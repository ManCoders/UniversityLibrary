<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    User Management Overview
</h1>
<!-- Tabs for Adding Accounts / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center">
        <!-- Tabs -->
        <nav class="flex space-x-4" aria-label="Tabs">

            <button id="tab-admin"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Admin Table
            </button>

            <button id="tab-faculty"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Faculty Table
            </button>
            <button id="tab-student"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Student Table
            </button>
            <button id="tab-visitor"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Visitor Table
            </button>
            <button id="tab-approval"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Account Approval
            </button>
        </nav>

        <div class="flex items-center">
        </div>

    </div>
</div>


<!-- Tab Contents -->
<div id="tab-content">
    <!-- Visitor Table -->
    <div id="visitor-table-content" class="tab-panel hidden">
        <table id="visitorTable"
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Fullname</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Gender</th>

                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        School from</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="visitorTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Admin Table -->
    <div id="admin-table-content" class="tab-panel hidden">
        <table id="adminTable"
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Employee ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Fullname</th>

                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Offices</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="adminTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Student Table -->
    <div id="student-table-content" class="tab-panel hidden">
        <table id="studentTable"
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Student No</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Fullname</th>

                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Course</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Department</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="studentTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Faculty Table -->
    <div id="faculty-table-content" class="tab-panel hidden">
        <table id="facultyTable"
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Employee ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Fullname</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email</th>

                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Department</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="facultyTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Account Approval Table -->
    <div id="approval-table-content" class="tab-panel hidden">
        <table id="approvalTable"
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Name</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Roles</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Account Status</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="approvalTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL BACKDROP -->
<div id="viewModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">

    <!-- MODAL CONTAINER -->
    <div
        class="bg-white dark:bg-gray-900 w-full max-w-5xl max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">

        <!-- MODAL HEADER -->
        <div
            class="flex items-center justify-between p-4 border-b border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Profile Overview</h2>
            <button id="closeViewBtn"
                class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white text-lg font-bold">✕</button>
        </div>

        <!-- MODAL BODY -->
        <div class="p-6 overflow-y-auto max-h-[65vh]">

            <!-- MAIN CONTENT -->
            <div class="flex flex-col sm:flex-row gap-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">

                <!-- LEFT SIDE -->
                <div
                    class="flex flex-col items-center w-full sm:w-[35%] border-r border-gray-300 dark:border-gray-700 pr-4">
                    <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-indigo-500 shadow-md">
                        <img id="viewProfilePic" src="../../assets/default-profile.png" alt="Profile Preview"
                            class="w-full h-full object-cover">
                    </div>
                    <p id="viewStatus" class="mt-4 text-sm font-bold text-indigo-600 dark:text-indigo-300">Pending</p>
                </div>

                <!-- RIGHT SIDE -->
                <div class="flex-1 flex flex-col gap-4">

                    <!-- NAME INFO -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Name</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="label">First Name</p>
                                <p id="viewfirstname" class="value">John</p>
                            </div>
                            <div>
                                <p class="label">Last Name</p>
                                <p id="viewlastname" class="value">Doe</p>
                            </div>
                            <div>
                                <p class="label">Middle Name</p>
                                <p id="viewmiddlename" class="value">Michael</p>
                            </div>
                            <div>
                                <p class="label">Suffix</p>
                                <p id="viewsuffix" class="value">Jr.</p>
                            </div>
                        </div>
                    </div>

                    <!-- STUDENT INFO -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Student Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="label">Designation Address: </p>
                                <p id="viewdepartment" class="value">Computer Science</p>
                            </div>
                            <div>
                                <p class="label">User ID</p>
                                <p id="viewstudent_id" class="value">2025001</p>
                            </div>
                            <div>
                                <p class="label">Course</p>
                                <p id="viewcourse" class="value">BSIT</p>
                            </div>
                            <div>
                                <p class="label">Gender</p>
                                <p id="viewgender" class="value">Male</p>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Contact</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="label">Email</p>
                                <p id="viewEmail" class="value">john.doe@example.com</p>
                            </div>
                            <div>
                                <p class="label">Login ID</p>
                                <p id="viewLogin" class="value">johndoe</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ACTIVITIES TABLE -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Student Activities</h3>
                <div class="overflow-x-auto">
                    <table id="activitiesTable"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th>#</th>
                                <th>Book Title</th>
                                <th>Date & Time</th>
                                <th>End Time / Consumed Reading</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="studentActivitiesBody" class="divide-y divide-gray-200 dark:divide-gray-700"></tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- MODAL FOOTER -->
        <div
            class="p-4 border-t border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex justify-end gap-3">
            <button id="closeViewBtn2"
                class="px-4 py-2 rounded-lg bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-white hover:bg-gray-400 transition">Close</button>
        </div>

    </div>

    <!-- DataTables Libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable


            // --- VIEW, EDIT, DELETE ACTIONS ---
            $(document).on("click", ".view-btn, .edit-btn, .delete-btn", function () {
                const tr = $(this).closest("tr");
                const userId = tr.data("id");

                if ($(this).hasClass("view-btn")) loadActivities(userId);
                else if ($(this).hasClass("edit-btn")) editUser(userId);
                else if ($(this).hasClass("delete-btn")) deleteUser(userId, tr);
            });


        });
    </script>

