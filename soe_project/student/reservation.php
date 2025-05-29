<?php
session_start();
$pageTitle = 'My Reservations';
require_once 'includes/header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Reservations</h1>
        <div>
            <a href="room.php" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Reservation
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="reservationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">
                Upcoming
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                Pending
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                History
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="reservationTabsContent">
        <!-- Upcoming Tab -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room 101</td>
                                    <td>May 28, 2025</td>
                                    <td>10:00 AM - 12:00 PM</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">View</button>
                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room 201</td>
                                    <td>May 29, 2025</td>
                                    <td>2:00 PM - 4:00 PM</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">View</button>
                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Tab -->
        <div class="tab-pane fade" id="pending" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room 105</td>
                                    <td>May 30, 2025</td>
                                    <td>9:00 AM - 11:00 AM</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">View</button>
                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- History Tab -->
        <div class="tab-pane fade" id="history" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room 103</td>
                                    <td>May 20, 2025</td>
                                    <td>1:00 PM - 3:00 PM</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room 202</td>
                                    <td>May 15, 2025</td>
                                    <td>10:00 AM - 12:00 PM</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
