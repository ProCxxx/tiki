<?php

setcookie("u","",time()-1,"/");
setcookie("uph","",time()-1,"/");

header('Location: login.php');
die();

?>
