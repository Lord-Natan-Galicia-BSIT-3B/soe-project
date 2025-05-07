<?php
require_once(__DIR__ . '../../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_request_id'])) {
        $requestId = intval($_POST['accept_request_id']);
        $updateQuery = "UPDATE Requests SET Status = 'In Progress' WHERE RequestID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('i', $requestId);
        $stmt->execute();
    }
    if (isset($_POST['decline_request_id'])) {
        $requestId = intval($_POST['decline_request_id']);
        $updateQuery = "UPDATE Requests SET Status = 'Declined' WHERE RequestID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('i', $requestId);
        $stmt->execute();
    }
}

$tab = $_GET['tab'] ?? 'requests';

if ($tab === 'status') {
    $sql = "SELECT 
                r.RequestID,
                b.BuildingName,
                rm.RoomNumber,
                u.Name,
                r.IssueDescription,
                r.Status,
                r.DateReported
            FROM Requests r
            JOIN Rooms rm ON r.RoomID = rm.RoomID
            JOIN Buildings b ON rm.BuildingID = b.BuildingID
            JOIN Users u ON r.UserID = u.UserID";
} else {
    $sql = "SELECT 
                r.RequestID,
                b.BuildingName,
                rm.RoomNumber,
                u.Name,
                r.IssueDescription,
                r.Status,
                r.DateReported
            FROM Requests r
            JOIN Rooms rm ON r.RoomID = rm.RoomID
            JOIN Buildings b ON rm.BuildingID = b.BuildingID
            JOIN Users u ON r.UserID = u.UserID
            WHERE r.Status = 'Pending'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/maintenance.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/234775b3ba.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="pages-management-container mt-5">
        <h4 class="text-primary mb-3 mt-3">View Maintenance</h4>
        <div class="d-flex align-items-center mb-4" style="justify-content: space-between;">
            <a href="#" class="text-list">Lists of Reported Requests</a>
            <button class="btn-print">
                <i class="fa fa-print me-2" data-bs-toggle="tooltip" title="Print"></i>
            </button>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?= $tab === 'requests' ? 'active' : '' ?>" href="index.php?page=Maintenance&tab=requests">Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $tab === 'status' ? 'active' : '' ?>" href="index.php?page=Maintenance&tab=status">Status</a>
                    </li>
                </ul>
                <div class="mt-3">
                    <input type="text" class="form-control mb-3" placeholder="Search">
                    <div class="d-flex justify-content-between mb-2">
                        <select class="form-select w-auto">
                            <option>Filters</option>
                        </select>
                        <select class="form-select w-auto">
                            <option>Sort</option>
                        </select>
                    </div>
                    <table class="table table-bordered" id="table-print">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>Date Reported</th>
                                <th>Room</th>
                                <th>Report</th>
                                <th>Reported By</th>
                                <th>Status</th>
                                <?php if ($tab !== 'status'): ?>
                                <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td><input type='checkbox'></td>
            <td>" . date('m/d/Y', strtotime($row['DateReported'])) . "</td>
            <td>" . htmlspecialchars($row['BuildingName'] . ' - ' . $row['RoomNumber']) . "</td>
            <td>" . htmlspecialchars($row['IssueDescription']) . "</td>
            <td>" . htmlspecialchars($row['Name']) . "</td>
            <td><button class='btn btn-sm btn-secondary'>" . htmlspecialchars($row['Status']) . "</button></td>";

        if ($tab !== 'status') {
            echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='accept_request_id' value='" . $row['RequestID'] . "'>
                    <button type='submit' class='btn btn-dark btn-sm'>Accept</button>
                </form>
                <form method='post' style='display:inline; margin-left:4px;'>
                    <input type='hidden' name='decline_request_id' value='" . $row['RequestID'] . "'>
                    <button type='submit' class='btn btn-danger btn-sm'>Decline</button>
                </form>
            </td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='" . ($tab === 'status' ? 6 : 7) . "' class='text-center'>No requests found.</td></tr>";
}
$conn->close();
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="../assets/js/print.js"></script>
</body>
</html>
