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
    <title>Reservations</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  


    <div class="container">

        <br><h3 align="center">Available Reservations</h3><br>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Reservation Date</th>
                <th scope="col">Time</th>
                <th scope="col">Table No</th>
                <th scope="col">For</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>


        <?php
            require_once "database.php";

            if (array_key_exists("id", $_GET)) {
                $id = $_GET["id"];
                $status = "Closed";
                $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ?");
                $stmt->bind_param("si", $status, $id);
            
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Reservation Closed</div>";
                }
            }
            

  
            $sql = "SELECT reservation_id, customer_name, reservation.table_id, capacity, reservation_date, status, time FROM restaurant_table, reservation, customer WHERE (reservation.table_id = restaurant_table.table_id AND status ='Active'AND reservation.customer_id = customer.customer_id  )ORDER BY reservation_date";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $reservation_no = 1;
                    while($row = mysqli_fetch_array($result)){

                    ?>

                <tr>
                    <th scope="row"><?php echo $reservation_no; ?></th>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['reservation_date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo "No ".$row['table_id']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>      
                    <td><?php echo $row['status']; ?></td>            
                    <td><?php echo "<a href='reservation.php?id=" .$row["reservation_id"]. "'><input type='button' value='Close' class='btn btn-outline-danger'> </a>" ?> </td>
                </tr>
                        
                        
                <?php
                    $reservation_no++;
                } ?>  
                </tbody></table><?php

            }else{
                echo "<div class='alert alert-success'>No Available Reservations !</div>";
            }
          }
          ?>
    </div>

</body>
</html>