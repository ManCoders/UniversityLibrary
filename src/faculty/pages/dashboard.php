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

    <!-- Approval Table -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">Approval Requests</h3>

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Request Type</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="approvalTable" class="text-gray-800 dark:text-gray-100">
                    <!-- Dynamic rows go here -->
                    <!-- Example row:
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">John Doe</td>
                        <td class="px-4 py-2">Account Activation</td>
                        <td class="px-4 py-2">2025-11-20</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">Pending</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="approveBtn px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs">Approve</button>
                            <button class="declineBtn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs ml-2">Decline</button>
                        </td>
                    </tr>
                    -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="tasksPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Tasks</h2>
    <canvas id="tasksChart" class="mt-4"></canvas>
</div>
<!-- Monitoring Panel -->
<div id="monitorPanel" class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
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
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {

        // Show panel on card click
        $('.stat-card').on('click', function () {
            const panelId = $(this).data('panel');
            $('#mainDashboard').hide();
            $('#' + panelId).show();
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


        loadApprovalRequests();
        function loadApprovalRequests() {
            $('#approvalTable').html(`
                <tr><td colspan="5" class="text-center py-4">Loading...</td></tr>
            `);

            $.post(base_url + "auth/action.php?action=GetFaculty", {
                action: 'GetFaculty'
            }, res => {
                if (!res.status || !res.data || res.data.length === 0) {
                    return $('#approvalTable').html(`
                <tr><td colspan="5" class="text-center py-4 text-gray-500">No pending requests</td></tr>
            `);
                }

                const statusClasses = {
                    Pending: 'bg-yellow-100 text-yellow-700',
                    Approved: 'bg-green-100 text-green-700',
                    Declined: 'bg-red-100 text-red-700'
                };

                const rows = res.data.map(req => `
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-2">${req.lastname}</td>
                    <td class="px-4 py-2">${req.user_role === 'student' ? 'Student' : 'Faculty'}</td>
                    <td class="px-4 py-2">${req.created_date}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded ${statusClasses[req.account_status] || 'bg-gray-100 text-gray-700'}">
                            ${req.account_status}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button data-id="${req.user_id}" class="approveBtn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 mr-1">Approve</button>
                        <button data-id="${req.user_id}" class="declineBtn px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Decline</button>
                    </td>
                </tr>
            `).join('');


                $("#approvalTable").html(rows);

            }, 'json')
                .fail(() => {
                    $('#approvalTable').html(`<tr><td colspan="5" class="text-center text-red-500 py-4">Failed to load requests</td></tr>`);
                });
        }

        // Handle approve
        $(document).on('click', '.approveBtn', function () {
            const user_id = $(this).data('id');
            // alert(id);
            if (!confirm("Approve this request?")) return;
            $('#upload-spinner').removeClass('hidden').show();

            $.post(base_url + "auth/action.php?action=account_status", { user_id: user_id, action: 'Approved'}, res => {
                $('#upload-spinner').removeClass('hidden').hide();

                if (res.status) {
                    alert('Request approved');
                    loadApprovalRequests();
                } else alert(res.message || 'Operation failed');
            }, 'json').fail(() => alert('Server error'));
        });

        // Handle decline
        $(document).on('click', '.declineBtn', function () {
            const user_id = $(this).data('id');

            if (!confirm("Decline this request?")) return;

            $('#upload-spinner').removeClass('hidden').show();

            $.post(base_url + "auth/action.php?action=account_status", { user_id: user_id, action: 'Declined'}, res => {
                $('#upload-spinner').removeClass('hidden').hide();

                if (res.status) {
                    alert('Request declined');
                    loadApprovalRequests();
                } else alert(res.message || 'Operation failed');
            }, 'json').fail(() => alert('Server error'));
        });

    });
</script>