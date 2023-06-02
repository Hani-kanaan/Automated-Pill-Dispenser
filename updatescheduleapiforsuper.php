<?php
session_start();
	require_once('connect.php');
		extract ($_GET);
		$plist = implode("','", $pFName);
			$pFName = $_GET['pFName'];
			
		for($j=0; $j<count($pFName); $j++){
	
		    for($i=1; $i<=4; $i++) {
  
    $pill[$i] = $_GET["pill$i"];

    
    

}

	$query = "UPDATE `schedule` SET`pill1`='{$pill1}',`pill2`='{$pill2}',`pill3`='{$pill3}',`pill4`='{$pill4}' WHERE pFName = '{$pFName[$j]}';";
echo $query;
		mysqli_query($con, $query);
		}
	
		mysqli_close($con);
 //header("Location: superupdateschedule.php" );

