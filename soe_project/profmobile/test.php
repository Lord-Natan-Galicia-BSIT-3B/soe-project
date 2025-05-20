<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mysql';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
echo "✅ Connection Successful!";
?>
