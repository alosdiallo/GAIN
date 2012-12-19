<?php
	session_start();
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);

	$returnOnSuccess = "SUCCESS";
	$returnOnFailure = "ERROR";
	
	// If the user is not logged on, redirect to login page.
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}

	// Make sure there wasn't an error
	if ($_FILES["fileToBeUploaded"]["error"] > 0){
		echo "ERROR";
		return 1;
	}
	
	$temporaryFileName = $_FILES["fileToBeUploaded"]["tmp_name"];
	$user = $_SESSION['user'];
	$project = escapeshellcmd($_POST["project"]);
	$filenameOnServer = $GLOBALS['interactionFileName'];
	
	$col1Label = $_POST["col1label"];
	$col2Label = $_POST["col2label"];
	
	if($project == ""){
		echo "The project must have a name.";
		return 1;
	}
	if($col1Label == ""){
		echo "You must have a label for column 1.";
		return 1;
	}
	if($col2Label == ""){
		echo "You must have a label for column 2.";
		return 1;
	}
	if($col1Label == $col2Label){
		echo "The labels for the two columns cannot be the same.";
		return 1;
	}
	
	
		
	// Ok, let's create this project now
	
	// Make sure the project and user are set.
	if($user == ""){
		echo "NO_USER";
		return 1;
	}
	if($project == ""){
		echo "NO_PROJECT";
		return 1;
	}
		
	$dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/";
		
	// Make sure the directory doesn't already exist
	if(file_exists($dir)){
		// Directory already exists
		echo "Directory Already Exists";
		return 1;
	}
	
	// Create the project folder inside the users projects directory
	mkdir($dir, 0777);
	chmod($dir, 0777);
	
	// Make a file that holds the column information for the project
	$colHandle = fopen($dir."columnInformation.txt", "w");
	fwrite($colHandle, $col1Label."\n".$col2Label);
	fclose($colHandle);
	
	// Make the interactions folder
	$dir = $dir."interactions/";
	mkdir($dir, 0777);
	chmod($dir, 0777);
		
	if(move_uploaded_file($temporaryFileName, $dir.$filenameOnServer)){
		//Move file was successful
		chmod($dir.$filenameOnServer, 0777);
		$convertErrorCode = convertFileFormat($user, $project, $filenameOnServer, $GLOBALS['interactionFileBaseName']);
		
		/*if($orientation == "reverse"){
			$convertErrorCode = convertFileFormat_reverse($user, $project, $filenameOnServer, $GLOBALS['interactionFileBaseName']);
		} else {
			$convertErrorCode = convertFileFormat($user, $project, $filenameOnServer, $GLOBALS['interactionFileBaseName']);
		}*/
		echo $returnOnSuccess;
	} else {
		//Move file was unsuccessful
		rmdir($dir);
		echo $returnOnFailure;
	}
?>
