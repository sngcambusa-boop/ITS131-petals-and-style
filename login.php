<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query the user
    $sql = "SELECT * FROM tbl_users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Petals & Style</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Welcome Back</h2>
            
            <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

            <form class="auth-form" method="POST" action="">
                <div class="form-group">
                    <label><i class="fa-solid fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-lock"></i> Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn--primary btn--full">Sign In</button>
            </form>
            <p class="auth-redirect">Don't have an account? <a href="register.php">Create one here</a></p>
        </div>
    </div>
</body>
</html>