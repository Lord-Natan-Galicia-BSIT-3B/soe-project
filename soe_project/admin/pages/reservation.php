<?php 

require_once(__DIR__ . '../../db_connect.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reserve.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-primary mb-3">Room Reservation</h3>
    <div class="header-container mb-3">
        <div class="add-btn">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservationModal">+ Add Reservation</button>
        </div>
        <div class="filter-container mt-2">
            <select class="form-select">
                <option selected>Room Type</option>
            </select>
            <select class="form-select">
                <option selected>Floor</option>
            </select>
            <select class="form-select">
                <option selected>Room Availability Status</option>
            </select>
            <select class="form-select">
                <option selected>Capacity</option>
            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-3">
                <button class="btn btn-secondary me-2" title="Print"><i class="fa fa-print"></i></button>
                <button class="btn btn-danger me-2" title="Delete"><i class="fa fa-trash"></i></button>
                <input type="text" class="form-control" placeholder="Search Room">
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
                            <button class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="roomName" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="roomName">
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="roomType" class="form-label">Room Type</label>
                            <input type="text" class="form-control" id="roomType">
                        </div>
                        <div class="col-md-6">
                            <label for="floor" class="form-label">Floor</label>
                            <input type="text" class="form-control" id="floor">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select-form form-control" id="status">
                                <option value="Available">Available</option>
                                <option value="Occupied">Occupied</option>
                                <option value="Under Maintenance">Under Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="text" class="form-control" id="capacity">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
