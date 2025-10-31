<?php include './header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_option('system_title'); ?></title>
    <!-- Load Tailwind CSS -->
    <script>
        tailwind.config = {
            darkMode: 'class', // <-- add this line
            theme: {
                extend: {
                    colors: {
                        'primary-dark': '#5D001E',
                        'primary-light': '#9A031E',
                        'accent-gold': '#FACC15',
                        'maroon-gradient-end': '#750024',
                        'soft-cream': '#F5F5E5',
                        'blush-pink': '#F5E9EC',
                        'dark-bg': '#121212',
                        'dark-card': '#1E1E1E',
                        'dark-text': '#E0E0E0',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }

    </script>
    <style>
        /* Custom styles for professional look and feel */
        .inter-font {
            font-family: 'Inter', sans-serif;
        }

        /* Style for the search button hover effect */
        .search-button {
            transition: all 0.3s ease;
        }

        .search-button:hover {
            transform: translateY(-2px);
            /* Gold accent shadow */
            box-shadow: 0 4px 15px rgba(250, 202, 21, 0.6);
        }

        /* Modal Transitions */
        .modal-overlay {
            opacity: 0;
            display: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            display: flex;
        }

        .modal-content {
            transform: scale(0.95);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        /* Chat bubble styles (existing, but important) */
        .user-message {
            background-color: #FACC15;
            color: #5D001E;
            align-self: flex-end;
            border-bottom-right-radius: 0;
        }

        .support-message {
            background-color: #ffffff;
            color: #374151;
            align-self: flex-start;
            border-bottom-left-radius: 0;
        }
    </style>
</head>

<body class="inter-font bg-dark-bg text-dark-text dark:bg-dark-bg dark:text-dark-text">


    <!-- Header & Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo/Title -->
                <a href="#" class="flex items-center space-x-4">
                    <img src="./assets/image/<?php echo get_option('system_logo'); ?>" alt="Logo"
                        class="w-20 h-auto object-contain rounded-full">

                    <span class="text-2xl font-extrabold text-primary-dark tracking-tight hidden lg:block">
                        <?php echo get_option('system_title'); ?>
                    </span>
                </a>



                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#"
                        class="text-gray-600 hover:text-primary-light transition duration-150 font-medium">Home</a>
                    <a href="#collections"
                        class="text-gray-600 hover:text-primary-light transition duration-150 font-medium">Collections</a>
                    <a href="#features"
                        class="text-gray-600 hover:text-primary-light transition duration-150 font-medium">Services</a>
                    <a href="#access"
                        class="text-gray-600 hover:text-primary-light transition duration-150 font-medium">Access</a>
                </nav>

                <!-- Login/Mobile Menu Toggle -->
                <div class="flex items-center space-x-4">
                    <a href="#" onclick="openLoginModal()"
                        class="hidden sm:inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-dark hover:bg-maroon-gradient-end transition duration-300 shadow-md">
                        Faculty & Students Login
                    </a>
                    <!-- Mobile Menu Button (Hamburger) -->
                    <button id="mobile-menu-button" onclick="toggleMobileMenu()"
                        class="md:hidden p-2 rounded-lg text-primary-dark hover:bg-gray-100 transition duration-150"
                        aria-label="Toggle menu">
                        <!-- Hamburger Icon -->
                        <svg id="mobile-menu-icon-open" class="w-6 h-6 block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <!-- Close Icon (Initially hidden) -->
                        <svg id="mobile-menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Content -->
        <!-- Added fixed inset-x-0 to cover screen width completely -->
        <div id="mobile-menu"
            class="hidden md:hidden absolute top-20 inset-x-0 z-40 bg-white shadow-xl border-t border-gray-100">
            <div class="px-2 pt-2 pb-4 space-y-1">
                <!-- Mobile Links -->
                <a href="#" onclick="closeMobileMenu()"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-blush-pink">Home</a>
                <a href="#collections" onclick="closeMobileMenu()"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-blush-pink">Collections</a>
                <a href="#features" onclick="closeMobileMenu()"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-blush-pink">Services</a>
                <a href="#access" onclick="closeMobileMenu()"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-blush-pink">Access</a>

                <!-- Mobile Login Button -->
                <a href="#" onclick="closeMobileMenu(); openLoginModal(); return false;"
                    class="mt-4 block w-full text-center px-3 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-light hover:bg-primary-dark transition duration-300 shadow-md">
                    Login to eLibrary
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section: Gradient Maroon Background -->
<section class="text-white py-20 sm:py-28 md:py-36 bg-gradient-to-br from-primary-dark to-maroon-gradient-end">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4 leading-tight">
                    Your Gateway to <span class="text-accent-gold">Knowledge</span>
                </h1>
                <p class="text-lg sm:text-xl text-red-100 mb-10 max-w-3xl mx-auto">
                    Access millions of academic journals, e-books, dissertations, and research papers—anywhere, anytime.
                </p>

                <!-- Search Bar - Responsive Stacking handled by flex-col sm:flex-row -->
                <div class="flex flex-col sm:flex-row max-w-2xl mx-auto shadow-xl rounded-xl overflow-hidden">
                    <input type="text" id="elibrary-search" placeholder="Search by title, author, subject, or DOI..."
                        class="w-full px-6 py-4 text-lg text-gray-800 focus:outline-none focus:ring-4 focus:ring-accent-gold rounded-t-xl sm:rounded-l-xl sm:rounded-tr-none transition duration-300"
                        aria-label="eLibrary search input">
                    <button onclick="performSearch()"
                        class="search-button w-full sm:w-auto px-8 py-4 text-lg font-bold bg-accent-gold text-primary-dark rounded-b-xl sm:rounded-r-xl sm:rounded-bl-none hover:bg-amber-500 flex items-center justify-center space-x-2 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="whitespace-nowrap">Search Now</span>
                    </button>
                </div>
                <p id="search-message" class="mt-4 text-sm text-red-200 opacity-80">
                    Example: "Artificial Intelligence Ethics" or "Quarterly Journal of Economics"
                </p>
            </div>
        </section>

        <!-- Features & Benefits Section -->
        <section id="features" class="py-16 md:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-primary-dark text-center mb-12">
                    Why Choose Our Digital Library?
                </h2>
                <!-- Responsive Grid: 1 column on mobile, 3 columns on tablet/desktop -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- Feature 1 -->
                    <div
                        class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-primary-light transform hover:scale-[1.02]">
                        <svg class="w-10 h-10 text-primary-light mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-primary-dark mb-2">24/7 Global Access</h3>
                        <p class="text-gray-600">
                            Research from anywhere in the world, on any device. Your resource center never sleeps.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-primary-light transform hover:scale-[1.02]">
                        <svg class="w-10 h-10 text-primary-light mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M5 10h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v1a2 2 0 002 2zm0 0l-3 3v2m0-5h2m-2 0V7m4 3h2m-2 0V7m4 3h2m-2 0V7m4 3h2m-2 0V7">
                            </path>
                        </svg>
                        <h3 class="text-xl font-bold text-primary-dark mb-2">Vast, Curated Collections</h3>
                        <p class="text-gray-600">
                            Millions of licensed, high-impact resources aligned with university curriculum and research
                            needs.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-primary-light transform hover:scale-[1.02]">
                        <svg class="w-10 h-10 text-primary-light mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <h3 class="text-xl font-bold text-primary-dark mb-2">Integrated Research Tools</h3>
                        <p class="text-gray-600">
                            Utilize advanced citation tools, personalized folders, and seamless PDF reader integration.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Access Collections Section -->
        <section id="collections" class="py-16 md:py-24 bg-soft-cream">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-primary-dark mb-3">
                        Quick Access to Core Collections
                    </h2>
                    <p class="text-lg text-gray-600">
                        Explore our most popular and essential digital resources.
                    </p>
                </div>

                <!-- Responsive Grid: 2 columns on mobile, 4 columns on large screens -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <!-- Collection Card 1 -->
                    <a href="#"
                        class="group block bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:border-primary-light hover:shadow-xl transition duration-300">
                        <svg class="w-10 h-10 text-primary-light group-hover:text-accent-gold mb-3 transition duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <p class="text-lg font-semibold text-primary-dark">Academic Journals</p>
                        <p class="text-sm text-gray-500">Peer-reviewed research.</p>
                    </a>

                    <!-- Collection Card 2 -->
                    <a href="#"
                        class="group block bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:border-primary-light hover:shadow-xl transition duration-300">
                        <svg class="w-10 h-10 text-primary-light group-hover:text-accent-gold mb-3 transition duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5 5.753 5 4.167 5.477 3 6.253v13C4.167 18.477 5.753 18 7.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <p class="text-lg font-semibold text-primary-dark">E-Books & Texts</p>
                        <p class="text-sm text-gray-500">Full-text reading online.</p>
                    </a>

                    <!-- Collection Card 3 -->
                    <a href="#"
                        class="group block bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:border-primary-light hover:shadow-xl transition duration-300">
                        <svg class="w-10 h-10 text-primary-light group-hover:text-accent-gold mb-3 transition duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9m2.828 9.9a5 5 0 010 7.072m0-2.828a5 5 0 00-7.072 0M12 18.707l1.757-1.757m-3.5 0L12 18.707">
                            </path>
                        </svg>
                        <p class="text-lg font-semibold text-primary-dark">Databases & Tools</p>
                        <p class="text-sm text-gray-500">Specialized research access.</p>
                    </a>

                    <!-- Collection Card 4 -->
                    <a href="#"
                        class="group block bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:border-primary-light hover:shadow-xl transition duration-300">
                        <svg class="w-10 h-10 text-primary-light group-hover:text-accent-gold mb-3 transition duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3m-4.5-9l-2-2m0 0l-2 2M9 5h1M3 9h12a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V11a2 2 0 012-2zm0-5l2-2m2 2l2 2">
                            </path>
                        </svg>
                        <p class="text-lg font-semibold text-primary-dark">Theses & Dissertations</p>
                        <p class="text-sm text-gray-500">Student research archive.</p>
                    </a>
                </div>

                <div class="text-center mt-12">
                    <a href="#"
                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-primary-dark bg-accent-gold hover:bg-amber-500 transition duration-300 shadow-md transform hover:scale-[1.05]">
                        View All Collections
                    </a>
                </div>
            </div>
        </section>

        <!-- Access & Support CTA -->
        <section id="access" class="py-16 md:py-24">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 bg-primary-dark rounded-xl p-8 sm:p-12 shadow-2xl">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white mb-4">
                        Need Help Logging In or Researching?
                    </h2>
                    <p class="text-lg text-red-200 mb-8">
                        Our dedicated support team is available to assist you with access, technical issues, and
                        research guidance.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="#" onclick="openChatModal(); return false;"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-primary-dark bg-white hover:bg-gray-100 transition duration-300 shadow-lg">
                            Live Chat Support
                        </a>
                        <a href="#" onclick="openGuideModal(); return false;"
                            class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-primary-light transition duration-300">
                            Access Guide
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer - Responsive columns are set correctly -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

                <!-- Section 1: Library Info -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent-gold">University Library</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-150">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Physical Location</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Library News</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Sitemap</a></li>
                    </ul>
                </div>

                <!-- Section 2: Services -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent-gold">Core Services</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-150">Interlibrary Loan</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Resource Guides</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Workshops</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Ask a Librarian</a></li>
                    </ul>
                </div>

                <!-- Section 3: Policies -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent-gold">Policies</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-150">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Access Rights</a></li>
                        <li><a href="#" class="hover:text-white transition duration-150">Terms of Use</a></li>
                    </ul>
                </div>

                <!-- Section 4: Contact -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent-gold">Contact</h4>
                    <p class="text-sm text-gray-400">
                        Email: <a href="mailto:support@university.edu"
                            class="hover:text-white">support@university.edu</a><br>
                        Phone: (123) 456-7890
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-sm text-gray-500">
                    &copy; <span id="current-year"></span> University Library System. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- 1. LOGIN Modal -->
    <div id="login-modal"
        class="modal-overlay fixed inset-0 z-[100] items-center justify-center p-4 bg-gray-900 bg-opacity-75"
        role="dialog" aria-modal="true" aria-labelledby="login-title">
        <!-- Max-w-md is mobile-friendly, p-4 ensures margins -->
        <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto p-6 sm:p-8">
            <!-- Close Button -->
            <div class="flex justify-end">
                <button onclick="closeLoginModal()"
                    class="text-gray-400 hover:text-gray-600 p-1 transition duration-150"
                    aria-label="Close login modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <h2 id="login-title" class="text-2xl font-bold text-primary-dark text-center mb-6">
                eLibrary Access
            </h2>

            <form id="login">
                <div class="mb-4">
                    <label for="university-id" class="block text-sm font-medium text-gray-700 mb-1">University ID /
                        Email</label>
                    <input type="text" id="university-id" name="university-id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-light focus:border-primary-light transition duration-150"
                        placeholder="e.g., U123456 or student@uni.edu">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-light focus:border-primary-light transition duration-150"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full py-3 text-lg font-bold rounded-lg text-primary-dark bg-accent-gold hover:bg-amber-500 transition duration-300 shadow-md transform hover:scale-[1.01]">
                    Log In
                </button>
            </form>

            <p class="mt-6 text-center text-sm">
                <a href="#" class="text-primary-light hover:text-primary-dark transition duration-150"
                    onclick="closeLoginModal(); showMessage('Forgot Password functionality is a placeholder.', 'text-green-600')">Forgot
                    Password?</a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="#" class="text-primary-light hover:text-primary-dark transition duration-150"
                    onclick="closeLoginModal(); showMessage('Guest Access is a placeholder.', 'text-green-600')">Guest
                    Access</a>
            </p>

            <!-- Status Message Area (for simulated login feedback) -->
            <p id="login-status" class="mt-4 text-center text-sm hidden"></p>
        </div>
    </div>

    <!-- 2. LIVE CHAT Modal -->
    <div id="chat-modal"
        class="modal-overlay fixed inset-0 z-[100] items-center justify-center p-4 bg-gray-900 bg-opacity-75"
        role="dialog" aria-modal="true" aria-labelledby="chat-title">
        <!-- Ensured max height for small screens -->
        <div
            class="modal-content bg-blush-pink rounded-xl shadow-2xl w-full max-w-md mx-auto flex flex-col h-[80vh] max-h-[600px]">
            <!-- Header -->
            <div class="bg-primary-dark text-white p-4 rounded-t-xl flex justify-between items-center flex-shrink-0">
                <h2 id="chat-title" class="text-lg font-bold">
                    Live Support Chat
                </h2>
                <button onclick="closeChatModal()" class="text-white hover:text-gray-200 p-1 transition duration-150"
                    aria-label="Close chat modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Chat Messages Area -->
            <div id="chat-messages" class="flex-grow p-4 space-y-4 overflow-y-auto flex flex-col">
                <div class="support-message max-w-[80%] p-3 rounded-xl shadow-md">
                    Welcome to eLibrary Support! How can I assist you with your access or research needs today?
                </div>
            </div>

            <!-- Input Form -->
            <form onsubmit="sendMessage(event)"
                class="p-4 border-t border-gray-200 bg-white rounded-b-xl flex-shrink-0">
                <div class="flex space-x-2">
                    <input type="text" id="chat-input" placeholder="Type your message..." required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-light focus:border-primary-light transition duration-150">
                    <button type="submit"
                        class="px-4 py-2 bg-accent-gold text-primary-dark font-semibold rounded-lg hover:bg-amber-500 transition duration-300">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. ACCESS GUIDE Modal -->
    <div id="guide-modal"
        class="modal-overlay fixed inset-0 z-[100] items-center justify-center p-4 bg-gray-900 bg-opacity-75"
        role="dialog" aria-modal="true" aria-labelledby="guide-title">
        <!-- Max-w-2xl is now contained by the p-4 on mobile and is scrollable (max-h-[90vh] overflow-y-auto) -->
        <div
            class="modal-content bg-blush-pink rounded-xl shadow-2xl w-full max-w-2xl mx-auto p-6 sm:p-8 max-h-[90vh] overflow-y-auto">

            <!-- Close Button -->
            <div class="flex justify-between items-start mb-6 border-b pb-3 border-primary-light">
                <h2 id="guide-title" class="text-xl sm:text-3xl font-bold text-primary-dark pr-4">
                    eLibrary Access & Troubleshooting Guide
                </h2>
                <button onclick="closeGuideModal()"
                    class="text-gray-400 hover:text-gray-600 p-1 transition duration-150"
                    aria-label="Close guide modal">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <h3 class="text-xl font-semibold text-primary-light mt-4 mb-2">1. Initial Login Requirements</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 pl-4">
                <li>**Students:** Use your full university email address (`@uni.edu`) and the password created during
                    orientation.</li>
                <li>**Faculty:** Use your Faculty ID and the associated network password.</li>
                <li>**Alumni:** Special access accounts must be renewed annually via the Alumni Office.</li>
            </ul>

            <h3 class="text-xl font-semibold text-primary-light mt-6 mb-2">2. Off-Campus Access (VPN)</h3>
            <p class="text-gray-700 mb-2">
                If you are outside the university network and cannot access licensed materials, you must use the
                official **University VPN**.
            </p>
            <div class="bg-white p-4 rounded-lg border-l-4 border-accent-gold text-gray-700">
                **Step 1:** Download and install the VPN client from the IT Services website.<br>
                **Step 2:** Connect to the VPN *before* attempting to search or download resources.
            </div>

            <h3 class="text-xl font-semibold text-primary-light mt-6 mb-2">3. Common Troubleshooting</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 pl-4">
                <li>**Clear Cache & Cookies:** Many access issues are resolved by clearing your browser's data.</li>
                <li>**Disable Pop-up Blockers:** Some publisher sites require pop-ups for PDF viewing.</li>
                <li>**Use a Supported Browser:** Ensure you are using the latest version of Chrome, Firefox, or Safari.
                </li>
            </ul>

            <div class="mt-8 text-center pt-4 border-t border-gray-300">
                <button onclick="openChatModal(); closeGuideModal(); return false;"
                    class="px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-dark hover:bg-maroon-gradient-end transition duration-300 shadow-lg">
                    Still Having Issues? Start a Live Chat
                </button>
            </div>
        </div>
    </div>

</body>

</html>