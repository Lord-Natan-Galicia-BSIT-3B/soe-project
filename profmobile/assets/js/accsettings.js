document.addEventListener("DOMContentLoaded", function() {
    // Back arrow
    document.querySelector('.back-arrow').addEventListener('click', function() {
        window.history.back();
    });
    // Check Status
    document.querySelector('.check-status-btn').addEventListener('click', function() {
        alert("Status check feature coming soon!");
    });
});
