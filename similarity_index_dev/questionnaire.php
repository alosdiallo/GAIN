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
		
		
	</head>
	<body>
	<div class="margin50"><img src="img/menu/top_similarity.jpg" width="1016" height="80" border="0" usemap="#MapMap">
	  <map name="MapMap">
	    <area shape="rect" coords="826,15,894,33" href="contact.php">
	    <area shape="rect" coords="768,16,804,34" href="help.php">
	    <area shape="rect" coords="697,17,748,34" href="guide.php">
	    <area shape="rect" coords="405,16,512,34" href="visualize_similarity_matrix.php">
	    <area shape="rect" coords="129,14,247,36" href="createNewProject.php">
	    <area shape="rect" coords="12,3,97,51" href="index.php">
	    <area shape="rect" coords="913,14,999,34" href="php/logout_server.php">
	    <area shape="rect" coords="271,18,389,36" href="visualize_interactions.php">
      </map>
	  <br>
	  <map name="Map">
	    <area shape="rect" coords="150,14,250,42" href="createNewProject.php">
      </map>
    </div>
	<p>&nbsp;</p>
	<hr>
	<div id="question"></div>
		<div id="picture"></div>
		<div id="answers"></div>
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript" src="js/setupQuestionnaire.js"></script>
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>
		<script>
			window.onload = setupQuestionnaire();
		</script>
	</body>
</html>
