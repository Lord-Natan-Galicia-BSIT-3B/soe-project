<?php
require_once(__DIR__ . '../../db_connect.php');
require_once(__DIR__ . '../../filter_functions.php');


$status = $_GET['status'] ?? null;
$search = $_GET['search'] ?? null;
$building = $_GET['building'] ?? null;

$counts = getRoomCounts($conn);
$rooms = getFilteredRooms($conn, $status, $search, $building);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/management.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/234775b3ba.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/Pages.css">
    <style>
        body { margin-left: 260px; padding: 25px; }
        .room-card { border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); overflow: hidden; position: relative; }
        .room-card img { width: 100%; height: 250px; object-fit: cover; }
        .status-available { color: green; }
        .status-occupied { color: purple; }
        .edit-button { position: absolute; top: 10px; right: 10px; background: none; border: none; color: #6c757d; font-size: 1.2rem; }
    </style>
</head>
<body>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editModalLabel">ROOM FEATURES</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="room-image.jpg" class="img-fluid mb-3" alt="Room Image">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Room Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="Room 101">
                                <button class="btn btn-outline-secondary"><i class="fas fa-pen"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" class="form-control" value="30">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room Description</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Room Schedule Modal START -->
  <div class="modal fade" id="roomScheduleModal" tabindex="-1" aria-labelledby="roomScheduleLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="roomScheduleLabel">ROOM SCHEDULE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <img src="your-schedule-image.png" alt="Room Schedule" class="img-fluid mb-3" />
            <form id="editScheduleForm">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="professorName" class="form-label">Professor Name</label>
                  <select class="form-select" id="professorName" name="professorName">
                    <option selected disabled>Select Professor</option>
                    <option>Prof. A</option>
                    <option>Prof. B</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="subjectPurpose" class="form-label">Subject/Purpose</label>
                  <input type="text" class="form-control" id="subjectPurpose" name="subjectPurpose" placeholder="Type here">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="date" class="form-label">Date</label>
                  <input type="text" class="form-control" id="date" name="date" placeholder="MM/DD">
                </div>
                <div class="col-md-6">
                  <label for="startTime" class="form-label">Start Time</label>
                  <input type="time" class="form-control" id="startTime" name="startTime" value="09:00">
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">Edit Schedule</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Room Schedule Modal END -->

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link <?= !isset($_GET['status']) ? 'active' : '' ?>" href="?page=Monitoring">All Rooms (<?= $counts['total'] ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === 'Available') ? 'active' : '' ?>" href="?page=Monitoring&status=Available">Available Rooms (<?= $counts['available'] ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === 'Reserved') ? 'active' : '' ?>" href="?page=Monitoring&status=Reserved">Reserved Rooms (<?= $counts['reserved'] ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === 'Under Maintenance') ? 'active' : '' ?>" href="?page=Monitoring&status=Under Maintenance">Under Maintenance (<?= $counts['under_maintenance'] ?>)</a>
                </li>
            </ul>

            <form method="get" class="d-flex">
                <input type="hidden" name="page" value="Monitoring">
                <?php if ($status): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
                <?php endif; ?>
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Room" value="<?= htmlspecialchars($search) ?>">
                <select name="building" class="form-select form-select-sm me-2">
                    <option value="">All Buildings</option>
                    <option value="A" <?= ($building === 'A') ? 'selected' : '' ?>>Building A</option>
                    <option value="B" <?= ($building === 'B') ? 'selected' : '' ?>>Building B</option>
                    <option value="C" <?= ($building === 'C') ? 'selected' : '' ?>>Building C</option>
                </select>
                <button class="btn btn-secondary btn-sm" type="submit">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>
        </div>

        <div class="row">
        <?php if ($rooms && $rooms->num_rows > 0): ?>
            <?php while ($row = $rooms->fetch_assoc()): ?>
            <div class="col-md-6 mb-4">
                <div class="card room-card">
                    <button class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class='fa-solid fa-pen-to-square'></i>
                    </button>
                    <img src="<?= htmlspecialchars($row['RoomImage'] ?? 'default.jpg') ?>" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['RoomNumber'] ?? 'Unnamed Room') ?></h5>
                        <p class="card-text">Capacity: <?= $row['RoomCapacity'] ?? '0' ?> Students</p>
                        <p class="card-text">Room Equipment/Specs: <?= htmlspecialchars($row['RoomDescription'] ?? 'N/A') ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> Building ID: <?= htmlspecialchars($row['BuildingID'] ?? 'Unknown') ?></p>
                        <p class="status-<?= strtolower($row['RoomStatus']) ?? 'unknown' ?>">
                            ● <?= ucfirst($row['RoomStatus'] ?? 'Unknown') ?>
                        </p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roomScheduleModal">
                            Room Schedule
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No rooms found.</p>
        <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
