<?php
include 'auth/functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo get_option('system_description') ?>">
    <title><?php echo get_option('system_title') ?></title>
    <?php render_styles(); ?>
    <?php render_scripts(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>

        var base_url = '<?php echo base_url() ?>';
        const THEME_KEY = "theme";

        // ✅ Apply theme *before paint* to prevent flashing
        (function () {
            const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const storedTheme = localStorage.getItem(THEME_KEY);
            const isDark = storedTheme === "dark" || (storedTheme === null && prefersDark);

            // Set correct background color *before* visibility
            if (isDark) {
                document.documentElement.classList.add("dark");
                document.documentElement.style.backgroundColor = "#111827"; // gray-900 for dark mode
                document.documentElement.style.colorScheme = "dark";
            } else {
                document.documentElement.classList.remove("dark");
                document.documentElement.style.backgroundColor = "#f3f4f6"; // gray-100 for light mode
                document.documentElement.style.colorScheme = "light";
            }

            if (!isDark) {

                document.documentElement.classList.remove("dark");
                document.documentElement.style.backgroundColor = "#f3f4f6"; // gray-100 for light mode
                document.documentElement.style.colorScheme = "light";
            } else {

                document.documentElement.classList.add("dark");
                document.documentElement.style.backgroundColor = "#111827"; // gray-900 for dark mode
                document.documentElement.style.colorScheme = "dark";
            }

            // Hide until ready
            document.documentElement.style.visibility = "hidden";

            window.addEventListener("DOMContentLoaded", () => {
                document.documentElement.style.visibility = "visible";
            });
        })();

        // ✅ Theme handling functions
        const applyTheme = (isDark) => {
            if (isDark) {
                document.documentElement.classList.add("dark");
                document.documentElement.style.backgroundColor = "#111827";
                document.documentElement.style.colorScheme = "dark";
            } else {
                document.documentElement.classList.remove("dark");
                document.documentElement.style.backgroundColor = "#f3f4f6";
                document.documentElement.style.colorScheme = "light";
            }
        };

        const initializeDarkModeToggle = () => {
            const toggleButton = document.getElementById("dark-mode-toggle");
            if (!toggleButton) return;

            toggleButton.addEventListener("click", () => {
                const isCurrentlyDark = document.documentElement.classList.contains("dark");
                const newIsDark = !isCurrentlyDark;
                applyTheme(newIsDark);
                localStorage.setItem(THEME_KEY, newIsDark ? "dark" : "light");
            });
        };

        const renderApp = () => {
            if (window.lucide) lucide.createIcons();
            initializeSidebarToggle?.();
            initializeDarkModeToggle();
        };
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div id="upload-spinner" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
        <div class="loader border-4 border-t-4 border-blue-500 rounded-full w-12 h-12 animate-spin"></div>
    </div>

    <style>
        .loader {
            border-top-color: #3498db;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
        }
    </style>