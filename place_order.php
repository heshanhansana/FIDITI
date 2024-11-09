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
    <title>Place An Order</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>  


    <div class="container">

        <form action="order_process.php" method="post">

        <?php
            if (array_key_exists("error", $_GET)) {
                echo "<br><div class='alert alert-danger'>Sorry, Item not selected !</div>";
            }
        ?>

        <?php
            require_once "database.php";
            $sql_meal = "SELECT * FROM food_item WHERE category='meal'";
            $sql_beverages = "SELECT * FROM food_item WHERE category='beverage'";
            $sql_dessert = "SELECT * FROM food_item WHERE category='dessert'";

            $result_meal = mysqli_query($conn, $sql_meal);
            $result_beverage = mysqli_query($conn, $sql_beverages);
            $result_dessert = mysqli_query($conn, $sql_dessert);

            ?>



<!--     Meals     -->      
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    </tr>
                </thead><tbody>

                <br><h3>Meals</h3>

            <?php

            if($result_meal){
                if(mysqli_num_rows($result_meal) > 0){
                    while($row = mysqli_fetch_array($result_meal)){
                        $item_id = $row['item_id'];
                        $item_name = $row['item_name'];
                        $item_price = $row['price'];
                ?>

                    <tr>
                    <td><div class="form-check">
                            <?php echo "<input type='checkbox' name='items[]' value='$item_id'>"; ?>
                        </div></td>  
                        <th scope="row"><?php echo $row['item_name']; ?></th>
                        <td><?php echo 'Rs. '.$row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo"<input type='number' name='quantities[$item_id]' min='1' max='50' value='1' class='col-md-4 mb-3 form-control'/>" ;?></td>
                    </tr>

                        
                    <?php
                    }?> 
                    </tbody></table><?php 
                        
                }
                }else{
                    echo "<div class='alert alert-danger'>No Beverages</div>";
                }
                ?> 


 



<!--     Beverages     -->
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    </tr>
                </thead><tbody>

                <br><h3>Beverages</h3>

            <?php

            if($result_beverage){
                if(mysqli_num_rows($result_beverage) > 0){
                    while($row = mysqli_fetch_array($result_beverage)){
                        $item_id = $row['item_id'];
                        $item_name = $row['item_name'];
                        $item_price = $row['price'];
                ?>

                    <tr>
                        <td><div class="form-check">
                            <?php echo "<input type='checkbox' name='items[]' value='$item_id'>"; ?>
                        </div></td>  
                        <th scope="row"><?php echo $row['item_name']; ?></th>
                        <td><?php echo 'Rs. '.$row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo"<input type='number' name='quantities[$item_id]' min='1' max='50' value='1' class='col-md-4 mb-3 form-control'/>" ;?></td>
                    </tr>

                        
                    <?php
                    }?> 
                    </tbody></table><?php 
                        
                }
                }else{
                    echo "<div class='alert alert-danger'>No Beverages</div>";
                }
                ?>





<!--       Desserts        -->
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    </tr>
                </thead><tbody>

                <br><h3>Desserts</h3>

            <?php

            if($result_dessert){
                if(mysqli_num_rows($result_dessert) > 0){
                    while($row = mysqli_fetch_array($result_dessert)){
                        $item_id = $row['item_id'];
                        $item_name = $row['item_name'];
                        $item_price = $row['price'];
                ?>

                    <tr>
                        <td><div class="form-check">
                            <?php echo "<input type='checkbox' name='items[]' value='$item_id'>"; ?>
                        </div></td>  
                        <th scope="row"><?php echo $row['item_name']; ?></th>
                        <td><?php echo 'Rs. '.$row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo"<input type='number' name='quantities[$item_id]' min='1' max='50' value='1' class='col-md-4 mb-3 form-control'/>" ;?></td>
                    </tr>

                        
                    <?php
                    }?> 
                    </tbody></table><?php 
                        
                }
                }else{
                    echo "<div class='alert alert-danger'>No Beverages</div>";
                }
                ?>
            
            <div class="form-btn" align="center">
                <input type="reset" value="Clear" class="btn btn-info">
                <input type="hidden" name="status" value="Pending">
                <input type="submit" name="place_order" value="Place Order" class="btn btn-primary"/></div><br><br><br></div>

        </form>

</body>
</html>