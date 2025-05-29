<?php
// Database configuration
$db_host = 'localhost';
$db_username = 'root';     // Default XAMPP username
$db_password = '';       // Default XAMPP password is empty
$db_name = 'soe_db'; // Replace with your actual database name

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    // Log the error instead of displaying it to the user
    error_log("Connection failed: " . $conn->connect_error);
    
    // Display a user-friendly message
    die("Sorry, we're experiencing technical difficulties. Please try again later.");
}

// Set charset to ensure proper encoding
$conn->set_charset("utf8mb4");

// You can add other database configurations here if needed

// Note: Don't close the connection here as it will be used by other files that include this one
?>
