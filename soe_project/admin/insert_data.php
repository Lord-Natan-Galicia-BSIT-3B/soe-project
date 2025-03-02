<?php
include "db_connect.php"; // Include database connection
session_start(); // Start session to store messages

if(isset($_POST['add_user'])){
    $user_role = trim($_POST['user_role']);
    $f_name = trim($_POST['full_name']);
    $user_email = trim($_POST['email']);
    $user_pass = trim($_POST['password']);

    // Validate input fields
    if(empty($f_name) || empty($user_email) || empty($user_pass)){
        $_SESSION['error'] = "All fields are required.";
        header("Location: .pages/user-management.php");
        exit();
    }

    // Check if email already exists
    $check_email_query = "SELECT username FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("Location: pages/user-management.php");
        exit();
    }

    mysqli_stmt_close($stmt);

    // Hash the password securely
    $hashedPassword = password_hash($user_pass, PASSWORD_BCRYPT);

    // Insert user into the database
    $insert_query = "INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $f_name, $user_email, $hashedPassword, $user_role);
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['success'] = "User added successfully!";

            // Reset IDs to be sequential
            $conn->query("SET @count = 0;");
            $conn->query("UPDATE users SET user_id = @count := @count + 1 ORDER BY user_id;");

            // Get the highest user_id
            $max_id_query = "SELECT MAX(user_id) AS max_id FROM users";
            $max_id_result = mysqli_query($conn, $max_id_query);
            $max_id_row = mysqli_fetch_assoc($max_id_result);
            $next_id = $max_id_row['max_id'] + 1;

            // Set AUTO_INCREMENT correctly
            $conn->query("ALTER TABLE users AUTO_INCREMENT = $next_id");
        } else {
            $_SESSION['error'] = "Error adding user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Database error: " . mysqli_error($conn);
    }

    header("Location: index.php?page=User");
    exit();
}
?>
