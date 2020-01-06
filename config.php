<?php
include("connection.php");
if(!isset($_COOKIE['loggeduserid']))
{
	header("location:index.php");
}

$loggeduserid = $_COOKIE['loggeduserid'];
$loggedusername = $_COOKIE['loggedusername'];

?>