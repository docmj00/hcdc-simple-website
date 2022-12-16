<?php 
	session_start();

	// ERROR MESSAGE
	function errorMessage() {
		if (isset($_SESSION['errorMessage'])) {
			$message = '<div class="alert alert-danger">';
			$message .= htmlentities($_SESSION['errorMessage']);
			$message .= '</div>';
			$_SESSION['errorMessage'] = NULL;
			return $message;
		}
	}

	// SUCCESS MESSAGE
	function successMessage() {
		if (isset($_SESSION['successMessage'])) {
			$message = '<div class="alert alert-success">';
			$message .= htmlentities($_SESSION['successMessage']);
			$message .= '</div>';
			$_SESSION['successMessage'] = NULL;
			return $message;
		}
	}

 ?>