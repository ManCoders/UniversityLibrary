<?php
$currentPage = $page ?? 'dashboard';

// Define navigation links
$navLinks = [
    ['id' => 'dashboard', 'text' => 'Dashboard', 'icon' => 'layout-dashboard'],
    ['id' => 'metadata', 'text' => 'Metadata Management', 'icon' => 'book-open'],
    ['id' => 'users', 'text' => 'User Management', 'icon' => 'users'],
    ['id' => 'reports', 'text' => 'Analytics & Reports', 'icon' => 'bar-chart-3'],
    ['id' => 'settings', 'text' => 'Settings', 'icon' => 'settings'],
];
?>

<nav id="sidebar"
    class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out bg-white dark:bg-gray-800 w-64 p-4 shadow-xl z-30 flex flex-col">

    <!-- Sidebar Header / Logo -->
    <div class="flex items-center justify-between h-16 border-b border-gray-100 dark:border-gray-700 mb-6 flex-shrink-0">
        <div class="text-xl font-bold text-indigo-700 dark:text-indigo-400 flex items-center">
            <i data-lucide="layout-grid" class="w-6 h-6 mr-2"></i>
            Admin Panel
        </div>
        <button id="close-sidebar-btn" class="lg:hidden text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <ul class="space-y-2 flex-grow">
        <?php foreach ($navLinks as $link):
            $isActive = ($link['id'] === $currentPage);
            $classes = $isActive
                ? 'flex items-center p-3 text-sm font-medium text-white bg-indigo-600 dark:bg-indigo-700 rounded-lg shadow-md transition duration-150'
                : 'flex items-center p-3 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-700 dark:hover:text-indigo-300 rounded-lg transition duration-150';
        ?>
            <li>
                <a href="?page=<?= $link['id'] ?>" class="nav-link <?= $classes ?>">
                    <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5 mr-3"></i>
                    <?= $link['text'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Logout -->
    <div class="mt-auto pt-6 border-t border-gray-100 dark:border-gray-700 flex-shrink-0">
        <a id="logout" href="#"
            class="flex items-center p-3 text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-red-600 rounded-lg transition duration-150">
            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>Sign Out
        </a>
    </div>
</nav>

<!-- Sidebar overlay for mobile -->
<div id="sidebar-overlay"
    class="fixed inset-0 bg-black/50 opacity-0 lg:hidden z-20 transition-opacity duration-300 ease-in-out pointer-events-none">
</div>
