<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// Check if a customer ID was passed in the URL
if (!isset($_GET['id'])) {
    header("Location: records.php");
    exit();
}

$customer_id = (int)$_GET['id'];

// 1. Fetch Customer Details & Lifetime Stats
$statsQuery = "SELECT c.customer_id, c.full_name, 
                      COUNT(o.order_id) as total_orders, 
                      COALESCE(SUM(o.total_amount), 0) as lifetime_value 
               FROM tbl_customers c 
               LEFT JOIN tbl_orders o ON c.customer_id = o.customer_id 
               WHERE c.customer_id = $customer_id
               GROUP BY c.customer_id";

$statsResult = $conn->query($statsQuery);

if ($statsResult && $statsResult->num_rows > 0) {
    $customer = $statsResult->fetch_assoc();
} else {
    // If the customer doesn't exist, send them back
    header("Location: records.php?msg=error");
    exit();
}

// Determine VIP Status
$is_vip = ($customer['lifetime_value'] >= 2000);

// 2. Fetch Order History Specific to this Customer
$historyQuery = "SELECT o.order_id, f.flower_name, o.qty_ordered, o.total_amount, o.order_date, o.status 
                 FROM tbl_orders o
                 JOIN tbl_flowers f ON o.flower_id = f.flower_id
                 WHERE o.customer_id = $customer_id
                 ORDER BY o.order_date DESC";
$historyResult = $conn->query($historyQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #94a3b8;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 5px;
        }
        .badge-vip { background-color: #fef08a; color: #854d0e; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
        .status-badge { padding: 4px 8px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .status-pending { color: #d97706; background-color: #fef3c7; }
        .status-processing { color: #2563eb; background-color: #dbeafe; }
        .status-delivered { color: #059669; background-color: #d1fae5; }
        .status-cancelled { color: #dc2626; background-color: #fee2e2; }
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
                <a href="records.php" class="sidebar__link active"><i class="fa-solid fa-table-list"></i> Records</a>
                <a href="reports.php" class="sidebar__link"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a href="profile.php" class="sidebar__link"><i class="fa-solid fa-user"></i> Profile</a>
            </nav>
        </aside>
        
        <main class="system-main">
            <header class="system-header">
                <h2>Customer Profile</h2>
                <div class="system-header__actions">
                    <a href="records.php?msg=view_customers" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Directory</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.8rem; color: #0f172a; margin-bottom: 5px;">
                                <?php echo htmlspecialchars($customer['full_name']); ?>
                            </h3>
                            <p style="color: #64748b;">Client ID: #<?php echo $customer['customer_id']; ?></p>
                            <?php if($is_vip) echo "<span class='badge-vip' style='margin-top: 10px;'><i class='fa-solid fa-star'></i> VIP Client</span>"; ?>
                        </div>
                    </div>
                    
                    <div class="stat-grid">
                        <div class="stat-box">
                            <p style="color: #64748b; font-size: 0.9rem;">Total Orders</p>
                            <div class="stat-value"><?php echo $customer['total_orders']; ?></div>
                        </div>
                        <div class="stat-box">
                            <p style="color: #64748b; font-size: 0.9rem;">Lifetime Spent</p>
                            <div class="stat-value">₱<?php echo number_format($customer['lifetime_value'], 2); ?></div>
                        </div>
                        <div class="stat-box">
                            <p style="color: #64748b; font-size: 0.9rem;">Average Order Value</p>
                            <div class="stat-value">
                                ₱<?php echo ($customer['total_orders'] > 0) ? number_format($customer['lifetime_value'] / $customer['total_orders'], 2) : "0.00"; ?>
                            </div>
                        </div>
                    </div>

                    <h4 style="margin-bottom: 15px; color: #334155;"><i class="fa-solid fa-clock-rotate-left"></i> Order History</h4>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item Purchased</th>
                                    <th>Quantity</th>
                                    <th>Total Paid</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($historyResult) && $historyResult->num_rows > 0) {
                                    while($row = $historyResult->fetch_assoc()) {
                                        $date = date("F j, Y", strtotime($row['order_date']));
                                        $statusClass = 'status-' . strtolower($row['status']);
                                        
                                        echo "<tr>";
                                        echo "<td>#" . htmlspecialchars($row['order_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['flower_name']) . "</td>";
                                        echo "<td>" . $row['qty_ordered'] . "</td>";
                                        echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                        echo "<td>" . $date . "</td>";
                                        echo "<td><span class='status-badge $statusClass'>" . $row['status'] . "</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' style='text-align:center; padding: 20px;'>No orders found for this customer.</td></tr>";
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