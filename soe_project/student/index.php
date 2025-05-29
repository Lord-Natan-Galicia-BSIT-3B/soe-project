<?php
session_start();
$pageTitle = 'Dashboard';
require_once 'includes/header.php';
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 mb-0">Welcome back, Student!</h1>
        <div class="d-flex align-items-center">
            <div class="input-group search-container me-3">
                <input type="text" class="form-control" placeholder="Search...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="dropdown me-3">
                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">New notification 1</a></li>
                    <li><a class="dropdown-item" href="#">New notification 2</a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php 
    require_once 'includes/conn.php';
    require_once 'includes/auth.php';

    // Redirect to login if not logged in
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }

    $user = $_SESSION['user'];

    // Get room statistics
    $totalRooms = 0;
    $availableRooms = 0;
    $occupiedRooms = 0;

    $roomQuery = "SELECT 
        COUNT(*) as total_rooms,
        SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available_rooms,
        SUM(CASE WHEN status = 'occupied' THEN 1 ELSE 0 END) as occupied_rooms
        FROM rooms";
    $roomResult = $conn->query($roomQuery);

    if ($roomResult && $roomResult->num_rows > 0) {
        $roomStats = $roomResult->fetch_assoc();
        $totalRooms = $roomStats['total_rooms'];
        $availableRooms = $roomStats['available_rooms'];
        $occupiedRooms = $roomStats['occupied_rooms'];
    }
    ?>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-title">Total Rooms</p>
                            <h2><?php echo $totalRooms; ?></h2>
                        </div>
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-title">Available</p>
                            <h2><?php echo $availableRooms; ?></h2>
                        </div>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-title">Occupied</p>
                            <h2><?php echo $occupiedRooms; ?></h2>
                        </div>
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room List -->
    <div class="card">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h5 class="card-title mb-2 mb-md-0">Room List</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: 150px;">
                    <option>All Buildings</option>
                    <option>Main Building</option>
                    <option>Science Wing</option>
                    <option>Arts Building</option>
                </select>
                <select class="form-select form-select-sm" style="width: 120px;">
                    <option>All Status</option>
                    <option>Available</option>
                    <option>Occupied</option>
                </select>
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add Room
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Building</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>101</td>
                            <td>Main Building</td>
                            <td>30</td>
                            <td><span class="badge bg-success">Available</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>205</td>
                            <td>Science Wing</td>
                            <td>25</td>
                            <td><span class="badge bg-success">Available</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>312</td>
                            <td>Arts Building</td>
                            <td>40</td>
                            <td><span class="badge bg-warning">Limited</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>150</td>
                            <td>Main Building</td>
                            <td>20</td>
                            <td><span class="badge bg-danger">Occupied</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
