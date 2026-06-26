<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// Check if an order ID was passed
if (!isset($_GET['id'])) {
    header("Location: records.php");
    exit();
}

$order_id = (int)$_GET['id'];

// Fetch all details for this specific order using SQL JOINs
$query = "SELECT o.order_id, o.order_date, o.qty_ordered, o.total_amount, o.status,
                 c.customer_id, c.full_name, c.email, c.phone,
                 f.flower_name, f.price 
          FROM tbl_orders o
          JOIN tbl_customers c ON o.customer_id = c.customer_id
          JOIN tbl_flowers f ON o.flower_id = f.flower_id
          WHERE o.order_id = $order_id";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    header("Location: records.php?msg=error");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .invoice-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-top: 4px solid #0f172a; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        .invoice-details { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .detail-group h4 { color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 5px; }
        .detail-group p { color: #0f172a; font-weight: 500; }
        .receipt-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .receipt-table th { text-align: left; padding: 10px; border-bottom: 2px solid #e2e8f0; color: #64748b; }
        .receipt-table td { padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .receipt-total { display: flex; justify-content: flex-end; font-size: 1.25rem; font-weight: 700; color: #0f172a; padding-top: 10px; }
        
        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
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
                <h2>Order Overview</h2>
                <div class="system-header__actions">
                    <a href="records.php" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Orders</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="invoice-card">
                    <div class="invoice-header">
                        <div>
                            <h3 style="font-family: 'Playfair Display', serif; color: #0f172a; font-size: 1.8rem; margin-bottom: 5px;">Digital Receipt</h3>
                            <p style="color: #64748b;">Order #<?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></p>
                        </div>
                        <div style="text-align: right;">
                            <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                <?php echo $order['status']; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="invoice-details">
                        <div class="detail-group">
                            <h4>Customer Info</h4>
                            <p><?php echo htmlspecialchars($order['full_name']); ?></p>
                            <p style="font-weight: 400; font-size: 0.9rem; color: #475569;">
                                <?php echo !empty($order['email']) ? htmlspecialchars($order['email']) : 'No email provided'; ?><br>
                                <?php echo !empty($order['phone']) ? htmlspecialchars($order['phone']) : 'No phone provided'; ?>
                            </p>
                        </div>
                        <div class="detail-group">
                            <h4>Order Date</h4>
                            <p><?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
                        </div>
                    </div>
                    
                    <table class="receipt-table">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($order['flower_name']); ?></td>
                                <td style="text-align: center;"><?php echo $order['qty_ordered']; ?></td>
                                <td style="text-align: right;">₱<?php echo number_format($order['price'], 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="receipt-total">
                        <span>Total Paid: ₱<?php echo number_format($order['total_amount'], 2); ?></span>
                    </div>
                    
                    <div style="margin-top: 30px; text-align: center;">
                        <button onclick="window.print()" class="btn btn--outline-sm"><i class="fa-solid fa-print"></i> Print Invoice</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>