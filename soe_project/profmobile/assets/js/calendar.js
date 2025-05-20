

document.addEventListener('DOMContentLoaded', function () {
  console.log("✅ calendar.js loaded");

  const calendarEl = document.getElementById('calendar');
  if (!calendarEl) {
    console.warn("❌ #calendar element not found.");
    return;
  }

  const urlParams = new URLSearchParams(window.location.search);
  const roomId = urlParams.get('room');

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: "auto",
    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: ''
    },
    dateClick: function (info) {
      if (roomId) {
        window.location.href = `calendar.php?room=${roomId}&date=${info.dateStr}`;
      } else {
        alert("No room ID provided in the URL.");
      }
    }
  });

  calendar.render();
});
