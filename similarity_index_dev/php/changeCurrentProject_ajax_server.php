<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);

	$projectName = $_POST["project"];

	$_SESSION['project'] = $projectName;
?>
