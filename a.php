<?php
	require_once("connect.php");
$json =file_get_contents("php://input");
echo gettype($json);
$data = json_decode($json, true);
echo gettype($data);
//var_dump(json_decode($json));


/*echo count($patients);
for ($i=0; $i <count($patients); $i++) {

$patient_data = explode("/", $patients[$i]);
$empty = $patient_data[0];
$name = $patient_data[1];
$pill2 = $patient_data[2];
$pill3 = $patient_data[2];
$pill4 = $patient_data[3];
$pill5 = $patient_data[4];
}*/

// Do something with patient data here

		//$result = mysqli_query($con, $query);
	
die;