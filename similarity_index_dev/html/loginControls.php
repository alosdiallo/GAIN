<!-- If user is logged in, show logout button, otherwise, show the login button so we can get the user logged in-->
<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
<div id="loginControls">
<button type="button" onclick="window.location.href='<?php if(isset($_SESSION['logged_on'])){echo "php/logout_server.php";}else{echo "login.php";}?>'"><?php if(isset($_SESSION['logged_on'])){echo "Logout";}else{echo "Login";}?></button>
<!--button type="button" onclick="window.location.href='index.php'">Back to Home</button-->
<?php if(isset($_SESSION['logged_on'])){echo "Welcome, ".$_SESSION['user'];}?>
</div>