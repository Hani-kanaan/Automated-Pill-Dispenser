<?php
	if (isset($_GET["uname"]) && isset($_GET["passwd"])){
		extract($_GET);
		require_once("connect.php");
		$query = "SELECT * FROM admin WHERE aFName = '{$uname}';";
  
		$result = mysqli_query($con, $query);
	
		if (!$result) {
			die(mysqli_error());
		}

		if (mysqli_num_rows($result) !=0) {
    
			setcookie("loggedin", "true", 30*60); //session is 30 minutes
			$row = mysqli_fetch_assoc($result);
			
			if ($passwd == $row['adminPass']) {
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["aFName"] = $row["aFName"];
				$_SESSION["adminID"]= $row["adminID"];
		      echo "log in ok";  
			}
			
		}
		else{
			    echo "incorrect username or password";
			}
//	setcookie("loggedin", "true", -1); // remove cookie if login fails
	}
?>