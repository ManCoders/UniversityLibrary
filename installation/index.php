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
                        // Library/Academic Colors
                        'primary': '#1a476f', // Deep Navy Blue (Authority)
                        'primaryHover': '#11304d',
                        'accent': '#cc9900', // Muted Gold (Classic Accent)
                        'background': '#fcfcf0', // Light Ivory/Paper
                        'card': '#ffffff', // White
                    }
                }
            }
        }

        let currentStep = 1;

        function updateStepUI() {
            // Hide all steps
            document.querySelectorAll('.install-step').forEach(step => step.classList.add('hidden'));

            // Show the current step
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            // Update the progress bar
            document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                indicator.classList.remove('step-active-color', 'step-inactive-color');
                if (index + 1 <= currentStep) {
                    indicator.classList.add('step-active-color');
                } else {
                    indicator.classList.add('step-inactive-color');
                }
            });

            // Update navigation buttons
            document.getElementById('prev-button').classList.toggle('hidden', currentStep === 1);

            const nextButton = document.getElementById('next-button');
            const installButton = document.getElementById('install-button');

            if (currentStep < 3) {
                nextButton.classList.remove('hidden');
                installButton.classList.add('hidden');
            } else {
                nextButton.classList.add('hidden');
                installButton.classList.remove('hidden');
                updateReviewData();
            }
        }

        function updateReviewData() {
            // Update the review step content with collected data
            const form = document.getElementById('install-form');
            const data = {
                title: form.system_title.value || '[Not Set]',
                description: form.system_description.value || '[Not Set]',
                name: `${form.firstname.value} ${form.lastname.value}` || '[Not Set]',
                email: form.email.value || '[Not Set]',
                username: form.username.value || '[Not Set]',
            };

            document.getElementById('review-title').textContent = data.title;
            document.getElementById('review-description').textContent = data.description;
            document.getElementById('review-name').textContent = data.name;
            document.getElementById('review-email').textContent = data.email;
            document.getElementById('review-username').textContent = data.username;
        }

        function nextStep() {
            // Simple validation before moving forward
            const currentFormSection = document.getElementById(`step-${currentStep}`);
            const requiredFields = currentFormSection.querySelectorAll('[required]');
            let allValid = true;

            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('ring-2', 'ring-red-500', 'border-red-500');
                    field.focus();
                    allValid = false;
                } else {
                    field.classList.remove('ring-2', 'ring-red-500', 'border-red-500');
                }
            });

            if (allValid && currentStep < 3) {
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

        document.addEventListener('DOMContentLoaded', () => {
            updateStepUI(); // Initialize UI

            // Logo upload logic
            const logoPreview = document.getElementById('systemLogoPreview');
            const logoInput = document.getElementById('systemLogo');

            logoPreview.onclick = function () {
                logoInput.click();
            };
            logoInput.onchange = function (event) {
                const [file] = event.target.files;
                if (file) {
                    logoPreview.src = URL.createObjectURL(file);
                }
            };

            // Handle form submission (only on final step)
            document.getElementById('install-form').addEventListener('submit', function (e) {
                e.preventDefault();
                if (currentStep === 3) {
                    // Display success message
                    document.getElementById('main-card').innerHTML = `
                        <div class="p-10 text-center">
                            <svg class="mx-auto h-16 w-16 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="text-3xl font-bold text-gray-800 mt-4">Installation Complete!</h2>
                            <p class="text-gray-500 mt-2">The '${document.getElementById('review-title').textContent}' system has been successfully cataloged.</p>
                            <a href="./" class="inline-block mt-6 bg-primary hover:bg-primaryHover text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-md">Proceed to Library System</a>
                        </div>
                    `;
                }
            });
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
                    <form id="install-form">

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
                            <h5 class="text-center font-bold text-primary mb-8 text-2xl font-serif">2. Chief Librarian
                                Account Enrollment</h5>

                            <!-- Name Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="firstname" class="text-gray-700 block mb-2 font-medium">First
                                        Name</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="firstname" name="firstname" placeholder="First Name" required>
                                </div>
                                <div>
                                    <label for="middlename" class="text-gray-700 block mb-2 font-medium">Middle Name
                                        (Optional)</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-gray-50 text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="middlename" name="middlename" placeholder="Middle Name">
                                </div>
                                <div>
                                    <label for="lastname" class="text-gray-700 block mb-2 font-medium">Last Name</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="lastname" name="lastname" placeholder="Last Name" required>
                                </div>
                            </div>

                            <!-- Credentials Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="email" class="text-gray-700 block mb-2 font-medium">Institutional
                                        Email</label>
                                    <input type="email"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="email" name="email" placeholder="chief.librarian@uni.edu" required>
                                </div>
                                <div>
                                    <label for="username" class="text-gray-700 block mb-2 font-medium">Librarian
                                        ID/Username</label>
                                    <input type="text"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="username" name="username" placeholder="e.g. jdoe_admin" required>
                                </div>
                                <div>
                                    <label for="password" class="text-gray-700 block mb-2 font-medium">Access Key
                                        (Password)</label>
                                    <input type="password"
                                        class="w-full px-5 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-primary focus:border-primary transition duration-200 shadow-sm"
                                        id="password" name="password" placeholder="Secure Key" required>
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
                                class="bg-primary hover:bg-primaryHover text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 active:scale-95">
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