</div>



<script>
    $(document).ready(function () {

        const tabButtons = $(".tab-button"); // Get all tab buttons
        const tabPanels = $(".tab-panel");  // Get all tab content panels

        // --- TAB MANAGEMENT ---
        function activateTab(tabId, contentId) {
            // Hide all panels and remove active class from all tab buttons
            tabPanels.addClass('hidden');
            tabButtons
                .removeClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .addClass('border-transparent dark:text-gray-400');

            // Show the selected panel and highlight the selected tab
            $(contentId).removeClass('hidden');
            $(tabId).addClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .removeClass('border-transparent dark:text-gray-400');
        }

        // Tab click handlers
        $('#tab-visitor').click(() => activateTab('#tab-visitor', '#visitor-table-content'));
        $('#tab-admin').click(() => activateTab('#tab-admin', '#admin-table-content'));
        $('#tab-student').click(() => activateTab('#tab-student', '#student-table-content'));
        $('#tab-faculty').click(() => activateTab('#tab-faculty', '#faculty-table-content'));
        $('#tab-approval').click(() => activateTab('#tab-approval', '#approval-table-content'));

        // Initial Tab: Load the "Visitor Table" by default
        // activateTab('#tab-visitor', '#visitor-table-content');
        activateTab(`.tab-panel`, '#view-content');




        /* ================================
   ACTIVITIES DATATABLE
================================= */
        const activitiesTable = new DataTable("#activitiesTable", {
            fixedHeight: true,
            searchable: true,
            paging: true,
            perPage: 10,
            perPageSelect: [10, 20, 50],
            order: [[2, "desc"]] // Date & Time DESC
        });

        function loadActivities(userId) {
            if (!userId) return;

            $.ajax({
                url: `${base_url}auth/action.php?action=recently_viewed&user_id=${userId}`,
                type: "GET",
                dataType: "json",
                success(res) {
                    activitiesTable.clear();

                    if (Array.isArray(res)) {
                        res.forEach((item, index) => {
                            activitiesTable.row.add([
                                index + 1,
                                item.book_title ?? "—",
                                item.start_time ?? "—",
                                item.end_time ?? "—",
                                item.remark ?? "—"
                            ]);
                        });
                    }

                    activitiesTable.draw();
                },
                error(err) {
                    console.error("Failed to fetch activities:", err);
                }
            });
        }







        const tableConfigs = {
            approvalTable: {
                order: [[2, "desc"]],
                perPage: 10,
                perPageSelect: [10, 20, 50]
            },
            visitorTable: {},
            adminTable: {},
            studentTable: {},
            facultyTable: {}
        };

        const tables = {};

        Object.entries(tableConfigs).forEach(([id, config]) => {
            tables[id] = new DataTable(`#${id}`, {
                searchable: true,
                paging: true,
                perPage: 10,
                ...config
            });
        });

        Object.entries(tables).forEach(([key, table]) => {
            $(`#${key}`).on("click", ".view-btn", function () {
                const userId = $(this).data("id");
                $("#viewModal").removeClass("hidden");

                // Optional: load user data via AJAX
                $.ajax({
                    url: `${base_url}auth/action.php?action=GetUser&user_id=${userId}`,
                    type: "GET",
                    dataType: "json",
                    success(res) {
                        if (!res || res.status !== 1) return;

                       

                        const personal = res.data.personal || {};
                        const auth = res.data.auth || {};

                        // Fill modal fields
                        $("#viewfirstname").text(personal.firstname || "Not Fill up by registree");
                        $("#viewlastname").text(personal.lastname || "Not Fill up by registree");
                        $("#viewmiddlename").text(personal.middlename || "No Available Middle Name");
                        $("#viewsuffix").text(personal.suffix || "Not Fill up by registree");
                        $("#viewdepartment").text(personal.department || personal.admin_offices || personal.schoolname || "Not Fill up by registree");
                        $("#viewstudent_id").text(personal.employee_id || personal.student_id || personal.admin_id || "Visitor ID Not Available");
                        $("#viewcourse").text(personal.course || "No Course Available");
                        $("#viewgender").text(personal.gender || "Not Fill up by registree");
                        $("#viewEmail").text(auth.email || "Not Fill up by registree");
                        $("#viewLogin").text(personal.library_id || "Generated ID has been Error");
                        $("#viewStatus").text(auth.account_status || "—");

                        // Profile picture
                        if (personal.profile_pic) {
                            $("#viewProfilePic").attr("src", base_url+ '/auth/'+ personal.profile_pic);
                        } else {
                            $("#viewProfilePic").attr("src", "../../assets/default-profile.png");
                        }

                        // Load activities into DataTable if needed
                        if (res.activities && Array.isArray(res.activities)) {
                            const activitiesTable = new DataTable("#activitiesTable");
                            activitiesTable.clear();
                            res.activities.forEach((act, idx) => {
                                activitiesTable.row.add([
                                    idx + 1,
                                    act.book_title || "—",
                                    act.start_time || "—",
                                    act.end_time || "—",
                                    act.remark || "—"
                                ]);
                            });
                            activitiesTable.draw();
                        }
                    },
                    error(err) {
                        console.error(err);
                    }
                });

                

            });

            $(`#${key}`).on("click", ".edit-btn", function () {
                const id = $(this).data("id");
                alert(`Edit: ${id}`);
            });

            $(`#${key}`).on("click", ".delete-btn", function () {
                const id = $(this).data("id");
                alert(`Delete: ${id}`);
            });
        });
        // Close modal
                $("#closeViewBtn, #closeViewBtn2").click(function () {
                    $("#viewModal").addClass("hidden");
                });


        loadUsers();
        function loadUsers() {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetFaculty`,
                type: "GET",
                dataType: "json",
                success(res) {
                    if (res.status !== 1) return;

                    // Clear all tables safely
                    Object.values(tables).forEach(t => t.clear());

                    res.data.forEach((user, index) => {
                        const personal = JSON.parse(user.personal_details || "{}");
                        const auth = JSON.parse(user.authentication_data || "{}");

                        const role = auth.user_role;
                        const status = (auth.account_status || "").toLowerCase();

                        if (status === "declined") return;

                        /* ===== PENDING USERS ===== */
                        if (status === "pending") {
                            tables.approvalTable.row.add([
                                index + 1,
                                `${personal.firstname} ${personal.lastname}`,
                                auth.email || "—",
                                role || "—",
                                auth.account_status,
                                actionButtons(user.user_id)
                            ]);
                            return;
                        }

                        /* ===== ROLE TABLE ROW ===== */
                        const row = [
                            personal.employee_id || personal.student_id || index + 1,
                            `${personal.firstname} ${personal.middlename || ""} ${personal.lastname}`,
                            auth.email || "—",
                            personal.department || personal.course || "—",
                            auth.account_status,
                            actionButtons(user.user_id)
                        ];

                        switch (role) {
                            case "visitor":
                                tables.visitorTable.row.add(row);
                                break;
                            case "admin":
                                tables.adminTable.row.add(row);
                                break;
                            case "student":
                                tables.studentTable.row.add(row);
                                break;
                            case "faculty":
                                tables.facultyTable.row.add(row);
                                break;
                        }
                    });

                    // Draw all tables once
                    Object.values(tables).forEach(t => t.draw(false));
                },
                error(xhr) {
                    console.error(xhr.responseText);
                }
            });

            function actionButtons(userId) {
                return `
            <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs" data-id="${userId}">View</button>
            <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs" data-id="${userId}">Edit</button>
            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs" data-id="${userId}">Delete</button>
            `;
            }
        }

    });


</script>