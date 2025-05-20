<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = 'Profile';
$status   = 'Online';
$pageTitle = 'Settings';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $pageTitle ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/settings.css" />
</head>
<body>

<?php include('../includes/nav.php'); ?>

<main>
  <section class="section">
    <h2 class="section-title">Notification Settings</h2>
    <div class="setting-item">
      <div class="setting-info">
        <p class="setting-title">Notifications</p>
        <p class="setting-desc" id="notif-desc">Enabled</p>
      </div>
      <button class="toggle-btn active" id="notif-toggle">
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
    <a href="../includes/accountsettings.php" class="setting-link">Account Info</a>
    <br/>
    <a href="#" class="setting-link text-danger mt-2 d-inline-block" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
  </section>
</main>


<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
      <p>Are you sure you want to log out?</p>
      <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../auth/logout.php" class="btn btn-danger">Yes, Logout</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebar.js"></script>
<script src="../assets/js/darkmode.js"></script>
</body>
</html>
