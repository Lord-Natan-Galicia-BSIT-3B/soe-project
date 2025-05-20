<?php
require_once "../connection/dbconnect.php";

$roomId = $_GET['room_id'];
$today = date('Y-m-d');

$sql = "SELECT u.Name, r.StartTime, r.EndTime
        FROM reservations r
        JOIN users u ON r.UserID = u.UserID
        WHERE r.RoomID = ? AND DATE(r.StartTime) = ? AND r.Status = 'Approved'
        AND TIME(NOW()) BETWEEN TIME(r.StartTime) AND TIME(r.EndTime)
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $roomId, $today);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  echo json_encode([
    'name' => $row['Name'],
    'start' => date('H:i', strtotime($row['StartTime'])),
    'end' => date('H:i', strtotime($row['EndTime']))
  ]);
} else {
  echo json_encode([]);
}
