import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('combinedChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // 1. Fungsi Gradient (Disesuaikan agar lebih halus untuk garis tipis)
    const getGradient = (colorStart, colorEnd) => {
        const chartHeight = canvas.offsetHeight || 400;
        const gradient = ctx.createLinearGradient(0, 0, 0, chartHeight);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(0.4, colorEnd); // Gradien menghilang lebih cepat agar clean
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
        return gradient;
    };

    // 2. Inisialisasi Chart
    const combinedChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Arus Kendaraan',
                    data: [],
                    borderColor: '#10b981',
                    borderWidth: 2, // <--- Diperhalus (sebelumnya 4)
                    fill: true,
                    backgroundColor: getGradient('rgba(16, 185, 129, 0.12)', 'rgba(16, 185, 129, 0)'),
                    tension: 0.4,   // Membuat lekukan lebih natural
                    pointRadius: 0, // Titik disembunyikan agar garis terlihat bersih
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                },
                {
                    label: 'Log Aktivitas',
                    data: [],
                    borderColor: '#f59e0b',
                    borderWidth: 2, // <--- Diperhalus (sebelumnya 4)
                    fill: true,
                    backgroundColor: getGradient('rgba(245, 158, 11, 0.12)', 'rgba(245, 158, 11, 0)'),
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#f59e0b',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                }
            ]
        },
        options: {
            animation: { duration: 1500, easing: 'easeOutQuart' },
            responsive: true,
            maintainAspectRatio: false, // Mengikuti tinggi h-[400px] di Blade
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: (context) => {
                            const val = context.parsed.y;
                            return context.dataset.label === 'Arus Kendaraan'
                                ? ` 🚗 ${val} Unit`
                                : ` ⚡ ${val} Aktivitas`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(241, 245, 249, 0.6)', drawTicks: false },
                    border: { display: false },
                    ticks: { 
                        precision: 0,
                        color: '#94a3b8',
                        font: { size: 11 }
                    }
                },
                x: { 
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10 },
                        maxRotation: 45, // Memiringkan label agar tidak padat
                        minRotation: 45
                    }
                }
            }
        }
    });

    // 3. Update Data dari API
    async function updateChartData() {
        try {
            const response = await fetch('/admin/chart-data');
            const result = await response.json();

            if (result.labels && result.datasets) {
                combinedChart.data.labels = result.labels;

                result.datasets.forEach((remoteDataset) => {
                    const localDataset = combinedChart.data.datasets.find(
                        ds => ds.label === remoteDataset.label
                    );
                    if (localDataset) {
                        localDataset.data = remoteDataset.data;
                    }
                });

                combinedChart.update('none'); 
            }
        } catch (error) {
            console.error("Gagal sinkronisasi data dashboard:", error);
        }
    }

    updateChartData();
    setInterval(updateChartData, 30000);
});