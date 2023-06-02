<?php
	
	$dbuser = "id20711878_root";
	$dbpasswd = "]0^UA=C(gYredv4r";
	$dbserver ="localhost";
	$dbdb = "id20711878_senior";
	
	
	$con = mysqli_connect($dbserver, $dbuser, $dbpasswd, $dbdb);
	
	if (mysqli_connect_errno()) { // returns an integer
		die (mysqli_connect_error()); // returns a string
	}