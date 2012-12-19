<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	error_reporting(E_ALL);
	require_once 'php/constants.php';
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Similarity Index</title>
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>
	</head>
	<body>
		<?php require($GLOBALS['directory']."html/loginControls.php");?>		
		<hr>
			<?php require($GLOBALS['directory']."html/projectControls.html");?>
		<hr>
	</body>
