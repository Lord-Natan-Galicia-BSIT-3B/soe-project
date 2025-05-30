<?php
/**
 * Authentication Helper Functions
 */

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Require user to be logged in
 * Redirects to login page if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

/**
 * Get current user ID
 * @return int|null User ID if logged in, null otherwise
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user data
 * @param mysqli $conn Database connection
 * @return array|null User data if found, null otherwise
 */
function getCurrentUser($conn) {
    if (!isLoggedIn()) {
        return null;
    }

    $user_id = getCurrentUserId();
    $stmt = $conn->prepare("SELECT * FROM Users WHERE UserID = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Check if user has a specific role
 * @param mysqli $conn Database connection
 * @param string $role Role to check
 * @return bool True if user has the role, false otherwise
 */
function hasRole($conn, $role) {
    if (!isLoggedIn()) {
        return false;
    }

    $user = getCurrentUser($conn);
    return $user && isset($user['role']) && $user['role'] === $role;
}

/**
 * Require user to have a specific role
 * Redirects to unauthorized page if user doesn't have the required role
 * @param mysqli $conn Database connection
 * @param string $role Required role
 */
function requireRole($conn, $role) {
    if (!hasRole($conn, $role)) {
        header('HTTP/1.0 403 Forbidden');
        include 'errors/403.php';
        exit();
    }
}

// Check if user is logged in and populate user data
if (isLoggedIn() && !isset($_SESSION['user'])) {
    $user = getCurrentUser($GLOBALS['conn'] ?? null);
    if ($user) {
        $_SESSION['user'] = $user;
    } else {
        // User ID in session but not found in database - log them out
        session_destroy();
        header('Location: login.php');
        exit();
    }
}
?>
