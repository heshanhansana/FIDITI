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
    <title>Customers</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  

    
    <div class="container">
        <br><h3>Customer Details</h3><br>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Full Name</th>
                <th scope="col">Address</th>
                <th scope="col">Email</th>
            </tr></thead>
            <tbody>

        <?php
            require_once "database.php";
            $sql = "SELECT customer_name, address, email FROM customer";
            $result = mysqli_query($conn, $sql);

            if($result){
                if(mysqli_num_rows($result) > 0){
                    $customer_no = 1;
                    while($row = mysqli_fetch_array($result)){

                ?>

                <tr>
                    <th scope="row"><?php echo $customer_no; ?></th>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                        
                        
                <?php
                    $customer_no++;
                } ?>  
                </tbody></table><?php
            }
        }else{
            echo "<div class='alert alert-danger'>No Records</div>";
        }
     ?>

    </div>

</body>
</html>