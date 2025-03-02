<?php
include "db_connect.php";

if(isset($_POST['update_user'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']); // This is the primary key (unchanged)
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if(empty($full_name) || empty($user_role) || empty($email)) {
        die("All fields are required.");
    }

    // **Update user info WITHOUT changing user_id**
    $sql = "UPDATE users 
            SET name='$full_name', 
                role='$user_role', 
                username='$email' 
            WHERE user_id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?page=User");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>
