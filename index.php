<?php include "./header.php"; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark:bg-gray-800 ">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php get_option('system_title'); ?></title>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }

        /* Custom scrollbar for chat messages */
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background-color: #a78bfa;
            /* Indigo 400 */
            border-radius: 3px;
        }

        .dark #chat-messages::-webkit-scrollbar-thumb {
            background-color: #4338ca;
            /* Indigo 700 */
        }
    </style>
</head>

<body
    class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300 font-sans min-h-screen">

    <!-- Header / Fixed Navigation (Contains Main Title and Auth/Toggle) -->
    <header
        class="fixed top-0 w-full bg-gradient-to-r from-[#800000] via-[#a00000] to-[#b03060] dark:from-[#4d0000] dark:via-[#660000] dark:to-[#990033] backdrop-blur-md shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-0 flex justify-between items-center">
            <h1 class="flex items-center gap-2 text-white">
                <img src="./assets/image/<?php echo htmlspecialchars(get_option('system_logo')); ?>"
                    alt="University Logo" class="w-14 sm:w-20 h-auto rounded-full border-1 border-white shadow-md" />
                <div class="flex flex-col leading-tight">
                    <span class="text-lg sm:text-2xl font-extrabold">
                        <?php echo htmlspecialchars(get_option('system_title')); ?>
                    </span>
                    <span class="text-sm sm:text-base text-gray-100 font-medium">
                        <?php echo htmlspecialchars(get_option('system_description')); ?>
                    </span>
                </div>
            </h1>



            <div class="flex items-center gap-3 relative">
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle"
                    class="p-2 rounded-full text-white hover:bg-white/20 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                    <i id="dark-mode-icon" data-lucide="moon" class="w-5 h-5"></i>
                </button>

                <!-- Home Button -->
                <button data-view="home"
                    class="nav-link text-white border-b-2 border-white font-semibold px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                    <i data-lucide="home" class="inline-block w-4 h-4 mr-1"></i> Home
                </button>

                <!-- User Authentication Container -->
                <div id="user-auth-container" class="relative">
                    <!-- Logged Out State (Sign In) -->
                    <button id="auth-sign-in-btn"
                        class="bg-gradient-to-r  from-[#800000] to-[#b03060] text-white px-4 py-2 rounded-full shadow-md hover:from-[#a00000] hover:to-[#c05070] transition transform hover:scale-105 text-sm sm:text-base font-medium">
                        <i data-lucide="log-in" class="inline-block w-4 h-4 mr-1"></i>Sign In
                    </button>

                    <!-- Logged In State (Profile Button & Dropdown) -->
                    <button id="profile-btn"
                        class="hidden p-2 rounded-full  border-2 border-[#b03060] hover:ring-2 hover:ring-[#ff4d6d]"
                        aria-expanded="false">
                        <i data-lucide="user" class="w-6 h-6 text-[#b03060] dark:text-[#ff4d6d] text-white"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown"
                        class="hidden absolute right-0 mt-3 w-48 bg-gradient-to-b from-[#ffd1d1] to-[#b03060] dark:from-[#330000] dark:to-[#660000] rounded-lg shadow-xl py-2 animate-fade-in border border-[#b03060] dark:border-[#990033] z-50 origin-top-right text-white">

                        <div
                            class="px-3 py-2 text-sm font-semibold border-b border-[#b03060] dark:border-[#990033] truncate">
                            <span id="profile-username">User ID: guest</span>
                        </div>

                        <a href="#" id="dropdown-my-profile" data-view-target="profile"
                            class="flex items-center px-3 py-2 text-sm hover:bg-white/20 dark:hover:bg-[#660000] transition">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>My Profile
                        </a>
                        <a href="#" id="dropdown-my-books" data-view-target="books"
                            class="flex items-center px-3 py-2 text-sm hover:bg-white/20 dark:hover:bg-[#660000] transition">
                            <i data-lucide="book" class="w-4 h-4 mr-2"></i>My Books
                        </a>
                        <a href="#" id="dropdown-settings" data-view-target="settings"
                            class="flex items-center px-3 py-2 text-sm hover:bg-white/20 dark:hover:bg-[#660000] transition">
                            <i data-lucide="settings" class="w-4 h-4 mr-2"></i>Settings
                        </a>

                        <div class="border-t dark:border-[#990033] mt-1 pt-1">
                            <button id="logout"
                                class="w-full flex items-center px-3 py-2 text-sm text-rwhite-600 dark:text-red-400 hover:bg-white/20 dark:hover:bg-[#660000] transition">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </header>

    <!-- Main Content Wrapper to handle the padding for the fixed header (Approx. 110-118px height) -->
    <main class="pt-[110px] sm:pt-[118px] ">

        <!-- HOME SECTION -->
        <section id="home-section" class="view-section overflow-hidden">

            <!-- Hero Section -->
            <section
                class="p-12 text-center px-4 bg-gradient-to-br from-[#ffe5e5] via-[#ffcccc] to-[#b03060] dark:from-[#330000] dark:via-[#660000] dark:to-[#800000] transition-colors duration-300">

                <h2 class="text-4xl sm:text-6xl font-extrabold mb-4 leading-tight">
                    <span class="text-[#800000] dark:text-[#ff4d6d]">Discover</span>
                    <span class="text-[#660000] dark:text-[#ffe5e5]">Your Academic World</span>
                </h2>

                <p class="text-lg text-[#660000] dark:text-[#ffd1d1] mb-8 max-w-3xl mx-auto">
                    The central hub for research, publications, and
                    <strong>24/7 access</strong> to campus-wide academic resources.
                </p>

                <!-- Search Bar -->
                <div class="flex justify-center mb-8">
                    <div class="w-full max-w-xl relative group">
                        <input id="search-input" type="text" placeholder="Search books, authors, or papers..."
                            class="w-full border-2 border-[#b03060] dark:border-[#660000] rounded-full p-4 pr-16 text-base bg-white dark:bg-[#330000] focus:ring-4 focus:ring-[#b03060] focus:border-[#b03060] transition-all outline-none shadow-md text-[#660000] dark:text-[#ffd1d1] placeholder-[#b03060] dark:placeholder-[#ffcccc]">
                        <button id="search-btn"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#800000] to-[#b03060] text-white p-3 rounded-full hover:from-[#a00000] hover:to-[#c05070] transition">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <p class="text-sm text-[#800000] dark:text-[#ffd1d1] italic">
                    Over 1.2 million digital assets available.
                </p>
            </section>


            <!-- Services Section -->
            <section class="max-w-6xl mx-auto px-6 pb-20">
                <h2 class="text-3xl font-bold text-center mb-12 pt-8 text-[#660000] dark:text-[#ffcccc]">
                    Core Library Services
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card -->
                    <div
                        class="p-8 bg-[#ffe5e5] dark:bg-[#330000] rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-[#b03060] dark:border-[#800000]">
                        <i data-lucide="book-open-text"
                            class="w-10 h-10 text-[#b03060] dark:text-[#ff4d6d] mb-4 bg-[#ffd1d1] dark:bg-[#660000]/40 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3 text-[#660000] dark:text-[#ffd1d1]">
                            Smart Metadata Management
                        </h3>
                        <p class="text-base text-[#800000] dark:text-[#ffcccc]">
                            Automatically extract, tag, and organize metadata for books, theses, and research papers.
                        </p>
                    </div>

                    <!-- Card -->
                    <div
                        class="p-8 bg-[#ffe5e5] dark:bg-[#330000] rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-[#b03060] dark:border-[#800000]">
                        <i data-lucide="bot"
                            class="w-10 h-10 text-[#b03060] dark:text-[#ff4d6d] mb-4 bg-[#ffd1d1] dark:bg-[#660000]/40 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3 text-[#660000] dark:text-[#ffd1d1]">
                            AI Library Chatbot
                        </h3>
                        <p class="text-base text-[#800000] dark:text-[#ffcccc]">
                            Get instant assistance for literature reviews, resource finding, and academic inquiries.
                        </p>
                    </div>

                    <!-- Card -->
                    <div
                        class="p-8 bg-[#ffe5e5] dark:bg-[#330000] rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-[#b03060] dark:border-[#800000]">
                        <i data-lucide="lock"
                            class="w-10 h-10 text-[#b03060] dark:text-[#ff4d6d] mb-4 bg-[#ffd1d1] dark:bg-[#660000]/40 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3 text-[#660000] dark:text-[#ffd1d1]">
                            Secure Campus Access
                        </h3>
                        <p class="text-base text-[#800000] dark:text-[#ffcccc]">
                            Login safely using your university ID for access to exclusive materials and your profile.
                        </p>
                    </div>
                </div>
            </section>

        </section>


        <!-- MY PROFILE SECTION -->

        <!-- PROFILE SECTION -->
        <section id="profile-section" class="view-section hidden pt-8 pb-20 max-w-4xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">My Profile</h2>

            <div
                class="border-2 border-indigo-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg space-y-6 max-w-3xl mx-auto">

                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Profile Picture -->
                    <div class="relative">
                        <img id="profile-picture"
                            src="https://ui-avatars.com/api/?name=Guest&background=4F46E5&color=fff&size=128"
                            alt="Profile Picture"
                            class="w-32 h-32 rounded-full border-4 border-indigo-500 shadow-md object-cover">
                        <button
                            class="absolute bottom-1 right-1 bg-indigo-600 text-white p-2 rounded-full text-xs hover:bg-indigo-700 transition"
                            title="Change Photo">
                            <i data-lucide="camera" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <!-- Welcome Text -->
                    <div class="flex-1 text-center sm:text-left">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                            Welcome back,
                            <span id="profile-view-username" class="text-indigo-600 dark:text-indigo-400">Guest</span>!
                        </p>
                        <p class="text-gray-500 dark:text-gray-400">Glad to see you again.</p>
                    </div>
                </div>

                <!-- Profile Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                    <p><strong>Status:</strong> <span id="profile-status">N/A</span></p>
                    <p><strong>Department:</strong><span id="profile-department">N/A</span></p>
                    <p><strong>Library ID:</strong> <span id="profile-library_id">N/A</span></p>
                    <p><strong>Email:</strong> <span id="profile-email">N/A</span></p>
                    <p><strong>Checkouts:</strong> 5 / 10 limit</p>
                    <p><strong>Fines:</strong> $0.00</p>
                </div>

                <!-- Edit Button -->
                <div class="flex justify-center sm:justify-end">
                    <button
                        class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition font-medium flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                        Edit Profile
                    </button>
                </div>
            </div>


            <div
                class="mt-8 p-6 border-2 border-indigo-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <h3 class="text-xl font-semibold mb-3 text-gray-800 dark:text-gray-100">Activity Log</h3>
                <ul class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-28:</span> Renewed "Data Structures"</li>
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-25:</span> Checked out "Literary Theory"</li>
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-25:</span> Account logged in from campus IP
                    </li>
                </ul>
            </div>
        </section>

        <!-- MY BOOKS SECTION -->
        <section id="books-section" class="view-section hidden pt-8 pb-20 max-w-6xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">My Books & Resources</h2>

            <div
                class="border-2 border-indigo-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                <h3
                    class="text-xl font-semibold mb-4 border-b border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-100">
                    Currently Checked Out (3)
                </h3>

                <ul class="space-y-3 divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium text-gray-900 dark:text-gray-100">The Structure of Scientific
                                Revolutions</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Thomas S. Kuhn</p>
                        </div>
                        <span class="text-sm text-red-600 dark:text-red-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Nov
                            15, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">
                            Renew
                        </button>
                    </li>

                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium text-gray-900 dark:text-gray-100">Designing Data-Intensive
                                Applications</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Martin Kleppmann</p>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Dec
                            5, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">
                            Renew
                        </button>
                    </li>

                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium text-gray-900 dark:text-gray-100">Modern Literary Theory</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">M.H. Abrams</p>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Dec
                            10, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">
                            Renew
                        </button>
                    </li>
                </ul>
            </div>
        </section>

        <!-- SETTINGS SECTION -->
        <section id="settings-section" class="view-section hidden pt-8 pb-20 max-w-4xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Account Settings</h2>

            <div
                class="border-2 border-indigo-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg space-y-6">
                <!-- Theme Preferences -->
                <div>
                    <h3 class="text-xl font-semibold mb-2 flex items-center text-gray-800 dark:text-gray-100">
                        <i data-lucide="palette" class="w-5 h-5 mr-2 text-indigo-500"></i> Theme Preferences
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                        Change the visual appearance of the portal.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <button data-theme="light"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm text-gray-800 dark:text-gray-200">
                            Light Mode
                        </button>
                        <button data-theme="dark"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm text-gray-800 dark:text-gray-200">
                            Dark Mode
                        </button>
                        <button data-theme="system"
                            class="theme-select px-4 py-2 border rounded-full transition text-sm font-medium border-indigo-500 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300">
                            System Default
                        </button>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="border-t pt-4 border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold mb-3 flex items-center text-gray-800 dark:text-gray-100">
                        <i data-lucide="bell" class="w-5 h-5 mr-2 text-indigo-500"></i> Notification Settings
                    </h3>
                    <label class="flex items-center space-x-3 cursor-pointer mt-2">
                        <input type="checkbox" checked
                            class="form-checkbox text-indigo-600 rounded-sm w-5 h-5 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-gray-700 dark:text-gray-300">Email notifications for due dates</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer mt-2">
                        <input type="checkbox"
                            class="form-checkbox text-indigo-600 rounded-sm w-5 h-5 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-gray-700 dark:text-gray-300">Portal alerts for new features</span>
                    </label>
                </div>
            </div>
        </section>

    </main>


    <!-- Chatbot Floating UI -->
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <div id="chatbox"
            class="hidden w-72 sm:w-80 bg-[#ffe5e5] dark:bg-[#330000] rounded-xl shadow-2xl p-4 mb-3 animate-fade-in border border-[#b03060] dark:border-[#800000] text-[#660000] dark:text-[#ffd1d1]">

            <div class="flex justify-between items-center mb-3 border-b pb-2 border-[#b03060] dark:border-[#800000]">
                <h4 class="font-bold flex items-center text-[#b03060] dark:text-[#ff4d6d]">
                    <i data-lucide="bot" class="w-5 h-5 mr-2"></i>Library Assistant
                </h4>
                <button id="close-chat" class="text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div id="chat-messages"
                class="h-64 overflow-y-auto text-sm mb-3 space-y-2 pr-1 text-[#660000] dark:text-[#ffd1d1]">
                <p class="italic text-[#800000] dark:text-[#ffcccc]">
                    Hi 👋 I'm your AI library assistant. Ask me anything!
                </p>
            </div>

            <div class="flex items-center gap-2">
                <input id="chat-input" type="text" placeholder="Ask a question..."
                    class="flex-1 border rounded-lg p-2 text-sm bg-[#fff0f0] dark:bg-[#440000] border-[#b03060] dark:border-[#800000] focus:ring-[#b03060] focus:border-[#b03060] transition text-[#660000] dark:text-[#ffd1d1] placeholder-[#800000] dark:placeholder-[#ffcccc]">
                <button id="send-btn" class="bg-[#b03060] text-white p-2 rounded-lg hover:bg-[#800000] transition">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <button id="chatbot-toggle"
            class="bg-[#b03060] text-white p-4 rounded-full shadow-xl hover:bg-[#800000] transition transform hover:scale-105">
            <i data-lucide="message-circle" class="w-6 h-6"></i>
        </button>
    </div>



    <!-- Login Modal (Sign In) -->
    <div id="login-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm z-[100] flex items-center justify-center transition-opacity duration-300">

        <div
            class="bg-[#fff0f0] dark:bg-[#330000] rounded-xl shadow-2xl w-80 sm:w-96 p-8 relative animate-fade-in border border-[#b03060] dark:border-[#800000]">

            <button id="close-login"
                class="absolute top-3 right-3 text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3 class="text-2xl font-bold text-center mb-6 text-[#b03060] dark:text-[#ff4d6d]">
                <i data-lucide="user-check" class="inline-block w-6 h-6 mr-1 align-text-bottom"></i> Campus Sign In
            </h3>

            <form id="login" class="space-y-4">
                <input type="text" id="username-input" name="username" placeholder="University ID or Email" required
                    class="w-full border-2 border-[#b03060] dark:border-[#800000] rounded-lg p-3 dark:bg-[#440000] focus:ring-[#b03060] focus:border-[#b03060] transition text-[#660000] dark:text-[#ffd1d1] placeholder-[#800000] dark:placeholder-[#ffcccc]">
                <input type="password" name="password" id="password-input" placeholder="Password" required
                    class="w-full border-2 border-[#b03060] dark:border-[#800000] rounded-lg p-3 dark:bg-[#440000] focus:ring-[#b03060] focus:border-[#b03060] transition text-[#660000] dark:text-[#ffd1d1] placeholder-[#800000] dark:placeholder-[#ffcccc]">

                <p id="login-message" class="text-sm text-red-500 hidden"></p>

                <button type="submit"
                    class="w-full bg-[#b03060] text-white font-semibold py-3 rounded-lg hover:bg-[#800000] transition transform hover:scale-[1.01]">
                    Sign In
                </button>

                <button type="button"
                    class="w-full text-[#b03060] dark:text-[#ff4d6d] text-sm mt-2 hover:underline">Forgot
                    Password?</button>
            </form>
        </div>
    </div>

    <!-- Search Modal -->
    <div id="search-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm flex items-center justify-center z-[100] transition-opacity duration-300">

        <div
            class="bg-[#fff0f0] dark:bg-[#330000] rounded-xl shadow-2xl w-full max-w-lg mx-4 p-6 relative max-h-[80vh] overflow-y-auto border border-[#b03060] dark:border-[#800000] transition-all duration-300">

            <button id="close-search"
                class="absolute top-3 right-3 text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3
                class="text-xl font-bold mb-4 text-[#b03060] dark:text-[#ff4d6d] border-b border-[#b03060] dark:border-[#800000] pb-2">
                Search Results
            </h3>

            <div id="search-results" class="space-y-4 text-base text-[#660000] dark:text-[#ffd1d1]">
                <p class="italic text-[#800000] dark:text-[#ffcccc]">No results yet...</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer
        class="bg-[#fff0f0] dark:bg-[#330000] border-t border-[#b03060] dark:border-[#800000] text-center py-6 text-sm text-[#660000] dark:text-[#ffd1d1]">

        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; <span id="current-year">2024</span> University Campus Library — All Rights Reserved</p>
            <p class="mt-1 text-xs">Developed for Academic Use |
                <a href="#" class="text-[#b03060] dark:text-[#ff4d6d] hover:underline">Privacy Policy</a>
            </p>
        </div>
    </footer>



</body>

</html>