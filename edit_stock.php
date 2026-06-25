<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$error = '';
$success = '';
$flower_data = null;

// 1. Process the update if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flower_id = (int)$_POST['flower_id'];
    $price = (float)$_POST['price'];
    $stock_qty = (int)$_POST['stock_qty'];

    // Update query
    $updateQuery = "UPDATE tbl_flowers SET price = $price, stock_qty = $stock_qty WHERE flower_id = $flower_id";
    
    if ($conn->query($updateQuery) === TRUE) {
        // Redirect back to records with a success message
        header("Location: records.php?msg=stock_updated");
        exit();
    } else {
        $error = "Error updating database: " . $conn->error;
    }
}

// 2. Fetch the current flower data based on the URL ID
if (isset($_GET['id'])) {
    $flower_id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM tbl_flowers WHERE flower_id = $flower_id");
    
    if ($result && $result->num_rows > 0) {
        $flower_data = $result->fetch_assoc();
    } else {
        $error = "Item not found in database.";
    }
} else {
    // If someone tries to visit edit_stock.php directly without clicking a link
    header("Location: records.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock - Petals & Style</title>
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
                <h2>Edit Inventory Stock</h2>
                <div class="system-header__actions">
                    <a href="records.php" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Records</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card" style="max-width: 500px; margin: 0 auto;">
                    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-boxes-stacked"></i> Update Item</h3>
                    
                    <?php if($error) echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px;'>$error</p>"; ?>

                    <?php if($flower_data): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="flower_id" value="<?php echo $flower_data['flower_id']; ?>">
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Flower / Arrangement Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($flower_data['flower_name']); ?>" disabled style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; background: #f8fafc; color: #64748b;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Unit Price (₱) <span class="required">*</span></label>
                            <input type="number" step="0.01" min="0" name="price" value="<?php echo $flower_data['price']; ?>" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Current Stock Quantity <span class="required">*</span></label>
                            <input type="number" min="0" name="stock_qty" value="<?php echo $flower_data['stock_qty']; ?>" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <button type="submit" class="btn btn--primary btn--full">Save Changes</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>