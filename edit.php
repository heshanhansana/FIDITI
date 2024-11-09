<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: admin_login.php");
    }
?>

<?php

    require_once "database.php";

    if(isset($_POST["update_item"])){
        $id = $_POST["id"];
        $name = $_POST["update_item_name"];
        $description = $_POST["update_description"];
        $price = $_POST["update_price"];
        $category = $_POST["update_category"];

        $stmt = $conn->prepare("UPDATE food_item SET item_name = ?, category = ?, description = ?, price = ? WHERE item_id = ?");
        $stmt->bind_param("ssssi", $name, $category, $description, $price, $id);

        if ($stmt->execute()) {
            header("Location: manage_items.php?updated=true"); 
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Retrieve record ID from form (if submitted) or URL
    $id = (isset($_POST["id"])) ? $_POST["id"] : $_GET["id"];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM food_item WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Edit Items</title>
</head>
<body>


    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="container_1">

    <h3 align="center">Edit Food Item</h3><br>
    <form action="edit.php" method="post">

        <div class="form-row" align="center">
            <input type="hidden" name="id" value="<?php echo $row["item_id"]; ?>">

            <div class="col-md-3 mb-3">
                <input type="text" name="update_item_name" class="form-control" value="<?php echo $row['item_name']; ?>"></div>
                                    
            <div class="col-md-2 mb-3">
                <input type="number" name="update_price" class="form-control" min="1" max="10000"value=<?php echo $row['price']; ?>></div>

            <div class="col-md-3 mb-3">
                <input type="text" name="update_description" class="form-control" value="<?php echo $row['description']; ?>"></div>

            <div class="col-md-2 mb-3">
                <select class="form-control" name="update_category">
                    <option value="Beverage"<?php if ($row['category'] === 'Beverage') echo 'selected'; ?>>Beverage</option>
                    <option value="Meal" <?php if ($row['category'] === 'Meal') echo 'selected'; ?>>Meal</option>
                    <option value="Dessert" <?php if ($row['category'] === 'Dessert') echo 'selected'; ?>>Dessert</option>
                </select></div>

            <div class="col-md-2 mb-3">
                <input type="submit" value="Update" name="update_item" class="btn btn-info"></div>

    </form>

    </div>
</body>
</html>

<?php
} else {
    echo "Record not found!";
}

$stmt->close();
$conn->close();
?>
