document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const dmToggle = document.getElementById('darkmode-toggle');
  const dmDesc   = document.getElementById('dark-desc');

  // Initialize from localStorage
  const darkPref = localStorage.getItem('darkMode');
  if (darkPref === 'enabled') {
    body.classList.add('dark');
    dmToggle.classList.add('active');
    dmDesc.textContent = 'Enabled';
  }

  dmToggle.addEventListener('click', () => {
    body.classList.toggle('dark');
    const enabled = body.classList.contains('dark');
    dmToggle.classList.toggle('active', enabled);
    dmDesc.textContent = enabled ? 'Enabled' : 'Disabled';
    localStorage.setItem('darkMode', enabled ? 'enabled' : 'disabled');
  });

  // (Optional) Notification toggle demo:
  const notifToggle = document.getElementById('notif-toggle');
  const notifDesc   = document.getElementById('notif-desc');
  let notifOn = true;
  notifToggle.addEventListener('click', () => {
    notifOn = !notifOn;
    notifToggle.classList.toggle('active', notifOn);
    notifDesc.textContent = notifOn ? 'Enabled' : 'Disabled';
  });
});
