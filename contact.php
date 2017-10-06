<?php

if(isset($_POST["msg"]))
{

$name=$_POST['name'];
$mail=$_POST['mail'];
$msg =$_POST['msg'] ;

$hostname = "localhost";
$username = "proxy";
$password = "proxy1";
$dbname = "proxy";

$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn)
{
    die("Connection failed!");
}

$sql = "INSERT INTO `contact`(`id`, `name`, `email`, `msg`) VALUES ('','".$name."','".$mail."','".$msg."')";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html>
<head>
  <title> TiKi</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="main.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<body>
  <?php
  if(isset($_COOKIE['u']))
  {
    echo '<p style="position:fixed;bottom:0;right:0;font-size:16px;color:blue;padding-right:10px;"><i>You are logged in as '.$_COOKIE['u'].'<br><span id="lower-time-span"></span></i></p>';
    echo '<script>xyz();</script>';
  }
  else
  {
    echo '<p style="position:fixed;bottom:0;right:0;font-size:16px;color:blue;padding-right:10px;"><i><span id="lower-time-span"></span></i></p>';
    echo '<script>xyz();</script>';
  }
  ?>
  <header>
    <p class="title">TiKi</p>
  </header>
  <nav>
    <ul>
      <li><p><a href="index.php">Home</a></p></li>
      <li><p><a href="about.php">About</a></p></li>
      <li><p><a href="contact.php">Contact</a></p></li>
      <?php
      if(!isset($_COOKIE['u'])&&!isset($_COOKIE['uph'])){
      echo
      '<li><p><a href="login.php">Log in</a></p></li>
      <li><p><a href="register.php">Register</a></p></li>';
      }
      else
      {
      echo
      '<li><p><a href="profile.php">Profile</a></p></li>
      <li><p><a href="settings.php">Settings</a></p></li>
      <li><p><a href="logout.php">Logout</a></p></li>';
      }
      ?>
    </ul>
  </nav>
  <br/>
  <div class="maindiv">
    <center>
    <form method="post">
      <table class="contact-box">
        <tr><td>Name:</td><td><input type="text" name="name" required maxlength="32"></td></td>
        <tr><td>E-mail: </td><td><input type="email" name="mail" required maxlength="128"></td></tr>
        <tr><td>Message: </td><td><textarea cols="25" rows="10" required name="msg" maxlength="4096" id="mes" onkeyup="kedow();"></textarea></td></tr>
        <tr><td><input type="submit" value="Send"></td><td><span class="remain"><p id="rem">0</p><p>/4000</p></span></td></tr>
      </table>
    </form>
  </div>
  <?php
  if(isset($_COOKIE['u'])){
   if(strtolower($_COOKIE["u"])=="admin" and $_COOKIE['uph']=="8ec64b2c86feb9de29b7474c052facfc"){
     echo '<center><a style="text-align:center;" href="contact2.php">Submited contact forms</a>';
   }}
   ?>
</body>
</html>
