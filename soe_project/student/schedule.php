<?php
session_start();
$pageTitle = 'My Schedule';
require_once 'includes/header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Schedule</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-calendar-alt me-1"></i> This Week
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar-plus me-1"></i> Add Event
            </button>
        </div>
    </div>

    <!-- Schedule View -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 14.28%">Sunday<br>May 26</th>
                            <th style="width: 14.28%">Monday<br>May 27</th>
                            <th style="width: 14.28%">Tuesday<br>May 28</th>
                            <th style="width: 14.28%">Wednesday<br>May 29</th>
                            <th style="width: 14.28%">Thursday<br>May 30</th>
                            <th style="width: 14.28%">Friday<br>May 31</th>
                            <th style="width: 14.28%">Saturday<br>Jun 1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Time Slots -->
                        <tr>
                            <td class="time-slot" data-bs-toggle="modal" data-bs-target="#eventModal">
                                <div class="time">8:00 AM</div>
                                <div class="event">
                                    <span class="badge bg-primary">Room 101</span>
                                    <div>Math Class</div>
                                    <small class="text-muted">8:00 AM - 9:30 AM</small>
                                </div>
                            </td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                        </tr>
                        <tr>
                            <td class="time-slot"></td>
                            <td class="time-slot" data-bs-toggle="modal" data-bs-target="#eventModal">
                                <div class="time">10:00 AM</div>
                                <div class="event">
                                    <span class="badge bg-success">Room 102</span>
                                    <div>Science Lab</div>
                                    <small class="text-muted">10:00 AM - 11:30 AM</small>
                                </div>
                            </td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                            <td class="time-slot"></td>
                        </tr>
                        <!-- Add more time slots as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Classes</h5>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Mathematics 101</h6>
                            <small class="text-muted">Tomorrow, 8:00 AM</small>
                        </div>
                        <p class="mb-1">Room 101 - Prof. Smith</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Computer Science</h6>
                            <small class="text-muted">Tomorrow, 10:00 AM</small>
                        </div>
                        <p class="mb-1">Room 205 - Prof. Johnson</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Reservations</h5>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Study Group</h6>
                            <span class="badge bg-success">Approved</span>
                        </div>
                        <p class="mb-1">Room 103 - May 28, 2:00 PM - 4:00 PM</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Project Meeting</h6>
                            <span class="badge bg-warning">Pending</span>
                        </div>
                        <p class="mb-1">Room 105 - May 29, 3:00 PM - 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> Mathematics 101</p>
                <p><strong>Room:</strong> 101</p>
                <p><strong>Date:</strong> May 27, 2025</p>
                <p><strong>Time:</strong> 8:00 AM - 9:30 AM</p>
                <p><strong>Instructor:</strong> Prof. Smith</p>
                <p><strong>Description:</strong> Introduction to Calculus</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add to Calendar</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
