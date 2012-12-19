<?php
	session_start();
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);

	$returnOnSuccess = "SUCCESS";
	$returnOnFailure = "ERROR";

	//echo "Success!\n";
	if ($_FILES["fileToBeUploaded"]["error"] > 0){
		echo "ERROR";
	} else {
		$temporaryFileName = $_FILES["fileToBeUploaded"]["tmp_name"];
		$project = $_SESSION['project'];
		$filenameOnServer = $_POST["upload_filenameOnServer"];
		$user = $_SESSION['user'];
		
		if($project == ""){
			echo "NO_PROJECT";
		} else {
			if(move_uploaded_file($temporaryFileName, $GLOBALS['directory']."users/".$user."/projects/".$project."/".$filenameOnServer)){
				//Move file was successful
				chmod($GLOBALS['directory']."users/".$user."/projects/".$project."/".$filenameOnServer, 0777);
				$convertErrorCode = convertFileFormat($user, $project, $filenameOnServer, $GLOBALS['interactionFileBaseName']);
				echo $returnOnSuccess;
			} else {
				//Move file was unsuccessful
				echo $returnOnFailure;
			}
		}
  }
?>
