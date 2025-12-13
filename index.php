<?php include "./header.php"; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark:bg-white-800 ">

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
            background-color: #fa8b8bff;
            /* Indigo 400 */
            border-radius: 3px;
        }

        .dark #chat-messages::-webkit-scrollbar-thumb {
            background-color: #b62e2eff;
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
                    alt="University Logo" class="sm:w-20 w-20 h-20 m-1 rounded-full border-1 border-white shadow-md" />
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
                    class="p-2 rounded-full text-white hover:bg-white/20  dark:hover:bg-gray-700 transition">
                    <i id="dark-mode-icon" data-lucide="moon" class="w-5 h-5"></i>
                </button>

                <!-- Home Button -->
                <button data-view="home"
                    class="nav-link text-white border-b-2 border-white font-semibold px-3 py-2 text-sm transition-colors duration-200 focus:outline-none">
                    <i data-lucide="home" class="inline-block w-4 h-4 mr-1 text-white"></i>
                </button>

                <div id="user-auth-container" class="relative">
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
                            <span>User ID: <i id="profile-username">test</i></span>
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

    <main class="pt-[110px] sm:pt-[118px] ">

        <!-- HOME SECTION -->
        <section id="home-section" class="view-section overflow-hidden">

            <!-- Hero Section -->
            <section
                class="p-12 text-center px-4 bg-gradient-to-br from-[#ffe5e5] via-[#ffcccc] to-[#b03060] dark:from-[#330000] dark:via-[#660000] dark:to-[#800000] transition-colors duration-300">

                <h2 class="text-4xl sm:text-6xl font-extrabold mb-4 leading-tight">
                    <span class="text-[#800000] dark:text-[#ff4d6d]">Discover</span>
                    <span class="text-[#660000] dark:text-[#ffe5e5]">Your Favorite Books</span>
                </h2>

                <p class="text-lg text-[#660000] dark:text-[#ffd1d1] mb-8 max-w-3xl mx-auto">
                    The central hub for research, publications, and
                    <strong>Digital library</strong> to campus-wide academic resources.
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
                    Our digital library assets available.
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

        <!-- PROFILE SECTION -->
        <section id="profile-section" class="view-section hidden pt-8 pb-20 max-w-4xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-[#b03060] dark:text-[#ff4d6d]">My Profile</h2>

            <form id="profile-edit-form" enctype="multipart/form-data"
                class="border-2 border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] p-8 rounded-2xl shadow-lg space-y-6 max-w-3xl mx-auto">

                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

                    <!-- Profile Picture -->
                    <div class="relative">
                        <?php
                        $profilePic = $_SESSION['student']['profile_pic'] ?? '';
                        ?>
                        <img id="profile-picture" alt="Profile Picture"
                            src="<?php echo base_url() . "auth/" . $profilePic; ?>"
                            class="w-32 h-32 rounded-full border-4 border-[#b03060] shadow-md object-cover">

                        <label for="profile-picture-input"
                            class="absolute bottom-1 right-1 bg-[#b03060] text-white p-2 rounded-full text-xs hover:bg-[#800000] transition cursor-pointer">
                            <i data-lucide="camera" class="w-4 h-4"></i>
                        </label>

                        <input type="file" id="profile-picture-input" name="profile_pic" class="hidden"
                            accept="image/*">
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <label class="block text-[#660000] dark:text-[#ffd1d1] font-medium mb-1">Full Name</label>

                        <input type="text" name="lastname" id="edit-lastname"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a] mb-2"
                            placeholder="Enter your last name">

                        <input type="text" name="firstname" id="edit-firstname"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a] mb-2"
                            placeholder="Enter your first name">

                        <input type="text" name="middlename" id="edit-middlename"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a] mb-2"
                            placeholder="Enter your middle name">

                        <input type="text" name="suffix" id="edit-suffix"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a]"
                            placeholder="Suffix (Optional)">

                        <p class="text-sm text-[#800000] dark:text-[#ffcccc] font-medium mt-2">
                            Role:
                            <span id="profile-role" class="ml-1"></span>
                        </p>
                    </div>
                </div>

                <!-- Profile Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-[#660000] dark:text-[#ffd1d1] mt-4">

                    <div>
                        <label class="block mb-1 font-medium">Status</label>
                        <input type="text" name="status" id="profile-status"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a]" readonly>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Department</label>
                        <input type="text" name="department" id="profile-department"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a]"
                            value="<?php echo $_SESSION['student']['department'] ?? ''; ?>">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Library ID</label>
                        <input type="text" name="library_id" id="profile-library_id"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a]"
                            value="<?php echo $_SESSION['student']['library_id'] ?? ''; ?>" readonly>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" id="profile-email"
                            class="w-full p-2 rounded-lg border border-[#b03060] bg-white dark:bg-[#4d1a1a]"
                            value="<?php echo $_SESSION['student']['email'] ?? ''; ?>">
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="submit"
                        class="px-6 py-2 rounded-full bg-[#b03060] text-white hover:bg-[#800000] transition">
                        Update Profile
                    </button>
                </div>
            </form>

            <!-- Activity Log -->
            <div
                class="mt-8 p-6 border-2 border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] rounded-xl shadow-lg">
                <h3 class="text-xl font-semibold mb-3 text-[#660000] dark:text-[#ffd1d1]">Activity Log</h3>
                <ul class="text-sm space-y-1 text-[#660000] dark:text-[#ffd1d1] overflow-auto h-40 max-h-40"
                    id="activity-log">
                </ul>
            </div>
        </section>


        <!-- MY BOOKS SECTION -->
        <section id="books-section" class="view-section hidden pt-8 pb-20 max-w-6xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-[#b03060] dark:text-[#ff4d6d]">My Books & Resources</h2>

            <div
                class="border-2 border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] p-6 rounded-xl shadow-lg">
                <h3
                    class="text-xl font-semibold mb-4 border-b border-[#b03060] dark:border-[#800000] text-[#660000] dark:text-[#ffd1d1]">
                    Currently Checked Out</h3>

                <div id="favorites-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Favorite books will be appended here -->
                </div>
            </div>
        </section>

        <!-- SETTINGS SECTION -->
        <section id="settings-section" class="view-section hidden pt-8 pb-20 max-w-4xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6 text-[#b03060] dark:text-[#ff4d6d]">Account Settings</h2>

            <div
                class="border-2 border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] p-8 rounded-xl shadow-lg space-y-6">
                <!-- Theme Preferences -->
                <div>
                    <h3 class="text-xl font-semibold mb-2 flex items-center text-[#660000] dark:text-[#ffd1d1]">
                        <i data-lucide="palette" class="w-5 h-5 mr-2 text-[#b03060]"></i> Theme Preferences
                    </h3>
                    <p class="text-[#800000] dark:text-[#ffcccc] text-sm mb-3">
                        Change the visual appearance of the portal.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <button data-theme="light"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-[#ffd1d1] dark:hover:bg-[#660000] transition text-sm text-[#660000] dark:text-[#ffd1d1]">
                            Light Mode
                        </button>
                        <button data-theme="dark"
                            class="theme-select px-4 py-2 border rounded-full hover:bg-[#ffd1d1] dark:hover:bg-[#660000] transition text-sm text-[#660000] dark:text-[#ffd1d1]">
                            Dark Mode
                        </button>
                        <button data-theme="system"
                            class="theme-select px-4 py-2 border rounded-full transition text-sm font-medium border-[#b03060] bg-[#fff0f0] dark:bg-[#330000] text-[#b03060] dark:text-[#ff4d6d]">
                            System Default
                        </button>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="border-t pt-4 border-[#b03060] dark:border-[#800000]">
                    <h3 class="text-xl font-semibold mb-3 flex items-center text-[#660000] dark:text-[#ffd1d1]">
                        <i data-lucide="bell" class="w-5 h-5 mr-2 text-[#b03060]"></i> Notification Settings
                    </h3>
                    <label class="flex items-center space-x-3 cursor-pointer mt-2">
                        <input type="checkbox" checked
                            class="form-checkbox text-[#b03060] rounded-sm w-5 h-5 focus:ring-[#b03060] dark:bg-[#440000] dark:border-[#800000]">
                        <span class="text-[#660000] dark:text-[#ffd1d1]">Email notifications for due dates</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer mt-2">
                        <input type="checkbox"
                            class="form-checkbox text-[#b03060] rounded-sm w-5 h-5 focus:ring-[#b03060] dark:bg-[#440000] dark:border-[#800000]">
                        <span class="text-[#660000] dark:text-[#ffd1d1]">Portal alerts for new features</span>
                    </label>
                </div>

                <!-- Change Password Section -->
                <div class="border-t pt-4 border-[#b03060] dark:border-[#800000]">
                    <h3 class="text-xl font-semibold mb-3 flex items-center text-[#660000] dark:text-[#ffd1d1]">
                        <i data-lucide="key" class="w-5 h-5 mr-2 text-[#b03060]"></i> Change Password
                    </h3>

                    <form id="change-password-form" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#660000] dark:text-[#ffd1d1] mb-1"
                                for="current-password">
                                Current Password
                            </label>
                            <input type="password" id="current-password" name="current-password"
                                class="w-full px-4 py-2 border rounded-lg border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] text-[#660000] dark:text-[#ffd1d1] focus:ring-[#b03060] focus:outline-none"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#660000] dark:text-[#ffd1d1] mb-1"
                                for="new-password">
                                New Password
                            </label>
                            <input type="password" id="new-password" name="new-password"
                                class="w-full px-4 py-2 border rounded-lg border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] text-[#660000] dark:text-[#ffd1d1] focus:ring-[#b03060] focus:outline-none"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#660000] dark:text-[#ffd1d1] mb-1"
                                for="confirm-password">
                                Confirm New Password
                            </label>
                            <input type="password" id="confirm-password" name="confirm-password"
                                class="w-full px-4 py-2 border rounded-lg border-[#b03060] dark:border-[#800000] bg-[#fff0f0] dark:bg-[#330000] text-[#660000] dark:text-[#ffd1d1] focus:ring-[#b03060] focus:outline-none"
                                required>
                        </div>

                        <button type="submit"
                            class="px-6 py-2 bg-[#b03060] dark:bg-[#800000] text-white rounded-lg hover:bg-[#ff4d6d] dark:hover:bg-[#a00000] transition">
                            Update Password
                        </button>
                    </form>
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
                    <i data-lucide="bot" class="w-5 h-5 mr-2"></i>LiBot Assistance
                </h4>
                <button id="close-chat" class="text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div id="chat-messages"
                class="h-64 overflow-y-auto text-sm mb-3 space-y-2 pr-1 text-[#660000] dark:text-[#ffd1d1]">
                <p class="italic text-[#800000] dark:text-[#ffcccc]">
                    👋 Hi! How can we help?
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
                <i data-lucide="user-check" class="inline-block w-6 h-6 mr-1 align-text-bottom"></i> Sign In
            </h3>

            <form id="login" class="space-y-4">
                <input type="text" id="username-input" name="username" placeholder="Library ID # or Email" required
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
                <!-- Inside login form -->
                <button type="button" class="w-full text-[#b03060] dark:text-[#ff4d6d] text-sm mt-3 ">
                    Don’t have an account? <span id="open-register" class="font-semibold hover:underline">Register
                        here</span>
                </button>

            </form>
        </div>
    </div>


    <div id="register-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm z-[100] flex items-center justify-center transition-opacity duration-300">

        <div
            class="bg-[#fff0f0] dark:bg-[#330000] rounded-xl shadow-2xl w-[95%] sm:w-[800px] p-6 relative animate-fade-in border border-[#b03060] dark:border-[#800000] flex flex-col sm:flex-row gap-6">

            <!-- Close Button -->
            <button id="close-register"
                class="absolute top-3 right-3 text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <!-- LEFT: Profile Upload -->
            <div
                class="flex flex-col items-center justify-center w-full sm:w-[35%] border-r border-[#b03060]/40 dark:border-[#800000]/40 pr-4">
                <div
                    class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-[#b03060] dark:border-[#800000]">
                    <img id="profile-preview" src="http://localhost/UniversityLibrary/assets/images/system_logo/LIBRARY.png" alt="Profile Preview"
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
                <h3 class="text-2xl font-bold text-center mb-3 text-[#b03060] dark:text-[#ff4d6d]">
                    <i data-lucide="user-plus" class="inline-block w-8 h-8 mr-1 align-text-bottom"></i>
                    Registration
                </h3>

                <form id="register" class="space-y-2" enctype="multipart/form-data">
                    <!-- ROLE SELECTOR -->
                    <div class="flex gap-3 justify-center mb-2">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="admin_office" class="accent-[#b03060]"> Admin
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="faculty" class="accent-[#b03060]"> Faculty
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="student" class="accent-[#b03060]"> Student
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="visitor" class="accent-[#b03060]"> Visitor
                        </label>


                    </div>

                    <!-- NAME FIELDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="lastname" placeholder="Last Name" required
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <input type="text" name="firstname" placeholder="First Name" required
                            class=" uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <input type="text" name="middlename" placeholder="Middle Name"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <select name=" suffix"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option value="" selected>No Suffix</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                        </select>

                    </div>

                    <!-- STUDENT FIELDS -->
                    <div id="student-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <input type="text" name="student_id" placeholder="Student ID"
                            class=" uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <select name="student_gender"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>

                        <select name="student_department"
                            class="uppercase col-span-1 sm:col-span-2 border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Department</option>
                            <option value="College of Information Computing and Sciences">College of Information
                                Computing and Sciences</option>
                            <option value="College of Maritime Education">College of Maritime Education</option>
                            <option value="College of Engineering & Technology Department">College of Engineering &
                                Technology </option>
                            <option value="College of Arts, Humanities and Social Sciences">College of Arts, Humanities
                                and Social Sciences</option>
                            <option value="College of Physical Education and Sports">College of Physical Education and
                                Sports</option>
                            <option value="College of Engineering and Technology">College of Engineering and Technology
                            </option>
                            <option value="School of Business Administration">School of Business Administration</option>
                            <option value="College of Teacher Education">College of Teacher Education</option>
                        </select>

                        <select id="course_select" name="course"
                            class="uppercase col-span-1 sm:col-span-2 border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Course</option>
                        </select>
                    </div>

                    <!-- FACULTY FIELDS -->
                    <div id="faculty-fields" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <input type="text" name="employee_id" placeholder="Employee ID"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <select name="faculty_gender"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>

                        <select name="faculty_department"
                            class=" uppercase col-span-1 sm:col-span-2 border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Department</option>
                            <option value="College of Maritime Education">College of Maritime Education</option>
                            <option value="College of Engineering & Technology Department">College of Engineering &
                                Technology Department</option>
                            <option value="College of Arts, Humanities and Social Sciences">College of Arts, Humanities
                                and Social Sciences</option>
                            <option value="College of Physical Education and Sports">College of Physical Education and
                                Sports</option>
                            <option value="College of Engineering and Technology">College of Engineering and Technology
                            </option>
                            <option value="School of Business Administration">School of Business Administration</option>
                            <option value="College of Teacher Education">College of Teacher Education</option>
                        </select>


                    </div>

                    <div id="admin-fields" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <input type="text" name="admin_employee_id" placeholder="Employee ID"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                        <select name="admin_gender"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>

                        <select name="admin_offices"
                            class="uppercase col-span-1 sm:col-span-2 border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Office</option>
                            <option value="Admissions Office">Admissions Office</option>
                            <option value="Office of Student Affairs and Services (OSAS)">Office of Student
                                Affairs and Services (OSAS)</option>
                            <option value="Career Services & Public Employment Service Office (PESO)">Career
                                Services & Public Employment Service Office (PESO)</option>
                            <option value="Public Information Office (PIO)">Public Information Office (PIO)
                            </option>
                            <option value="Office of the Vice President for Academic Affairs">Office of the Vice
                                President for Academic Affairs
                            </option>
                            <option value="Office of the President">Office of the President</option>
                            <option value="Medical-Dental Health Services">Medical-Dental Health Services
                            </option>
                        </select>
                    </div>

                    <!-- VISITOR FIELDS -->
                    <div id="visitor-fields" class="hidden grid grid-cols-2 sm:grid-cols-2 gap-3 mt">
                        <select name="visitor_gender"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <option disabled selected>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>

                        <input type="text" name="schoolname" placeholder="School Name"
                            class="uppercase border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-1 ">
                        <div class="grid grid-cols-3 sm:grid-cols-3 gap-3">
                            <input type="email" name="email" placeholder="Email" required
                                class=" border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                            <input type="password" name="password" placeholder="Password" required
                                class=" border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">

                            <input type="password" name="confirm_password" placeholder="Confirm Password" required
                                class="border-2 border-[#b03060] rounded-lg p-3 dark:bg-[#440000] text-[#660000] dark:text-[#ffd1d1]">
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <p id="register-message" class="text-sm text-red-500 hidden"></p>

                    <button type="submit"
                        class="w-full bg-[#b03060] text-white font-semibold py-3 rounded-lg hover:bg-[#800000] transition transform hover:scale-[1.01]">
                        Register Account
                    </button>

                    <button type="button" class="w-full text-[#b03060] dark:text-[#ff4d6d] text-sm mt-2">
                        Already have an account? <span id="open-login-from-register"
                            class="font-semibold  hover:underline">Sign In</span>
                    </button>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            // ===== Profile Preview =====
            $('#profile').on('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => $('#profile-preview').attr('src', e.target.result);
                reader.readAsDataURL(file);
            });

            // ===== Role Toggle =====
            function toggleRoleFields(role) {
                // Hide all first
                $('#student-fields, #faculty-fields,#zppsu_offices, #visitor-fields, #admin-fields')
                    .addClass('hidden');

                if (role === 'student') {
                    $('#student-fields').removeClass('hidden');
                }
                else if (role === 'faculty') {
                    $('#faculty-fields').removeClass('hidden');
                }
                else if (role === 'visitor') {
                    $('#visitor-fields').removeClass('hidden');
                }
                else if (role === 'admin_office') {
                    $('#admin-fields').removeClass('hidden');
                    $("#zppsu_offices").removeClass('hideen');
                }
            }

            // Detect role change
            $('input[name="role"]').on('change', function () {
                toggleRoleFields($(this).val());
            });

            // Initialize default on page load
            toggleRoleFields($('input[name="role"]:checked').val());


            const courses = {
                "College of Maritime Education": [
                    "Bachelor of Science Marine Transportation",
                    "Bachelor of Science Marine Engineering"
                ],
                "College of Information Computing and Sciences": [
                    "Bachelor of Science Information Technology",
                    "Bachelor of Science Information System"
                ],
                "College of Engineering & Technology Department": [
                    "Bachelor of Science Computer Engineering",
                    "Bachelor of Science Electrical Engineering"
                ],
                "College of Arts, Humanities and Social Sciences": [
                    "BA Communication",
                    "BA Political Science"
                ],
                "College of Physical Education and Sports": [
                    "Bachelor of Science Physical Education",
                    "Bachelor of Science Sports Science"
                ],
                "College of Engineering and Technology": [
                    "Bachelor of Science Mechanical Engineering",
                    "Bachelor of Science Civil Engineering"
                ],
                "School of Business Administration": [
                    "Bachelor of Science Business Administration",
                    "Bachelor of Science Accounting"
                ],
                "College of Teacher Education": [
                    "Bachelor of Science Education major in English",
                    "Bachelor of Science Education major in Math"
                ]
            };

            $('select[name="student_department"]').on('change', function () {
                let dept = $(this).val();
                let $courseSelect = $('#course_select');

                // Clear previous
                $courseSelect.empty();

                // Show the select
                $courseSelect.removeClass('hidden');

                // Add default option
                $courseSelect.append(`<option disabled selected>Select Course</option>`);

                // Insert the department's courses
                if (courses[dept]) {
                    courses[dept].forEach(course => {
                        $courseSelect.append(`<option value="${course}">${course}</option>`);
                    });
                }
            });





            // ===== Modal Controls =====
            function toggleModal(showSelector, hideSelector) {
                $(hideSelector).addClass('hidden').attr('aria-expanded', 'false');
                $(showSelector).removeClass('hidden').attr('aria-expanded', 'true');
            }

            // Open/Close Modals
            $('#open-register').on('click', () => toggleModal('#register-modal', '#login-modal'));
            $('#open-login-from-register').on('click', () => toggleModal('#login-modal', '#register-modal'));
            $('#close-register').on('click', () => $('#register-modal').addClass('hidden').attr('aria-expanded', 'false'));

            // ===== Registration Form =====
            $('#register').on('submit', function (e) {
                e.preventDefault();

                const formDataObj = {};

                // ----- 1. Capture radio buttons (role) -----
                formDataObj.role = $('input[name="role"]:checked').val();

                // ----- 2. Capture all inputs -----
                $(this).find("input, select").each(function () {
                    const type = $(this).attr("type");
                    const name = $(this).attr("name");

                    if (!name) return;

                    // Skip file inputs
                    if (type === "file") return;

                    // Handle radio buttons
                    if (type === "radio") {
                        // Only take checked radio
                        if ($(this).is(":checked")) {
                            formDataObj[name] = $(this).val();
                        } else if (!(name in formDataObj)) {
                            formDataObj[name] = null;
                        }
                        return;
                    }

                    // Handle select elements
                    if ($(this).is("select")) {
                        const val = $(this).val();
                        if (!val) {
                            $(this).addClass("border-red-500"); // optional visual feedback
                        } else {
                            $(this).removeClass("border-red-500");
                        }
                        formDataObj[name] = val;
                        return;
                    }

                    // Normal inputs
                    formDataObj[name] = $(this).val();
                });


                // ----- 3. Capture ALL select dropdowns -----
                $(this).find("select").each(function () {
                    const name = $(this).attr("name");
                    if (!name) return;
                    formDataObj[name] = $(this).val();
                });

                // ----- 4. Handle Profile Picture (Base64) -----
                const fileInput = $('#profile')[0]?.files[0];

                if (fileInput) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        formDataObj.profile_pic = e.target.result;
                        sendRegisterRequest(formDataObj);
                    };
                    reader.readAsDataURL(fileInput);
                } else {
                    sendRegisterRequest(formDataObj);
                }
            });

            function sendRegisterRequest(data) {
                console.log(data);
                $.ajax({
                    url: `${base_url}auth/action.php?action=register_user`,
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function (res) {
                        let response;
                        try {
                            response = typeof res === 'string' ? JSON.parse(res) : res;
                        } catch {
                            response = { status: 0, message: 'Unexpected server response.' };
                        }

                        $('#register-message')
                            .removeClass('hidden text-red-500 text-green-500')
                            .addClass(response.status === 1 ? 'text-green-500' : 'text-red-500')
                            .text(response.message);

                        if (response.status === 1) {
                            $('#register')[0].reset();
                            $('#profile-preview').attr('src', base_url+'assets/images/system_logo/library.png');
                            setTimeout(() => toggleModal('#login-modal', '#register-modal'), 1500);
                        }
                    },
                    error: function () {
                        $('#register-message')
                            .removeClass('hidden text-red-500 text-green-500')
                            .addClass('text-red-500')
                            .text('Failed to connect to the server.');
                    }
                });
            }
        });
    </script>




    <!-- Search Modal -->
    <div id="search-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm flex items-center justify-center z-[100] transition-opacity duration-300">

        <div
            class="bg-[#fff0f0] dark:bg-[#330000] rounded-xl shadow-2xl w-full max-w-lg mx-4 p-0 relative max-h-[80vh] border border-[#b03060] dark:border-[#800000] transition-all duration-300 flex flex-col">

            <!-- Header: sticky -->
            <div
                class="p-6 border-b border-[#b03060] dark:border-[#800000] sticky top-0 bg-[#fff0f0] dark:bg-[#330000] z-10 flex items-center justify-between">
                <h3 class="text-xl font-bold text-[#b03060] dark:text-[#ff4d6d]">
                    Search Results
                </h3>
                <button id="close-search" class="text-[#800000] dark:text-[#ffcccc] hover:text-red-500 transition p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div id="search-results"
                class="p-6 overflow-y-auto flex-1 space-y-4 text-base text-[#660000] dark:text-[#ffd1d1]">
                <p class="italic text-[#800000] dark:text-[#ffcccc]">No results yet...</p>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer
        class="bg-[#fff0f0] dark:bg-[#330000] border-t border-[#b03060] dark:border-[#800000] text-center py-6 text-sm text-[#660000] dark:text-[#ffd1d1]">

        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; <span id="current-year">2024</span> Zamboanga Peninsula Polytechnic State University Campus
                Library — All Rights Reserved</p>
            <p class="mt-1 text-xs">Developed for Academic Use by TechGeek Major |
                <a href="https://privacy.gov.ph/data-privacy-act/"
                    class="text-[#b03060] dark:text-[#ff4d6d] hover:underline">Privacy Policy</a>
            </p>
        </div>
    </footer>
