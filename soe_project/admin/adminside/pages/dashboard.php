<?php
require_once __DIR__ . '/../db_connect.php';

$totalRoomsQuery = "SELECT COUNT(*) AS total FROM rooms";
$occupiedRoomsQuery = "SELECT COUNT(*) AS occupied FROM rooms WHERE RoomStatus = 'Occupied'";
$maintenanceRoomsQuery = "SELECT COUNT(*) AS maintenance FROM rooms WHERE RoomStatus = 'Under Maintenance'";
$availableRoomsQuery = "SELECT COUNT(*) AS available FROM rooms WHERE RoomStatus = 'Available'";

$totalRoomsResult = mysqli_query($conn, $totalRoomsQuery);
$occupiedRoomsResult = mysqli_query($conn, $occupiedRoomsQuery);
$maintenanceRoomsResult = mysqli_query($conn, $maintenanceRoomsQuery);
$availableRoomsResult = mysqli_query($conn, $availableRoomsQuery);

$totalRooms = mysqli_fetch_assoc($totalRoomsResult)['total'];
$occupiedRooms = mysqli_fetch_assoc($occupiedRoomsResult)['occupied'];
$maintenanceRooms = mysqli_fetch_assoc($maintenanceRoomsResult)['maintenance'];
$availableRooms = mysqli_fetch_assoc($availableRoomsResult)['available'];

$pendingRequests = 5;

$roomsListQuery = "SELECT RoomNumber, RoomStatus, RoomCapacity FROM rooms";
$roomsListResult = mysqli_query($conn, $roomsListQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<section id="analytics-section">
  <div class="title-section">
    <h2>Analytics Overview</h2>
  </div>

  <div class="count-section">
    <div class="count">
      <div class="count-item"><i class="fas fa-building"></i><div class="count-text"><h3>Total Rooms</h3><p><?php echo $totalRooms; ?></p></div></div>
      <div class="count-item"><i class="fas fa-door-open"></i><div class="count-text"><h3>Available</h3><p><?php echo $availableRooms; ?></p></div></div>
      <div class="count-item"><i class="fas fa-door-closed"></i><div class="count-text"><h3>Occupied</h3><p><?php echo $occupiedRooms; ?></p></div></div>
      <div class="count-item"><i class="fas fa-tools"></i><div class="count-text"><h3>Under Maintenance</h3><p><?php echo $maintenanceRooms; ?></p></div></div>
      <div class="count-item"><i class="fas fa-hourglass-half"></i><div class="count-text"><h3>Pending Request</h3><p><?php echo $pendingRequests; ?></p></div></div>
    </div>
  </div>

  <div class="chart-section">
    <div class="chart-container">
    <canvas id="roomsChart"></canvas>
    <div class="graph-info">
      <p><strong>Total</strong><br><strong>123</strong></p>
      <div class="divider"></div>
      <p><strong>Status</strong><br><strong>Available</strong></p>
      <div class="divider"></div>
      <p><strong>Date</strong><br><strong>07/05/25</strong></p>
    </div>
</div>

  </div>

  <table class="rooms-table">
    <thead>
      <tr>
        <th>Room Number</th>
        <th>Status</th>
        <th>Capacity</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($roomsListResult && mysqli_num_rows($roomsListResult) > 0) {
          while ($room = mysqli_fetch_assoc($roomsListResult)) {
              echo "<tr>
                      <td>" . htmlspecialchars($room['RoomNumber']) . "</td>
                      <td>" . htmlspecialchars($room['RoomStatus']) . "</td>
                      <td>" . htmlspecialchars($room['RoomCapacity']) . "</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='3'>No rooms found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</section>

<script src="assets/js/dashboard.js"></script>

</body>
</html>
