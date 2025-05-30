<?php
include "../db_connect.php";

if (isset($_POST['update_user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);

    // Only set course/yearlevel/section for students, otherwise set to NULL
    if ($user_role === 'Student') {
        $course = mysqli_real_escape_string($conn, $_POST['course']);
        $yearlevel = mysqli_real_escape_string($conn, $_POST['yearlevel']);
        $section = mysqli_real_escape_string($conn, $_POST['section']);
    } else {
        $course = null;
        $yearlevel = null;
        $section = null;
    }

    if (empty($full_name) || empty($user_role) || empty($email)) {
        die("All fields are required.");
    }

    $sql = "UPDATE users SET Name=?, Email=?, Role=?, Course=?, YearLevel=?, Section=?, ContactInfo=? WHERE UserID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $full_name,
        $email,
        $user_role,
        $course,
        $yearlevel,
        $section,
        $contact_info,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../index.php?page=User");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>