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
		<style>
			/* The Cytoscape Web container must have its dimensions set. */
			#interactionNetwork { 
				width: 800px; 
				height: 600px; 
				border-style:solid;
				border-width:5px;
			}
		</style>
	</head>
	<body>
		<?php require($GLOBALS['directory']."html/loginControls.php");?>
		<?php require($GLOBALS['directory']."html/backToHomeButton.html");?>		
		<hr>
		<?php require($GLOBALS['directory']."html/projectControls.html");?>
		<hr>
		<!--button type="button" onclick="loadInteractions()">Reload Interactions with current project.</button-->
		
		<!--Display the image-->
		
		<div id="unclusteredPicture"></div>
		<!--Display the image-->
		<div id="tableVizualization">
			<table id="interactionTable" border="1"></table> 
		</div>
		<div id="interactionNetwork" height="500" width="500" style="display: none;">Cytoscape Web will replace the contents of this div with your graph.</div>

		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		<script type="text/javascript"> baseurl = "<?php echo $GLOBALS['url']?>"; </script>
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript" src="js/getInteractionData_ajax.js"></script> 
		<script type="text/javascript" src="js/setupInteractionTable.js"></script> 
		
		<!-- JSON support for IE (needed to use JS API) -->
		<script type="text/javascript" src="js/min/json2.min.js"></script>
        
		<!-- Flash embedding utility (needed to embed Cytoscape Web) -->
		<script type="text/javascript" src="js/min/AC_OETags.min.js"></script>
        
		<!-- Cytoscape Web JS API (needed to reference org.cytoscapeweb.Visualization) -->
		<script type="text/javascript" src="js/min/cytoscapeweb.min.js"></script>
		
		<script type="text/javascript" src="js/readMatrixFile.js"></script> 
		<script type="text/javascript" src="js/readCytoscapeFile.js"></script> 
		<script type="text/javascript">
			window.onload = loadInteractions();
			
			$("#project").change(function () {loadInteractions();})
			
			window.onload = loadInteractions_image();
			
			$("#project").change(function () {loadInteractions_image();})

			
			function loadInteractions(){
				project = $("#project").val();
				//readMatrixFile("interactionTable", project, "interactions", true, true);
			}
			
			//Trying to display the image
			function loadInteractions_image(){
				project = $("#project").val();
					$.ajax({
					url : 'php/interactions_image.php',
					type : 'post',
					data : {
						
					},
					success : function(answer){
						$("#response").html(answer);
					}
				});
				
				//$("#interactionTable").hide();
				$("#unclusteredPicture").html("<img src='"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/interactions/interactions_headered.png' />");

				
			}
		</script>	

			
	</body>
