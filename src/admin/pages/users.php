<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    User Management Overview
</h1>
<!-- Tabs for Adding Accounts / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
        <!-- <button id="tab-dashboard"
            class="tab-button border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            User Dashboard
        </button> -->
        <button id="tab-faculty"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Add New Faculty
        </button>
        <button id="tab-student"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Add New Student
        </button>
        <button id="tab-student-table"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Student Table
        </button>
        <button id="tab-teacher-table"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Teacher Table
        </button>
    </nav>
</div>

<!-- Tab Contents -->
<div id="tab-content">
    <!-- Dashboard -->
    <div id="dashboard-content" class="tab-panel">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">4,289</p>
                <p class="text-xs text-green-500 mt-2">↑ 12.5% this month</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-emerald-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Registrations</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">1,024</p>
                <p class="text-xs text-red-500 mt-2">↓ 3.1% this month</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Verifications</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">14</p>
                <p class="text-xs text-yellow-500 mt-2">Last updated 5 mins ago</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Issues</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">3</p>
                <p class="text-xs text-red-500 mt-2">Action required</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Recent User Activity</h2>
            <div class="space-y-3">
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    User JohnDoe logged in successfully.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">2 min ago</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    New user JaneSmith registered.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">1 hour ago</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    Account verification completed for user MikeBrown.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">3 hours ago</span>
                </p>
            </div>
        </div>

        <div class="mt-12 p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">Extended User Management Tools</p>
            <p class="mt-4 text-gray-500 dark:text-gray-400">
                Use this section for user reports, role management, or activity charts.
            </p>
            <div
                class="h-[60vh] bg-gray-50 dark:bg-gray-700 mt-4 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm border-2 border-dashed dark:border-gray-600">
                Placeholder for User Charts/Tables
            </div>
        </div>
    </div>

    <!-- Faculty Form -->
    <div id="faculty-content" class="tab-panel hidden">
        <form id="facultyForm" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
            <h2 class="text-xl font-semibold mb-1 text-gray-800 dark:text-gray-100 text-center">Add New Faculty</h2>

            <!-- Message container -->
            <div id="facultyFormMessage" class="m-2 text-center  px-4 py-1 rounded"></div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <!-- Profile Picture Preview -->
                <div class="col-span-1 flex flex-col items-center md:col-span-1">
                    <label class="mb-2 text-gray-700 dark:text-gray-200">Profile Picture</label>
                    <div class="w-32 h-32 mb-2">
                        <img id="profilePreview" src="https://via.placeholder.com/150" alt="Profile Preview"
                            class="w-full h-full object-cover rounded-full border border-gray-300">
                    </div>
                    <input type="file" name="profile_pic" id="profile_pic"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                </div>

                <!-- Personal & Account Info -->
                <div class="col-span-1 md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="firstname" placeholder="First Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="text" name="lastname" placeholder="Last Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="email" name="email" placeholder="Email"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <select name="department" class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">Select Department</option>
                        <option value="CTE">CTE</option>
                        <option value="CICS">CICS</option>
                        <option value="ITE">ITE</option>
                        <option value="SBC">SBC</option>
                        <option value="BSMT">BSMT</option>
                        <option value="CAHS">CAHS</option>
                        <option value="CET">CET</option>
                        <option value="SHS">SHS</option>
                    </select>
                    <input type="text" name="username" placeholder="Username / Student ID"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="password" name="password" placeholder="Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <select name="user_role" class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">Select User Access</option>
                        <option value="librarian">Librarian</option>
                        <option value="faculty">Faculty</option>
                        <option value="student">Student</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit"
                    class="bg-indigo-500 text-white px-6 py-2 rounded-md hover:bg-indigo-600 transition duration-200">
                    Add Faculty
                </button>
            </div>
        </form>


        <script>
            // Profile picture preview
            document.getElementById('profile_pic').addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('profilePreview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>

    <!-- Student Form -->
    <div id="student-content" class="tab-panel hidden">
        <form id="studentForm" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 text-center">Add New Student</h2>
            <div id="studentFormMessage" class="m-2 text-center  px-4 py-1 rounded"></div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <!-- Profile Picture Preview -->
                <div class="col-span-1 flex flex-col items-center md:col-span-1">
                    <label class="mb-2 text-gray-700 dark:text-gray-200">Profile Picture</label>
                    <div class="w-32 h-32 mb-2">
                        <img id="studentProfilePreview" src="https://via.placeholder.com/150" alt="Profile Preview"
                            class="w-full h-full object-cover rounded-full border border-gray-300">
                    </div>
                    <input type="file" name="profile_pic" id="studentProfilePic"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                </div>

                <!-- Personal & Account Info -->
                <div class="col-span-1 md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="firstname" placeholder="First Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="text" name="lastname" placeholder="Last Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="email" name="email" placeholder="Email"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="text" name="username" placeholder="Username / Student ID"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="password" name="password" placeholder="Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">

                    <!-- Course / Program select dropdown -->
                    <select name="course" class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">Select Course / Program</option>
                        <option value="bsc_computer_science">BSc Computer Science</option>
                        <option value="bsc_mathematics">BSc Mathematics</option>
                        <option value="bsc_physics">BSc Physics</option>
                        <option value="bsc_chemistry">BSc Chemistry</option>
                        <option value="bsc_biology">BSc Biology</option>
                    </select>

                    <!-- Department select dropdown -->
                    <select name="department" class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">Select Department</option>
                        <option value="CTE">CTE</option>
                        <option value="CICS">CICS</option>
                        <option value="ITE">ITE</option>
                        <option value="SBC">SBC</option>
                        <option value="BSMT">BSMT</option>
                        <option value="CAHS">CAHS</option>
                        <option value="CET">CET</option>
                        <option value="SHS">SHS</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-md hover:bg-emerald-600">
                    Add Student
                </button>
            </div>
        </form>


        <!-- Optional message div -->

        <script>
            // Preview selected profile picture
            document.getElementById('studentProfilePic').addEventListener('change', function (e) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('studentProfilePreview').src = event.target.result;
                };
                if (this.files[0]) reader.readAsDataURL(this.files[0]);
            });
        </script>


    </div>

    <!-- Student Table -->
    <div id="student-table-content" class="tab-panel hidden">
        <table
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
                        Course</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="studentTableBody">


            </tbody>
        </table>
    </div>

    <!-- Teacher Table -->
    <div id="teacher-table-content" class="tab-panel hidden">
        <table
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
                        Department</th>
                    <th
                        class="px-1 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="teacherTableBody">
            </tbody>
        </table>
    </div>

