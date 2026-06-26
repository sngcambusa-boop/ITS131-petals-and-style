<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

if (isset($_GET['id'])) {
    $flower_id = (int)$_GET['id'];
    
    // Attempt to delete the product
    $deleteQuery = "DELETE FROM tbl_flowers WHERE flower_id = $flower_id";
    
    if ($conn->query($deleteQuery)) {
        // Success!
        header("Location: records.php?msg=item_deleted");
    } else {
        // Error 1451 means the item is tied to an existing order in tbl_orders
        if ($conn->errno == 1451) {
            header("Location: records.php?msg=item_delete_fk_error");
        } else {
            header("Location: records.php?msg=error");
        }
    }
} else {
    header("Location: records.php");
}
exit();
?>