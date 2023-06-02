<?php
if (isset($_GET["sname"]) && isset($_GET["spass"])){
		extract($_GET);
		require_once("connect.php");
	
		
		$query = "SELECT * FROM super WHERE superName = '{$sname}';";
		
		$result = mysqli_query($con, $query);
	
		if (!$result) {
			die(mysqli_error());
		}

		if (mysqli_num_rows($result) !=0) {
			setcookie("loggedin", "true", 30*60); //session is 30 minutes
			$row = mysqli_fetch_assoc($result);
			
			if ($spass == $row['password']) {
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["sname"] = $row["superName"];
				echo "super access";
			}
		
		}	else {
			    echo "wrong username or password ";
			}
	
	//	setcookie("loggedin", "true", -1); // remove cookie if login fails
	}
	?>