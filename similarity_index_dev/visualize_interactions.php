<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}	
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
		<div class="margin50"><img src="img/menu/top_visualize.jpg" width="1016" height="80" border="0" usemap="#MapMap">
		  <map name="MapMap">
		    <area shape="rect" coords="826,15,894,33" href="contact.php">
		    <area shape="rect" coords="768,16,804,34" href="help.php">
		    <area shape="rect" coords="697,17,748,34" href="guide.php">
		    <area shape="rect" coords="532,17,681,35" href="compareMetrics.php">
		    <area shape="rect" coords="405,16,512,34" href="visualize_similarity_matrix.php">
		    <area shape="rect" coords="129,14,247,36" href="createNewProject.php">
		    <area shape="rect" coords="12,3,97,51" href="index.php">
		    <area shape="rect" coords="913,14,999,34" href="php/logout_server.php">
	      </map>
		  <br>

        </div>	
		<hr>
		<div class="relative">
			<div class="width20">
				<div class="bgblue padding15 textCenter margin15"><img src="img/project.jpg" width="236" height="21"></div>
				<div class="padding5 textCenter margin15"><?php require($GLOBALS['directory']."html/projectControls.html");?></div>
				
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/interaction.jpg" width="236" height="21"></b></div>
				<div class="padding5 textCenter margin15"><button type="button" onclick="showMatrix()">Visualize Data</button></div>
				
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/network.jpg" width="236" height="21"></b></div>
				<div class="padding5 textCenter margin15"><button type="button" onclick="showNetwork()">Visualize Network</button></div>
				<div id="download_section">
					<div class="bgblue padding15 textCenter margin15" onclick=""><b><img src="img/download.jpg" width="236" height="21"></b></div>
					<div id="download" style="display:none;"></div>
				</div>
			</div>
			<div class="width80 absolute" style="left: 20%; top: 0px;">

				<div id="unclusteredPicture" style="display: none;"></div>
				<div id="interactionNetwork" height="500" width="500" style="display: none;">Cytoscape Web will replace the contents of this div with your graph.</div>
			</div>
		<div>
	
	
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
		<script>
			
			function showNetwork(){
				$("#interactionNetwork").show();
				$("#unclusteredPicture").hide();
			}
			function showMatrix(){
				$("#unclusteredPicture").show();
				$("#interactionNetwork").hide();
			}
			function hideBoth(){
				$("#unclusteredPicture").hide();
				$("#interactionNetwork").hide();
			}
			function hidedownload(){
				$("#download").hide();
			}
		</script>
		<script type="text/javascript">
			$().ready(function () { loadInteractions(); })
			
			// function show_loading_bar(){
				// $("#loading_bar").show();
			// }
			
			// function hide_loading_bar(){
				// $("#loading_bar").hide();
			// }
			
			$("#project").change(function () {loadInteractions();})
			
			function loadInteractions(){
				hidedownload();
				//show_loading_bar();
				project = $("#project").val();
				loadInteractions_image();
				readCytoscapeFile("interactionNetwork", project, "interactions", false, 0);
				hideBoth();
				//hidedownload();
			}
			
			//Trying to display the image
			function loadInteractions_image(){
				$("#unclusteredPicture").html("<img src='http://franklin-umh.cs.umn.edu/similarity_index_dev/img/ajax-loadera.gif' />");				$("#unclusteredPicture").show();

				project = $("#project").val();
				$.ajax({
					url : 'php/interactions_image.php',
					type : 'post',
					data : {
						project: project
					},
					success : function(answer){
						$("#response").html(answer);
						$("#unclusteredPicture").html("<img src='"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/interactions/interactions_headered.png' />");
						download_results();
					}
				});
				
			}	
			function download_results(){
				project = $("#project").val();
				$.ajax({
					url : 'php/vi_download.php',
					type : 'post',
					data : {
						project: project
					},
					success : function(answer){
						$("#response").html(answer);
						$("#download").show();
						downloadStr = '<button type="button" onclick="window.location.href='+"'"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/interactions/"+"download.zip'"+'">Download Data</button>';
						$("#download").html(downloadStr);
			
					}
				});
			}
		</script>
	</body>
