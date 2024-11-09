<?php
    session_start();

    // if user not loged in
    if(!isset($_SESSION["user"])){
        header("Location: admin_dashboard.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Add New Admin</title>
</head>
<body>

<header>
    <?php
        include('navigation.php');
    ?>
</header>




<div class="col-md-6 offset-3">
    <br><h3 align="center">Add New Admin</h3><br>
   
    <?php
      if(isset($_POST["submit"])){
        $user_name = $_POST["user_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $repeat_password = $_POST["repeat_password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors =  array();

        // error handling
        if(empty($user_name) OR empty($email) OR empty($password) OR empty($repeat_password)){
            array_push($errors, "All fields are required");
        }

        if(strlen($password < 8)){
            array_push($errors, "Paassword must be at least 8 charactes long");
        }

        if($password !== $repeat_password){
            array_push($errors, "Password does not match");
        } 

        require_once "database.php";
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = $conn->query($sql);

        if($result -> num_rows > 0){
            array_push($errors, "Email already exist");
        }

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }

        else{

            // require_once "database.php";
            $sql = "INSERT INTO admin(admin_name, email, password) VALUES(?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            
            // to avoid sql injections
            if($prepareStmt){
                mysqli_stmt_bind_param($stmt, "sss", $user_name, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Registration Success !</div>";
            }

            else{
                die("Rgistration Unsuccess");
            }
        }
      }

    ?>
    



    <form action="add_admin.php" method="POST">
        <div class="form-group">
            <input type="text" name="user_name" placeholder="User Name:" class="form-control"/></div>

        <div class="form-group">
            <input type="email" name="email" placeholder="Email:" class="form-control"/></div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control"/></div>

        <div class="form-group">
            <input type="password" name="repeat_password" placeholder="Repeat Password" class="form-control"/></div>

        <div class="form-btn">
            <input type="submit" name="submit" value="Register" class="btn btn-primary"/></div>
    </form>


</div>

</body>
</html>