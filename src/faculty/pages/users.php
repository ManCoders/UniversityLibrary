<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    User Management Overview
</h1>
<!-- Tabs for Adding Accounts / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center">
        <!-- Tabs -->
        <nav class="flex space-x-4" aria-label="Tabs">
            <!-- <button id="tab-dashboard"
                class="tab-button border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                User Dashboard
            </button> -->
            <button id="tab-faculty"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Account Request
            </button>
            <button id="tab-student-table"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Student Table
            </button>
            <button id="tab-teacher-table"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Faculty Table
            </button>
            <button id="tab-request-table"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Acccount Approval
            </button>
        </nav>

        <div class="flex items-center">
            <input id="searchFaculty" type="text" placeholder="Search user"
                class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

    </div>
</div>


<!-- Tab Contents -->
<div id="tab-content">
    <div id="user-content"
        class="tab-panel flex flex-col sm:flex-row gap-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <!-- LEFT: Profile Upload -->
        <div
            class="flex flex-col items-center justify-center w-full sm:w-[35%] border-r border-[#b03060]/40 dark:border-[#800000]/40 pr-4">
            <div class="relative w-32 h-32 rounded-full overflow-hidden border border-[#b03060] dark:border-[#ff4d6d]">
                <img id="profile-preview" src="../../assets/default-profile.png" alt="Profile Preview"
                    class="w-full h-full object-cover">
            </div>
            <label for="profile"
                class="mt-3 cursor-pointer text-sm font-semibold text-[#b03060] dark:text-[#ff4d6d] hover:underline">
                Upload Profile
            </label>
            <input type="file" name="profile" id="profile" accept="image/*" class="hidden" required>
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
                        class="input-field border  rounded-lg py-3 p-2">
                    <input type="text" name="lastname" placeholder="Last Name" required
                        class="input-field border rounded-lg py-3 p-2">
                    <input type="text" name="middlename" placeholder="Middle Name"
                        class="input-field border rounded-lg py-3 p-2">
                    <input type="text" name="suffix" placeholder="Suffix (e.g. Jr., III)"
                        class="input-field border rounded-lg py-3 p-2">
                </div>

                <!-- Department -->
                <input type="text" name="department" placeholder="Department" required
                    class="input-field border rounded-lg py-3 p-2 w-full">

                <!-- Student Section -->
                <div id="student-fields" class="space-y-3">
                    <input type="text" name="student_id" placeholder="Student ID"
                        class="input-field border rounded-lg py-3 p-2 w-full">
                    <input type="text" name="course" placeholder="Course"
                        class="input-field border rounded-lg py-3 p-2 w-full">
                    <input type="text" name="section" placeholder="Section"
                        class="input-field border rounded-lg py-3 p-2 w-full">
                </div>

                <!-- Faculty Section -->
                <div id="faculty-fields" class="hidden space-y-3">
                    <input type="text" name="employee_id" placeholder="Employee ID"
                        class="input-field border rounded-lg py-3 p-2 w-full">
                </div>

                <!-- Email & Username -->
                <div class="grid grid-cols-2 gap-3">
                    <input type="email" name="email" placeholder="Email" required
                        class="input-field border rounded-lg py-3 p-2">
                    <input type="text" name="username" placeholder="Username" required
                        class="input-field border rounded-lg py-3 p-2">
                </div>

                <!-- Password -->
                <div class="grid grid-cols-2 gap-3">
                    <input type="password" name="password" placeholder="Password" required
                        class="input-field border rounded-lg py-3 p-2">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required
                        class="input-field border rounded-lg py-3 p-2">
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
    <div id="approval-table-content" class="tab-panel hidden">
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
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Account Status</th>
                    <th
                        class="px-1 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="approvalTable">
            </tbody>
        </table>
    </div>

    <!-- View info tab -->
    <div id="view-content" class="tab-panel hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                Profile Overview
            </h2>
            <button id="closeViewBtn"
                class="bg-indigo-600 text-white px-6 py-1 rounded-lg hover:bg-indigo-700 transition">
                Back
            </button>
        </div>
        <div class="flex flex-col sm:flex-row gap-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">

            <!-- LEFT: Profile Picture & Status -->
            <div
                class="flex flex-col items-center my-auto justify-start w-full sm:w-[35%] border-r border-[#b03060]/40 dark:border-[#800000]/40 pr-4">
                <div class="relative w-50 h-50 overflow-hidden border border-[#b03060] dark:border-[#ff4d6d]">
                    <img id="viewProfilePic" src="../../assets/default-profile.png" alt="Profile Preview"
                        class="w-full h-full object-cover">
                </div>
                <p id="viewStatus" class="mt-3 text-sm font-bold text-[#b03060] dark:text-[#ff4d6d]">Pending</p>

            </div>

            <!-- RIGHT: Profile Information -->
            <div class="flex-1 flex flex-col gap-4">

                <!-- Name Section -->
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Name</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">First Name</p>
                            <p id="viewfirstname" class="text-gray-800 dark:text-gray-100 font-semibold">John</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last Name</p>
                            <p id="viewlastname" class="text-gray-800 dark:text-gray-100 font-semibold">Doe</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Middle Name</p>
                            <p id="viewmiddlename" class="text-gray-800 dark:text-gray-100 font-semibold">Michael</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Suffix</p>
                            <p id="viewsuffix" class="text-gray-800 dark:text-gray-100 font-semibold">Jr.</p>
                        </div>
                    </div>
                </div>

                <!-- Student Info Section -->
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Student Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Department</p>
                            <p id="viewdepartment" class="text-gray-800 dark:text-gray-100 font-semibold">Computer
                                Science
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Student ID</p>
                            <p id="viewstudent_id" class="text-gray-800 dark:text-gray-100 font-semibold">2025001</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Course</p>
                            <p id="viewcourse" class="text-gray-800 dark:text-gray-100 font-semibold">BSIT</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Section</p>
                            <p id="viewsection" class="text -gray-800 dark:text-gray-100 font-semibold">A</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Contact</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p id="viewEmail" class="text-gray-800 dark:text-gray-100 font-semibold">
                                john.doe@example.com</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Username</p>
                            <p id="viewUsername" class="text-gray-800 dark:text-gray-100 font-semibold">johndoe</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <!-- Student Activities Table -->
        <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-6xl mx-auto">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Student Activities</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th
                                class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Book Title
                            </th>
                            <th
                                class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th
                                class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                End Time / Consumed Reading
                            </th>
                            <th
                                class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Remark
                            </th>
                        </tr>
                    </thead>
                    <tbody id="studentActivitiesBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                        
                        <!-- Dynamic rows can be appended via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL OVERLAY -->
    <div id="reviewModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden justify-center items-center z-50">

        <!-- MODAL CONTENT -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-[95%] max-w-4xl p-6 overflow-y-auto max-h-[90vh]">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Review Overview</h2>
                <button id="closeViewBtn"
                    class="bg-indigo-600 text-white px-6 py-1 rounded-lg hover:bg-indigo-700 transition">
                    Back
                </button>
            </div>

            <!-- ORIGINAL CONTENT -->
            <div class="flex flex-col sm:flex-row gap-6">

                <!-- LEFT: Profile Picture & Status -->
                <div
                    class="flex flex-col items-center my-auto justify-start w-full sm:w-[35%] border-r border-[#b03060]/40 dark:border-[#800000]/40 pr-4">
                    <div class="relative w-50 h-50 overflow-hidden border border-[#b03060] dark:border-[#ff4d6d]">
                        <img id="ReviewProfilePic" src="../../assets/default-profile.png" alt="Profile Preview"
                            class="w-full h-full object-cover">
                    </div>
                    <p id="viewStatus" class="mt-3 text-sm font-bold text-[#b03060] dark:text-[#ff4d6d]">Pending</p>

                </div>

                <!-- RIGHT CONTENT (unchanged from yours) -->
                <div class="flex-1 flex flex-col gap-4">
                    <!-- Name Section -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Complete Name</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <p><span class="text-gray-500 dark:text-gray-400">First Name</span><br><span id="firstname"
                                    class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Last Name</span><br><span id="lastname"
                                    class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Middle Name</span><br><span
                                    id="middlename" class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Suffix</span><br><span id="suffix"
                                    class="font-semibold"></span></p>
                        </div>
                    </div>

                    <!-- Student Info Section -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold mb-2">Student Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <p><span class="text-gray-500 dark:text-gray-400">Department</span><br><span id="department"
                                    class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Student ID</span><br><span id="student_id"
                                    class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Course</span><br><span id="course"
                                    class="font-semibold"></span></p>
                            <p><span class="text-gray-500 dark:text-gray-400">Section</span><br><span id="section"
                                    class="font-semibold"></span></p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h3 class="text-md font-semibold mb-2">Contact</h3>
                        <p><span class="text-gray-500 dark:text-gray-400">Email</span><br><span id="reviewEmail"
                                class="font-semibold"></span></p>
                        <p><span class="text-gray-500 dark:text-gray-400">Username</span><br><span id="reviewUsername"
                                class="font-semibold"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit info tab -->
    <div id="edit-content" class="tab-panel hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-6xl mx-auto w-full">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Update User Information</h2>
                <button id="closeEditBtn"
                    class="bg-indigo-600 text-white px-6 py-1 rounded-lg hover:bg-indigo-700 transition">Back</button>
            </div>

            <form id="updateForm" enctype="multipart/form-data">

                <input type="hidden" name="user_id" id="edit-user_id" value="" />

                <div class="flex flex-col sm:flex-row gap-6">

                    <!-- LEFT: Profile Picture & Upload -->
                    <div
                        class="flex flex-col items-center my-auto sm:w-[35%] bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-md">
                        <div class="relative w-50 h-50  overflow-hidden border-4 border-indigo-500 shadow-lg">
                            <img id="editProfilePreview" src="../../assets/default-profile.png" alt="Profile Picture"
                                class="w-full h-full object-cover">
                        </div>
                        <label for="edit-profile_pic"
                            class="mt-4 text-sm font-medium text-gray-700 dark:text-gray-200">Update Profile
                            Picture</label>
                        <input type="file" name="profile_pic" id="edit-profile_pic"
                            class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    </div>

                    <!-- RIGHT: Editable Form Fields -->
                    <div class="flex-1 flex flex-col gap-4">

                        <!-- Name Section -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Name</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">First Name</label>
                                    <input type="text" name="firstname" id="edit-firstname"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Last Name</label>
                                    <input type="text" name="lastname" id="edit-lastname"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Middle Name</label>
                                    <input type="text" name="middlename" id="edit-middlename"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Suffix</label>
                                    <input type="text" name="suffix" id="edit-suffix"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                            </div>
                        </div>

                        <!-- Student Info Section -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Student Information
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Department</label>
                                    <input type="text" name="department" id="edit-department"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Student ID</label>
                                    <input type="text" name="student_id" id="edit-student_id"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Course</label>
                                    <input type="text" name="course" id="edit-course"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Section</label>
                                    <input type="text" name="section" id="edit-section"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Account Info Section -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Contact & Account
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Email</label>
                                    <input type="email" name="email" id="edit-email"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Username</label>
                                    <input type="text" name="username" id="edit-username"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Role</label>
                                    <select name="user_role" id="edit-user_role"
                                        class="w-full p-2 mt-1 rounded-lg bg-white dark:bg-gray-800 border dark:border-gray-600">
                                        <option value="student">Student</option>
                                        <option value="faculty">Faculty</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Save Button -->
                <div class="text-end mt-6">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Update Changes
                    </button>
                </div>

            </form>
        </div>
    </div>





