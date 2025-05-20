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
$pageTitle = 'Account Settings';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $pageTitle ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/accountsettings.css?v=<?= time() ?>" />
</head>
<body>

<?php include('../includes/nav.php'); ?>

<div class="container mt-4 mb-5">
  <div class="account-card">
    <h5 class="mb-4">Account Info</h5>

    <label class="form-label">First Name:</label>
    <div class="form-control bg-light mb-3"><?= htmlspecialchars($first_name) ?></div>

    <label class="form-label">Preferred First Name:</label>
    <div class="form-control bg-light mb-3">-</div>

    <label class="form-label">Last Name:</label>
    <div class="form-control bg-light mb-3"><?= htmlspecialchars($last_name) ?></div>

    <label class="form-label">Username: <span class="text-danger">**</span></label>
    <div class="form-control bg-light mb-3"><?= htmlspecialchars($email) ?></div>

    <label class="form-label">Primary Email: <span class="text-danger">**</span></label>
    <div class="form-control bg-light mb-3"><?= htmlspecialchars($email) ?></div>

    <label class="form-label">Alternate Email:</label>
    <div class="form-control bg-light mb-3"><?= htmlspecialchars($contactinfo ?: '-') ?></div>

    <label class="form-label">Timezone:</label>
    <select class="form-select mb-3" disabled>
      <option selected>Asia/Manila - <?= date('g:i A') ?> (GMT+8)</option>
    </select>

    <div class="form-text mb-3">
      By clicking <strong>Save Changes</strong>, you agree to our 
      <a href="#" class="link-primary">Privacy Policy</a> and 
      <a href="#" class="link-primary">Terms of Use</a>.
    </div>

    <button class="btn btn-primary w-100" disabled style="opacity: 0.7;">Save Changes</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
