<?php
require_once('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reservation_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE Reservations SET StartTime=?, EndTime=?, Status=? WHERE ReservationID=?");
    $stmt->bind_param("sssi", $startTime, $endTime, $status, $id);
    if ($stmt->execute()) {
        header("Location: ../index.php?page=Reservation");


        exit();
    } else {
        echo "Error updating reservation.";
    }
}
?>
