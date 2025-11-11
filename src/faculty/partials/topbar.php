<header id="topbar"
    class="bg-white dark:bg-gray-800 shadow-sm dark:shadow-lg dark:shadow-black/20 sticky top-0 z-10 flex-shrink-0">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Mobile Menu Button -->
            <button id="open-sidebar-btn"
                class="lg:hidden text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div class="flex-1 flex items-center justify-end">

                <!-- Dark Mode Toggle Button (New) -->
                <button id="dark-mode-toggle"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-300 transition duration-150 focus:outline-none">
                    <!-- The icon is set dynamically by JavaScript on load and toggle -->
                    <i data-lucide="sun" id="dark-mode-icon" class="w-6 h-6"></i>
                </button>

                <!-- Search Bar -->
                <div class="relative hidden sm:block ml-4">
                    <input type="text" placeholder="Search..."
                        class="pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-full focus:ring-indigo-500 focus:border-indigo-500 text-sm w-64 transition duration-150 bg-white dark:bg-gray-700 dark:text-gray-200">
                    <i data-lucide="search"
                        class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                </div>
                <!-- User Info -->
                <div class="ml-4 flex items-center space-x-3">
                    <span
                        class="text-sm font-medium text-gray-700 dark:text-gray-200 hidden md:block"><?php echo isset($_SESSION['faculty']) ? $_SESSION['faculty']['firstname'] .' '. $_SESSION['faculty']['lastname'] : ''; ?></span>
                    <img class="h-10 w-10 rounded-full object-cover shadow-lg ring-2 ring-indigo-500/50"
                        src="../../auth/<?php echo isset($_SESSION['faculty']) ? $_SESSION['faculty']['profile_pic'] : '';?>" alt="User Avatar">
                </div>
            </div>
        </div>
    </div>
</header>