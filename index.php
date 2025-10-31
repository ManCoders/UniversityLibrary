
<?php include './header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMD/CDQyFwYtC65HqL+q4D0eK2/4v6h/g9R/4qf+r+L4gP0L+3h0v1uGv8pA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Campus Digital Library Portal</title>
     <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        // Light Mode Base Colors
                        'light-bg': '#fcfaf6', // Softer, lighter cream from logo background
                        'light-card': '#ffffff',
                        'light-text': '#2b2b2b', // Darker text for readability

                        // Dark Mode Base Colors
                        'dark-bg': '#121212', // Standard dark background
                        'dark-card': '#1e1e1e', // Standard dark card background
                        'dark-text': '#f0e6d6', // Light goldish-cream for dark mode text

                        // ZPPSU Branding Colors derived from the logo
                        'zppsu-maroon-dark': '#5D001E', // Deep maroon from logo's outer ring
                        'zppsu-maroon-light': '#9A031E', // Lighter shade of maroon for accents
                        'zppsu-gold': '#FACC15', // Bright gold from logo's accents
                        'zppsu-cream': '#F8F4EA', // Inner background cream
                        'zppsu-green': '#6B8E23', // Olive green from logo leaves
                        'zppsu-brown': '#8B4513', // Book/Laptop color base

                        // Re-mapping existing components to new ZPPSU colors
                        'primary-dark': '#5D001E',        // Deep Maroon
                        'primary-light': '#9A031E',       // Lighter Maroon
                        'accent-gold': '#FACC15',         // Bright Gold
                        'maroon-gradient-start': '#5D001E', // For gradient
                        'maroon-gradient-end': '#750024',   // A slightly darker maroon for depth
                    },
                },
            },
        };
    </script>
</head>

