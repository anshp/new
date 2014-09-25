<!doctype HTML>
<html>
<head>
	<style>
	#m{
		margin-left: 20px;
		font-size: 16px;
	}
	div {
		margin-left: 20px;
	}
	</style>
	<title>Delete Student
	</title>
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<?php
	// Connecting to the database
	$user = 'root';
	$pass = "'";
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=new', $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

	//Delete the student
	if ($_GET['did']){
		
		header("Location: student.php?del=".$_GET['did']."&page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']);
	}
	if ($_GET['id']){
		$q = $dbh -> prepare("SELECT * FROM student WHERE id = ?;");
		$q->bindParam(1, $_GET['id']);
		$q->execute();
		$row = $q->fetch();
	}
	?>
</head>
<body>
	<?php
	
	echo "<br><p id = 'm'><span class ='alert alert-warning'>Are you sure you want to delete the following record?</span><br><br><div>Id. ".$row['0']."<br>Name: ".$row[1]."<br>Class: ".$row[2]."<br> Date of birth: ".$row[3]."</div></p>";
	echo "<a href = 'delete_student.php?page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']."&did=".$_GET['id']."'><div class='btn btn-danger'>Yes</div></a>";
	echo "<a href = 'student.php?page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']."'><div class='btn btn-success'>Cancel</div></a>";
	?>
	
</body>
</html>
