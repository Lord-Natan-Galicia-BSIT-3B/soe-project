<?php
session_start();
require_once "../connection/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = $_POST['reservation_id'];
    $date = $_POST['date'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];

    $startTime = $date . ' ' . $start . ':00';
    $endTime = $date . ' ' . $end . ':00';

    $stmt = $conn->prepare("UPDATE reservations SET StartTime = ?, EndTime = ?, Status = 'Pending' WHERE ReservationID = ? AND UserID = ?");
    $stmt->bind_param("ssii", $startTime, $endTime, $reservationId, $_SESSION['user_id']);
    $stmt->execute();
}

header("Location: your_reservation.php");
exit;
