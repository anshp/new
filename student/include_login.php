<?php

//Checking for login
if ($_COOKIE['PHPSESSID']){
	session_start();
	$username = $_SESSION['username'];
} else {
	header('Location: login.php');
}
?>