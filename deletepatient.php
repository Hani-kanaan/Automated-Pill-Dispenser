<?php
	session_start();
//	if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
	//	header("Location: login.php");
//	} else {
		require_once('connect.php');
		extract ($_GET);
		$plist = implode("','", $pFName);
		$query = "DELETE FROM patient WHERE pFName IN ('$plist');";
		mysqli_query($con, $query);
		mysqli_close($con);
	
	header("Location: superdeletepatient.php");
//	}