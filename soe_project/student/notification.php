<?php
session_start();
$pageTitle = 'Notifications';
require_once 'includes/header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Notifications</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-check-double me-1"></i> Mark all as read
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash-alt me-1"></i> Clear all
            </button>
        </div>
    </div>

    <!-- Notification Tabs -->
    <ul class="nav nav-tabs mb-4" id="notificationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                All Notifications
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread" type="button">
                Unread <span class="badge bg-danger rounded-pill">3</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reservation-tab" data-bs-toggle="tab" data-bs-target="#reservation" type="button">
                Reservations
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button">
                System
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="notificationTabsContent">
        <!-- All Notifications -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            <div class="list-group">
                <!-- Unread Notification -->
                <div class="list-group-item list-group-item-action active-notification">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Reservation Approved</h6>
                        <small class="text-muted">10 min ago</small>
                    </div>
                    <p class="mb-1">Your reservation for Room 101 on May 28 has been approved.</p>
                    <small>Click to view details</small>
                </div>

                <!-- Read Notification -->
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Class Reminder</h6>
                        <small class="text-muted">2 hours ago</small>
                    </div>
                    <p class="mb-1">You have a class in 30 minutes: Mathematics 101 in Room 205</p>
                </div>

                <!-- System Notification -->
                <div class="list-group-item list-group-item-action active-notification">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">System Maintenance</h6>
                        <small class="text-muted">5 hours ago</small>
                    </div>
                    <p class="mb-1">Scheduled maintenance on May 28, 2025 from 2:00 AM to 4:00 AM</p>
                </div>

                <!-- Reservation Reminder -->
                <div class="list-group-item list-group-item-action active-notification">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Reservation Reminder</h6>
                        <small class="text-muted">1 day ago</small>
                    </div>
                    <p class="mb-1">Your reservation for Room 103 is tomorrow at 2:00 PM</p>
                </div>

                <!-- Older Notifications -->
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Room Change</h6>
                        <small class="text-muted">2 days ago</small>
                    </div>
                    <p class="mb-1">Your class on May 26 has been moved to Room 207</p>
                </div>
            </div>
        </div>

        <!-- Other tabs would have similar structure but filtered content -->
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-4">
        <button class="btn btn-outline-primary">
            <i class="fas fa-arrow-down me-1"></i> Load More Notifications
        </button>
    </div>
</main>

<style>
.active-notification {
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
}
</style>

<?php require_once 'includes/footer.php'; ?>
