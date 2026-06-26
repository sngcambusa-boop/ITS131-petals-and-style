<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// 1. Calculate Lifetime Sales Data (Excluding Cancelled Orders)
$lifetimeQuery = "SELECT COALESCE(SUM(total_amount), 0) as lifetime_rev, 
                         COALESCE(SUM(qty_ordered), 0) as total_items_sold 
                  FROM tbl_orders 
                  WHERE status != 'Cancelled'";
$lifetimeResult = $conn->query($lifetimeQuery);
$lifetimeData = $lifetimeResult->fetch_assoc();

// 2. Fetch Best Sellers (Group by Flower, Order by Revenue)
$bestSellersQuery = "SELECT f.flower_id, f.flower_name, f.price, 
                            COALESCE(SUM(o.qty_ordered), 0) as total_sold, 
                            COALESCE(SUM(o.total_amount), 0) as generated_revenue 
                     FROM tbl_flowers f
                     LEFT JOIN tbl_orders o ON f.flower_id = o.flower_id AND o.status != 'Cancelled'
                     GROUP BY f.flower_id, f.flower_name, f.price
                     ORDER BY generated_revenue DESC";
$bestSellersResult = $conn->query($bestSellersQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Reports - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .metric-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .metric-card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); text-align: center; border-top: 4px solid #8b5cf6; }
        .metric-value { font-size: 2.5rem; font-weight: 700; color: #0f172a; margin: 10px 0; font-family: 'Playfair Display', serif; }
        .metric-label { color: #64748b; font-size: 0.95rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
        
        .rank-badge { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; margin: 0 auto; }
        .rank-1 { background-color: #fbbf24; box-shadow: 0 0 10px rgba(251, 191, 36, 0.5); } /* Gold */
        .rank-2 { background-color: #94a3b8; } /* Silver */
        .rank-3 { background-color: #b45309; } /* Bronze */
        .rank-other { background-color: #f1f5f9; color: #64748b; }
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
                <h2>Sales Analytics & Reports</h2>
                <div class="system-header__actions">
                    <button onclick="window.print()" class="btn btn--outline-sm"><i class="fa-solid fa-print"></i> Print Report</button>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            
            <div class="system-content">
                <div class="metric-grid">
                    <div class="metric-card">
                        <div class="metric-label"><i class="fa-solid fa-chart-line"></i> Total Lifetime Revenue</div>
                        <div class="metric-value" style="color: #10b981;">₱<?php echo number_format($lifetimeData['lifetime_rev'], 2); ?></div>
                        <p style="color: #94a3b8; font-size: 0.85rem;">All completed & pending orders</p>
                    </div>
                    <div class="metric-card" style="border-top-color: #3b82f6;">
                        <div class="metric-label"><i class="fa-solid fa-boxes-stacked"></i> Total Units Sold</div>
                        <div class="metric-value" style="color: #3b82f6;"><?php echo $lifetimeData['total_items_sold']; ?></div>
                        <p style="color: #94a3b8; font-size: 0.85rem;">Individual floral arrangements delivered</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h3 style="margin-bottom: 20px; color: #334155;"><i class="fa-solid fa-trophy" style="color: #fbbf24; margin-right: 8px;"></i> Product Performance (Best Sellers)</h3>
                    
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Rank</th>
                                    <th>Item Name</th>
                                    <th>Unit Price</th>
                                    <th>Total Units Sold</th>
                                    <th>Total Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($bestSellersResult && $bestSellersResult->num_rows > 0) {
                                    $rank = 1;
                                    while($row = $bestSellersResult->fetch_assoc()) {
                                        // Assign medal colors to top 3
                                        if ($rank == 1) $rankClass = "rank-1";
                                        elseif ($rank == 2) $rankClass = "rank-2";
                                        elseif ($rank == 3) $rankClass = "rank-3";
                                        else $rankClass = "rank-other";

                                        echo "<tr>";
                                        echo "<td><div class='rank-badge $rankClass'>$rank</div></td>";
                                        echo "<td style='font-weight: 600; color: #0f172a;'>" . htmlspecialchars($row['flower_name']) . "</td>";
                                        echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>" . $row['total_sold'] . " units</td>";
                                        echo "<td style='font-weight: 600; color: #10b981;'>₱" . number_format($row['generated_revenue'], 2) . "</td>";
                                        echo "</tr>";
                                        
                                        $rank++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5' style='text-align:center; padding: 20px;'>No sales data available yet.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>