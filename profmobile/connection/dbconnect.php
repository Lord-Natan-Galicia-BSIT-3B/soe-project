
<?php

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'soe';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('DB Connection failed: ' . $conn->connect_error);
}

?>