<?php
require_once(__DIR__ . '../../db_connect.php');

?>


<?php
session_start();
if(isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Remove message after displaying
}

if(isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']); // Remove message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/234775b3ba.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="assets/css/user_management.css">
</head>
<body>

<div class="user-management-container">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">User Management</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>

        <!-- Table and Pagination -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>User Role</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    $limit = 5;
    $page = isset($_GET['page']) ? max((int) $_GET['page'], 1) : 1; // Ensure page is at least 1
    $offset = max(($page - 1) * $limit, 0); // Prevent negative offset
    

    // Fetch total records
    $total_query = "SELECT COUNT(*) AS total FROM users";
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Apply pagination with LIMIT and OFFSET
    $query = "SELECT * FROM users ORDER BY user_id DESC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $query);
    

    if ($result->num_rows > 0) {    
        while ($row = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>{$row['user_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['role']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>  
                <td>{$row['created_at']}</td>   
                <td>
                    <button class='btn btn-outline-secondary edit-btn' 
                        data-id='{$row['user_id']}' 
                        data-name='{$row['name']}'
                        data-role='{$row['role']}' 
                        data-email='{$row['username']}'  
                        data-bs-toggle='modal' data-bs-target='#editUserModal'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </button>
            
                    <button class='btn btn-danger delete-btn' data-id='{$row['user_id']}'>
                        <i class='fa-solid fa-trash-can'></i>
                    </button>
        
                </td> 
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='text-center'>No users found</td></tr>";
    }
    ?>
                </tbody>
            </table>
        </div>

        <!-- Ensure Pagination is Outside Sidebar -->
        <!-- Pagination (Outside Sidebar) -->
<div class="custom-pagination">
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</div>

    </div>
</div>



<!-- Add User Modal -->
<form action="insert_data.php" method="post">
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select class="form-select" name="user_role" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="Student">Student</option>
                            <option value="Faculty">Faculty</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" 
           title="Please enter a valid email address (e.g., user@example.com)" autocomplete="email">
           <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                        <input type="checkbox" onclick="togglePassword()"> Show Password
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                   
                    <button class="btn btn-primary" name="add_user" value="add" type="submit">ADD</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Update User Modal -->
 <!-- Update User Modal -->
 <form action="update_user.php" method="post">
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="editUserModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Hidden input for user ID -->
                    <input type="hidden" id="edit_user_id" name="id">

                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select class="form-select" name="user_role" id="edit_user_role" required>
                            <option value="Student">Student</option>
                            <option value="Faculty">Faculty</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="edit_full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" name="update_user" value="update" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>



<!-- Bootstrap JS (Required for Modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-btn");

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Get user data from button attributes
            const userId = this.getAttribute("data-id");
            const userName = this.getAttribute("data-name");
            const userRole = this.getAttribute("data-role");
            const userEmail = this.getAttribute("data-email");

            // Populate modal fields with user data
            document.getElementById("edit_user_id").value = userId;
            document.getElementById("edit_full_name").value = userName;
            document.getElementById("edit_user_role").value = userRole;
            document.getElementById("edit_email").value = userEmail;
        });
    });
});
</script>

<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
</body>
</html>