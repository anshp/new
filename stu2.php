<!doctype HTML>
<html>
<head>
	<title>Student Database 1
	</title>

	<style>
	table,td,tr,th {
		
		min-width: 60px;
		background-color: #d4fff0;
	}
	.page{
		float:left;
		min-width: 30px;
		text-align: center;
		background-color: #ecfffc;
	}
	#creatediv {
		background-color: #cceeff;
		border: 2px solid #ccfffc;
		width: 160px;
		height: 25px;
		margin-bottom: 10px;
		font-size: 17px;
		font-weight: bold;
		text-align: center;
		cursor: pointer;
	}
	#clear{
		clear:both;
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
	if ($_GET['sort']){
		$sort = $_GET['sort'];
		$ord[$sort] = $_GET['ord'] % 2;
	}
	else{
		$sort = 1;
		$ord[$sort] = 1;
	}
	?>
</head>
<body>
	<h1>Student Database</h1>
	<a href = "create_student.php"><div id = "creatediv">Create New Student</div></a>
	<form method="post" action="student.php">
		<input type = "text" name = 'search'>
		<input type ='submit' value = 'search'><br><br>
	</form>
	<div id = "viewdiv">
		<?php

		$limit = 10;
		if($_GET['page'])
			$page = $_GET['page'];
		else 
			$page = 1;
		echo "Page No. ".$page;
		$start=($page-1)*$limit;
		
		echo "<table><tr><th><a href = 'student.php?page=".$page."&sort=1&ord=".($ord[1]+1)."'>Id</a></th><th><a href = 'student.php?page=".$page."&sort=2&ord=".($ord[2]+1)."'>Name</a></th><th><a href = 'student.php?page=".$page."&sort=3&ord=".($ord[3]+1)."'>Class</a></th><th><a href = 'student.php?page=".$page."&sort=4&ord=".($ord[4]+1)."'>Date of Birth</a></th></tr>";
		if ($_POST['search'] or $_GET['search']){
			$q = $dbh -> prepare("SELECT * FROM student WHERE name LIKE ?;");
			if ($_POST['search'])
				$a = $_POST['search'];
			if ($_GET['search'])
				$a = $_GET['search'];
			$b=$a.'%';
			$q->bindParam(1, $b);

		}
		else{

			if ($sort == 1 and $ord[$sort] % 2 == 1){
				$order = 'id';
				$dir =  'ASC';
			}
			if ($sort == 1 and $ord[$sort] % 2 == 0){
				$order = 'id';
				$dir =  'DESC';
			}
			if ($sort == 2 and $ord[$sort] % 2 == 1){
				$order = 'name';
				$dir =  'ASC';
			}
			if ($sort == 2 and $ord[$sort] % 2 == 0){
				$order = 'name';
				$dir =  'DESC';
			}
			if ($sort == 3 and $ord[$sort] % 2 == 1){
				$order = 'class';
				$dir =  'ASC';
			}
			if ($sort == 3 and $ord[$sort] % 2 == 0){
				$order = 'class';
				$dir =  'DESC';
			}
			if ($sort == 4  and $ord[$sort] % 2 == 1){
				$order = 'dob';
				$dir =  'ASC';
			}
			if ($sort == 4 and $ord[$sort] % 2 == 0){
				$order = 'dob';
				$dir =  'DESC';
			}
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
			echo "<tr><td>$row[0]</td><td>$row[1]</td> <td>$row[2]</td><td>$row[3]</td><td><a href = 'edit_student_table.php?id=".$row[0]."'>Edit</a></td><td><a href = 'delete_student.php?id=".$row[0]."'>Delete</a></td></tr>";			
			$i++;
		}
		echo "</table><br>";
		echo "<div class = 'page'>Page No.</div>";
		
		$p = ceil($count/$limit);

		for ($i = 0; $i < $p; $i++){
			echo "<a href = student.php?page=".($i+1)."&sort=".$sort."&ord=".($ord[$sort])."&search=".$a."><div class = 'page'>".($i+1)." </div></a>";
		}
		if ($a)
			echo "<br><a href = 'student.php'>View all</a>";
		?>
	</div>


</body>
</html>
