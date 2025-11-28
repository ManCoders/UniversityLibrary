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

        </div>
        <!-- <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="panelDepartment">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400"></p>
            <p id="statDepartment" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <p class="text-xs text-red-500 mt-2">Action required</p>
        </div> -->
        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-emerald-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="OnlinePanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Users</p>
            <p id="OnlineUsers" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <!-- <p class="text-xs text-red-500 mt-2">↓ 0% this month</p> -->
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 cursor-pointer 
                hover:shadow-2xl hover:scale-105 transform transition duration-300 ease-in-out"
            data-panel="requestsPanel">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Registered Account </p>
            <p id="statRequests" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">0</p>
            <!-- <p class="text-xs text-yellow-500 mt-2">Last updated just now</p> -->
        </div>


    </div>

</div>

<div id="booksPanel" class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6 hidden">
    <button class="backBtn mb-4 px-5 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600">
        Back
    </button>

    <h2 class="text-xl text-gray-900 dark:text-gray-100 mb-2">
        Books by Category
    </h2>

    <div class="space-y-2">
        <div id="booksContainer" class="space-y-4"></div>
        <!-- <div class="border rounded-lg bg-gray-50 dark:bg-gray-700">
            <button class="w-full flex justify-between items-center p-3 categoryBtn">
                <span class="font-semibold text-gray-900 dark:text-gray-100">Science</span>
                <span class="bg-indigo-500 text-white text-xs px-3 text-2xl font-bold py-2 rounded font-bold">Total book: <span class="">12</span></span>
            </button>

            <hr class="border-gray-300 dark:border-gray-600">

            <div class="categoryList hidden px-4 pb-3">
                <ol class="list-decimal list-inside text-gray-700 dark:text-gray-300 space-y-1">
                    <li>Physics Handbook</li>
                    <li>Chemistry Essentials</li>
                    <li>Biology Intro</li>
                </ol>
            </div>
        </div>

        <div class="border rounded-lg bg-gray-50 dark:bg-gray-700">
            <button class="w-full flex justify-between items-center p-3 categoryBtn">
                <span class="font-semibold text-gray-900 dark:text-gray-100">Science</span>
                <span class="bg-indigo-500 text-white text-xs px-3 text-2xl font-bold py-2 rounded font-bold">Total book: <span class="">12</span></span>
            </button>

            <hr class="border-gray-300 dark:border-gray-600">

            <div class="categoryList hidden px-4 pb-3">
                <ol class="list-decimal list-inside text-gray-700 dark:text-gray-300 space-y-1">
                    <li>Physics Handbook</li>
                    <li>Chemistry Essentials</li>
                    <li>Biology Intro</li>
                </ol>
            </div>
        </div>
 -->
    </div>
</div>

<script>
    $(document).on('click', '.categoryBtn', function () {
        $(this).closest('div').find('.categoryList').toggleClass('hidden');
    });
</script>





<div id="OnlinePanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Users Logged Monitoring</h2>
    <canvas id="usersChart" class="mt-4"></canvas>
</div>
<div id="panelDepartment" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Department Books Monitoring</h2>
    <canvas id="offlineChart" class="mt-4"></canvas>
