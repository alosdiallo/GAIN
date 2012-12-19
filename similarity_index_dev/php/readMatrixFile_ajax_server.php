<?php
	session_start();
	require_once 'constants.php';
	require_once 'readFile_server.php';
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	if(!isset($_POST['headered'])){$_POST['headered'] = false;}
	if(isset($_POST['project'])){
		$project = $_POST['project'];
	} else {
		$project = $_SESSION['project'];
	}
	if($_POST['headered'] == "true"){
		$headered = true;
	} else {
		$headered = false;
	}
		
	
	echo json_encode(readMatrixFile($_SESSION['user'], $project, $_POST['fileBase'], $headered));
?>