<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
   
    if (isset($_GET['id'])) {
        $cid = $_GET['id'];
        $publisher = $_SESSION['username'];
        $query = mysqli_query($con, "UPDATE revcourse SET status='ON', approvedby='$publisher' WHERE id='$cid'");
        if ($query) {
            $_SESSION['successMessage'] = "Review Approved";
            reDirect('revcourse.php');
        }
        else {
            $_SESSION['errorMessage'] = "Something went wrong. Try Again!";
			reDirect('revcourse.php');
        }
    }
    
 ?>