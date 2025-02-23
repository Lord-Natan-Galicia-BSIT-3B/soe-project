<?php
session_start();
require_once '../dbconnection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($DBConnect, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo '<!DOCTYPE html>
<html>
<head>
  <title>Loading</title>
  <link rel="stylesheet" href="login.css">
  <meta charset="UTF-8">
</head>
<body>
  <div class="loading-overlay" id="loadingOverlay" style="display:flex;">
    <div class="spinner"></div>
    <p>Please wait...</p>
  </div>
  <script>
    setTimeout(function(){
      window.location.href = "../../index.php";
    }, 3000);
  </script>
</body>
</html>';
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
  <meta charset="UTF-8">
</head>

  <div class="login-container">
    <div class="login-left-panel">
      <div class="left-content">
        <img src="../../Images/dyci-logo.png" alt="DYCI Logo">
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


  <script>
    function showLoading() {
      document.getElementById('loadingOverlay').style.display = 'flex';
      document.getElementById('loginForm').style.display = 'none';
    }
  </script>
