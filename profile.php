<?php

if(isset($_COOKIE['u'])&&isset($_COOKIE['uph'])){

  $hostname = "localhost";
  $username = "proxy";
  $password = "proxy1";
  $dbname = "proxy";

  $conn = mysqli_connect($hostname, $username, $password, $dbname );

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

if(isset($_POST['text']))
{

  $text=$_POST['text'];

  $hostname = "localhost";
  $username = "proxy";
  $password = "proxy1";
  $dbname = "proxy";

  $conn = mysqli_connect($hostname, $username, $password, $dbname );

  if (!$conn)
  {
      die("Connection failed!");
  }

  $dejt=date("F d. H:i");
  $sql = "INSERT INTO `status`(`id`, `text`, `user`, `stamp`) VALUES ('','".$text."','".$_COOKIE['u']."','".$dejt."')";
  $result = mysqli_query($conn, $sql);
  
  $sql = "SELECT `id` FROM `status` WHERE `text`='".$text."' AND `user`='".$_COOKIE['u']."' AND `stamp`='".$dejt."'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $statusid=$row['id'];
  

  $sql = "INSERT INTO `likes`(`id`, `user`, `number`, `status`) VALUES ('','','0','".$statusid."')";
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
  <center>
  <div class="maindiv">
    <form method="post">
      <table class="update-status">
        <tr><td><textarea name="text" placeholder="Write something..." class='status-post-text' rows="7" autofocus required></textarea></td></tr>
        <tr><td><input type="submit" value="Post" style="float:right;"></td></tr>
      </table>
    </form><br>
  </div>
  <div class="status">

    <?php 
    $hostname = "localhost";
    $username = "proxy";
    $password = "proxy1";
    $dbname = "proxy";

    $conn = mysqli_connect($hostname, $username, $password, $dbname );

    if (!$conn)
    {
      die("Connection failed!");
    }

    
    $sql = "SELECT `name` FROM `user` WHERE `username`='".$_COOKIE['u']."'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    $statusname=$row['name'];
    
    $statustext=[];
    $statususer=[];
    $statustime=[];
    $statusid=[];
    $statuslike=[];

    $sql = "SELECT * FROM `status` WHERE `user`='".$_COOKIE['u']."' ORDER BY id DESC";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
    array_push($statustext,$row['text']);
    array_push($statususer,$row['user']);
    array_push($statustime,$row['stamp']);
    array_push($statusid,$row['id']);
    }
    $temp=0;
    while($temp<count($statusid)){
    $sql = "SELECT * FROM `likes` WHERE `status`='".$statusid[$temp]."'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    array_push($statuslike,$row['number']);
    $temp+=1;
    }
    $temp=0;
    $br="<br>";
    while ($temp<count($statusid)) {
      
      echo "<table class='status-table'>";
      echo "<tr><td colspan='2'><center><p class='status-name'>".$statusname."</p></center></td><td>
            <center><p class='status-time'>".$statustime[$temp]."</p></center></td></tr>";
      echo "<tr><td colspan='3'><center><p class='status-text'>".$statustext[$temp]."</p></center></td></tr>";
      echo "<tr><td><center><p class='status-like' id='".$statusid[$temp]."'>".$statuslike[$temp]."</p></center></td><td>
            <center><button onclick='lajk(\"".$_COOKIE['uph']."\",\"".$statusid[$temp]."\");'>like</button></center></td><td>
            <center><button onclick='dilit(\"".$_COOKIE['uph']."\",\"".$statusid[$temp]."\");'>delete</button></center></td></tr>";
            
      echo "</table><br>";
      $temp+=1;
    }

    mysqli_close($conn);
    ?>
  </div>
  </center>
</body>
</html>
