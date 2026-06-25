<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$error = '';
$flower_data = null;

// 1. Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flower_id = (int)$_POST['flower_id'];
    $spoilage_qty = (int)$_POST['spoilage_qty'];

    // First, check current stock
    $checkStock = $conn->query("SELECT stock_qty FROM tbl_flowers WHERE flower_id = $flower_id");
    if ($checkStock && $checkStock->num_rows > 0) {
        $current_stock = $checkStock->fetch_assoc()['stock_qty'];
        
        // Prevent them from spoiling more than they have
        if ($spoilage_qty > $current_stock) {
            $error = "You cannot report more spoilage than your current stock ($current_stock units).";
        } else {
            // Deduct the spoiled quantity from the database
            $updateQuery = "UPDATE tbl_flowers SET stock_qty = stock_qty - $spoilage_qty WHERE flower_id = $flower_id";
            if ($conn->query($updateQuery)) {
                header("Location: records.php?msg=spoilage_added");
                exit();
            } else {
                $error = "Error updating database: " . $conn->error;
            }
        }
    }
}

// 2. Fetch the flower details to show on the page
if (isset($_GET['id'])) {
    $flower_id = (int)$_GET['id'];
    $result = $conn->query("SELECT flower_id, flower_name, stock_qty FROM tbl_flowers WHERE flower_id = $flower_id");
    
    if ($result && $result->num_rows > 0) {
        $flower_data = $result->fetch_assoc();
    } else {
        $error = "Item not found in database.";
    }
} else if (!isset($_POST['flower_id'])) {
    header("Location: records.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Spoilage - Petals & Style</title>
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
                <h2>Report Spoilage</h2>
                <div class="system-header__actions">
                    <a href="records.php" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Records</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card" style="max-width: 500px; margin: 0 auto; border-top: 4px solid #f59e0b;">
                    <h3 style="margin-bottom: 20px; color: #b45309;"><i class="fa-solid fa-triangle-exclamation"></i> Log Wilted / Damaged Stock</h3>
                    <p style="color: #64748b; margin-bottom: 20px; font-size: 0.9rem;">Reporting spoilage will permanently remove these items from your active inventory.</p>
                    
                    <?php if($error) echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 15px;'>$error</p>"; ?>

                    <?php if($flower_data): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="flower_id" value="<?php echo $flower_data['flower_id']; ?>">
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Flower / Arrangement Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($flower_data['flower_name']); ?>" disabled style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; background: #f8fafc; color: #64748b;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Current Stock Available</label>
                            <input type="text" value="<?php echo $flower_data['stock_qty']; ?> units" disabled style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; background: #f8fafc; color: #64748b;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Quantity Spoiled <span class="required">*</span></label>
                            <input type="number" min="1" max="<?php echo $flower_data['stock_qty']; ?>" name="spoilage_qty" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #f59e0b; outline-color: #f59e0b;">
                        </div>
                        
                        <button type="submit" class="btn btn--primary btn--full" style="background-color: #f59e0b; border-color: #f59e0b;">Confirm Spoilage</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>