<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: components/login/login.php");
    exit;
}

include 'header.php';
include 'components/navigation/nav.php';
include 'components/navigation/topbar/top.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

switch ($page) {
    case 'Dashboard':
        include "components/navigation/dashboard/dashboard.php";
        break;
    case 'Reservation':
        include "components/navigation/room_management/reservation.php";
        break;
    case 'Monitoring':
        include "components/navigation/room_monitoring/monitoring.php";
        break;
    case 'Maintenance':
        include "components/navigation/maintenance/maintenance.php";
        break;
    case 'Report':
        include "components/navigation/reports/report.php";
        break;
    case 'Building':
        include "components/navigation/building_management/building.php";
        break;
    case 'User':
        include "components/navigation/user_management/user.php";
        break;
    case 'logout':
        session_destroy();
        header("Location: components/login/login.php");
        exit;
        break;
    default:
        include "components/navigation/dashboard/dashboard.php";
        break;
}
?>
