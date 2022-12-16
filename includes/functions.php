<?php 

	// REDIRECT
	function reDirect($newLocation){
		header('Location:'.$newLocation);
		exit;	
	}

	// TIME
	function currentTime(){
		$time = time();
		return strftime('%d-%B-%Y %H: %M' ,$time);
	} 

	// LOGIN
	function loggedIn() {
		if (isset($_SESSION['username'])) {
			return TRUE;
		}
		else {
			$_SESSION['errorMessage'] = "Login Required!";
			reDirect('../login.php');
		}
	}

 ?>