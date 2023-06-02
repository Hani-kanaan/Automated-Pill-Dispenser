<?php
session_start();
	$htmlContent = file_get_contents("https://automated-pill-dispenser.000webhostapp.com/getschedule.php?pFName=patient1&aFName=user1");
		
	$DOM = new DOMDocument();
	@$DOM->loadHTML($htmlContent);
	
	$Header = $DOM->getElementsByTagName('th');
	$Detail = $DOM->getElementsByTagName('td');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i+1 ;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j +1 : $j;
	}
	print_r($aDataTableDetailHTML); 
	$data = $aDataTableDetailHTML;
	
	require_once("connect.php");

	for($i=0; $i<count($data); $i++) {
// Extract patient name from the first element of each sub-array
$pFName = $data[$i][0];
$pill1 = $data[$i][1];
$pill2 = $data[$i][2];
$pill3 = $data[$i][3];
$pill4 = $data[$i][4];
echo $pFName;
 $query =  "UPDATE schedule
SET pill1 = '{$pill1}', pill2 ='{$pill2}', pill3 = '{$pill3}', pill4 = '{$pill4}'
WHERE pFName = '{$pFName}'"; 
	$result = mysqli_query($con, $query);
		if (!$result) {
			die(mysqli_error());
		}
	}
?>