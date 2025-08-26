<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Tugas Departemen</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #667eea;
            margin-bottom: 30px;
        }
        #chart-container {
            width: 100%;
            height: 400px;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-btn">← Kembali ke Kalender</a>
        <h1>Grafik Tugas Departemen Bulan Ini</h1>
        <div style="display:flex;justify-content:center;align-items:center;gap:16px;margin-bottom:10px;">
            <button id="prev-month" style="background:#764ba2;color:white;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;font-weight:bold;">←</button>
            <div id="bulan-info" style="text-align:center;font-size:1.2rem;color:#764ba2;"></div>
            <button id="next-month" style="background:#764ba2;color:white;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;font-weight:bold;">→</button>
        </div>
        <div id="chart-container">
            <canvas id="dptChart"></canvas>
        </div>
    </div>
    <script>
        function getNamaBulan(bulan) {
            const arr = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            return arr[bulan-1] || '-';
        }

        function getQueryMonthYear() {
            const params = new URLSearchParams(window.location.search);
            let month = parseInt(params.get('month'), 10);
            let year = parseInt(params.get('year'), 10);
            const now = new Date();
            if (!month || isNaN(month) || month < 1 || month > 12) month = now.getMonth() + 1;
            if (!year || isNaN(year)) year = now.getFullYear();
            return { month, year };
        }

        function setQueryMonthYear(month, year) {
            const params = new URLSearchParams(window.location.search);
            params.set('month', month);
            params.set('year', year);
            window.location.search = params.toString();
        }

        async function fetchData(month, year) {
            const response = await fetch('/api/tasks');
            const tasks = await response.json();
            document.getElementById('bulan-info').textContent = `${getNamaBulan(month)} ${year}`;
            const filtered = tasks.filter(task => {
                if (!task.date) return false;
                const d = new Date(task.date);
                return d.getMonth() + 1 === month && d.getFullYear() === year;
            });
            // Hitung jumlah tugas per departemen
            const dptCount = {};
            filtered.forEach(task => {
                const dpt = task.departemen || '-';
                dptCount[dpt] = (dptCount[dpt] || 0) + 1;
            });
            return dptCount;
        }

        let chartInstance = null;
        async function renderChart() {
            const { month, year } = getQueryMonthYear();
            const dptCount = await fetchData(month, year);
            const labels = Object.keys(dptCount);
            const data = Object.values(dptCount);
            const ctx = document.getElementById('dptChart').getContext('2d');
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Tugas',
                        data: data,
                        backgroundColor: 'rgba(102, 126, 234, 0.7)',
                        borderColor: '#667eea',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'Departemen dengan Tugas Terbanyak Bulan Ini'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        document.getElementById('prev-month').addEventListener('click', function() {
            const { month, year } = getQueryMonthYear();
            let newMonth = month - 1;
            let newYear = year;
            if (newMonth < 1) {
                newMonth = 12;
                newYear--;
            }
            setQueryMonthYear(newMonth, newYear);
        });
        document.getElementById('next-month').addEventListener('click', function() {
            const { month, year } = getQueryMonthYear();
            let newMonth = month + 1;
            let newYear = year;
            if (newMonth > 12) {
                newMonth = 1;
                newYear++;
            }
            setQueryMonthYear(newMonth, newYear);
        });

        renderChart();
    </script>
</body>
</html>
