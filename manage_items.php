<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: admin_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Add Items</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="container_1">
    <h3 align="center">Add Items</h3><br>


    <?php
      require_once "database.php";

      if(isset($_POST["add_item"])){
        $item_name = $_POST["item_name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $errors =  array();

        if(empty($item_name) OR empty($description) OR empty($price) OR empty($category)){
            array_push($errors, "All fields are required");
        }

        $sql = "SELECT * FROM food_item WHERE item_name = '$item_name'";
        $result = $conn->query($sql);

        if($result -> num_rows > 0){
            array_push($errors, "This item already exist");
        }

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }

        else{
            $sql = "INSERT INTO food_item(item_name, category, description, price) VALUES(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            
            if($prepareStmt){
                mysqli_stmt_bind_param($stmt, "sssi", $item_name, $category, $description, $price);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>".$item_name." Added Successfuly !</div>";
            }

            else{
                die("Item doesn't added !");
            }
        }
      }
    ?>





<!-- add items   -->   
        <form class="needs-validation" novalidate action="manage_items.php" method="POST">
            <div class="form-row">

                <div class="col-md-3 mb-3">
                    <input type="text" name="item_name" placeholder="Name:" class="form-control"/></div>

                <div class="col-md-2 mb-3">
                    <input type="number" name="price" placeholder="Price:" min="1" max="10000"class="form-control"/></div>

                <div class="col-md-3 mb-3">
                    <textarea class="form-control" rows="1" name="description" placeholder="Description"></textarea></div>

                <div class="col-md-2 mb-3">
                    <select class="form-control" name="category">
                        <option value="Beverage">Beverage</option>
                        <option value="Meal">Meal</option>
                        <option value="Dessert">Dessert</option>
                    </select></div> 

                <div class="col-md-2 mb-3">
                    <input type="submit" name="add_item" value="Add Item" class="btn btn-primary"/></div>

            </div> 
        </form>

    </div>
      
    



<!-- update & delete items   -->
    <div class="container_1">
    <h3 align="center">Update or Delete Items</h3>

    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">No</th>
            <th scope="col">Item Name</th>
            <th scope="col">Price</th>
            <th scope="col">Description</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th> 
        </tr></thead>
        <tbody>
            
            
    <?php

        if (array_key_exists("deleted", $_GET)) {
            echo "<div class='alert alert-success'>Item Delete Success !</div>";
        }
   
        if(array_key_exists("updated", $_GET)) {
            echo "<div class='alert alert-success'>Item Update Success !</div>";
        }

        $sql = "SELECT * FROM food_item";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $item_no = 1;
            while ($row = $result->fetch_assoc()) {
                    //print_r($row);
            ?>

            <tr>
                <th scope="row"><?php echo $item_no; ?></th>
                <td><?php echo $row['item_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo "<a href='edit.php?id=" . $row["item_id"] . "'><input type='button' value='Update' class='btn btn-success'> </a>  <a href='delete.php?id=" . $row["item_id"] . "'><input type='button' value='Delete' class='btn btn-danger'></a>"?></td>
            </tr>

            <?php
                $item_no++;
            }
        }?>

    </div>

</body>
</html>
