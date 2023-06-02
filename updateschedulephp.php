<?php
session_start();
require_once('connect.php');
extract($_GET);
$aFName = $_SESSION["aFName"];
$plist = implode("','", $pFName);
print_r($_GET);
for ($j = 0; $j < count($pFName); $j++) {
    $pill = array(); // Initialize the $pill array inside the outer loop
/*
    for ($i = 1; $i <= 4; $i++) {
        $pill[$i] = $pill1[];
         
    }
    */
$query = "UPDATE `schedule` SET `pill1`='{$pill1[$j]}', `pill2`='{$pill2[$j]}', `pill3`='{$pill3[$j]}', `pill4`='{$pill4[$j]}' WHERE pFName = '{$pFName[$j]}';";
    mysqli_query($con, $query);
    echo $query;
   
}

mysqli_close($con);
 header("Location: timepicker.php?aFName=". $aFName );
?>

