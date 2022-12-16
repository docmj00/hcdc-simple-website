<?php 

	$timezone = date_default_timezone_set("Asia/Manila");

	// DATA SOURCE NETWORK (DATABASE CONNECTION)
	$con = mysqli_connect('localhost', 'root', '', 'hcdc');
	if(mysqli_errno($con)){
		echo "Failed to connect database: " . mysqli_errno($con);
	}

 ?>