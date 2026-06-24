<?php
// XAMPP credentials
$host = '127.0.0.1'; // Using 127.0.0.1 is safer than 'localhost' when changing ports
$user = 'root'; 
$pass = '';     
$dbname = 'petals_and_style';
$port = 3307; // Explicitly defining your custom port

// Create connection (Notice we added the $port as the 5th item here)
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to handle special characters (like the Peso sign) properly
$conn->set_charset("utf8mb4");
?>