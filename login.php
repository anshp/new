<!doctype HTML>
<html>
<head>
	<title>Login / Signup
	</title>

	<?php

	//User logs out
	if ($_COOKIE['PHPSESSID']){
		session_destroy();
		$_SESSION = array();
		setcookie("PHPSESSID", "", time()-300);
	}

	//Reading all usernames and passwords
	$pa = fopen("pass.txt", "r"); 		
	$i=1;
	while(!feof($pa)){
		$user[$i] = fgets($pa);
		$pass[$i] = fgets($pa);
		$i++;
	}
	fclose($pa);

	//Signup process
	if($_POST['signup']){				
		if ($_POST['name'] and $_POST['pass']){
			if (array_search($_POST['name']."\n",$user)){
				echo "Username already exists";	
			}
			else{
				$pa = fopen("pass.txt","a");
				fwrite($pa, $_POST['name']."\n".$_POST['pass']."\n");
				fclose($pa);
				
			}
		}
	}

	//Sign in process.
	if ($_POST['signin']){
		if ($_POST['pass']."\n"==$pass[array_search($_POST['name']."\n",$user)]){
			//username and password correct
			session_start();
			$_SESSION['username'] = $_POST['name'];
			header("Location: page.php");
		}
		else{
			echo "wrong username or password";
		}
	}	
	?>

	<style>
	h1{
		text-align: center;
	}
	#left{text-align: left;}
	#d{
		width: 300px;
		margin-left: 300px;
	}
</style>
</head>

<body>
	<div id = "d">
		<form method="post" action="login.php">
			<p><input type = "text" name = "name" placeholder = "Username"></p>
			<p><input type = "password" name = "pass" placeholder = "Password"></p>
			<input type="submit" name="signin"  value="Sign in">
			<input type="submit" name="signup"  value="Sign up">
		</form>
	</div>
	
</body>
</html>