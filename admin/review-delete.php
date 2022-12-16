<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
   
    if (isset($_GET['id'])) {
        $cid = $_GET['id'];
        $query = mysqli_query($con, "DELETE FROM review WHERE id='$cid'");
        if ($query) {
            $_SESSION['successMessage'] = "Review Deleted";
            reDirect('review.php');
        }
        else {
            $_SESSION['errorMessage'] = "Something went wrong. Try Again!";
			reDirect('review.php');
        }
    }
    
 ?>