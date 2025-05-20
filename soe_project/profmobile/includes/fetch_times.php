<?php
require_once "../connection/dbconnect.php";

$roomId = $_GET['room_id'];
$date = $_GET['date'];

$sql = "SELECT StartTime, EndTime, u.Name
        FROM reservations r
        JOIN users u ON u.UserID = r.UserID
        WHERE r.RoomID = ? AND DATE(r.StartTime) = ? AND r.Status = 'Approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $roomId, $date);
$stmt->execute();
$result = $stmt->get_result();

$reserved = [];
while ($row = $result->fetch_assoc()) {
    $reserved[] = [
        'start' => date('H:i', strtotime($row['StartTime'])),
        'end'   => date('H:i', strtotime($row['EndTime'])),
        'name'  => $row['Name']
    ];
}

$slots = [];
for ($h = 7; $h < 19; $h++) {
    $slotStart = sprintf('%02d:00', $h);
    $slotEnd = sprintf('%02d:00', $h + 1);
    $occupiedBy = null;

    foreach ($reserved as $r) {
        if (!($slotEnd <= $r['start'] || $slotStart >= $r['end'])) {
            $occupiedBy = $r['name'];
            break;
        }
    }

    $slots[] = [
        'start' => $slotStart,
        'end'   => $slotEnd,
        'reserved' => $occupiedBy ? true : false,
        'name' => $occupiedBy
    ];
}

header('Content-Type: application/json');
echo json_encode($slots);
