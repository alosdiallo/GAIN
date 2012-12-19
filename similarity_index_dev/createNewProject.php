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
  <map name="MapMapMap"><area shape="rect" coords="12,3,97,51" href="index.php">
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
<div id="help_info">
<p>
Notes:<br>
- No spaces are allowed in any name (file names, gene names, etc).<br>
- If you are a Mac user the files to upload must be in UTF-8 Unicode text format.<br>
- Projects submitted will be stored. When you run an analysis, specially for large datasets, you can close your Browser and view the results later on.<br></p>

</div>
	
		<div class="relative">
			<div class="width50">
				<form action="php/uploadFile_createNewProject_server.php" method="post" enctype="multipart/form-data">
					<FIELDSET>
					  <img src="img/submit_interactions.jpg" width="184" height="9">
					  <div id="submit_jobA">
                        <P>
							Enter the name of a .txt file that contains a two column list of interactions (<a href="createNewProject_examples.php">See Example</a>)
						</P>
						</div>
						<DIV>
							<div id="submit_jobB">
							<span class="width25 floatL">File:</span><input type="file" name="fileToBeUploaded" id="fileToBeUploaded" class="width70 floatR" /><br>
							</div>
						</DIV>
					</FIELDSET>
					<FIELDSET>
						<div id="submit_jobC">
						<span class="width25 floatL">Project Name:</span> <input name="project" type="text" class="width70 floatR" id="project" /><br>
						<span class="width25 floatL">Column 1 Name:</span><input type="text" name="col2label" id="col2label" class="width70 floatR" /><br>
						<span class="width25 floatL">Column 2 Name:</span><input type="text" name="col1label" id="col1label" class="width70 floatR" /><br>
						</div>
					</FIELDSET>
					<input type="submit" name="submit" value="Upload" />
				</form>
				
			</div>
	
			<div class="width50 absolute" style="left: 50%; top: 0px;">
				<form action="php/uploadFile_createNewProject_server.php" method="post" enctype="multipart/form-data">
					<FIELDSET>
						<B><img src="img/submit_interactions_matrix.jpg" width="190" height="9"></B>
						<div id="submit_jobD">
						<P>
							Enter the name of a .txt file that contains an interaction matrix (<a href="createNewProject_examples.php">See Example</a>)
						</P>
						</div>
						<DIV>
							<div id="submit_jobE">
							<span class="width25 floatL">File:</span><input type="file" name="fileToBeUploaded" id="fileToBeUploaded" class="width70 floatR" /><br>
							</div>
						</DIV>
					</FIELDSET>
					<FIELDSET>
						<div id="submit_jobF">
						<span class="width25 floatL">Project name:</span> <input type="text" name="project" id="project" class="width70 floatR" /><br>
						<span class="width25 floatL">Column Name:</span><input type="text" name="col2label" id="col2label" class="width70 floatR" /><br>
						<span class="width25 floatL">Row Name:</span><input type="text" name="col1label" id="col1label" class="width70 floatR" /><br>
						</div>
					</FIELDSET>
					<input type="submit" name="submit" value="Upload" />
				</form>
				
			</div>
		</div>
		<br><br>
			<form>
				 <FIELDSET>
					<div class="bgblue padding15 textCenter margin15"><b><img src="img/deleteproject.jpg" width="236" height="21"></b></div>
					<p class="delete_Project">Please manually enter the name of the project which you would like to delete. <br> Please note project names are case sensitive.
					<br>This is done to ensure projects are not accidentally deleted.<p>
				   <div class="padding0 textCenter margin0"><?php require($GLOBALS['directory']."html/projectControls.html");?></div>
					<span class="width18 floatL">Project Name:</span><input type="text" name="projectlabel" id="projectlabel" class="width20 floatR" /><br>
					<p ><button type="button" onclick="delete_project()">Delete</button></p>
				 </FIELDSET>
			</form>
		
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script>
			$(document).ready(function(){ 
				setupAjaxForm('form');
			})
			
			project_name = $("#projectlabel").val();
			$("#project").change(function () {delete_project();})

			function delete_project(){
							
				project_name = $("#projectlabel").val();

				
				$.ajax({
					url : 'php/delete_project.php',
					type : 'post',
					data : {
						project_name: project_name
					},
					success : function(answer){
						$("#response").html(answer);
						
					}
					
				});
						txt="Your project ";
						txt+=project_name;
						txt+=" has been deleted.\n";
						alert(txt);

			}
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
