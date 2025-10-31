<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Library System Installation</title>
    <style>
        /* Base styles adapted for a light, academic theme */

        .logo-upload-container {
            transition: all 0.3s;
        }

        .logo-upload-container:hover {
            /* Hover effect: Accent border, subtle shadow */
            border-color: #cc9900;
            background-color: #f7f7f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }

        .logo-preview {
            object-fit: contain;
            background-color: #ffffff;
            cursor: pointer;
            transition: transform 0.3s;
            border: 2px solid #1a476f;
            /* Primary blue frame */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .logo-preview:hover {
            transform: scale(1.05);
        }

        /* Custom scrollbar matching the accent color */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cc9900;
            border-radius: 4px;
        }

        /* Stepper Colors */
        .step-inactive-color {
            color: #6b7280;
            border-color: #d1d5db;
        }

        .step-active-color {
            color: #ffffff;
            background-color: #1a476f;
            border-color: #1a476f;
        }
    </style>
    <script>
tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                'primary': '#1a476f', // Deep Navy Blue
                'primaryHover': '#11304d',
                'accent': '#cc9900', // Muted Gold
                'background': '#fcfcf0', // Light Ivory
                'card': '#ffffff', // White
            }
        }
    }
}

$(document).ready(function () {
    let currentStep = 1;
    let adminProfileBase64 = '';

    function updateStepUI() {
        $('.install-step').addClass('hidden');
        $(`#step-${currentStep}`).removeClass('hidden');

        $('.step-indicator').each(function (index) {
            $(this).removeClass('step-active-color step-inactive-color');
            if (index + 1 <= currentStep) $(this).addClass('step-active-color');
            else $(this).addClass('step-inactive-color');
        });

        $('#prev-button').toggle(currentStep !== 1);
        $('#next-button').toggle(currentStep < 3);
        $('#install-button').toggle(currentStep === 3);

        if (currentStep === 3) updateReviewData();
    }

    function validateStep() {
        let allValid = true;
        $(`#step-${currentStep} [required]`).each(function () {
            if (!$(this).val()) {
                $(this).addClass('ring-2 ring-red-500 border-red-500');
                allValid = false;
            } else {
                $(this).removeClass('ring-2 ring-red-500 border-red-500');
            }
        });
        return allValid;
    }

    function nextStep() {
        if (validateStep() && currentStep < 3) {
            currentStep++;
            updateStepUI();
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepUI();
        }
    }

    window.nextStep = nextStep;
    window.prevStep = prevStep;

    // Logo upload preview
    $('#systemLogoPreview').click(() => $('#systemLogo').click());
    $('#systemLogo').change(function () {
        const file = this.files[0];
        if (file) $('#systemLogoPreview').attr('src', URL.createObjectURL(file));
    });

    // Admin profile picture preview
    $('#adminProfilePreview').click(() => $('#adminProfilePic').click());
    $('#adminProfilePic').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#adminProfilePreview').attr('src', e.target.result);
                adminProfileBase64 = e.target.result; // Save Base64 for backend
            };
            reader.readAsDataURL(file);
        }
    });

    // Update review step
    function updateReviewData() {
        $('#review-title').text($('#system_title').val() || '[Not Set]');
        $('#review-description').text($('#system_description').val() || '[Not Set]');
        const fullName = $('#firstname').val() + ' ' + ($('#middlename').val() ? $('#middlename').val() + ' ' : '') + $('#lastname').val();
        $('#review-name').text(fullName || '[Not Set]');
        $('#review-email').text($('#email').val() || '[Not Set]');
        $('#review-username').text($('#username').val() || '[Not Set]');

        // Show admin profile in review if needed
        if (adminProfileBase64) {
            $('#review-admin-pic').attr('src', adminProfileBase64).removeClass('hidden');
        }
    }

    
    updateStepUI();
});
</script>

</head>

