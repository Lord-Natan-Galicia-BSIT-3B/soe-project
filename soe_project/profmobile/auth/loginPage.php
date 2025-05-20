<?php

  session_start();
require_once('../connection/dbconnect.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT UserID, Password, Role FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        if (strtolower($role) !== 'professor') {
            $error = "Only professors are allowed to log in.";
        } elseif ($password === $hashed_password || password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header('Location: ../public/index.php');
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found for that email.";
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DYCI RoomTrack Login</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
  <div class="login-container">
    <header class="login-header">
      <h1 class="app-title">DYCI RoomTrack</h1>
      <img src="../assets/images/logo.png" alt="Dr. Yanga’s Colleges Logo" class="logo">
    </header>
    <div class="login-content">
      <h2 class="school-name">Dr. Yanga’s Colleges, Inc.</h2>
      <p class="campus-code">QWXH+C5M, Bocaue, Bulacan</p>
      <p class="campus-address">Dr. Yanga’s Colleges, Inc. – Elida Campus, Address</p>
      <form class="login-form" method="post" autocomplete="off">
        <?php if ($error): ?>
          <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="form-group">
          
          <input type="email" id="email" name="email" placeholder="Email Address" required autofocus>
        </div>
        <div class="form-group">
          
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Log In</button>
      </form>
    </div>

    <?php if ($error === "Only professors are allowed to log in."): ?>
<div id="roleModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="custom-modal-icon">✖</div>
    <h2 class="custom-modal-title">Access Denied</h2>
    <p class="custom-modal-message"><?= htmlspecialchars($error) ?></p>
    <button onclick="closeModal()" class="custom-modal-button">OK</button>
  </div>
</div>
<?php endif; ?>


  </div>
  <script>
  function closeModal() {
    document.getElementById('roleModal').style.display = 'none';
  }

  // Auto-close after 4 seconds *only if modal exists*
  window.onload = function () {
    const modal = document.getElementById('roleModal');
    if (modal) {
      setTimeout(() => closeModal(), 4000);
    }
  };
</script>



</body>
</html>
