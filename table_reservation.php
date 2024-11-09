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
    <link rel="stylesheet" href="style.css">
    <title>Table Reservations</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header> 


    <div class="container_1">
        <h3 align="center">Table Reservations</h3><br>

        <form class="needs-validation" novalidate action="table_reservation.php" method="POST">
            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <input type="date" name="date" class="form-control"/></div>

                <div class="col-md-3 mb-3">
                    <select class="form-control" name="time">
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Dinner">Dinner</option>
                    </select></div> 

                <div class="col-md-3 mb-3">
                    <select class="form-control" name="capacity">
                        <option value="Family">Family</option>
                        <option value="Couple">Couple</option>
                    </select></div> 

                <div class="col-md-2 mb-3">
                    <input type="submit" name="search_tables" value="Availeble Tables" class="btn btn-primary"/></div>

            </div> 
        </form>
    

   



    <?php
      require_once "database.php";
    
      if(isset($_POST["search_tables"])){
        $date = $_POST["date"];
        $time = $_POST["time"];
        $capacity = $_POST["capacity"];
        $errors =  array();
        
        if(empty($date)){
           array_push($errors, "Date is required");
        }

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }

        else{
            ?>

            <br><hr><h3 align="center">Available Tables</h3><br>
            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Table No</th>
                <th scope="col">For</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>

        
        
        <?php
           // $sql = "SELECT restaurant_table.id, capacity, reservation_date, time, status FROM reservation, restaurant_table WHERE (reservation_date <> '$date' AND reservation.table_id = restaurant_table.id AND status = 'Active' AND capacity = '$capacity')  OR (reservation_date = '$date' AND time <> '$time' AND reservation.table_id = restaurant_table.id AND capacity = '$capacity')";
           
            $sql = "SELECT rt.table_id, rt.capacity
            FROM restaurant_table rt
            WHERE rt.capacity = '$capacity'
            AND rt.table_id NOT IN (
                SELECT r.table_id
                FROM reservation r
                WHERE r.reservation_date = '$date'
                AND r.time = '$time'
                AND r.status <> 'Closed'
            )";     



            $result = mysqli_query($conn, $sql);
            
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $order_no = 1;
                    $Active = "Active";
                    while($row = mysqli_fetch_array($result)){


                    ?>
                
                <tr>
                    <td></td>
                    <td></td>
                    <th scope="row"><?php echo $order_no; ?></th>
                    <td><?php echo "No ".$row['table_id']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                    <td><?php echo "<a href='table_reservation.php?id=" . $row["table_id"] . "&date=" .$date. "&time=" .$time. "&status=" .$Active. "'><input type='button' value='Book Now' class='btn btn-warning'> </a>" ?> </td>
                </tr>
                        
                        
                <?php
                    $order_no++;
                } ?>  
                </tbody></table><?php

            }else{
                echo "<div class='alert alert-success'>No Available Tables !</div>";
            }
          }
        }
      }




      if (array_key_exists("id", $_GET)) {
        $table_id = $_GET["id"];
        $date = $_GET["date"];
        $time = $_GET["time"];
        $status = $_GET["status"];
        $customer_id = $_SESSION["id"];

        $formatted_date = date('Y-m-d', strtotime($date));

        $sql = "INSERT INTO reservation (customer_id, reservation_date, time, table_id, status) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issis", $customer_id, $formatted_date, $time, $table_id, $status);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            echo "<div class='alert alert-success'>Table Reservation Success !</div>";
        }
      }

     ?>

    </div>
</div>

</body>
</html>