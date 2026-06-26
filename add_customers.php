<?php
session_start();

// Secure the script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$error = '';

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clean inputs to prevent SQL injection
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    // Insert the new customer into the database
    $insertQuery = "INSERT INTO tbl_customers (full_name, email, phone) 
                    VALUES ('$full_name', '$email', '$phone')";
    
    if ($conn->query($insertQuery)) {
        // Redirect back to the customers tab with a success message
        header("Location: records.php?msg=customer_added");
        exit();
    } else {
        $error = "Error adding to database: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer - Petals & Style</title>
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
        </aside>
        
        <main class="system-main">
            <header class="system-header">
                <h2>Add Walk-In Customer</h2>
                <div class="system-header__actions">
                    <a href="records.php?msg=view_customers" class="btn btn--outline-sm"><i class="fa-solid fa-arrow-left"></i> Back to Directory</a>
                </div>
            </header>
            
            <div class="system-content">
                <div class="dashboard-card" style="max-width: 500px; margin: 0 auto; border-top: 4px solid #3b82f6;">
                    <h3 style="margin-bottom: 20px; color: #1d4ed8;"><i class="fa-solid fa-user-plus"></i> Client Details</h3>
                    
                    <?php if($error) echo "<p style='color:red; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 15px;'>$error</p>"; ?>

                    <form method="POST" action="">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Full Name <span class="required">*</span></label>
                            <input type="text" name="full_name" required placeholder="e.g., Maria Santos" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="maria@example.com" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="09XX XXX XXXX" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                        </div>
                        
                        <button type="submit" class="btn btn--primary btn--full" style="background-color: #3b82f6; border-color: #3b82f6;">Register Customer</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>