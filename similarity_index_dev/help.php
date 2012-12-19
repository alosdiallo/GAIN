<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	// If the user is not logged on, redirect to login page.
	// if(!isset($_SESSION['logged_on'])){
		// header('Location: '.$GLOBALS['url'].'login.php');
	// }
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require($GLOBALS['directory']."html/title.html");?>
		
		<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
	</head>
	<body>
<div class="margin50"><img src="img/menu/top_help.jpg" width="1016" height="80" border="0" usemap="#MapMapMap">
  <map name="MapMapMap">
    <area shape="rect" coords="826,15,894,33" href="contact.php">
    <area shape="rect" coords="697,17,748,34" href="guide.php">
    <area shape="rect" coords="532,17,681,35" href="compareMetrics.php">
    <area shape="rect" coords="405,16,512,34" href="visualize_similarity_matrix.php">
    <area shape="rect" coords="129,14,247,36" href="createNewProject.php">
    <area shape="rect" coords="12,3,97,51" href="index.php">
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
		    <td><img src="img/Tutorial/img-01.jpg" width="992" height="333"><br>		      <br></td>
	      </tr>
		  <tr>
		    <td><img src="img/Tutorial/barra-09.jpg" width="990" height="3"></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-02.jpg" width="990" height="514"><br>		      
	        <br></td>
	      </tr>
		  <tr>
		    <td><img src="img/Tutorial/barra-09.jpg" width="990" height="3"></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-03.jpg" width="992" height="257"><br>		      
	        <br></td>
	      </tr>
		  <tr>
		    <td><img src="img/Tutorial/barra-09.jpg" width="990" height="3"></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-04.jpg" width="992" height="474"><br></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-05.jpg" width="992" height="343"><br></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-06.jpg" width="992" height="275"><br>		      
	        <br></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-07.jpg" width="992" height="424"><br></td>
	      </tr>
		  <tr>
		    <td><img src="img/Tutorial/barra-09.jpg" width="990" height="3"></td>
	      </tr>
		  <tr>
		    <td><br>		      <img src="img/Tutorial/img-08.jpg" width="992" height="725"></td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
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
