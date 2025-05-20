<?php
require_once("../connection/dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['room_photo'])) {
    $uploadDir = "../uploads/rooms/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $fileName = time() . '_' . basename($_FILES['room_photo']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['room_photo']['tmp_name'], $targetPath)) {
        // Insert filename into the database - you can adjust logic as needed
        // (e.g. associate with a room or just store photo reference)
        $stmt = $conn->prepare("INSERT INTO rooms (RoomImage) VALUES (?)");
        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        $stmt->close();
        header("Location: reservation.php");
        exit;
    } else {
        echo "<script>alert('Photo upload failed!'); history.back();</script>";
    }
}
?>
