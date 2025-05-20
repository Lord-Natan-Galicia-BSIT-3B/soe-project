<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../auth/loginPage.php");
exit;
?>
