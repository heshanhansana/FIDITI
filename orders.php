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
    <title>Customer Orders</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  


    <div class="container">

        <br><h3 align="center">Customer Orders</h3><br>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Order Items</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>


            
        <?php
            require_once "database.php";

            if (array_key_exists("id", $_GET)) {
                $id = $_GET["id"];
                $status = "Complete";
                $stmt = $conn->prepare("UPDATE customer_order SET status = ? WHERE order_id = ?");
                $stmt->bind_param("si", $status, $id);
            
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Order Complete</div>";
                }
            }

           // $sql = "SELECT * FROM customer_order, customer WHERE status = 'Pending' AND customer.customer_id = customer_order.customer_id";
           
           $sql= "SELECT 
            customer_order.order_id, 
            customer.customer_name,
            GROUP_CONCAT(CONCAT(food_item.item_name, ' x ', order_item.quantity) SEPARATOR ', ') AS order_items,
            customer_order.status,
            customer_order.price
            FROM 
            order_item
            JOIN 
            customer_order ON order_item.order_id = customer_order.order_id
            JOIN 
            customer ON customer.customer_id = customer_order.customer_id
            JOIN 
            food_item ON food_item.item_id = order_item.item_id
            AND status = 'Pending'
            GROUP BY 
            customer_order.order_id, customer_order.status, customer_order.price";

           
           $result = mysqli_query($conn, $sql);

            if($result){
                if(mysqli_num_rows($result) > 0){
                    $order_no = 1;
                    while($row = mysqli_fetch_array($result)){

                ?>

                <tr>
                    <th scope="row"><?php echo $order_no; ?></th>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['order_items']; ?></td>
                    <td><?php echo "Rs. " .$row['price']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo "<a href='orders.php?id=" . $row["order_id"] . "'><input type='button' value='Complete' class='btn btn-outline-success'> </a>" ?> </td>
                </tr>
                        
                        
                <?php
                    $order_no++;
                } ?>  
                </tbody></table><?php

            }else{
                echo "<div class='alert alert-success'>No Pending Orders !</div>";
            }
        }
     ?>
    </div>

</body>
</html>