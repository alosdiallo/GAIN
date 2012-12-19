<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	require_once 'runScript_server.php';
	ini_set('display_errors', 1);

	$user = $_SESSION['user'];
	$project = $_SESSION['project'];

	$list = $_POST['list'];

	$hypergeometric = $_POST['hypergeometric'];
	$geometric = $_POST['geometric'];
	$pearson = $_POST['pearson'];
	$jaccard = $_POST['jaccard'];
	$simpson = $_POST['simpson'];
	$cosine = $_POST['cosine'];
	$inverse = ($_POST['inverse'] == "true");
	
	
	$dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/";
	$outputHandle = fopen($dir."lists/".$list."/download.csv", "w");

	// Gene 1 Gene 2 in header
	fwrite($outputHandle, "Gene1\tGene2");
	
	$suffix = "";
	if($inverse){$suffix = "rev";}
	// Ok, Let's run the full correlation script and grab the lists we need.. Also set up the header!
	if($hypergeometric == "true"){
		runCorrelationScript($user, $project, "hyper.pl", $inverse);
		$hypergeometric_list = loadListValues($dir."hypergeometric".$suffix."/hypergeometric".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $hypergeometric_list, "hypergeometric".$suffix);
		createAssociationDensityPlotList($dir, $list, "hypergeometric".$suffix, $user, $project);
		createAssociationDensityPlot($dir, $list, "hypergeometric".$suffix, $user, $project);
		fwrite($outputHandle, "\tHypergeometric");
	}
	if($geometric == "true"){
		runCorrelationScript($user, $project, "geo.pl", $inverse);
		$geometric_list = loadListValues($dir."geometric".$suffix."/geometric".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $geometric_list, "geometric".$suffix);
		createAssociationDensityPlotList($dir, $list, "geometric".$suffix, $user, $project);
		createAssociationDensityPlot($dir, $list, "geometric".$suffix, $user, $project);
		fwrite($outputHandle, "\tGeometric");
	}
	if($pearson == "true"){
		runCorrelationScript($user, $project, "pearson.pl", $inverse);
		$pearson_list = loadListValues($dir."pearson".$suffix."/pearson".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $pearson_list, "pearson".$suffix);
		createAssociationDensityPlotList($dir, $list, "pearson".$suffix, $user, $project);
		createAssociationDensityPlot($dir, $list, "pearson".$suffix, $user, $project);
		fwrite($outputHandle, "\tPearson");
	}
	if($jaccard == "true"){
		runCorrelationScript($user, $project, "jaccard.pl", $inverse);
		$jaccard_list = loadListValues($dir."jaccard".$suffix."/jaccard".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $jaccard_list, "jaccard".$suffix);
		createAssociationDensityPlotList($dir, $list, "jaccard".$suffix, $user, $project);		
		createAssociationDensityPlot($dir, $list, "jaccard".$suffix, $user, $project);
		fwrite($outputHandle, "\tJaccard");
	}
	if($simpson == "true"){
		echo "Running Simpson<br>";
		runCorrelationScript($user, $project, "mm.pl", $inverse);
		echo "Running Simpson<br>";
		$simpson_list = loadListValues($dir."simpson".$suffix."/simpson".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $simpson_list, "simpson".$suffix);
		createAssociationDensityPlotList($dir, $list, "simpson".$suffix, $user, $project);
		createAssociationDensityPlot($dir, $list, "simpson".$suffix, $user, $project);
		fwrite($outputHandle, "\tSimpson");
	}
	if($cosine == "true"){
		runCorrelationScript($user, $project, "c_index.pl", $inverse);	
		$cosine_list = loadListValues($dir."cosine".$suffix."/cosine".$suffix."_list.txt");
		createAssociationPartialFromArray($dir, $list, $cosine_list, "cosine".$suffix);
		createAssociationDensityPlotList($dir, $list, "cosine".$suffix, $user, $project);
		createAssociationDensityPlot($dir, $list, "cosine".$suffix, $user, $project);
		fwrite($outputHandle, "\tCosine");
	}
	
	fwrite($outputHandle, "\n");
	// Header end!
	
	
	
	// Output file
	if(file_exists($dir."lists/".$list."/list.txt")){
		$inputHandle = fopen($dir."lists/".$list."/list.txt", "r");
		
		while (($buffer = fgets($inputHandle, 4096)) !== false) {
				$buffer = trim($buffer);
				$bufferArray = explode("\t", $buffer);
				#$bufferArray[0] & $bufferArray[1] = gene names

				fwrite($outputHandle, $bufferArray[0]."\t".$bufferArray[1]);
			
				
				
				if($hypergeometric == "true"){
					if(isset($hypergeometric_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$hypergeometric_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				if($geometric == "true"){
					if(isset($geometric_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$geometric_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				if($pearson == "true"){
					if(isset($pearson_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$pearson_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				if($jaccard == "true"){
					if(isset($jaccard_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$jaccard_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				if($simpson == "true"){
					if(isset($simpson_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$simpson_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				if($cosine == "true"){
					if(isset($cosine_list[$bufferArray[0].":".$bufferArray[1]])){
						fwrite($outputHandle, "\t".$cosine_list[$bufferArray[0].":".$bufferArray[1]]);
					} else {
						fwrite($outputHandle, "\t");
					}
				}
				
				fwrite($outputHandle, "\n");
				
				
				//$array[$bufferArray[0].":".$bufferArray[1]] = $bufferArray[2];
		}
		
		fclose($inputHandle);
	}
	
	fclose($outputHandle);
	
	
	function createAssociationDensityPlot($projectDir, $list, $baseName, $user, $project){
		$output = $projectDir."lists/".$list."/";
		$fullAssociationFile = $projectDir.$baseName."/".$baseName."_full_list.txt";
		$partialAssociationFile = $output.$baseName."_association_partial.txt";
		$full_list_dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/";
		$index_full_list_dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		$exec_str = "perl ".$GLOBALS['directory']."scripts/"."histogram_m.pl $fullAssociationFile $partialAssociationFile $baseName $output $full_list_dir $index_full_list_dir 2>&1";
		exec($exec_str, $execOutput);
		echo "<br><br>|||<br>".$exec_str."<br>|||<br><br>";
		echo "<br><br>||<br>".print_r($execOutput)."<br>||<br><br>";
	}
	//Alos 12/7/12
	function createAssociationDensityPlotList($projectDir, $list, $baseName, $user, $project){
		$output = $projectDir."lists/".$list."/";
		$full_list_dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/interactions/";
		$index_full_list_dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		$headered_file = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/".$baseName."_headered.txt";
		$nonheadered_file = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/".$baseName."_bare_matrix.txt";
		$exec_str = "perl ".$GLOBALS['directory']."scripts/"."make_lists.pl $headered_file $nonheadered_file $index_full_list_dir $baseName 2>&1";
		exec($exec_str, $execOutput);
		echo "<br><br>|||<br>".$exec_str."<br>|||<br><br>";
		echo "<br><br>||<br>".print_r($execOutput)."<br>||<br><br>";
	}

	function createAssociationPartialFromArray($directory, $list, $array, $baseName){
		//echo "\n".$directory."lists/".$list."/".$baseName."_association_partial.txt"."\n";
		$outputHandle = fopen($directory."lists/".$list."/".$baseName."_association_partial.txt", "w");
		if(file_exists($directory."lists/".$list."/list.txt")){
			//echo "\n".$directory."lists/".$list."/list.txt"."\n";
			$inputHandle = fopen($directory."lists/".$list."/list.txt", "r");
			while (($buffer = fgets($inputHandle, 4096)) !== false) {
					$buffer = trim($buffer);
					$bufferArray = explode("\t", $buffer);
					#$bufferArray[0] & $bufferArray[1] = gene names	

					if(isset($array[$bufferArray[0].":".$bufferArray[1]])){
						
						fwrite($outputHandle, $array[$bufferArray[0].":".$bufferArray[1]]."\n");
					}
			}
			fclose($inputHandle);
		}
		fclose($outputHandle);
	}
	function loadListValues($list){
		$array = array();

		if(file_exists($list)){
			$handle = fopen($list, "r");
			
			while (($buffer = fgets($handle, 4096)) !== false) {
				$buffer = trim($buffer);
				$bufferArray = explode("\t", $buffer);
				#$bufferArray[0] & $bufferArray[1] = gene names
				#$bufferArray[2] = score
				
				$array[$bufferArray[0].":".$bufferArray[1]] = $bufferArray[2];
			}
			
			fclose($handle);
		}
		return $array;
	}
?>
