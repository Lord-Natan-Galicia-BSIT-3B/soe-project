document.addEventListener('DOMContentLoaded', function () {
  const eventsTab = document.getElementById('events-tab');
  const roomsTab = document.getElementById('rooms-tab');
  const eventsContent = document.getElementById('events-content');
  const roomsContent = document.getElementById('rooms-content');

  const searchInput = document.getElementById('searchRoom');
  const filterSelect = document.getElementById('statusFilter');
  const roomList = document.getElementById('room-list');
  const rooms = roomList ? roomList.querySelectorAll('.room-item') : [];
  const roomCount = document.getElementById('roomCount');
  const noRoomsMsg = document.getElementById('noRoomsMsg');

  if (eventsTab && roomsTab) {
    eventsTab.addEventListener('click', function (e) {
      e.preventDefault();
      eventsTab.classList.add('active');
      roomsTab.classList.remove('active');
      eventsContent.classList.remove('d-none');
      roomsContent.classList.add('d-none');
    });

    roomsTab.addEventListener('click', function (e) {
      e.preventDefault();
      roomsTab.classList.add('active');
      eventsTab.classList.remove('active');
      roomsContent.classList.remove('d-none');
      eventsContent.classList.add('d-none');
      setTimeout(() => searchInput?.focus(), 300);
    });
  }

  function filterRooms() {
    const searchTerm = searchInput.value.trim().toLowerCase();
    const statusTerm = filterSelect.value.trim().toLowerCase();
    let visibleCount = 0;

    rooms.forEach(room => {
      const roomNum = room.getAttribute('data-room') || '';
      const roomDesc = room.getAttribute('data-desc') || '';
      const status = room.getAttribute('data-status') || '';

      const matchesSearch = !searchTerm || roomNum.includes(searchTerm) || roomDesc.includes(searchTerm);
      const matchesStatus = !statusTerm || status === statusTerm;

      const shouldShow = matchesSearch && matchesStatus;
      room.classList.toggle('d-none', !shouldShow);

      if (shouldShow) visibleCount++;
    });

    roomCount.textContent = `${visibleCount} Result${visibleCount !== 1 ? 's' : ''}`;
    noRoomsMsg.classList.toggle('d-none', visibleCount > 0);
  }

  searchInput?.addEventListener('input', filterRooms);
  filterSelect?.addEventListener('change', filterRooms);
  filterRooms();
});

function openReserveModal(roomId, capacity) {
  document.getElementById('reserveRoomId').value = roomId;
  document.getElementById('reserveRoomCapacity').value = capacity;
  const dateInput = document.querySelector('[name="date"]');
  const today = new Date().toISOString().split('T')[0];
  dateInput.value = today;
  fetchRoomTimes(roomId, today);
  dateInput.onchange = () => {
    fetchRoomTimes(roomId, dateInput.value);
  };
  const modal = new bootstrap.Modal(document.getElementById('reservationModal'));
  modal.show();
}

function fetchRoomTimes(roomId, date) {
  fetch(`fetch_times.php?room_id=${roomId}&date=${date}`)
    .then(res => res.json())
    .then(data => {
      const slotDiv = document.getElementById('timeSlots');
      const occupiedDiv = document.getElementById('todayOccupied');
      const container = document.getElementById('timeStatusContainer');
      slotDiv.innerHTML = '';
      occupiedDiv.innerHTML = '';
      container.style.display = 'block';

      let occupiedTodayList = [];

      data.forEach(slot => {
        const badge = document.createElement('div');
        badge.className = `badge d-inline-block me-1 mb-1 px-2 py-1 ${slot.reserved ? 'bg-danger' : 'bg-success'}`;
        badge.innerHTML = `${slot.start} - ${slot.end}` + (slot.reserved ? ` (${slot.name})` : '');
        slotDiv.appendChild(badge);

        if (slot.reserved && date === new Date().toISOString().split('T')[0]) {
          occupiedTodayList.push(`${slot.start} - ${slot.end} (${slot.name})`);
        }
      });

      occupiedDiv.innerHTML = occupiedTodayList.length
        ? occupiedTodayList.join('<br>')
        : 'No current reservation.';
    });
}


function openReportModal(roomName) {
  document.getElementById('reportRoomName').value = roomName;
  const modal = new bootstrap.Modal(document.getElementById('reportModal'));
  modal.show();
}


