<?php
session_start();
$pageTitle = 'Rooms';
require_once 'includes/header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Available Rooms</h1>
        <div class="d-flex align-items-center">
            <div class="input-group me-3" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Search rooms...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#newReservationModal">
                    <i class="fas fa-plus me-1"></i> New Reservation
                </button>
            </div>
        </div>
    </div>

    <!-- Room Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Room Card 1 -->
        <div class="col">
            <div class="card h-100">
                <img src="https://via.placeholder.com/300x200?text=Room+101" class="card-img-top" alt="Room 101">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">Room 101</h5>
                        <span class="badge bg-success">Available</span>
                    </div>
                    <p class="card-text text-muted"><i class="fas fa-users me-2"></i>Capacity: 30</p>
                    <p class="card-text">Main Building, 1st Floor</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserveModal">
                            <i class="far fa-calendar-plus me-1"></i> Reserve Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Room Card 2 -->
        <div class="col">
            <div class="card h-100">
                <img src="https://via.placeholder.com/300x200?text=Room+102" class="card-img-top" alt="Room 102">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">Room 102</h5>
                        <span class="badge bg-danger">Occupied</span>
                    </div>
                    <p class="card-text text-muted"><i class="fas fa-users me-2"></i>Capacity: 25</p>
                    <p class="card-text">Main Building, 1st Floor</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary" disabled>
                            <i class="far fa-calendar-plus me-1"></i> Not Available
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add more room cards as needed -->
    </div>
</main>

<!-- Reserve Modal -->
<div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reserveModalLabel">Reserve Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="roomNumber" class="form-label">Room Number</label>
                        <input type="text" class="form-control" id="roomNumber" value="101" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reservationDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="reservationDate" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="startTime" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="startTime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endTime" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="endTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <textarea class="form-control" id="purpose" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit Reservation</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
