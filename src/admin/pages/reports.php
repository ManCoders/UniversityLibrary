<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    Digital E-Library Analytics & Reports
</h1>


<!-- Detailed Table -->
<div class="mt-12 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Detailed Report</h2>
        <div class="flex gap-2 mt-2 md:mt-0">
            <button onclick="exportDetailedReportCSV()"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition text-sm">Export
                CSV</button>
            <button onclick="exportDetailedReportPDF()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">Export
                PDF</button>
        </div>
    </div>
    <div class="overflow-x-auto max-h-[400px]">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        #</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        User</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Ebook Title</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Start Time</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Time Duration</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Time Limits</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Access Date</th>
                </tr>
            </thead>
            <tbody id="HistoryReading" class="divide-y divide-gray-200 dark:divide-gray-700 hover:divide-gray-400">

            </tbody>
        </table>
    </div>
</div>

<!-- Detailed Books -->
<div class="mt-12 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Books List</h2>
        <div class="flex gap-2 mt-2 md:mt-0">
            <button onclick="exportBooksCSV()"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition text-sm">
                Export CSV
            </button>
            <button onclick="exportBooksPDF()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                Export PDF
            </button>
        </div>
    </div>
    <div class="overflow-x-auto max-h-[400px]">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        #</th>

                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Book ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Book Title</th>

                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Author</th>

                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Number of Visited</th>
                </tr>
            </thead>
            <tbody id="AllBooks" class="divide-y divide-gray-200 dark:divide-gray-700 hover:divide-gray-400">
                <!-- AJAX-loaded rows will go here -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let allBooksData = [];

    function fetchBooks() {
        $.post(`${base_url}auth/action.php?action=getMetadata`, {}, function (res) {
            if (!res.status || !res.data) return console.warn("No books found.");

            allBooksData = res.data; // store globally for export

            const tbody = $("#AllBooks");
            tbody.empty();

            res.data.forEach((book, index) => {
                const tr = `<tr>
                <td class="px-4 py-2">${index + 1}</td>
                
                <td class="px-4 py-2">${book.book_id}</td>
                <td class="px-4 py-2 truncate max-w-xs">${book.title}</td>
                <td class="px-4 py-2">${book.author}</td>
            </tr>`;
                tbody.append(tr);
            });
        }, 'json').fail(() => console.error("Failed to load books."));
    }

    function exportBooksCSV() {
        if (!allBooksData.length) return console.warn("No data to export.");

        const headers = ["#", "Book ID", "Book Title", "Author"];
        let csvContent = headers.join(",") + "\n";

        allBooksData.forEach((book, index) => {
            const row = [
                index + 1,

                book.book_id,
                book.title,
                book.author
            ].map(cell => `"${String(cell).replace(/"/g, '""')}"`);
            csvContent += row.join(",") + "\n";
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "books_list.csv";
        link.click();
    }

    function exportBooksPDF() {
        if (!allBooksData.length) return console.warn("No data to export.");

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4');

        const columns = ["#", "Book ID", "Book Title", "Author"];
        const rows = allBooksData.map((book, index) => [
            index + 1,
            book.book_id,
            book.title,
            book.author
        ]);

        doc.setFontSize(14);
        doc.text("Books List", 40, 40);

        doc.autoTable({
            startY: 60,
            head: [columns],
            body: rows,
            theme: 'grid',
            headStyles: { fillColor: [99, 102, 241] },
            alternateRowStyles: { fillColor: [245, 245, 245] },
            styles: { fontSize: 10, cellPadding: 4 },
            columnStyles: { 3: { cellWidth: 150 } }
        });

        doc.save('books_list.pdf');
    }

    $(document).ready(() => {
        fetchBooks();
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Load stats first
        fetchDashboardStats();
        fetchDetailedReport();
        function fetchDashboardStats() {
            $.post(`${base_url}auth/action.php?action=getAnalyticsStats`, {}, res => {
                if (!res.status || !res.data) {
                    console.warn("No dashboard data found.");
                    return;
                }

                buildCharts(res.data);
            }, 'json')
                .fail(() => console.error("Dashboard stats failed to load"));
        }

        function buildCharts(data) {

            const barOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            };

            // === Utilization Chart ===
            const maxLength = 15; // max characters for display
            const shortLabels = data.utilization.labels.map(title =>
                title.length > maxLength ? title.slice(0, maxLength) + '…' : title
            );

            new Chart(document.getElementById('utilizationChart'), {
                type: 'bar',
                data: {
                    labels: shortLabels,
                    datasets: [{
                        label: 'Accesses',
                        data: data.utilization.values,
                        backgroundColor: '#6366F1',
                        borderRadius: 5
                    }]
                },
                options: barOptions
            });

            // Truncate labels helper
            function truncateLabels(labels) {
                return labels.map(label => label.length > maxLength ? label.slice(0, maxLength) + '…' : label);
            }

            // Users Chart
            new Chart(document.getElementById('usersChart'), {
                type: 'bar',
                data: {
                    labels: truncateLabels(data.users.labels),
                    datasets: [{
                        label: 'Ebooks Accessed',
                        data: data.users.values,
                        backgroundColor: '#10B981',
                        borderRadius: 5
                    }]
                },
                options: barOptions
            });

            // Resources Chart
            new Chart(document.getElementById('resourcesChart'), {
                type: 'doughnut',
                data: {
                    labels: truncateLabels(data.resources.labels),
                    datasets: [{
                        data: data.resources.values,
                        backgroundColor: ['#F59E0B', '#FCD34D']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: '#374151'
                            }
                        }
                    }
                }
            });

        }

        function fetchDetailedReport() {
            $.post(`${base_url}auth/action.php?action=getDetailedReport`, {}, res => {
                if (!res.status || !res.data) {
                    console.warn("No detailed report data found.");
                    return;
                }

                const tbody = document.getElementById('HistoryReading');
                tbody.innerHTML = '';

                res.data.forEach((record, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 py-2">${index + 1}</td>
                        <td class="px-4 truncate py-2">${record.fullname}</td>
                        <td class="px-4 truncate block max-w-xs py-2">${record.book_title}</td>
                        <td class="px-4 py-2">${record.start_time}</td>
                        <td class="px-4 py-2">${record.start_time}</td>
                        <td class="px-4 py-2">${record.total_read_time_formatted}</td>
                        <td class="px-4 py-2">${record.total_read_time_formatted}</td>
                        <td class="px-4 py-2">${record.end_time}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }, 'json')
                .fail(() => console.error("Detailed report failed to load"));
        }

        let detailedReportData = [];

        function fetchDetailedReport() {
            $.post(`${base_url}auth/action.php?action=getDetailedReport`, {}, res => {
                if (!res.status || !res.data) {
                    console.warn("No detailed report data found.");
                    return;
                }

                detailedReportData = res.data; // store globally for export

                const tbody = document.getElementById('HistoryReading');
                tbody.innerHTML = '';

                res.data.forEach((record, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td class="px-4 py-2">${index + 1}</td>
                <td class="px-4 truncate py-2">${truncate(record.fullname, 20)}</td>
                <td class="px-4 truncate block max-w-xs py-2">${truncate(record.book_title, 25)}</td>
                <td class="px-4 py-2">${record.start_time}</td>
                <td class="px-4 py-2">${record.total_read_time_formatted}</td>
                <td class="px-4 py-2">${record.total_read_time_formatted}</td>
                <td class="px-4 py-2">${record.end_time ?? '-'}</td>
            `;
                    tbody.appendChild(tr);
                });
            }, 'json')
                .fail(() => console.error("Detailed report failed to load"));
        }

        function truncate(str, maxLength) {
            if (!str) return '';
            return str.length > maxLength ? str.slice(0, maxLength) + '…' : str;
        }

        window.exportDetailedReportPDF = function () {
            if (!detailedReportData.length) return console.warn("No data to export.");

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');

            const tableColumns = ["#", "Name", "Book Title", "Start Time", "Duration", "End Time"];
            const tableRows = detailedReportData.map((record, index) => [
                index + 1,
                truncate(record.fullname, 20),
                truncate(record.book_title, 25),
                record.start_time ?? '-',
                record.total_read_time_formatted ?? '-',
                record.end_time ?? '-'
            ]);

            doc.setFontSize(14);
            doc.text("Detailed Reading Report", 40, 40);

            doc.autoTable({
                startY: 60,
                head: [tableColumns],
                body: tableRows,
                theme: 'grid',
                headStyles: { fillColor: [99, 102, 241] },
                alternateRowStyles: { fillColor: [245, 245, 245] },
                styles: { fontSize: 10, cellPadding: 4 },
                columnStyles: { 1: { cellWidth: 100 }, 2: { cellWidth: 120 } }
            });

            doc.save('detailed_reading_report.pdf');
        };

        window.exportDetailedReportCSV = function () {
            if (!detailedReportData.length) return console.warn("No data to export.");

            const headers = ["#", "Name", "Book Title", "Start Time", "Duration", "End Time"];
            const rows = detailedReportData.map((record, index) => [
                index + 1,
                record.fullname,
                record.book_title,
                record.start_time ?? '',
                record.total_read_time_formatted ?? '',
                record.end_time ?? ''
            ]);

            let csvContent = headers.join(",") + "\n";
            rows.forEach(row => {
                const escapedRow = row.map(cell => `"${String(cell).replace(/"/g, '""')}"`);
                csvContent += escapedRow.join(",") + "\n";
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "detailed_reading_report.csv";
            link.click();
        };

    });
</script>