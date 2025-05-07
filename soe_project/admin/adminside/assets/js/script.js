// document.addEventListener("DOMContentLoaded", () => {
//     console.log("Admin panel loaded.");
// });
// var myModal = new bootstrap.Modal(document.getElementById('addUserModal'));
// myModal.show();


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");

            if (!userId) {
                alert("Error: User ID is missing.");
                return;
            }

            if (confirm("Are you sure you want to delete this user?")) {
                fetch("delete_user.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + userId
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Show success/error message
                    location.reload(); // Refresh page to update the table
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});




