<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	error_reporting(E_ALL);
	require_once 'php/constants.php';
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require($GLOBALS['directory']."html/title.html");?>
		<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
		
	</head>
	<body>
		<div class="margin50"><img src="img/menu/top_contact.jpg" width="1016" height="80" border="0" usemap="#MapMap">
		  <map name="MapMap">
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
		</img>
		
		<!-- Javascript -->
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript">baseurl = "<?php echo $GLOBALS['url']?>";</script>
	</body>
</html>
