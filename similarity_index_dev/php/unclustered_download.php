<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);
	$user = $_SESSION['user'];
	$project = $_SESSION['project'];
	$baseName = $_POST['baseName'];
	$type_name = $_POST['type_name'];
	$inverse = $_POST['inverse'];
	
	// return 0: No error
	// return 1: Bad script
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist

		if($user == ""){return 2;}
		if($project == ""){return 3;}
		if($inverse == "true"){
			$baseName = $baseName."rev";
		}
		$inputFile = $baseName."_headered.png";
		$inputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		if($type_name == "UnClustered"){
			if(file_exists($inputDir.$inputFile)){
				$exec_str = "perl ".$GLOBALS['directory']."scripts/unclustered_download.pl $inputFile $inputDir 2>&1";
				exec($exec_str);
			} else {
					echo "unclustered_download.pl DOES EXIST!<br>";
					echo "<br>".$inputFile."<br>";
					echo "<br>".$inputDir."<br>";
			}
		}
		if($type_name == "Clustered"){
			if(file_exists($inputDir.$inputFile)){
				$exec_str = "perl ".$GLOBALS['directory']."scripts/clustered_download.pl $inputFile $inputDir 2>&1";
				exec($exec_str);
			} else {
					echo "unclustered_download.pl DOES EXIST!<br>";
					echo "<br>".$inputFile."<br>";
					echo "<br>".$inputDir."<br>";
			}
		}
		if($type_name == "Network"){
			if(file_exists($inputDir.$inputFile)){
				$exec_str = "perl ".$GLOBALS['directory']."scripts/network_download.pl $inputFile $inputDir 2>&1";
				exec($exec_str);
			} else {
					echo "unclustered_download.pl DOES EXIST!<br>";
					echo "<br>".$inputFile."<br>";
					echo "<br>".$inputDir."<br>";
			}
		}
		exec($exec_str, $execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
	
?>