<?php
	session_start();
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);

	$user = $_SESSION['user'];
	$project = $_SESSION['project'];
	$input = $_POST['testText'];
	$minRange = $_POST['minRange'];
	$maxRange = $_POST['maxRange'];
	////////////////////////////////////////////////////////
	// NOTE THIS PAGE MAY BE OBSOLETE!!!!!!!!!!
	///////////////////////////////////////
	//Rscript cluster_matrix.r /heap/lab_website/similarity_index/users/tester/projects/arda/2pearson_headered.txt
	
	//$exec_str = $GLOBALS['directory']."scripts/".$script." ".$inputFile." ".$inputDir." 2>&1";
	$exec_str = '/heap/opt/bin/Rscript '.$GLOBALS['directory'].'scripts/'.'cluster_matrix.r '.$GLOBALS['directory'].'users/'.$user."/projects/".$project."/".$input.' 2>&1';
	exec($exec_str, $execOutput);

		print_r($execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
?>
