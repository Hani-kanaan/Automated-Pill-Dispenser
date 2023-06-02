<?php
    //open connection to mysql db
	require_once("connect.php");
   
    $pFName = $_GET["pFName"];
    $sql = "select * from schedule WHERE pFName = '{$pFName}'";
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
