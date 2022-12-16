<?php 
	require 'config/config.php';	
	require 'includes/functions.php';	
	require 'includes/sessions.php';	
 ?>

<?php
    if (isset($_SESSION['username'])) {
        reDirect('admin/dashboard.php');
    }

    if (isset($_POST['alogin'])) {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        if (empty($username)||empty($pass)) {
            $_SESSION['errorMessage'] = "Enter all the fields";
			reDirect('login.php');
        }
        else {
            $enc_pass = md5($pass);
            $query = mysqli_query($con, "SELECT * FROM admins WHERE username='$username' AND password='$enc_pass'");
            $count = mysqli_num_rows($query);
            if ($count==1) {
                $row = mysqli_fetch_array($query);

                //admin login
                $_SESSION['id'] = $row['id'];
                $_SESSION['admin'] = $row['name'];
                $_SESSION['username'] = $row['username'];

                if (isset($_SESSION['URL'])) {
                    reDirect($_SESSION['URL'] );
                }
                else {
                    reDirect('admin/dashboard.php');
                }
            }
            else {
                $_SESSION['errorMessage'] = "Incorrect Username or Password";
			    reDirect('login.php');
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
	<title>HCDC | login</title>

	<!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
    <div class="wrapper">

        <div class="row align-items-center h-100 m-0" style="background-image: url('assets/images/hcdc.jpg'); background-size:cover; height: 100%; width: 100%;">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg sticky-top bg-light pr-0">
            <a class="navbar-brand ml-4" href="index.php"><strong>Holy Cross of Davao City</strong></a>
        </nav>
        <!-- NAVBAR END -->

            <div class="col-sm-4 offset-sm-8 d-flex justify-content-center mt-3" style="height: 90vh;">
                <div class="w-75 mt-4">
                <?php 
                    echo errorMessage();
                    echo successMessage();
                ?>
					<h2 class="mt-4">Welcome!</h2>
                    <form action="login.php" method="POST">
                        <input type="text" class="form-control mt-4" name="username"  placeholder="Username" required>
                        <input type="password" class="form-control mt-3" name="password" placeholder="Password" required>
                        <button type="submit" class="btn pull-left btn-primary action-button mt-4" name="alogin">Login</button>
                    </form>
                    
                </div>
            </div>

        </div>

    <!-- FOOTER -->
	<footer class="page-footer fixed-bottom bg-light">
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
          <a href="index.php"> hcdc.com</a>
        </div>
    </footer>
    <!-- FOOTER END -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>