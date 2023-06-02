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
				$_SESSION["uname"] = $row["aFName"];
				$_SESSION["adminID"]= $row["adminID"];
		     
			header("Location:https://automated-pill-dispenser.000webhostapp.com/adminPage.php");
					 echo "log in ok" ;  
			}
		}
	setcookie("loggedin", "true", -1); // remove cookie if login fails
	}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
 

  <meta charset="UTF-8">
  <title>Login Page</title>

<style type="text/css">
 

</style>
<script>
/*
  function validateForm() {
    var passwords = document.getElementsByName("passwd");

    console.log(passwords[0].value);
       
        }
        console.log(passwords[0].value != passwords[1].value);
        if (passwords[0].value != passwords[1].value) {
          alert('two passwords should match');
          return false;
        }
        return true;
      }
  */

</script>
</head>
<body>



  <div id="bg"></div>

<form  onsubmit="return validateForm()" action="loginpage.php" method="get">

  <div class="form-field">
    <input type="input" placeholder=" Username" name = "uname" required/>
  </div>
  
  <div class="form-field">
    <input type="password" placeholder="Password" name="passwd" required/>                         
</div>

  <div class="form-field">
    <button class="btn" type="submit">Sign In</button><button><a href="http://localhost/senior/signup.php" class="btn>
    sign up</a></button>

  </div>
</form>

  
</body>

</html>
