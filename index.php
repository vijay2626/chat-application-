<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background:#ddd">
<center style="padding-top:100px;">
	<div style="width:400px;border:1px #eee solid;">
		<table style="width:100%" cellpadding="10">
			<tr>
				<th style="background:#eee">Login</th>
			</tr>
			<tr>
				<td style="width: 100%;border-bottom:1px #eee solid;">
					Username
					<br/>
					<input type="text" class="input" name="" id="username">

<br/><br/>
					Password
					<br/>
					<input type="text" class="input"  name="" id="password">

<br/><br/>

<button class="" type="button" onclick="checkLogin()">Login</button>
				</td>
			</tr>
		</table>
	</div>
</center>
</body>
<script type="text/javascript">
	
	function checkLogin()
	{
		var username = document.getElementById('username').value;
		var password = document.getElementById('password').value;

		if(username == '' || password == '')
		{
			alert("Please enter both fields");
			return false;
		}
		else
		{
			var url = "checklogin.php";
			var params = "username="+username+"&password="+password;


			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			     var response = this.responseText;
			     if(response.indexOf('FALSE') == -1)
			     {
			     	window.location = "default.php";
			     }
			     else
			     {
			     	alert("Invalid Username/Password");
			     }
			    }
			  };
			  xhttp.open("POST", url, true);
			  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			  xhttp.send(params);
			}

		
	}
</script>
</html>