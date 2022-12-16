<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
	loggedIn();
 ?>

 <?php
 	$id = $_GET['id'];
	$query = mysqli_query($con, "SELECT * FROM posts WHERE id='$id'");
	$row = mysqli_fetch_array($query);

	$ftitle = $row['title'];
	$fcategory = $row['category'];
	$fimage = $row['image'];
	$fcontent = $row['content'];
 ?>

<?php
	if (isset($_POST['pdelete'])) {
		$query = mysqli_query($con, "DELETE FROM posts WHERE id='$id'");

		if ($query) {
			$uploaded_image_delete = '../uploads/{$fimage}';
			unlink($uploaded_image_delete);
			$_SESSION['successMessage'] = "Post deleted successfully";
		}
		else {
			$_SESSION['errorMessage'] = "Something went wrong. Try Again!";
			reDirect('deletepost.php?id=$id');
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
	<title>Delete</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

</head>

<body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg fixed-top bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">Holy Cross of Davao</a>
			<button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#nav-collapse">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="nav-collapse">	
				<ul class="navbar-nav ml-auto mr-auto">
					<li class="nav-item">
						<a class="nav-link text-secondary" href="../index.php">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-secondary" href="dashboard.php">Dashboard<span class="sr-only">(current)</span></a>
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
							<!--
							<a class="dropdown-item" href="admins.php">Manage Access</a>
							-->
							<a class="dropdown-item text-danger" href="logout.php">Logout</a>
				    	</div>
			  		</li>
				</ul>

			</div>
		</div>
	</nav>
	<!-- NAVBAR END -->

    <!-- HEADER -->
    <header>
    <div class="container mg-top">
        <div class="pt-3 pb-1"><h2>Delete</h2></div>
    </div>
	</header>
	<!-- HEADER END -->

	<!-- MAIN AREA -->
	<div class="container">

		<div class="mt-4 mx-sm-5">
			<?php 
				echo errorMessage();
				echo successMessage();
			?>

			<div class="card">
		  		<div class="card-header h4 text-primary">Delete Post</div>
		  		<div class="card-body mx-sm-5">
		    		
		    		<form action="deletepost.php?id=<?php echo $id; ?>" method="POST">
					  	<h5 class="card-title h5">Post Name</h5>
					    <input disabled="y" type="text" class="form-control" placeholder="Post Title" value="<?php echo $ftitle; ?>">
					    <h5 class="card-title h5 mt-4">Sub Heading</h5>
					    <input disabled="y" type="text" class="form-control" placeholder="Sub Title">
				    
				    	<h5 class="card-title h5 mt-4">Cover Image</h5>
				    	<img class="rounded" src="../uploads/<?php echo $fimage; ?>" max-height="500px" width="100%">
					    <div class="row">
					      	<div class="col-lg-8">
						      	<h5 class="card-title h5 mt-4">Post Image</h5>
						      	<div class="input-group">
								  	<div class="custom-file">
									    <input disabled="y" type="file" class="custom-file-input" id="postimage">
									    <label class="custom-file-label" for="postimage">Choose Cover Image</label>
								  	</div>
								</div>
					      	</div>

					      	<div class="col-lg-4">
							    <h5 class="card-title h5 mt-4">Category</h5>
							    <select disabled="y" class="custom-select w-100">
							        <option selected><?php echo $fcategory; ?></option>
						      	</select>
					      	</div>
				      	</div>

				      	<h5 class="card-title h5 mt-4">Post Description</h5>
					    <textarea disabled="y" class="form-control" rows="3" cols="20">
					    	 <?php echo $fcontent; ?>
					    </textarea>

					    <!-- BUTTONS -->
					    <div class="row mt-4">
					    	<div class="col pr-2">
								<a href="dashboard.php" class="btn float-right btn-primary action-button btn-min-wt">Dashboard</a>
					    	</div>
					    	<div class="col pl-2">
					    		<button type="submit" class="btn float-left btn-danger action-button btn-min-wt" name="pdelete">Delete</button>
					    	</div>
					    </div>
					</form>

		  		</div>
			</div>	
		</div>
	</div>
	<!-- MAIN AREA END -->


	<footer class="page-footer bg-light mt-4">
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
          <a href="../index.php"> hcdc.com</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>