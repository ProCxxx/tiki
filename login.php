<?php

if(isset($_COOKIE['u'])&&isset($_COOKIE['uph'])){

  $hostname = "35.195.192.3";
  $username = "proxy";
  $password = "proxy1";
  $dbname = "proxy";

  $conn = mysqli_connect($hostname, $username, $password,$dbname);

  if (!$conn)
  {
      die("Connection failed!");
  }

  $sql = "SELECT `userpwhash` FROM `user` WHERE `username`='".$_COOKIE['u']."'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  if($row['userpwhash']==$_COOKIE['uph'])
  {
  mysqli_close($conn);
  header('Location: index.php');
  die();
  }
  else
  {
    mysqli_close($conn);
    header('Location: logout.php');
    die();
  }
}
$err="";
if(isset($_POST['username1'])&&isset($_POST['password1']))
{

$username1=$_POST['username1'];
$password1=$_POST['password1'];
$userhash=hash("md5",hash("md5",$username1));
$pwhash=hash("md5",hash("md5",$password1));

$hostname = "35.195.192.3";
$username = "proxy";
$password = "proxy1";
$dbname = "proxy";

$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn)
{
    die("Connection failed!");
}


$sql = "SELECT * FROM `user` WHERE ((`username`='".$username1."' AND `password`='".$password1."') OR (`userhash`='".$userhash."' AND `pwhash`='".$pwhash."'));";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1)
{
  $row = mysqli_fetch_assoc($result);
  $err = "Successfully logged in as ".$row["username"];
  setcookie("u",$row["username"],time()+3600,"/");
  setcookie("uph",hash("md5",hash("md5",strtolower($username1)).hash("md5",$password1)),time()+3600,"/");
  header('Location: index.php');
  die();
}
else
{
  $err="Wrong username or password";
}
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
  if(!isset($_COOKIE['u']))
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
      <li><p><a href="login.php">Log in</a></p></li>
      <li><p><a href="register.php">Register</a></p></li>
    </ul>
  </nav>
  <br>
  <center>
  <div class="maindiv">
    <form method="post">
      <table class="contact-box">
        <tr><td>Username: </td><td><input type="text" name="username1" required autofocus autocomplete="off"></td></tr>
        <tr><td>Password: </td><td><input type="password" name="password1" required></td></tr>
        <tr><td><input type="submit" value="Log in"></td><td><p class="err" style="display:inline;"><?php echo $err; ?></p></td></tr>
      </table>
    </form>
  </div>
  <p style="color:blue;font-size:10px;"><i>If you've disabled cookies, you won't be able to log in</i></p>
</body>
</html>
