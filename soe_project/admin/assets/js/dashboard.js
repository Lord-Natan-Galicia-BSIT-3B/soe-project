const ctx = document.getElementById('roomsChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, "rgba(47, 128, 237, 0.4)");
gradient.addColorStop(1, "rgba(47, 128, 237, 0)");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5"],
        datasets: [{
            label: "Rooms Managed",
            data: [30, 40, 38, 50, 48],
            borderColor: "#2F80ED",
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: "#2F80ED"
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: "rgba(0, 0, 0, 0.1)"
                }
            }
        }
    }
});