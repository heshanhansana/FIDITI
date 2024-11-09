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
    <title>Manage Tables</title>
</head>
<body>
    
    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="container_1">
    <h3 align="center">Add Table</h3><br>


    <?php
      require_once "database.php";

      if(isset($_POST["add_table"])){
        $category = $_POST["category"];

        $sql = "INSERT INTO restaurant_table(capacity) VALUES(?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            
        if($prepareStmt){
            mysqli_stmt_bind_param($stmt, "s", $category);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'> Table Successfuly !</div>";
        }

        else{
            die("Item doesn't added !");
        }
      } 
    ?>



<!-- add   -->   
        <form class="col-md-6 offset-3 " novalidate action="manage_tables.php" method="POST">

            <div class="form-row">

                <div class="col-md-5 mb-3">
                    <select class="form-control" name="category">
                        <option value="Family">Family</option>
                        <option value="Couple">Couple</option>
                    </select></div> 

                <div class="col-md-5 mb-3">
                    <input type="submit" name="add_table" value="Add Table" class="btn btn-primary"/></div>

            </div> 
        </form>

    </div>
      
    



<!-- update & delete    -->
    <div class="container_1">
    <h3 align="center">Update or Delete Tables</h3><br>

    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col">#</th>
            <th scope="col">Table</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th> 
        </tr></thead>
        <tbody>
            
            
    <?php

        if (array_key_exists("deleted", $_GET)) {
            echo "<div class='alert alert-success'>Table Delete Success !</div>";
        }
   
        if(array_key_exists("updated", $_GET)) {
            echo "<div class='alert alert-success'>Table Update Success !</div>";
        }

        $sql = "SELECT * FROM restaurant_table";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $item_no = 1;
            while ($row = $result->fetch_assoc()) {
                    //print_r($row);
            ?>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <th scope="row"><?php echo $item_no; ?></th>
                <td><?php echo "No " .$row['table_id']; ?></td>
                <td><?php echo $row['capacity']; ?></td>
                <td><?php echo "<a href='table_edit.php?id=" . $row["table_id"] . "'><input type='button' value='Update' class='btn btn-success'> </a>  <a href='table_delete.php?id=" . $row["table_id"] . "'><input type='button' value='Delete' class='btn btn-danger'></a>"?></td>
            </tr>

            <?php
                $item_no++;
            }
        }?>

    </div>

</body>
</html>
