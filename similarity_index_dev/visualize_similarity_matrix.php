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
		<div class="margin50"><img src="img/menu/top_modules.jpg" width="1016" height="80" border="0" usemap="#MapMap">
		  <map name="MapMap">
		    <area shape="rect" coords="826,15,894,33" href="contact.php">
		    <area shape="rect" coords="768,16,804,34" href="help.php">
		    <area shape="rect" coords="697,17,748,34" href="guide.php">
		    <area shape="rect" coords="532,17,681,35" href="compareMetrics.php">
		    <area shape="rect" coords="129,14,247,36" href="createNewProject.php">
		    <area shape="rect" coords="12,3,97,51" href="index.php">
		    <area shape="rect" coords="913,14,999,34" href="php/logout_server.php">
		    <area shape="rect" coords="271,18,389,36" href="visualize_interactions.php">
	      </map>
		  <br>

        </div>
		<hr>
		
		<div class="relative">
			<div class="width20">
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/project.jpg" width="236" height="21"></b></div>
				<div class="padding0 textCenter margin0"><?php require($GLOBALS['directory']."html/projectControls.html");?></div>
				
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/similarity.jpg" width="236" height="21"></b></div>
				<div class="padding0 textCenter margin0"><select id='column_select'></select></div>
				
				<div class="bgblue padding15 textCenter margin15"><img src="img/index.jpg" width="236" height="21"></div>
				<div class="padding0 textCenter margin0">
					<select id="script_select">
						<option value='pearson.pl'>Pearson</option>
						<option value='geo.pl'>Geometric</option>
						<option value='jaccard.pl'>Jaccard</option>
						<option value='mm.pl'>Simpson</option>
						<option value='c_index.pl'>Cosine</option>
						<option value='hyper.pl'>Hypergeometric</option>
					</select><br>
					<div id="use_csi">
						<input type="checkbox" id="useCSI"/> CSI <input type="text" size=1 id="CSIconstant" value="0.05"/><br>
					</div>		
				</div>


				<div class="bgyellow padding15 textCenter margin15"><img src="img/submit.jpg" width="236" height="21"></div>
				<div class="padding0 textCenter margin0"><button type="button" onclick="runCorrelationScript()">Submit</button></div>
				<input type="checkbox" id="forceRerun"/> Recalculate Values<br>
				<br>
					<div id="options"  style="display:none;">
					<div class="bgblue padding15 textCenter margin15"><img src="img/Options.jpg" width="236" height="21"></div>
					<div class="padding0 textCenter margin0">

						<b>Range for your HeatMap</b><br>
						<div id="min_range">
						min: <input type="text" id="minRange" value="0"/><br>
						</div>
						max: <input type="text" id="maxRange" value="1"/><br>
					</div>
					<P>To see your changes click submit again.</p><br>
				</div>
	
				<div id="visualize"  style="display:none;">
					<div class="bgblue padding15 textCenter margin15"><img src="img/visualize.jpg" width="236" height="21"></div>
					<div class="padding15 textCenter margin15">
						<button type="button" name="unclustered" onclick="loadUnClusteredHeatmap($('#script_select').val())" id="unclustered" style="display:none;"> Unclustered Heatmap</button>
						
						<button type="button" name="network_cy" onclick="loadNetwork($('#script_select').val())" id="network_cy" style="display:none;">Network</button>

						<button type="button" name="clustered" onclick="loadClusteredHeatmapAndDendrogram($('#script_select').val())" id="clustered" style="display:none;"> Clustered Heatmap</button>


					</div>
				</div>				
				<div id="download_results">
						<div class="bgblue padding15 textCenter margin15"><img src="img/download_alone.jpg" width="236" height="21"></div>
						<div id="unclustered_download" style="display:none;"></div>
				</div>
			</div>
			<div class="width80 absolute" style="left: 20%; top: 0px;">
				<div id="interactionNetworkDiv" style="display:none;">
					<div id="cutoffDiv" style="display: none;">
						Threshold: <input type="text" size=1 id="cutoff" value="0.2"/><button type="button" onclick="reloadCytoscape()">Reload</button>
					</div>
					<div id="interactionNetwork"></div>
				</div>
				<div id="loading_bar"  style="display:none;">
					<div class="bgblue padding15 textCenter margin15"><img src="img/ajax-loadera.gif"></div>
				</div>	
				<div id="clusteredPicture" style="display:none;"></div>
				<div id="resultPicture" style="display:none;"></div>
				<div id="dendrogram" style="display:none;"></div>
				
			</div>
		<div>
		<!--div id="response"></div-->
		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>
		
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
		<script type="text/javascript" src="js/getColumnNames_ajax.js"></script> 
		<script>
			function setColumns(col1, col2){
				str = "";
				str = str + "<option value=''>"+col1+"</option>";
				str = str + "<option value='true'>"+col2+"</option>";
				$("#column_select").html(str);
			}

			//document.onload = goDoStuff();
			//getColumnNames_ajax();
			$(document).ready(function(){
				getColumnNames_ajax();
			})
			function afterColumnNames(){
				setColumns(column_names[0],column_names[1]);
			}
		</script>
		
		
		
		<script>
			function downloadFile(project){
				user = '<?php echo $_SESSION['user']?>';
				url = '<?php echo $GLOBALS['url']?>' + "users/" + user + "/projects/" + project + "/download.zip";
				location.href=url;
			}
		</script>
		<script>
			// This script is for tests
			function runTest(){
				project = $("#project").val();
				testText = $("#testText").val();
				
				$.ajax({
					url : 'php/test_server.php',
					type : 'post',
					data : {
						project: project,
						testText: testText,
						
					},
					success : function(answer){
						$("#response").html(answer);
					}
				});
			}
		</script>
		<script>
			var lastProject = "";
			var lastBaseName = "";
			var baseName = "";
			
			function show_loading_bar(){
				$("#loading_bar").show();
			}
			
			function hide_loading_bar(){
				$("#loading_bar").hide();
			}

			function cleaner(){
				script = $("#script_select").val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				inverse = $('#column_select').val();

				$.ajax({
					url : 'php/cleanerFM.php',
					type : 'post',
					data : {
						baseName: baseName,
						inverse: inverse						
					
					},
					success : function(answer){
						$("#response").html(answer);			
					}
				})
			}
			
			function runCorrelationScript(){
				$("#interactionNetworkDiv").hide();
				$("#resultPicture").hide();
				$("#dendrogram").hide();
				$("#clusteredPicture").hide();				
				show_loading_bar();
				$("#unclustered_download").hide();
				script = $("#script_select").val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				
				project = $("#project").val();
				cutoff = $("#cutoff").val();
				forceRerun = $('#forceRerun').is(":checked");
				useCSI = $('#useCSI').is(":checked");
				inverse = $('#column_select').val();
				CSIconstant = $("#CSIconstant").val();
				

				maxRange = $("#maxRange").val();
				minRange = $("#minRange").val();
				
				$("#visualize").show();
				if(isNaN(CSIconstant)){
					CSIconstant = 0.5;
				}
				if(isNaN(cutoff)){
					cutoff = 0;
				}	
				
				$.ajax({
					url : 'php/visSimMatrixRunScript_ajax_server.php',
					type : 'post',
					data : {
						script: script,
						forceRerun: forceRerun,
						useCSI: useCSI,
						CSIconstant: CSIconstant,
						inverse: inverse,
						minRange: minRange,
						maxRange: maxRange
					},
					success : function(answer){
						$("#response").html(answer);
						baseID = baseName;
						if(useCSI){
							baseName = "csi"+baseName;
						}
						// if(baseName == "pearson"){
							// $("#min_range").hide();
						// }
						// if(baseName != "pearson"){
							// $("#min_range").show();
						// }						
						
						if(inverse == "true"){
							baseName = baseName+"rev";
							baseID = baseID+"rev";
							// if(baseName == "pearsonrev"){
								// $("#min_range").hide();
							// }
							// if(baseName != "pearsonrev"){
								// $("#min_range").show();
							// }
						}
						
						
						readMatrixFile("interactionTable", project, baseName, true, false);
						if(useCSI){
							readCytoscapeFileCSI("interactionNetwork", project, baseID, true, cutoff);
						} else {
							readCytoscapeFile("interactionNetwork", project, baseID, true, cutoff);
						}
						clusterImageStr = "<img src='"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseID+"/"+baseName+"_headered.png' />";
						dendrogramImageStr = "<img src='"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseID+"/"+baseName+"_dendrogram.png' />";
						resultPictureImageStr = "<img src='"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseID+"/"+baseName+"_clustered_headered.png' />";
						
						downloadStr = '<button type="button" onclick="window.location.href='+"'"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseName+"/"+"download.zip'"+'">Download</button>';
						
						$("#clusteredPicture").html(clusterImageStr);
						$("#dendrogram").html(dendrogramImageStr);
						$("#resultPicture").html(resultPictureImageStr);
						$("#download").html(downloadStr);

						lastProject = project;
						lastBaseName = baseName;
						
						hide_loading_bar();
						document.getElementById("unclustered").style.display = "block";
						document.getElementById("network_cy").style.display = "block";
						document.getElementById("clustered").style.display = "block";
						document.getElementById("download").style.display = "block";

	
					}
				});
				
				//loadClusteredHeatmapAndDendrogram(baseName);
				
			}

			function reloadCytoscape(){
				inverse = $('#column_select').val();
				script = $("#script_select").val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				baseID = baseName;
				
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";
					if(baseName == "pearsonrev"){
						$("#min_range").hide();
					}
					if(baseName != "pearsonrev"){
						$("#min_range").show();
					}
				}
				
				
				

				
				project = $("#project").val();
				cutoff = $("#cutoff").val();
				if(isNaN(cutoff)){
					cutoff = 0;
				}
				
				
				if(useCSI){
					readCytoscapeFileCSI("interactionNetwork", project, baseID, true, cutoff);
				} else {
					readCytoscapeFile("interactionNetwork", project, baseID, true, cutoff);
				}
				lastProject = project;
				lastBaseName = baseName;

			}
			
			
			
			function loadUnClusteredHeatmap(){
				script = $("#script_select").val();
				inverse = $('#column_select').val();

				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";
				}				
				$("#options").show();
				$("#resultPicture").hide();
				$("#cutoffDiv").hide();
				$("#interactionNetworkDiv").hide();
				$("#dendrogram").hide();
				$("#clusteredPicture").show();
				unclustered_download_func();
				$("#unclustered_download").show();
				
			}
			$("#script_select").change(function () {unclustered_download_func();})
			
			function unclustered_download_func(){
				$("#unclustered_download").hide();
				script = $("#script_select").val();
				inverse = $('#column_select').val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";
				}
				
				downloadStrNew = '<button type="button" onclick="window.location.href='+"'"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseName+"/"+"unclustered.zip'"+'">Unclustered download</button>';
				$("#unclustered_download").html(downloadStrNew);
				lastProject = project;
				lastBaseName = baseName;			
			
			
			}
			
			
			
			
			function loadClusteredHeatmapAndDendrogram(){
				script = $("#script_select").val();
				inverse = $('#column_select').val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";
				}				
				$("#options").show();
				$("#clusteredPicture").hide();
				$("#dendrogram").show();
				$("#cutoffDiv").hide();
				$("#interactionNetworkDiv").hide();			
				$("#resultPicture").show();	
				loadClusteredHeatmapAndDendrogram_func();
				lastProject = project;
				lastBaseName = baseName;
				$("#unclustered_download").show();				
			}
			
			$("#script_select").change(function () {loadClusteredHeatmapAndDendrogram_func();})
			function loadClusteredHeatmapAndDendrogram_func(){
				$("#unclustered_download").hide();
				script = $("#script_select").val();
				inverse = $('#column_select').val();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";
				}				
				
				downloadStrNew = '<button type="button" onclick="window.location.href='+"'"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseName+"/"+"clustered.zip'"+'">Clustered download</button>';
				$("#unclustered_download").html(downloadStrNew);
				lastProject = project;
				lastBaseName = baseName;		
			
			
			}			

			
			function loadNetwork(){
				script = $("#script_select").val();
				inverse = $('#column_select').val();

				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";

				}				
				$("#options").hide();
				$("#cutoffDiv").show();
				$("#interactionNetworkDiv").show();
				$("#resultPicture").hide();
				$("#dendrogram").hide();
				$("#clusteredPicture").hide();
				lastProject = project;
				lastBaseName = baseName;
				loadNetwork_func();	
				$("#unclustered_download").show();
			
			}
			
			$("#script_select").change(function () {loadNetwork_func();})
			function loadNetwork_func(){
				script = $("#script_select").val();
				inverse = $('#column_select').val();
				$("#unclustered_download").hide();
				if(script == 'hyper.pl'){baseName = 'hypergeometric';}
				if(script == 'geo.pl'){baseName = 'geometric';}
				if(script == 'pearson.pl'){baseName = 'pearson';}
				if(script == 'jaccard.pl'){baseName = 'jaccard';}
				if(script == 'mm.pl'){baseName = 'simpson';}
				if(script == 'c_index.pl'){baseName = 'cosine';}
				if(inverse == "true"){
					baseName = baseName+"rev";
					baseID = baseID+"rev";

				}				

				
				downloadStrNew = '<button type="button" onclick="window.location.href='+"'"+baseurl+"users/<?php echo($_SESSION['user']);?>/projects/"+project+"/"+baseName+"/"+"network.zip'"+'">Network download</button>';
				$("#unclustered_download").html(downloadStrNew);
				$("#unclustered_download").hide();				
				lastProject = project;
				lastBaseName = baseName;			
			}
			
			
			
		</script>
	</body>
