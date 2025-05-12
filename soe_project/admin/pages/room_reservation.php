<?php

require_once(__DIR__ . '../../db_connect.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/Pages.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    .form-select {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 8px 12px;
      font-size: 14px;
      color: #333;
      box-shadow: none;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='gray' class='bi bi-caret-down-fill' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14l-4.796-5.481c-.566-.646-.106-1.659.753-1.659h9.592c.86 0 1.32 1.013.753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px 12px;
    }

    .form-select:focus {
      border-color: #8c8c8c;
      box-shadow: none;
    }
  </style>
</head>

<body>
  <div class="pages-management-container mt-5">
    <h3 class="text-primary mb-3">Room Reservation</h3>
    <div class="header-container mb-3">
      <div class="add-btn">
        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#reservationModal">+ Add Reservation</button>
      </div>
      <div class="d-flex gap-2 mb-3">
        <select class="form-select">
          <option>Room Type</option>
        </select>
        <select class="form-select">
          <option>Floor</option>
        </select>
        <select class="form-select">
          <option>Room Availability Status</option>
        </select>
        <select class="form-select">
          <option>Capacity</option>
        </select>
      </div>

    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex mb-3 justify-content-between align-items-center">
          <div>
            <button class="icon-btn me-2" title="Print">
              <i class="fa fa-print"></i>
            </button>
            <button class="icon-btn" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          </div>
          <div style="width: 250px;">
            <input type="text" class="form-control" placeholder="Search Room">
          </div>
        </div>


        <table class="table table-striped">
          <thead>
            <tr>
              <th><input type="checkbox"></th>
              <th>Room Name</th>
              <th>Reserved By</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "
                    SELECT r.ReservationID, rm.RoomNumber AS RoomName, u.Name AS ReservedBy, r.StartTime, r.EndTime, r.Status
                    FROM Reservations r
                    JOIN Rooms rm ON r.RoomID = rm.RoomID
                    JOIN Users u ON r.UserID = u.UserID
                    ORDER BY r.StartTime DESC
                ";
            $result = $conn->query($query);


            if ($result->num_rows > 0):
              while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                  <td><input type="checkbox" value="<?= $row['ReservationID'] ?>"></td>
                  <td><?= $row['RoomName'] ?></td>
                  <td><?= $row['ReservedBy'] ?></td>
                  <td><?= date("M d, Y h:i A", strtotime($row['StartTime'])) ?></td>
                  <td><?= date("M d, Y h:i A", strtotime($row['EndTime'])) ?></td>
                  <td><?= $row['Status'] ?></td>
                  <td>
                    <button
                      class="btn btn-sm btn-warning edit-btn"
                      data-id="<?= $row['ReservationID'] ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#editReservationModal">
                      <i class="fa fa-pencil-alt"></i>
                    </button>

                    <form method="post" action="delete_reservation.php" style="display:inline;">
                      <input type="hidden" name="delete_id" value="<?= $row['ReservationID'] ?>">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this reservation?')">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>

                </tr>
              <?php
              endwhile;
            else:
              ?>
              <tr>
                <td colspan="7" class="text-center">No reservations found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Add Reservation</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="add_reservation.php">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="roomName" class="form-label">Room Name</label>
              <select class="form-select" id="roomName" name="room_id" required>
                <option disabled selected>Select Room</option>
                <?php
                $rooms = $conn->query("SELECT RoomID, RoomNumber, RoomCapacity, RoomStatus, BuildingID FROM Rooms WHERE RoomStatus = 'Available' ORDER BY RoomNumber ASC");
                while ($room = $rooms->fetch_assoc()) {
                  $roomData = htmlspecialchars(json_encode([
                    'capacity' => $room['RoomCapacity'],
                    'status' => $room['RoomStatus'],
                    'floor' => $room['BuildingID']
                  ]), ENT_QUOTES, 'UTF-8');
                  echo "<option value='{$room['RoomID']}' data-info='{$roomData}'>{$room['RoomNumber']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="department" class="form-label">Department</label>
              <select class="form-select" id="department" name="department" required>
                <option disabled selected>Select Department</option>
                <option value="Engineering">Engineering</option>
                <option value="Education">Education</option>
                <option value="Business">Business</option>
                <option value="IT">IT</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="roomType" class="form-label">Room Type</label>
              <select class="form-select" id="roomType" name="room_type" required>
                <option disabled selected>Select Type</option>
                <option value="Lecture">Lecture Room</option>
                <option value="Lab">Laboratory</option>
                <option value="Conference">Conference Room</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="floor" class="form-label">Floor</label>
              <select class="form-select" id="floor" name="floor" required>
                <option disabled selected>Select Floor</option>
                <option value="1">1st Floor</option>
                <option value="2">2nd Floor</option>
                <option value="3">3rd Floor</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status" required>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
                <option value="Under Maintenance">Under Maintenance</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="capacity" class="form-label">Capacity</label>
              <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="col-md-6">
              <label for="end_time" class="form-label">End Time</label>
              <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Reservation</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Reservation Modal -->
<div class="modal fade" id="editReservationModal" tabindex="-1" aria-labelledby="editReservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="post" action="./reservation/update_reservation.php">


        <div class="modal-header">
          <h5 class="modal-title" id="editReservationModalLabel">Edit Reservation</h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_reservation_id" name="reservation_id">

          <div class="mb-3">
            <label for="edit_room_name" class="form-label">Room Name</label>
            <input type="text" class="form-control" id="edit_room_name" name="room_name" readonly>
          </div>

          <div class="mb-3">
            <label for="edit_reserved_by" class="form-label">Reserved By</label>
            <input type="text" class="form-control" id="edit_reserved_by" name="reserved_by" readonly>
          </div>

          <div class="mb-3">
            <label for="edit_start_time" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="edit_start_time" name="start_time" required>
          </div>

          <div class="mb-3">
            <label for="edit_end_time" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="edit_end_time" name="end_time" required>
          </div>

          <div class="mb-3">
            <label for="edit_status" class="form-label">Status</label>
            <select class="form-select" id="edit_status" name="status" required>
              <option value="Approved">Approved</option>
              <option value="Pending">Pending</option>
              <option value="Declined">Declined</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Reservation</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.getElementById('roomName').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const roomInfo = JSON.parse(selectedOption.getAttribute('data-info'));

    if (roomInfo) {
      document.getElementById('capacity').value = roomInfo.capacity || '';
      document.getElementById('status').value = roomInfo.status || '';
      document.getElementById('floor').value = roomInfo.floor || '';
    }
  });
</script>
<script>
  $(document).ready(function () {
    $('.edit-btn').on('click', function () {
      const row = $(this).closest('tr');
      const id = $(this).data('id');
      const roomName = row.find('td').eq(1).text().trim();
      const reservedBy = row.find('td').eq(2).text().trim();
      const startTime = row.find('td').eq(3).text().trim();
      const endTime = row.find('td').eq(4).text().trim();
      const status = row.find('td').eq(5).text().trim();

      // Set values into modal
      $('#edit_reservation_id').val(id);
      $('#edit_room_name').val(roomName);
      $('#edit_reserved_by').val(reservedBy);
      $('#edit_start_time').val(formatDateTime(startTime));
      $('#edit_end_time').val(formatDateTime(endTime));
      $('#edit_status').val(status);
    });

    // Helper to convert "May 05, 2025 08:00 AM" → "2025-05-05T08:00"
    function formatDateTime(dateString) {
      const date = new Date(dateString);
      if (isNaN(date)) return '';
      return date.toISOString().slice(0, 16);
    }
  });
</script>

</body>

</html>