<?php 
	require 'config/config.php';	
	require 'includes/functions.php';	
	require 'includes/sessions.php';	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="BSIT STUDENT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Course - Welcome to HCDC</title>

	<!-- design sa pages WITH BOOTSTRAP V4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="undefined" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
	<!-- navigation -->
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
		<div class="row">
			<div class="col-sm-8 mt-1">
			    <!-- mo display error/sucess -->
                <div class="mt-1"><?php echo errorMessage(); ?></div>
                <!-- search field nasa navigation bar -->
                <?php 
                    if (isset($_GET['searchbutton'])) {
      				    $search = $_GET['search'];
      				    $query = mysqli_query($con, "SELECT * FROM course WHERE title LIKE '%$search%' OR category LIKE '%$search%' OR content LIKE '%$search%'");
                    }
					//number sa page
				    elseif (isset($_GET['page'])) {
						$page = $_GET['page'];
						if ($page<1) {
							$page = 1;
						}
							$blogs = ($page*4)-4;
							$query = mysqli_query($con, "SELECT * FROM course ORDER BY id DESC LIMIT $blogs,4");
					}

					elseif (isset($_GET['category'])) {
						$category = $_GET['category'];
						$count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM course WHERE category='$category' ORDER BY id DESC"));
						if ($count==0) {
							$_SESSION['errorMessage'] = "Sorry, there isn't any course regarding that category";
							reDirect('offer.php');
						}
						else {
							$query = mysqli_query($con, "SELECT * FROM course WHERE category='$category' ORDER BY id DESC");
						}
					}
			      	else {
						$query = mysqli_query($con, "SELECT * FROM course ORDER BY id DESC LIMIT 0, 4");
						$page = 1;
					}
						
				    while($row = mysqli_fetch_assoc($query)){
				
			    ?>

                <div class="card my-3">
			     	<div class="card-body">
			     		<h1> <?php echo $row['title']; ?> </h1>
						<div class="position-relative">
						<!-- remove if you want to add by category
							<h5 class="tag"><span class="badge badge-warning p-2"> <?php echo $row['category'] ?> </span></h5>
						-->
							<img class="rounded mt-1" src="uploads/<?php echo $row['image']; ?>" width="100%">
						</div>
						<small class="text-muted"><?php echo $row['datetime']; ?></small>
						<small class="float-right mt-1">Review: 
						<?php
						//display kung pila kabuok pages available
                            $id = $row['id'];
                            $count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM revcourse WHERE postid='$id' AND status='ON'"));
                            if ($count>0) {
                                echo '<span class="badge badge-primary">'.$count.'</span>';
                            }
                            else { echo '0'; }
                        ?>
						</small>
						<hr>

						<p class="card-text">
							<?php 
                                if (strlen($row['content'])>500) {
                                    $row['content'] = substr($row['content'], 0,278).'....';
                                }
                            ?>
							<?php echo ($row['content']) ?>
                        </p>
						<a href="offer_more.php?id=<?php echo $row['id']; ?>" class="pull-right">
							<div class="text-right"><span class="btn btn-sm btn-primary">Read More</span></div>
						</a>
			     	</div>
			    </div>

                <?php
                	}
				?>
                <nav>
					<ul class="pagination justify-content-end">
						<?php
							if (isset($page)) {
								if ($page>1) {
								
						?>
						<li class="page-item">
							<a class="page-link" href="offer.php?page=<?php echo $page-1; ?>" aria-label="Next">
								<span aria-hidden="true">&laquo;</span>
								<span class="sr-only">Next</span>
							</a>
						</li>
						<?php
								}
							}
						?>

						<?php
						$count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM course"));
						$paginate = ceil($count/5);
						for ($i=1; $i<=$paginate; $i++) { 
							if (isset($page)) {
								if ($i==$page) {
								
						?>

						<li class="page-item active">
							<a class="page-link" href="offer.php?page=<?php echo $i; ?>">
								<?php echo $i; ?>
							</a>
						</li>
					
						<?php
									}
									else {
						?>
									<li class="page-item">
										<a class="page-link" href="offer.php?page=<?php echo $i; ?>">
											<?php echo $i; ?>
										</a>
									</li>
						<?php
									}
								}
							}
						?>
						<?php
							if (isset($page)&&!empty($page)) {
								if ($page+1 <= $paginate) {
								
						?>
						<li class="page-item">
						<a class="page-link" href="offer.php?page=<?php echo $page+1; ?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
							<span class="sr-only">Next</span>
						</a>
						</li>
						<?php
								}
							}
						?>
					</ul>
				</nav>

            </div>
			<!-- SIDE COLUMN -->
            <div class="col-sm-4 mt-1">	
            	<div class="mt-1">
					<h4 class="mt-3">Popular course</h4>
					<div class="card my-3">
						<div class="card-body pb-0">
							<?php
								$query = mysqli_query($con, "SELECT * FROM course WHERE id IN (SELECT postid FROM revcourse GROUP BY postid ORDER BY COUNT(reviews) DESC) ORDER BY id LIMIT 0, 6");
								while($row = mysqli_fetch_assoc($query)){
							?>
							
							<div>
								<a href="offer_more.php?id=<?php echo $row['id']?>" style="text-decoration: none;">
									<img class="rounded" src="uploads/<?php echo $row['image']; ?>" width="100%">
										<div class="text-secondary mt-2"> <?php echo $row['title']; ?></div>
								</a>
							</div>
							<hr>

							<?php
								}
							?>
						</div>
					</div>
					<div class="card my-3">
						<div class="card-header">
							<h5 class="text-warning">Browse by Categories</h5>
						</div>
						<div class="card-body">
							<?php
								$query = mysqli_query($con, "SELECT * FROM catcourse ORDER BY id DESC");
								while($row = mysqli_fetch_assoc($query)){
							?>
							<a href="offer.php?category=<?php echo ($row['name']); ?>" style="text-decoration: none; color:#000;"> <div class="my-1"> <?php echo ($row['name']); ?> </div> </a>
							<?php
								}
							?>
						</div>
					</div>
					<div class="card my-3">
						<div class="card-header">
							<h5 class="text-primary">Recent course</h5>
						</div>
						<div class="card-body pb-0">
							<?php
								$query = mysqli_query($con, "SELECT * FROM course ORDER BY id DESC LIMIT 0, 6");
								while($row = mysqli_fetch_assoc($query)){
							?>
							
							<div class="media">
									<img src="uploads/<?php echo $row['image']; ?>" class="rounded d-block img-fluid align-self-start" width="100">
									<a href="offer_more.php?id=<?php echo $row['id']?>" style="text-decoration: none;">
									<div class="media-body ml-3">
										<div class="text-secondary"> <?php echo $row['title']; ?></div>
									</div>
									</a>
							</div>
							<hr>

							<?php
								}
							?>
						</div>
					</div>

				</div>
			</div>

        </div>
	</div>
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
					<p><a href="offer.php">Top</a></p>
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
						<a href="index.php"><strong> hcdc.com</strong></a>
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