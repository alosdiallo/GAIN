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
<hr>
		
		<div class="relative">
			<div class="width20">
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/project.jpg" width="236" height="21"></b></div>
				<div class="padding0 textCenter margin0"><?php require($GLOBALS['directory']."html/projectControls.html");?></div>
				
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/similarity.jpg" width="236" height="21"></b></div>
				<div class="padding0 textCenter margin0"><select id='column_select'></select></div>
				
				<div class="bgblue padding15 textCenter margin15"><img src="img/index.jpg" width="236" height="21"></div>
				<div class="padding0 textCenter margin0">
					<div id="sim_names">
						<input type="checkbox" id="Hypergeometric"/> Hypergeometric<br>
						<input type="checkbox" id="Geometric"/> Geometric<br>
						<input type="checkbox" id="Pearson"/> Pearson<br>
						<input type="checkbox" id="Jaccard"/> Jaccard<br>
						<input type="checkbox" id="Simpson"/> Simpson<br>
						<input type="checkbox" id="Cosine"/> Cosine
					</div>	
					<p ><button type="button" onclick="window.location.href='questionnaire.php'">Help for choosing Index</button></p>
				</div>
				
				<div class="bgblue padding15 textCenter margin15"><b><img src="img/lists.jpg" width="236" height="21"></b></div>
				<div class="padding0 textCenter margin0">
					<select id="lists"></select>
				</div>
				
				<div id="submit">
					<div class="bgyellow padding15 textCenter margin15"><img src="img/submit.jpg" width="236" height="21"></div>
					<div class="padding0 textCenter margin0">
						<button type="button" onclick="createFileMetrics($('#lists').val())">Submit</button>
					</div>
				</div>
				<br>
				<div id="download_button_frame">
					<div class="bgblue padding15 textCenter margin15"><img src="img/download_alone.jpg" width="236" height="21"></div>
						<div class="padding0 textCenter margin0">
						<div id="download_button"></div>
					</div>
				</div>
			</div>
			<div class="width70 absolute" style="left: 20%; top: 0px;">
				<div class="width100">
					<div id="uploadForm">
						<p> In this section you can interrogate the similarity between selected node-pairs. To do this you must first upload a list of node-pairs. You can then visualize a density plot comparing the index value distribution for your selected node- pairs against the values for all possible pairs of nodes. For more details on list format to upload go to the Help section.</p>
					
						<form action="php/uploadFile_compareMetricsList_server.php" method="post" enctype="multipart/form-data">
							<input type="hidden" name="upload_filenameOnServer" value="<?php echo $GLOBALS['compareMetricsListFileName'];?>" />
							<label for="listName">List name:</label> <input type="text" name="listName">
							<label for="file">Filename:</label><input type="file" name="fileToBeUploaded" id="fileToBeUploaded" />
							<input type="submit" name="submit" value="Upload" />
						</form>
					</div>
					<hr>
				</div>
			
				<div class="padding5"><b>Note: Hypergeometric Index is Slow!</b></div>
				<div id="loading_bar"  style="display:none;">
					<div class="bgblue padding15 textCenter margin15"><img src="img/ajax-loadera.gif"></div>
				</div>	
				<div id="densityPlot">
					<img class="width80" id="density"></img>
				</div>
				
				<br><br><br>
				<div id="hist_buttons"></div>
				<br><br><br>
				
			</div>
			<div class="width10 absolute" style="left: 60%; top: 40px;">
	
		
			</div>
		</div>
		
		
		
		<!--div id="errors"></div-->
		<!--button type="button" onclick="">Upload</button-->
		
		
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript" src="js/getColumnNames_ajax.js"></script> 
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>

		<script>
			function populateLists(){
				$.ajax({
					url : 'php/getCompareMetricLists.php',
					type : 'post',
					data : {},
					success : function(answer){
						var returnAr = eval(answer);
						var lists = returnAr[0];
						var download_ready = returnAr[1];

						str = "";
						for(var i in lists){
							str = str + "<option value='"+lists[i]+"'>"+lists[i]+"</option>"
							str = str + '<button type="button" onclick="createFileMetrics('+"'"+lists[i]+"'"+')">Run</button>';
							
							if(download_ready[i]){
								//str = str + '  <a href="'+download_ready[i]+'">Download (Right Click -> Save as)</a>'; 
								str = str + '<button type="button" onclick="downloadFile('+"'"+download_ready[i]+"'"+')">Download</button>';
							}
							str = str + '<br>';
							cleaner(lists[i]);
						}
						
						$("#lists").html(str);
					}
				})
				
			}
			
			function cleaner(list){
				$.ajax({
					url : 'php/cleaner.php',
					type : 'post',
					data : {
						list: list
					
					},
					success : function(answer){
						$("#response").html(answer);
					}
				})
			}
		</script>
		<script>
			function downloadFile(url){
				location.href=url;	
				//window.location.reload(url);
			}
		
			var $idown;  // Keep it outside of the function, so it's initialized once.
			function downloadURL(url){
				if ($idown) {
					$idown.attr('src',url);
				} else {
					$idown = $('<iframe>', { id:'idown', src:url }).hide().appendTo('body');
				}
			}
		</script>
		<script>
			$(document).ready(function(){ 
				setupAjaxForm('form');
				populateLists();
			})
			
			
			
			function setupAjaxForm(identifier){
				$(identifier).ajaxForm({
					beforeSubmit: function() {},
					success: showResponse
				});
			}

			function showResponse(answer){
				if(answer == "ERROR"){
					alert("There was an error with the file upload.");
				} else if (answer == "ERROR_FILE_MOVE"){
					alert("There was an error with the file upload. The file was unable to move.");
				} else if (answer == "NO_PROJECT"){
					alert("Please make sure you have a project selected.");
				} else if (answer == "NO LIST"){
					alert("Please make sure that your list name is not blank");
				} else if (answer == "SUCCESS"){
					populateLists();
				}
			}
		</script>
			
		<script>
		
			function show_loading_bar(){
				$("#loading_bar").show();
			}
			
			function hide_loading_bar(){
				$("#loading_bar").hide();
			}
			function createFileMetrics(list){
				$("#density").hide();
				$("#hist_buttons").hide();
				
				hypergeometric = $('#Hypergeometric').is(":checked");
				geometric = $('#Geometric').is(":checked");
				pearson = $('#Pearson').is(":checked");
				jaccard = $('#Jaccard').is(":checked");
				simpson = $('#Simpson').is(":checked");
				cosine = $('#Cosine').is(":checked");

				if(!($('#Hypergeometric').is(":checked")) && !($('#Geometric').is(":checked")) && !($('#Pearson').is(":checked")) && !($('#Jaccard').is(":checked")) && !($('#Simpson').is(":checked")) && !($('#Cosine').is(":checked")))
				{
					hide_loading_bar();
					txt="You have not selected an index.\n";
					txt+="Please select an index.\n";
					txt+="Click OK to continue.\n\n";
					alert(txt);
				
				}
			
				else{
				
					if(null!= list){
						show_loading_bar();
						inverse = $("#column_select").val();
						user = '<?php echo $_SESSION['user'];?>';
						project = $("#project").val();
						
						suffix = "";
						if(inverse == "true"){suffix = "rev";}
						
						baseURL = "http://franklin-umh.cs.umn.edu/similarity_index_dev/users/" + user + "/projects/"+project+"/lists/"+list+"/";
						$.ajax({
							url : 'php/createFileMetrics_ajax_server.php',
							type : 'post',
							data : 	{ 
											hypergeometric: hypergeometric,
											geometric: geometric,
											pearson: pearson,
											jaccard: jaccard,
											simpson: simpson,
											cosine: cosine,
											list: list,
											inverse: inverse
										},
							success : function(answer){
								//populateLists();
								$("#errors").html(answer);
								
								densityStr = "";
								histButtonStr = "";
								
								if(hypergeometric){
									//densityStr = densityStr+'<img src="'+baseURL+'hypergeometric_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'hypergeometric'+suffix+'_density.png'+"'"+')">Hypergeometric</button>';
								}
								if(geometric){
									//densityStr = densityStr+'<img src="'+baseURL+'geometric_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'geometric'+suffix+'_density.png'+"'"+')">Geometric</button>';
								}
								if(pearson){
									//densityStr = densityStr+'<img src="'+baseURL+'pearson_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'pearson'+suffix+'_density.png'+"'"+')">Pearson</button>';
								}
								if(jaccard){
									//densityStr = densityStr+'<img src="'+baseURL+'jaccard_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'jaccard'+suffix+'_density.png'+"'"+')">Jaccard</button>';
								}
								if(simpson){
									//densityStr = densityStr+'<img src="'+baseURL+'simpson_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'simpson'+suffix+'_density.png'+"'"+')">Simpson</button>';
								}
								if(cosine){
									//densityStr = densityStr+'<img src="'+baseURL+'cosine_density.png'+'" />';
									histButtonStr = histButtonStr + '<button type="button" onclick="displayHistogram('+"'"+baseURL+'cosine'+suffix+'_density.png'+"'"+')">Cosine</button>';
								}
								$("#hist_buttons").show();
								$("#hist_buttons").html(histButtonStr);
								

								downloadButtonStr = '<button type="button" onclick="window.location.href='+"'"+baseURL+'download.zip'+"'"+'">Download</button>';
								$("#download_button").html(downloadButtonStr);
				
								hide_loading_bar();
								
							}
						})
					}
					else{
						hide_loading_bar();
						txt="You have not selected a list.\n";
						txt+="Please select a list.\n";
						txt+="Click OK to continue.\n\n";
						alert(txt);
					}
					
				}
			}
			
			function displayHistogram(url){
				$("#density").show();
				str = '<img src="'+url+'" />';
				//$("#densityPlot").html(str);
				$("#density").attr({src: url});
				$('#density').error(function() {
					$("#density").hide();
					$("#hist_buttons").hide();
					alert('The list of node-pairs selected does not match with your selection in the \'Similarity according to\' tab');
				});
				
				
			}
		</script>
		
		
	</body>
</html>
