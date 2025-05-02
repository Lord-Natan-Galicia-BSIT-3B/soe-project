<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
</head>
<body>
  <nav>
    <div class="logo">
      <img src="assets/images/dyci-logo.png" alt="DYCI Logo">
      <h1>DYCI RoomTrack</h1>
    </div>
    <div class="divider"></div>
    <ul>
      <li><a href="index.php?page=Dashboard"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="index.php?page=Reservation"><i class="fa-solid fa-calendar-check"></i> Room Reservation</a></li>
      <li><a href="index.php?page=Monitoring"><i class="fa-solid fa-door-open"></i > Room Monitoring</a></li>
      <li><a href="index.php?page=Maintenance"><i  class="fa-solid fa-wrench"></i> Maintenance</a></li>
      <li><a href="index.php?page=Report"><i class="fa-solid fa-chart-bar"></i> Reports</a></li>
      <li><a href="index.php?page=User"><i class="fa-solid fa-users-cog"></i> User Management</a></li>
      <li><a href="#" id="logoutLink"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </nav>
  <div id="logoutModal" class="modal">
    <div class="modal-content">
      <h2>Confirm Logout</h2>
      <p>Are you sure you want to logout?</p>
      <button class="confirm-btn" id="confirmLogout">Yes, Logout</button>
      <button class="cancel-btn" id="cancelLogout">Cancel</button>
    </div>
  </div>
  <div id="spinnerOverlay" class="spinner-overlay">
    <div class="spinner"></div>
  </div>

  <script src="../assets/js/sidebar.js"></script>
</body>
</html>
