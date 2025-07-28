import Chart from 'chart.js/auto';

function renderCharts(data) {
    // Bookings Trend Chart
    const bookingsTrendCtx = document.getElementById('bookingsTrendChart');
    if (bookingsTrendCtx) {
        new Chart(bookingsTrendCtx, {
            type: 'line',
            data: {
                labels: data.bookingsTrend.map(item => item.month),
                datasets: [{
                    label: 'Bookings',
                    data: data.bookingsTrend.map(item => item.count),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#047857',
                            font: { family: 'Poppins', weight: 'bold' }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    }
                }
            }
        });
    }

    // User Registrations Bar Chart
    const userGrowthCtx = document.getElementById('userGrowthChart');
    if (userGrowthCtx) {
        new Chart(userGrowthCtx, {
            type: 'bar',
            data: {
                labels: data.userGrowth.map(item => item.month),
                datasets: [{
                    label: 'New Users',
                    data: data.userGrowth.map(item => item.count),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#2563EB',
                            font: { family: 'Poppins', weight: 'bold' }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    }
                }
            }
        });
    }

    // Revenue Area Chart
    const revenueTrendCtx = document.getElementById('revenueTrendChart');
    if (revenueTrendCtx) {
        new Chart(revenueTrendCtx, {
            type: 'line',
            data: {
                labels: data.revenueTrend.map(item => item.month),
                datasets: [{
                    label: 'Revenue (₱)',
                    data: data.revenueTrend.map(item => item.revenue),
                    borderColor: 'rgba(251, 191, 36, 1)',
                    backgroundColor: 'rgba(251, 191, 36, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(251, 191, 36, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#CA8A04',
                            font: { family: 'Poppins', weight: 'bold' }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#6B7280', font: { family: 'Poppins' } },
                        grid: { color: '#E5E7EB' }
                    }
                }
            }
        });
    }

    // Service Type Pie Chart
    const serviceTypePieCtx = document.getElementById('serviceTypePieChart');
    if (serviceTypePieCtx) {
        const labels = Object.keys(data.serviceTypeStats);
        const values = Object.values(data.serviceTypeStats);
        new Chart(serviceTypePieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Service Types',
                    data: values,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)', // blue
                        'rgba(16, 185, 129, 0.7)', // emerald
                        'rgba(251, 191, 36, 0.7)', // yellow
                        'rgba(239, 68, 68, 0.7)',  // red
                        'rgba(139, 92, 246, 0.7)', // purple
                        'rgba(79, 70, 229, 0.7)'   // indigo
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(79, 70, 229, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: { family: 'Poppins', weight: 'bold' }
                        }
                    }
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/admin/dashboard/chart-data')
        .then(response => response.json())
        .then(data => {
            renderCharts(data);
        });
}); 