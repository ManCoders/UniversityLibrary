<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    User Management Overview
</h1>
<!-- Tabs for Adding Accounts / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center">
        <!-- Tabs -->
        <nav class="flex space-x-4" aria-label="Tabs">
            <button id="tab-visitor"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Visitor Table
            </button>
            <button id="tab-admin"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Admin Table
            </button>
            <button id="tab-student"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Student Table
            </button>
            <button id="tab-faculty"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Faculty Table
            </button>
            <button id="tab-approval"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Account Approval
            </button>
        </nav>


        <div class="flex items-center">
            <input id="searchFaculty" type="text" placeholder="Search user"
                class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg px-3 py-1 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

    </div>
</div>


<!-- Tab Contents -->
<div id="tab-content">
    <!-- Visitor Table -->
    <div id="visitor-table-content" class="tab-panel hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gender</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">School from</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="visitorTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Admin Table -->
    <div id="admin-table-content" class="tab-panel hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="adminTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Student Table -->
    <div id="student-table-content" class="tab-panel hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student No</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="studentTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Faculty Table -->
    <div id="faculty-table-content" class="tab-panel hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Employee No</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="facultyTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Account Approval Table -->
    <div id="approval-table-content" class="tab-panel hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Account Status</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="approvalTableBody">
                <!-- Rows will be appended here dynamically by AJAX -->
            </tbody>
        </table>
    </div>
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
        activateTab('#tab-visitor', '#visitor-table-content');

        // --- SEARCH FUNCTIONALITY ---
        // Search for users based on the active tab (Visitor, Admin, Student, Faculty)
        $("#searchFaculty").on("keyup", function () {
            const searchQuery = $(this).val().toLowerCase();
            const activeTab = $(".tab-button.border-indigo-500").attr('id');  // Get the active tab's id
            loadUsers(searchQuery, activeTab);  // Load users based on search query and active tab
        });

        // Function to load data for different tables based on the tab
        function loadUsers(query = "", activeTab = 'tab-visitor') {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetFaculty`, // Adjust URL as needed
                type: "GET",
                dataType: "json",
                success: function (res) {
                    if (res.status !== 1) return;

                    // Empty the tables before adding new rows
                    const visitorTbody = $("#visitorTableBody").empty();
                    const adminTbody = $("#adminTableBody").empty();
                    const studentTbody = $("#studentTableBody").empty();
                    const facultyTbody = $("#facultyTableBody").empty();

                    const q = query.toLowerCase();

                    res.data
                        .filter(user => user.account_status !== 'Pending' && user.account_status !== 'Declined') // Exclude pending/declined
                        .filter(user => {
                            // Search in relevant fields (firstname, lastname, email, etc.)
                            const personalDetails = JSON.parse(user.personal_details);
                            const authData = JSON.parse(user.authentication_data);

                            return [
                                personalDetails.firstname,
                                personalDetails.lastname,
                                authData.email,
                                personalDetails.department,
                                personalDetails.course,
                                authData.user_role
                            ].some(field => field.toLowerCase().includes(q)); // Check if any field matches query
                        })
                        .forEach((user, index) => {
                            const personalDetails = JSON.parse(user.personal_details);
                            const authData = JSON.parse(user.authentication_data);

                            const row = `
                        <tr data-id="${user.user_id}">
                            <td class="px-4 py-2">${index + 1}</td>
                            <td class="px-4 py-2">${personalDetails.firstname} ${personalDetails.middlename} ${personalDetails.lastname}</td>
                            <td class="px-4 py-2">${authData.email}</td>
                            <td class="px-4 py-2">${personalDetails.department || personalDetails.course}</td>
                            <td class="px-2 py-2 text-center flex justify-center gap-1">
                                <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                            </td>
                        </tr>`;

                            // Append rows to corresponding tables based on user role
                            const role = authData.user_role;
                            if (role === 'visitor') {
                                visitorTbody.append(row);  // Visitor Table
                            } else if (role === 'admin') {
                                adminTbody.append(row);  // Admin Table
                            } else if (role === 'student') {
                                studentTbody.append(row);  // Student Table
                            } else if (role === 'faculty') {
                                facultyTbody.append(row);  // Faculty Table
                            }
                        });
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Load the users initially for the visitor tab (or any other tab as needed)
        loadUsers();

        // --- HANDLE USER ACTIONS (VIEW, EDIT, DELETE) ---
        $(document).on("click", ".view-btn, .edit-btn, .delete-btn", function () {
            const tr = $(this).closest("tr");
            const userId = tr.data("id");

            if ($(this).hasClass("view-btn")) {
                viewUser(userId);
            } else if ($(this).hasClass("edit-btn")) {
                editUser(userId);
            } else if ($(this).hasClass("delete-btn")) {
                deleteUser(userId, tr);
            }
        });

        // View User Details (example)
        function viewUser(userId) {
            // You can load user details in a modal or a dedicated view section
            alert(`Viewing user with ID: ${userId}`);
        }

        // Edit User (example)
        function editUser(userId) {
            // You can open a modal or form to edit user details
            alert(`Editing user with ID: ${userId}`);
        }

        // Delete User (example)
        function deleteUser(userId, tr) {
            if (!confirm("Are you sure you want to delete this user?")) return;
            // Send a request to delete the user
            $.post(`${base_url}auth/action.php?action=DeleteUser`, { user_id: userId }, function (res) {
                if (res.status === 1) {
                    alert(res.message);
                    tr.remove();
                } else {
                    alert(res.message);
                }
            }, "json");
        }
    });


</script>