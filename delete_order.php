<?php
session_start();
require_once 'db.php';

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if an order ID was sent in the URL
if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];

    // 1. Fetch the order details first so we know what to restock
    $checkOrder = $conn->query("SELECT flower_id, qty_ordered FROM tbl_orders WHERE order_id = $order_id");
    
    if ($checkOrder && $checkOrder->num_rows > 0) {
        $orderData = $checkOrder->fetch_assoc();
        $flower_id = $orderData['flower_id'];
        $qty_to_return = $orderData['qty_ordered'];

        // 2. Put the flowers back into the stock inventory
        $conn->query("UPDATE tbl_flowers SET stock_qty = stock_qty + $qty_to_return WHERE flower_id = $flower_id");

        // 3. Delete the actual order record
        $conn->query("DELETE FROM tbl_orders WHERE order_id = $order_id");
        
        // Redirect back to records with a success message in the URL
        header("Location: records.php?msg=deleted");
        exit();
    }
}

// If something fails or the ID is missing, redirect with an error
header("Location: records.php?msg=error");
exit();
?>