<?php
	$directory = "/heap/lab_website/similarity_index_dev/";
	$url = "http://franklin-umh.cs.umn.edu/similarity_index_dev/";
	//if($GLOBALS['debug'] >= 1){echo();}
	// Debug level 0 = production
	// Debug level 1 = specific test
	// Debug level 2 = global test
	// Debug Level 3 = All test
	$debug = 2;
	
	$standardDelimiter = "\t";

	// Required files to be uploaded to the server, This will store their names on the server
	$interactionFileName = "interactions.txt";
	$compareMetricsListFileName = "list.txt";
	// Base Names
	$interactionFileBaseName = "interactions";
?>
