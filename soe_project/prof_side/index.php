<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: components/login/login.php");
    exit;
}

include "header.php";
include "components/navigation/nav.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

switch ($page) {
    case 'Home':
        include "components/home/home.php";
        break;
    case 'Room':
        include "components/home/room.php";
        break;
    case 'Reports':
        include "components/home/reports.php";
        break;
    default:
        include "components/home/home.php";
        break;
}
?>
