<?php
session_start();
require_once 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch Sales Report Data: Group by Flower and Sum the Totals
$reportQuery = "
    SELECT 
        f.flower_name, 
        COUNT(o.order_id) as times_ordered, 
        SUM(o.total_amount) as total_revenue 
    FROM tbl_orders o
    JOIN tbl_flowers f ON o.flower_id = f.flower_id
    GROUP BY f.flower_name
    ORDER BY total_revenue DESC
";

$reportResult = $conn->query($reportQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Petals & Style</title>
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
                <a href="records.php" class="sidebar__link"><i class="fa-solid fa-table-list"></i> Records</a>
                <a href="reports.php" class="sidebar__link active"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a href="profile.php" class="sidebar__link"><i class="fa-solid fa-user"></i> Profile</a>
            </nav>
            <div class="sidebar__footer">
                <a href="logout.php" class="sidebar__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
        </aside>
        <main class="system-main">
            <header class="system-header">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h2>Reports</h2>
                <div class="system-header__actions">
                    <span class="notification-bell"><i class="fa-solid fa-bell"></i><span class="badge">3</span></span>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            <div class="system-content">
                <div class="report-controls">
                    <select class="report-select">
                        <option>Sales Report (Best Sellers)</option>
                        <option>Spoilage Report</option>
                        <option>Inventory Report</option>
                        <option>Customer Report</option>
                    </select>
                    <input type="date" class="report-date" value="<?php echo date('Y-m-01'); ?>">
                    <span>to</span>
                    <input type="date" class="report-date" value="<?php echo date('Y-m-t'); ?>">
                    <button class="btn btn--primary"><i class="fa-solid fa-rotate"></i> Generate</button>
                    <button class="btn btn--outline-sm"><i class="fa-solid fa-download"></i> Export PDF</button>
                </div>
                
                <div class="report-charts">
                    <div class="chart-card chart-card--large">
                        <h4><i class="fa-solid fa-chart-line"></i> Sales Trend (Placeholder)</h4>
                        <div class="chart-placeholder">
                            <div class="bar-chart">
                                <div class="bar" style="height:60%;"><span>Week 1</span><span class="bar-val">₱28k</span></div>
                                <div class="bar" style="height:80%;"><span>Week 2</span><span class="bar-val">₱42k</span></div>
                                <div class="bar" style="height:55%;"><span>Week 3</span><span class="bar-val">₱24k</span></div>
                                <div class="bar" style="height:90%;"><span>Week 4</span><span class="bar-val">₱51k</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-card">
                        <h4><i class="fa-solid fa-chart-pie"></i> Spoilage by Category</h4>
                        <div class="chart-placeholder chart-placeholder--pie">
                            <div class="pie-legend">
                                <div class="pie-legend__item"><span class="dot dot--red"></span> Roses (35%)</div>
                                <div class="pie-legend__item"><span class="dot dot--orange"></span> Tulips (25%)</div>
                                <div class="pie-legend__item"><span class="dot dot--yellow"></span> Daisies (22%)</div>
                                <div class="pie-legend__item"><span class="dot dot--green"></span> Others (18%)</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h3><i class="fa-solid fa-table"></i> Sales by Flower (Best Sellers)</h3>
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Flower / Arrangement</th>
                                <th>Times Ordered</th>
                                <th>Total Revenue Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($reportResult && $reportResult->num_rows > 0): ?>
                                <?php while($row = $reportResult->fetch_assoc()): ?>
                                    <tr>
                                        <td style="font-weight: 500;"><?php echo htmlspecialchars($row['flower_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['times_ordered']); ?></td>
                                        <td class="text-success">₱<?php echo number_format($row['total_revenue'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 20px;">No sales data available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>