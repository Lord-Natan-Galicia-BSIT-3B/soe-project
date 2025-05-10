<?php
function getRoomCounts($conn) {
    $counts = [];
    $statuses = ['Available', 'Reserved', 'Under Maintenance'];
    $counts['total'] = $conn->query("SELECT COUNT(*) as count FROM rooms")->fetch_assoc()['count'];
    foreach ($statuses as $status) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM rooms WHERE RoomStatus = ?");
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $counts[strtolower(str_replace(' ', '_', $status))] = $result['count'];
    }
    return $counts;
}

function getFilteredRooms($conn, $status = null, $search = null, $building = null) {
    $query = "SELECT * FROM rooms WHERE 1=1";
    $params = [];
    $types = '';

    if ($status) {
        $query .= " AND RoomStatus = ?";
        $params[] = $status;
        $types .= 's';
    }

    if ($building) {
        $query .= " AND BuildingID = ?";
        $params[] = $building;
        $types .= 's';
    }

    if ($search) {
        $query .= " AND (RoomNumber LIKE ? OR RoomDescription LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= 'ss';
    }

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}
?>
