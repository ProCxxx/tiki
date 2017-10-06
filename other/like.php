<?php 
//LIKE UPDATE
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

    
    $sql = "SELECT `id` , `username` FROM `user` WHERE `userpwhash`='".$userhash."'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    $user=$row['username'];
    $userid=$row['id'];

    $sql = "SELECT  * FROM `likes` WHERE `user` LIKE '%, ".$userid." ,%'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_num_rows($result);
    echo $row;
    
    if($row>0){
    
    $sql = "UPDATE `likes` SET `user` = REPLACE(`user`, ', ".$userid." ,', '') WHERE `status` = '".$postid."'";
    $result = mysqli_query($conn,$sql);    
    if($result){
    $sql="UPDATE `likes` SET `number`=number-1  WHERE  `status`='".$postid."'";
    $result=mysqli_query($conn, $sql);
    }

    $sql = "SELECT `number` FROM `likes` WHERE `status`='".$postid."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $lajkovi = $row['number'];
    echo $lajkovi;
    
    mysqli_close($conn);

    }else{

    $sql="UPDATE `likes` SET `number`=number+1 ,`user`=CONCAT(`user`,', ".$userid." ,') WHERE  `status`='".$postid."'";
    $result=mysqli_query($conn, $sql);

    $sql="SELECT `number` FROM `likes` WHERE `status`='".$postid."'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $lajkovi=$row['number'];
    echo $lajkovi;
    mysqli_close($conn);	
	}
	}
	else
	{
		echo "Error";
	}
?>