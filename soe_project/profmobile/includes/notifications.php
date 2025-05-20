<?php
session_start();
$pageTitle = 'Notifications';
require_once '../connection/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/loginPage.php");
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT r.StartTime, r.EndTime, r.Status, r.Purpose, r.updated_at, rm.RoomNumber
        FROM reservations r
        JOIN rooms rm ON r.RoomID = rm.RoomID
        WHERE r.UserID = ?
        ORDER BY r.StartTime DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);

include '../includes/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Notifications</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/notification.css?v=<?= time() ?>">
</head>
<body>
<div class="container py-4">
  <h4 class="mb-3">Notifications</h4>

  <?php if (count($reservations) > 0): ?>
    <?php foreach ($reservations as $r): 
      $status = strtolower($r['Status']);
      $type = match ($status) {
        'approved' => 'approved',
        'rejected' => 'rejected',
        'under maintenance' => 'maintenance',
        default => 'info'
      };

      $icon = match ($type) {
        'approved' => '✔️',
        'rejected' => '❌',
        'maintenance' => '🛠️',
        default => '🔔'
      };

      $msg = match ($type) {
        'approved' => "Your reservation for Room {$r['RoomNumber']} has been approved.",
        'rejected' => "Your reservation for Room {$r['RoomNumber']} has been rejected. Please choose another time or room.",
        'maintenance' => "Room {$r['RoomNumber']} is currently under maintenance. Your reservation was declined.",
        default => "Reservation status update for Room {$r['RoomNumber']}."
      };

      $timeLabel = timeAgo($r['updated_at'] ?? $r['StartTime']);

    ?>
        <div class="notification-card">
        <img src="../assets/images/profile.jpg" alt="Avatar" class="notif-avatar">
        <div class="notif-body">
            <h6 class="notif-title">Reservation Notice</h6>
            <p class="notif-message"><?= $msg ?></p>
            <p class="notif-time"><?= $timeLabel ?></p>
        </div>
        </div>

    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info">You have no reservation notifications.</div>
  <?php endif; ?>
</div>

<?php
function timeAgo($datetime) {
  $timestamp = strtotime($datetime);
  $diff = time() - $timestamp;
  if ($diff < 60) return 'Just now';
  if ($diff < 3600) return floor($diff / 60) . ' min ago';
  if ($diff < 86400) return floor($diff / 3600) . ' hour(s) ago';
  return date('M d, Y', $timestamp);
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>
</html>
