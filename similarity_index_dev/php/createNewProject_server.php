<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);

	// If the user is not logged on, redirect to login page.
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}

	$projectName = $_POST["newProjectName"];
	$permissionForImprovement = isset($_POST["permissionForImprovement"]);
	$user = $_SESSION['user'];
	
	$dir = $GLOBALS['directory']."users/".$user."/projects/".$projectName;
	if(file_exists($dir)){
		// Directory already exists
		echo "Directory Already Exists";
	} else {
		// Create the project folder inside the users projects directory
		mkdir($dir, 0777);
		chmod($dir, 0777);
		header('Location: '.$GLOBALS['url']);
	}
?>
