<?php
	session_start();
	require_once 'constants.php';
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	
	// Grab session details to get the directory
	$directory = $GLOBALS['directory']."users/".$_SESSION['user']."/projects/".$_SESSION['project']."/lists/";

	$url = $GLOBALS['url']."users/".$_SESSION['user']."/projects/".$_SESSION['project']."/lists/";
	$lists = array();
	$downloads_ready = array();
	if(file_exists($directory) && is_dir($directory)){

		// Find everything in the folder as lists
		if ($handle = opendir($directory)) {
	   	while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "/") {
					array_push($lists, $entry);
					//echo $entry;
					//echo "\n";
					//array_push($downloads_ready, 1);
					if(file_exists($directory.$entry."/download.csv")){
						array_push($downloads_ready, $url.$entry."/download.csv");
					} else {
						array_push($downloads_ready, 0);
					}
				}
			}

			closedir($handle);
		}
		
		// return those lists
	}

	echo json_encode(array($lists, $downloads_ready));

	
?>
