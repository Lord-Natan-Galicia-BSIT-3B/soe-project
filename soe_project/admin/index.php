<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

include 'components/sidebar_header.php';
include 'components/sidebar.php';
include 'components/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

switch ($page) {
    case 'Dashboard':
        include "pages/dashboard.php";
        break;
    case 'Reservation':
        include "pages/reservation.php";
        break;
    case 'Monitoring':
        include "pages/room_monitoring.php";
        break;
    case 'Maintenance':
        include "pages/maintenance.php";
        break;
    case 'Report':
        include "pages/report.php";
        break;
    case 'User':
        include "pages/user-management.php";
        break;
    case 'logout':
        session_destroy();
        header("Location: auth/login.php");
        exit;
        break;
    default:
        include "pages/dashboard.php";
        break;
}
?>
