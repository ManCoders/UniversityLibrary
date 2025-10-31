<?php include './header.php'; ?>
<?php
$allowed_pages = ['dashboard', 'metadata', 'users', 'reports', 'settings'];
$page = 'dashboard'; // default

if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
    $page = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modular Admin Dashboard</title>
</head>

<body class="min-h-screen bg-gray-100 font-sans">
    <script>
        const THEME_KEY = 'theme';

        // --- Sidebar Toggle ---
        const initializeSidebarToggle = () => {
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('open-sidebar-btn');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const overlay = document.getElementById('sidebar-overlay');

            if (!sidebar || !openBtn || !closeBtn || !overlay) {
                console.error("Sidebar elements not found. Layout rendering may have failed.");
                return;
            }

            const toggleSidebar = (isOpen) => {
                if (isOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('opacity-0', 'pointer-events-none');
                    overlay.classList.add('opacity-100');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    overlay.classList.remove('opacity-100');
                }
            };

            openBtn.addEventListener('click', () => toggleSidebar(true));
            closeBtn.addEventListener('click', () => toggleSidebar(false));
            overlay.addEventListener('click', () => toggleSidebar(false));

            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) { // mobile
                        setTimeout(() => toggleSidebar(false), 500);
                    }
                });
            });

            // Prevent body scroll when sidebar is open on mobile
            const observer = new MutationObserver(() => {
                if (window.innerWidth < 1024) {
                    document.body.style.overflow = sidebar.classList.contains('-translate-x-full') ? '' : 'hidden';
                }
            });
            observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
        };

        // --- Dark Mode ---
        const applyTheme = (isDark) => {
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };

        const loadTheme = () => {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const storedTheme = localStorage.getItem(THEME_KEY);

            let isDark;
            if (storedTheme === 'dark') {
                isDark = true;
            } else if (storedTheme === 'light') {
                isDark = false;
            } else {
                isDark = prefersDark;
            }

            applyTheme(isDark);
        };

        const initializeDarkModeToggle = () => {
            const toggleButton = document.getElementById('dark-mode-toggle');
            if (!toggleButton) return;

            toggleButton.addEventListener('click', () => {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                const newIsDark = !isCurrentlyDark;
                applyTheme(newIsDark);
                localStorage.setItem(THEME_KEY, newIsDark ? 'dark' : 'light');
            });
        };

        // --- Render App ---
        const renderApp = () => {
            lucide.createIcons();
            initializeSidebarToggle();
            loadTheme();
            initializeDarkModeToggle();
        };

        document.addEventListener('DOMContentLoaded', renderApp);
    </script>


    <!-- Sidebar and Overlay Containers -->
    <div id="sidebar-container"></div>


    <div class="main-content-wrapper lg:ml-64 flex flex-col min-h-screen">
        <div id="topbar-container"></div>
        <main id="main-content-area" class="content-area flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 content-area flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            
        </main>
        <div id="footer-container"></div>
    </div>

</body>

</html>