<body class="font-sans bg-light-bg text-light-text dark:bg-dark-bg dark:text-dark-text min-h-screen transition-colors duration-500">

    <!-- HEADER (Sticky Top) --><header class="bg-light-card shadow-md dark:bg-dark-card sticky top-0 z-50 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="#" class="flex items-center space-x-3">
                <!-- Library Icon: fa-building-columns --><i class="fa-solid fa-building-columns w-8 h-8 text-zppsu-maroon-dark dark:text-zppsu-gold"></i>
                <span class="text-2xl font-extrabold text-zppsu-maroon-dark dark:text-zppsu-gold tracking-tight">
                    ZPPSU eLibrary
                </span>
            </a>

            <!-- Nav (Desktop) --><nav class="hidden md:flex space-x-8">
                <a href="#" class="nav-link text-light-text dark:text-dark-text hover:text-zppsu-gold transition duration-150 font-medium">Home</a>
                <a href="#resources" class="nav-link text-light-text dark:text-dark-text hover:text-zppsu-gold transition duration-150 font-medium">Resources</a>
                <a href="#help" class="nav-link text-light-text dark:text-dark-text hover:text-zppsu-gold transition duration-150 font-medium">Help</a>
            </nav>

            <!-- Right: Theme Toggle & Login Button --><div class="flex items-center space-x-4">
                <!-- Theme Toggle Button: fa-sun/fa-moon --><button id="theme-toggle" class="p-2 rounded-full text-light-text dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-card transition focus:ring-2 focus:ring-zppsu-gold" aria-label="Toggle Theme">
                    <i class="fa-solid fa-sun w-6 h-6 hidden" id="sun-icon"></i>
                    <i class="fa-solid fa-moon w-6 h-6 block" id="moon-icon"></i>
                </button>

                <button id="desktop-login-trigger" class="hidden sm:inline-flex px-4 py-2 font-medium rounded-lg bg-zppsu-maroon-dark text-white hover:bg-zppsu-maroon-light transition shadow-md">
                    Staff & Student Login
                </button>

                <!-- Mobile Menu Button: fa-bars/fa-xmark --><button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-card">
                    <i class="fa-solid fa-bars w-6 h-6 block" id="mobile-menu-icon-open"></i>
                    <i class="fa-solid fa-xmark w-6 h-6 hidden" id="mobile-menu-icon-close"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Dropdown) --><div id="mobile-menu" class="hidden md:hidden absolute top-20 inset-x-0 z-40 bg-light-card dark:bg-dark-card shadow-xl border-t border-gray-200 dark:border-gray-700">
            <div class="px-2 pt-2 pb-4 space-y-1">
                <a href="#" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-zppsu-maroon-light">Home</a>
                <a href="#resources" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-zppsu-maroon-light">Resources</a>
                <a href="#help" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-zppsu-maroon-light">Help</a>

                <button id="mobile-login-trigger"
                    class="mt-4 block w-full text-center px-3 py-3 text-sm font-medium rounded-lg bg-zppsu-maroon-dark text-white hover:bg-zppsu-maroon-light transition">
                    Staff & Student Login
                </button>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT --><main>
        <!-- Hero Section --><section class="text-white py-20 sm:py-28 md:py-36 bg-gradient-to-br from-zppsu-maroon-dark to-maroon-gradient-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4 leading-tight">
                    Your Center for <span class="text-zppsu-gold">Academic Excellence</span>
                </h1>
                <p class="text-lg sm:text-xl text-red-100 mb-10 max-w-3xl mx-auto">
                    Search our vast collections of journals, e-books, and archival data. Knowledge is at your fingertips.
                </p>
                <!-- Search Bar --><div class="flex flex-col sm:flex-row max-w-3xl mx-auto shadow-xl rounded-xl overflow-hidden">
                    <input type="text" id="search-input" placeholder="Search for a title, author, or subject..."
                        class="w-full px-6 py-4 text-lg text-light-text bg-light-card dark:bg-dark-card dark:text-dark-text focus:outline-none focus:ring-4 focus:ring-zppsu-gold rounded-t-xl sm:rounded-l-xl sm:rounded-tr-none transition duration-300"
                        aria-label="eLibrary search input" />
                    <!-- Updated ID for Search Trigger --><button id="search-trigger" class="w-full sm:w-auto px-8 py-4 text-lg font-bold bg-zppsu-gold text-zppsu-maroon-dark rounded-b-xl sm:rounded-r-xl sm:rounded-bl-none hover:bg-amber-500 flex items-center justify-center space-x-2 transition duration-300">
                        <!-- Search Icon: fa-book-open --><i class="fa-solid fa-book-open w-6 h-6"></i>
                        <span class="whitespace-nowrap">Start Search</span>
                    </button>
                </div>
                <!-- Search Tip --><p class="text-sm mt-4 text-red-200">Over 5 million indexed items available.</p>
            </div>
        </section>

        <!-- Resources Section --><section id="resources" class="py-16 md:py-24 bg-light-bg dark:bg-dark-bg transition-colors duration-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-zppsu-maroon-dark dark:text-zppsu-gold mb-12">Explore Our Collections</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- Resource Card 1: fa-microscope --><div class="resource-card">
                        <i class="fa-solid fa-microscope w-10 h-10 text-zppsu-gold mb-4"></i>
                        <h3 class="text-xl font-bold text-zppsu-maroon-dark dark:text-dark-text mb-2">Peer-Reviewed Journals</h3>
                        <p class="text-gray-600 dark:text-gray-300">Access high-impact research across all disciplines.</p>
                    </div>
                    <!-- Resource Card 2: fa-graduation-cap --><div class="resource-card">
                        <i class="fa-solid fa-graduation-cap w-10 h-10 text-zppsu-gold mb-4"></i>
                        <h3 class="text-xl font-bold text-zppsu-maroon-dark dark:text-dark-text mb-2">E-Books & Textbooks</h3>
                        <p class="text-gray-600 dark:text-gray-300">Essential course readings and reference materials online.</p>
                    </div>
                    <!-- Resource Card 3: fa-box-archive --><div class="resource-card">
                        <i class="fa-solid fa-box-archive w-10 h-10 text-zppsu-gold mb-4"></i>
                        <h3 class="text-xl font-bold text-zppsu-maroon-dark dark:text-dark-text mb-2">Institutional Repository</h3>
                        <p class="text-gray-600 dark:text-gray-300">Theses, dissertations, and faculty publications.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER --><footer class="bg-gray-100 dark:bg-dark-card text-gray-700 dark:text-gray-300 py-12 border-t border-gray-200 dark:border-gray-700 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-sm">
            <!-- Footer links will inherit ZPPSU colors if defined, or stay generic --></div>
        <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
            &copy; 2024 ZPPSU Digital Library. All rights reserved.
        </div>
    </footer>

    <!-- LOGIN MODAL (Hidden by default) --><div id="login-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black bg-opacity-50 dark:bg-opacity-80 transition-opacity duration-300">
        <div class="w-full max-w-md bg-light-card dark:bg-dark-card rounded-xl shadow-2xl p-6 sm:p-8 text-light-text dark:text-dark-text transition-colors duration-500">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-zppsu-maroon-dark dark:text-zppsu-gold">Institutional Access</h3>
                <button id="modal-close-button" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition" aria-label="Close Modal">
                <!-- Close Icon: fa-xmark --><i class="fa-solid fa-xmark w-6 h-6"></i>
                </button>
            </div>
            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">Please use your university single sign-on credentials.</p>
            <form class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">University Email or student Id</label>
                    <input type="email" id="email" placeholder="studentID@university.edu" 
                        class="input-field w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-light-text dark:text-dark-text focus:ring-zppsu-gold focus:border-zppsu-gold transition" required />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" id="password" placeholder="••••••••" 
                        class="input-field w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-light-text dark:text-dark-text focus:ring-zppsu-gold focus:border-zppsu-gold transition" required />
                </div>
                <button type="submit" class="w-full py-3 mt-4 text-lg font-bold bg-zppsu-gold text-zppsu-maroon-dark rounded-lg hover:bg-amber-500 transition duration-300 shadow-md">
                    Secure Log In
                </button>
            </form>
        </div>
    </div>

    <!-- SEARCH RESULTS MODAL (Hidden by default) --><div id="search-results-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black bg-opacity-50 dark:bg-opacity-80 transition-opacity duration-300">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-light-card dark:bg-dark-card rounded-xl shadow-2xl p-6 sm:p-8 text-light-text dark:text-dark-text transition-colors duration-500">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-zppsu-maroon-dark dark:text-zppsu-gold">Search Results for: "<span id="search-query-display"></span>"</h3>
                <button id="search-modal-close-button" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition" aria-label="Close Search Results">
                    <!-- Close Icon: fa-xmark --><i class="fa-solid fa-xmark w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Results List Placeholder -->
            <div id="search-results-list" class="space-y-4">
                <!-- Simulated Result 1 -->
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <p class="text-lg font-semibold text-primary-dark dark:text-zppsu-gold">The History of Zamboanga Peninsula State University</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Author: Dela Cruz, M. | Year: 2023 | Type: Thesis</p>
                    <p class="text-sm mt-1 line-clamp-2">An in-depth analysis of the institutional history, educational reforms, and cultural impact of ZPPSU from its founding to the present day...</p>
                    <a href="#" class="text-xs font-medium text-zppsu-maroon-light dark:text-zppsu-gold hover:underline mt-2 inline-block">View Full Text <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-xs"></i></a>
                </div>

                <!-- Simulated Result 2 -->
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <p class="text-lg font-semibold text-primary-dark dark:text-zppsu-gold">Marine Biodiversity in the Basilan Strait</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Author: Santos, A. G. | Year: 2024 | Type: Journal Article</p>
                    <p class="text-sm mt-1 line-clamp-2">A survey of marine life and conservation challenges in the waters surrounding the Zamboanga region, focusing on endemic species...</p>
                    <a href="#" class="text-xs font-medium text-zppsu-maroon-light dark:text-zppsu-gold hover:underline mt-2 inline-block">View Full Text <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-xs"></i></a>
                </div>
                
                <p class="text-center text-sm text-gray-500 dark:text-gray-400 pt-4">End of simulated results. Please log in for full database access.</p>
            </div>
        </div>
    </div>

    <!-- CHAT TOGGLE BUTTON: fa-comments --><button id="chat-toggle-button" class="fixed bottom-6 right-6 p-4 rounded-full bg-zppsu-maroon-dark text-white shadow-2xl hover:bg-zppsu-maroon-light transition duration-300 transform hover:scale-105 z-50 focus:outline-none focus:ring-4 focus:ring-zppsu-gold" aria-label="Open Live Chat">
        <i class="fa-solid fa-comments w-6 h-6"></i>
    </button>

    <!-- CHAT WIDGET (Hidden by default) --><div id="chat-widget" class="fixed bottom-20 right-6 w-80 h-96 hidden bg-light-card dark:bg-dark-card border border-gray-300 dark:border-gray-700 rounded-xl shadow-2xl overflow-hidden z-50 transition-colors duration-500 flex flex-col">
        
        <!-- Chat Header --><div class="p-4 bg-zppsu-maroon-dark text-white flex justify-between items-center rounded-t-xl">
            <h4 class="font-bold">AI Librarian Support</h4>
            <button id="chat-minimize-button" class="text-white opacity-80 hover:opacity-100 transition" aria-label="Minimize Chat">
                <!-- Minimize Icon: fa-minus --><i class="fa-solid fa-minus w-5 h-5"></i>
            </button>
        </div>

        <!-- Chat Body (Scrolling Area) --><div class="flex-grow p-4 space-y-3 overflow-y-auto flex flex-col-reverse">
             <!-- Simulated Admin Message --><div class="flex justify-start">
                <div class="bg-gray-200 dark:bg-gray-700 p-3 rounded-xl rounded-tl-none max-w-[75%] text-sm text-light-text dark:text-dark-text">
                    Hello! I am your AI assistant. How can I help you find resources or troubleshoot access today?
                </div>
            </div>
        </div>

        <!-- Chat Input --><div class="p-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex space-x-2">
                <input type="text" placeholder="Type your question..." class="flex-grow p-2 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-zppsu-maroon-light focus:border-zppsu-maroon-light text-light-text dark:text-dark-text" />
                <button class="p-2 bg-zppsu-maroon-dark text-white rounded-lg hover:bg-zppsu-maroon-light transition" aria-label="Send Message">
                    <!-- Send Icon: fa-paper-plane --><i class="fa-solid fa-paper-plane w-5 h-5"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- STYLES (Inline CSS for custom components) --><style>
        .resource-card {
            @apply bg-light-card p-8 rounded-xl shadow-lg hover:shadow-2xl border-t-4 border-zppsu-gold transform hover:scale-[1.02] dark:bg-dark-card transition-all duration-300 ease-in-out;
        }
    </style>

    <!-- JS & Initialization --><script>
        const root = document.documentElement;

        // --- Core Theme Logic (Pure JS) ---
        const loadTheme = () => {
            const stored = localStorage.getItem("theme");
            const isDark = stored === "dark" || (!stored && window.matchMedia("(prefers-color-scheme: dark)").matches);
            root.classList.toggle("dark", isDark);
            $("#sun-icon").toggleClass("hidden", !isDark);
            $("#moon-icon").toggleClass("hidden", isDark);
        };
        
        // --- JQUERY UI Logic ---
        $(function () {
            // 1. Theme Toggle
            $("#theme-toggle").on("click", () => {
                const isDark = root.classList.toggle("dark");
                localStorage.setItem("theme", isDark ? "dark" : "light");
                // Update icons manually
                $("#sun-icon").toggleClass("hidden", !isDark);
                $("#moon-icon").toggleClass("hidden", isDark);
            });

            // 2. Mobile Menu Toggle
            $('#mobile-menu-button').on('click', function() {
                $('#mobile-menu').toggleClass('hidden');
                $('#mobile-menu-icon-open').toggleClass('hidden');
                $('#mobile-menu-icon-close').toggleClass('hidden');
            });
            
            // 3. Login Modal Logic (Open)
            $("#desktop-login-trigger, #mobile-login-trigger, #help").on("click", e => {
                e.preventDefault();
                // Close mobile menu if open when modal is triggered
                if ($('#mobile-menu').is(':visible')) {
                    $('#mobile-menu-button').trigger('click'); 
                }
                $("#login-modal").removeClass("hidden").attr('aria-modal', 'true');
            });

            // 4. Login Modal Logic (Close)
            $("#modal-close-button, #login-modal").on("click", e => {
                // Check if the click is on the backdrop or the close button
                if (e.target.id === "login-modal" || $(e.target).closest('#modal-close-button').length) {
                    $("#login-modal").addClass("hidden").attr('aria-modal', 'false');
                }
            });

            // 5. Chat Widget Toggle
            $("#chat-toggle-button, #chat-minimize-button").on("click", () => {
                 // Now only toggle 'hidden'
                 $("#chat-widget").toggleClass("hidden");
            });

            // 6. Search Modal Logic (Open) - NEW
            $("#search-trigger").on("click", e => {
                e.preventDefault();
                const query = $("#search-input").val().trim() || "all resources";
                $("#search-query-display").text(query);
                $("#search-results-modal").removeClass("hidden").attr('aria-modal', 'true');
                $("#search-input").val(''); // Clear input after search
            });

            // 7. Search Modal Logic (Close) - NEW
            $("#search-modal-close-button, #search-results-modal").on("click", e => {
                // Check if the click is on the backdrop or the close button
                if (e.target.id === "search-results-modal" || $(e.target).closest('#search-modal-close-button').length) {
                    $("#search-results-modal").addClass("hidden").attr('aria-modal', 'false');
                }
            });
            
            loadTheme();
        });
    </script>
</body>
</html>
