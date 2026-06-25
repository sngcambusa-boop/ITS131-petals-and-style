<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// UPDATE 1: Added 'o.status' to the SELECT query
$query = "SELECT o.order_id, c.full_name, f.flower_name, o.qty_ordered, o.total_amount, o.order_date, o.status 
          FROM tbl_orders o
          JOIN tbl_customers c ON o.customer_id = c.customer_id
          JOIN tbl_flowers f ON o.flower_id = f.flower_id
          ORDER BY o.order_date DESC";

$result = isset($conn) ? $conn->query($query) : null;
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
        /* A little extra styling to make the dropdown look like a clean status badge */
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
                    <button class="records-tab active">Orders</button>
                    <button class="records-tab">Inventory</button>
                    <button class="records-tab">Customers</button>
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
                    } elseif ($_GET['msg'] == 'error') {
                        echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 15px;'><i class='fa-solid fa-triangle-exclamation'></i> Error processing request.</p>";
                    }
                }
                ?>

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
                            if (isset($result) && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $date = date("Y-m-d", strtotime($row['order_date']));
                                    $amount = number_format($row['total_amount'], 2);
                                    
                                    // Make sure status has a fallback just in case
                                    $current_status = isset($row['status']) ? $row['status'] : 'Pending';
                                    
                                    // Define the available statuses for the dropdown
                                    $status_options = ['Pending', 'Processing', 'Delivered', 'Cancelled'];
                                    
                                    echo "<tr>";
                                    echo "<td>#" . htmlspecialchars($row['order_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['flower_name']) . " (x" . $row['qty_ordered'] . ")</td>";
                                    echo "<td>₱" . $amount . "</td>";
                                    echo "<td>" . $date . "</td>";
                                    
                                    // UPDATE 2: The Live Status Dropdown Form
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
                                            <a href='#' title='Edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                            <a href='delete_order.php?id=" . $row['order_id'] . "' onclick=\"return confirm('Are you sure you want to delete this order? The items will be restocked in inventory.');\" title='Delete' style='color: #ef4444;'><i class='fa-solid fa-trash'></i></a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' style='text-align:center; padding: 20px;'>No orders found in the database.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <span>Showing results from database</span>
                    <div class="pagination__pages">
                        <button class="active">1</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>