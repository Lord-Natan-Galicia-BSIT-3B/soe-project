<?php
session_start();
require_once 'includes/conn.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

?>

<style>
/* Overall layout */
body {
    background: white;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Top Navbar */
.top-navbar {
    background-color: #17275f; /* Dark navy blue */
    color: white;
    height: 56px;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    justify-content: space-between;
    font-size: 0.9rem;
}

/* Left nav section */
.nav-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.nav-left .logo {
    font-weight: bold;
    font-size: 1.3rem;
    color: white;
    font-family: 'Segoe UI Black', sans-serif;
}

.nav-left .logo span {
    color: #ffd500; /* Gold/yellow color for "oo" */
}

.nav-left a {
    color: white;
    text-decoration: none;
    font-weight: 600;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.nav-left a.active, .nav-left a:hover {
    background-color: #3b49b5; /* Highlight purple/blue */
    color: white;
}

/* Right nav section */
.nav-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Search input */
.nav-right .search-box {
    position: relative;
    width: 250px;
}

.nav-right input[type="text"] {
    width: 100%;
    padding: 6px 38px 6px 12px;
    border-radius: 4px;
    border: none;
    font-size: 0.9rem;
}

.nav-right .search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #17275f;
    font-size: 1.1rem;
}

/* Notification bell */
.nav-right .notification {
    position: relative;
    cursor: pointer;
    font-size: 1.3rem;
    color: white;
}

.nav-right .notification .badge {
    position: absolute;
    top: -4px;
    right: -6px;
    background-color: #ffd500;
    color: #17275f;
    font-weight: bold;
    font-size: 0.65rem;
    padding: 0 5px;
    border-radius: 12px;
}

/* User info */
.nav-right .user-info {
    text-align: right;
    font-size: 0.75rem;
    cursor: default;
    color: white;
}

.nav-right .user-info .name {
    font-weight: 600;
}

.nav-right .user-avatar {
    width: 28px;
    height: 28px;
    background-color: #a3a3a3;
    border-radius: 50%;
    margin-left: 10px;
}

/* Main container below navbar */
.main-container {
    display: flex;
    margin: 1.5rem 2rem;
    gap: 2rem;
}

/* Tabs */
.tabs {
    display: flex;
    border-bottom: 2px solid #ddd;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    gap: 2rem;
}

.tabs .tab {
    padding-bottom: 8px;
    cursor: pointer;
    color: #444;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.tabs .tab.active {
    color: #17275f;
    border-color: #17275f;
}

/* Left content */
.left-content {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Event card */
.event-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.1);
    padding: 1rem 1.5rem;
    font-size: 0.85rem;
    color: #444;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 120px;
    flex: .59
}

.event-card h3 {
    margin: 0 0 0.5rem 0;
    font-weight: 700;
    font-size: 1.05rem;
}

.event-card p {
    margin: 0 0 0.8rem 0;
    line-height: 1.3;
    color: #666;
}

.event-card .footer {
    font-weight: 600;
    font-size: 0.75rem;
    color: #17275f;
    display: flex;
    justify-content: space-between;
}

/* Right content */
.right-content {
    flex: .4;
    border: 1px solid #d3dafe;
    border-radius: 8px;
    height: 300px;
    display: flex;
    flex-direction: column;
}

/* Right content header */
.right-header {
    background-color: #17275f;
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.2rem;
    border-radius: 8px 8px 0 0;
    font-size: 0.85rem;
    cursor: pointer;
    user-select: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Plus icon for right header */
.right-header .plus-icon {
    font-weight: 700;
    font-size: 1.2rem;
    user-select: none;
}

/* Right content body */
.right-body {
    flex-grow: 1;
    background: white;
    padding: 1rem 1.2rem;
    color: #999;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-style: italic;
    user-select: none;
}

/* Responsive */
@media (max-width: 992px) {
    .main-container {
        flex-direction: column;
        margin: 1rem;
    }
    .left-content, .right-content {
        flex: unset;
        width: 100%;
    }
    .right-content {
        height: 200px;
        margin-top: 1rem;
    }
    .nav-right .search-box {
        width: 160px;
    }
}
</style>

<!-- Top Navbar -->
<div class="top-navbar">
    <div class="nav-left">
        <div class="logo">R<span>oo</span>mFinder</div>
        <a href="#" class="active">Home</a>
        <a href="#">Room Reservation</a>
    </div>
    <div class="nav-right">
        <div class="search-box">
            <input type="text" placeholder="Search Room">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="notification">
            <i class="fas fa-bell"></i>
            <span class="badge">3</span>
        </div>
        <div class="user-info">
            <div class="name"><?php echo htmlspecialchars($_SESSION['name'] ?? 'John Doe'); ?></div>
            <div class="role">BSIT-3B</div>
        </div>
        <div class="user-avatar"></div>
    </div>
</div>

<!-- Tabs -->
<div class="main-container">
    <div class="left-content">
        <div class="tabs">
            <div class="tab active">Events</div>
            <div class="tab">Rooms</div>
        </div>
<div class="event-container" style="display:flex; justify-content:space-between; ">
   <!-- Event Cards -->
   <?php
$sql = "SELECT events.*, rooms.RoomNumber AS room_name FROM events LEFT JOIN rooms ON events.room_id = rooms.RoomID ORDER BY event_date DESC";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo '<div class="event-card"><p>No events found.</p></div>';
} else {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="event-card">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<div class="footer">';
        echo '<span>' . date('D, M d Y \a\t h:i A', strtotime($row['event_date'])) . '</span>';
        echo '<span>' . htmlspecialchars($row['room_name'] ?? $row['location']) . '</span>';
        echo '</div></div>';
    }
}
?>

    <!-- Right Sidebar -->
    <div class="right-content">
        <div class="right-header">
            Request A Room
            <span class="plus-icon" style="cursor:pointer;" onclick="window.location.href='room.php'">+</span>
        </div>
        <div class="right-body">
            No Request
        </div>
    </div>

</div>
    
</div>

<?php require_once 'includes/footer.php'; ?>
