<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
        <nav class="navbar navbar-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                &#9776;
            </button>
            <span class="navbar-brand mb-0">Home</span>
            <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
                &#128203;
            </button>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar">
        <div class="offcanvas-header">
            <div class="profile-section">
                <img src="profile.jpg" alt="Profile Picture" class="profile-img">
                <div>
                    <h5>Munir Abba</h5>
                    <p>Online</p>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li><a href="#">Home</a></li>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Request a Room</a></li>
                <li><a href="#">Report Room</a></li>
                <li><a href="#">Notifications</a></li>
                <hr>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrScannerLabel">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-reader" style="width: 100%;"></div>
                    <p class="mt-3 text-muted">Scan a room QR code to view details.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>