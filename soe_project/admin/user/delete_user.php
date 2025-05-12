<?php
include "../db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // First delete dependent records in 'requests'
    $deleteRequests = $conn->prepare("DELETE FROM requests WHERE UserID = ?");
    $deleteRequests->bind_param("i", $id);
    $deleteRequests->execute();

    // Then delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE UserID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $conn->query("SET @count = 0;");
        $conn->query("UPDATE users SET UserID = @count := @count + 1;");
        $conn->query("ALTER TABLE users AUTO_INCREMENT = 1;");
        header("Location: ../index.php?page=User&deleted=1");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
