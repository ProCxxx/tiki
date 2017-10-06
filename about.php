<!DOCTYPE html>
<html>
<head>
  <title>TiKi</title>
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
    }else{
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
      if(!isset($_COOKIE['u'])&&!isset($_COOKIE['uph']))
      {
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
  <br>
  <div class="maindiv">
    <center>
      <p class="about-text">Something about this ...</p>
  </div>
</body>
</html>
