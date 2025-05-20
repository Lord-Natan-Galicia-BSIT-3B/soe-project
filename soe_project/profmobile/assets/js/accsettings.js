document.addEventListener("DOMContentLoaded", function() {

    document.querySelector('.back-arrow').addEventListener('click', function() {
        window.history.back();
    });

    document.querySelector('.check-status-btn').addEventListener('click', function() {
        alert("Status check feature coming soon!");
    });
});
