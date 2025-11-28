<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    Digital E-Library Analytics & Reports
</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-indigo-500 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
            <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </div>
        <p id="totalUsers" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">128</p>
        <p class="text-xs text-green-500 mt-1">↑ 12% this month</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-emerald-500 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ebooks Accessed</p>
            <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v12H4z" fill="none"/><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM4 6h16v12H4V6z"/></svg>
        </div>
        <p id="ebooksAccessed" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">542</p>
        <p class="text-xs text-green-500 mt-1">↑ total usage</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-yellow-500 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Resources</p>
            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M5 4v16h14V4H5zm12 14H7V6h10v12z"/></svg>
        </div>
        <p id="totalResources" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">1,024</p>
        <p class="text-xs text-yellow-500 mt-1">Last updated 5 mins ago</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-red-500 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Users Today</p>
            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </div>
        <p id="activeUsers" class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">34</p>
        <p class="text-xs text-red-500 mt-1">Currently active</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition flex flex-col">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Ebook Access Utilization</h2>
        <div class="flex-1">
            <canvas id="utilizationChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition flex flex-col">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Number of Users Access</h2>
        <div class="flex-1">
            <canvas id="usersChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition flex flex-col">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Total Ebooks & References</h2>
        <div class="flex-1">
            <canvas id="resourcesChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>

<!-- Detailed Table -->
<div class="mt-12 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Detailed Report</h2>
        <div class="flex gap-2 mt-2 md:mt-0">
            <button class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition text-sm">Export CSV</button>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">Export PDF</button>
        </div>
    </div>
    <div class="overflow-x-auto max-h-[400px]">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ebook Title</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Access Type</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Timestamp</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 hover:divide-gray-400">
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">John Doe</td>
                    <td class="px-4 py-2">Digital Research Paper 2025</td>
                    <td class="px-4 py-2">Read</td>
                    <td class="px-4 py-2">60 min</td>
                    <td class="px-4 py-2">2025-11-28 08:30</td>
                </tr>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-2">2</td>
                    <td class="px-4 py-2">Jane Doe</td>
                    <td class="px-4 py-2">Modern Library Systems</td>
                    <td class="px-4 py-2">Downloaded</td>
                    <td class="px-4 py-2">0 min</td>
                    <td class="px-4 py-2">2025-11-28 10:00</td>
                </tr>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-2">3</td>
                    <td class="px-4 py-2">Michael Smith</td>
                    <td class="px-4 py-2">Introduction to Algorithms</td>
                    <td class="px-4 py-2">Read</td>
                    <td class="px-4 py-2">45 min</td>
                    <td class="px-4 py-2">2025-11-27 14:30</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const barOptions = {
        responsive:true,
        maintainAspectRatio:false,
        plugins:{legend:{display:false}},
        scales:{y:{beginAtZero:true,ticks:{precision:0}}}
    };

    // Utilization Chart
    new Chart(document.getElementById('utilizationChart'), {
        type: 'bar',
        data: {
            labels: ['Intro to Algorithms','Clean Code','Digital Research Paper 2025','Modern Library Systems','Data Science Handbook'],
            datasets: [{label:'Accesses',data:[25,18,12,9,7],backgroundColor:'#6366F1',borderRadius:5}]
        },
        options: barOptions
    });

    // Users Chart
    new Chart(document.getElementById('usersChart'), {
        type: 'bar',
        data: {
            labels:['John Doe','Jane Doe','Michael Smith','Emily Johnson','Robert Brown'],
            datasets:[{label:'Ebooks Accessed',data:[15,12,9,8,7],backgroundColor:'#10B981',borderRadius:5}]
        },
        options: barOptions
    });

    // Resources Chart
    new Chart(document.getElementById('resourcesChart'), {
        type:'doughnut',
        data:{labels:['Ebooks','Research Papers','References & Guides'],datasets:[{data:[850,120,54],backgroundColor:['#F59E0B','#FBBF24','#FCD34D']}]},
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{legend:{position:'bottom',labels:{usePointStyle:true,pointStyle:'circle',color:'#374151'}}}
        }
    });
});
</script>
