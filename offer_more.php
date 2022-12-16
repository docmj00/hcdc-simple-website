<?php 
	require 'config/config.php';		
	require 'includes/functions.php';	
	require 'includes/sessions.php';	
 ?>

<?php
	$postid = $_GET['id'];     
	
	//SUBMITTING REVIEW
	if (isset($_POST['comnt'])) {
		$name = $_POST['comntname'];
		$email = $_POST['comntemail'];
		$reviews = $_POST['reviews'];
		
		// DATE
		$datetime = currentTime();

		// VALIDATION
		if (empty($name)) {
			$_SESSION['errorMessage'] = "Enter your Name";
			reDirect('offer_more.php?id='.$postid);
		}
		elseif (empty($email)) {
			$_SESSION['errorMessage'] = "Enter your Email";
			reDirect('offer_more.php?id='.$postid);
		}
		elseif (empty($reviews)) {
			$_SESSION['errorMessage'] = "Share your thoughts on the course";
			reDirect('offer_more.php?id='.$postid);
		}
		elseif (strlen($reviews)>299) {
			$_SESSION['errorMessage'] = "Reviews should be less than 300 characters";
			reDirect('offer_more.php?id='.$postid);
		}
		else {
			$query = mysqli_query($con, "INSERT INTO revcourse VALUES ('', '$datetime', '$name', '$email', '$reviews', 'None', 'OFF', '$postid')");
			if ($query) {
				$_SESSION['successMessage'] = "Submitted successfully";
			}
			else {
				$_SESSION['errorMessage'] = "Something went wrong. Try Again!";
				reDirect('offer_more.php?id='.$postid);
			}
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="BSIT STUDENT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Course | full</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="undefined" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
	<!-- navigation bar nasa taas ng page -->
	<nav class="navbar navbar-expand-lg sticky-top bg-light">
		<div class="container">
			<a class="navbar-brand" href="offer.php"><strong>Holy Cross of Davao City</strong></a>
			<button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#nav-collapse">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="nav-collapse">	
				<ul class="navbar-nav ml-auto mr-auto">
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="index.php">Home<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="offer.php">Course<span class="sr-only">(current)</span></a>
					</li>
					<!--
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="#">Features<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="#">About<span class="sr-only">(current)</span></a>
					</li>
					-->
				</ul>
				<ul class="navbar-nav">
					<form class="form-inline my-lg-0 mt-2" action="offer.php">
		      			<span class="form-group"><input class="form-control mr-sm-2 shadow-none" type="search" placeholder="Search" name="search" aria-label="Search"></span>
		      			<span class="form-group"><button class="btn btn-outline-primary mx-2 mx-sm-0 shadow-none" name="searchbutton"> <img class="pb-1" style="max-width: 100%; max-height: 20px; fill: white;" src="assets/icons/search.svg"> </button></span>
		    		</form>
				</ul>

			</div>
		</div>
	</nav>
	
	<div class="container">
		<!-- <div class="row"> -->
			<!-- <div class="col-sm-8 mt-1"> -->
				<?php
					//SEARCH FIELD
					if (isset($_GET['searchbutton'])) {
						$search = $_GET['search'];
						$query = mysqli_query($con, "SELECT * FROM course WHERE title LIKE '%$search%' OR category LIKE '%$search%' OR content LIKE '%$search%'");
					}
					else {

						if (!isset($postid)) {
							$_SESSION['errorMessage'] = 'Bad URL Request!';
							reDirect('offer.php');
						}

						//LOADING THE FULL POST
						$query = mysqli_query($con, "SELECT * FROM course WHERE id='$postid'");
						$row = mysqli_fetch_array($query);
					}
						
				?>

				<div class="card-body">
					<h1 class="py-1"> <?php echo htmlentities($row['title']) ?> </h1>
					<div class="position-relative">
							<img class="rounded mt-3" src="uploads/<?php echo $row['image']; ?>" width="100%">
					</div>
					<small class="text-muted"><?php echo htmlentities($row['datetime']) ?></small>

					<div class="btn btn-sm btn-light mt-1 float-right">Reviews: 
					<span class="badge badge-primary">
						<?php
							//SHOWING COUNTS ON EACH POSTS
							$id = $row['id'];
							$count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM revcourse WHERE postid='$id' AND status='ON'"));
							if ($count>0) {
								echo '<span class="badge badge-primary">'.$count.'</span>';
							}
							else { echo '0'; }
						?>
					</span>
					</div>
					<hr>

					<div class="mb-4">
						<?php echo ($row['content']); ?>
					</div>	
				</div>

				<!-- COMMENT -->
				<div>	
					<div class="card mx-auto">
						<h5 class="card-header text-primary">Reviews</h5>
						<div>
							<?php 
								//APPROVED REVIEW
								$query = mysqli_query($con, "SELECT * FROM revcourse WHERE postid='$postid' AND status='ON'");
								$count = mysqli_num_rows($query);
								if ($count>0) {
									$i = 0;
									while($row = mysqli_fetch_assoc($query)) {
											
							?>
									
							<div class="card-body pb-0">
								<div class="media">
									<img class="align-self-start" style="max-width: 100px; margin-right:15px;" src="assets/images/default.png" alt="Reviewer">
									<div class="media-body">
										<h4 class="lead mb-1"> <?php echo $row['name']; ?> </h4>
										<p class="small"> <?php echo $row['datetime']; ?> </p>
										<p> <?php echo $row['reviews']; ?> </p>
										<hr>
									</div>
								</div>
							</div>

							<?php
								//END OF WHILE LOOP
									$i++ ;
								}
							}
							else {
								echo '<h5 class="lead text-warning mt-4 mx-3 pl-1">Be the first to reviews on this post</span>';
							}
							 ?>
						</div>

						<hr>
						<div class="card-body mx-sm-4">
							<?php 
								echo errorMessage();
								echo successMessage();
							?>

							<!-- COMMENT SECTION -->
							<form action="offer_more.php?id=<?php echo $postid; ?>" method="POST">
								<div class="form-row">
									<div class="col-sm-6 mb-2">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><img class="c-icon" src="assets/icons/username.svg"></span>
											</div>
											<input type="text" name="comntname" class="form-control" placeholder="Name">
										</div>
									</div>

									<div class="col-sm-6 mb-2">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><img class="c-icon" src="assets/icons/mail.svg"></span>
											</div>
											<input type="email" name="comntemail" class="form-control" placeholder="Email">
										</div>
									</div>

									<div class="form-group col-sm-12">
										<textarea class="form-control" name="reviews"></textarea>
									</div>
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-sm btn-primary" name="comnt">Submit</button>
								</div>
							</form>	
						</div>
					</div>
				</div>
			<!-- </div> -->
		<!-- </div> -->
	</div>

	<!-- FOOTER -->
	<footer class="page-footer font-small mdb-color pt-4 mt-4 border-top border-primary">
		<div class="container text-center text-md-left">
			<div class="row text-center text-md-left mt-3 pb-3">
				<div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
					<h6 class="text-uppercase mb-4 font-weight-bold">HCDC WEBSITE</h6>
					<p>The Holy Cross of Davao College is a private and research Catholic college institution founded by the Religious of the Virgin Mary Sisters in 1951 and maintained by the Foreign Mission Society of Quebec in 1956.t</p>
				</div>
				<hr class="w-100 clearfix d-md-none">

				<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
					<h6 class="text-uppercase mb-4 font-weight-bold">Join Us</h6>
					<p><a href="login.php">Dashboard</a></p>
					<p><a href="#">Contact Us</a></p>
					<p><a href="#">Learn More</a></p>
				</div>
				<hr class="w-100 clearfix d-md-none">

				<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
					<h6 class="text-uppercase mb-4 font-weight-bold">Links</h6>
					<p><a href="offer_more.php">Top</a></p>
					<p><a href="#">Features</a></p>
					<p><a href="#">About Us</a></p>
				</div>
				<hr class="w-100 clearfix d-md-none">

				<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
					<h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
					<p>Santa Ana Avenue Davao City, Philippines</p>
					<p>hcdc@info.com</p>
					<p></p>
				</div>
			</div>

			<hr>
			<div class="row d-flex">
				<div class="col-md-7 col-lg-8">
					<p class="text-center text-md-left">© 2022 Copyright:
						<a href="offer.php"><strong> hcdc.com</strong></a>
					</p>
				</div>

				<div class="col-md-5 col-lg-4 ml-lg-0">
					<div class="text-center text-md-right">
						<ul class="list-unstyled list-inline">
							<li class="list-inline-item">
								<a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fab fa-facebook-f fa-lg"></i></a>
							</li>
							<li class="list-inline-item">
								<a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fab fa-twitter fa-lg"></i></a>
							</li>
							<li class="list-inline-item">
								<a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fab fa-google-plus-g fa-lg"></i></a>
							</li>
							<li class="list-inline-item">
								<a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fab fa-linkedin-in fa-lg"></i></a>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>