</div>
<div id="requestsPanel" class="hidden p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-6">
    <button class="backBtn mb-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Back</button>

    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Registration Requests Approval</h2>

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

                </tbody>
            </table>
        </div>
    </div>
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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {

        let dashboardData = { requests: { pending: 0, approved: 0, declined: 0 } };

        // ---------------- Load Dashboard Stats ----------------
        function loadDashboardStats() {
            $.ajax({
                url: `${base_url}auth/action.php?action=getDashboardStats`,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (!res || res.status !== 1) {
                        alert(res?.message || "Failed to load dashboard.");
                        return;
                    }

                    // Only keep request-related stats
                    dashboardData.requests = res.stats.requests || {
                        pending: 0,
                        approved: 0,
                        declined: 0
                    };
                    // Online/offline users
                    dashboardData.users = res.stats || {
                        online: 0,
                        offline: 0
                    };


                    dashboardData.stats = {
                        totalDepartment: res.stats.totalDepartment || 0, //locked this
                        folder_names: res.stats.folder_names || [], //locked this
                        booksperfolder: res.stats.booksperfolder || {}
                    };


                    const allBooks = Object.values(dashboardData.stats.booksperfolder)
                        .flat();

                    console.log('Array: ', allBooks);
                    console.log('Total books:', allBooks.length);


                    if (res.status !== 1 || !res.stats || !res.stats.booksperfolder) {
                        $("#booksContainer").html("<p class='text-red-500'>No data found.</p>");
                        return;
                    }
                    const folders = res.stats.booksperfolder;
                    let html = "";

                    $.each(folders, function (folderName, files) {

                        // Extract titles properly
                        const titles = files.map(file => {
                            if (file.metadata?.Title) return file.metadata.Title;
                            if (file.metadata?.["dc:title"]) return file.metadata["dc:title"];
                            return file.filename; // fallback
                        });

                        html += `
                        <div class="border rounded-lg bg-gray-50 dark:bg-gray-700">
                            <button class="w-full flex justify-between items-center p-3 categoryBtn">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">${folderName}</span>
                                <span class="bg-indigo-500 text-white text-xs px-3 text-2xl font-bold py-2 rounded">
                                    Total book: <span>${titles.length}</span>
                                </span>
                            </button>

                            <hr class="border-gray-300 dark:border-gray-600">

                            <div class="categoryList hidden px-4 pb-3">
                                <ol class="list-decimal list-inside text-gray-700 dark:text-gray-300 space-y-1">
                                    ${titles.map(t => `<li>${t}</li>`).join("")}
                                </ol>
                            </div>
                        </div>
                        `;
                    });

                    $("#booksContainer").html(html);






                    $('#statBooks').text(allBooks.length || null);

                    // Update dashboard counter
                    const totalRequests = dashboardData.requests.pending + dashboardData.requests.approved + dashboardData.requests.declined;


                    $('#statDepartment').text(dashboardData.stats.totalDepartment);
                    $('#statRequests').text(totalRequests);
                    $('#OnlineUsers').text(dashboardData.users.totalusers || 0);






                    // Populate recent activity
                    const $recent = $('#recentActivity').empty();
                    if (res.recent?.length) {
                        res.recent.forEach(item => {
                            $recent.append(`
                            <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                                ${item.message || ''} 
                                <span class="float-right text-xs text-gray-400 dark:text-gray-500">
                                    ${item.time || ''}
                                </span>
                            </p>
                        `);
                        });
                    } else {
                        $recent.append('<p class="text-center text-gray-500 dark:text-gray-400 py-2">No recent activity</p>');
                    }

                    // Refresh requests chart
                    loadChart('requestsPanel');
                    loadChart('OnlinePanel');
                    loadChart('panelDepartment');
                },
                error: function () {
                    alert("Server error while fetching dashboard stats.");
                }
            });
        }

        // ---------------- Requests Chart ----------------
        function loadChart(panelId) {
            let ctx, chartData, chartLabel, chartColors;

            switch (panelId) {
                case 'requestsPanel':
                    ctx = $('#requestsChart');
                    chartData = [
                        dashboardData.requests.pending || 0,
                        dashboardData.requests.approved || 0,
                        dashboardData.requests.declined || 0
                    ];
                    chartLabel = ['Pending', 'Approved', 'Declined'];
                    chartColors = ['#facc15', '#34d399', '#ef4444'];
                    break;

                case 'OnlinePanel':
                    ctx = $('#usersChart');
                    chartData = [
                        dashboardData.users.online || 0,
                        dashboardData.users.offline || 0
                    ];
                    chartLabel = ['Online Users', 'Offline Users'];
                    chartColors = ['#10b981', '#ef4444'];
                    break;

                case 'panelDepartment':
                    ctx = $('#offlineChart');
                    const folderNames = dashboardData.stats.folder_names || [];

                    // Get the book counts (length of each array) in the same order as folderNames
                    chartData = folderNames.map(name => {
                        const files = dashboardData.stats.booksperfolder[name] || [];
                        return Array.isArray(files) ? files.length : 0;
                    });

                    chartLabel = folderNames;

                    // console.log({ chartLabel, chartData });

                    const colorPalette = [
                        '#ef4444', // red
                        '#f59e0b', // amber
                        '#10b981', // green
                        '#3b82f6', // blue
                        '#8b5cf6', // purple
                        '#ec4899', // pink
                        '#f43f5e'  // rose
                    ];
                    chartColors = folderNames.map((_, i) => colorPalette[i % colorPalette.length]);
                    break;

                default:
                    return;
            }

            if (!ctx.length) return;

            // Destroy previous chart instance if exists
            if (ctx.data('chartInstance')) {
                ctx.data('chartInstance').destroy();
            }

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabel,
                    datasets: [{
                        label: panelId.includes('Online') ? 'Online' : panelId.includes('Offline') ? 'Offline' : 'Requests',
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
                    scales: { y: { beginAtZero: true } }
                }
            });

            ctx.data('chartInstance', chart);
        }

        // ---------------- Panel click / back ----------------
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

        // ---------------- Approval Requests Table ----------------
        function loadApprovalRequests() {
            $('#approvalTable').html(`<tr><td colspan="5" class="text-center py-4">Loading...</td></tr>`);

            $.post(`${base_url}auth/action.php?action=GetFaculty`, { action: 'GetFaculty' }, res => {
                if (!res.status || !res.data?.length) {
                    return $('#approvalTable').html(`<tr><td colspan="5" class="text-center py-4 text-gray-500">No pending requests</td></tr>`);
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
            }, 'json').fail(() => {
                $('#approvalTable').html(`<tr><td colspan="5" class="text-center text-red-500 py-4">Failed to load requests</td></tr>`);
            });
        }

        // Approve / Decline handlers
        $(document).on('click', '.approveBtn, .declineBtn', function () {
            const user_id = $(this).data('id');
            const action = $(this).hasClass('approveBtn') ? 'Approved' : 'Declined';

            if (!confirm(`${action} this request?`)) return;

            $('#upload-spinner').removeClass('hidden').show();

            $.post(`${base_url}auth/action.php?action=account_status`, { user_id, action }, res => {
                $('#upload-spinner').hide();
                if (res.status) {
                    alert(`Request ${action.toLowerCase()}`);
                    loadApprovalRequests();
                    loadDashboardStats(); // refresh chart
                } else alert(res.message || 'Operation failed');
            }, 'json').fail(() => alert('Server error'));
        });

        // ---------------- Initial Load ----------------
        loadDashboardStats();
        loadApprovalRequests();

    });
</script>