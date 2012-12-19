<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);
	$user = $_SESSION['user'];
	$project_name = $_POST['project_name'];
	// return 0: No error
	// return 1: Bad script
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist

	if($user == ""){return 2;}
	if($project_name == ""){return 3;}

	// If the user is not logged on, redirect to login page.
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}
	
	$inputDir = $GLOBALS['directory']."users/".$user."/projects/";	
	$dir = $GLOBALS['directory']."users/".$user."/projects/".$project_name;
	if(file_exists($dir)){
		echo "Directory Exists Deleting Project!!!!!"."<br>";

		$exec_str = "perl ".$GLOBALS['directory']."scripts/delete_project.pl $inputDir $dir $project_name 2>$1";
		exec($exec_str, $execOutput);
		print_r($execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";

	} else {
		echo "The project does not exist.";
	}
?>