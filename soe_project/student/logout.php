<?php
session_start();
$_SESSION = array(); // Unset all session variables
session_destroy();
header('Location: login.php');
exit();
?>