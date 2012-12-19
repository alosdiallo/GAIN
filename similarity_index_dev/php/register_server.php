<?php
	require_once 'constants.php';
	ini_set('display_errors', 1);

	$user = validateUser($_POST['user']);
	$pw = validatePassword($_POST['pwOrig'], $_POST['pwCopy']);

	if($GLOBALS['debug'] >= 2){echo("user: ".$user."<br>");}
	if($GLOBALS['debug'] >= 2){echo("pw: ".($pw != "")."<br>");}
	// User and Password both validated as correct
	
	if($user && $pw){
		createNewUser($user, $pw);
		header('Location: '.$GLOBALS['url'].'login.php');
	}

	
	
	//
	//escapeshellarg();
	function createNewUser($user, $pw){
		echo "In Create New User";
		if(!doesUserDirectoryExist($user)){
			$dir = $GLOBALS['directory']."users/".$user;
			echo("User Directory Does Not Exist"."<br>");
			mkdir($dir, 0775);
			mkdir($dir."/projects/", 0775);
			writePassword($user, $pw);
		} else {
			// The user directory already exists!
			echo("User Directory Exists"."<br>");
			return false;
		}
	}

	function writePassword($user, $pw){
		$pwFile = $GLOBALS['directory']."users/".$user."/pw.txt";
		
		$fh = fopen($pwFile, 'w');
		fwrite($fh, $pw);
		fclose($fh);
		chmod($pwFile, 0775);
	}

	function doesUserDirectoryExist($user){
		$dir = $GLOBALS['directory']."users/".$user."/";
		return file_exists($dir);
	}

	function validateUser($user){
		$MIN_USER_LENGTH = 6;
		$MAX_USER_LENGTH = 24;
		// MIN LENGTH CHECK
		if(strlen($user) < $MIN_USER_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MIN USER LENGTH: Your user name is too short, minimum is $MIN_USER_LENGTH <br>");}
			return "";
		}
		// MAX LENGTH CHECK
		if(strlen($user) > $MAX_USER_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MAX USER LENGTH: Your user name is too long, maximum is $MAX_USER_LENGTH <br>");}
			return "";
		}
		//CHECK FOR NON ALPHANUMERIC CHARACTERS
		if(checkForAlphanumericCharacters($user)){
			if($GLOBALS['debug'] >= 2){echo("ALPHANUMERIC USER NOT PASSED: You have a non-alphanumeric character in your username <br>");}
			return "";
		}
		//RETURN user
		return $user;
	}
	//
	
	
	function validatePassword($pwOrig, $pwCopy){
		$MIN_PASSWORD_LENGTH = 6;
		$MAX_PASSWORD_LENGTH = 24;
		// MIN LENGTH CHECK
		if(strlen($pwOrig) < $MIN_PASSWORD_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MIN PW LENGTH: Your password is too short, minimum is $MIN_PASSWORD_LENGTH <br>");}
			return "";
		}
		// MAX LENGTH CHECK
		if(strlen($pwOrig) > $MAX_PASSWORD_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MAX PW LENGTH: Your password is too long, maximum is $MAX_PASSWORD_LENGTH <br>");}
			return "";
		}
		// ORIG = COPY check
		if($pwOrig != $pwCopy){
			if($GLOBALS['debug'] >= 2){echo("PW: ORIG ne COPY: The passwords that you entered do not match <br>");}
			return "";
		}
		//CHECK FOR NON ALPHANUMERIC CHARACTERS
		//if(checkForAlphanumericCharacters($pwOrig)){
		//	if($GLOBALS['debug'] >= 2){echo("ALPHANUMERIC PW NOT PASSED");}
		//	return "";
		//}
		//RETURN md5(pw)
		return md5($pwOrig);
	}

	function checkForAlphanumericCharacters($string){
		return preg_match( "/^[a-zA-Z0-9]$/", $string);
		//return ctype_alnum($string);
		//return preg_match ( "/^([a-z]||[A-Z]||[0-9])+$/", $string );
	}
	
?>
