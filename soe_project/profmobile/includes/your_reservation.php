<?php
session_start();
require_once "../connection/dbconnect.php";
$pageTitle = 'Reservation';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/loginPage.php");
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT r.ReservationID, r.StartTime, r.EndTime, r.Purpose, r.Status, rm.RoomNumber
        FROM reservations r
        JOIN rooms rm ON rm.RoomID = r.RoomID
        WHERE r.UserID = ?
        ORDER BY r.StartTime ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

include '../includes/nav.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Reservations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/reservation.css?v=<?= time() ?>" />
</head>

<body>
<div class="container py-4">
  <h3 class="mb-4">Your Reservations</h3>

  <?php if (count($reservations) > 0): ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover responsive-table">
    <thead class="table-dark">
      <tr>
        <th>Room</th>
        <th>Date</th>
        <th>Time</th>
        <th>Purpose</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reservations as $res): ?>
        <?php
          $status = $res['Status'];
          $badge = $status === 'Approved' ? 'success' : ($status === 'Pending' ? 'warning' : 'danger');
        ?>
        <tr>
          <td data-label="Room"><?= htmlspecialchars($res['RoomNumber']) ?></td>
          <td data-label="Date"><?= date('Y-m-d', strtotime($res['StartTime'])) ?></td>
          <td data-label="Time"><?= date('g:i A', strtotime($res['StartTime'])) . ' - ' . date('g:i A', strtotime($res['EndTime'])) ?></td>
          <td data-label="Purpose"><?= htmlspecialchars($res['Purpose']) ?></td>
          <td data-label="Status">
            <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
          </td>
          <td data-label="Actions">
            <form action="cancel_reservation.php" method="POST" class="d-inline">
              <input type="hidden" name="reservation_id" value="<?= $res['ReservationID'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
            </form>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal"
              onclick="fillUpdateForm(<?= $res['ReservationID'] ?>, '<?= $res['StartTime'] ?>', '<?= $res['EndTime'] ?>')">Update</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

  <?php else: ?>
    <div class="alert alert-info">You have no reservations.</div>
  <?php endif; ?>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-4">
      <h5 class="modal-title">Update Reservation</h5>
      <form action="update_reservation.php" method="POST">
        <input type="hidden" name="reservation_id" id="updateReservationId">
        <div class="mb-2">
          <label class="form-label">New Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">New Start Time</label>
          <input type="time" name="start_time" id="updateStartTime" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">New End Time</label>
          <input type="time" name="end_time" id="updateEndTime" class="form-control" required>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fillUpdateForm(id, start, end) {
  document.getElementById('updateReservationId').value = id;
  document.getElementById('updateStartTime').value = start.substring(11, 16);
  document.getElementById('updateEndTime').value = end.substring(11, 16);
}
</script>
</body>
</html>
