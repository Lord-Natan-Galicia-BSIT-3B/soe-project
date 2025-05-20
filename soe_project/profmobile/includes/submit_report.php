<?php
session_start();
require_once('../connection/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $room = $_POST['room'];
    $problem = $_POST['problem'];

    $photoPath = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $photoPath = $targetPath;
        }
    }

    $stmt = $conn->prepare("INSERT INTO reports (sender_email, receiver_email, room, problem_description, photo_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $from, $to, $room, $problem, $photoPath);

    if ($stmt->execute()) {
        $_SESSION['report_status'] = 'success';
        $_SESSION['report_message'] = 'Report submitted successfully!';
    } else {
        $_SESSION['report_status'] = 'error';
        $_SESSION['report_message'] = 'Failed to submit report.';
    }

    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit;
}
?>
