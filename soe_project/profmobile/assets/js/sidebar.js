
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('menu-toggle');
  const sidebar   = document.querySelector('.sidebar');
  const overlay   = document.querySelector('.overlay');

  function openMenu() {
    sidebar.classList.add('active');
    overlay.classList.add('active');
  }
  function closeMenu() {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
  }

  toggleBtn.addEventListener('click', () =>
    sidebar.classList.contains('active') ? closeMenu() : openMenu()
  );
  overlay.addEventListener('click', closeMenu);
});
