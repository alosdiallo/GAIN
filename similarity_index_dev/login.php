<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start(); ?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<?php require($GLOBALS['directory']."html/title.html");?>
    <style type="text/css">
    .login {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
    .login {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
    .login {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
    .intro_text {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
    </style>
	</head>
	<body>
		<div class="margin50"><img src="img/menu/top_index.jpg" width="1016" height="80" border="0" usemap="#MapMap">
		  <map name="MapMap">
		    <area shape="rect" coords="826,15,894,33" href="contact.php">
		    <area shape="rect" coords="766,16,802,34" href="help.php">
		    <area shape="rect" coords="695,17,746,34" href="guide.php">
		    <area shape="rect" coords="530,17,679,35" href="compareMetrics.php">
		    <area shape="rect" coords="403,16,510,34" href="visualize_similarity_matrix.php">
		    <area shape="rect" coords="10,3,95,51" href="index.php">
		    <area shape="rect" coords="127,14,245,36" href="createNewProject.php">
		    <area shape="rect" coords="269,18,387,36" href="visualize_interactions.php">
		    <area shape="rect" coords="911,14,997,34" href="php/logout_server.php">
	      </map>
		  <br>

		  <map name="Map">
		    <area shape="rect" coords="150,14,250,42" href="createNewProject.php">
	      </map>
	</div>
		<hr>
<table width="100" border="0">
  <tr>
  <form action="php/login_server.php" method="post">
    <td valign="top"></p>
      <label for="user"><img src="img/username.jpg" width="152" height="14"></label>
	  <br><input name="user" type="text" id="user" size="35" /><br>
		<label for="pw"><img src="img/password.jpg" width="152" height="14"></label>
		<br><input name="pw" type="password" id="pw" size="35" />
		<br>

		<button type="submit">Login</button>
			</form>
			<button type="button" onclick="window.location.href='register.php'">Register New User</button>
			<br>
		
		<!--button type="button" onclick="window.location.href='index.html'">Back to Home</button-->	</td>
    <td>&nbsp;</td>
    <td valign="top"><p class="intro_text"><img src="img/img_intro_new.jpg" width="755" height="460"><br>
      <br>
      Many types of biological networks are rapidly being mapped. Aside from providing system-level insights into biological processes, these networks can be used to functionally annotate uncharacterized genes based on interaction profile similarities with well-studied genes (&quot;guilt by association&quot;).<br>
      Numerous different association indices can be used to determine interaction profile similarities, and it can be daunting to select which one is most appropriate for a particular goal.<br>
      Here we provide a webtool that facilitates the identification of modules of genes with similar function, the assembly of association networks and the comparison of the interaction profile similarity between selected pairs of nodes in a network.</p>
      <p class="intro_text">To begin first you must login or create a user and then go to Manage Projects to submit a new project. Go to Help for detailed instructions on how to use the web tool or to Guide for assistance to select an association index.<br>
        <br>
    </p></td>
  </tr>
</table>
<br>
		
		<!--button type="button" onclick="window.location.href='index.html'">Back to Home</button-->	
	</body>
</html>
