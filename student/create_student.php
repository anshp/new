<!doctype HTML>
<html>
<head>
    <title>Create New Student
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap-theme.min.css">
    
    <style>
    a {
        
        margin-left: 40px;
    }
    h2{
        margin-left: 40px;
    }
    form{
        width: 600px;
    }
    </style>
    <?php
    require "include_login.php";
    require "include_dbase.php";

    //Create the student
    if ($_POST['createbutton']){
        $q = $dbh -> prepare("INSERT INTO student (id, name, class, dob) VALUES (NULL, ?,?,?);");
        $q -> bindParam(1, $_POST['name']);
        $q -> bindParam(2, $_POST['class']);
        $q -> bindParam(3, $_POST['dob']);
        $q -> execute();
        $msg = 'New student <b>'.$_POST['name'].'</b> created';
    }
    ?>
</head>
<body>
    <div id = "creatediv">
        <form method="post" action="create_student.php" class="form-horizontal">

        <?php
        if ($msg) {
            echo "<div class = 'col-sm-offset-1 alert alert-success'>".$msg."</div>";
        }
        ?>
            <h2>
                Enter Student Data:
            </h2>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Name:</label>
                <div class="col-sm-9">
                    <input class="form-control" type = "text" name = "name" placeholder = "Name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Class:</label>
                <div class="col-sm-9">
                    <input class="form-control" type = "text" name = "class" placeholder = "Class">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Date of Birth:</label>
                <div class="col-sm-9">
                    <input class="form-control" type = "date" name = "dob" placeholder = "Date of Birth">
                </div>
            </div>
         <div class="col-sm-offset-3">
            <input class='btn btn-primary' type="submit" name="createbutton"  value="Create">
            <a class='btn btn-success col-sm-offset-1' href = "student.php">Back to view</a>
         </div>

        </form>
    </div>
    
</body>
</html>
