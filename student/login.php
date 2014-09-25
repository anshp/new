<!doctype HTML>
<html>
<head>
    <title>Login / Signup
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
                $msg = "Username already exists";   
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
            header("Location: student.php");
        }
        else{
            $msg = "wrong username or password";
        }
    }   
    ?>

    <style>
    form{
        //border: 1px solid red;
    }

    h1{
        text-align:center;
        margin-left: 10px;
        font-size: 18px;
    }
    #left{text-align: left;}
    #d{
        width: 400px;
        margin-left: 200px;
    }
</style>
</head>

<body>
    <div id = "d">
        <form class = 'form-horizontal' method="post" action="login.php">
            <h1 >Login</h1><br>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    Username:
                </label>
                <div class="col-sm-9">
                    <input class = "form-control" type = "text" name = "name" placeholder = "Username" value ='abcd'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    Password:
                </label>
                <div class="col-sm-9">
                    <input class = "form-control" type = "password" name = "pass" placeholder = "Password" value ='pqrs'>
                </div>
            </div>
            <?php
            echo "<div class = 'col-sm-offset-3'>".$msg."</div>";
            ?>
            <input class = "col-sm-offset-3 col-sm-4 btn btn-primary" type="submit" name="signin"  value="Sign in">
            <input class = "col-sm-offset-1 col-sm-4 btn btn-success" type="submit" name="signup"  value="Sign up">
        </form>
    </div>
    
</body>
</html>