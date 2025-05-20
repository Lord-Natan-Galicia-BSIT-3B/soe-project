<?php


include '../public/title.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

switch ($page) {
    case 'Home':
        include "../includes/home.php";
        break;
    case 'logout':
        session_destroy();
        header("Location: auth/loginPage.php");
        exit;
        break;
    default:
        include "../includes/home.php";
        break;
}
?>