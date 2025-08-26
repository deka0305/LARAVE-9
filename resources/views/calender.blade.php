<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Tugas Tim</title>
    <style>
        .calendar-day {
            position: relative;
        }

        .calendar-day.has-task::after {
            content: '';
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background-color: #ff4757;
            /* Merah */
            border-radius: 50%;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
            }
        }

        .calendar-section,
        .tasks-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .month-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
        }

        .current-month {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .calendar-day-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .calendar-day:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: scale(1.05);
            border-color: #667eea;
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
            transform: scale(1.05);
        }

        .calendar-day.today {
            background: #ffc107;
            color: #333;
            border-color: #ffc107;
            font-weight: bold;
        }

        .calendar-day.other-month {
            color: #ccc;
            background: #f0f0f0;
        }

        .calendar-day.other-month:hover {
            background: #e0e0e0;
            color: #999;
        }

        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .task-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .task-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .task-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .task-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
            font-size: 0.95rem;
        }

        .task-detail strong {
            color: #333;
        }

        /* Keterangan agar proporsional */
        .task-detail.keterangan {
            word-break: break-word;
            max-width: 600px;
            max-height: 600px;
            overflow-y: auto;
            white-space: pre-line;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .task-detail.keterangan::-webkit-scrollbar {
            width: 100px;
        }

        .tasks-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            min-height: 500px;
            /* Minimal tinggi */
        }

        #tasks-list {
            flex: 1;
            max-height: 600px;
            /* Atur tinggi maksimal */
            overflow-y: auto;
            /* Scroll vertikal jika melebihi */
            padding-right: 8px;
            /* Sedikit ruang untuk scrollbar */
            scrollbar-width: thin;
            scrollbar-color: #667eea #f1f1f1;
        }

        #tasks-list::-webkit-scrollbar {
            width: 6px;
        }

        #tasks-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #tasks-list::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        #tasks-list::-webkit-scrollbar-thumb:hover {
            background: #5a67d8;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status.selesai {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .status.pending {
            background: linear-gradient(135deg, #FFC107, #FFB300);
            color: #333;
        }

        .status.proses {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .no-tasks {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }

        .selected-date {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .content {
                gap: 20px;
            }

            .calendar-section,
            .tasks-section {
                padding: 20px;
            }

            .task-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📅 Monitoring Tugas Tim</h1>
            <p>Sistem monitoring tugas berbasis kalender untuk manajemen tim</p>
        </div>

        <div class="content">
            <div class="calendar-section">
                <h2 class="section-title">Kalender Tugas
                    <a id="grafik-link" href="/grafik" title="Lihat Grafik Tugas" style="margin-left:12px;vertical-align:middle;display:inline-block;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;">
                            <rect x="3" y="13" width="3" height="8" rx="1.5" fill="#667eea"/>
                            <rect x="8" y="9" width="3" height="12" rx="1.5" fill="#764ba2"/>
                            <rect x="13" y="5" width="3" height="16" rx="1.5" fill="#4CAF50"/>
                            <rect x="18" y="2" width="3" height="19" rx="1.5" fill="#FFC107"/>
                        </svg>
                    </a>
                </h2>
                <div class="calendar-header">
                    <div class="month-nav">
                        <button class="nav-btn" id="prev-month">←</button>
                        <div class="current-month" id="current-month">April 2024</div>
                        <button class="nav-btn" id="next-month">→</button>
                    </div>
                </div>
                <div class="calendar-grid" id="calendar-grid">
                    <!-- Calendar will be generated by JavaScript -->
                </div>
            </div>

            <div class="tasks-section">
                <h2 class="section-title">Daftar Tugas</h2>
                <div class="selected-date" id="selected-date">Tanggal: 15 April 2024</div>
                <div class="tasks-list" id="tasks-list">
                    <!-- Tasks will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // ✅ Data diambil via AJAX, bukan dari Blade
        let tasks = [];

        // Ambil data dari API
        async function loadTasks() {
            try {
                const response = await fetch('/api/tasks');
                tasks = await response.json();
                console.log('Tasks dari API:', tasks);
                renderTasks(); // Render langsung setelah load
            } catch (error) {
                console.error('Gagal ambil data tugas:', error);
                document.getElementById('tasks-list').innerHTML =
                    '<div class="no-tasks">Gagal memuat data tugas.</div>';
            }
        }

    // State
    let currentDate = new Date();
    let selectedDate = new Date();

        // DOM Elements
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthElement = document.getElementById('current-month');
        const selectedDateElement = document.getElementById('selected-date');
        const tasksList = document.getElementById('tasks-list');
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');

        // Event Listeners
        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // Render Calendar
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            currentMonthElement.textContent = currentDate.toLocaleDateString('id-ID', {
                month: 'long',
                year: 'numeric'
            });

            // Update grafik link agar sesuai bulan yang dipilih
            const grafikLink = document.getElementById('grafik-link');
            const monthParam = currentDate.getMonth() + 1;
            const yearParam = currentDate.getFullYear();
            grafikLink.href = `/grafik?month=${monthParam}&year=${yearParam}`;

            calendarGrid.innerHTML = '';

            const dayHeaders = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            dayHeaders.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'calendar-day-header';
                dayHeader.textContent = day;
                calendarGrid.appendChild(dayHeader);
            });

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const firstDayOfWeek = firstDay.getDay();

            for (let i = 0; i < firstDayOfWeek; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                emptyDay.textContent = new Date(year, month, -firstDayOfWeek + i + 1).getDate();
                calendarGrid.appendChild(emptyDay);
            }

            // Add days of month
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.style.position = 'relative';
                dayElement.textContent = day;

                // Fix: tanggal JS UTC offset, agar tidak bergeser
                const date = new Date(year, month, day);
                // Set jam ke 00:00:00 lokal agar tidak offset
                date.setHours(0, 0, 0, 0);
                // Format YYYY-MM-DD manual agar tidak offset
                const dateString = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;

                // Cek apakah ada tugas di tanggal ini
                const hasTask = tasks.some(task => task.date === dateString);
                if (hasTask) {
                    dayElement.classList.add('has-task');
                }

                // Check if today
                const todayString = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;
                if (dateString === todayString) {
                    dayElement.classList.add('today');
                }

                // Check if selected
                const selectedString = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth()+1).padStart(2,'0')}-${String(selectedDate.getDate()).padStart(2,'0')}`;
                if (dateString === selectedString) {
                    dayElement.classList.add('selected');
                }

                // Add click event
                dayElement.addEventListener('click', () => {
                    selectedDate = new Date(year, month, day);
                    selectedDate.setHours(0,0,0,0);
                    renderCalendar();
                    renderTasks();
                });

                calendarGrid.appendChild(dayElement);
            }

            const totalCells = 42;
            const remainingCells = totalCells - (firstDayOfWeek + daysInMonth);
            for (let i = 1; i <= remainingCells; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                emptyDay.textContent = i;
                calendarGrid.appendChild(emptyDay);
            }
        }

        // Render Tasks
        function renderTasks() {
            selectedDateElement.textContent = `Tanggal: ${selectedDate.toLocaleDateString('id-ID')}`;

            // Format tanggal manual agar tidak offset
            const selectedString = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth()+1).padStart(2,'0')}-${String(selectedDate.getDate()).padStart(2,'0')}`;
            const filteredTasks = tasks.filter(task => task.date === selectedString);

            tasksList.innerHTML = '';

            if (filteredTasks.length === 0) {
                const noTasks = document.createElement('div');
                noTasks.className = 'no-tasks';
                noTasks.textContent = 'Tidak ada tugas untuk tanggal ini.';
                tasksList.appendChild(noTasks);
                return;
            }

            filteredTasks.forEach(task => {
                const taskCard = document.createElement('div');
                taskCard.className = 'task-card';
                taskCard.innerHTML = `
                <div class="task-title">${task.title}</div>
                <div class="task-info">
                    <div class="task-detail">
                        <strong>👤 PIC:</strong> ${task.pic}
                    </div>
                    <div class="task-detail">
                        <strong>📊 Status:</strong> 
                        <span class="status ${task.status.toLowerCase()}">${task.status}</span>
                    </div>
                    <div class="task-detail">
                        <strong>📅 Tanggal:</strong> ${new Date(task.date).toLocaleDateString('id-ID')}
                    </div>
                    <div class="task-detail">
                        <strong>📝 DPT:</strong> ${task.departemen}
                    </div>

                    <div class="task-detail">
                        <strong>Keterangan:</strong>
                    </div>
                    <div class="task-detail keterangan">
                        <strong></strong> ${task.keterangan}
                    </div>
                </div>
            `;
                tasksList.appendChild(taskCard);
            });
        }

        // Initialize
        renderCalendar();
        loadTasks(); // Ambil data dari API
    </script>
</body>

</html>
