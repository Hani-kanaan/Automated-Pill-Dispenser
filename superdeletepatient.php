<?php
	session_start();
//	if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
	
//	} else {
		require_once('connect.php');
//	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>delete patients</title>
		<meta charset="UTF-8">
		
		<script>
			function deletepatients(){
				if (confirm("Are you sure?")) {
					selCourses = document.getElementsByName("courses");
					str="";
					for (i = 0; i < selCourses.length; i++) {
						if (selCourses[i].checked) {
							str += "pFName[]="+selCourses[i].value + "&";
								console.log(str);
						}
					}
	location.href = "deletepatient.php?" + str;
				
				}
			}
		</script>
	</head>

	<body>
	<table border="1">
		<tr><th>patient name</th><th>patient ID</th><th>Delete</th></tr>
<?php
		$query = "SELECT * FROM patient;";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($result)) {
?>
		<tr>
			<td><?=$row['pFName']?></td>
			<td><?=$row['pID']?></td>
			
			<td><input type="checkbox" name="courses"value = "<?=$row['pFName']?>" /></td></tr>
<?php
		}
		mysqli_close($con);
?>
	</table>
	<br />
	<input type="button" value="Delete Selected" onclick="deletepatients();" />
	<br />

	<br />

	</body>
</html>