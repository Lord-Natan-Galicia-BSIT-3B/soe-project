<?php
session_start();
require_once '../db_connect.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$error = "";
$login_success = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $login_success = true;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MAP</title>
  <link rel="stylesheet" href="login.css">
  <link rel="shortcut icon" href="../assets/images/dyci-logo.png" type="image/x-icon">
 
</head>
<body>
  <div class="login-container">
    <div class="login-left-panel">
      <div class="left-content">
        <img src="../assets/images/dyci-logo.png" alt="DYCI Logo">
        <h2>Dr. Yanga&apos;s Colleges Inc.</h2>
      </div>
    </div>
    <div class="login-right-panel">
      <div class="login-form-container">
        <?php if (!empty($error)): ?>
          <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST" id="loginForm">
          <label>Username
            <input type="text" name="username" required>
          </label>
          <label>Password
            <input type="password" name="password" required>
          </label>
          <button type="submit" name="login" onclick="showLoading()">Login</button>
        </form>
      </div>
    </div>
  </div>
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <p>Please wait...</p>
  </div>
  <div class="modal-overlay" id="successModal">
    <div class="modal-content">
      <div class="modal-icon">✔</div>
      <h2>LOGIN SUCCESSFUL</h2>
      <p>You have successfully signed into your account.</p>
      
    </div>
  </div>


  <script>
    function showLoading() {
      document.getElementById('loadingOverlay').style.display = 'flex';
      document.getElementById('loginForm').style.display = 'none';
    }
    <?php if ($login_success === true): ?>
      setTimeout(function() {
        document.getElementById('loadingOverlay').style.display = 'none';
        document.getElementById('successModal').style.display = 'flex';
        setTimeout(function() {
          window.location.href = '../index.php';
        }, 3000);
      }, 3000);
    <?php endif; ?>
  
  </script>
</body>
</html>
