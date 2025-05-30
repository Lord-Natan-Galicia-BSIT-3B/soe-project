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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/234775b3ba.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="assets/css/Pages.css">
</head>
<body>

<div class="pages-management-container">
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
                        <th>Contact Info</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Section</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
           
                <?php
    $limit = 5;
    $pagenum = isset($_GET['pagenum']) ? max((int) $_GET['pagenum'], 1) : 1;
    $offset = ($pagenum - 1) * $limit;
    

    // Fetch total records
    $total_query = "SELECT COUNT(*) AS total FROM users";
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Apply pagination with LIMIT and OFFSET
    $query = "SELECT * FROM users ORDER BY UserID DESC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $query);
    

    if ($result->num_rows > 0) {    
        while ($row = $result->fetch_assoc()) {
            $userID = htmlspecialchars($row['UserID']);
            $name = htmlspecialchars($row['Name']);
            $role = htmlspecialchars($row['Role']);
            $email = htmlspecialchars($row['Email']);
            $contact = htmlspecialchars($row['ContactInfo']);
            $course = ($row['Role'] === 'Student') ? htmlspecialchars($row['Course']) : '-';
            $yearlevel = ($row['Role'] === 'Student') ? htmlspecialchars($row['YearLevel']) : '-';
            $section = ($row['Role'] === 'Student') ? htmlspecialchars($row['Section']) : '-';
        
            // Use raw values for data-* attributes (not the dash for non-students)
            $data_course = htmlspecialchars($row['Course']);
            $data_yearlevel = htmlspecialchars($row['YearLevel']);
            $data_section = htmlspecialchars($row['Section']);
        
            echo <<<HTML
        <tr>
            <td>$userID</td>
            <td>$name</td>
            <td>$role</td>
            <td>$email</td>
            <td>$contact</td>
            <td>$course</td>
            <td>$yearlevel</td>
            <td>$section</td>
            <td>
                <button class="btn btn-outline-secondary edit-btn" 
                    data-id="$userID"
                    data-name="$name"
                    data-role="$role"
                    data-email="$email"
                    data-contactinfo="$contact"
                    data-course="$data_course"
                    data-yearlevel="$data_yearlevel"
                    data-section="$data_section"
                    data-bs-toggle="modal" data-bs-target="#editUserModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <form method="post" action="./user/delete_user.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    <input type="hidden" name="id" value="$userID">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </td>
        </tr>
        HTML;
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
    <ul class="pagination justify-content-center">
        <?php if ($pagenum > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=User&pagenum=<?= $pagenum - 1; ?>">Previous</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($pagenum == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=User&pagenum=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($pagenum < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=User&pagenum=<?= $pagenum + 1; ?>">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</div>



    </div>
</div>



<!-- Add User Modal -->
<form action="./user/insert_data.php" method="post">
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
                        <select class="form-select" name="role" id="add_user_role" onchange="toggleStudentFieldsAdd()" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="Student">Student</option>
                            <option value="Professor">Professor</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                        <div id="add_studentFields" style="display:none;">
    <label class="form-label mb-2">Student Details</label>
    <select name="course" id="add_course" class="form-select mb-2" required>
        <option value="" disabled selected>Select Course</option>
        <option value="BSIT">BSIT</option>
        <option value="BSED">BSED</option>
        <option value="BEED">BEED</option>
        <option value="BSBA">BSBA</option>
        <option value="BSA">BSA</option>
        <option value="BSCE">BSCE</option>
    </select>
    <select name="yearlevel" id="add_yearlevel" class="form-select mb-2" required>
        <option value="" disabled selected>Select Year Level</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select>
    <select name="section" id="add_section" class="form-select mb-2" required>
        <option value="" disabled selected>Select Section</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
</div>
                        
                        
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" placeholder="Enter Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="Enter Email"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" 
           title="Please enter a valid email address (e.g., user@example.com)" autocomplete="email">
           <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" name="contact_info" placeholder="Enter phone number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" required>
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
 <form action="./user/update_user.php" method="post">
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="editUserModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Hidden input for user ID -->
                    <input type="hidden" id="edit_UserID" name="id">

                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select class="form-select" name="user_role" id="edit_user_role" onchange="toggleStudentFieldsEdit()" required>
    <option value="Student">Student</option>
    <option value="Professor">Professor</option>
    <option value="Maintenance">Maintenance</option>
</select>
<div id="edit_studentFields" style="display:none;">
    <label class="form-label mb-2">Student Details</label>
    <select name="course" id="edit_course" class="form-select mb-2" required>
        <option value="" disabled>Select Course</option>
        <option value="BSIT">BSIT</option>
        <option value="BSED">BSED</option>
        <option value="BEED">BEED</option>
        <option value="BSBA">BSBA</option>
        <option value="BSA">BSA</option>
        <option value="BSCE">BSCE</option>
    </select>
    <select name="yearlevel" id="edit_yearlevel" class="form-select mb-2" required>
        <option value="" disabled>Select Year Level</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select>
    <select name="section" id="edit_section" class="form-select mb-2" required>
        <option value="" disabled>Select Section</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
</div>

                      
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="edit_full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" name="contact_info" id="edit_contact_info" placeholder="Enter phone number" required>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" accesskey=""class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
    //add
    function toggleStudentFieldsAdd() {
    var role = document.getElementById('add_user_role').value;
    document.getElementById('add_studentFields').style.display = (role === 'Student') ? 'block' : 'none';
}
document.addEventListener("DOMContentLoaded", function() {
    toggleStudentFieldsAdd();
    document.getElementById('add_user_role').addEventListener('change', toggleStudentFieldsAdd);
});

//edit
function toggleStudentFieldsEdit() {
    var role = document.getElementById('edit_user_role').value;
    document.getElementById('edit_studentFields').style.display = (role === 'Student') ? 'block' : 'none';
}
document.addEventListener("DOMContentLoaded", function() {
    toggleStudentFieldsEdit();
    document.getElementById('edit_user_role').addEventListener('change', toggleStudentFieldsEdit);

    document.getElementById("edit_course").value = this.getAttribute("data-course") || '';
document.getElementById("edit_yearlevel").value = this.getAttribute("data-yearlevel") || '';
document.getElementById("edit_section").value = this.getAttribute("data-section") || '';
toggleStudentFieldsEdit(); // Show/hide fields based on role
});

document.getElementById("edit_course").value = this.getAttribute("data-course") || '';
document.getElementById("edit_yearlevel").value = this.getAttribute("data-yearlevel") || '';
document.getElementById("edit_section").value = this.getAttribute("data-section") || '';
</script>
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
            const userContactInfo = this.getAttribute("data-contactinfo");

            // Populate modal fields with user data
            document.getElementById("edit_UserID").value = userId;
            document.getElementById("edit_full_name").value = userName;
            document.getElementById("edit_user_role").value = userRole;
            document.getElementById("edit_email").value = userEmail;
            document.getElementById("edit_contact_info").value = userContactInfo;
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