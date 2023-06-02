<?php
    //open connection to mysql db
	require_once("connect.php");
   
    $aFName = $_GET["aFName"];
    $sql = "SELECT admin.aFName, patient.pFName
FROM admin
INNER JOIN junction ON admin.aFName = '{$aFName}'
INNER JOIN patient ON junction.pID = patient.pID;";
    $result = mysqli_query($con, $sql);
    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
    
    //close the db connection
    mysqli_close($con);

?>
