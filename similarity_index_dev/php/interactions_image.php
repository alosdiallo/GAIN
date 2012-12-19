<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);
	$user = $_SESSION['user'];
	$project = $_POST['project'];
	// return 0: No error
	// return 1: Bad script
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist
	//I removed the &1 Alos Diallo 12/13/12
		if($user == ""){return 2;}
		if($project == ""){return 3;}
		$inputFile = "interactions_headered.txt";
		$inputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/";
		if(file_exists($inputDir.$inputFile)){
			$exec_str = "perl ".$GLOBALS['directory']."scripts/make_image.pl $inputFile $inputDir 2>$1";
			exec($exec_str, $execOutput);
		} else {
				echo "make_image.pl DOES NOT EXIST!<br>";
			}
		print_r($execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
	
?>