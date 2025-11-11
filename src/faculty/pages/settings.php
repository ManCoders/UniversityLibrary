<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    Faculty Account Settings
</h1>

<!-- Profile Section -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg flex flex-col md:flex-row gap-6 items-center md:items-start">

    <!-- Left: Profile Picture -->
    <div class="flex flex-col items-center md:items-center w-full md:w-1/3">
        <div class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-indigo-500 dark:border-indigo-400">
            <img id="profile-picture"
                src="<?php echo $_SESSION['faculty']['profile_pic'] ?? 'assets/default-profile.png'; ?>"
                alt="Profile Picture"
                class="w-full h-full object-cover">
        </div>
        <label for="profile-upload"
            class="mt-3 cursor-pointer text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
            Upload Profile Picture
        </label>
        <input type="file" id="profile-upload" name="profile-upload" class="hidden" accept="image/*">
    </div>

    <!-- Right: Account Form -->
    <form id="faculty-account-form" class="flex-1 space-y-4" enctype="multipart/form-data">
        <div class="grid grid-cols-2 gap-3">
            <input type="text" name="firstname" placeholder="First Name"
                value="<?php echo $_SESSION['faculty']['firstname'] ?? ''; ?>"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                required>
            <input type="text" name="lastname" placeholder="Last Name"
                value="<?php echo $_SESSION['faculty']['lastname'] ?? ''; ?>"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                required>

            <input type="text" name="middlename" placeholder="Middle Name"
                value="<?php echo $_SESSION['faculty']['middlename'] ?? ''; ?>"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <input type="text" name="suffix" placeholder="Suffix"
                value="<?php echo $_SESSION['faculty']['suffix'] ?? ''; ?>"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
        </div>

        <input type="text" name="department" placeholder="Department"
            value="<?php echo $_SESSION['faculty']['department'] ?? ''; ?>"
            class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
            required>
        <input type="email" name="email" placeholder="University Email"
            value="<?php echo $_SESSION['faculty']['email'] ?? ''; ?>"
            class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
            required>

        <!-- Password Update -->
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mt-4">Change Password</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input type="password" name="current_password" placeholder="Current Password"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <input type="password" name="new_password" placeholder="New Password"
                class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
        </div>
        <input type="password" name="confirm_password" placeholder="Confirm New Password"
            class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 text-gray-800 dark:text-gray-200">

        <button type="submit"
            class="w-full bg-indigo-600 dark:bg-indigo-500 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
            Update Account
        </button>

        <p id="account-message" class="text-sm text-red-500 hidden"></p>
    </form>
</div>

<script>
$(document).ready(function() {
    // Preview profile image immediately when selected
    $('#profile-upload').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            $('#profile-picture').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });

    // Submit form via AJAX
    $('#faculty-account-form').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: `${base_url}auth/action.php?action=settingupdate`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                $('#account-message').removeClass('hidden').text(res.message);

                if (res.status === 1) {
                    $('#account-message').removeClass('text-red-500').addClass('text-green-500');

                    // Update profile picture dynamically, with cache busting
                    if (res.new_image) {
                        $('#profile-picture').attr('src', `${base_url}auth/${res.new_image}?v=` + new Date().getTime());
                    }

                    // Clear password fields
                    $('#faculty-account-form input[name="current_password"], #faculty-account-form input[name="new_password"], #faculty-account-form input[name="confirm_password"]').val('');

                } else {
                    $('#account-message').removeClass('text-green-500').addClass('text-red-500');
                }
            },
            error: function() {
                $('#account-message').removeClass('hidden').text('An error occurred.');
            }
        });
    });
});
</script>

