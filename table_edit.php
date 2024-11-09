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
        $category = $_POST["update_category"];

        print_r($id);

        $stmt = $conn->prepare("UPDATE restaurant_table SET capacity = ? WHERE table_id = ?");
        $stmt->bind_param("si", $category, $id);

        if ($stmt->execute()) {
            header("Location: manage_tables.php?updated=true"); 
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Retrieve record ID from form (if submitted) or URL
    $id = (isset($_POST["id"])) ? $_POST["id"] : $_GET["id"];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM restaurant_table WHERE table_id = ?");
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
    <title>Edit Table</title>
</head>
<body>


    <header>
        <?php
            include('navigation.php');
        ?>
    </header>


    <div class="container_1">

    <h3 align="center">Edit Table</h3><br>
    <form action="table_edit.php" method="post">

        <div class="form-row" align="center">
            <input type="hidden" name="id" value="<?php echo $row["table_id"]; ?>">

            <div class="col-md-2 mb-3"></div>

            <div class="col-md-2 mb-3">
                <?php echo "<h5>Table " .$row["table_id"]. " :</h5>"; ?>
            </div>

            <div class="col-md-3 mb-3">
                <select class="form-control" name="update_category">
                    <option value="Family"<?php if ($row['capacity'] === 'Family') echo 'selected'; ?>>Family</option>
                    <option value="Couple" <?php if ($row['capacity'] === 'Couple') echo 'selected'; ?>>Couple</option>
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
