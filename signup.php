<?php

	if (isset($_GET["uname"]) && isset($_GET["passwd"])){
		extract($_GET);
		 
		require_once("connect.php");
		
		setcookie("loggedin", "true", 30*60); 
		$query = "INSERT INTO admin VALUES ('{$uname}','0' , '{$passwd}')";
		$result = mysqli_query($con, $query);
		$_SESSION["adminID"]=$uname;
		 echo "log in ok" ;  
	//	header("Location:https://automated-pill-dispenser.000webhostapp.com/adminPage.php");
		
	
	}	
?>
<!DOCTYPE html>
<html>
<head>
<link rel="website icon" type="png" href="htdocs\11930070\img\web.png">
  <title>Sign pills</title>
<style type="text/css">

  @import url("https://fonts.googleapis.com/css?family=Lato:400,700");
#bg {
  background-image: url('img/background.jpg');
  position: fixed;
  left: 0
  top: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  filter: blur(5px);
}

body {
  font-family: 'Lato', sans-serif;
  color: #4A4A4A;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  overflow: hidden;
  margin: 0;
  padding: 0;
}

form {
  width: 350px;
  position: relative;
}
form .form-field::before {
  font-size: 20px;
  position: absolute;
  left: 15px;
  top: 17px;
  color: #888888;
  content: " ";
  display: block;
  background-size: cover;
  background-repeat: no-repeat;
}
form .form-field:nth-child(1)::before {
  background-image: url(img/user-icon.png);
  width: 20px;
  height: 20px;
  top: 15px;
}
form .form-field:nth-child(2)::before {
  background-image: url(img/lock-icon.png);
  width: 16px;
  height: 16px;
}
form .form-field:nth-child(3)::before {
  background-image: url(img/lock.png);
  width: 16px;
  height: 16px;
  }
form .form-field {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  margin-bottom: 1rem;
  position: relative;
}
form input {
  font-family: inherit;
  width: 100%;
  outline: none;
  background-color: #fff;
  border-radius: 4px;
  border: none;
  display: block;
  padding: 0.9rem 0.7rem;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
  font-size: 17px;
  color: #4A4A4A;
  text-indent: 40px;
}
form .btn {
  outline: none;
  border: none;
  cursor: pointer;
  display: inline-block;
  margin: 0 auto;
  padding: 0.9rem 2.5rem;
  text-align: center;
  background-color: #47AB11;
  color: #fff;
  border-radius: 4px;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
  font-size: 17px;
}</style>



<script>
 function validateForm() {
   var passwords = document.getElementsByName("passwd");

    console.log(passwords[0].value);
      //  if (!passwords[0].value.match(/[\$@!%\^&\*]+/)) {
        //  alert('password should contain at least one special char');
        //  return false;
       // }
     //   console.log(passwords[0].value != passwords[1].value);
        //if (passwords[0].value != passwords[1].value) {
        //  alert('two passwords should match');
        //  return false;
        }
        return true;
      //}
  </script>
  </head>
<body>
<div id="bg"></div>
<form  onsubmit="return validateForm()">
<form action="signup.php" method="get">

 <div class="form-field">
<input type="input" placeholder="username" name="uname" required/> 
</div>
 <div class="form-field">   
    <input type="password" placeholder="Password" name="passwd" required/>  </div>                       
  
<div class="form-field">
    <input type="password" placeholder="Confirm Password" name="passwd" required/>
	</div>
	 <div class="form-field">
    <button class = "btn" type="submit">Sign up</button> </form>
</div></form>
</body>
</html>