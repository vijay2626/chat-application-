<?php
include("config.php");
$getUpto = mysqli_query($con,"SELECT * FROM `chat` WHERE `to_user` = '$loggeduserid' ORDER BY `id` DESC LIMIT 1") or die(mysqli_error($con));
if(mysqli_num_rows($getUpto) == 0)
{
	$upto = '0';
}
else
{
$rowUpto =mysqli_fetch_array($getUpto);
$upto = $rowUpto['id'];	

	
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
	<title><?php echo $loggedusername;?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript">
       
	increment = [];
	</script>
</head>
<body>
<table style="width:100%;">
	<tr>
		<td style="width:85%" valign="top" id="chatWindowHolder">
		</td>
		<td style="width:15%;background:#f7f7f7;height:1000px;" valign="top">


<?php 
$getUsers = mysqli_query($con,"SELECT * FROM `register` WHERE `id` != '$loggeduserid' ORDER BY `username` ASC") or die(mysqli_error($con));
while($row = mysqli_fetch_array($getUsers))
{
	?>
<div style="padding:10px;border-bottom:1px #ddd solid;text-align:leftl;cursor:pointer" onclick="openChatWindow('<?php echo $row['id'];?>','<?php echo $row['username'];?>','block')">
	<?php echo $row['username'];?> [<span id="notification<?php echo $row['id'];?>"></span>]

</div>
<span id="hidden<?php echo $row['id'];?>" style="display:none"><?php echo $row['username'];?></span>
<script type="text/javascript">
	increment[<?php echo $row['id'];?>] = 0;
</script>
	<?php
}
?>			




		</td>
	</tr>
</table>
<script type="text/javascript">
     
	var upto = <?php echo $upto; ?>;
	var currentWindow=0;

	function openChatWindow(id,username,displayproperty)
	{
 document.getElementById('notification'+id).innerHTML = '';
 	if(displayproperty != 'none')
 	{
		if(currentWindow != 0)
		{
			document.getElementById('chatWindow'+currentWindow).style.display = 'none';

		}
		currentWindow = id;

		if(document.getElementById('chatWindow'+id))
		{
			document.getElementById('chatWindow'+id).style.display = 'block'
		}
		else
		{
		var html = '<div class="chatWindow" id="chatWindow'+id+'" style="display:'+displayproperty+'">'+username+' says..<br/><div class="chatHolder" id="chatHolder'+id+'"><center><button type="button" onclick="loadMessage(\''+id+'\')">Load Previous Chat</button></center><input type="hidden" id="inc" value="0"></div><textarea style="width:80%;height:95px;" placeholder="Send Message"   id="chatMsgholder'+id+'"></textarea><button style="vertical-align: top" onclick="sendMessage(\''+id+'\')">SEND</button></div>';

		document.getElementById('chatWindowHolder').innerHTML += html;			
		}

 	}
 	else
 	{
		var html = '<div class="chatWindow" id="chatWindow'+id+'" style="display:'+displayproperty+'">'+username+' says..<br/><div class="chatHolder" id="chatHolder'+id+'"><center><button type="button" onclick="loadMessage(\''+id+'\')">Load Previous Chat</button></center><input type="hidden" id="inc" value="0"></div><textarea style="width:80%;height:95px;" placeholder="Send Message"   id="chatMsgholder'+id+'"></textarea><button style="vertical-align: top" onclick="sendMessage(\''+id+'\')">SEND</button></div>';

		document.getElementById('chatWindowHolder').innerHTML += html;			

 	}
		

	}



	function sendMessage(id)
	{ 
		var date = new Date();
		var hour = date.getHours();
		var day = date.getDay();
		var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		var minutes = date.getMinutes();
		var message = document.getElementById('chatMsgholder'+id).value;
		if(message != '')
		{
			var url = "sendmessage.php";
			var params = "message="+message+"&touser="+id;


			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			     var response = this.responseText;
			      document.getElementById('chatMsgholder'+id).value = '';
			      var html = '<div style="border:1px;text-align:right;padding:10px; color:blue;">'+message+"<br/>"+day+"-"+days[date.getDay()]+"-"+hour+":"+minutes+'</div>';
			      document.getElementById('chatHolder'+id).innerHTML += html;

			    }
			  };
			  xhttp.open("POST", url, true);
			  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			  xhttp.send(params);
		}
	}
 

function loadMessage(id)
	{
		 
	//	  i[id]  = 0;
        console.log(increment[id]);

		var url = "loadMessage.php?id="+id;
		var inc=document.getElementById('inc').value = ++increment[id];
		console.log("inc="+inc);
			var params = "inc="+inc;


			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	 console.log(this.responseText);
			    	 var response = this.responseText
			    	
			    	
			      document.getElementById('chatHolder'+id).innerHTML += response;
                  
			    }
			  };
			  xhttp.open("POST", url, true);
			  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			  xhttp.send(params);

	}


	function receiveMessage()
	{
        
		var url = "receivemessage.php?upto="+upto;
		
			var params = "";


			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	response = this.responseText;
			    	response = response.split('THISISTOBREAKMESSAGE');
			    	console.log(response.length);
			    	if(response.length > 2)
			    	{
			    	upto = response[response.length -1];
			    	for(j=0;j<response.length;j++)
			    	{

			    		var temp = response[j];
			    		temp1 = temp.split(':::::::');
			    		var msg = temp1[0];
			    		var fromuser = temp1[1];
                        
			    		if(document.getElementById('chatWindow'+fromuser))
			    		{


 							var html = '<div style="text-align:left;padding:10px;">'+msg+'</div>';
						      document.getElementById('chatHolder'+fromuser).innerHTML += html;
						      if(document.getElementById('chatWindow'+fromuser).style.display == 'none')
						      {
						      		displayNotification(fromuser);
						      }			    
						}		    		
			    		else
			    		{
			    			var Username = document.getElementById('hidden'+fromuser).innerHTML;
			    			openChatWindow(fromuser,Username,'none');
			    			 var html = '<div style="text-align:left;padding:10px;">'+msg+'</div>';
						      document.getElementById('chatHolder'+fromuser).innerHTML += html;

			    			displayNotification(fromuser);
			    		}
			    	}
			    }

			    }
			  };
			  xhttp.open("POST", url, true);
			  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			  xhttp.send(params);

	}

	setInterval(function(){
		receiveMessage();
	},3000);


	function displayNotification(id)
	{
					    			if(document.getElementById('notification'+id))
			    			{
			    		var x = document.getElementById('notification'+id).innerHTML;
			    		if(x == '')
			    		{
			    			x = '0';
			    		}
			    		x= parseInt(x);
			    		x = x+1;
			    		document.getElementById('notification'+id).innerHTML = x;
	}
}




</script>
</body>
</html>