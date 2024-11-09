<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="dashboard.css">
    <title>User Dashboard</title>
</head>
<body>

    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="container">

        <br><h2  align="center">Welcome To Customer Dashboard</h2><br>

        <?php
            if (array_key_exists("order", $_GET)) {
                echo "<div class='alert alert-success'>You Just Make An Order !</div>";
            }
        ?>

        
        
        <a href="place_order.php"><button type="button" class="btn btn-success btn-lg btn-block">Place an Order</button></a><br>
        <a href="table_reservation.php"><button type="button" class="btn btn-success btn-lg btn-block">Make a Reservation</button></a><br>
        <a href="my_orders.php"><button type="button" class="btn btn-success btn-lg btn-block">My Activity</button></a><br>
        <a href="profile.php"><button type="button" class="btn btn-success btn-lg btn-block">Edit Profile</button></a><br><br>


        <a href="logout.php"><button type="button" class="btn btn-warning btn-lg btn-block">Logout</button></a>


    </div>
    
</body>
</html>