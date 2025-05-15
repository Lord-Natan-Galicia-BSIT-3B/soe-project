<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>


    <div class="container mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="events-tab" href="#">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rooms-tab" href="#">Rooms</a>
            </li>
        </ul>

        <div id="events-content" class="mt-3">
            <h5 class="fw-bold">Upcoming Events</h5>
            <p>Event details will be loaded here.</p>
        </div>

        <div id="rooms-content" class="mt-3 d-none">
            <div class="input-group my-3">
                <input type="text" class="form-control" placeholder="Search Room">
                <button class="btn btn-outline-secondary">Filters</button>
            </div>
            <h5 class="fw-bold">Room Lists <span class="text-muted small">1040 Results</span></h5>
            <div class="list-group">
                <div class="list-group-item d-flex align-items-center p-3">
                    <div class="placeholder rounded bg-secondary" style="width: 50px; height: 50px;"></div>
                    <div class="ms-3">
                        <h5 class="mb-1">Room Name</h5>
                        <p class="mb-1">Room Capacity <br> Room Type</p>
                        <p class="text-muted mb-0">📍 Location</p>
                    </div>
                    <div class="ms-auto text-end">
                        <p class="text-success mb-1">Available</p>
                        <a href="#" class="btn btn-outline-secondary">📅 Reserve</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>