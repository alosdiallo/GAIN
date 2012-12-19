<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);
	
	// Error code 0: No Error
	// Error code 1: File doesn't exist
	function convertFileFormat($user, $project, $file, $baseFileName, $headers1Name = "", $headers2Name = "", $prefix = ""){
	
		$inputFile = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseFileName."/".$file;
		$baseFile = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseFileName."/".$prefix.$baseFileName;
		
		$headers1File = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/".$headers1Name;
		$headers2File = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/".$headers2Name;
		
		if(!file_exists($inputFile)){ return 1;};
		// Detect file type...
		$inputFileHandle = fopen($inputFile, "r");
		
		$firstLine = fgets($inputFileHandle);
		$secondLine = fgets($inputFileHandle);
		$firstLineParameters = explode("\t", $firstLine);
		$secondLineParameters = explode("\t", $secondLine);
		fclose($inputFileHandle);

		/// firstLine, first value is blank or genes, second value is alpha
		/// secondLine, first value is alpha
		/// Means the file is a headered matrix
		if( (trim($firstLineParameters[0]) == "" || trim($firstLineParameters[0]) == "genes") && !is_numeric(trim($firstLineParameters[1])) && !is_numeric(trim($secondLineParameters[0])) && is_numeric(trim($secondLineParameters[1]))){
			convertHeaderedMatrixToMatrix($inputFile, $baseFile."_bare_matrix.txt");
			convertHeaderedMatrixToList($inputFile, $baseFile."_list.txt");
			convertListToHeaderedMatrix($baseFile."_list.txt", $baseFile."_headered.txt");
			createHeaderFileFromHeaderedMatrix($baseFile."_headered.txt", $baseFile."_header_horz.txt", $baseFile."_header_vert.txt");

			createReverseMatrix($baseFile."_headered.txt", $baseFile."rev_headered.txt");
			createReverseMatrix($baseFile."_bare_matrix.txt", $baseFile."rev_bare_matrix.txt");
			createReverseList($baseFile."_list.txt", $baseFile."rev_list.txt");

			createFullAssociationfromList($baseFile."_list.txt", $baseFile."_association_full.txt");
		}
		
		/// firstLine, first value is alpha, second value is alpha
		/// secondLine, first value is alpha, second value is alpha
		/// Means the file is a list
		if(!is_numeric(trim($firstLineParameters[0])) && !is_numeric(trim($firstLineParameters[1])) && !is_numeric(trim($secondLineParameters[0])) && !is_numeric(trim($secondLineParameters[1]))){
			convertListToHeaderedMatrix($inputFile, $baseFile."_headered.txt");
			convertHeaderedMatrixToMatrix($baseFile."_headered.txt", $baseFile."_bare_matrix.txt");
			convertHeaderedMatrixToList($baseFile."_headered.txt", $baseFile."_list.txt");
			createHeaderFileFromHeaderedMatrix($baseFile."_headered.txt", $baseFile."_header_horz.txt", $baseFile."_header_vert.txt");
			
			createReverseMatrix($baseFile."_headered.txt", $baseFile."rev_headered.txt");
			createReverseMatrix($baseFile."_bare_matrix.txt", $baseFile."rev_bare_matrix.txt");
			createReverseList($baseFile."_list.txt", $baseFile."rev_list.txt");

			createFullAssociationfromList($baseFile."_list.txt", $baseFile."_association_full.txt");
		}
		
		/// firstLine, first value is number, second value is number
		/// secondLine, first value is number, second value is number
		/// Means the file is a headerless matrix
		if(is_numeric(trim($firstLineParameters[0])) && is_numeric(trim($firstLineParameters[1])) && is_numeric(trim($secondLineParameters[0])) && is_numeric(trim($secondLineParameters[1]))){
			if($headers1Name != "" && $headers2Name != ""){
				echo "\n\n".$headers1Name;
				echo "\n\n".$headers2Name;
				convertMatrixToHeaderedMatrix($inputFile, $baseFile."_headered.txt", $headers1File, $headers2File);
				convertHeaderedMatrixToMatrix($baseFile."_headered.txt", $baseFile."_bare_matrix.txt");
				convertHeaderedMatrixToList($baseFile."_headered.txt", $baseFile."_list.txt");
				createHeaderFileFromHeaderedMatrix($baseFile."_headered.txt", $baseFile."_header_horz.txt", $baseFile."_header_vert.txt");
				
				createReverseMatrix($baseFile."_headered.txt", $baseFile."rev_headered.txt");
				createReverseMatrix($baseFile."_bare_matrix.txt", $baseFile."rev_bare_matrix.txt");
				createReverseList($baseFile."_list.txt", $baseFile."rev_list.txt");

				createFullAssociationfromList($baseFile."_list.txt", $baseFile."_association_full.txt");
			} else {
				echo "Need Header File";
			}
		}

	}

	function createFullAssociationfromList($inputFile, $outputFile){
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		while(($inputLine = fgets($inputFileHandle)) !== false){
			$lineParameters = explode("\t", trim($inputLine));
			if(isset($lineParameters[2])){
				fwrite($outputFileHandle, $lineParameters[2]."\n");
			}
		}
		
		fclose($inputFileHandle);
		fclose($outputFileHandle);
		
		chmod($outputFile, 0777);
	}
	
	function createReverseList($inputFile, $outputFile){
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		while(($inputLine = fgets($inputFileHandle)) !== false){
			$lineParameters = explode("\t", trim($inputLine));
			fwrite($outputFileHandle, $lineParameters[1]."\t".$lineParameters[0]);
			if(isset($lineParameters[2])){
				fwrite($outputFileHandle, "\t".$lineParameters[2]);
			}
			fwrite($outputFileHandle, "\n");
		}
		
		fclose($inputFileHandle);
		fclose($outputFileHandle);
		
		chmod($outputFile, 0777);
	}
	
	function createHeaderFileFromHeaderedMatrix($inputFile, $headers1File, $headers2File){
		if(!file_exists($inputFile)){ return false;};
		
		$inputFileHandle = fopen($inputFile, "r");
		$headers1FileHandle = fopen($headers1File, "w");
		$headers2FileHandle = fopen($headers2File, "w");
		
		$headerLine = fgets($inputFileHandle);
		$headerLineArray = explode("\t", trim($headerLine));
		
		foreach($headerLineArray as $element){
			if($element != "genes"){
				fwrite($headers1FileHandle, $element."\n");
			}
		}
		
		while(($inputLine = fgets($inputFileHandle)) !== false){
			$lineArray = explode("\t", trim($inputLine));
			
			fwrite($headers2FileHandle, $lineArray[0]."\n");
		}
	
		fclose($inputFileHandle);
		fclose($headers1FileHandle);
		fclose($headers2FileHandle);
		
		chmod($headers1File, 0777);
		chmod($headers2File, 0777);
	}
	
	function createReverseMatrix($inputFile, $outputFile){
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		$matrixValues = array();
		
		$i = 0;
		$j = 0;
		
		while(($inputLine = fgets($inputFileHandle)) !== false){
			$lineParameters = explode("\t", trim($inputLine));
			$matrixValues[$i] = $lineParameters;
			$i++;
		}
		
		$widthp1 = count($matrixValues[0]);
		
		for($k = 0; $k < $widthp1; $k++){
			for($j = 0; $j < $i; $j++){
				fwrite($outputFileHandle, $matrixValues[$j][$k]);
				if($j == $i-1){
					fwrite($outputFileHandle, "\n");
				} else {
					fwrite($outputFileHandle, "\t");
				}
			}
		}
		
		fclose($inputFileHandle);
		fclose($outputFileHandle);
		
		chmod($outputFile, 0777);
		
	}
	
	function convertMatrixToHeaderedMatrix($inputFile, $outputFile, $headers1File, $headers2File){
		if(!file_exists($inputFile)){  echo "matrix file doesn't exist!"; return false;};
		if(!file_exists($headers1File)){ echo $headers1File." does not exist\n\n"; return false;};
		if(!file_exists($headers2File)){ echo $headers2File." does not exist\n\n"; return false;};
		
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		$headers1FileHandle = fopen($headers1File, "r");
		$headers2FileHandle = fopen($headers2File, "r");
		
		fwrite($outputFileHandle, "genes");
		
		while(($header1Line = fgets($headers1FileHandle)) !== false){
			fwrite($outputFileHandle, "\t".trim($header1Line));
		}
		fwrite($outputFileHandle, "\n");
		
		while(($inputLine = fgets($inputFileHandle)) !== false){
			if(($header2Line = fgets($headers2FileHandle)) !== false){
				fwrite($outputFileHandle, trim($header2Line)."\t");
			} else {
				fwrite($outputFileHandle, "\t");
			}
			fwrite($outputFileHandle, $inputLine);
		}
		
		fclose($inputFileHandle);
		fclose($outputFileHandle);
		fclose($headers1FileHandle);
		fclose($headers2FileHandle);
		
		chmod($outputFile, 0777);
		
	}	
	
	function convertHeaderedMatrixToMatrix($inputFile, $outputFile){
	
		$order   = array("\n\r", "\r");
		$replace = '';
	
		if(!file_exists($inputFile)){ return false;};
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		$headerLine = fgets($inputFileHandle);
		while(($line = fgets($inputFileHandle)) !== false){
			$line = str_replace($order, $replace, $line);
			fwrite($outputFileHandle, substr(strstr($line, "\t"), 1));
		}
		
		fclose($outputFileHandle);
		fclose($inputFileHandle);
		
		chmod($outputFile, 0777);
		return true;
		
	}
	
	function convertHeaderedMatrixToList($inputFile, $outputFile){
	
		if(!file_exists($inputFile)){ return false;};
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		$headerLine = fgets($inputFileHandle);
		$headerLineParameters = explode("\t", trim($headerLine));
		
		if($headerLineParameters[0] != "genes"){
			array_unshift($headerLineParameters, "genes");
		}
		
		while(($line = fgets($inputFileHandle)) !== false){
			$lineParameters = explode("\t", trim($line));
			$lineName = $lineParameters[0];
			$paramNumber = 0;
			foreach($lineParameters as $param){
				if($param == $lineName){} else {
					if(($param > 0 || $param == "1") && isset($headerLineParameters[$paramNumber])){
						fwrite($outputFileHandle, $headerLineParameters[$paramNumber]."\t".$lineName."\t".$param."\n");
					} else {}
				}
				$paramNumber++;
			}

		}
		
		fclose($outputFileHandle);
		fclose($inputFileHandle);
		chmod($outputFile, 0777);
		return true;
		
	}
	
	function convertListToHeaderedMatrix($inputFile, $outputFile){
	
		if(!file_exists($inputFile)){ return false;};
		$inputFileHandle = fopen($inputFile, "r");
		$outputFileHandle = fopen($outputFile, "w");
		
		$matrix = array();
		$headers1 = array();
		$headers2 = array();
		fwrite($outputFileHandle, "genes");
		while(($line = fgets($inputFileHandle)) !== false){
			$lineParameters = explode("\t", trim($line));
			if(!in_array($lineParameters[0], $headers1)){$headers1[] = $lineParameters[0];}
			if(!in_array($lineParameters[1], $headers2)){$headers2[] = $lineParameters[1];}
			$matrix[$lineParameters[0]][$lineParameters[1]] = 1;
		}
		
		// Print out horizontal Headers
		foreach($headers1 as $header1){
			fwrite($outputFileHandle, "\t".$header1);
		}
		fwrite($outputFileHandle, "\n");
		
		foreach($headers2 as $header2){
			fwrite($outputFileHandle, $header2);
			foreach($headers1 as $header1){
				fwrite($outputFileHandle, "\t".(isset($matrix[$header1][$header2])?1:0));
			}
			fwrite($outputFileHandle, "\n");
		}
		
		fclose($outputFileHandle);
		fclose($inputFileHandle);
		chmod($outputFile, 0777);
		return true;
	}
?>
