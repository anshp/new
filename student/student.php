<!doctype HTML>
<html>
<head>
    <title>Student Database 1
    </title>
    <link rel = "stylesheet" href = "bootstrap.min.css">
    <link rel = "stylesheet" href = "bootstrap-theme.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <style>
    h1{
        display: inline;
    }
    .page{
        font-size: 20px;
    }
    form {
        width: 600px;
    }
    .large{
        font-size: 16px;
    }
    .margin-10{
        margin: 10px;
    }
    #q{
        margin: 20px;
    }
    #x{
        width: 400px;
        float:left;
        margin-right: 5px;
    }
    </style>

    <?php
    require "include_login.php";
    require "include_dbase.php";
    
    //Determine sorting and order
    if ($_GET['sort']) {
        $sort = $_GET['sort'];
        $ord[$sort] = $_GET['ord'] % 2;
    } else {
        $sort=1;
        $ord[$sort] = 1;
    }

    //Determining page no.
    $limit = 10;
    if($_GET['page']) {
        $page=$_GET['page'];
    } else  {
        $page=1;
    }

    $start = ($page - 1) * $limit;
    if ($_POST['search']){
        $a = $_POST['search'];
    }
    if ($_GET['search']){
        $a = $_GET['search'];
    }
    $b = $a.'%';
    ?>
</head>
<body>
    <div id = 'q'>
        <div>
        <h1>
            Student Database
        </h1>
        <?php
            echo "<span class = 'col-md-offset-6 col-sm-offset-3'><span class = 'large'>Welcome <b>".$username."</b></span>";
            echo "<a class = 'margin-10 btn btn-danger'href = 'login.php'> Logout </a></span>";
        ?>
        
    </div>
        <a href = "create_student.php"><div class = 'btn btn-primary'>Create New Student</div></a><br><br>
        <form method = "post" action = "student.php">
            <input autocomplete="off"  id = 'x' class = "form-control" type = "text" name = 'search' value = "<?PHP echo $a; ?>" onfocus="this.value = this.value;">
            <input class = 'btn btn-success' type = 'submit' value = 'search'>
            <?php
            if ($a) {
                echo "<a class = 'btn btn-danger' href = 'student.php'>Cancel</a>";
            }
            ?>
        </form>
        <br>
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

            //Determine query for sort and order
            if ($sort == 1 and $ord[$sort] == 1){
                $order = 'id';
                $dir = 'ASC';
            }
            if ($sort == 1 and $ord[$sort] == 0){
                $order = 'id';
                $dir = 'DESC';
            }
            if ($sort == 2 and $ord[$sort] == 1){
                $order = 'name';
                $dir = 'ASC';
            }
            if ($sort == 2 and $ord[$sort] == 0){
                $order = 'name';
                $dir = 'DESC';
            }
            if ($sort == 3 and $ord[$sort] == 1){
                $order = 'class';
                $dir = 'ASC';
            }
            if ($sort == 3 and $ord[$sort] == 0){
                $order = 'class';
                $dir = 'DESC';
            }
            if ($sort == 4  and $ord[$sort] == 1){
                $order = 'dob';
                $dir = 'ASC';
            }
            if ($sort == 4 and $ord[$sort] == 0){
                $order = 'dob';
                $dir = 'DESC';
        }
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

</body>

</html>