<?php
session_start();

include '../public/title.php';
include '../includes/nav.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

switch ($page) {
    case 'Home':
        include "../public/home.php";
        break;
    case 'logout':
        session_destroy();
        header("Location: auth/login.php");
        exit;
        break;
    default:
        include "../public/home.php";
        break;
}
?>