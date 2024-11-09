<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: admin_dashboard.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Admin Login</title>
</head>
<body>

    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="col-md-6 offset-3">
        <br><h3 align="center">Admin Login</h3><br>
           
        <?php

            if(isset($_POST['login'])){
                require_once "database.php";
                $email = $_POST['email'];
                $password = $_POST['password'];

                $sql = "SELECT * FROM admin WHERE email= '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                //print_r($user);

                // check eamil and password
                if($user){
                    if(password_verify($password, $user["password"])){
                        session_start();
                        $_SESSION["user"] = $user['admin_name'];
                        $_SESSION["password_hash"] = $user['password'];
                        $_SESSION["email"] = $user['email'];
                        $_SESSION["states"] = "admin";
                        header("Location: admin_dashboard.php");
                        die();
                    }
                    else{
                        echo "<div class='alert alert-danger'>Password dose not match</div>";
                    }
                }

                else{
                    echo "<div class='alert alert-danger'>Email dose not match</div>";
                }
            } 
        ?>



        <form action="admin_login.php" method="post">

            <div class="form-group">
                <input type="text" name="email" placeholder="Enter Email" class="form-control"/>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Enter Password" class="form-control"/>
            </div>

            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary"/>
            </div>

        </form>
        
    </div>

</body>
</html>