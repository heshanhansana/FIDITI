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
    <title>Analize Report</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  

    <div class="container">

    <br><h3 align = "center">Analyze Report</h3>

    <div class="container">
        <hr><h4>Reservations</h4>

        <?php

        require_once "database.php";

        $sql = "SELECT
        COUNT(reservation_id) AS total_reservation,
        SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active_reservation,
        SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS closed_reservation
        FROM reservation ";
    
        $result = mysqli_query($conn, $sql);
            
        if($result){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                echo "<p>Total : " .$row['total_reservation']. "<br> Completed : " .$row['closed_reservation']. "<br> Pending : " .$row['active_reservation']. " </>";
                
            }
        }
        ?>
    </div>   
    


    <div class="container">
        <hr><h4>Orders</h4>

        <?php

        require_once "database.php";

        $sql = "SELECT
        COUNT(order_id) AS total_orders,
        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending_orders,
        SUM(CASE WHEN status = 'Complete' THEN 1 ELSE 0 END) AS closed_orders
        FROM customer_order ";
    
        $result = mysqli_query($conn, $sql);
            
        if($result){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                echo "<p>Total : " .$row['total_orders']. "<br> Completed : " .$row['closed_orders']. "<br> Pending : " .$row['pending_orders']. " </>";
                
            }
        }
        ?>
    </div>   



    <div class="container">
        <hr><h4>Top 10 Customers</h4>
        <table width="600px">
            <thead>
                <tr>
                <th scope="col"># </th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Orders</th>
                <th scope="col">Total Spend</th>
            </tr></thead>
            <tbody>

            <?php

            require_once "database.php";

            $sql = "SELECT
            c.customer_id,
            c.email,
            c.customer_name,
            COUNT(o.order_id) AS order_count,
            SUM(o.price) AS total_spend
            FROM customer c
            JOIN customer_order o ON c.customer_id = o.customer_id
            GROUP BY c.customer_id, c.customer_name
            ORDER BY total_spend DESC 
            LIMIT 10";
        
            

            $result = mysqli_query($conn, $sql);
            
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $customer_no = 1;
                    while($row = mysqli_fetch_array($result)){
            
            
                ?>
            
            <tr>
                <th scope="row"><?php echo $customer_no; ?></th>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['order_count']; ?></td>
                    <td align="right"><?php echo "Rs.  " .$row['total_spend']. ".00"; ?></td>
                </tr>
                                    
                                    
            <?php
                $customer_no++;
            } ?>  
                </tbody></table><?php
                }
              }
        ?>
    </div>



    <div class="container">
        <hr><h4>Top 10 Selling Items</h4>

        <table width="400px">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Items</th>
                <th scope="col">Sold</th>
            </tr></thead>
            <tbody>

        <?php

        require_once "database.php";

        $sql = "SELECT
        fi.item_name AS most_selling_item,
        SUM(oi.quantity) AS total_quantity_sold
        FROM order_item oi
        JOIN food_item fi ON oi.item_id = fi.item_id
        GROUP BY oi.item_id
        ORDER BY total_quantity_sold DESC
        LIMIT 10";
        

        $result = mysqli_query($conn, $sql);
            
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $customer_no = 1;
                    while($row = mysqli_fetch_array($result)){
            
            
                ?>
            
            <tr>
                <th scope="row"><?php echo $customer_no; ?></th>
                    <td><?php echo $row['most_selling_item']; ?></td>
                    <td><?php echo $row['total_quantity_sold']; ?></td>
                </tr>
                                    
                                    
            <?php
                $customer_no++;
            } ?>  
                </tbody></table><?php
                }
              }
        ?>
    </div>


    </div>

</body>
</html>