<?php
require_once("connect.php");
if ($con->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$aFName = $_GET["aFName"];
$pFName = $_GET["pFName"];
//$pID = $_GET["pID"];

$sql = "
    INSERT INTO patient VALUES ('{$pFName}' , NULL);";
   $sql.= "INSERT INTO schedule (pFName,pID ,pill1 , pill2 , pill3 ,pill4)
    SELECT pat.pFName, pat.pID, '9' , '8','1' ,'2' 
    FROM patient pat
    WHERE pat.pFName = '{$pFName}';
";
$sql .= "INSERT INTO junction (junctionID ,adminID, pID) VALUES (NULL ,(SELECT adminID FROM admin WHERE aFName = '{$aFName}'), (SELECT pID FROM patient WHERE pFName = '{$pFName}'));";

if ($con->multi_query($sql) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $con->error;
}

//$con->close();
?>