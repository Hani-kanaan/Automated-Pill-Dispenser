<?php
	session_start();
//	if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
	//	header("Location: login.php");
//	} else {
		require_once('connect.php');
		extract ($_GET);
		$dlist = implode("','", $aFName);
		$query = "DELETE FROM admin WHERE aFName IN ('$dlist');";
		mysqli_query($con, $query);
		mysqli_close($con);
	
	header("Location: superdeletedoctor.php");
//	}