</div>

<!-- jQuery Tab Script -->
<script>
    $(document).ready(function () {
        function activateTab(tabId, contentId) {
            $('.tab-panel').addClass('hidden');
            $('.tab-button').removeClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .addClass('border-transparent text-gray-500 dark:text-gray-400');
            $(contentId).removeClass('hidden');
            $(tabId).addClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .removeClass('border-transparent text-gray-500 dark:text-gray-400');
        }

        // Initial tab
        activateTab('#tab-faculty', '#faculty-content');

        // $('#tab-dashboard').click(function () { activateTab('#tab-dashboard', '#dashboard-content'); });
        $('#tab-faculty').click(function () { activateTab('#tab-faculty', '#faculty-content'); });
        $('#tab-student').click(function () { activateTab('#tab-student', '#student-content'); });
        $('#tab-student-table').click(function () { activateTab('#tab-student-table', '#student-table-content'); });
        $('#tab-teacher-table').click(function () { activateTab('#tab-teacher-table', '#teacher-table-content'); });


        loadFaculty();
        function loadFaculty() {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetFaculty`,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === 1) {
                        const tbody = $("#teacherTableBody");
                        tbody.empty();
                        response.data.forEach((faculty, index) => {
                            tbody.append(`
                        <tr class="text-white" data-id="${faculty.user_id}">
                            <td class="px-4 py-2">${index + 1}</td>
                            <td class="px-4 py-2">${faculty.firstname} ${faculty.lastname}</td>
                            <td class="px-4 py-2">${faculty.email}</td>
                            <td class="px-4 py-2">${faculty.department}</td>
                            <td class="px-2 py-2 text-center space-x-1">
                                <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                            </td>
                        </tr>
                    `);
                        });
                    }
                },
                error: function (xhr) { console.error(xhr.responseText); }
            });
        }

        /* FACULTY */
        $("#facultyForm").on("submit", function (e) {
            e.preventDefault();
            const $form = $(this);
            const faculty_details = {};
            let filesProcessed = 0;
            const fileInputs = $form.find("input[type=file]");
            const totalFiles = fileInputs.length;

            function sendIfReady() {
                if (filesProcessed >= totalFiles) {
                    // Send faculty_details as JSON
                    $.ajax({
                        url: `${base_url}auth/action.php?action=Regfaculty`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(faculty_details),
                        dataType: "json",
                        beforeSend: function () {
                            $form.find("button[type=submit]").prop("disabled", true).text("Saving...");
                            // Hide previous messages
                            $("#facultyFormMessage").addClass("hidden").removeClass("bg-green-100 text-green-800 bg-red-100 text-red-800").text("");
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                $("#facultyFormMessage")
                                    .removeClass("hidden bg-red-100 text-red-800")
                                    .addClass("bg-green-100 text-green-800")
                                    .text(response.message || "Faculty added successfully!");

                                // Reset form and preview image
                                $form[0].reset();
                                $("#profilePreview").attr("src", "https://via.placeholder.com/150");

                                // Reload faculty table
                                loadFaculty();

                                // Optional redirect
                                if (response.url) {
                                    setTimeout(() => {
                                        window.location.href = response.url;
                                    }, 2000);
                                }
                            } else {
                                $("#facultyFormMessage")
                                    .removeClass("hidden bg-green-100 text-green-800")
                                    .addClass("bg-red-100 text-red-800")
                                    .text(response.message || "Error: Unable to add faculty.");
                            }
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            $("#facultyFormMessage")
                                .removeClass("hidden bg-green-100 text-green-800")
                                .addClass("bg-red-100 text-red-800")
                                .text("Error: Something went wrong. Check console for details.");
                        },
                        complete: function () {
                            $form.find("button[type=submit]").prop("disabled", false).text("Add Faculty");
                        }
                    });
                }
            }

            // Convert file inputs to Base64
            fileInputs.each(function () {
                const inputName = $(this).attr("name");
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        faculty_details[inputName] = e.target.result; // Base64 string
                        filesProcessed++;
                        sendIfReady();
                    };
                    reader.readAsDataURL(file); // Converts to Base64
                } else {
                    faculty_details[inputName] = null;
                    filesProcessed++;
                    sendIfReady();
                }
            });

            // Handle non-file inputs
            $form.find("input:not([type=file]), select").each(function () {
                const name = $(this).attr("name");
                if (!name) return;
                faculty_details[name] = $(this).val().trim() || "";
            });

            // If no file inputs, send immediately
            if (totalFiles === 0) {
                filesProcessed = 1;
                sendIfReady();
            }

            console.log("Faculty payload (Base64 image included):", faculty_details);
        });

        function loadFaculty() {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetFaculty`,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === 1) {
                        const tbody = $("#teacherTableBody");
                        tbody.empty();
                        response.data.forEach((faculty, index) => {
                            if (faculty.user_role == 'faculty') {
                                tbody.append(`
                                <tr class="text-white" data-id="${faculty.user_id}">
                                    <td class="px-4 py-2">${index + 1}</td>
                                    <td class="px-4 py-2">${faculty.firstname} ${faculty.lastname}</td>
                                    <td class="px-4 py-2">${faculty.email}</td>
                                    <td class="px-4 py-2">${faculty.department}</td>
                                    <td class="px-2 py-2 text-center space-x-1">
                                        <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                        <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                        <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                                    </td>
                                </tr>
                            `);
                            } else {
                                const tbody = $("#studentTableBody");
                                tbody.append(`
                                <tr class="text-white" data-id="${faculty.user_id}">
                                    <td class="px-4 py-2">${index + 1}</td>
                                    <td class="px-4 py-2">${faculty.firstname} ${faculty.lastname}</td>
                                    <td class="px-4 py-2">${faculty.email}</td>
                                    <td class="px-4 py-2">${faculty.department}</td>
                                    <td class="px-2 py-2 text-center space-x-1">
                                        <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                        <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                        <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                                    </td>
                                </tr>
                            `);
                            }
                        });
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        /* FACULTY END */

        /* STUDENT */
        $("#studentForm").on("submit", function (e) {
            e.preventDefault();
            const $form = $(this);
            const student_details = {};
            let filesProcessed = 0;
            const fileInputs = $form.find("input[type=file]");
            const totalFiles = fileInputs.length;

            function sendIfReady() {
                if (filesProcessed >= totalFiles) {
                    // Send student_details as JSON
                    $.ajax({
                        url: `${base_url}auth/action.php?action=Regstudent`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(student_details),
                        dataType: "json",
                        beforeSend: function () {
                            $form.find("button[type=submit]").prop("disabled", true).text("Saving...");
                            $("#studentFormMessage").addClass("hidden")
                                .removeClass("bg-green-100 text-green-800 bg-red-100 text-red-800")
                                .text("");
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                $("#studentFormMessage")
                                    .removeClass("hidden bg-red-100 text-red-800")
                                    .addClass("bg-green-100 text-green-800")
                                    .text(response.message || "Student added successfully!");

                                // Reset form and preview image
                                $form[0].reset();
                                $("#studentProfilePreview").attr("src", "https://via.placeholder.com/150");

                                loadFaculty();

                            } else {
                                $("#studentFormMessage")
                                    .removeClass("hidden bg-green-100 text-green-800")
                                    .addClass("bg-red-100 text-red-800")
                                    .text(response.message || "Error: Unable to add student.");
                            }
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            $("#studentFormMessage")
                                .removeClass("hidden bg-green-100 text-green-800")
                                .addClass("bg-red-100 text-red-800")
                                .text("Error: Something went wrong. Check console for details.");
                        },
                        complete: function () {
                            $form.find("button[type=submit]").prop("disabled", false).text("Add Student");
                        }
                    });
                }
            }

            // Convert file inputs to Base64
            fileInputs.each(function () {
                const inputName = $(this).attr("name");
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        student_details[inputName] = e.target.result; // Base64 string
                        filesProcessed++;
                        sendIfReady();
                    };
                    reader.readAsDataURL(file); // Converts to Base64
                } else {
                    student_details[inputName] = null; // No file, set null
                    filesProcessed++;
                    sendIfReady();
                }
            });

            // Handle non-file inputs
            $form.find("input:not([type=file]), select").each(function () {
                const name = $(this).attr("name");
                if (!name) return;
                student_details[name] = $(this).val().trim() || "";
            });

            // If no file inputs, send immediately
            if (totalFiles === 0) {
                filesProcessed = 1; // No files to process
                sendIfReady();
            }

            console.log("Student payload (Base64 image included):", student_details);
        });
        /* END STUDENT */

    });
</script>