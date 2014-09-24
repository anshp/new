<!doctype HTML>
<html>
<head>
	<title>Login / Signup
	</title>
	<?php
	if ($_COOKIE['PHPSESSID']){
		session_id($_COOKIE['PHPSESSID']);
		print_r($_SESSION);
		session_start();
		echo "Welcome ".$_SESSION['username']."<br>";
	}
	elseif ($_COOKIE["usern"]) {
		echo "Welcome ".$_COOKIE["usern"]."<br>";
	}
	else{
		header('Location: login.php');
	}

	
	?>
</head>
<body>
	<a href = "login.php"> Logout </a>
	
</body>
</html>
