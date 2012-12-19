<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);

	$user = $_SESSION['user'];
	$project = $_SESSION['project'];
	
	$file = $GLOBALS['directory']."users/".$user."/projects/".$project."/columnInformation.txt";
	if(file_exists($file)){
		if($fh = fopen($file, "r")){
			$contents = fread($fh, filesize($file));
			fclose($fh);
			echo json_encode(explode("\n", $contents));
		} else {
			echo "FAILED_OPEN";
		}
	} else {
		echo "FAILED_OPEN";
	}
	
	
?>