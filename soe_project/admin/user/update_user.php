<?php
include "../db_connect.php";

if(isset($_POST['update_user'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']); // This is the primary key (unchanged)
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);

    if(empty($full_name) || empty($user_role) || empty($email)) {
        die("All fields are required.");
    }

    // **Update user info WITHOUT changing user_id**
    $sql = "UPDATE users 
            SET Name='$full_name', 
                Email='$email',
                Role='$user_role', 
                ContactInfo='$contact_info'
    

            WHERE UserID='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../index.php?page=User");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>
