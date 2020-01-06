<?php
include("config.php");
$upto = $_GET['upto'];
$getData = mysqli_query($con,"SELECT * FROM `chat` WHERE `id` > '$upto' AND `to_user` = '$loggeduserid' ORDER BY `id` ASC") or die(mysqli_error($con));
$response = "";
$lastid= 0;
while($row = mysqli_fetch_array($getData))
{
	$response .= $row['message'].":::::::".$row['from_to']."THISISTOBREAKMESSAGE";
	$lastid = $row['id'];
}
echo $response."THISISTOBREAKMESSAGE".$lastid;
?>