</body>

</html>

<script>
    $(document).ready(function () {
        const $container = $("#favorites-container");

        $("#dropdown-my-books").on("click", function () {
            $.ajax({
                url: base_url + "auth/action.php?action=get_favorite_books",
                type: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res); // <-- debug the response
                    if (res.status === 1 && res.data.length) {
                        $container.empty();
                        res.data.forEach(book => {
                            const bookHtml = `
                                <div class="relative bg-[#fff0f0] dark:bg-[#330000] p-4 rounded-xl shadow-lg flex flex-col items-center text-center">

                                <!-- X BUTTON -->
                                <button  data-title="${book.title}" data-id="${book.book_id}" class="remove-btn absolute top-2 right-2 text-[#b03060] dark:text-[#ff4d6d] hover:text-[#800000] dark:hover:text-[#ff9999] text-lg font-bold close-card-btn">
                                    ✕
                                </button>

                                <img src="${book.cover_url || base_url + 'assets/image/library.png'}" 
                                    alt="${book.title} Cover" 
                                    class=" w-25 h-40 object-cover rounded-lg mb-3">

                                <p class="font-semibold text-[#660000] dark:text-[#ffd1d1] mb-1">${book.title}</p>
                                <p class="text-sm text-[#800000] dark:text-[#ffcccc] mb-3">${book.author}</p>

                                <button class="read-btn text-[#b03060] hover:text-[#800000] dark:text-[#ff4d6d] dark:hover:text-[#ff9999] text-sm border border-[#b03060] dark:border-[#800000] rounded-full px-3 py-1 transition"
                                        data-file="${book.file_url}">
                                    Read
                                </button>
                            </div>

                        `;
                            $container.append(bookHtml);
                        });
                        $("#books-section").removeClass("hidden");
                    } else if (res.status === 0) {
                        alert("Error: " + res.message);
                    } else {
                        $container.html(`<p class="text-gray-500 dark:text-gray-400">No favorite books found.</p>`);
                        $("#books-section").removeClass("hidden");
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // debug raw response
                    alert("AJAX Error: " + error);
                }
            });

        });
        $container.on("click", ".read-btn", function () {
            const filePath = $(this).data("file");
            console.log("Requesting reading session for file:", filePath);
            if (!filePath) return;

            console.log("Requesting reading session for file:", filePath);

            const $btn = $(this);
            $btn.prop("disabled", true).text("Opening...");

            $.ajax({
                url: base_url + "auth/action.php?action=readingbooks",
                type: "POST",
                data: { file: filePath }, // encode special chars
                dataType: "json",
                success: function (res) {
                    if (res && res.status === 1 && res.data) {
                        console.log("Received token:", res.data);
                        window.open(res.data, "_blank");
                    } else {
                        alert(res?.message || "Failed to open the book.");
                    }
                },
                error: function (err) {
                    console.error("Error starting reading session:", err);
                    alert("Failed to open the book.");
                },
                complete: function () {
                    $btn.prop("disabled", false).text("Read"); // reset button text
                }
            });
        });
        $container.on("click", ".remove-btn", function () {
            const title = $(this).data("title");

            if (!title) return;

            $.ajax({
                url: base_url + "auth/action.php?action=remove_favorite",
                type: "POST",
                data: { file: title },
                dataType: "json",
                success: function (res) {
                    if (res && res.status === 1 && res.data) {
                        alert("Book removed from favorites.");

                    } else {
                        alert(res?.message || "Failed to open the book.");
                    }
                    window.location.reload();
                },
                error: function (err) {
                    console.error("Error starting reading session:", err);
                    alert("Failed to open the book.");
                },
                complete: function () {
                    $btn.prop("disabled", false).text("Read"); // reset button text
                }
            });
        });

        loadActivityLog();
        function loadActivityLog() {
            $.ajax({
                url: base_url + "auth/action.php?action=get_activity_log",
                type: "GET",
                dataType: "json",
                success: function (res) {
                    if (!res.status) return;

                    let html = "";

                    res.data.forEach(item => {
                        html += `
                            <li>
                                <span class="font-mono text-[#800000] dark:text-[#ffcccc] mr-2">
                                    ${item.log_time}:
                                </span>
                                ${item.activity}
                            </li>`;
                    });

                    $("#activity-log").html(html);
                },
                error: function () {
                    console.log("Failed to fetch activity log.");
                }
            });
        }

        loadProfile();

        function loadProfile() {
            $.ajax({
                url: `${base_url}auth/action.php?action=GetUser`,
                type: "POST",
                data: {
                    action: "GetUser",
                    user_id: '<?php echo $_SESSION['student']['user_id'] ?? '' ?>'
                },
                dataType: "json",
                success: function (res) {
                    if (res.status === 1 && res.data) {
                        const completename = res.data.personal.firstname + " " + res.data.personal.middlename + " " + res.data.personal.lastname;

                        $('#profile-username').text(res.data.personal.library_id);
                        $("#edit-firstname").val(res.data.personal.firstname || '');
                        $("#edit-middlename").val(res.data.personal.middlename || '');
                        $("#edit-lastname").val(res.data.personal.lastname || '');
                        $("#edit-suffix").val(res.data.personal.suffix || '');
                        $("#profile-status").val(res.data.auth.account_status || '');
                        $("#profile-department").val(res.data.personal.department || '');
                        $("#profile-library_id").val(res.data.personal.library_id || '');
                        $("#profile-email").val(res.data.auth.email || '');
                        $("#profile-role").text(res.data.auth.user_role ? capitalize(res.data.auth.user_role) : 'Student');

                        if (res.data.personal.profile_pic) {
                            $("#profile-picture").attr("src", base_url + "auth/" + res.data.personal.profile_pic);
                        }
                    } else {
                        //alert(res.message  "Could not load profile.");
                    }
                    loadActivityLog();
                },
                error: function () {
                    alert("Server error while fetching profile.");
                }
            });
        }

        // Submit profile edit via AJAX
        $("#profile-edit-form").on("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("user_id", <?php echo $_SESSION['student']['user_id'] ?? '' ?>);

            $.ajax({
                url: `${base_url}auth/action.php?action=updateUser`,
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("button[type=submit]").prop("disabled", true).text("Updating...");
                },
                success: function (res) {
                    if (res.status === 1) {
                        alert(res.message || "Profile updated successfully.");
                        loadProfile(); // refresh fields
                    } else {
                        alert(res.message || "Failed to update profile.");
                    }
                    loadActivityLog();
                },
                error: function () {
                    alert("Server error while updating profile.");
                },
                complete: function () {
                    $("button[type=submit]").prop("disabled", false).text("Update Profile");
                }
            });
        });

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Profile picture preview on file select
        $("#profile-picture-input").on("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => $("#profile-picture").attr("src", e.target.result);
                reader.readAsDataURL(file);
            }
        });

    });
</script>