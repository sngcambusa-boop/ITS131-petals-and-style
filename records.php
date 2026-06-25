<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// 1. Fetch Orders Data
$ordersQuery = "SELECT o.order_id, c.full_name, f.flower_name, o.qty_ordered, o.total_amount, o.order_date, o.status 
          FROM tbl_orders o
          JOIN tbl_customers c ON o.customer_id = c.customer_id
          JOIN tbl_flowers f ON o.flower_id = f.flower_id
          ORDER BY o.order_date DESC";
$ordersResult = isset($conn) ? $conn->query($ordersQuery) : null;

// 2. Fetch Inventory Data
$inventoryQuery = "SELECT flower_id, flower_name, price, stock_qty FROM tbl_flowers ORDER BY flower_name ASC";
$inventoryResult = isset($conn) ? $conn->query($inventoryQuery) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Management - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .status-select {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            cursor: pointer;
            outline: none;
        }
        .status-select.pending { color: #d97706; background-color: #fef3c7; border-color: #fde68a; }
        .status-select.processing { color: #2563eb; background-color: #dbeafe; border-color: #bfdbfe; }
        .status-select.delivered { color: #059669; background-color: #d1fae5; border-color: #a7f3d0; }
        .status-select.cancelled { color: #dc2626; background-color: #fee2e2; border-color: #fecaca; }
        
        /* New Inventory Badges */
        .stock-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .stock-good { background-color: #d1fae5; color: #059669; }
        .stock-low { background-color: #fee2e2; color: #dc2626; }
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
            <div class="sidebar__footer">
                <a href="logout.php" class="sidebar__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
        </aside>
        
        <main class="system-main">
            <header class="system-header">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h2>Records Management</h2>
                <div class="system-header__actions">
                    <span class="notification-bell"><i class="fa-solid fa-bell"></i><span class="badge">3</span></span>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            
            <div class="system-content">
                <div class="records-tabs">
                    <button class="records-tab active" data-target="orders-view">Orders</button>
                    <button class="records-tab" data-target="inventory-view">Inventory</button>
                    <button class="records-tab" data-target="customers-view">Customers</button>
                </div>
                
                <div class="records-toolbar">
                    <div class="search-box">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" placeholder="Search records...">
                    </div>
                    <a href="add_order.php" class="btn btn--primary"><i class="fa-solid fa-plus"></i> Add New Order</a>
                </div>
                
                <?php 
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] == 'deleted') {
                        echo "<p style='color:green; background: #d1fae5; padding: 10px; border-radius: 6px; margin-bottom: 15px;'><i class='fa-solid fa-check-circle'></i> Order successfully deleted and inventory restocked!</p>";
                    } elseif ($_GET['msg'] == 'status_updated') {
                        echo "<p style='color:green; background: #d1fae5; padding: 10px; border-radius: 6px; margin-bottom: 15px;'><i class='fa-solid fa-check-circle'></i> Order status updated successfully!</p>";
                    } elseif ($_GET['msg'] == 'stock_updated') {
                        echo "<p style='color:green; background: #d1fae5; padding: 10px; border-radius: 6px; margin-bottom: 15px;'><i class='fa-solid fa-check-circle'></i> Inventory stock updated successfully!</p>";
                    } elseif ($_GET['msg'] == 'error') {
                        echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 15px;'><i class='fa-solid fa-triangle-exclamation'></i> Error processing request.</p>";
                    }
                }
                ?>

                <div id="orders-view" class="tab-content" style="display: block;">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($ordersResult) && $ordersResult->num_rows > 0) {
                                    while($row = $ordersResult->fetch_assoc()) {
                                        $date = date("Y-m-d", strtotime($row['order_date']));
                                        $amount = number_format($row['total_amount'], 2);
                                        $current_status = isset($row['status']) ? $row['status'] : 'Pending';
                                        $status_options = ['Pending', 'Processing', 'Delivered', 'Cancelled'];
                                        
                                        echo "<tr>";
                                        echo "<td>#" . htmlspecialchars($row['order_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['flower_name']) . " (x" . $row['qty_ordered'] . ")</td>";
                                        echo "<td>₱" . $amount . "</td>";
                                        echo "<td>" . $date . "</td>";
                                        
                                        echo "<td>
                                                <form action='update_status.php' method='POST' style='margin: 0;'>
                                                    <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                                                    <select name='status' onchange='this.form.submit()' class='status-select " . strtolower($current_status) . "'>";
                                                    foreach($status_options as $option) {
                                                        $selected = ($option == $current_status) ? 'selected' : '';
                                                        echo "<option value='$option' $selected>$option</option>";
                                                    }
                                        echo "      </select>
                                                </form>
                                              </td>";
                                        
                                        echo "<td class='action-cell'>
                                                <a href='#' title='View'><i class='fa-solid fa-eye'></i></a>
                                                <a href='delete_order.php?id=" . $row['order_id'] . "' onclick=\"return confirm('Are you sure you want to delete this order? The items will be restocked.');\" title='Delete' style='color: #ef4444;'><i class='fa-solid fa-trash'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align:center; padding: 20px;'>No orders found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="inventory-view" class="tab-content" style="display: none;">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Flower / Arrangement</th>
                                    <th>Unit Price</th>
                                    <th>Current Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($inventoryResult) && $inventoryResult->num_rows > 0) {
                                    while($row = $inventoryResult->fetch_assoc()) {
                                        $stock = $row['stock_qty'];
                                        
                                        // Logic to determine if stock is healthy or low
                                        if ($stock <= 5) {
                                            $badgeClass = "stock-low";
                                            $badgeText = "Low Stock";
                                        } else {
                                            $badgeClass = "stock-good";
                                            $badgeText = "In Stock";
                                        }
                                        
                                        echo "<tr>";
                                        echo "<td>#" . htmlspecialchars($row['flower_id']) . "</td>";
                                        echo "<td style='font-weight: 500;'>" . htmlspecialchars($row['flower_name']) . "</td>";
                                        echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>" . $stock . " units</td>";
                                        echo "<td><span class='stock-badge $badgeClass'>$badgeText</span></td>";
                                        echo "<td class='action-cell'>
                                                <a href='edit_stock.php?id=" . $row['flower_id'] . "' title='Edit Stock'><i class='fa-solid fa-pen-to-square'></i></a>
                                                <a href='#' title='Add Spoilage' style='color:#f59e0b;'><i class='fa-solid fa-triangle-exclamation'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' style='text-align:center; padding: 20px;'>No inventory items found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="customers-view" class="tab-content" style="display: none;">
                    <div class="dashboard-card" style="text-align: center; padding: 50px 20px;">
                        <i class="fa-solid fa-users" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <h3 style="color: #475569;">Customer Directory</h3>
                        <p style="color: #64748b;">The customer management module is currently under construction.</p>
                    </div>
                </div>

            </div>
        </main>
    </div>
    
    <script src="js/main.js"></script>
    
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.records-tab');
            const contents = document.querySelectorAll('.tab-content');

            // 1. Standard Tab Switching Logic
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    contents.forEach(content => content.style.display = 'none');
                    
                    const targetId = tab.getAttribute('data-target');
                    document.getElementById(targetId).style.display = 'block';
                });
            });

            // 2. Check the URL for status messages
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');

            // 3. Auto-open the Inventory tab if we just updated stock
            if (msg === 'stock_updated') {
                document.querySelector('[data-target="inventory-view"]').click();
            }

            // 4. Auto-hide messages after 3 seconds and clean the URL
            const alertMessages = document.querySelectorAll('.system-content > p');
            if (alertMessages.length > 0) {
                setTimeout(() => {
                    // Hide the message
                    alertMessages.forEach(alert => alert.style.display = 'none');
                    // Remove the ?msg=... from the URL so it doesn't come back on refresh
                    window.history.replaceState(null, '', window.location.pathname);
                }, 3000);
            }
        });
    </script>
</body>
</html>