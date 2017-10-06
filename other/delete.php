<?php

//DELETE STATUS
if(isset($_POST['user'])&&isset($_POST['status'])){	
	
	$userhash=$_POST['user'];
	$postid=$_POST['status'];

	$hostname = "localhost";
    $username = "proxy";
    $password = "proxy1";
    $dbname = "proxy";

    $conn = mysqli_connect($hostname, $username, $password, $dbname );

    if (!$conn)
    {
      die("Connection failed!");
    }

    
    $sql = "DELETE FROM `status` WHERE `id`='".$postid."'";
    $result = mysqli_query($conn, $sql);

    $sql = "DELETE FROM `likes` WHERE `status`=".$postid;
    $result = mysqli_query($conn, $sql);
    
    mysqli_close($conn);	
    echo 'Successfull';
	
	}
	else
	{
		echo "Error";
	}

?>