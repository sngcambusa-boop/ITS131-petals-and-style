<?php
session_start();
require_once 'db.php';

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if a form was submitted with the necessary data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = (int)$_POST['order_id'];
    // Clean the input to prevent SQL injection
    $status = $conn->real_escape_string($_POST['status']);

    // Update the specific order
    $updateQuery = "UPDATE tbl_orders SET status = '$status' WHERE order_id = $order_id";
    
    if ($conn->query($updateQuery)) {
        header("Location: records.php?msg=status_updated");
        exit();
    }
}

// If something fails, redirect with an error
header("Location: records.php?msg=error");
exit();
?>