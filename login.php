<?php
include "includes/db_connect.php";

session_start();
$uPass = $uName = $message = "";

/* mysqli_real_escape_string() helps prevent sql injection */
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(!empty($_POST['u_name'])){
		$uName = mysqli_real_escape_string($conn, $_POST['u_name']);
	}
	if(!empty($_POST['u_pass'])){
		$uPass = mysqli_real_escape_string($conn, $_POST['u_pass']);
	}

	$sqlUserCheck = "SELECT name, password FROM users WHERE name = '$uName'";
	$result = mysqli_query($conn, $sqlUserCheck);
	$rowCount = mysqli_num_rows($result);

	if($rowCount < 1){
		$message = "User does not exist!";
	}
	else{
		while($row = mysqli_fetch_assoc($result)){
			$uPassInDB = $row['password'];

			if(password_verify($uPass, $uPassInDB)){
				$_SESSION['name'] = $uName;
				header("Location: welcome.php");
			}
			else{
				$message = "Wrong Password!";
			}
		}
	}
}

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form action="login.php" method="post">
      <fieldset>
        <legend>Login</legend>
        <label for="u_name">Username: </label>
        <input type="text" name="u_name" value="" required><br>
        <label for="u_pass">Password: </label>
        <input type="password" name="u_pass" value="" required><br>
        <button type="submit" name="login">Login</button>
				<span style="color:red"><?php echo $message; ?></span>
				<span><b>Or Register <a href="registration.php">here</a></b></span>
      </fieldset>
    </form>
  </body>
</html>
