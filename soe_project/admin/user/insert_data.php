<?php
include "../db_connect.php";
session_start();

if(isset($_POST['add_user'])){
    $user_role = trim($_POST['user_role']);
    $f_name = trim($_POST['full_name']);
    $user_email = trim($_POST['email']);
    $user_pass = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $contact_info = trim($_POST['contact_info']);

    if(empty($f_name) || empty($user_email) || empty($user_pass)){
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../pages/user-management.php");
        exit();
    }

    $check_email_query = "SELECT Email FROM users WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("Location: ../pages/user-management.php");
        exit();
    }

    mysqli_stmt_close($stmt);

    $insert_query = "INSERT INTO users (Name, Email, Password, Role, ContactInfo) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $f_name, $user_email, $user_pass, $user_role, $contact_info);
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['success'] = "User added successfully!";
            $conn->query("SET @count = 0;");
            $conn->query("UPDATE users SET UserID = @count := @count + 1 ORDER BY UserID;");
            $max_id_query = "SELECT MAX(UserID) AS max_id FROM users";
            $max_id_result = mysqli_query($conn, $max_id_query);
            $max_id_row = mysqli_fetch_assoc($max_id_result);
            $next_id = $max_id_row['max_id'] + 1;
            $conn->query("ALTER TABLE users AUTO_INCREMENT = $next_id");
        } else {
            $_SESSION['error'] = "Error adding user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Database error: " . mysqli_error($conn);
    }

    header("Location: ../index.php?page=User");
    exit();
}
?>
