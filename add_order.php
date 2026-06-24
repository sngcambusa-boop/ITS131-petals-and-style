<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';

$error = '';
$success = '';

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = (int)$_POST['customer_id'];
    $flower_id = (int)$_POST['flower_id'];
    $qty = (int)$_POST['qty'];

    // 1. Get the flower's price and current stock from the database
    $flowerQuery = "SELECT price, stock_qty FROM tbl_flowers WHERE flower_id = $flower_id";
    $flowerResult = $conn->query($flowerQuery);
    
    if ($flowerResult && $flowerResult->num_rows > 0) {
        $flowerData = $flowerResult->fetch_assoc();
        $price = $flowerData['price'];
        $current_stock = $flowerData['stock_qty'];

        // 2. Check if we have enough stock
        if ($qty > $current_stock) {
            $error = "Not enough stock! You only have $current_stock of this item left.";
        } else {
            // 3. Calculate the total amount
            $total_amount = $price * $qty;
            
            // 4. Insert the new order
            $insertOrder = "INSERT INTO tbl_orders (flower_id, customer_id, qty_ordered, total_amount) 
                            VALUES ($flower_id, $customer_id, $qty, $total_amount)";
            
            if ($conn->query($insertOrder) === TRUE) {
                // 5. Deduct the stock quantity
                $updateStock = "UPDATE tbl_flowers SET stock_qty = stock_qty - $qty WHERE flower_id = $flower_id";
                $conn->query($updateStock);
                
                $success = "Order added successfully! Total: ₱" . number_format($total_amount, 2);
            } else {
                $error = "Database Error: " . $conn->error;
            }
        }
    } else {
        $error = "Invalid flower selected.";
    }
}

// Fetch lists for our dropdown menus
$customers = $conn->query("SELECT customer_id, full_name FROM tbl_customers ORDER BY full_name ASC");
// Only fetch flowers that actually have stock left
$flowers = $conn->query("SELECT flower_id, flower_name, price, stock_qty FROM tbl_flowers WHERE stock_qty > 0 ORDER BY flower_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Order - Petals & Style</title>
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
                <h2>Add New Order</h2>
                <div class="system-header__actions">
                    <a href="records.php" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Records</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card" style="max-width: 600px; margin: 0 auto;">
                    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-cart-plus"></i> Order Details</h3>
                    
                    <?php 
                    if($error) echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px;'>$error</p>"; 
                    if($success) echo "<p style='color:green; background: #d1fae5; padding: 10px; border-radius: 6px;'>$success</p>"; 
                    ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Select Customer <span class="required">*</span></label>
                            <select name="customer_id" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                                <option value="">-- Choose a Customer --</option>
                                <?php while($c = $customers->fetch_assoc()): ?>
                                    <option value="<?php echo $c['customer_id']; ?>">
                                        <?php echo htmlspecialchars($c['full_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Select Flower Arrangement <span class="required">*</span></label>
                            <select name="flower_id" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                                <option value="">-- Choose a Flower --</option>
                                <?php while($f = $flowers->fetch_assoc()): ?>
                                    <option value="<?php echo $f['flower_id']; ?>">
                                        <?php echo htmlspecialchars($f['flower_name']) . " - ₱" . number_format($f['price'], 2) . " (" . $f['stock_qty'] . " in stock)"; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity <span class="required">*</span></label>
                            <input type="number" name="qty" min="1" value="1" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div style="margin-top: 25px;">
                            <button type="submit" class="btn btn--primary btn--full">Process Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>