<body class="bg-background font-sans min-h-screen text-gray-800">

    <main id="main" class="flex flex-col items-center justify-center py-12 md:py-20">
        <div class="container max-w-4xl w-full mx-auto px-4">
            <div id="main-card" class="bg-card shadow-xl border border-gray-200 rounded-xl overflow-hidden">

                <!-- Card Header (Classic Navy Banner) -->
                <div class="bg-primary p-6 rounded-t-xl">
                    <h3 class="text-2xl font-serif font-bold text-white tracking-wider">Library System Cataloging Wizard
                    </h3>
                </div>

                <!-- Progress Stepper (Paper-like border) -->
                <div class="p-6 border-b border-gray-200">
                    <ol class="flex justify-between items-center text-center">
                        <li class="flex-1">
                            <div id="indicator-1"
                                class="step-indicator w-8 h-8 rounded-full font-bold text-lg leading-8 mx-auto border-2 transition duration-300">
                                1</div>
                            <p class="mt-2 text-sm text-gray-600">Library Profile</p>
                        </li>
                        <li class="flex-1">
                            <hr class="w-full h-0.5 bg-gray-300 -ml-1/2 -mr-1/2 translate-y-1/2">
                        </li>
                        <li class="flex-1">
                            <div id="indicator-2"
                                class="step-indicator w-8 h-8 rounded-full font-bold text-lg leading-8 mx-auto border-2 transition duration-300">
                                2</div>
                            <p class="mt-2 text-sm text-gray-600">Chief Librarian</p>
                        </li>
                        <li class="flex-1">
                            <hr class="w-full h-0.5 bg-gray-300 -ml-1/2 -mr-1/2 translate-y-1/2">
                        </li>
                        <li class="flex-1">
                            <div id="indicator-3"
                                class="step-indicator w-8 h-8 rounded-full font-bold text-lg leading-8 mx-auto border-2 transition duration-300">
                                3</div>
                            <p class="mt-2 text-sm text-gray-600">Final Enrollment</p>
                        </li>
                    </ol>
                </div>

                <!-- Card Body -->
                <div class="p-6 md:p-10">
                    <form id="install-form" enctype="multipart/form-data">

                        <!-- STEP 1: LIBRARY PROFILE -->
                        <div id="step-1" class="install-step">
                            <h5 class="text-center font-bold text-primary mb-8 text-2xl font-serif">1. Library Seal &
                                Catalog Information</h5>

                            <!-- Logo Upload Section (Seal/Plaque style) -->
                            <div class="text-center mb-10">
                                <h5 class="font-bold text-gray-700 mb-4 text-lg">Upload Library Seal/Logo</h5>
                                <div
                                    class="logo-upload-container mx-auto inline-block p-4 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 max-w-xs transition duration-300">

                                    <img src="https://placehold.co/150x150/ffffff/1a476f?text=SEAL"
                                        class="logo-preview w-[150px] h-[150px] rounded-full mx-auto block border-2 shadow-lg"
                                        alt="Library Seal Preview" id="systemLogoPreview"
                                        title="Click to Upload Seal/Logo">

                                    <small class="text-gray-500 mt-3 block text-sm font-medium">Click to Upload Seal
                                        (Recommended: Circular)</small>
                                    <input type="file" name="system_logo" class="hidden" accept="image/*"
                                        id="systemLogo">
                                </div>
                            </div>

                            <hr class="my-8 border-gray-200">

                            <!-- System Text Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="system_title" class="text-gray-700 block mb-2 font-medium">Library Name
                                        (or System Title)</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="system_title" name="system_title"
                                        placeholder="E.g., The Athenaeum Library System" required>
                                </div>
                                <div>
                                    <label for="system_description" class="text-gray-700 block mb-2 font-medium">System
                                        Tagline/Motto</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="system_description" name="system_description"
                                        placeholder="Dedicated to Knowledge and Research" required>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: CHIEF LIBRARIAN (ADMIN ACCOUNT) SETUP -->
                        <div id="step-2" class="install-step hidden">
                            <h5 class="text-center font-bold text-primary mb-8 text-2xl font-serif">
                                2. Chief Librarian Account Enrollment
                            </h5>

                            <!-- Admin Profile Picture Upload -->
                            <div class="text-center mb-8">
                                <h5 class="font-bold text-gray-700 mb-4 text-lg">Upload Admin Profile Picture</h5>
                                <div
                                    class="logo-upload-container mx-auto inline-block p-4 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 max-w-xs transition duration-300">
                                    <img src="https://placehold.co/150x150/ffffff/1a476f?text=PROFILE"
                                        class="logo-preview w-[150px] h-[150px] rounded-full mx-auto block border-2 shadow-lg"
                                        alt="Admin Profile Preview" id="adminProfilePreview"
                                        title="Click to Upload Profile Picture">
                                    <small class="text-gray-500 mt-3 block text-sm font-medium">
                                        Click to upload profile picture
                                    </small>
                                    <input type="file" name="admin_profile_pic" class="hidden" accept="image/*"
                                        id="adminProfilePic">
                                </div>
                            </div>

                            <!-- Name Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="firstname" class="text-gray-700 block mb-2 font-medium">First
                                        Name</label>
                                    <input type="text" id="firstname" name="firstname" placeholder="First Name" required
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                                <div>
                                    <label for="middlename" class="text-gray-700 block mb-2 font-medium">Middle Name
                                        (Optional)</label>
                                    <input type="text" id="middlename" name="middlename" placeholder="Middle Name"
                                        class="w-full px-5 py-3 bg-gray-50 text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                                <div>
                                    <label for="lastname" class="text-gray-700 block mb-2 font-medium">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" placeholder="Last Name" required
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                            </div>

                            <!-- Credentials Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="email" class="text-gray-700 block mb-2 font-medium">Institutional
                                        Email</label>
                                    <input type="email" id="email" name="email" placeholder="chief.librarian@uni.edu"
                                        required
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                                <div>
                                    <label for="username" class="text-gray-700 block mb-2 font-medium">Librarian
                                        ID/Username</label>
                                    <input type="text" id="username" name="username" placeholder="e.g. jdoe_admin"
                                        required
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                                <div>
                                    <label for="password" class="text-gray-700 block mb-2 font-medium">Access Key
                                        (Password)</label>
                                    <input type="password" id="password" name="password" placeholder="Secure Key"
                                        required
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm">
                                </div>
                            </div>
                        </div>


                        <!-- STEP 3: REVIEW & INSTALL -->
                        <div id="step-3" class="install-step hidden">
                            <h5 class="text-center font-bold text-primary mb-8 text-2xl font-serif">3. Final Review &
                                System Activation</h5>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-md mb-8">
                                <p
                                    class="text-xl font-semibold text-primary border-b border-gray-300 pb-3 mb-4 font-serif">
                                    Catalog Details</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <div><span class="font-medium text-primary">Title:</span> <span
                                            id="review-title"></span></div>
                                    <div><span class="font-medium text-primary">Motto:</span> <span
                                            id="review-description"></span></div>
                                </div>

                                <p
                                    class="text-xl font-semibold text-primary border-b border-gray-300 pb-3 mt-8 mb-4 font-serif">
                                    Chief Librarian Credentials</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                                    <div><span class="font-medium text-primary">Name:</span> <span
                                            id="review-name"></span></div>
                                    <div><span class="font-medium text-primary">Email:</span> <span
                                            id="review-email"></span></div>
                                    <div><span class="font-medium text-primary">ID:</span> <span
                                            id="review-username"></span></div>
                                </div>
                            </div>

                            <p class="text-center text-gray-500 text-sm italic">
                                Once you click "ACTIVATE LIBRARY SYSTEM," the records will be cataloged and the Chief
                                Librarian account will be created.
                            </p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-10">
                            <button type="button" id="prev-button" onclick="prevStep()"
                                class="text-gray-500 hover:text-primary flex items-center transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Return to Previous
                            </button>

                            <button type="button" id="next-button" onclick="nextStep()"
                                class="bg-primary hover:bg-primary text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 active:scale-95">
                                Continue to Enrollment
                            </button>

                            <!-- Changed color to an authoritative Green for final action -->
                            <button type="submit" id="install-button"
                                class="bg-green-700 hover:bg-green-800 text-white font-extrabold text-lg py-3 px-16 rounded-lg shadow-2xl shadow-green-700/30 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 border-b-4 border-green-800 hover:border-green-900 hidden">
                                ACTIVATE LIBRARY SYSTEM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>

</html>