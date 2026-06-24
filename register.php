<?php
session_start();
require_once 'db.php';

// Ensure $conn is defined (fallback for missing/incorrect db.php)
if (!isset($conn) || !($conn instanceof mysqli)) {
    // Adjust these credentials if your environment differs
    $conn = new mysqli('localhost', 'root', '', 'petals_and_style');
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $shop_name = $conn->real_escape_string($_POST['shop_name']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Basic validation
    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Securely hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO tbl_users (first_name, last_name, email, password_hash, shop_name) 
                VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$shop_name')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Error: Email might already be registered.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card auth-card--wide">
            <h2>Create Your Account</h2>
            
            <?php 
            if($error) echo "<p style='color:red;'>$error</p>"; 
            if($success) echo "<p style='color:green;'>$success</p>"; 
            ?>

            <form class="auth-form" method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Flowershop Name</label>
                    <input type="text" name="shop_name">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password" required minlength="8">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="confirm_password" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn--primary btn--full">Create Account</button>
            </form>
            <p class="auth-redirect">Already have an account? <a href="login.php">Sign in here</a></p>
        </div>
    </div>
</body>
</html>