<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect back to login page
    header("Location: login.php");
    exit();
}
// For records.php, require_once 'db.php' goes here right after the session check.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Petals & Style</title>
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
                <a href="reports.php" class="sidebar__link"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a href="profile.php" class="sidebar__link active"><i class="fa-solid fa-user"></i> Profile</a>
            </nav>
            <div class="sidebar__footer">
                <a href="index.php" class="sidebar__link"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
            </div>
        </aside>
        <main class="system-main">
            <header class="system-header">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h2>My Profile</h2>
                <div class="system-header__actions">
                    <span class="notification-bell"><i class="fa-solid fa-bell"></i><span class="badge">3</span></span>
                    <div class="user-avatar"><i class="fa-solid fa-user-circle"></i></div>
                </div>
            </header>
            <div class="system-content">
                <div class="profile-layout">
                    <!-- Avatar Section -->
                    <div class="profile-sidebar-card">
                        <div class="profile-avatar-large">
                            <i class="fa-solid fa-user-circle"></i>
                        </div>
                        <h3>Rosario Dela Cruz</h3>
                        <span class="profile-role">Shop Manager</span>
                        <p class="profile-email"><i class="fa-solid fa-envelope"></i> rosario@petalsandstyle.ph</p>
                        <button class="btn btn--outline-sm btn--full"><i class="fa-solid fa-camera"></i> Change Photo</button>
                    </div>
                    <!-- Edit Form -->
                    <div class="profile-form-card">
                        <h3>Account Information</h3>
                        <form>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" value="Rosario" placeholder="First name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" value="Dela Cruz" placeholder="Last name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" value="rosario@petalsandstyle.ph" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" value="+63 912 345 6789" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label>Flowershop Name</label>
                                <input type="text" value="Petals & Style - Main Branch" placeholder="Shop name">
                            </div>
                            <hr>
                            <h4>Change Password</h4>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" placeholder="Enter current password">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" placeholder="New password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" placeholder="Confirm password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn--primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>