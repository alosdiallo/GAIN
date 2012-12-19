<?php
	session_start();
	require_once 'constants.php';
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	$user = $_SESSION['user'];
	$project = $_SESSION['project'];
	$list = $_POST['list'];
	
	// Grab session details to get the directory
	$directory = $GLOBALS['directory']."users/".$_SESSION['user']."/projects/".$_SESSION['project']."/lists/".$list."/";

	$url = $GLOBALS['url']."users/".$_SESSION['user']."/projects/".$_SESSION['project']."/lists/";
	$lists = array();
	$exec_str = "perl /heap/lab_website/similarity_index_dev/scripts/cleaner_fm.pl $directory 2>&1";
	exec($exec_str, $execOutput);
	echo "<br><br>|||<br>".$exec_str."<br>|||<br><br>";
	echo "<br><br>||<br>".print_r($execOutput)."<br>||<br><br>";
	
?>