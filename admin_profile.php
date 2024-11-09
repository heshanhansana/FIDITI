<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: admin_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Edit Profile</title>
</head>
<body>

    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <br><h3 align="center">Update Admin Information</h3><br>


    <div class="col-md-6 offset-3">
    
    <!-- update profile  -->
       <?php
            if(isset($_POST["submit"])){
                $update_user_name = $_POST["update_username"];
                $update_email = $_POST["update_email"];
                $current_password = $_POST["current_password"];
                $password_hash = $_SESSION["password_hash"];
                $new_password = $_POST["new_password"];
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $confirm_new_password = $_POST["confirm_new_password"];

                $errors =  array();

                // error handling
                if(empty($update_user_name) OR empty($update_email) OR empty($current_password) OR empty($new_password) OR empty($confirm_new_password)){
                    array_push($errors, "All fields are required");
                }

                if(!password_verify($current_password, $password_hash)){
                    array_push($errors, "Current password is wrong");
                }

                if(strlen($new_password < 8)){
                    array_push($errors, "Paassword must be at least 8 charactes long");
                }

                if($new_password !== $confirm_new_password){
                    array_push($errors, "Password does not match");
                } 

                if(count($errors) > 0){
                    foreach($errors as $error){
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }

                else{
                    require_once "database.php";
                    $stmt = $conn->prepare("UPDATE admin SET admin_name = ?, email = ?, password = ? WHERE email = ?");
                    $stmt->bind_param("ssss", $update_user_name, $update_email, $new_password_hash, $_SESSION['email']);
                
                    if ($stmt->execute()) {
                        $_SESSION["password_hash"] = $new_password_hash;
                        $_SESSION["user"] = $update_user_name;
                        echo "<div class='alert alert-success'>Profile Update Success !</div>";
                        $_SESSION["email"] = $update_email;
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }
            }
        ?>



        
    <!-- delete profile  -->
        <?php
            if(isset($_POST["delete_account"])){
                $sql = "DELETE FROM admin WHERE email= '".$_SESSION['email']."'";
                require_once "database.php";

                if ($conn->query($sql) === TRUE) {
                    header("Location: logout.php");
                  } 
                  
                  else {
                    echo "Error deleting record: " . $conn->error;
                }
            }
        ?>



            
        <form action="admin_profile.php" method="post">

            <?php
                $current_user = $_SESSION['user'];
                $sql = "SELECT * FROM admin WHERE admin_name = '$current_user'";

                require_once "database.php";
                $result = mysqli_query($conn, $sql);

                if($result){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                    
                        ?>

                        <div class="form-group">
                            <input type="text" name="update_username" class="form-control" value="<?php echo $row['admin_name']; ?>">
                        </div>

                        <div class="form-group">
                            <input type="email" name="update_email" class="form-control" value=<?php echo $row['email']; ?>>
                        </div>

                        <div class="form-group">
                            <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                        </div>

                        <div class="form-group">
                            <input type="password" name="new_password" class="form-control" placeholder="New Password">
                        </div>

                        <div class="form-group">
                            <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password">
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update" name="submit" class="btn btn-success">
                            <input type="submit" value="Delete Account" name="delete_account" class="btn btn-danger">
                        </div>

                            <?php
                        }
                    }
                }

            ?>
        </form>

    </div>
    
</body>
</html>