<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
        
        

<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
		<?php require($GLOBALS['directory']."html/title.html");?>
	</head>
    <div class="margin50"><img src="img/top1.jpg" width="992" height="72" border="0" usemap="#MapMap">
		  <map name="MapMap"><area shape="rect" coords="725,17,777,40" href="help.php"><area shape="rect" coords="796,16,902,41" href="contact.php"><area shape="rect" coords="411,18,530,38" href="visualize_similarity_matrix.php"><area shape="rect" coords="549,16,715,39" href="compareMetrics.php"><area shape="rect" coords="270,18,394,42" href="visualize_interactions.php">
		    <area shape="rect" coords="149,14,249,42" href="createNewProject.php">
	        <area shape="rect" coords="924,14,999,41" href="php/logout_server.php">
		  </map>
		  <br>

		  <map name="Map">
		    <area shape="rect" coords="150,14,250,42" href="createNewProject.php">
	      </map>
		</div>
        		<hr>
<body>
		<div id="help_info">
			<p> User names and Passwords should be at least 6 characters in length and should not contain any spaces. <br>
			Once you have registered you will need to login, in order to use the site.</p>
		</div>
		
		
		<form action="php/register_server.php" method="post">
			<label for="user"><img src="img/username.jpg" width="152" height="14"><br>
			</label> <input type="text" id="user" name="user" />
			<br>
			<br>
			<label for="pw1"><img src="img/password.jpg" width="152" height="14"><br>
			</label> <input type="password" id="pwOrig" name="pwOrig" />
			<br>
			<br>
			<label for="pw2"><img src="img/retype.jpg" width="152" height="14"><br>
			</label> <input type="password" id="pwCopy" name="pwCopy" /><br>
			<button type="submit">Register</button>
		</form>
		<button type="button" onclick="window.location.href='index.php'">Back to Home</button>
	</body>
</html>
