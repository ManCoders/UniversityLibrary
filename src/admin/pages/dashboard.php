<!-- Dashboard Overview -->
<div id="mainDashboard">
    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
        Dashboard Overview
    </h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-indigo-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="booksPanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Available Books</p>
            <p id="statBooks" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <p class="text-xs text-green-500 mt-2">↑ 0% this month</p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-emerald-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="usersPanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Users</p>
            <p id="statUsers" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <p class="text-xs text-red-500 mt-2">↓ 0% this month</p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="requestsPanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Requests</p>
            <p id="statRequests" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <p class="text-xs text-yellow-500 mt-2">Last updated just now</p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="tasksPanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Tasks</p>
            <p id="statTasks" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <p class="text-xs text-red-500 mt-2">Action required</p>
        </div>
    </div>

</div>

<!-- Panels -->
<div id="booksPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Books</h2>
    <canvas id="booksChart" class="mt-4"></canvas>
</div>

<div id="usersPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Users</h2>
    <canvas id="usersChart" class="mt-4"></canvas>
</div>

<div id="requestsPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Requests</h2>
    <canvas id="requestsChart" class="mt-4"></canvas>
    
</div>

<div id="tasksPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Tasks</h2>
    <canvas id="tasksChart" class="mt-4"></canvas>
</div>
<!-- Monitoring Panel -->
<!-- <div id="monitorPanel" class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Live User Monitoring</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
            <p class="font-medium text-gray-600 dark:text-gray-300 mb-2">Currently Logged In</p>
            <ul id="loggedInUsers" class="text-sm text-gray-700 dark:text-gray-200 space-y-1">
                <li>No users online</li>
            </ul>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
            <p class="font-medium text-gray-600 dark:text-gray-300 mb-2">Recently Logged Out</p>
            <ul id="loggedOutUsers" class="text-sm text-gray-700 dark:text-gray-200 space-y-1">
                <li>No recent logouts</li>
            </ul>
        </div>
    </div>

    <div class="mt-6">
        <p class="font-medium text-gray-600 dark:text-gray-300 mb-2">System Status</p>
        <ul id="systemStatus" class="text-sm text-gray-700 dark:text-gray-200 space-y-1">
            <li>Server load: 0%</li>
            <li>Database connections: 0</li>
        </ul>
    </div>
</div> -->



<!-- jQuery + Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {

        // Show panel on card click
        $('.stat-card').on('click', function () {
            const panelId = $(this).data('panel');
            $('#mainDashboard').hide();
            $('#' + panelId).show();

            // load chart dynamically
            loadChart(panelId);
        });

        // Back button
        $('.backBtn').on('click', function () {
            $(this).parent().hide();
            $('#mainDashboard').show();
        });

        // Load dashboard stats & recent activity
        function loadDashboardStats() {
            $.getJSON(base_url + "auth/action.php?action=getDashboardStats", function (data) {
                if (data.status === 1) {
                    $('#statBooks').text(data.stats.books);
                    $('#statUsers').text(data.stats.users);
                    $('#statRequests').text(data.stats.requests);
                    $('#statTasks').text(data.stats.tasks);

                    $('#recentActivity').empty();
                    data.recent.forEach(item => {
                        $('#recentActivity').append(
                            `<p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                            ${item.message} <span class="float-right text-xs text-gray-400 dark:text-gray-500">${item.time}</span>
                        </p>`
                        );
                    });
                }
            });
        }

        loadDashboardStats();

        // Function to load charts dynamically
        function loadChart(panelId) {
            let ctx, chartData, chartLabel, chartColors;

            switch (panelId) {
                case 'booksPanel':
                    ctx = $('#booksChart');
                    chartData = [120, 80, 600, 50, 200]; // example data
                    chartLabel = ['Fiction', 'Science', 'programming', 'History', 'Others'];
                    chartColors = ['#4338ca', '#4f46e5', '#818cf8', '#c7d2fe'];
                    break;
                case 'usersPanel':
                    ctx = $('#usersChart');
                    chartData = [50, 30, 20]; // example: students/faculty/admin
                    chartLabel = ['Students', 'Faculty', 'Admin'];
                    chartColors = ['#10b981', '#34d399', '#6ee7b7'];
                    break;
                case 'requestsPanel':
                    ctx = $('#requestsChart');
                    chartData = [5, 8, 1]; // example: pending/approved/rejected
                    chartLabel = ['Pending', 'Approved', 'Rejected'];
                    chartColors = ['#facc15', '#fde68a', '#fbbf24'];
                    break;
                case 'tasksPanel':
                    ctx = $('#tasksChart');
                    chartData = [3, 2, 4, 1]; // example tasks by type
                    chartLabel = ['Database', 'Reports', 'Maintenance', 'Other'];
                    chartColors = ['#ef4444', '#f87171', '#fca5a5', '#fecaca'];
                    break;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabel,
                    datasets: [{
                        label: 'Count',
                        data: chartData,
                        backgroundColor: chartColors
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }


        function loadMonitoringPanel() {
            $.ajax({
                url: `${base_url}auth/action.php?action=getMonitoringData`,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.status === 1) {
                        const loggedIn = res.data.loggedIn || [];
                        const loggedOut = res.data.loggedOut || [];
                        const system = res.data.system || {};

                        const $loggedInList = $('#loggedInUsers').empty();
                        if (loggedIn.length) {
                            loggedIn.forEach(user => {
                                $loggedInList.append(`<li>${user.name} (${user.role}) - ${user.time}</li>`);
                            });
                        } else {
                            $loggedInList.append('<li>No users online</li>');
                        }

                        const $loggedOutList = $('#loggedOutUsers').empty();
                        if (loggedOut.length) {
                            loggedOut.forEach(user => {
                                $loggedOutList.append(`<li>${user.name} (${user.role}) - ${user.time}</li>`);
                            });
                        } else {
                            $loggedOutList.append('<li>No recent logouts</li>');
                        }

                        const $systemList = $('#systemStatus').empty();
                        $systemList.append(`<li>Server load: ${system.load || 0}%</li>`);
                        $systemList.append(`<li>Database connections: ${system.dbConnections || 0}</li>`);
                    }
                },
                error: function (err) {
                    console.error('Monitoring data load failed', err);
                }
            });
        }

        // Refresh every 10 seconds
        loadMonitoringPanel();
        setInterval(loadMonitoringPanel, 10000);

    });
</script>