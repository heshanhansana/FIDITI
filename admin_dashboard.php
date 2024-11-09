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
    <link rel="stylesheet" href="dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  

    <div class="container">
        <br><h2 align="center">Welcome To Admin Dashboard</h2><br>

        
        <a href="report.php"><button type="button" class="btn btn-success btn-lg btn-block">Analyze Report</button></a><br>
        <a href="reservation.php"><button type="button" class="btn btn-success btn-lg btn-block">Available Reservations</button></a><br>
        <a href="orders.php"><button type="button" class="btn btn-success btn-lg btn-block">Available Orders</button></a><br>
        <a href="add_admin.php"><button type="button" class="btn btn-success btn-lg btn-block">Add New Admins</button></a><br>
        <a href="manage_tables.php"><button type="button" class="btn btn-success btn-lg btn-block">Manage Table</button></a><br>
        <a href="manage_items.php"><button type="button" class="btn btn-success btn-lg btn-block">Customize Menue</button></a><br>
        <a href="customers.php"><button type="button" class="btn btn-success btn-lg btn-block">Customers</button></a><br>
        <a href="admin_profile.php"><button type="button" class="btn btn-success btn-lg btn-block">Edit Profile</button></a><br><br>

        <a href="logout.php"><button type="button" class="btn btn-warning btn-lg btn-block">Logout</button></a>


    </div>
    
</body>
</html>