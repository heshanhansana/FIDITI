<?php

require_once "database.php";

// Retrieve record ID from URL
$id = $_GET["id"];

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM food_item WHERE item_id = ?");
$stmt->bind_param("i", $id);

// Execute deletion and check for success
if ($stmt->execute()) {
    header("Location: manage_items.php?deleted=true"); 
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
