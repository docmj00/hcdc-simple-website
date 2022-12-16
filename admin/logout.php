<?php 
	require '../config/config.php';
	require '../includes/functions.php';
	require '../includes/sessions.php';
   
    $_SESSION['name'] = NULL;
    $_SESSION['username'] = NULL;
    session_destroy();
    reDirect('../login.php');

 ?>