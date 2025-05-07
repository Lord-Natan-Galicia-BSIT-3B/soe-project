const logoutLink = document.getElementById('logoutLink');
const logoutModal = document.getElementById('logoutModal');
const confirmLogout = document.getElementById('confirmLogout');
const cancelLogout = document.getElementById('cancelLogout');
const spinnerOverlay = document.getElementById('spinnerOverlay');
logoutLink.addEventListener('click', function(e) {
  e.preventDefault();
  logoutModal.classList.add('show');
});
confirmLogout.addEventListener('click', function() {
  logoutModal.classList.remove('show');
  spinnerOverlay.style.display = 'flex';
  setTimeout(function() {
    window.location.href = "index.php?page=logout";
  }, 1500);
});
cancelLogout.addEventListener('click', function() {
  logoutModal.classList.remove('show');
});
window.addEventListener('click', function(e) {
  if (e.target == logoutModal) {
    logoutModal.classList.remove('show');
  }
});