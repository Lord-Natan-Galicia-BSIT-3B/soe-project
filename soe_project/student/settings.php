<?php
session_start();
$pageTitle = 'Settings';
require_once 'includes/header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Account Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
                <a href="#password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="fas fa-lock me-2"></i> Password
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="fas fa-bell me-2"></i> Notifications
                </a>
                <a href="#privacy" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="fas fa-shield-alt me-2"></i> Privacy
                </a>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Information</h5>
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" value="John">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" value="Doe">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="john.doe@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" value="+1 (555) 123-4567">
                                </div>
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" rows="3" placeholder="Tell us about yourself..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Tab -->
                <div class="tab-pane fade" id="password">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Notification Preferences</h5>
                            <form>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Email Notifications
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                                    <label class="form-check-label" for="pushNotifications">
                                        Push Notifications
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="reservationAlerts" checked>
                                    <label class="form-check-label" for="reservationAlerts">
                                        Reservation Alerts
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="classReminders" checked>
                                    <label class="form-check-label" for="classReminders">
                                        Class Reminders
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Privacy Tab -->
                <div class="tab-pane fade" id="privacy">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Privacy Settings</h5>
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Profile Visibility</label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="profileVisibility" id="publicProfile" checked>
                                        <label class="form-check-label" for="publicProfile">
                                            Public (Anyone can view your profile)
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="profileVisibility" id="privateProfile">
                                        <label class="form-check-label" for="privateProfile">
                                            Private (Only you can view your profile)
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="activityStatus" checked>
                                    <label class="form-check-label" for="activityStatus">
                                        Show my activity status
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="personalizedAds" checked>
                                    <label class="form-check-label" for="personalizedAds">
                                        Allow personalized ads
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Privacy Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
