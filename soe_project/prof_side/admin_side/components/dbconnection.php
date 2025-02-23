<?php
$DBConnect = mysqli_connect("localhost", "root", "", "soeprojectdb");

if ($DBConnect->connect_error) {
    die("Connection failed: " . $DBConnect->connect_error);
}
?>
