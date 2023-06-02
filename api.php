<?php
	if (isset($_GET["aFName"])){
		extract($_GET);
		require_once("connect.php");
		$query = "SELECT patient.pFName, patient.pID
FROM patient
INNER JOIN junction
ON junction.pID = patient.pID
INNER JOIN admin
ON admin.adminID = junction.adminID
WHERE admin.aFName = '{$aFName}'";
  
		$result = mysqli_query($con, $query);
	
		if (!$result) {
			die(mysqli_error());
		}

	$emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
    
    //close the db connection
    mysqli_close($con);
	}
?>