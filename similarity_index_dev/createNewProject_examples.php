<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	// If the user is not logged on, redirect to login page.
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require($GLOBALS['directory']."html/title.html");?>
		
		<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
	</head>
	<body>
<div class="margin50"><img src="img/menu/top_manage.jpg" width="1016" height="80" border="0" usemap="#MapMapMap">
  <map name="MapMapMap">
    <area shape="rect" coords="12,3,97,51" href="index.php">
    <area shape="rect" coords="826,15,894,33" href="contact.php">
    <area shape="rect" coords="768,16,804,34" href="help.php">
    <area shape="rect" coords="697,17,748,34" href="guide.php">
    <area shape="rect" coords="532,17,681,35" href="compareMetrics.php">
    <area shape="rect" coords="405,16,512,34" href="visualize_similarity_matrix.php">
    <area shape="rect" coords="913,14,999,34" href="php/logout_server.php">
    <area shape="rect" coords="271,18,389,36" href="visualize_interactions.php">
  </map>
  <br>

  <map name="MapMap">
    <area shape="rect" coords="150,14,250,42" href="createNewProject.php">
  </map>
</div>
<hr>
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<table width="1001" border="0" class="table1">
		  <tr>
		    <td><span class="width50">GAIN is principally designed to analyze interaction profile similarity in bipartite networks. You can either upload a list of interactions or and interaction matrix.<br>
The files uploaded should be tab delimited .txt files. In the case of interaction matrices 0 indicates no interaction and 1 presence of interaction.</span><br>
<br>
<span class="width50"><img src="img/example1.jpg" width="234" height="123"></span><br>
<br>
<img src="img/example2.jpg" width="305" height="100"> <br>
<br>
Special cases:<br>
- Although the tool is not specifically designed for weighted networks, a weighted interaction matrix may be uploaded. To analyze these networks we recommend only using PCC and Cosine index, with or without applying CSI. Beware that some of the functionality of the web tool will not work with weighted matrices such as network visualization.<br>
- A monopartite network can be uploaded as an interaction matrix, provided it is symmetrical.<br>
Beware that some of the functionality of the web tool will not work with monopartite networks, such as network visualization. <br><br></td>
	      </tr>
    </table>
		<script>
			$(document).ready(function(){ 
				setupAjaxForm('form');
			})
			
			function setupAjaxForm(identifier){
				$(identifier).ajaxForm({
					beforeSubmit: function() {},
					success: showResponse
				});
			}

			function showResponse(answer){
				if(answer != "SUCCESS" && answer != ""){
					alert(answer);
				} else if(answer == "SUCCESS"){
					alert("Project Created!");
					// Since we were successful let's empty text boxes to make sure we don't make any stupid mistakes.
					$("#project").val("");
					$("#fileToBeUploaded").val("");
					$("#col1label").val("");
					$("#col2label").val("");
			
				}
			}
		</script>
	</body>
</html>
