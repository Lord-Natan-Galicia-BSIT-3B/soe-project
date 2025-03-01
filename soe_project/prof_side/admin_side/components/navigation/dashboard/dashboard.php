<?php
require_once __DIR__ . '/../../dbconnection.php';

$totalRoomsQuery = "SELECT COUNT(*) AS total FROM rooms";
$occupiedRoomsQuery = "SELECT COUNT(*) AS occupied FROM rooms WHERE status = 'Occupied'";
$maintenanceRoomsQuery = "SELECT COUNT(*) AS maintenance FROM rooms WHERE status = 'Under Maintenance'";
$availableRoomsQuery = "SELECT COUNT(*) AS available FROM rooms WHERE status = 'Available'";

$totalRoomsResult = mysqli_query($conn, $totalRoomsQuery);
$occupiedRoomsResult = mysqli_query($conn, $occupiedRoomsQuery);
$maintenanceRoomsResult = mysqli_query($conn, $maintenanceRoomsQuery);
$availableRoomsResult = mysqli_query($conn, $availableRoomsQuery);

$totalRooms = mysqli_fetch_assoc($totalRoomsResult)['total'];
$occupiedRooms = mysqli_fetch_assoc($occupiedRoomsResult)['occupied'];
$maintenanceRooms = mysqli_fetch_assoc($maintenanceRoomsResult)['maintenance'];
$availableRooms = mysqli_fetch_assoc($availableRoomsResult)['available'];

$pendingRequests = 5;

$roomCounts = [30, 40, 38, 50, 48];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/navigation/dashboard/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <section id="analytics-section">
    <div class="title-section">
      <h2>Analytics Overview</h2>
    </div>

    <div class="count-section">
      <div class="count-item">
        <h3>Total Rooms</h3>
        <p><?php echo $totalRooms; ?></p>
      </div>

      <div class="count-item">
        <h3>Available</h3>
        <p><?php echo $availableRooms; ?></p>
      </div>

      <div class="count-item">
        <h3>Occupied</h3>
        <p><?php echo $occupiedRooms; ?></p>
      </div>

      <div class="count-item">
        <h3>Under Maintenance</h3>
        <p><?php echo $maintenanceRooms; ?></p>
      </div>

      <div class="count-item">
        <h3>Pending Request</h3>
        <p><?php echo $pendingRequests; ?></p>
      </div>
    </div>

    <div class="chart-container">
      <canvas id="roomsChart"></canvas>
    </div>
  </section>

  <div class="graph-container">
    <div class="chart-wrapper">
        <canvas id="roomsChart"></canvas>
    </div>
    <div class="graph-info">
        <p><strong style="color: #9FA2B4; font-size: 1rem; font-weight:100;">Total</strong><br><strong style="color: #252733; font-size: 1.3rem;"><?php echo $totalRooms; ?></strong></p>
        <div class="divider"></div>
        <p><strong style="color: #9FA2B4; font-size: 1rem; font-weight:100;">Status</strong><br><strong style="color: #252733; font-size: 1.3rem;">Available</strong></p>
        <div class="divider"></div>
        <p><strong style="color: #9FA2B4; font-size: 1rem; font-weight:100;">Date</strong><br><strong style="color: #252733; font-size: 1.3rem;"><?php echo date("d/m/y"); ?></strong></p>
    </div>
</div>

<script src="components/navigation/dashboard/dashboard.js"></script>

</body>
</html>
