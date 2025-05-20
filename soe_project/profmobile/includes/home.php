<?php
session_start();

$pageTitle = 'Home';
require_once "../connection/dbconnect.php";

// Ensure user email is loaded before any output
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT Email FROM users WHERE UserID = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($email);
    if ($stmt->fetch()) {
        $_SESSION['user_email'] = $email;
    }
    $stmt->close();
}

include '../includes/nav.php';

$adminEmails = [];
$adminQuery = $conn->query("SELECT Email FROM users WHERE Role = 'Admin'");
while ($row = $adminQuery->fetch_assoc()) {
    $adminEmails[] = $row['Email'];
}
$adminQuery->free();

$rooms = [];
$sql = "SELECT RoomID, RoomNumber, RoomCapacity, RoomDescription, RoomStatus FROM rooms";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

function getRoomSlots($roomId, $conn) {
    $today = date('Y-m-d');
    $slots = [];

    $sql = "SELECT StartTime, EndTime FROM reservations 
            WHERE RoomID = ? AND DATE(StartTime) = ? AND Status = 'Approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $roomId, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $reserved = [];
    while ($row = $result->fetch_assoc()) {
        $reserved[] = [
            'start' => date('H:i', strtotime($row['StartTime'])),
            'end'   => date('H:i', strtotime($row['EndTime']))
        ];
    }

    for ($h = 7; $h < 19; $h++) {
        $slotStart = sprintf('%02d:00', $h);
        $slotEnd = sprintf('%02d:00', $h + 1);
        $isReserved = false;

        foreach ($reserved as $r) {
            if (!($slotEnd <= $r['start'] || $slotStart >= $r['end'])) {
                $isReserved = true;
                break;
            }
        }

        if (!$isReserved) {
            $slots[] = $slotStart . ' - ' . $slotEnd;
        }
    }

    return $slots;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $pageTitle ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/home.css?v=<?= time() ?>" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3">
  <ul class="nav nav-tabs" id="tabs">
    <li class="nav-item">
      <a class="nav-link active" id="events-tab" href="#">Events</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="rooms-tab" href="#">Rooms</a>
    </li>
  </ul>

  <div id="events-content" class="mt-3">
    <h5 class="fw-bold">Upcoming Events</h5>
    <p>Event details will be loaded here.</p>
  </div>

  <div id="rooms-content" class="mt-3 d-none">
    <div class="row mb-3">
      <div class="col-md-7 mb-2 mb-md-0">
        <input type="text" class="form-control" placeholder="Search Room..." id="searchRoom" autocomplete="off">
      </div>
      <div class="col-md-5">
        <select id="statusFilter" class="form-select">
          <option value="">All Status</option>
          <option value="available">Available</option>
          <option value="occupied">Occupied</option>
          <option value="under maintenance">Under Maintenance</option>
        </select>
      </div>
    </div>

    <h5 class="fw-bold">Room Lists <span class="text-muted small" id="roomCount"><?= count($rooms) ?> Results</span></h5>

    <div class="list-group" id="room-list">
      <?php
      date_default_timezone_set('Asia/Manila');
      $now = date('H:i');
      $today = date('Y-m-d');

      foreach ($rooms as $room): 
        $availableSlots = getRoomSlots($room['RoomID'], $conn);
        $statusText = '';
        $statusClass = '';

        if (strtolower($room['RoomStatus']) === 'under maintenance') {
            $statusText = 'Under Maintenance';
            $statusClass = 'text-warning';
            $realStatus = 'under maintenance';
        } else {
            $sqlRes = "SELECT StartTime, EndTime FROM reservations 
                       WHERE RoomID = ? AND DATE(StartTime) = ? AND Status = 'Approved'";
            $stmtRes = $conn->prepare($sqlRes);
            $stmtRes->bind_param("is", $room['RoomID'], $today);
            $stmtRes->execute();
            $res = $stmtRes->get_result();

            $isOccupied = false;
            while ($r = $res->fetch_assoc()) {
                $start = date('H:i', strtotime($r['StartTime']));
                $end = date('H:i', strtotime($r['EndTime']));
                if ($now >= $start && $now < $end) {
                    $isOccupied = true;
                    break;
                }
            }
            $stmtRes->close();

            if ($isOccupied) {
                $statusText = 'Occupied';
                $statusClass = 'text-danger';
                $realStatus = 'occupied';
            } else {
                $statusText = 'Available';
                $statusClass = 'text-success';
                $realStatus = 'available';
            }
        }
      ?>
      <div class="list-group-item d-flex align-items-center p-3 room-item"
        data-room="<?= strtolower(htmlspecialchars($room['RoomNumber'])) ?>"
        data-desc="<?= strtolower(htmlspecialchars($room['RoomDescription'])) ?>"
        data-status="<?= $realStatus ?>">
        <div class="placeholder rounded bg-secondary" style="width: 50px; height: 50px;"></div>
        <div class="ms-3 flex-grow-1">
          <h5 class="mb-1"><?= htmlspecialchars($room['RoomNumber']) ?></h5>
          <p class="mb-1">Capacity: <?= htmlspecialchars($room['RoomCapacity']) ?><br><?= htmlspecialchars($room['RoomDescription']) ?></p>
          <p class="mb-1 <?= $statusClass ?>"><?= $statusText ?></p>
          <?php if (!empty($availableSlots)): ?>
            <div class="mb-1 small">
              <?php foreach ($availableSlots as $slot): ?>
                <span class="badge bg-success me-1 mb-1"><?= $slot ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="ms-auto text-end">
          <button class="btn btn-outline-primary btn-sm me-1"
            data-bs-toggle="modal"
            data-bs-target="#reservationModal"
            onclick="openReserveModal('<?= $room['RoomID'] ?>', '<?= $room['RoomCapacity'] ?>')">📅 Reserve</button>
          <button class="btn btn-outline-danger btn-sm"
            onclick="openReportModal('<?= htmlspecialchars($room['RoomNumber']) ?>')">🚨 Report</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div id="noRoomsMsg" class="text-center text-muted mt-3 d-none">No rooms found.</div>
  </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-3 shadow" style="max-width: 500px;">
      <form action="../includes/submit_report.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="room" id="reportRoomName">
        <div class="mb-3">
          <label class="form-label">From:</label>
          <input type="email" class="form-control" name="from" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">To:</label>
          <input type="email" class="form-control" name="to" value="<?= htmlspecialchars($adminEmails[0] ?? 'admin.room@dyci.edu.ph') ?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Problem:</label>
          <textarea class="form-control" name="problem" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Attach Photo (optional):</label>
          <input type="file" class="form-control" name="photo" accept="image/*" capture="environment">
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary w-100">Submit Report</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="reservationModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title mb-3">Reserve Room</h5>
      <form action="../includes/submit_reservation.php" method="POST" id="reserveForm">
        <input type="hidden" name="room_id" id="reserveRoomId">
        <input type="hidden" name="capacity" id="reserveRoomCapacity">
        <div class="mb-2">
          <label>Class/Section</label>
          <input type="text" name="section" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="d-flex gap-2">
          <div>
            <label>Start Time</label>
            <input type="time" name="start" class="form-control" required>
          </div>
          <div>
            <label>End Time</label>
            <input type="time" name="end" class="form-control" required>
          </div>
        </div>
        <div class="mt-2">
          <label>Purpose</label>
          <textarea name="purpose" class="form-control" required></textarea>
        </div>
        <div class="mt-3" id="timeStatusContainer" style="display:none;">
          <label class="form-label fw-bold">Available Time Slots</label>
          <div id="timeSlots" class="mb-3 small"></div>
          <label class="form-label fw-bold">Occupied (Today)</label>
          <div id="todayOccupied" class="text-danger small"></div>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if (isset($_SESSION['report_status']) || isset($_SESSION['reserve_status'])): ?>
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="modal-header <?= ($_SESSION['report_status'] ?? $_SESSION['reserve_status']) === 'success' ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title">
          <?= isset($_SESSION['report_status']) 
                ? ($_SESSION['report_status'] === 'success' ? 'Report Submitted' : 'Report Failed') 
                : ($_SESSION['reserve_status'] === 'success' ? 'Reservation Submitted' : 'Reservation Failed') ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= htmlspecialchars($_SESSION['report_message'] ?? $_SESSION['reserve_message']) ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
    setTimeout(() => modal.hide(), 3000);
  });
</script>

<?php
unset($_SESSION['report_status'], $_SESSION['report_message']);
unset($_SESSION['reserve_status'], $_SESSION['reserve_message']);
endif;
?>


<script src="../assets/js/home.js?v=<?= time() ?>"></script>
</body>
</html>
