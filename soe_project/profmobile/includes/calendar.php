<?php

$pageTitle = 'Calendar';

include('../includes/nav.php');

$schedules = [];
$roomId = isset($_GET['room']) ? (int)$_GET['room'] : null;
$selectedDate = $_GET['date'] ?? null;
$roomName = '';

if ($roomId) {
    $result = $conn->query("SELECT RoomNumber FROM rooms WHERE RoomID = $roomId");
    if ($row = $result->fetch_assoc()) {
        $roomName = $row['RoomNumber'];
    }

    if ($selectedDate) {
        $stmt = $conn->prepare("
            SELECT r.StartTime, r.EndTime, rm.RoomNumber
            FROM reservations r
            JOIN rooms rm ON r.RoomID = rm.RoomID
            WHERE DATE(r.StartTime) = ?
            AND r.RoomID = ?
            AND r.Status = 'Approved'
            ORDER BY r.StartTime ASC
        ");
        $stmt->bind_param("si", $selectedDate, $roomId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $pageTitle ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
  <link rel="stylesheet" href="../assets/css/calendar.css" />
</head>
<body>
  <div class="container mt-3">
    <h5 class="fw-bold"><?= $pageTitle ?></h5>
    <?php if ($roomName): ?>
      <h6 class="text-muted mb-3">Room: <?= htmlspecialchars($roomName) ?></h6>
    <?php endif; ?>

    <div id="calendar"></div>

    <?php if ($selectedDate): ?>
      <div class="mt-4">
        <h6 class="fw-bold"><?= date("F j, Y", strtotime($selectedDate)) ?></h6>

        <?php if (empty($schedules)): ?>
          <p class="text-success">✅ Room is available all day.</p>
        <?php else: ?>
          <?php foreach ($schedules as $event): ?>
            <div class="event-item">
              <?= htmlspecialchars($event['RoomNumber']) ?>
              <span>
                <?= date("h:i A", strtotime($event['StartTime'])) ?>
                - <?= date("h:i A", strtotime($event['EndTime'])) ?>
              </span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <form method="post" action="submit_reservation.php" class="mt-4">
          <input type="hidden" name="room_id" value="<?= htmlspecialchars($roomId) ?>">
          <input type="hidden" name="selected_date" value="<?= htmlspecialchars($selectedDate) ?>">
          <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" name="start_time" required>
          </div>
          <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" class="form-control" name="end_time" required>
          </div>
          <button type="submit" class="btn btn-primary">Reserve this Room</button>
        </form>
      </div>
    <?php endif; ?>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="../assets/js/calendar.js"></script>


</body>
</html>
