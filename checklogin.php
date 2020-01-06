<?php
include("connection.php");
$username = $_POST['username'];
$password = $_POST['password'];
$checklogin = mysqli_query($con,"SELECT * FROM `register` WHERE `username` = '$username' AND `password` = '$password'") or die(mysqli_error($con));
if(mysqli_num_rows($checklogin) > 0)
{
	$row = mysqli_fetch_array($checklogin);
	$loggeduserid = $row['id'];
	$loggedusername = $row['username'];
	
	$expire = time()+(60*60*24);
	setcookie("loggeduserid",$loggeduserid,$expire,"/");
	setcookie("loggedusername",$loggedusername,$expire,"/");
	
	echo "TRUE";
}
else
{
	echo "FALSE";
}
?>