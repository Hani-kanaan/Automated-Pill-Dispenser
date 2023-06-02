<?php
require_once("connect.php");
$hour = $_GET["hour"];
$min = $_GET["min"];
$query = "UPDATE schedule
SET hour = 10, min = 30
WHERE pFName IN (
SELECT patient.pFName
FROM patient
JOIN junction ON patient.pID = junction.pID
JOIN admin ON junction.adminID = admin.adminID
WHERE admin.aFName = 'user1'
)" ;
$result = mysqli_query($con, $query);
	if (!$result) {
			die(mysqli_error());
		}
	
?>