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
    <div id="user-content"
        class="tab-panel flex flex-col sm:flex-row gap-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">

        <!-- LEFT: Profile Upload -->
        <div
            class="flex flex-col items-center justify-center w-full sm:w-[35%] border-r border-[#b03060]/40 dark:border-[#800000]/40 pr-4">
            <div
                class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-[#b03060] dark:border-[#800000]">
                <img id="profile-preview" src="../../assets/default-profile.png" alt="Profile Preview"
                    class="w-full h-full object-cover">
            </div>
            <label for="profile"
                class="mt-3 cursor-pointer text-sm font-semibold text-[#b03060] dark:text-[#ff4d6d] hover:underline">
                Upload Profile
            </label>
            <input type="file" name="profile" id="profile" accept="image/*" class="hidden">
            <p class="mt-2 text-xs text-[#800000] dark:text-[#ffcccc]">JPG, PNG under 2MB</p>
        </div>

        <!-- RIGHT: Registration Form -->
        <div class="flex-1">
            <h3 class="text-2xl font-bold text-center mb-4 text-[#b03060] dark:text-[#ff4d6d]">
                <i data-lucide="user-plus" class="inline-block w-4 h-4 mr-1 align-text-bottom"></i> Campus Registration
            </h3>

            <form id="register" class="space-y-4" enctype="multipart/form-data">
                <!-- Role Selector -->
                <div class="flex gap-6 justify-center mb-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="role" value="student" class="accent-[#b03060]" checked> Student
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="role" value="faculty" class="accent-[#b03060]"> Faculty
                    </label>
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="firstname" placeholder="First Name" required
                        class="input-field rounded-lg py-3 p-2">
                    <input type="text" name="lastname" placeholder="Last Name" required
                        class="input-field rounded-lg py-3 p-2">
                    <input type="text" name="middlename" placeholder="Middle Name"
                        class="input-field rounded-lg py-3 p-2">
                    <input type="text" name="suffix" placeholder="Suffix (e.g. Jr., III)"
                        class="input-field rounded-lg py-3 p-2">
                </div>

                <!-- Department -->
                <input type="text" name="department" placeholder="Department" required
                    class="input-field rounded-lg py-3 p-2 w-full">

                <!-- Student Section -->
                <div id="student-fields" class="space-y-3">
                    <input type="text" name="student_id" placeholder="Student ID"
                        class="input-field rounded-lg py-3 p-2 w-full">
                    <input type="text" name="section" placeholder="Section"
                        class="input-field rounded-lg py-3 p-2 w-full">
                </div>

                <!-- Faculty Section -->
                <div id="faculty-fields" class="hidden space-y-3">
                    <input type="text" name="employee_id" placeholder="Employee ID"
                        class="input-field rounded-lg py-3 p-2 w-full">
                </div>

                <!-- Email & Username -->
                <div class="grid grid-cols-2 gap-3">
                    <input type="email" name="email" placeholder="Email" required
                        class="input-field rounded-lg py-3 p-2">
                    <input type="text" name="username" placeholder="Username" required
                        class="input-field rounded-lg py-3 p-2">
                </div>

                <!-- Password -->
                <div class="grid grid-cols-2 gap-3">
                    <input type="password" name="password" placeholder="Password" required
                        class="input-field rounded-lg py-3 p-2">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required
                        class="input-field rounded-lg py-3 p-2">
                </div>

                <!-- Message -->
                <p id="register-message" class="text-sm text-red-500 hidden"></p>

                <!-- Buttons -->
                <button type="submit"
                    class="w-full bg-[#b03060] text-white font-semibold py-3 rounded-lg hover:bg-[#800000] transition transform hover:scale-[1.01]">
                    Register Account
                </button>
            </form>
        </div>
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

                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 text-center mb-6">
                        Recent Activity
                    </h2>

                    <!-- Read Logs Section -->
                    <div class="mb-4">
                        <h3
                            class="text-md text-end font-semibold text-gray-700 dark:text-gray-200 mb-3 border-b dark:border-gray-600 pb-1">
                            Read Logs
                        </h3>

                        <div id="book_logs" class="space-y-3">
                            <p class="text-sm text-gray-700 dark:text-gray-300 border-b dark:border-gray-600 pb-2">
                                Book 1
                                <span class="float-right text-xs text-gray-500 dark:text-gray-400">
                                    2 min ago
                                </span>
                            </p>
                        </div>
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
                        const facultyTbody = $("#teacherTableBody");
                        const studentTbody = $("#studentTableBody");

                        // Clear tables once before appending
                        facultyTbody.empty();
                        studentTbody.empty();

                        response.data.forEach((user, index) => {
                            const row = `
                        <tr class="text-white" data-id="${user.user_id}">
                            <td class="px-4 py-2">${index + 1}</td>
                            <td class="px-4 py-2">${user.firstname} ${user.lastname}</td>
                            <td class="px-4 py-2">${user.email}</td>
                            <td class="px-4 py-2">${user.department}</td>
                            <td class="px-2 py-2 text-center space-x-1">
                                <button id="view-btn-${user.user_id}" class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                                <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                            </td>
                        </tr>
                    `;

                            if (user.user_role === 'faculty') {
                                facultyTbody.append(row);
                            } else if (user.user_role === 'student') {
                                studentTbody.append(row);
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
                            } else {
                                $("#viewProfilePic").attr("src", base_url + "assets/default-profile.png");
                            }
                        } else {
                            alert(res.message);
                        }
                        loadFaculty();
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
                        loadFaculty();
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
                        loadFaculty();
                    },
                    error: function () { alert("Server error"); }
                });
            }
        });



        const studentFields = $("#student-fields");
        const facultyFields = $("#faculty-fields");
        const profileInput = $("#profile");
        const profilePreview = $("#profile-preview");
        const registerMessage = $("#register-message");

        // Toggle student/faculty fields
        $('input[name="role"]').change(function () {
            if ($(this).val() === "student") {
                studentFields.removeClass("hidden");
                facultyFields.addClass("hidden");
            } else {
                facultyFields.removeClass("hidden");
                studentFields.addClass("hidden");
            }
        });

        // Profile preview
        profileInput.on('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                profilePreview.attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        });

        // Register form submission
        $("#register").submit(function (e) {
            e.preventDefault();

            const role = $('input[name="role"]:checked').val();
            const formData = {
                role: role,
                firstname: $("input[name='firstname']").val(),
                lastname: $("input[name='lastname']").val(),
                middlename: $("input[name='middlename']").val(),
                suffix: $("input[name='suffix']").val(),
                department: $("input[name='department']").val(),
                email: $("input[name='email']").val(),
                username: $("input[name='username']").val(),
                password: $("input[name='password']").val(),
                confirm_password: $("input[name='confirm_password']").val(),
                profile_pic: ""
            };

            // Add role-specific fields
            if (role === "student") {
                formData.student_id = $("input[name='student_id']").val();
                formData.section = $("input[name='section']").val();
            } else {
                formData.employee_id = $("input[name='employee_id']").val();
            }

            // Password confirmation check
            if (formData.password !== formData.confirm_password) {
                registerMessage.text("Passwords do not match")
                    .removeClass("hidden text-green-500")
                    .addClass("text-red-500");
                return;
            }

            // Convert profile image to Base64 if selected
            if (profileInput[0].files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    formData.profile_pic = e.target.result;
                    sendAjax(formData);
                }
                reader.readAsDataURL(profileInput[0].files[0]);
            } else {
                sendAjax(formData);
            }
        });

        function sendAjax(data) {
            $.ajax({
                url: `${base_url}auth/action.php?action=register_user`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: 'json',
                success: function (result) {
                    registerMessage.text(result.message).removeClass("hidden");
                    if (result.status === 1) {
                        registerMessage.removeClass("text-red-500").addClass("text-green-500");
                        $("#register")[0].reset();
                        profilePreview.attr("src", "../../assets/default-profile.png");
                        studentFields.removeClass("hidden");
                        facultyFields.addClass("hidden");
                    } else {
                        registerMessage.removeClass("text-green-500").addClass("text-red-500");
                    }
                    loadFaculty();
                },
                error: function () {
                    registerMessage.text("An error occurred. Please try again.")
                        .removeClass("hidden text-green-500")
                        .addClass("text-red-500");
                }
            });
        }
    });
</script>