<?php include "./header.php"; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark:bg-gray-800 ">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php get_option('system_title'); ?></title>

    <!-- IMMEDIATE THEME LOADER (Vanilla JS to prevent FOUC) -->
    <script>
        // Checks localStorage or system preference and applies 'dark' class instantly
        const THEME_KEY = "theme";
        const storedTheme = localStorage.getItem(THEME_KEY);
        const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        // Determine if dark mode should be active based on stored preference or system default
        const isDark = storedTheme ? storedTheme === "dark" : prefersDark;
        if (isDark) {
            document.documentElement.classList.add("dark");
        }
    </script>

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
    <header class="fixed top-0 w-full bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-0 flex justify-between items-center">
            <h1 class="flex items-center gap-2  text-indigo-700 dark:text-indigo-400">
                <img src="./assets/image/<?php echo htmlspecialchars(get_option('system_logo')); ?>"
                    alt="University Logo"
                    class="w-14 sm:w-20 h-auto rounded-full border m-2 border-indigo-300 dark:border-indigo-700 shadow-md" />
                <div class="flex flex-col leading-tight">
                    <span class="text-lg sm:text-2xl font-extrabold">
                        <?php echo htmlspecialchars(get_option('system_title')); ?>
                    </span>
                    <span
                        class="text-sm sm:text-base font-medium text-gray-600 dark:text-gray-400 truncate max-w-[200px] sm:max-w-[300px]">
                        <?php echo htmlspecialchars(get_option('system_description')); ?>
                    </span>
                </div>

            </h1>


            <div class="flex items-center gap-3 relative">
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle"
                    class="p-2 rounded-full text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <!-- Icon attribute is updated dynamically by JS upon load/toggle -->
                    <i id="dark-mode-icon" data-lucide="moon" class="w-5 h-5"></i>
                </button>
                <button data-view="home"
                    class="nav-link text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400 font-semibold px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                    <i data-lucide="home" class="inline-block w-4 h-4 mr-1"></i> Home
                </button>

                <!-- User Authentication Container (Dynamically updated) -->
                <div id="user-auth-container" class="relative">
                    <!-- 1. Logged Out State (Sign In Button) - Default shown -->
                    <button id="auth-sign-in-btn"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow-md hover:bg-indigo-700 transition transform hover:scale-105 text-sm sm:text-base font-medium">
                        <i data-lucide="log-in" class="inline-block w-4 h-4 mr-1"></i>Sign In
                    </button>

                    <!-- 2. Logged In State (Profile Button & Dropdown) - Default hidden -->
                    <button id="profile-btn"
                        class="hidden p-2 rounded-full border-2 border-indigo-400 dark:border-indigo-600 hover:ring-2 hover:ring-indigo-300 transition"
                        aria-expanded="false">
                        <i data-lucide="user" class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown"
                        class="hidden absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-2 animate-fade-in border border-gray-200 dark:border-gray-700 z-50 origin-top-right">
                        <div
                            class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 font-semibold border-b dark:border-gray-700 truncate">
                            <span id="profile-username">User ID: guest</span>
                        </div>
                        <a href="#" id="dropdown-my-profile" data-view-target="profile"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>My Profile
                        </a>
                        <a href="#" id="dropdown-my-books" data-view-target="books"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                            <i data-lucide="book" class="w-4 h-4 mr-2"></i>My Books
                        </a>
                        <a href="#" id="dropdown-settings" data-view-target="settings"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                            <i data-lucide="settings" class="w-4 h-4 mr-2"></i>Settings
                        </a>
                        <div class="border-t dark:border-gray-700 mt-1 pt-1">
                            <button id="logout"
                                class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Secondary Navigation (The Tabs) -->
        <!-- <nav class="bg-white dark:bg-gray-800 shadow-md border-t dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex space-x-4 h-12">

                    <button data-view="profile"
                        class="nav-link text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 border-b-2 border-transparent hover:border-indigo-300 dark:hover:border-indigo-600 px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                        <i data-lucide="user" class="inline-block w-4 h-4 mr-1"></i> My Profile
                    </button>
                    <button data-view="books"
                        class="nav-link text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 border-b-2 border-transparent hover:border-indigo-300 dark:hover:border-indigo-600 px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                        <i data-lucide="bookshelf" class="inline-block w-4 h-4 mr-1"></i> My Books
                    </button>
                    <button data-view="settings"
                        class="nav-link text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 border-b-2 border-transparent hover:border-indigo-300 dark:hover:border-indigo-600 px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                        <i data-lucide="settings" class="inline-block w-4 h-4 mr-1"></i> Settings
                    </button>
                </div>
            </div>
        </nav> -->
    </header>

    <!-- Main Content Wrapper to handle the padding for the fixed header (Approx. 110-118px height) -->
    <main class="pt-[110px] sm:pt-[118px] ">

        <!-- HOME SECTION -->
        <section id="home-section" class="view-section  overflow-hidden">
            <!-- Hero Section -->
            <section
                class="p-12  text-center px-4 bg-gradient-to-br from-indigo-50 dark:from-gray-900 to-white dark:to-gray-800">
                <h2 class="text-4xl sm:text-6xl font-extrabold mb-4 text-white leading-tight">
                    <span class="text-indigo-600 dark:text-white-400">Discover</span> Your Academic World
                </h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    The central hub for research, publications, and <strong>24/7 access</strong> to campus-wide academic
                    resources.
                </p>

                <!-- Search Bar -->
                <div class="flex justify-center mb-8">
                    <div class="w-full max-w-xl relative group">
                        <input id="search-input" type="text" placeholder="Search books, authors, or papers..."
                            class="w-full border-2 border-indigo-300 dark:border-gray-600 rounded-full p-4 pr-16 text-base dark:bg-gray-700 focus:ring-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-lg text-gray-900 dark:text-gray-100">
                        <button id="search-btn"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 italic">Over 1.2 million digital assets available.
                </p>
            </section>

            <!-- Services Section -->
            <section class="max-w-5xl text-white mx-auto px-6 pb-20">
                <h2 class="text-3xl font-bold text-center mb-12 pt-8">Core Library Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                        <i data-lucide="book-open-text"
                            class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3">Smart Metadata Management</h3>
                        <p class="text-base text-gray-600 dark:text-gray-400">Automatically extract, tag, and organize
                            metadata for books, theses, and research papers.</p>
                    </div>

                    <div
                        class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                        <i data-lucide="bot"
                            class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3">AI Library Chatbot</h3>
                        <p class="text-base text-gray-600 dark:text-gray-400">Get instant assistance for literature
                            reviews,
                            resource finding, and academic inquiries.</p>
                    </div>

                    <div
                        class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                        <i data-lucide="lock"
                            class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                        <h3 class="text-xl font-semibold mb-3">Secure Campus Access</h3>
                        <p class="text-base text-gray-600 dark:text-gray-400">Login safely using your university ID for
                            access to exclusive materials and your profile.</p>
                    </div>
                </div>
            </section>
        </section>

        <!-- MY PROFILE SECTION -->

        <section id="profile-section" class="view-section hidden text-white pt-8 pb-20 max-w-4xl mx-auto px-6 ">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">My Profile</h2>
            <div
                class="border-2 border-indigo-200 dark:border-gray-700 dark:bg-gray-800 p-8 rounded-xl shadow-lg space-y-4">
                <p class="text-lg font-medium">Welcome back, <span id="profile-view-username"
                        class="text-indigo-600 dark:text-indigo-400">Guest</span>!</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                    <p><strong>Status:</strong> <span id="profile-role">N/A</span></p>
                    <p><strong>Department:</strong> Computer Science</p>
                    <p><strong>Library ID:</strong> <span id="profile-view-id">N/A</span></p>
                    <p><strong>Email:</strong> user@university.edu</p>
                    <p><strong>Checkouts:</strong> 5 / 10 limit</p>
                    <p><strong>Fines:</strong> $0.00</p>
                </div>
                <button
                    class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition font-medium">Edit
                    Profile</button>
            </div>
            <div
                class="mt-8 p-6 border-2 border-indigo-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl shadow-lg border-indigo-500">
                <h3 class="text-xl font-semibold mb-3">Activity Log</h3>
                <ul class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-28:</span> Renewed "Data Structures"</li>
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-25:</span> Checked out "Literary Theory"</li>
                    <li><span class="font-mono text-gray-500 mr-2">2024-10-25:</span> Account logged in from campus IP
                    </li>
                </ul>
            </div>
        </section>

        <!-- MY BOOKS SECTION -->
        <section id="books-section"
            class="view-section hidden text-white pt-8 pb-20 max-w-6xl mx-auto px-6  rounded-2xl ">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">My Books & Resources</h2>
            <div class="border-2 border-indigo-200 dark:border-gray-700  dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                <h3 class="text-xl font-semibold mb-4 border-b pb-2 dark:border-gray-700">Currently Checked Out (3)</h3>
                <ul class="space-y-3 divide-y dark:divide-gray-700">
                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium">The Structure of Scientific Revolutions</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Thomas S. Kuhn</p>
                        </div>
                        <span class="text-sm text-red-600 dark:text-red-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Nov
                            15, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">Renew</button>
                    </li>

                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium">Designing Data-Intensive Applications</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Martin Kleppmann</p>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Dec
                            5, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">Renew</button>
                    </li>

                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3">
                        <div class="flex-1">
                            <span class="font-medium">Modern Literary Theory</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">M.H. Abrams</p>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-1 sm:mt-0 sm:mr-4">Due: Dec
                            10, 2024</span>
                        <button
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm border border-indigo-200 dark:border-indigo-600 rounded-full px-3 py-1 transition mt-2 sm:mt-0">Renew</button>
                    </li>
                </ul>
            </div>
        </section>

        <!-- SETTINGS SECTION -->
        <section id="settings-section" class="view-section text-white hidden pt-8 pb-20 max-w-4xl mx-auto px-6 ">
            <h2 class="text-4xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Account Settings</h2>
            <div class="border-2 border-indigo-200   dark:bg-gray-800 p-8 rounded-xl shadow-lg space-y-6">
                <!-- Theme Preferences -->
                <div class="">
                    <h3 class="text-xl font-semibold mb-2 flex items-center"><i data-lucide="palette"
                            class="w-5 h-5 mr-2 text-indigo-500"></i> Theme Preferences</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Change the visual appearance of the portal.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <button data-theme="light"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm">Light
                            Mode</button>
                        <button data-theme="dark"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm">Dark
                            Mode</button>
                        <button data-theme="system"
                            class="theme-select px-4 py-2 border rounded-full transition text-sm font-medium border-indigo-500 bg-indigo-100 dark:bg-indigo-900">System
                            Default</button>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="border-t pt-4 dark:border-gray-700">
                    <h3 class="text-xl font-semibold mb-3 flex items-center"><i data-lucide="bell"
                            class="w-5 h-5 mr-2 text-indigo-500"></i> Notification Settings</h3>
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
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 text-white flex flex-col items-end">
        <div id="chatbox"
            class="hidden w-72 sm:w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-4 mb-3 animate-fade-in border border-indigo-200 dark:border-indigo-900">
            <div class="flex justify-between items-center mb-3 border-b pb-2 dark:border-gray-700">
                <h4 class="font-bold text-indigo-600 text-white flex items-center">
                    <i data-lucide="bot" class="w-5 h-5 mr-2"></i>Library Assistant
                </h4>
                <button id="close-chat" class="text-gray-500 hover:text-red-500 transition p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="chat-messages"
                class="h-64 overflow-y-auto text-sm text-gray-700 dark:text-gray-300 mb-3 space-y-2 pr-1">
                <p class="text-gray-500 italic">Hi 👋 I'm your AI library assistant. Ask me anything!</p>
            </div>
            <div class="flex items-center gap-2">
                <input id="chat-input" type="text" placeholder="Ask a question..."
                    class="flex-1 border rounded-lg p-2 text-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 transition text-gray-900 dark:text-gray-100">
                <button id="send-btn" class="bg-indigo-600 text-white p-2 rounded-lg hover:bg-indigo-700 transition">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
        <button id="chatbot-toggle"
            class="bg-indigo-600 text-white p-4 rounded-full shadow-xl hover:bg-indigo-700 transition transform hover:scale-105">
            <i data-lucide="message-circle" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Login Modal (Now used for Sign In) -->
    <div id="login-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm z-[100] items-center justify-center transition-opacity duration-300">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-80 sm:w-96 p-8 relative animate-fade-in border border-indigo-300 dark:border-indigo-700">
            <button id="close-login" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <h3 class="text-2xl font-bold text-center mb-6 text-indigo-600 dark:text-indigo-400">
                <i data-lucide="user-check" class="inline-block w-6 h-6 mr-1 align-text-bottom"></i> Campus Sign In
            </h3>
            <!-- ✅ FIXED: Form ID is 'login-form' and inputs have correct IDs -->
            <form id="login" class="space-y-4">
                <input type="text" id="username-input" name="username" placeholder="University ID or Email" required
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition text-gray-900 dark:text-gray-100">
                <input type="password" name="password" id="password-input" placeholder="Password" required
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition text-gray-900 dark:text-gray-100">
                <p id="login-message" class="text-sm text-center hidden"></p>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-7G00 transition transform hover:scale-[1.01]">Sign
                    In</button>
                <button type="button"
                    class="w-full text-indigo-600 dark:text-indigo-400 text-sm mt-2 hover:underline">Forgot
                    Password?</button>
            </form>
        </div>
    </div>

    <!-- Search Modal -->
    <div id="search-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm flex items-center justify-center z-[100] transition-opacity duration-300">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg mx-4 p-6 relative max-h-[80vh] overflow-y-auto animate-fade-in border border-indigo-300 dark:border-indigo-700">
            <button id="close-search" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <h3
                class="text-xl text-white font-bold mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2 dark:border-gray-700">
                Search Results</h3>
            <div id="search-results" class="space-y-4 text-base text-gray-700 dark:text-gray-300">
                <p class="text-gray-500 italic">No results yet...</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer
        class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-6 text-sm text-gray-600 dark:text-gray-400">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; <span id="current-year">2024</span> University Campus Library — All Rights Reserved</p>
            <p class="mt-1 text-xs">Developed for Academic Use | <a href="#"
                    class="text-indigo-600 dark:text-indigo-400 hover:underline">Privacy Policy</a></p>
        </div>
    </footer>


</body>

</html>