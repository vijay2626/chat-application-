<?php
include("config.php");
$message = $_POST['message'];
$touser = $_POST['touser'];

mysqli_query($con,"INSERT INTO `chat` (`from_to`, `to_user`, `message`, `dt`) VALUES ('$loggeduserid', '$touser', '$message', '$datetime');") or die(mysqli_error($con));
?>