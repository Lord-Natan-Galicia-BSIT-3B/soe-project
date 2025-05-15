<?php
session_start();

$username = 'Profile';
$status   = 'Online';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings</title>
  <link rel="stylesheet" href="../assets/css/settings.css" />
</head>
<body>
 
  <div class="overlay"></div>
  <aside class="sidebar" role="navigation">
    <div class="sidebar-header">
      <div class="profile-section">
        <img src="assets/images/profile-placeholder.png"
             alt="Profile" class="profile-img"/>
        <div class="profile-info">
          <div class="username"><?= htmlspecialchars($username) ?></div>
          <div class="status"><?= htmlspecialchars($status) ?></div>
        </div>
      </div>
      <button id="sidebar-close" class="close-btn">&times;</button>
    </div>
    <nav class="sidebar-nav">
      <a href="home.php">Home</a>
      <a href="calendar.php">Calendar</a>
      <a href="request-room.php">Request a Room</a>
      <a href="report-room.php">Report Room</a>
      <a href="notifications.php">Notifications</a>
      <hr/>
      <a href="settings.php">Settings</a>
      <a href="../auth/logout.php">Logout</a>
    </nav>
  </aside>

  
  <header class="topbar">
    <button id="menu-toggle" class="menu-btn" aria-label="Open menu">&#9776;</button>
    <h1 class="page-title">Settings</h1>
  </header>

 
  <main>
    <section class="section">
      <h2 class="section-title">Notification Settings</h2>
      <div class="setting-item">
        <div class="setting-info">
          <p class="setting-title">Notification</p>
          <p class="setting-desc" id="notif-desc">Enabled</p>
        </div>
        <button class="toggle-btn" id="notif-toggle">
          <span class="toggle-icon"></span>
        </button>
      </div>
      <div class="setting-item">
        <div class="setting-info">
          <p class="setting-title">Dark mode</p>
          <p class="setting-desc" id="dark-desc">Disabled</p>
        </div>
        <button class="toggle-btn" id="darkmode-toggle">
          <span class="toggle-icon"></span>
        </button>
      </div>
    </section>

    <hr/>

    <section class="section">
      <h2 class="section-title">Account Settings</h2>
      <a href="account.php" class="setting-link">Account Info</a>
    </section>
  </main>

 
  <script src="../assets/js/sidebar.js"></script>
  <script src="../assets/js/darkmode.js"></script>
</body>
</html>
