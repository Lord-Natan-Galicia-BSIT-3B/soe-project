
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'soeproject_db';


$conn = new mysqli($host, $user, $pass, $dbname);


if ($conn->connect_errno) {
    die("Database connection failed: " . $conn->connect_error);
}
?>