<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    User Management Overview
</h1>
<!-- Tabs for Adding Accounts / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
        <button id="tab-dashboard"
            class="tab-button border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            User Dashboard
        </button>
        <button id="tab-faculty"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Add New Account
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
    <div id="user-content" class="tab-panel">
        <form id="userForm" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg max-w-5xl mx-auto"
            enctype="multipart/form-data">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 text-center">
                Add New User
            </h2>

            <div id="userFormMessage" class="m-2 text-center px-4 py-1 rounded"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

                <!-- Profile Picture -->
                <div class="flex flex-col items-center col-span-1">
                    <label class="mb-2 text-gray-700 dark:text-gray-200 font-semibold">Profile Picture</label>
                    <div class="w-32 h-32 mb-3">
                        <img id="userProfilePreview" src=""
                            class="w-full h-full object-cover rounded-full border border-gray-300 shadow">
                    </div>
                    <input type="file" name="profile_pic" id="userProfilePic"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full">
                </div>

                <!-- Form Fields -->
                <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Role -->
                    <div class="md:col-span-2">
                        <label class="text-gray-700 dark:text-gray-200 font-semibold">User Role</label>
                        <select id="userRole" name="user_role"
                            class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                            <option value="">Select User Type</option>
                            <option value="faculty">Faculty</option>
                            <option value="student">Student</option>
                        </select>
                    </div>

                    <!-- Basic Info -->
                    <input name="firstname" type="text" placeholder="First Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                    <input name="lastname" type="text" placeholder="Last Name"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                    <input name="email" type="email" placeholder="Email"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                    <input name="username" type="text" placeholder="Username / Student ID"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                    <input name="password" type="password" placeholder="Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                    <input name="confirm_password" type="password" placeholder="Confirm Password"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">

                    <!-- Optional Info (Shown dynamically) -->
                    <input name="birthdate" type="date" id="birthdateField"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                    <select name="gender" id="genderField"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <input name="phone" type="text" id="phoneField" placeholder="Contact Number"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                    <input name="address" type="text" id="addressField" placeholder="Address"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">

                    <!-- Faculty ONLY -->
                    <input name="position" type="text" id="positionField" placeholder="Faculty Position"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">

                    <!-- Student ONLY -->
                    <select id="departmentField" name="department"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
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

                    <select id="courseField" name="course"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                        <option value="">Select Course / Program</option>
                        <option value="bsc_computer_science">BSc Computer Science</option>
                        <option value="bsc_mathematics">BSc Mathematics</option>
                        <option value="bsc_physics">BSc Physics</option>
                        <option value="bsc_chemistry">BSc Chemistry</option>
                        <option value="bsc_biology">BSc Biology</option>
                    </select>

                    <select id="yearField" name="year_level"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                        <option value="">Select Year Level</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>

                    <input name="section" type="text" id="sectionField" placeholder="Section"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 hidden">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit"
                    class="bg-indigo-500 text-white px-6 py-2 rounded-md hover:bg-indigo-600 transition duration-300">
                    Add User
                </button>
            </div>
        </form>
    </div>

    <script>
        const roleFields = {
            common: ["birthdateField", "genderField", "phoneField", "addressField"],
            faculty: ["departmentField", "positionField"],
            student: ["departmentField", "courseField", "yearField", "sectionField"]
        };

        document.getElementById("userRole").addEventListener("change", function () {
            const role = this.value;

            // Hide all optional fields
            Object.values(roleFields).flat().forEach(id => document.getElementById(id).classList.add("hidden"));

            // Show common + role-specific fields
            roleFields.common.forEach(id => document.getElementById(id).classList.remove("hidden"));
            if (role && roleFields[role]) roleFields[role].forEach(id => document.getElementById(id).classList.remove("hidden"));
        });

        // Profile Preview
        const profileInput = document.getElementById('userProfilePic');
        const profilePreview = document.getElementById('userProfilePreview');
        profileInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => profilePreview.src = e.target.result;
            reader.readAsDataURL(file);
        });
    </script>



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

    <!-- View info tab -->
    <div id="view-content" class="tab-panel hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-6xl mx-auto">
            <!-- Back Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                    Profile Overview
                </h2>
                <button id="closeViewBtn"
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Back
                </button>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column: Profile -->
                <div class="flex flex-col items-center bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-md">
                    <img id="viewProfilePic" src="" alt="Profile Picture"
                        class="w-36 h-36 rounded-full object-cover border-4 border-indigo-500 shadow-lg" />
                    <h2 id="viewFullname" class="text-2xl font-semibold mt-4 text-gray-800 dark:text-gray-100">
                        Manuel Daligdig
                    </h2>
                    <p id="viewRole"
                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">
                        Student
                    </p>

                    <div class="w-full mt-6 space-y-3 text-gray-700 dark:text-gray-200 text-left">
                        <div>
                            <label class="font-semibold block text-sm text-gray-500 dark:text-gray-400">Email</label>
                            <p id="viewEmail" class="text-base break-all">
                                daligdig.manuel19@gmail.com
                            </p>
                        </div>
                        <div>
                            <label class="font-semibold block text-sm text-gray-500 dark:text-gray-400">Username</label>
                            <p id="viewUsername" class="text-base">manuel</p>
                        </div>
                        <div>
                            <label class="font-semibold block text-sm text-gray-500 dark:text-gray-400">Course</label>
                            <p id="viewCourse" class="text-base uppercase">BSC Physics</p>
                        </div>
                        <div>
                            <label
                                class="font-semibold block text-sm text-gray-500 dark:text-gray-400">Department</label>
                            <p id="viewDepartment" class="text-base uppercase">CICS</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Activities -->
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 text-center">
                        Recent Activities
                    </h2>
                    <div class="space-y-3">
                        <p class="text-sm text-gray-700 dark:text-gray-300 border-b dark:border-gray-600 pb-2">
                            Book 1
                            <span class="float-right text-xs text-gray-500 dark:text-gray-400">2 min ago</span>
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 border-b dark:border-gray-600 pb-2">
                            Book 2
                            <span class="float-right text-xs text-gray-500 dark:text-gray-400">1 hour ago</span>
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 border-b dark:border-gray-600 pb-2">
                            Book 3
                            <span class="float-right text-xs text-gray-500 dark:text-gray-400">3 hours ago</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- jQuery Tab Script -->
