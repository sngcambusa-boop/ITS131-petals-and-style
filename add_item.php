<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$error = '';

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // We use real_escape_string for the name because users might type an apostrophe (e.g., "Mother's Day Bouquet")
    $flower_name = $conn->real_escape_string($_POST['flower_name']);
    $price = (float)$_POST['price'];
    $stock_qty = (int)$_POST['stock_qty'];

    // Insert the new item into the database
    $insertQuery = "INSERT INTO tbl_flowers (flower_name, price, stock_qty) 
                    VALUES ('$flower_name', $price, $stock_qty)";
    
    if ($conn->query($insertQuery)) {
        // Redirect back to the inventory tab with a success message
        header("Location: records.php?msg=item_added");
        exit();
    } else {
        $error = "Error adding to database: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="system-page">
    <div class="system-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar__brand">
                <i class="fa-solid fa-flower-daffodil"></i>
                <span>Petals & Style</span>
            </div>
            <nav class="sidebar__nav">
                <a href="dashboard.php" class="sidebar__link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                <a href="records.php" class="sidebar__link active"><i class="fa-solid fa-table-list"></i> Records</a>
                <a href="reports.php" class="sidebar__link"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a href="profile.php" class="sidebar__link"><i class="fa-solid fa-user"></i> Profile</a>
            </nav>
            <div class="sidebar__footer">
                <a href="logout.php" class="sidebar__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
        </aside>
        
        <main class="system-main">
            <header class="system-header">
                <h2>Add New Product</h2>
                <div class="system-header__actions">
                    <a href="records.php" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Records</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card" style="max-width: 500px; margin: 0 auto; border-top: 4px solid #10b981;">
                    <h3 style="margin-bottom: 20px; color: #047857;"><i class="fa-solid fa-seedling"></i> Create Catalog Item</h3>
                    
                    <?php if($error) echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 15px;'>$error</p>"; ?>

                    <form method="POST" action="">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Flower / Arrangement Name <span class="required">*</span></label>
                            <input type="text" name="flower_name" required placeholder="e.g., Spring Tulip Bundle" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Unit Price (₱) <span class="required">*</span></label>
                            <input type="number" step="0.01" min="0" name="price" required placeholder="0.00" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Starting Stock Quantity <span class="required">*</span></label>
                            <input type="number" min="0" name="stock_qty" required placeholder="0" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <button type="submit" class="btn btn--primary btn--full" style="background-color: #10b981; border-color: #10b981;">Add to Inventory</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>