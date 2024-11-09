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
    <title>My Activity</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  


    <div class="container">

<!-- orders  -->        
        <br><h3>My Orders</h3><br>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Order Items</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
            </tr></thead>
            <tbody>

        <?php
            require_once "database.php";

            $user_id = $_SESSION['id'];
            //$sql = "SELECT price, status FROM customer_order WHERE customer_id = $user_id";

            /* $sql = "SELECT
            item_name , quantity , status, customer_order.price
            FROM order_item, customer_order, customer , food_item
            WHERE (order_item.order_id = customer_order.order_id) 
            AND (customer.customer_id = customer_order.customer_id)
            AND (food_item.item_id = order_item.item_id)";
            */

            $sql= "SELECT 
            customer_order.order_id,
            GROUP_CONCAT(CONCAT(food_item.item_name, ' x ', order_item.quantity) SEPARATOR ', ') AS order_items,
            customer_order.status,
            customer_order.price
            FROM 
            order_item
            JOIN 
            customer_order ON order_item.order_id = customer_order.order_id
            JOIN 
            customer ON customer.customer_id = customer_order.customer_id
            AND customer.customer_id = $user_id
            JOIN 
            food_item ON food_item.item_id = order_item.item_id
            GROUP BY 
            customer_order.order_id, customer_order.status, customer_order.price";



            $result = mysqli_query($conn, $sql);
           // $result_order_items = mysqli_query($conn, $sql_order_items);

            if($result){
                if(mysqli_num_rows($result) > 0){
                    $order_no = 1;
                    while($row = mysqli_fetch_array($result)){

                        ?>
                        <tr>
                        <th scope="row"><?php echo $order_no; ?></th>
                        <td><?php echo $row['order_items'];?></td>
                        <td><?php echo "Rs. " .$row['price']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        </tr>
                        <?php
                    }
                }
            }


            if($result){
                if(mysqli_num_rows($result) > 0){
                    $order_no = 1;
                    while($row = mysqli_fetch_array($result)){

                ?>

                <tr>
                    <th scope="row"><?php echo $order_no; ?></th>
                    <td><?php  ?></td>
                    <td><?php echo "Rs. " .$row['price']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                        
                        
                <?php
                    $order_no++;
                } ?>  
                </tbody></table><?php
            }else{
                echo "<div class='alert alert-success'>No Orders</div>";
            } 
        } ?>






<!-- Reservatios  -->

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Reservation Date</th>
                <th scope="col">Time</th>
                <th scope="col">Table No</th>
                <th scope="col">For</th>
                <th scope="col">Status</th>
            </tr></thead>
            <tbody>

        <?php
        
            echo "<br><h3>My Resevations</h3><br>";
            require_once "database.php";
            
            $user_id = $_SESSION['id'];

            $sql = "SELECT reservation.table_id, reservation_date, capacity, status, time 
            FROM reservation, restaurant_table 
            WHERE (customer_id = '$user_id' AND reservation.table_id = restaurant_table.table_id) 
            ORDER BY reservation_date";
            
            $result = mysqli_query($conn, $sql);

            if($result){
                if(mysqli_num_rows($result) > 0){
                    $order_no = 1;
                    while($row = mysqli_fetch_array($result)){

                ?>

                <tr>
                    <th scope="row"><?php echo $order_no; ?></th>
                    <td><?php echo $row['reservation_date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo "No " .$row['table_id']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                        
                        
                <?php
                    $order_no++;
                } ?>  
                </tbody></table><?php
            }else{
                echo "<div class='alert alert-success'>No Reservations</div>";
            }   
        }
        ?>

    </div>

</body>
</html>