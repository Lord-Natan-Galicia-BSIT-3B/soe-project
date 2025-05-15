<?php
include "../connection/dbconnect.php";

$buildings = [];
$sqlB = 'SELECT BuildingID, BuildingName FROM buildings ORDER BY BuildingName';
$resB = $conn->query($sqlB);
while ($b = $resB->fetch_assoc()) {
    $buildings[] = $b;
}
$resB->free();


$buildingId = isset($_GET['building_id'])
    ? (int)$_GET['building_id']
    : (count($buildings) ? (int)$buildings[0]['BuildingID'] : null);


$rooms = [];
if ($buildingId) {
    $stmtR = $conn->prepare(
      'SELECT RoomID, RoomNumber, RoomCapacity, RoomImage
         FROM rooms
        WHERE BuildingID = ?
        ORDER BY RoomNumber'
    );
    $stmtR->bind_param('i', $buildingId);
    $stmtR->execute();
    $resR = $stmtR->get_result();
    while ($r = $resR->fetch_assoc()) {
        $rooms[] = $r;
    }
    $stmtR->close();
}


$roomId = isset($_GET['room_id'])
    ? (int)$_GET['room_id']
    : (count($rooms) ? (int)$rooms[0]['RoomID'] : null);


$photos = [];
if ($roomId) {
    $stmtP = $conn->prepare('SELECT RoomImage FROM rooms WHERE RoomID = ?');
    $stmtP->bind_param('i', $roomId);
    $stmtP->execute();
    $stmtP->bind_result($filename);
    if ($stmtP->fetch() && $filename) {
        $photos[] = $filename;
    }
    $stmtP->close();
}

$conn->close();
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Room Reservation</title>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />

  <link rel="stylesheet" href="../assets/css/reservation.css">
</head>
<body>


  <aside class="sidebar">
    <div class="profile">
      <img src="assets/img/profile.jpg" alt="Munir Abba">
      <div class="profile-info">
        <strong>Munir Abba</strong>
        <span class="status">Online</span>
      </div>
    </div>
    <nav class="nav-menu">
      <ul>
        <li><i class="fas fa-home"></i><span>Home</span></li>
        <li><i class="fas fa-calendar"></i><span>Calendar</span></li>
        <li>
          <i class="fas fa-plus"></i><span>Request A Room</span>
          <i class="fas fa-chevron-right chevron"></i>
        </li>
        <li>
          <i class="fas fa-file-alt"></i><span>Report Room</span>
          <i class="fas fa-chevron-right chevron"></i>
        </li>
        <li><i class="fas fa-bell"></i><span>Notification</span></li>
      </ul>
    </nav>
    <div class="divider"></div>
    <div class="settings">
      <h3>Settings</h3>
      <ul>
        <li>
          <i class="fas fa-cog"></i><span>Settings</span>
          <i class="fas fa-chevron-right chevron"></i>
        </li>
        <li><i class="fas fa-sign-out-alt"></i><span>Logout</span></li>
      </ul>
    </div>
  </aside>

  
  <div class="overlay"></div>

  
  <div class="main-content">
    <div class="reservation-container">

      
      <header class="header">
        <button id="menu-toggle" class="menu-btn">
          <i class="fas fa-bars"></i>
        </button>
        <h1 class="title">Reservation</h1>
      </header>

     
      <div class="image-gallery">
        <?php
          $photoDir = 'assets/img/rooms/';
          foreach ($photos as $file):
            $path = $photoDir . basename($file);
            if (!file_exists($path)) continue;
        ?>
          <div class="image-item">
            <img src="<?= htmlspecialchars($path) ?>" alt="Room photo">
          </div>
        <?php endforeach; ?>
        <div class="add-photo">
          <i class="fas fa-plus"></i>
          <span>Photos</span>
        </div>
      </div>

      
      <form class="reservation-form" action="submit_reservation.php" method="POST">
        <input type="hidden" name="building_id" value="<?= $buildingId ?>">
        <input type="hidden" name="room_id"     value="<?= $roomId ?>">

        
        <div class="form-group">
          <label for="building">Building</label>
          <select
            id="building"
            name="building_id"
            required
            onchange="location.search='building_id='+this.value;"
          >
            <?php foreach ($buildings as $b): ?>
              <option
                value="<?= $b['BuildingID'] ?>"
                <?= $b['BuildingID']==$buildingId ? 'selected' : '' ?>
              >
                <?= htmlspecialchars($b['BuildingName']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

       
        <div class="form-row">
          <div class="form-group">
            <label for="room">Room Name / Number</label>
            <select
              id="room"
              name="room_id"
              required
              onchange="location.search='building_id=<?= $buildingId ?>&room_id='+this.value;"
            >
              <option value="">Select A Room</option>
              <?php foreach ($rooms as $r): ?>
                <option
                  value="<?= $r['RoomID'] ?>"
                  <?= $r['RoomID']==$roomId ? 'selected' : '' ?>
                >
                  <?= htmlspecialchars($r['RoomNumber']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="capacity">Capacity</label>
            <input
              type="number"
              id="capacity"
              name="capacity"
              value="<?=
                ($roomId && $rooms)
                  ? array_column($rooms,'RoomCapacity','RoomID')[$roomId]
                  : ''
              ?>"
              readonly
            >
          </div>
        </div>

      
        <div class="form-group">
          <label for="section">Class / Section</label>
          <input
            type="text"
            id="section"
            name="section"
            placeholder="Type Here"
            required
          >
        </div>

       
        <div class="form-row">
          <div class="form-group date-group">
            <label for="date">Date</label>
            <div class="date-wrapper">
              <input type="date" id="date" name="date" required>
              <i class="fas fa-calendar-alt calendar-icon"></i>
            </div>
            <small class="date-format">MM/DD/YYYY</small>
          </div>
          <div class="form-group time-group">
            <label for="start">Start Time</label>
            <input type="time" id="start" name="start" required>
          </div>
          <div class="form-group time-group">
            <label for="end">End Time</label>
            <input type="time" id="end" name="end" required>
          </div>
        </div>

        
        <div class="form-group">
          <label for="purpose">Purpose Of Use</label>
          <textarea
            id="purpose"
            name="purpose"
            rows="4"
            placeholder="Type here"
            required
          ></textarea>
        </div>

        <button type="submit" class="submit-btn">REQUEST</button>
      </form>
    </div>
  </div>

  
  <script src="../assets/js/sidebar.js"></script>
</body>
</html>
