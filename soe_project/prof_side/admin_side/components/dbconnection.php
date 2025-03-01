<?php
$conn = mysqli_connect("localhost", "root", "", "soeprojectdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
