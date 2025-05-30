<?php
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$login_success = false;

if (isset($_POST['login'])) {
    $email = $_POST['username']; 
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['Password'])) {
            if ($user['Role'] === 'Student') {
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['username'] = $user['Email'];
                $_SESSION['role'] = $user['Role'];
                $_SESSION['name'] = $user['Name'];
                $login_success = true;
            } else {
                $error = "Access denied. Only Student can log in.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MAP - Student Login</title>
  <link rel="stylesheet" href="assets/css/login.css" />
  <link rel="shortcut icon" href="../assets/images/dyci-logo.png" type="image/x-icon" />
  <style>
    .modal-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      animation: fadeIn 0.3s ease-in-out;
      width: 300px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    .modal-icon {
      font-size: 40px;
      color: red;
      margin-bottom: 10px;
    }

    .modal-message {
      font-size: 16px;
      color: #333;
      font-weight: bold;
    }

    .hide {
      animation: fadeOut 0.5s ease-in-out forwards;
    }

    @keyframes fadeOut {
      from { opacity: 1; transform: scale(1); }
      to { opacity: 0; transform: scale(0.9); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-left-panel">
      <div class="left-content">
        <img src="assets/img/logo.png" alt="DYCI Logo" />
        <h2>Dr. Yanga's Colleges Inc.</h2>
      </div>
    </div>
    <div class="login-right-panel">
      <div class="login-form-container">
        <form action="" method="POST" id="loginForm">
          <label>Email
            <input type="text" name="username" required />
          </label>
          <label>Password
            <input type="password" name="password" required />
          </label>
          <button type="submit" name="login" onclick="showLoading()">Login</button>
        </form>
      </div>
    </div>
  </div>

  <div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="spinner"></div>
    <p>Please wait...</p>
  </div>

  <div class="modal-overlay" id="errorModal">
    <div class="modal-content">
      <div class="modal-icon">⚠</div>
      <p class="modal-message" id="errorMessage"></p>
    </div>
  </div>

  <script>
    function showLoading() {
      document.getElementById('loadingOverlay').style.display = 'flex';
      document.getElementById('loginForm').style.display = 'none';
    }

    <?php if (!empty($error)): ?>
      document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('errorMessage').textContent = "<?php echo $error; ?>";
        document.getElementById('errorModal').style.display = 'flex';

        setTimeout(function() {
          document.getElementById('errorModal').classList.add('hide');
          setTimeout(function() {
            document.getElementById('errorModal').style.display = 'none';
            document.getElementById('errorModal').classList.remove('hide');
          }, 500);
        }, 3000);
      });
    <?php endif; ?>

    <?php if ($login_success === true): ?>
      setTimeout(function() {
        document.getElementById('loadingOverlay').style.display = 'none';
        window.location.href = 'index.php';
      }, 3000);
    <?php endif; ?>
  </script>
</body>
</html>
