<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// 1. Calculate Today's Revenue
$todayQuery = "SELECT COALESCE(SUM(total_amount), 0) as today_rev FROM tbl_orders WHERE DATE(order_date) = CURDATE() AND status != 'Cancelled'";
$todayResult = $conn->query($todayQuery);
$today_revenue = $todayResult->fetch_assoc()['today_rev'];

// 2. Count Pending Orders
$pendingQuery = "SELECT COUNT(*) as pending_count FROM tbl_orders WHERE status = 'Pending'";
$pendingResult = $conn->query($pendingQuery);
$pending_orders = $pendingResult->fetch_assoc()['pending_count'];

// 3. Count Total Customers
$customerQuery = "SELECT COUNT(*) as customer_count FROM tbl_customers";
$customerResult = $conn->query($customerQuery);
$total_customers = $customerResult->fetch_assoc()['customer_count'];

// 4. Fetch Low Stock Alerts (Stock 5 or below)
$lowStockQuery = "SELECT flower_name, stock_qty FROM tbl_flowers WHERE stock_qty <= 5 ORDER BY stock_qty ASC LIMIT 5";
$lowStockResult = $conn->query($lowStockQuery);

// 5. Fetch 5 Most Recent Orders for the Activity Feed
$recentOrdersQuery = "SELECT o.order_id, c.full_name, o.total_amount, o.status 
                      FROM tbl_orders o 
                      JOIN tbl_customers c ON o.customer_id = c.customer_id 
                      ORDER BY o.order_date DESC LIMIT 5";
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
    <style>
        .metric-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .metric-card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px; border-left: 4px solid #0ea5e9; }
        .metric-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
        
        /* Dynamic Colors for Metrics */
        .metric-card.revenue { border-left-color: #10b981; }
        .metric-card.revenue .metric-icon { background: #d1fae5; color: #059669; }
        
        .metric-card.pending { border-left-color: #f59e0b; }
        .metric-card.pending .metric-icon { background: #fef3c7; color: #d97706; }
        
        .metric-card.customers { border-left-color: #6366f1; }
        .metric-card.customers .metric-icon { background: #e0e7ff; color: #4338ca; }

        .dashboard-columns { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        
        .alert-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .alert-item:last-child { border-bottom: none; }
        .stock-badge-low { background-color: #fee2e2; color: #dc2626; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; }
        
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .dot-pending { background-color: #f59e0b; }
        .dot-processing { background-color: #3b82f6; }
        .dot-delivered { background-color: #10b981; }
        .dot-cancelled { background-color: #ef4444; }
    </style>
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
                <h2>Welcome Back, Admin!</h2>
                <div class="system-header__actions">
                    <span class="notification-bell"><i class="fa-solid fa-bell"></i>
                        <?php if($pending_orders > 0) echo "<span class='badge'>$pending_orders</span>"; ?>
                    </span>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            
            <div class="system-content">
                <div class="metric-grid">
                    <div class="metric-card revenue">
                        <div class="metric-icon"><i class="fa-solid fa-peso-sign"></i></div>
                        <div>
                            <p style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Revenue Today</p>
                            <h3 style="font-size: 1.8rem; color: #0f172a;">₱<?php echo number_format($today_revenue, 2); ?></h3>
                        </div>
                    </div>
                    
                    <div class="metric-card pending">
                        <div class="metric-icon"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <p style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Pending Orders</p>
                            <h3 style="font-size: 1.8rem; color: #0f172a;"><?php echo $pending_orders; ?></h3>
                        </div>
                    </div>
                    
                    <div class="metric-card customers">
                        <div class="metric-icon"><i class="fa-solid fa-users"></i></div>
                        <div>
                            <p style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Total Clients</p>
                            <h3 style="font-size: 1.8rem; color: #0f172a;"><?php echo $total_customers; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="dashboard-columns">
                    <div class="dashboard-card">
                        <h3 style="margin-bottom: 20px; color: #334155;"><i class="fa-solid fa-bolt" style="color: #eab308; margin-right: 8px;"></i> Recent Orders</h3>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($recentOrdersResult && $recentOrdersResult->num_rows > 0) {
                                    while($row = $recentOrdersResult->fetch_assoc()) {
                                        $dotClass = 'dot-' . strtolower($row['status']);
                                        echo "<tr>";
                                        echo "<td style='font-weight: 500; color: #3b82f6;'>#" . $row['order_id'] . "</td>";
                                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                        echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                        echo "<td><span class='status-dot $dotClass'></span>" . $row['status'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align: center; color: #94a3b8;'>No recent orders.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div style="text-align: right; margin-top: 15px;">
                            <a href="records.php" style="color: #3b82f6; font-size: 0.9rem; font-weight: 500; text-decoration: none;">View All Orders &rarr;</a>
                        </div>
                    </div>

                    <div class="dashboard-card" style="border-top: 4px solid #ef4444;">
                        <h3 style="margin-bottom: 20px; color: #b91c1c;"><i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> Low Stock Alerts</h3>
                        
                        <?php
                        if ($lowStockResult && $lowStockResult->num_rows > 0) {
                            while($item = $lowStockResult->fetch_assoc()) {
                                echo "<div class='alert-item'>";
                                echo "<span style='color: #334155; font-weight: 500;'>" . htmlspecialchars($item['flower_name']) . "</span>";
                                echo "<span class='stock-badge-low'>" . $item['stock_qty'] . " left</span>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p style='color: #059669; text-align: center; padding: 20px 0;'><i class='fa-solid fa-circle-check'></i> Inventory is looking healthy!</p>";
                        }
                        ?>
                        
                        <div style="margin-top: 20px;">
                            <a href="records.php?msg=view_inventory" class="btn btn--outline-sm btn--full" style="text-align: center; display: block;">Manage Inventory</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>