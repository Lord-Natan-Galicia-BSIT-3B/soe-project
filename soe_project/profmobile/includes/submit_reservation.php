<?php
session_start();
require_once('../connection/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id  = $_POST['room_id'];
    $date     = $_POST['date'];
    $start    = $_POST['start'];
    $end      = $_POST['end'];
    $section  = $_POST['section'];
    $purpose  = $_POST['purpose'];
    $user_id  = $_SESSION['user_id'] ?? 1;

    $start_time = $date . ' ' . $start . ':00';
    $end_time   = $date . ' ' . $end . ':00';

    // Check for overlapping reservations
    $conflict = $conn->prepare("
        SELECT 1 FROM reservations
        WHERE RoomID = ? AND Status = 'Approved'
        AND StartTime < ? AND EndTime > ?
    ");
    $conflict->bind_param("iss", $room_id, $end_time, $start_time);
    $conflict->execute();
    $conflict->store_result();

    if ($conflict->num_rows > 0) {
        $_SESSION['reserve_status']  = 'error';
        $_SESSION['reserve_message'] = 'Room already reserved for the selected time.';
        $conflict->close();
        $conn->close();
        header("Location: home.php");

        exit;
    }

    $conflict->close();

    // Insert reservation (default status: Pending)
    $stmt = $conn->prepare("
        INSERT INTO reservations (RoomID, StartTime, EndTime, Purpose, Status, UserID, Section)
        VALUES (?, ?, ?, ?, 'Pending', ?, ?)
    ");
    $stmt->bind_param("isssis", $room_id, $start_time, $end_time, $purpose, $user_id, $section);

    if ($stmt->execute()) {
        $_SESSION['reserve_status']  = 'success';
        $_SESSION['reserve_message'] = 'Reservation submitted successfully!';
    } else {
        $_SESSION['reserve_status']  = 'error';
        $_SESSION['reserve_message'] = 'Failed to submit reservation.';
    }

    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit;
}
