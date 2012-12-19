<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);

	echo json_encode(convertFileFormat("tester", "testproject2", $GLOBALS['interactionFileName']));
	
?>
