<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FuturesV</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="style/jquery_validation.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<script src="js/jquery_validation.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css">
</head> 
<body style="margin:0;">
<div>
<img src="pic/bg.jpg" style="height:100%; width:100%; position:fixed; z-index:0;left:0px;"></img>
		<div style="top:100px;position:relative;">
			<form style="height:275px" class="logForm" action="processLogin.php" method="post" type="post">
				<h1 align="center">Welcome!</h1></br>
				<input class="logInput" type="text" name="loginName" placeholder="Username" minlength="2" maxlength="10" required></br>
				<input class="logInput" type="password" name="loginPassword" placeholder="Password" minlength="5" maxlength="10" required></br>
				<button type="submit" class="logButton" name="loginButton" id="loginButton" value="loginButton">Sign In</button></br></br>
	<!--			<a href="register.php"><p style="text-align:center;"> Do not have an account? Sign up now!</p></a>	-->
			</form>
			<script>
				$(".logForm").validate();
			</script>
		</div>
</div>
</body>
</html>