<?php
session_start();
ob_start();
//error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$db = "chatapplication";

// Create connection
$con = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Kolkata');
$datetime  = date("Y-m-d H:i:s");
// echo "Connected successfully";
?>