<?php
session_start();
	if (isset($_GET["pname"]) && isset($_GET["pID"])){
		extract($_GET);
		require_once("connect.php");
	
		
		$query = "INSERT INTO patient VALUES ('{$pname}','{$pID}');" ;
		
		$result = mysqli_query($con, $query);
		$query2 = "INSERT INTO junction VALUES ('','{$_SESSION["adminID"]}','{$pID}')";
		$result = mysqli_query($con, $query2);
		/*if (!$result) {
			die(mysqli_error());
		}*/

		/*if (mysqli_num_rows($result) !=0) {
			$row = mysqli_fetch_assoc($result);
			
			if ($location == $row['location']) {
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["location"] = $row["location"];
				header("Location:http://localhost/11930070/seats.php");
			}
		}*/
	}
?>

<!DOCTYPE html>
<html lang="en" >
<head></head>
<body><style>

</style>

<form  onsubmit="return validateForm()">

  <div class="form-field">
    <input type="input" placeholder="patient name" name = "pname" required/>
  </div>
  
  <div class="form-field">
    <input type="input" placeholder="ID" name="pID" required/>                         
</div>

  
  
  <div class="form-field">
    <button class="btn" type="submit"> add patient</button>

  </div>
</form>



<label for="appt">Select a time:</label>
<input type="time" id="appt" name="appt"> 
  

<?php
		require_once("connect.php");
		$query3 = "SELECT * FROM junction WHERE adminID = '{$_SESSION["adminID"]}' ;";
		$result = mysqli_query($con, $query3);
		while ($row = mysqli_fetch_assoc($result)) {
?>
		<tr>
			<td><?=$row['junctionID']?></td>
			<td><?=$row['adminID']?></td>
			<td><?=$row['pID']?></td>
			<td><input type="checkbox" name="courses" value="<?=$row['junctionID']?>" /></td></tr>
<?php
		}
		mysqli_close($con);
?>
  
</body>
</html>
</body>