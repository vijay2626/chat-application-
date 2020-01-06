<?php
include("config.php");

 $id = $_GET['id'];

 
 $page = $_POST['inc'];


for($a=$page;$a<200;$a++){
	$perpage = 10;
$calc = $perpage * $page;
$start = $calc - $perpage;

$getData = mysqli_query($con,"SELECT * FROM `chat` WHERE  `from_to` = '$loggeduserid' AND `to_user` = '$id' or `from_to` = '$id' AND `to_user` = '$loggeduserid' ORDER BY `id` DESC limit $start, $perpage") or die(mysqli_error($con));
}

while($row = mysqli_fetch_array($getData))
{

	
	
	if($row['from_to'] == $loggeduserid)
		{
	?>
	
		 <div style="text-align:right;padding:10px;"><?php echo $row['message']."<br/>";?></div>
	<?php }

	 else if ($row['from_to'] == $id) 
	{
	?> 
		<div style="text-align:left;padding:10px;"><?php echo $row['message']."<br/>";?></div>
	<?php
	}

}

?>