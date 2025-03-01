<?php
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']); // Ensure it's an integer to prevent SQL injection

        // Use a prepared statement for security
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Reorder IDs sequentially after deletion
            $conn->query("SET @count = 0;");
            $conn->query("UPDATE users SET user_id = @count := @count + 1;");
            $conn->query("ALTER TABLE users AUTO_INCREMENT = 1;");
            
            echo "User deleted!";
        } else {
            echo "Error deleting user: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: No ID received!";
    }
} else {
    echo "Invalid request!";
}

$conn->close();
?>
