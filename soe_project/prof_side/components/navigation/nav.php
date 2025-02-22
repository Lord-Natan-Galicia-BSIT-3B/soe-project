<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="components/navigation/nav.css">
  <script src="https://kit.fontawesome.com/yourkitcode.js" crossorigin="anonymous"></script>
</head>

<nav class="main-nav">
  <input type="checkbox" id="check" />
  <label for="check" class="checkbtn">
    <i class="fas fa-bars"></i>
  </label>
  <a href="index.php" class="logo-container">
    <img src="images/dyci-logo.png" alt="Logo" class="logo" />
    <span class="app-name">RoomFinder</span>
  </a>
  <ul class="nav-center">
    <li><a href="index.php?page=Home">Home</a></li>
    <li><a href="index.php?page=Room">Room</a></li>
    <li><a href="index.php?page=Reports">Reports</a></li>
  </ul>
  <ul class="nav-right">
    <li><a href="#" data-tooltip="QR Code"><i class="fas fa-qrcode"></i></a></li>
    <li><a href="#" data-tooltip="Calendar"><i class="fas fa-calendar-alt"></i></a></li>
    <li><a href="#" data-tooltip="Notifications"><i class="fas fa-bell"></i></a></li>

    <li class="profile">
      <span class="divider"></span>
      <div class="profile-info">
        <span class="profile-name">Ms. Lim</span>
        <span class="profile-role">Professor</span>
      </div>
      <div class="profile-avatar"></div>
      <i class="fas fa-caret-down"></i>
    </li>
  </ul>
</nav>

