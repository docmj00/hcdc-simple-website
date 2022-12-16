<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
	$_SESSION['URL'] = $_SERVER['PHP_SELF']; //ang function ani return to itself FILE TO SQL naka private para dli mo balhin sa lain file
	loggedIn();  //purpose ani login muna bago i view kung naka login na i de go na
 ?>

<?php
	$publisher = $_SESSION['username'];

	if (isset($_POST['psubmit'])) {
		$title = $_POST['ptitle'];
		$image = $_FILES['pimage']['name'];
		$category = $_POST['pcategory'];
		$upload = "../uploads/".basename($_FILES['pimage']['name']);
		$content = $_POST['cdescription'];

		// DATE naka auto na ni base sa current time
		$datetime = currentTime();

		if (empty($title)) {
			$_SESSION['errorMessage'] = "Enter a Title";
			reDirect('course.php');
		}
		elseif (strlen($title)<5) {
			$_SESSION['errorMessage'] = "Title should be greater than 5 characters";
			reDirect('course.php');
		}
		else {
            // ESCAPED STRINGS
            $title = mysqli_real_escape_string($con, $title);
            $subtitle = mysqli_real_escape_string($con, $subtitle);
            $content = mysqli_real_escape_string($con, $content);

            $post = mysqli_query($con, "INSERT INTO course VALUES ('', '$datetime', '$title', '$category', '$publisher', '$image', '$content')");

			if ($post) {
				$_SESSION['successMessage'] = "Added successfully";
                move_uploaded_file($_FILES['pimage']['tmp_name'], $upload);
			}
			else {
				$_SESSION['errorMessage'] = "Something went wrong. Try Again!";
				reDirect('course.php');
			}
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="author" content="BSIT STUDENT">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add New</title>

    <!-- design para mo gwapo ang website -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

</head>

<body>
    <!-- navigation bar nasa taas ng page o header -->
	<nav class="navbar navbar-expand-lg fixed-top bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">Holy Cross of Davao</a>
			<button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#nav-collapse">
				<span class="navbar-toggler-icon"></span>
			</button>
		    <!--responsive navigation bar-->
			<div class="collapse navbar-collapse" id="nav-collapse">	
				<ul class="navbar-nav ml-auto mr-auto">
					<li class="nav-item">
						<a class="nav-link text-secondary" href="../index.php">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="dashboard_course.php">Dashboard<span class="sr-only">(current)</span></a>
					</li>
					<!-- purpose ani akoa gi hide sa para ma trace nako kung unsay gipang hawa nako
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="categories.php">Categories<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="posts.php">Trend<span class="sr-only">(current)</span></a>
					</li>
					-->
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="review.php">Recommendation<span class="sr-only">(current)</span></a>
					</li>
				</ul>
				
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-secondary" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['username']; ?> </a>
				    	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="profile.php">Manage Profile</a>
							<a class="dropdown-item text-danger" href="logout.php">Logout</a>
				    	</div>
			  		</li>
				</ul>

			</div>
		</div>
	</nav>

	<header>
		<div class="container mg-top">
			<div class="pt-3 pb-1"><h2>What's new?</h2></div>
		</div>
	</header>
	<div class="container">
        
		<div class="mt-4 mx-sm-5">
            <?php 
			    //mao ni sya mo pop up na error message
				echo errorMessage();
				echo successMessage();
			 ?>
            
			<div class="card">
		  		<div class="card-header h4 text-primary">Add New</div>
		  		<div class="card-body mx-sm-5">
		    		
		    		<form action="course.php" method="POST" enctype="multipart/form-data">
					  	<h5 class="card-title h5">Title</h5>
					    <input type="text" class="form-control" name="ptitle" placeholder="Post Title">
				    
					    <div class="row">
					      	<div class="col-lg-8">
						      	<h5 class="card-title h5 mt-4">Image</h5>
						      	<div class="input-group">
								  	<div class="custom-file">
									    <input type="file" class="custom-file-input" name="pimage" id="postimage">
									    <label class="custom-file-label" for="postimage">Choose Cover Image</label>
								  	</div>
								</div>
					      	</div>

					      	<div class="col-lg-4">
							    <h5 class="card-title h5 mt-4">Category</h5>
							    <select class="custom-select w-100" name="pcategory">
							        <option selected>Select Category</option>
							    	
							    	<?php 
								    	$categories_name = mysqli_query($con, "SELECT name FROM categories");
								    	$i = 0;
								    	while($row = mysqli_fetch_assoc($categories_name)){
								    		echo '<option>'. $row['name'] .'</option>';
								    		$i++ ;
								    	}
							         ?>
							        
						      	</select>
					      	</div>
				      	</div>

				      	<h5 class="card-title h5 mt-4">Description</h5>
					    <textarea class="form-control" name="cdescription" rows="3" cols="20"></textarea>

					    <div class="row mt-4">
					    	<div class="col pr-2">
							<a href="dashboard_course.php" class="btn float-right btn-primary action-button btn-min-wt"> Dashboard</a>
					    	</div>
					    	<div class="col pl-2">
					    		<button type="submit" class="btn float-left btn-warning action-button btn-min-wt" name="psubmit">Submit</button>
					    	</div>
					    </div>
					</form>

		  		</div>
			</div>	
		</div>
	</div>

    <!-- FOOTER  wala ni sya naka fixed-->
	<footer class="page-footer bg-light mt-4">
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
          <a href="../index.php"> hcdc.com</a>
        </div>
    </footer>

    <!--Design para mo gwapo ang website-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>