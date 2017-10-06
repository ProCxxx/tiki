<?php

if(strtolower($_COOKIE['u'])!="admin" or $_COOKIE['uph']!="8ec64b2c86feb9de29b7474c052facfc")
{
  header("Location: index.php");
  die();
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
      <?php
      if(!isset($_COOKIE['u'])&&!isset($_COOKIE['uph'])){
          echo
          '<li><p><a href="login.php">Log in</a></p></li>
          <li><p><a href="register.php">Register</a></p></li>';}
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
        <?php

        $hostname = "localhost";
        $username = "proxy";
        $password = "proxy1";
        $dbname = "proxy";

        $conn = mysqli_connect($hostname, $username, $password,$dbname);

        if (!$conn)
        {
            die("Connection failed!");
        }

        $sql = "SELECT * FROM `contact` WHERE 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
          echo "<table class='contact-box2'>";
          echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr><td>". $row["id"]. "</td><td>". $row["name"]. "</td><td>" . $row["email"]. "</td><td>". $row["msg"]."</td></tr>";
            }
            echo '</table>';
        }
        else
        {
            echo '<p class="results">No results</p>';
        }

        mysqli_close($conn);

        ?>
  </div>
</body>
</html>
