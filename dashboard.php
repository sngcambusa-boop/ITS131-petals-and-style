<?php
// Start the session and secure the page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once 'db.php';

// 1. Calculate Total Revenue (Sum of all orders)
$revenueQuery = "SELECT SUM(total_amount) as total_revenue FROM tbl_orders";
$revenueResult = $conn->query($revenueQuery);
$revenueRow = $revenueResult->fetch_assoc();
$totalRevenue = $revenueRow['total_revenue'] ? $revenueRow['total_revenue'] : 0;

// 2. Count Active Orders
$ordersQuery = "SELECT COUNT(order_id) as total_orders FROM tbl_orders";
$ordersResult = $conn->query($ordersQuery);
$ordersRow = $ordersResult->fetch_assoc();
$totalOrders = $ordersRow['total_orders'] ? $ordersRow['total_orders'] : 0;

// 3. Count Total Stock Items
$stockQuery = "SELECT SUM(stock_qty) as total_stock FROM tbl_flowers";
$stockResult = $conn->query($stockQuery);
$stockRow = $stockResult->fetch_assoc();
$totalStock = $stockRow['total_stock'] ? $stockRow['total_stock'] : 0;

// 4. Fetch the 3 Most Recent Orders for the table
$recentOrdersQuery = "SELECT o.order_id, c.full_name, o.total_amount 
                      FROM tbl_orders o
                      JOIN tbl_customers c ON o.customer_id = c.customer_id
                      ORDER BY o.order_date DESC LIMIT 3";
$recentOrdersResult = $conn->query($recentOrdersQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Petals & Style</title>
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
                <a href="dashboard.php" class="sidebar__link active"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                <a href="records.php" class="sidebar__link"><i class="fa-solid fa-table-list"></i> Records</a>
                <a href="reports.php" class="sidebar__link"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a href="profile.php" class="sidebar__link"><i class="fa-solid fa-user"></i> Profile</a>
            </nav>
            <div class="sidebar__footer">
                <a href="logout.php" class="sidebar__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
        </aside>
        
        <main class="system-main">
            <header class="system-header">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h2>Dashboard</h2>
                <div class="system-header__actions">
                    <span style="font-weight: 500; color: #2d2d2d; margin-right: 15px;">
                        Hello, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!
                    </span>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            
            <div class="system-content">
                <div class="summary-cards">
                    <div class="summary-card summary-card--sales">
                        <div class="summary-card__icon"><i class="fa-solid fa-peso-sign"></i></div>
                        <div class="summary-card__info">
                            <span class="summary-card__label">Total Revenue</span>
                            <span class="summary-card__value">₱<?php echo number_format($totalRevenue, 2); ?></span>
                        </div>
                    </div>
                    <div class="summary-card summary-card--orders">
                        <div class="summary-card__icon"><i class="fa-solid fa-clipboard-check"></i></div>
                        <div class="summary-card__info">
                            <span class="summary-card__label">Total Orders</span>
                            <span class="summary-card__value"><?php echo $totalOrders; ?></span>
                        </div>
                    </div>
                    <div class="summary-card summary-card--inventory">
                        <div class="summary-card__icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <div class="summary-card__info">
                            <span class="summary-card__label">Stock Items</span>
                            <span class="summary-card__value"><?php echo $totalStock; ?></span>
                        </div>
                    </div>
                    <div class="summary-card summary-card--spoilage">
                        <div class="summary-card__icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="summary-card__info">
                            <span class="summary-card__label">Spoilage Alerts</span>
                            <span class="summary-card__value">0</span>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <h3><i class="fa-solid fa-clock-rotate-left"></i> Recent Orders</h3>
                        <table class="mini-table">
                            <thead>
                                <tr><th>Order #</th><th>Customer</th><th>Amount</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($recentOrdersResult && $recentOrdersResult->num_rows > 0) {
                                    while($row = $recentOrdersResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>#" . htmlspecialchars($row['order_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                        echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                        echo "<td><span class='status status--processing'>Processing</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No recent orders.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="dashboard-card">
                        <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                        <div class="quick-actions">
                            <a href="records.php" class="quick-action"><i class="fa-solid fa-plus-circle"></i> New Order</a>
                            <a href="records.php" class="quick-action"><i class="fa-solid fa-box"></i> Add Stock</a>
                            <a href="reports.php" class="quick-action"><i class="fa-solid fa-file-export"></i> Generate Report</a>
                            <a href="profile.php" class="quick-action"><i class="fa-solid fa-gear"></i> Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>