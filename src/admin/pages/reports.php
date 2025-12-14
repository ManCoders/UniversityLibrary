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
        <table id="userReferenceTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        #</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        FullNAME</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Book Title</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Date/Time</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Time used</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                         Count Visited</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Remark</th>
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
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">List of Reference</h2>
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
        <table id="bookReferenceTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
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
                        Visited</th>
                </tr>
            </thead>
            <tbody id="AllBooks" class="divide-y divide-gray-200 dark:divide-gray-700 hover:divide-gray-400">
                <!-- AJAX-loaded rows will go here -->
            </tbody>
        </table>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

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
                const totalCount = (book.readinglog || []).reduce((sum, log) => sum + (log.count_user || 0), 0);
                const tr = `<tr>
                <td class="px-4 py-2">${index + 1}</td>
                
                <td class="px-4 py-2">${book.isbn}</td>
                <td class="px-4 py-2 truncate max-w-xs">${book.title}</td>
                <td class="px-4 py-2">${book.author}</td>
                <td class="px-4 py-2">${totalCount}</td>
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

                book.isbn,
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

        // === Users Table / Detailed Report ===
        const userTable = $('#userReferenceTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc']],
            columnDefs: [
                { targets: 0, width: '50px' },
                { targets: [4, 5], className: 'text-center' }
            ],
            language: {
                search: "Filter users:",
                emptyTable: "No user data available",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "Showing 0 to 0 of 0 users",
                lengthMenu: "Show _MENU_ users",
                paginate: { previous: "Prev", next: "Next" }
            }
        });

        // === Books Table ===
        const bookTable = $('#bookReferenceTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc']],
            columnDefs: [
                { targets: 0, width: '50px' },
                { targets: 4, className: 'text-center' }
            ],
            language: {
                search: "Filter books:",
                emptyTable: "No book data available",
                info: "Showing _START_ to _END_ of _TOTAL_ books",
                infoEmpty: "Showing 0 to 0 of 0 books",
                lengthMenu: "Show _MENU_ books",
                paginate: { previous: "Prev", next: "Next" }
            }
        });

        // Fetch Detailed Report
        fetchDetailedReport();

        function fetchDetailedReport() {
            $.post(`${base_url}auth/action.php?action=getDetailedReport`, {}, res => {
                if (!res.status || !res.data) return console.warn("No detailed report data found.");
                detailedReportData = res.data;

                userTable.clear();
                res.data.forEach((record, index) => {
                    userTable.row.add([
                        index + 1,
                        truncate(record.fullname, 20),
                        truncate(record.book_title, 25),
                        record.start_time ?? '-',
                        record.total_read_time_formatted ?? '-',
                        record.book_count ?? 0,
                        record.remark ?? '-'
                    ]);
                });
                userTable.draw();
            }, 'json').fail(() => console.error("Failed to load detailed report"));
        }

        // Fetch Books List
        fetchBooks();

        function fetchBooks() {
            $.post(`${base_url}auth/action.php?action=getMetadata`, {}, function (res) {
                if (!res.status || !res.data) return console.warn("No books found.");
                allBooksData = res.data;

                bookTable.clear();
                res.data.forEach((book, index) => {
                    const totalCount = (book.readinglog || []).reduce((sum, log) => sum + (log.count_user || 0), 0);
                    bookTable.row.add([
                        index + 1,
                        book.book_id,
                        truncate(book.title, 40),
                        book.author,
                        totalCount
                    ]);
                });
                bookTable.draw();
            }, 'json').fail(() => console.error("Failed to load books."));
        }

        // Truncate helper
        function truncate(str, maxLength) {
            if (!str) return '';
            return str.length > maxLength ? str.slice(0, maxLength) + '…' : str;
        }

        // === Exports ===
        window.exportDetailedReportCSV = function () {
            if (!detailedReportData.length) return console.warn("No data to export.");
            const headers = ["#", "Name", "Book Title", "Date/Time", "Time Used", "USED Count", "Remark"];
            let csv = headers.join(",") + "\n";
            detailedReportData.forEach((r, i) => {
                const row = [
                    i + 1,
                    r.fullname,
                    r.book_title,
                    r.start_time ?? '',
                    r.total_read_time_formatted ?? '',
                    r.book_count ?? 0,
                    r.remark ?? '-'
                ].map(c => `"${String(c).replace(/"/g, '""')}"`);
                csv += row.join(",") + "\n";
            });
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "detailed_report.csv";
            link.click();
        };

        window.exportDetailedReportPDF = function () {
            if (!detailedReportData.length) return console.warn("No data to export.");
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');
            const columns = ["#", "Name", "Book Title", "Date/Time", "Time Used", "USED Count", "Remark"];
            const rows = detailedReportData.map((r, i) => [
                i + 1,
                truncate(r.fullname, 20),
                truncate(r.book_title, 25),
                r.start_time ?? '-',
                r.total_read_time_formatted ?? '-',
                r.book_count ?? 0,
                r.remark ?? '-'
            ]);
            doc.setFontSize(14);
            doc.text("Detailed Reading Report", 40, 40);
            doc.autoTable({ startY: 60, head: [columns], body: rows, theme: 'grid', headStyles: { fillColor: [99, 102, 241] }, styles: { fontSize: 10, cellPadding: 4 } });
            doc.save('detailed_report.pdf');
        };

        window.exportBooksCSV = function () {
            if (!allBooksData.length) return console.warn("No data to export.");
            const headers = ["#", "Book ID", "Book Title", "Author", "Count Visited"];
            let csv = headers.join(",") + "\n";
            allBooksData.forEach((book, i) => {
                const totalCount = (book.readinglog || []).reduce((sum, log) => sum + (log.count_user || 0), 0);
                const row = [
                    i + 1,
                    book.book_id,
                    book.title,
                    book.author,
                    totalCount
                ].map(c => `"${String(c).replace(/"/g, '""')}"`);
                csv += row.join(",") + "\n";
            });
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "books_list.csv";
            link.click();
        };

        window.exportBooksPDF = function () {
            if (!allBooksData.length) return console.warn("No data to export.");
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');
            const columns = ["#", "Book ID", "Book Title", "Author", "Visited"];
            const rows = allBooksData.map((book, i) => {
                const totalCount = (book.readinglog || []).reduce((sum, log) => sum + (log.count_user || 0), 0);
                return [i + 1, book.book_id, truncate(book.title, 40), book.author, totalCount];
            });
            doc.setFontSize(14);
            doc.text("Books List", 40, 40);
            doc.autoTable({ startY: 60, head: [columns], body: rows, theme: 'grid', headStyles: { fillColor: [99, 102, 241] }, styles: { fontSize: 10, cellPadding: 4 }, columnStyles: { 2: { cellWidth: 150 } } });
            doc.save('books_list.pdf');
        };

    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
