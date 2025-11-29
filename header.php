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

        // Tailwind config
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Inter", "ui-sans-serif", "system-ui", "-apple-system", "BlinkMacSystemFont", "Segoe UI", "Roboto", "Helvetica Neue", "Arial", "Noto Sans", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
                        serif: ["ui-serif", "Georgia", "Cambria", "Times New Roman", "Times", "serif"],
                    },
                    colors: {
                        "indigo-700": "#4338ca",
                        "indigo-600": "#4f46e5",
                        "indigo-50": "#eef2ff",
                    },
                },
            },
        };

        // ---------------------------
        //  PRE-PAINT THEME SETUP
        // ---------------------------
        (function () {
            const storedTheme = localStorage.getItem(THEME_KEY);
            const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const isDark = storedTheme === "dark" || (storedTheme === null && prefersDark);

            const html = document.documentElement;

            if (isDark) {
                html.classList.add("dark");
                html.style.backgroundColor = "#111827";
                html.style.colorScheme = "dark";
            } else {
                html.classList.remove("dark");
                html.style.backgroundColor = "#f3f4f6";
                html.style.colorScheme = "light";
            }

            // hide until ready → avoid flash
            html.style.visibility = "hidden";

            window.addEventListener("DOMContentLoaded", () => {
                html.style.visibility = "visible";
            });
        })();


        // ---------------------------
        //  THEME APPLY FUNCTION
        // ---------------------------
        const applyTheme = (isDark) => {
            const html = document.documentElement;

            if (isDark) {
                html.classList.add("dark");
                html.style.backgroundColor = "#111827";
                html.style.colorScheme = "dark";
            } else {
                html.classList.remove("dark");
                html.style.backgroundColor = "#f3f4f6";
                html.style.colorScheme = "light";
            }
        };


        // ---------------------------
        //  DARK MODE TOGGLE HANDLER
        // ---------------------------
        const initializeDarkModeToggle = () => {
            const toggleButton = document.getElementById("dark-mode-toggle");
            if (!toggleButton) return;

            toggleButton.addEventListener("click", () => {
                const currentlyDark = document.documentElement.classList.contains("dark");
                const newTheme = !currentlyDark;

                applyTheme(newTheme);
                localStorage.setItem(THEME_KEY, newTheme ? "dark" : "light");
            });
        };


        // ---------------------------
        //  APP BOOTSTRAP
        // ---------------------------
        const renderApp = () => {
            if (window.lucide) lucide.createIcons();
            initializeSidebarToggle?.();
            initializeDarkModeToggle();
        };


        let inactivityTime = 0;
        const logoutTime = 30; 

        // Reset inactivity timer
        function resetTimer() {
            inactivityTime = 0;
        }

        document.onmousemove = resetTimer;
        document.onkeydown = resetTimer;
        document.onclick = resetTimer;
        document.onscroll = resetTimer;

        // Check every second
        setInterval(() => {
            inactivityTime++;

            if (inactivityTime >= logoutTime) {
                fetch(`${base_url}auth/action.php?action=autologout`)
                    .then(res => res.json())
                    .then(data => {
                        alert("Auto-logged out for security reasons.");
                        window.location.href = data.redirect_url;
                    })
                    .catch(() => {
                        alert("Session expired.");
                        window.location.href = base_url;
                    });
            }

        }, 1000);


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