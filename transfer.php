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
      if(!empty($_POST['transfer'])){
      $amount = mysqli_real_escape_string($conn, $_POST['transfer']);
    }
    if(!empty($_POST['password'])){
      $pass = mysqli_real_escape_string($conn, $_POST['password']);
    }

    $sql = "SELECT balance FROM users WHERE u_name = '$uName'";
    $balance = mysqli_query($conn, $sql);

  if($amount > $balance){
    $message = "Amount is high! You can transfer less than your balance.";
  }
  else{

      if(password_verify($pass, $uPassInDB)){
        
        $newBalance = $balance - $amount;

        $sqlUpdate = "UPDATE users SET balance = $newBalance WHERE u_name = '$uName'";
        $update = mysqli_query($conn, $sqlUpdate);

         $message = "Transfer Success!"
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
    <title>Transfer Money</title>
  </head>
  <body>
    <h1>Welcome, <?php echo $_SESSION["username"]; ?></h1>
    <label for="transfer">Amount You want to Transfer: </label>
    <input type="number" name="transfer" value="" required><br>
    <label for="account">Account number: </label>
    <input type="number" name="account" value="" required><br>
    <label for="password">Enter Password: </label>
    <input type="password" name="password" value="" required><br>
    <button type="submit" name="transferMoney">Transfer</button>
        <span style="color:red"><?php echo $message; ?></span>
    <a href="logout.php">Logout</a>
  </body>
</html>
