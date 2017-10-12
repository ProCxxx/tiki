<?php

if(isset($_COOKIE['u'])&&isset($_COOKIE['uph'])){

  $hostname = "localhost";
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

if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password2'])&&isset($_POST['mail']))
{

$name=$_POST['name'];
$username1=$_POST['username'];
$userhash=hash("md5",hash("md5",strtolower($username1)));
$password1=$_POST['password'];
$pwhash=hash("md5",hash("md5",$password1));
$mail=$_POST['mail'];

$hostname = "localhost";
$username = "proxy";
$password = "proxy1";
$dbname = "proxy";

$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn)
{
    die("Connection failed!");
}

$sql = "SELECT * FROM `user` WHERE `username`='".$username1."' OR `email`='".$mail."';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
  $err = "Username or e-mail alredy taken";
}
else
{
$sql = "INSERT INTO `user`( `name`, `username`, `userhash`, `password`, `pwhash`, `email`, `userpwhash`) VALUES ('".$name."','".$username1."','".$userhash."','".$password1."','".$pwhash."','".$mail."','".hash("md5",hash("md5",strtolower($username1)).hash("md5",$password1))."');";
$result = mysqli_query($conn, $sql);
$err="Successfully registered";
header('Location: login.php');
die();
}
mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title> TiKi</title>
  <link rel="stylesheet" href="css/main.css">
  <script src="main.js"></script>
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
    <li><p><a href="logout.php">Logout</a></p></li>';
    }
    ?>
  </ul>
</nav>
<br/>
<div class="maindiv">
  <center>
    <form method="post" onsubmit="return keup();">
      <table class="contact-box">
        <tr>
          <td>Username: </td>
          <td>
            <input type="text" name="username" maxlength="32" required autofocus autocomplete="on" pattern=".{6,}"   required title="6 characters minimum">
          </td>
        </tr>
        <tr>
          <td>Name: </td>
          <td>
            <input type="text" name="name" maxlength="64" required autocomplete="on" >
          </td>
        </tr>
        <tr>
          <td>Password: </td>
          <td>
            <input type="password" name="password" maxlength="32" required id="pw" autocomplete="off" onkeyup="keup();" pattern=".{8,}"   required title="8 characters minimum">
          </td>
        </tr>
        <tr>
          <td>Confirm: </td>
          <td>
            <input type="password" name="password2" maxlength="32" required id="pw2" autocomplete="off" onkeyup="keup();" pattern=".{8,}"   required title="8 characters minimum">
          </td>
        </tr>
        <tr>
          <td>E-mail </td>
          <td>
            <input type="email" name="mail" maxlength="128" autocomplete="on" required>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" value="Register">
          </td>
          <td>
            <p class="err" id="err" style="display:inline;"><?php echo $err; ?></p>
          </td>
        </tr>
      </table>
    </form>
  </center>
</div>
</body>
</html>
