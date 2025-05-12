<?php
require_once('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomID = $_POST['room_id'];
    $department = $_POST['department'];
    $roomType = $_POST['room_type'];
    $floor = $_POST['floor'];
    $status = $_POST['status'];
    $capacity = $_POST['capacity'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Assuming you have a logged-in user
    $userID = 1; // Replace with actual session user ID

    $sql = "INSERT INTO Reservations (RoomID, UserID, Department, RoomType, Floor, Status, Capacity, StartTime, EndTime) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssiss", $roomID, $userID, $department, $roomType, $floor, $status, $capacity, $startTime, $endTime);

    if ($stmt->execute()) {
        header("Location: pages/room_reservation.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
