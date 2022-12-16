<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
    $_SESSION['URL'] = $_SERVER['PHP_SELF']; //ang function ani return to itself FILE TO SQL naka private para dli mo balhin sa lain file
    loggedIn();   //purpose ani login muna bago i view kung naka login na i de go na
 ?>

<?php
	$publisher = $_SESSION['username'];

	if (isset($_POST['aregister'])) {
        $aname = $_POST['aname'];
        $username = $_POST['username'];
        $password = $_POST['apassword'];
        $cpass = $_POST['cpassword'];
		
		// DATE naka auto na ni base sa current time
		$datetime = currentTime();

        //VALIDATION
		if (empty($aname)||empty($username)||empty($password)||empty($cpass)) {
			$_SESSION['errorMessage'] = "All fields must be entered";
			reDirect('admins.php');
		}
		elseif (strlen($password)<4) {
			$_SESSION['errorMessage'] = "Password should be greater than 4 characters";
			reDirect('admins.php');
		}
		elseif ($password !== $cpass) {
			$_SESSION['errorMessage'] = "Passwords doesn't match";
			reDirect('admins.php');
        }
        
        //EXISTING USERNAMES VALIDATE
        elseif (isset($username)) {
            $query = mysqli_query($con, "SELECT username FROM admins WHERE username='$username'");
            $count = mysqli_num_rows($query);
            if($count>0){
			    $_SESSION['errorMessage'] = "Username already exist!";
                reDirect('admins.php');
            }
            else {
                $enc_pass = md5($password);
                $publish = mysqli_query($con, "INSERT INTO admins VALUES ('', '$datetime', '$username', '$enc_pass', '$aname', '', '', 'default.png', '$publisher')");
                if ($publish) {
                    $_SESSION['successMessage'] = "Admin registered successfully";
                }
                else {
                    $_SESSION['errorMessage'] = "Something went wrong. Try Again!";
                    reDirect('admins.php');
                }
		    }
		}
		else {
            $_SESSION['errorMessage'] = "Something went wrong. Try Again!";
            reDirect('admins.php');
        }
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
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
							<a class="dropdown-item" href="dashboard_course.php">Dashboard Course</a>
							<a class="dropdown-item text-danger" href="logout.php">Logout</a>
				    	</div>
			  		</li>
				</ul>

			</div>
		</div>
	</nav>

	<header>
		<div class="container mg-top">
			<div class="pt-3 pb-1"><h2>Admin | New</h2></div>
		</div>
	</header>


        <div class="container">

            <div class="mt-4 mx-sm-5">
                <?php 
                    echo errorMessage();
                    echo successMessage();
                ?>
                <div class="card">
                    <div class="card-header h4 text-primary">Add New Admin</div>
                    <div class="card-body mx-sm-5">
                        
                        <form action="admins.php" method="POST">
                            <h5 class="card-title h5">Admin Name</h5>
                            <input type="text" class="form-control" name="aname" id="aname" placeholder="Name">
                            <h5 class="card-title h5 mt-3">Username</h5>
                            <input type="text" class="form-control" name="username" id="username" placeholder="User Name">
                            <div class="row">
                            <div class="col-sm-6">
                            <h5 class="card-title h5 mt-3">Password</h5>
                            <input type="password" class="form-control" name="apassword" id="apassword" placeholder="Password">
                            </div>
                            <div class="col-sm-6">
                            <h5 class="card-title h5 mt-3">Confirm Password</h5>
                            <input type="password" class="form-control" name="cpassword" placeholder="Retype Password">
                            </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col pr-2">
								    <a href="dashboard.php" class="btn float-right btn-primary action-button btn-min-wt"> Dashboard</a>
                                </div>
                                <div class="col pl-2">
                                    <button type="submit" class="btn float-left btn-warning action-button btn-min-wt" name="aregister">Register</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>	
            </div>
        </div>

    <!-- FOOTER -->
	<footer class="page-footer bg-light">
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
          <a href="index.php"> hcdc.com</a>
        </div>
    </footer>
    <!--Design para mo gwapo ang website-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>