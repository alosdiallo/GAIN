<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	ini_set('display_errors', 1);

	$user = validateUser($_POST['user']);
	$pw = validatePassword($_POST['pw']);

	validateLogin($user, $pw);
	
	// Validates login, if the login was successful it will redirect back to index, otherwise it will display an error.
	function validateLogin($user, $pw){
		if(doesUserDirectoryExist($user)){
			// User Exists
			$pwFile = $GLOBALS['directory']."users/".$user."/pw.txt";

			if(file_get_contents($pwFile) === $pw){
				$_SESSION['logged_on']=1;
				$_SESSION['user']=$user;
				$_SESSION['project']="none";
				if($GLOBALS['debug'] >= 2){echo("Logged on"."<br>");}
				if($GLOBALS['debug'] >= 2){echo($_SESSION['logged_on']."<br>");}
				header('Location: '.$GLOBALS['url']."first_page.html");
			} else {
				echo "INVALID PASSWORD: Your password did not match the password on file <br>";
			}
		} else {
			//User doesn't exist
			echo "USER DOESN'T EXIST: The username that you entered does not exist. <br>";
		}
	}

	// return true is user directory exists.
	function doesUserDirectoryExist($user){
		$dir = $GLOBALS['directory']."users/".$user."/";
		return file_exists($dir);
	}

	// returns user if user is longer than min, shorter than max and contains only alphanumeric characters, blank string otherwise.
	function validateUser($user){
		$MIN_USER_LENGTH = 6;
		$MAX_USER_LENGTH = 24;
		// MIN LENGTH CHECK
		if(strlen($user) < $MIN_USER_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MIN USER LENGTH: Usernames must be at least $MIN_USER_LENGTH <br>");}
			return "";
		}
		// MAX LENGTH CHECK
		if(strlen($user) > $MAX_USER_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MAX USER LENGTH: Usernames must be at most $MAX_USER_LENGTH <br>");}
			return "";
		}
		//CHECK FOR NON ALPHANUMERIC CHARACTERS
		if(checkForAlphanumericCharacters($user)){
			if($GLOBALS['debug'] >= 2){echo("ALPHANUMERIC USER NOT PASSED: Your username contains non-alphanumeric characters");}
			return "";
		}
		//RETURN user
		return $user;
	}
	//
	
	// Returns md5($pw) if password is longer than min length, shorter than max length. else returns blank string
	function validatePassword($pw){
		$MIN_PASSWORD_LENGTH = 6;
		$MAX_PASSWORD_LENGTH = 24;
		// MIN LENGTH CHECK
		if(strlen($pw) < $MIN_PASSWORD_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MIN PW LENGTH: Passwords must be at least $MIN_PASSWORD_LENGTH <br>");}
			return "";
		}
		// MAX LENGTH CHECK
		if(strlen($pw) > $MAX_PASSWORD_LENGTH){
			if($GLOBALS['debug'] >= 2){echo("MAX PW LENGTH: Passwords must be at most $MAX_PASSWORD_LENGTH <br>");}
			return "";
		}
		
		return md5($pw);
	}
	
	// Returns true if there are only alphanumeric characters in the string, false otherwise
	function checkForAlphanumericCharacters($string){
		return preg_match( "/^[a-zA-Z0-9]$/", $string);
	}
	
?>
