<head>
  <meta charset="UTF-8">
  <title>Navigation with Modern Logout Confirmation</title>
  <link rel="stylesheet" href="components/navigation/nav.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
</head>

  <nav>
    <div class="logo">
      <img src="Images/dyci-logo.png" alt="DYCI Logo">
      <h1>DYCI Room Track</h1>
    </div>
    <div class="divider"></div>
    <ul>
      <li><a href="index.php?page=Dashboard"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="index.php?page=Reservation"><i class="fa-solid fa-calendar-check"></i> Room Reservation</a></li>
      <li><a href="index.php?page=Monitoring"><i class="fa-solid fa-door-open"></i> Room Monitoring</a></li>
      <li><a href="index.php?page=Maintenance"><i class="fa-solid fa-wrench"></i> Maintenance</a></li>
      <li><a href="index.php?page=Report"><i class="fa-solid fa-chart-bar"></i> Reports</a></li>
      <li><a href="index.php?page=Building"><i class="fa-solid fa-building"></i> Building Management</a></li>
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

  <script>
    const logoutLink = document.getElementById('logoutLink');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');
    logoutLink.addEventListener('click', function(e) {
      e.preventDefault();
      logoutModal.classList.add('show');
    });
    confirmLogout.addEventListener('click', function() {
      window.location.href = "index.php?page=logout";
    });
    cancelLogout.addEventListener('click', function() {
      logoutModal.classList.remove('show');
    });
    window.addEventListener('click', function(e) {
      if (e.target == logoutModal) {
        logoutModal.classList.remove('show');
      }
    });
  </script>

