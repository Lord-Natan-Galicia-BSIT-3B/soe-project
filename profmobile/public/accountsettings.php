<?php
session_start();
require_once('../connection/dbconnect.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/loginPage.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT Name, Email, Role, ContactInfo FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $role, $contactinfo);
$stmt->fetch();
$stmt->close();


$first_name = $name;
$last_name = '';
if (strpos($name, ' ') !== false) {
    $parts = explode(' ', $name, 2);
    $first_name = $parts[0];
    $last_name = $parts[1];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/account-settings.css">
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <span class="back-arrow">&#8592;</span>
            <span class="nav-title">Account Settings</span>
        </div>
        <div class="account-box">
            <h3>Account Info</h3>
            <div class="info-block">
                <label>First Name:</label>
                <div class="info-text"><?= htmlspecialchars($first_name) ?></div>
            </div>
            <div class="info-block">
                <label>Preferred First Name:</label>
                <div class="info-text">-</div>
            </div>
            <hr>
            <div class="info-block">
                <label>Last Name:</label>
                <div class="info-text"><?= htmlspecialchars($last_name) ?></div>
            </div>
            <div class="info-block">
                <label>Username: <span class="asterisk">**</span></label>
                <div class="info-text email-link">
                    <a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a>
                </div>
            </div>
            <div class="info-block">
                <label>Primary Email: <span class="asterisk">**</span></label>
                <div class="info-text"><?= htmlspecialchars($email) ?></div>
            </div>
            <button type="button" class="check-status-btn">Check Status</button>
            <div class="info-block">
                <label>Alternate Email / Contact Info:</label>
                <div class="info-text"><?= htmlspecialchars($contactinfo ?: '-') ?></div>
            </div>
            <div class="info-block">
                <label>Role:</label>
                <div class="info-text"><?= htmlspecialchars($role) ?></div>
            </div>
            <div class="info-block">
                <label>Timezone:</label>
                <div class="info-text">-</div>
            </div>
            <p class="policy-text">
                By clicking <strong>Save Changes</strong>, you are agreeing to our
                <a href="#" class="policy-link">Privacy Policy</a> and
                <a href="#" class="policy-link">Terms of Use</a>
            </p>
            <button type="button" class="save-btn" style="opacity: 0.7; cursor: default;">Save Changes</button>
        </div>
    </div>
    <script src="../assets/js/accsettings.js"></script>
</body>
</html>
