<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/234775b3ba.js" crossorigin="anonymous"></script>
    <style>
        .room-card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        .room-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .status-available {
            color: green;
        }
        .status-occupied {
            color: purple;
        }
        .edit-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#">All Rooms (496)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Available Rooms (293)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reserved Rooms (62)</a>
                </li>
            </ul>
            <div class="d-flex">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Search Room" aria-label="Search Room">
                <button class="btn btn-secondary btn-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
        
        <div class="row">
            <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="col-md-6 mb-4">
                <div class="card room-card">
                    <button class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class='fa-solid fa-pen-to-square'></i>
                    </button>
                    <img src="room-image.jpg" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title">Room 101</h5>
                        <p class="card-text">Capacity: 30 Students</p>
                        <p class="card-text">Room Equipment/Specs:</p>
                        <p><i class="fas fa-map-marker-alt"></i> Location</p>
                        <p class="status-<?php echo ($i % 2 == 0) ? 'available' : 'occupied'; ?>">
                            <?php echo ($i % 2 == 0) ? '● Available' : '● Occupied'; ?>
                        </p>
                        <a href="#" class="btn btn-primary">Room Schedule</a>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>

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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>