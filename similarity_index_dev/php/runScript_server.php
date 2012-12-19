<?php
	session_start();
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);
	
	// return 0: No error
	// return 1: Bad script
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist
	function runCorrelationScript($user, $project, $script, $inverse = false){
		if($script != "hyper.pl" && $script != "geo.pl" && $script != "pearson.pl" && $script != "jaccard.pl" && $script != "mm.pl" && $script != "cluster_matrix.r" && $script != "c_index.pl" ){return 1;}
		if($user == ""){return 2;}
		if($project == ""){return 3;}
		
		
		
		
		if($script == "hyper.pl"){
			$outputFile = "hyper_results.txt";
			$baseName = "hypergeometric";
		}
		if($script == "geo.pl"){
			$outputFile = "geo_results.txt";
			$baseName = "geometric";
		}
		if($script == "pearson.pl"){
			$outputFile = "pear_results.txt";
			$baseName = "pearson";
		}
		if($script == "jaccard.pl"){
			$outputFile = "jac_results.txt";
			$baseName = "jaccard";
		}
		if($script == "mm.pl"){
			$outputFile = "mm_results.txt";
			$baseName = "simpson";
		}
		if($script == "c_index.pl"){
			$outputFile = "c_results.txt";
			$baseName = "cosine";
		}
		
		echo "<br><br><br> $baseName <br><br><br>";

		if($inverse){ 
			$inputFile = "interactionsrev_bare_matrix.txt";
			$baseName = $baseName."rev";
			$header1File = "interactions_header_horz.txt";
			$header2File = "interactions_header_horz.txt";
		} else { 
			$inputFile = "interactions_bare_matrix.txt";
			$header1File = "interactions_header_vert.txt";
			$header2File = "interactions_header_vert.txt";
		}
		echo " STAGE2 ";
		// exceptions, pass the headered matrix
		//if($script == "pearson.pl"){$inputFile = "interactions_headered.txt";}
		
		$inputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/";
		$outputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		echo " STAGE3 ";
		echo "<br><br>$inputDir creating if it doesn't exist...";
		if(file_exists($outputDir) && is_dir($outputDir)){
			// Everything is fine, don't do anything
			echo "it exists...";
		} else {
			mkdir($outputDir, 0777);
			chmod($outputDir, 0777);
		}
		
		if(file_exists($inputDir.$inputFile)){
			//$exec_str = $GLOBALS['directory']."scripts/".$script." ".escapeshellarg($inputFile)." ".escapeshellarg($inputDir);
			$exec_str = $GLOBALS['directory']."scripts/"."$script $inputFile $inputDir $outputDir 2>&1";
		
			// Rscript cluster_matrix.r /heap/lab_website/similarity_index/users/tester/projects/arda/2pearson_headered.txt
			exec($exec_str, $execOutput);
			
			convertFileFormat($user, $project, $outputFile, $baseName, $header1File, $header2File);
		} else {return 4;}
		
		print_r($execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
		return 0;
	}
	
	// return 0: No error
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist
	function runCSIScript($user, $project, $baseName, $constant, $inverse){
		if($user == ""){return 2;}
		if($project == ""){return 3;}
		
		//Alos
		if($inverse){
			$baseName = $baseName."rev";
			$header1File = "interactions_header_horz.txt";
			$header2File = "interactions_header_horz.txt";
		}
		else {
			$header1File = "interactions_header_vert.txt";
			$header2File = "interactions_header_vert.txt";
		}
		//Alos
		
		$baseID = $baseName;
		$inputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		
		
		
		$baseName = "csi".$baseName;
		
		
		if(file_exists($inputDir) && is_dir($inputDir)){
			// Everything is fine, don't do anything
		} else {
			mkdir($inputDir, 0777);
			chmod($inputDir, 0777);
		}
		
		$inputFile = $baseID."_bare_matrix.txt";

		
		$outputFile = "csi_matrix_results.txt";
		
		if(file_exists($inputDir.$inputFile)){
			//$exec_str = $GLOBALS['directory']."scripts/".$script." ".escapeshellarg($inputFile)." ".escapeshellarg($inputDir);
			$exec_str = $GLOBALS['directory']."scripts/csi_matrix.pl"." ".$inputFile." ".$constant." ".$inputDir." 2>&1";
			exec($exec_str, $execOutput);
			
			convertFileFormat($user, $project, $outputFile, $baseID, $header1File, $header2File, "csi");
		} else {return 4;}
		
		print_r($execOutput);
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
		return 0;
	}
	
	// return 0: No error
	// return 2: Bad user
	// return 3: Bad project
	// return 4: input file doesn't exist
	function runClusterScript($user, $project, $baseName, $minRange, $maxRange, $inverse, $csi = false){
		if($user == ""){return 2;}
		if($project == ""){return 3;}
		
		
		if($inverse){$baseName = $baseName."rev";}
		$inputDir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		$baseID = $baseName;
		if($csi){$baseName = "csi".$baseName;}
		
		$inputFile = $baseName."_headered.txt";
		
		if(file_exists($inputDir) && is_dir($inputDir)){
			// Everything is fine, don't do anything
		} else {
			mkdir($inputDir, 0777);
			chmod($inputDir, 0777);
		}
		
		$outputFile = "result.png";
		
		echo "\n\n".$inputDir.$inputFile."\n\n";
		
		if(file_exists($inputDir.$inputFile)){
			//$exec_str = $GLOBALS['directory']."scripts/".$script." ".escapeshellarg($inputFile)." ".escapeshellarg($inputDir);
			//exec("PATH=/opt/csw/bin/gs ./bin");
			$exec_str = $GLOBALS['directory']."scripts/"."clustering.pl $inputFile $inputDir $minRange $maxRange 2>&1";
			exec($exec_str, $execOutput);

			if(!file_exists($inputDir."result.pdf")){
				echo "RESULT.pdf DOES NOT EXIST!<br>";
			} else {
				echo "RESULT.pdf DOES EXIST!<br>";
			}
			if(file_exists($inputDir.$outputFile)){
				rename($inputDir.$outputFile, $inputDir."clustered_".$baseName.".png");
				echo "RESULT.png DOES EXIST!<br>";
			} else {
				echo "RESULT.png DOES NOT EXIST!<br>";
			}
			
			//convertFileFormat($user, $project, $outputFile, "csi_".$baseName, $header1File, $header2File);
		} else {return 4;}
		echo "<br><br>";
		print_r($execOutput);
		echo "<br><br><br>";
		echo "<br>".$exec_str."<br>";
		echo "COMPLETE"."<br>";
		return 0;
	}
?>
