<?php
session_start();
require_once "../connection/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = $_POST['reservation_id'];
    $stmt = $conn->prepare("DELETE FROM reservations WHERE ReservationID = ? AND UserID = ?");
    $stmt->bind_param("ii", $reservationId, $_SESSION['user_id']);
    $stmt->execute();
}

header("Location: your_reservation.php");
exit;
