<?php

session_start();
if(!isset($_SESSION["user"])){
    header("Location: loin.php");
}



// Get selected item IDs and quantities from the form
$selected_items = $_POST['items'];
$item_quantities = $_POST['quantities'];
$status = $_POST['status'];



require_once "database.php";
// Retrieve details of selected items
$item_details = [];



if ($selected_items) {
    $item_ids_str = implode(",", $selected_items);
    $sql = "SELECT * FROM food_item WHERE item_id IN ($item_ids_str)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_details[] = $row;
        }
    }
}



// Calculate total price
$total_price = 0;
$qua_array = [];
foreach ($item_details as $item) {
    $quantity = $item_quantities[$item['item_id']] ?? 1; // Default to 1 if quantity not provided
    $qua_array[] = $item_quantities[$item['item_id']];
    $total_price += $item['price'] * $quantity;
}



// Insert order into the "order" table
if ($item_details) {
    $order_items = "";
    foreach ($item_details as $item) {
        $order_items .= $item['item_name'] . " x " . $item_quantities[$item['item_id']] . ", ";
    }

    $order_items = rtrim($order_items, ", "); // Remove trailing comma
    $customer_id = $_SESSION["id"];

    $sql_customer_order = "INSERT INTO customer_order (customer_id, price, status) VALUES ($customer_id, $total_price, '$status')";

    $order_id = 0;

    if ($conn->query($sql_customer_order) === TRUE) {
        $order_id = $conn->insert_id;
        //header("Location: customer_dashboard.php?order=true");

    } else {
        echo "Error: " . $sql_customer_order . "<br>" . $conn->error;
    }  


    $sql_order_item = "INSERT INTO order_item(order_id, item_id, quantity) VALUE(?,?,?)";
    $stmt = $conn->prepare($sql_order_item);

    if ($stmt) {
        $stmt->bind_param("iii", $order_id, $item_id, $quantity);

        for ($i = 0; $i < count($selected_items); $i++) {
            $item_id = $selected_items[$i];
            $quantity = $qua_array[$i];
            $stmt->execute();
        }

        $stmt->close();
        header("Location: customer_dashboard.php?order=true"); 

    } else {
        echo "Error: " . $conn->error;
    }




} else {
    header("Location: place_order.php?error=true");
}

$conn->close();
?>
