<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start(); ?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>[Needs Title]</title>
	</head>
	<body>
		<form action="php/logout_server.php" method="post">
			<label for="user">Username: </label><input type="text" id="user" name="user" /><br>
			<label for="pw">Password: </label><input type="password" id="pw" name="pw" /><br>
			<button type="submit">Login</button>
		</form>
		<br>
		<button type="button" onclick="window.location.href='register.html'">Register</button>
		<button type="button" onclick="window.location.href='index.html'">Back to Home</button>	
	</body>
</html>
