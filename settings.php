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
  }
  else
  {
    mysqli_close($conn);
    header('Location: logout.php');
    die();
  }
}
else
{
header("Location: logout.php");
}

$err1="";
$err2="";

if(isset($_POST['name'])&&isset($_POST['mail'])){

  $hostname = "localhost";
  $username = "proxy";
  $password = "proxy1";
  $dbname = "proxy";

  $conn = mysqli_connect($hostname, $username, $password,$dbname);

  if (!$conn)
  {
      die("Connection failed!");
  }

  $sql = "SELECT * FROM `user` WHERE `email`='".$_POST['mail']."'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $err1="E-mail alredy taken";
    mysqli_close($conn);
  }
  else
  {
  $sql="UPDATE `user` SET `name`='".$_POST['name']."',`email`='".$_POST['mail']."' WHERE `username`='".$_COOKIE['u']."' AND `userpwhash`='".$_COOKIE['uph']."'";

  if (mysqli_query($conn, $sql)) {
  $err1="Updated successfully";
  }
  else
  {
  $err1="Error updating";
  }
  mysqli_close($conn);
  }
}

if(isset($_POST['pw1'])&&isset($_POST['pw2'])){

    $hostname = "localhost";
    $username = "proxy";
    $password = "proxy1";
    $dbname = "proxy";

    $conn = mysqli_connect($hostname, $username, $password,$dbname);

    if (!$conn)
    {
        die("Connection failed!");
    }


    $sql = "SELECT * FROM `user` WHERE `password`='".$_POST['pw1']."' AND `username`='".$_COOKIE['u']."' AND `userpwhash`='".$_COOKIE['uph']."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      $err2="Wrong old password";
      mysqli_close($conn);
    }
    else
    {
    $sql="UPDATE `user` SET `password`='".$_POST['pw2']."',`pwhash`='".hash('md5',hash('md5',$_POST['pw2']))."',`userpwhash`='".hash('md5',hash('md5',strtolower($_COOKIE['u'])).hash('md5',$_POST['pw2']))."' WHERE `username`='".$_COOKIE['u']."'";
    if (mysqli_query($conn, $sql))
    {
      $err2="Updated successfully";
      setcookie("uph",hash("md5",hash("md5",strtolower($_COOKIE['u'])).hash("md5",$_POST['pw2'])),time()+3600,"/");
    }
    else
    {
      $err2="Error updating";
    }
      mysqli_close($conn);
    }
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
  ?>
  <header>
    <p class="title">TiKi</p>
  </header>
  <nav>
    <ul>
      <li><p><a href="index.php">Home</a></p></li>
      <li><p><a href="about.php">About</a></p></li>
      <li><p><a href="contact.php">Contact</a></p></li>
      <li><p><a href="profile.php">Profile</a></p></li>
      <li><p><a href="settings.php">Settings</a></p></li>
      <li><p><a href="logout.php">Logout</a></p></li>
    </ul>
  </nav>
  <br>
  <div class="maindiv">
    <center>
      <?php
      if(isset($_COOKIE['u'])&&isset($_COOKIE['uph']))
      {
      $hostname = "localhost";
      $username = "proxy";
      $password = "proxy1";
      $dbname = "proxy";

      $conn = mysqli_connect($hostname, $username, $password,$dbname);

      if (!$conn)
      {
          die("Connection failed!");
      }

      $sql = "SELECT `id`, `name`, `username`, `password`, `email` FROM `user` WHERE `username`='".$_COOKIE['u']."' AND `userpwhash`='".$_COOKIE['uph']."'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      mysqli_close($conn);

      }

      echo '<form method="post">
        <table class="contact-box">
          <tr><td>Name: </td><td><input type="text" name="name" maxlength="64" required autocomplete="off" value="'.$row["name"].'"></td></tr>
          <tr><td>Username: </td><td><input type="text" readonly value="'.$row['username'].'"></td></tr>
          <tr><td>E-mail: </td><td><input type="email" name="mail" maxlength="128" required autocomplete="off" value="'.$row['email'].'"></td></tr>
          <tr><td><input type="submit" value="Save"></td><td><p class="err1 err" style="display:inline;">'.$err1.'</p></td></tr>
        </table>
      </form><br/>
      <form method="post" onsubmit="return pwkeup();">
        <table class="contact-box">
          <tr><td>Old password: </td><td><input type="password" required maxlength="32" name="pw1" ></td></tr>
          <tr><td>New password: </td><td><input type="password" required maxlength="32" name="pw2" id="pw1" onkeyup="pwkeup();" pattern=".{8,}"   required title="8 characters minimum"></td></tr>
          <tr><td>New password: </td><td><input type="password" required maxlength="32" id="pw2" onkeyup="pwkeup();" pattern=".{8,}"   required title="8 characters minimum"></td></tr>
          <tr><td><input type="submit" value="Save"></td><td><p class="err2 err" style="display:inline;">'.$err2.'</p></td></tr>
        </table>
      </form>';
      ?>
  </div>
</body>
</html>
