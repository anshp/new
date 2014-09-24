<!doctype HTML>
<html>
<head>
	<title>Student Database 1
	</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<style>
	.page{
		font-size: 20px;
		font-weight: 'bold';
	}
	form {
		width: 600px;
	}
	#q{
		margin: 20px;
	}
	#x{
		width: 400px;
		float:left;
	}
	</style>

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

	//Sort and order
	if ($_GET['sort']){
		$sort = $_GET['sort'];
		$ord[$sort] = $_GET['ord'] % 2;
	}
	else{
		$sort = 1;
		$ord[$sort] = 1;
	}

	//Page No.
	$limit = 10;
	if($_GET['page'])
		$page = $_GET['page'];
	else 
		$page = 1;
	$start=($page-1)*$limit;
	if ($_POST['search'])
		$a = $_POST['search'];
	if ($_GET['search'])
		$a = $_GET['search'];
	$b=$a.'%';
	?>
</head>
<body>
	<div id = 'q'>
	<h1>Student Database</h1>
	<a href = "create_student.php"><div class='btn btn-primary'>Create New Student</div></a><br><br>
	<form method="post" action="student.php">
		<input id = 'x' class="form-control" type = "text" name = 'search' value = "<?PHP echo $a; ?>">
		<input class='btn btn-success' type ='submit' value = 'search'><br><br>
	</form>
	<div id = "viewdiv">
		<?php
		
		if ($_GET['del']){
			$sql="SELECT * FROM student WHERE id=".$_GET['del'].";";
			$q = $dbh -> prepare($sql);
			$q->execute();
			$row = $q->fetch();
			echo "<br>".$row[0].". <b>".$row[1]."</b>'s records deleted";

			$qu = $dbh -> prepare("DELETE FROM student WHERE id = ?;");
			$qu->bindParam(1, $_GET['del']);
			$qu->execute();
		}
		if ($_GET['ed']){
			$sql="SELECT * FROM student WHERE id=".$_GET['ed'].";";
			$q = $dbh -> prepare($sql);
			$q->execute();
			$row = $q->fetch();
			echo "<br>".$row[0].". <b>".$row[1]."</b>'s records edited";
		}
		echo "<table class = 'table table-striped'><tr><th><a href = 'student.php?page=".$page."&sort=1&ord=".($ord[1]+1)."&search=".$a."'>Id</a></th><th><a href = 'student.php?page=".$page."&sort=2&ord=".($ord[2]+1)."&search=".$a."'>Name</a></th><th><a href = 'student.php?page=".$page."&sort=3&ord=".($ord[3]+1)."&search=".$a."'>Class</a></th><th><a href = 'student.php?page=".$page."&sort=4&ord=".($ord[4]+1)."&search=".$a."'>Date of Birth</a></th></tr>";
		if ($sort == 1 and $ord[$sort] == 1){
				$order = 'id';
				$dir =  'ASC';
			}
			if ($sort == 1 and $ord[$sort] == 0){
				$order = 'id';
				$dir =  'DESC';
			}
			if ($sort == 2 and $ord[$sort] == 1){
				$order = 'name';
				$dir =  'ASC';
			}
			if ($sort == 2 and $ord[$sort] == 0){
				$order = 'name';
				$dir =  'DESC';
			}
			if ($sort == 3 and $ord[$sort] == 1){
				$order = 'class';
				$dir =  'ASC';
			}
			if ($sort == 3 and $ord[$sort] == 0){
				$order = 'class';
				$dir =  'DESC';
			}
			if ($sort == 4  and $ord[$sort] == 1){
				$order = 'dob';
				$dir =  'ASC';
			}
			if ($sort == 4 and $ord[$sort] == 0){
				$order = 'dob';
				$dir =  'DESC';
			}
		if ($a){
			$sql="SELECT * FROM student WHERE name LIKE ? ORDER BY ".$order." ".$dir.";";
			$q = $dbh -> prepare($sql);
			$q->bindParam(1, $b);
		}
		else{
			$sql="SELECT * FROM student ORDER BY ".$order." ".$dir.";";
			$q = $dbh -> prepare($sql);
		}
		$q->execute();
		$i=0;
		while($row = $q->fetch()){
			$result[$i]=$row;
			$i++;
		}
		$count = count($result);
		$i = $start;
		while($i < $start + 10 and $i < $count){
			$row=$result[$i];
			echo "<tr><td>$row[0]</td><td>$row[1]</td> <td>$row[2]</td><td>$row[3]</td><td><a href = 'edit_student_table.php?id=".$row[0]."&page=".$page."&sort=".$sort."&ord=".$ord[$sort]."'>Edit</a></td><td><a href = 'delete_student.php?id=".$row[0]."&page=".$page."&sort=".$sort."&ord=".$ord[$sort]."'>Delete</a></td></tr>";
			$i++;
		}
		echo "</table><br>";
		//echo "Page No. ".$page."<br>";
		//echo "<div class = 'page'>Go to page:</div>";
		
		$p = ceil($count/$limit);
		echo "<ul class='pagination'>";
		for ($i = 0; $i < $p; $i++){
			if (($i+1)==$page)
				echo "<li><a href = student.php?page=".($i+1)."&sort=".$sort."&ord=".($ord[$sort])."&search=".$a."><div class = 'page'>".($i+1)."</div></a></li>";
			else
				echo "<li><a href = student.php?page=".($i+1)."&sort=".$sort."&ord=".($ord[$sort])."&search=".$a.">".($i+1)."</a></li>";
		}
		echo "</ul>";
		if ($a)
			echo "<br><a href = 'student.php'>View all</a>";
		?>
	</div></div>


</body>
</html>
