<?php
$user = 'root';
$pass = "'";
try {
	$dbh = new PDO('mysql:host=localhost;dbname=new', $user, $pass);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}
function getCurrentUri(){
	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
	$uri = '/' . trim($uri, '/');
	return $uri;
}

$base_url = getCurrentUri();
$routes = array();
$routes = explode('/', $base_url);

print_r($routes);
?>



<?php
/*

	<div id = "viewdiv">
			<?php

			//Deleting the record and notification
			if ($_GET['del']){
				$sql = "SELECT * FROM student WHERE id = ".$_GET['del'].";";
				$q = $dbh -> prepare($sql);
				$q->execute();
				$row = $q->fetch();
				echo "<div class = 'alert alert-danger'>".$row[0].". <b>".$row[1]."</b>'s records deleted</div>";
				$qu = $dbh -> prepare("DELETE FROM student WHERE id = ?;");
				$qu->bindParam(1, $_GET['del']);
				$qu->execute();
			}

			//Edit notification
			if ($_GET['ed']){
				$sql = "SELECT * FROM student WHERE id = ".$_GET['ed'].";";
				$q = $dbh -> prepare($sql);
				$q->execute();
				$row = $q->fetch();
				echo "<div class = 'alert alert-info'>".$row[0].". <b>".$row[1]."</b>'s records edited</div>";
			}

			//Creating the record table
			echo "<table class = 'table table-striped'><tr><th><a href = 'student.php?page=".$page."&sort=1&ord=".($ord[1]+1)."&search=".$a."'>Id</a></th><th><a href = 'student.php?page=".$page."&sort=2&ord=".($ord[2]+1)."&search=".$a."'>Name</a></th><th><a href = 'student.php?page=".$page."&sort=3&ord=".($ord[3]+1)."&search=".$a."'>Class</a></th><th><a href = 'student.php?page=".$page."&sort=4&ord=".($ord[4]+1)."&search=".$a."'>Date of Birth</a></th></tr>";

			
		//Search query and normal query
		if ($a){
			$sql = "SELECT * FROM student WHERE name LIKE ? ORDER BY ".$order." ".$dir.";";
			$q = $dbh -> prepare($sql);
			$q->bindParam(1, $b);
		}
		else{
			$sql = "SELECT * FROM student ORDER BY ".$order." ".$dir.";";
			$q = $dbh -> prepare($sql);
		}
		$q->execute();
		$i = 0;

		//storing all the reults in a variable
		while($row = $q->fetch()){
			$result[$i] = $row;
			$i++;
		}

		//Printing the table
		$count = count($result);
		$i = $start;
		while($i < $start + 10 and $i < $count){
			$row = $result[$i];
			echo "<tr><td>$row[0]</td><td>$row[1]</td> <td>$row[2]</td><td>$row[3]</td><td><a href = 'edit_student_table.php?id=".$row[0]."&page=".$page."&sort=".$sort."&ord=".$ord[$sort]."'>Edit</a></td><td><a href = 'delete_student.php?id=".$row[0]."&page=".$page."&sort=".$sort."&ord=".$ord[$sort]."'>Delete</a></td></tr>";
			$i++;
		}
		echo "</table><br>";

		//Pagination
		$p = ceil($count/$limit);
		echo "<ul class = 'pagination'>";
		for ($i = 0; $i < $p; $i++){
			if (($i+1) == $page){
				echo "<li><a href = student.php?page=".($i+1)."&sort=".$sort."&ord=".($ord[$sort])."&search=".$a."><div class='page'>".($i+1)."</div></a></li>";
			}
			else {
				echo "<li><a href = student.php?page=".($i+1)."&sort=".$sort."&ord=".($ord[$sort])."&search=".$a.">".($i+1)."</a></li>";
			}
		}
		echo "</ul>";
		?>
	</div>
</div>
<div id ='y'></div>
<script>
	 $("#x").keyup(function(){
		 $.post("/student/student.php",
		 {
			 search : $("#x").val()
		 },
		 function(data){
			 $("body").html(data);
			 $("#x").focus();
		 });
	 });
</script>
*/
?>
