<?php

	if (isset($_GET["aFName"]) & isset($_GET["passwd"])){
		extract($_GET);
		require_once("connect.php");
		
		setcookie("loggedin", "true", 30*60); 
		$query = "INSERT INTO admin VALUES ('{$aFName}','0' , '{$passwd}')";
		$result = mysqli_query($con, $query);
	
	}
?>