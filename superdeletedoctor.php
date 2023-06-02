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
		<title> delete doctor</title>
		<meta charset="UTF-8">
		
		<script>
			function deletedc(){
				if (confirm("Are you sure?")) {
					selCourses = document.getElementsByName("courses");
					str="";
					for (i = 0; i < selCourses.length; i++) {
						if (selCourses[i].checked) {
							str += "aFName[]="+selCourses[i].value + "&";
								console.log(str);
						}
					}
	location.href = "deletedoctor.php?" + str;
				
				}
			}
		</script>
	</head>

	<body>
	<table border="1">
		<tr><th>doctor name</th><th>doctor ID</th><th>Delete</th></tr>
<?php
		$query = "SELECT * FROM admin;";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($result)) {
?>
		<tr>
			<td><?=$row['aFName']?></td>
			<td><?=$row['adminID']?></td>
			
			<td><input type="checkbox" name="courses"value = "<?=$row['aFName']?>" /></td></tr>
<?php
		}
		mysqli_close($con);
?>
	</table>
	<br />
	<input type="button" value="Delete Selected" onclick="deletedc();" />
	<br />

	<br />

	</body>
</html>