<script>
    $(document).ready(function () {
        function activateTab(tabId, contentId) {
            $('.tab-panel').addClass('hidden');
            $('.tab-button').removeClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .addClass('border-transparent  dark:text-gray-400');

            $(contentId).removeClass('hidden');
            $(tabId).addClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .removeClass('border-transparent  dark:text-gray-400');

        }

        // Initial tab
        activateTab('#tab-dashboard', '#dashboard-content');
        $('#closeViewBtn').on('click', function () {
            $('#view-content').addClass('hidden');
            $('.tab-panel').removeClass('hidden');

        });

        $('#tab-dashboard').click(function () { activateTab('#tab-dashboard', '#dashboard-content'); });
        $('#tab-faculty').click(function () { activateTab('#tab-faculty', '#user-content'); });
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
                                        <button id="view-btn-${faculty.user_id}" class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                        <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                        <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                                    </td>
                                </tr>
                            `);
                            } else {
                                const tbody = $("#studentTableBody");
                                tbody.empty();
                                tbody.append(`
                                <tr class="text-white" data-id="${faculty.user_id}">
                                    <td class="px-4 py-2">${index + 1}</td>
                                    <td class="px-4 py-2">${faculty.firstname} ${faculty.lastname}</td>
                                    <td class="px-4 py-2">${faculty.email}</td>
                                    <td class="px-4 py-2">${faculty.department}</td>
                                    <td class="px-2 py-2 text-center space-x-1">
                                        <button id="view-btn-${faculty.user_id}" class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
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
        $(document).on("click", ".view-btn, .edit-btn, .delete-btn", function () {
            const tr = $(this).closest("tr");
            const userId = tr.data("id");

            if ($(this).hasClass("view-btn")) {

                activateTab(`#view-btn-${userId}`, `#view-content`);


                $.ajax({
                    url: `${base_url}auth/action.php?action=GetUser`,
                    type: "POST",
                    data: {
                        action: 'GetFaculty',
                        user_id: userId
                    },
                    dataType: "json",

                    success: function (res) {
                        if (res.status === 1) {
                            $("#viewFullname").text(res.data.firstname + " " + res.data.lastname);
                            $("#viewEmail").text(res.data.email);
                            $("#viewUsername").text(res.data.username);
                            $("#viewDepartment").text(res.data.department);
                            $("#viewCourse").text(res.data.course);
                            $("#viewRole").text(res.data.user_role);

                            if (res.data.profile_pic) {
                                $("#viewProfilePic").attr("src", base_url + "auth/" + res.data.profile_pic);
                            }

                        } else {
                            alert(res.message);
                        }
                    },
                    error: function () { alert("Server error"); }
                });
            } else if ($(this).hasClass("edit-btn")) {
                $.ajax({
                    url: `${base_url}auth/action.php?action=GetUser`,
                    type: "POST",
                    data: {
                        action: 'EditUser',
                        user_id: userId
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === 1) {
                            const form = $("#editForm");
                            form.find("input[name='user_id']").val(res.data.user_id);
                            form.find("input[name='firstname']").val(res.data.firstname);
                            form.find("input[name='lastname']").val(res.data.lastname);
                            form.find("input[name='email']").val(res.data.email);
                            form.find("input[name='department']").val(res.data.department);
                            $("#editModal").fadeIn(200);
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function () { alert("Server error"); }
                });
            } else if ($(this).hasClass("delete-btn")) {
                if (!confirm("Are you sure you want to delete this user?")) return;
                $.ajax({
                    url: `${base_url}auth/action.php?action=GetUser`,
                    type: "POST",
                    data: {
                        action: 'DeleteUser',
                        user_id: userId
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === 1) {
                            alert(res.message);
                            tr.remove();
                            loadFaculty();

                        } else alert(res.message);
                    },
                    error: function () { alert("Server error"); }
                });
            }
        });

        $('#userForm').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form); // includes files automatically
            const userRole = $('#userRole').val();

            if (!userRole) {
                $('#userFormMessage').addClass('text-red-500').text('Please select a user role').removeClass('hidden');
                return;
            }

            formData.set('user_role', userRole);

            $.ajax({
                url: `${base_url}auth/action.php?action=register_user`,
                type: 'POST',
                data: formData,
                processData: false, // do not process FormData
                contentType: false, // set by browser
                success: function (res) {
                    let data;
                    try {
                        data = typeof res === 'string' ? JSON.parse(res) : res;
                    } catch (err) {
                        $('#userFormMessage').addClass('text-red-500').text('Unexpected server response').removeClass('hidden');
                        return;
                    }

                    const msgEl = $('#userFormMessage');
                    msgEl.removeClass('text-red-500 text-green-500 hidden');

                    if (data.status === 1) {
                        msgEl.addClass('text-green-500').text(data.message).removeClass('hidden');
                        form.reset();
                        $('#userProfilePreview').attr('src', 'https://via.placeholder.com/150');

                        // Hide all role-specific fields
                        ['birthdateField', 'genderField', 'phoneField', 'addressField', 'departmentField', 'positionField', 'courseField', 'yearField', 'sectionField'].forEach(id => {
                            $('#' + id).addClass('hidden');
                        });
                    } else {
                        msgEl.addClass('text-red-500').text(data.message).removeClass('hidden');
                    }
                },
                error: function () {
                    $('#userFormMessage').addClass('text-red-500').text('Failed to connect to server').removeClass('hidden');
                }
            });
        });


    });
</script>