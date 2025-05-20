<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Home';
}
$currentPage = strtolower(trim($pageTitle));
?>

<style>
.navbar {
    background-color: #002D62;
}
.navbar .nav-link,
.navbar .navbar-brand,
.btn-outline-light {
    color: white;
}

/* Hide page title in desktop */
.navbar-brand {
    display: block;
}
@media (min-width: 992px) {
    .navbar-brand {
        display: none !important;
    }
}

/* QR button hover */
.qr-icon {
    font-size: 1.3rem;
    padding: 0.5rem;
    border-radius: 5px;
}
.qr-icon:hover {
    background-color: #004080;
    transition: 0.2s;
}

/* Button hover */
.btn-outline-light:hover {
    background-color: #004080;
    border-color: #004080;
    color: white;
}

/* Desktop nav: box highlight for active */
@media (min-width: 992px) {
    .navbar .nav-link {
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }
    .navbar .nav-link:hover {
        background-color: #004080;
    }
    .navbar .nav-link.active {
        background-color: #ffdd57;
        color: #002D62 !important;
        font-weight: bold;
    }
}

/* Sidebar */
.offcanvas {
    background-color: #002D62;
}
.offcanvas .nav-link {
    color: white;
}
.profile-section img {
    border-radius: 50%;
}
</style>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid justify-content-between align-items-center">
    <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      &#9776;
    </button>

    <span class="navbar-brand mb-0"><?= htmlspecialchars($pageTitle) ?></span>

    <div class="d-none d-lg-flex align-items-center gap-3 ms-auto">
      <button class="btn btn-outline-light qr-icon" data-bs-toggle="modal" data-bs-target="#qrScannerModal" title="Scan QR">
        📷
      </button>

      <a class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>" href="../includes/home.php">Home</a>
      <a class="nav-link <?= in_array($currentPage, ['reservation', 'your reservation', 'your reservations']) ? 'active' : '' ?>" href="../includes/your_reservation.php">Reservation</a>
      <a class="nav-link <?= $currentPage === 'notifications' ? 'active' : '' ?>" href="../includes/notifications.php">Notifications</a>
      <a class="nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>" href="../includes/settings.php">Settings</a>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebar">
  <div class="offcanvas-header border-bottom border-white">
    <div class="profile-section d-flex align-items-center gap-2">
      <img src="../assets/images/profile.jpg" alt="Profile" class="profile-img" width="40" height="40">
      <div><strong class="text-white">Online</strong></div>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <li><a class="nav-link text-white" href="../includes/home.php">Home</a></li>
      <li><a class="nav-link text-white" href="../includes/your_reservation.php">Your Reservation</a></li>
      <li><a class="nav-link text-white" href="../includes/notifications.php">Notifications</a></li>
      <hr class="text-white">
      <li><a class="nav-link text-white" href="../includes/settings.php">Settings</a></li>
    </ul>
  </div>
</div>

<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrScannerLabel">Scan QR Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <div id="qr-reader" style="width: 100%;"></div>
        <p class="mt-3 text-muted">Scan a room QR code to view details.</p>
      </div>
    </div>
  </div>
</div>
