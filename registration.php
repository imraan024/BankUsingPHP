<?php

  include "includes/db_connect.php";

  $uName = $pass = $confirmPass = $uEmail = $uPhone = $nationalId = $balance = $err = $uNameInDB = "" ;
	
	
	/* mysqli_real_escape_string() helps prevent sql injection */
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(!empty($_POST['name'])){
      $uName = mysqli_real_escape_string($conn, $_POST['name']);
    }
    if(!empty($_POST['password'])){
      $pass = mysqli_real_escape_string($conn, $_POST['password']);
      $uPassToDB = password_hash($uPass, PASSWORD_DEFAULT);
    }
    if(!empty($_POST['confirmPassord'])){
      $confirmPass = mysqli_real_escape_string($conn, $_POST['confirmPassord']);
      $uPassToDB = password_hash($uPass, PASSWORD_DEFAULT);
    }
    if(!empty($_POST['user_email'])){
      $uEmail = mysqli_real_escape_string($conn, $_POST['user_email']);
      
    }
    if(!empty($_POST['user_phone'])){
      $uPhone = mysqli_real_escape_string($conn, $_POST['user_phone']);
    }
    if(!empty($_POST['user_id'])){
      $nationalId = mysqli_real_escape_string($conn, $_POST['user_id']);
    }

    $sqlUserCheck = "SELECT u_name FROM users WHERE u_name = '$uName'";
    $result = mysqli_query($conn, $sqlUserCheck);

    while($row = mysqli_fetch_assoc($result)){
      $uNameInDB = $row['u_name'];
    }

    if($uNameInDB == $uName){
      $err = "User Name already exists! Try different User Name!";
    }
    else{
      $sql = "INSERT INTO users (u_name,  email, phone, national_id, password)
              VALUES ('$uName','$uEmail', '$uPhone', '$nationalId', '$uPassToDB');";

      mysqli_query($conn, $sql);
    }
  }

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registration: </title>
  </head>
  <body>
    <form action="registration.php" method="post">
      <fieldset>
        <legend>User Registration: </legend>
        <label for="name">User Name: </label>
        <input type="text" name="name" value="" required><br>
        <label for="password">Password: </label>
        <input type="password" name="password" value="" required><br>
        <label for="confirmPassword">Confirm Password: </label>
        <input type="password" name="confirmPassword" value="" required><br>
        <label for="user_email">E-mail: </label>
        <input type="text" name="user_email" value="" required><br>
        <label for="user_phone">Phone: </label>
        <input type="number" name="user_phone" value="" required><br>
        <label for="user_id">National Id: </label>
        <input type="text" name="user_id" value="" required><br>
        <button type="submit" name="button">Register</button><br>
        <span style="color:red;"><?php echo $err; ?></span>
        <span><b>Or Log In <a href="login.php">here</a></b></span>
      </fieldset>
    </form>
  </body>
</html>
