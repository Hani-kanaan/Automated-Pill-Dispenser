<?php
	if (isset($_GET["sname"]) && isset($_GET["spass"])){
		extract($_GET);
		require_once("connect.php");

		
		$query = "INSERT INTO super VALUES ('{$sname}','{$spass}', null)";
		
		$result = mysqli_query($con, $query);
		
	}




