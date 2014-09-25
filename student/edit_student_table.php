
<!doctype HTML>
<html>
<head>
    <title>Edit Student Data
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <style>
    #creatediv{
        margin: 20px;
    }
    form{
        width: 600px;
    }
    </style>
    <?php
    require "include_login.php";
    require "include_dbase.php";
    
    //Fetching student information
    $q = $dbh -> prepare("SELECT * FROM student WHERE id = ?;");
    $q -> bindParam(1, $_GET['id']);
    $q -> execute();
    $student = $q -> fetch();

    //Updating table
    if ($_POST['editbutton']) {
        $q = $dbh -> prepare("UPDATE student SET name = ?, class = ?, dob = ? WHERE id = ?;");
        $q -> bindParam(1, $_POST['name']);
        $q -> bindParam(2, $_POST['class']);
        $q -> bindParam(3, $_POST['dob']);
        $q -> bindParam(4, $_POST['id']);
        $q -> execute();
        header("Location: student.php?ed=".$_POST['id']."&page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']);
    }
?>
</head>
<body>
<div id = "creatediv">
    <form class = "form-horizontal" method = "post" action = "<?php echo "edit_student_table.php?page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']; ?>">
        <h2>
            Student Information:
        </h2>
        <div class = "form-group">
            <label class = "col-sm-2 control-label">
                Id:
            </label>
            <div class = "col-sm-10">
                <input class = "form-control" type = "text" name = "id" value = "<?php echo $student['id'] ?>" readonly>
            </div>
        </div>
        <div class = "form-group">
            <label class = "col-sm-2 control-label">
                Name:
            </label>
            <div class = "col-sm-10">
                <input class = "form-control" type = "text" name = "name" value = "<?php echo $student['name'] ?>">
            </div>
        </div>
        <div class = "form-group">
            <label class = "col-sm-2 control-label">
                Class:
            </label>
            <div class = "col-sm-10">
                <input class = "form-control" type = "text" name = "class" value = "<?php echo $student['class'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label class = "col-sm-2 control-label">
                Date Of Birth:
            </label>
            <div class = "col-sm-10">
                <input class = "form-control" type = "date" name = "dob" value = "<?php echo $student['dob'] ?>">
            </div>
        </div>
        <div class = "col-sm-offset-2 col-sm-10">
            <input class = "btn btn-primary" type="submit" name="editbutton"  value="Update">
            <?php
            echo "<a class='btn btn-success' href = 'student.php?page=".$_GET['page']."&sort=".$_GET['sort']."&ord=".$_GET['ord']."'>Back to view</a>";
            ?>
        </div>
    </form>
    <br><br>
    
</div>
</body>
</html>