</div>

<script>
    $(document).ready(function () {
        const studentFields = $("#student-fields");
        const facultyFields = $("#faculty-fields");
        const profilePreview = $("#profile-preview");
        const registerMessage = $("#register-message");

        // --- TAB MANAGEMENT ---
        function activateTab(tabId, contentId) {
            $('.tab-panel').addClass('hidden');
            $('.tab-button')
                .removeClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .addClass('border-transparent dark:text-gray-400');

            $(contentId).removeClass('hidden');
            $(tabId).addClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                .removeClass('border-transparent dark:text-gray-400');
        }

        // Initial tab
        activateTab('#tab-faculty', '#user-content');

        // Close view/edit tabs
        $('#closeViewBtn, #closeEditBtn').click(() => {
            $('#reviewModal').addClass('hidden');
            $('.tab-panel').addClass('hidden');
            activateTab('#tab-faculty', '#user-content');
        });

        // Tab click handlers
        $('#tab-dashboard').click(() => activateTab('#tab-dashboard', '#dashboard-content'));
        $('#tab-faculty').click(() => activateTab('#tab-faculty', '#user-content'));
        $('#tab-student-table').click(() => activateTab('#tab-student-table', '#student-table-content'));
        $('#tab-teacher-table').click(() => activateTab('#tab-teacher-table', '#teacher-table-content'));
        $('#tab-request-table').click(() => activateTab('#tab-request-table', '#approval-table-content'));

        // --- SEARCH & LOAD FACULTY/STUDENT TABLE ---
        $("#searchFaculty").on("keyup", function () { loadUsers($(this).val()); });
        loadUsers();

        function loadUsers(query = "") {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetFaculty`,
                type: "GET",
                dataType: "json",
                success: function (res) {
                    if (res.status !== 1) return;

                    const facultyTbody = $("#teacherTableBody").empty();
                    const studentTbody = $("#studentTableBody").empty();
                    const q = query.toLowerCase();

                    res.data
                        .filter(user => user.account_status !== 'Pending' && user.account_status !== 'Declined') // exclude pending/declined
                        .filter(user =>
                            [user.firstname, user.lastname, user.email, user.department, user.user_role]
                                .some(field => field.toLowerCase().includes(q))
                        )
                        .forEach((user, index) => {
                            const row = `
                    <tr data-id="${user.user_id}">
                        <td class="px-4 py-2">${index + 1}</td>
                        <td class="px-4 py-2">${user.firstname} ${user.middlename} ${user.lastname}</td>
                        <td class="px-4 py-2">${user.email}</td>
                        <td class="px-4 py-2">${user.department}</td>
                        <td class="px-2 py-2 text-center flex justify-center gap-1">
                            <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                            <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                        </td>
                    </tr>`;
                            user.user_role === 'faculty' ? facultyTbody.append(row) : studentTbody.append(row);
                        });
                },
                error: xhr => console.error(xhr.responseText)
            });

        }

        // --- VIEW, EDIT, DELETE ACTIONS ---
        $(document).on("click", ".view-btn, .edit-btn, .delete-btn", function () {
            const tr = $(this).closest("tr");
            const userId = tr.data("id");

            if ($(this).hasClass("view-btn")) viewUser(userId);
            else if ($(this).hasClass("edit-btn")) editUser(userId);
            else if ($(this).hasClass("delete-btn")) deleteUser(userId, tr);
        }); 

        function viewUser(userId) {
            activateTab(`.tab-panel`, '#view-content');
            loadStudentActivities(userId);
            $.post(`${base_url}auth/action.php?action=GetUser`, { action: 'GetFaculty', user_id: userId }, function (res) {
                if (res.status !== 1) return alert(res.message);
                const data = res.data;
                $("#viewstudent_id").text(data.student_id);
                $("#viewfirstname").text(data.firstname);
                $("#viewlastname").text(data.lastname);
                $("#viewmiddlename").text(data.middlename);
                $("#viewsuffix").text(data.suffix);
                $("#viewcourse").text(data.course);
                $("#viewsection").text(data.section);
                $("#viewEmail").text(data.email);
                $("#viewUsername").text(data.username);
                $("#viewdepartment").text(data.department);
                $("#viewStatus").text(data.account_status);
                $("#viewProfilePic").attr("src", data.profile_pic ? base_url + "auth/" + data.profile_pic : "../../assets/default-profile.png");

             }, "json").fail(() => alert("Server error"));
        }

        function editUser(userId) {
            activateTab(`.tab-panel`, '#edit-content');
            $.post(`${base_url}auth/action.php?action=GetUser`, { user_id: userId, action: 'GetFaculty' }, function (res) {
                if (res.status !== 1) return alert(res.message || "Failed to load user.");
                const data = res.data;
                $("#edit-firstname").val(data.firstname);
                $("#edit-lastname").val(data.lastname);
                $("#edit-middlename").val(data.middlename);
                $("#edit-suffix").val(data.suffix);
                $("#edit-email").val(data.email);
                $("#edit-student_id").val(data.student_id);
                $("#edit-section").val(data.section);
                $("#edit-username").val(data.username);
                $("#edit-department").val(data.department);
                $("#edit-course").val(data.course);
                $("#edit-user_role").val(data.user_role);
                $("#edit-user_id").val(userId);
                $("#editProfilePreview").attr("src", data.profile_pic ? base_url + "auth/" + data.profile_pic : "../../assets/default-profile.png");
            }, "json").fail(() => alert("Server error while loading user."));
        }

        function deleteUser(userId, tr) {
            if (!confirm("Are you sure you want to delete this user?")) return;
            $.post(`${base_url}auth/action.php?action=GetUser`, { action: 'DeleteUser', user_id: userId }, function (res) {
                if (res.status === 1) {
                    alert(res.message);
                    tr.remove();
                    loadUsers();
                } else alert(res.message);
            }, "json").fail(() => alert("Server error"));
        }

        // --- PROFILE PREVIEW ---
        $("#profile, #edit-profile_pic").change(function () {
            const file = this.files[0];
            if (!file) return;
            const target = $(this).attr("id") === "profile" ? profilePreview : $("#editProfilePreview");
            target.attr("src", URL.createObjectURL(file));
        });

        // --- ROLE TOGGLE ---
        $('input[name="role"]').change(function () {
            if ($(this).val() === "student") {
                studentFields.removeClass("hidden");
                facultyFields.addClass("hidden");
            } else {
                facultyFields.removeClass("hidden");
                studentFields.addClass("hidden");
            }
        });

        // --- REGISTER FORM ---
        $("#register").submit(function (e) {
            e.preventDefault();
            const role = $('input[name="role"]:checked').val();
            const formData = new FormData(this);
            formData.append('role', role);

            $.ajax({
                url: `${base_url}auth/action.php?action=register_user`,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (res) {
                    registerMessage.text(res.message).removeClass("hidden")
                        .toggleClass("text-green-500", res.status === 1)
                        .toggleClass("text-red-500", res.status !== 1);
                    if (res.status === 1) {
                        $("#register")[0].reset();
                        profilePreview.attr("src", "../../assets/default-profile.png");
                        studentFields.removeClass("hidden");
                        facultyFields.addClass("hidden");
                        loadUsers();
                    }
                },
                error: function () {
                    registerMessage.text("An error occurred. Please try again.").removeClass("hidden").addClass("text-red-500");
                }
            });
        });

        // --- UPDATE FORM ---
        $("#updateForm").submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `${base_url}auth/action.php?action=updateUser`,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: "json",
                success: res => {
                    if (res.status === 1) { alert("Updated successfully."); loadUsers(); }
                    else alert(res.message || "Update failed.");
                },
                error: xhr => { console.error(xhr.responseText); alert("Server error while updating."); }
            });
        });

        // --- APPROVE / DECLINE ---
        $(document).on('click', '.approveBtn, .declineBtn', function () {
            const user_id = $(this).data('id');
            const action = $(this).hasClass('approveBtn') ? 'Approved' : 'Declined';
            if (!confirm(`${action} this request?`)) return;
            $.post(`${base_url}auth/action.php?action=account_status`, { user_id, action }, res => {
                if (res.status) { alert(`Request ${action.toLowerCase()}`); loadUsers(); }
                else alert(res.message || 'Operation failed');
            }, 'json').fail(() => alert('Server error'));
        });
    });

    function loadApprovalRequests() {
        const approvalTable = $("#approvalTable");
        approvalTable.html(`<tr><td colspan="5" class="text-center py-4">Loading...</td></tr>`);

        $.post(`${base_url}auth/action.php?action=GetFaculty`, { action: 'GetFaculty' }, res => {
            if (!res.status || !res.data?.length) {
                return approvalTable.html(`<tr><td colspan="5" class="text-center py-4 text-gray-500">No pending requests</td></tr>`);
            }

            const statusClasses = {
                Pending: 'bg-yellow-100 text-yellow-700',
                Approved: 'bg-green-100 text-green-700',
                Declined: 'bg-red-100 text-red-700'
            };

            const filteredData = res.data.filter(req => req.account_status === 'Pending' || req.account_status === 'Declined');

            if (!filteredData.length) {
                return approvalTable.html(`<tr><td colspan="5" class="text-center py-4 text-gray-500">No pending requests</td></tr>`);
            }

            const rows = filteredData.map(req => `
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">${req.user_id}</td>
                        <td class="px-6 py-2">${req.firstname} ${req.lastname}</td>
                        <td class="px-4 py-2">${req.email}</td>
                        <td class="px-4 py-2">${req.department}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold ${statusClasses[req.account_status] || 'bg-gray-100 text-gray-700'}">
                                ${req.account_status}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button data-id="${req.user_id}" class="reviewBtn px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 mr-1">Review</button>
                            <button data-id="${req.user_id}" class="approveBtn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 mr-1">Approve</button>
                            <button data-id="${req.user_id}" class="declineBtn px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Decline</button>
                        </td>
                    </tr>
                `).join('');

            approvalTable.html(rows);
        }, 'json').fail(() => {
            approvalTable.html(`<tr><td colspan="5" class="text-center text-red-500 py-4">Failed to load requests</td></tr>`);
        });
    }


    $(document).on('click', '.approveBtn, .declineBtn, .reviewBtn', function () {
        const user_id = $(this).data('id');

        // === HANDLE REVIEW BUTTON ===
        if ($(this).hasClass('reviewBtn')) {
            // Show modal
            $('#reviewModal').removeClass('hidden').addClass('flex');
            // Load user data into modal
            $.post(`${base_url}auth/action.php?action=GetUser`, { action: 'GetFaculty', user_id }, function (res) {
                if (res.status !== 1) return alert(res.message);
                const data = res.data;
                $("#firstname").text(data.firstname);
                $("#lastname").text(data.lastname);
                $("#middlename").text(data.middlename);
                $("#suffix").text(data.suffix);
                $("#department").text(data.department);
                $("#student_id").text(data.student_id);
                $("#course").text(data.course);
                $("#section").text(data.section);
                $("#reviewEmail").text(data.email);
                $("#reviewUsername").text(data.username);
                $("#viewStatus").text(data.account_status);
                $("#ReviewProfilePic").attr("src", data.profile_pic ? base_url + "auth/" + data.profile_pic : "../assets/image/users.png");
            }, "json").fail(() => alert("Server error"));

            return; // stop the approve/decline flow
        }

        // === NORMAL APPROVE / DECLINE ===
        let action = $(this).hasClass('approveBtn') ? 'Approved' : 'Declined';

        if (!confirm(`${action} this request?`)) return;

        $.post(`${base_url}auth/action.php?action=account_status`,
            { user_id, action },
            res => {
                if (res.status) {
                    alert(`Request ${action.toLowerCase()}`);
                    loadApprovalRequests();
                    loadUsers();
                } else {
                    alert(res.message || 'Operation failed');
                }
            },
            'json'
        ).fail(() => alert('Server error'));
    });



    // ---------------- Initial Load ----------------
    loadApprovalRequests();




    function loadStudentActivities(user_id) {
        const tbody = $("#studentActivitiesBody");
        tbody.html('<tr><td colspan="5" class="text-center py-4">Loading...</td></tr>');

        $.ajax({
            url: `${base_url}auth/action.php?action=GetStudentActivities`,
            type: 'GET', // or POST if you prefer
            data: { user_id },
            dataType: 'json',
            success: function (res) {
                if (!res.status || !res.data.length) {
                    tbody.html('<tr><td colspan="5" class="text-center py-4">No activities found</td></tr>');
                    return;
                }

                const rows = res.data.map((act, index) => `
            <tr class="border-b dark:border-gray-700">
                <td class="px-4 py-2">${index + 1}</td>
                <td class="px-4 py-2">${act.book_title}</td>
                <td class="px-4 py-2">${act.start_time}</td>
                <td class="px-4 py-2">${act.end_time || 'In Progress'} / ${act.total_read_time}</td>
                <td class="px-4 py-2">${act.remark}</td>
            </tr>
        `).join('');

                tbody.html(rows);
            },
            error: function (xhr) {
                tbody.html('<tr><td colspan="5" class="text-center text-red-500 py-4">Failed to load activities</td></tr>');
                console.error(xhr.responseText);
            }
        });

    }

    // Usage example:
    // loadStudentActivities(2025001);

</script>