<?php
  include "includes/db_connect.php";
  session_start();

  $amount = $pass = $message "";

  if(!isset($_SESSION["name"])){
    header("Location: login.php");
  }
  else
  {
    if($_SERVER["REQUEST_METHOD"]=="POST"){
      if(!empty($_POST['add'])){
      $amount = mysqli_real_escape_string($conn, $_POST['add']);
    }
    if(!empty($_POST['password'])){
      $pass = mysqli_real_escape_string($conn, $_POST['password']);
    }


  if($amount > 50000){
    $message = "Amount is high! You can add less than 50000 at a time!";
  }
  else{

      if(password_verify($pass, $uPassInDB)){
        $sql = "SELECT balance FROM users WHERE u_name = '$uName'";
        $balance = mysqli_query($conn, $sql);
        $newBalance = $balance + $amount;

        $sqlUpdate = "UPDATE users SET balance = $newBalance WHERE u_name = '$uName'";
        $update = mysqli_query($conn, $sqlUpdate);
        $message = "Add Money Success!"
      }
      }
      else{
        $message = "Wrong Password!";
      }
    }
  }
    
  
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add Money</title>
  </head>
  <body>
    <h1>Welcome, <?php echo $_SESSION["username"]; ?></h1>
    <label for="add">Amount You want to Add: </label>
    <input type="number" name="add" value="" required><br>
    <label for="password">Enter Password: </label>
    <input type="password" name="password" value="" required><br>
    <button type="submit" name="addMoney">Add</button>
        <span style="color:red"><?php echo $message; ?></span>
    <a href="logout.php">Logout</a>
  </body>
</html>
