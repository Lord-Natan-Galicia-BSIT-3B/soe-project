<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Topbar Example</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="components/navigation/topbar/top.css">
</head>
<body>
  <nav class="topbar">
    <div class="topbar-left"></div>
    <div class="topbar-right">
      <div class="search-container">
        <input type="text" placeholder="Search...">
        <button type="button">
          <svg width="18" height="18" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="8" cy="8" r="5"></circle>
            <line x1="13" y1="13" x2="17" y2="17"></line>
          </svg>
        </button>
      </div>
      <div class="notification-icon">
        <button type="button">
          <svg width="18" height="18" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 10V6a5 5 0 0 0-10 0v4a2 2 0 0 1-2 2h14a2 2 0 0 1-2-2z"></path>
            <path d="M9 18a2 2 0 0 0 2-2H7a2 2 0 0 0 2 2z"></path>
          </svg>
        </button>
      </div>
      <div class="profile-section">
        <img src="profile.jpg" alt="Profile">
        <span>Juan Moreno</span>
      </div>
    </div>
  </nav>
</body>
</html>
