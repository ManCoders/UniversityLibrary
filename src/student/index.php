<?php include "./header.php"; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>University Campus Library Portal</title>

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

    <!-- Header / Fixed Navigation -->
    <header class="fixed top-0 w-full bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <h1 class="text-xl sm:text-2xl font-extrabold text-indigo-700 dark:text-indigo-400">
                <i data-lucide="graduation-cap" class="inline-block w-6 h-6 mr-1 align-sub"></i>Campus Library Portal
            </h1>
            <div class="flex items-center gap-3">
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle"
                    class="p-2 rounded-full text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i id="dark-mode-icon" data-lucide="moon" class="w-5 h-5"></i>
                </button>
                <button id="login-btn"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow-md hover:bg-indigo-700 transition transform hover:scale-105 text-sm sm:text-base font-medium">
                    <i data-lucide="log-in" class="inline-block w-4 h-4 mr-1"></i>Login
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="pt-28 pb-12 sm:pt-40 sm:pb-20 text-center px-4 bg-gradient-to-br from-indigo-50 dark:from-gray-900 to-white dark:to-gray-800">
        <h2 class="text-4xl sm:text-6xl font-extrabold mb-4 leading-tight">
            <span class="text-indigo-600 dark:text-indigo-400">Discover</span> Your Academic World
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

        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Over 1.2 million digital assets available.</p>
    </section>

    <!-- Services Section -->
    <section class="max-w-6xl mx-auto px-6 pb-20">
        <h2 class="text-3xl font-bold text-center mb-12 pt-8">Core Library Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
                class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                <i data-lucide="book-open-text"
                    class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                <h3 class="text-xl font-semibold mb-3">Smart Metadata Management</h3>
                <p class="text-base text-gray-600 dark:text-gray-400">Automatically extract, tag, and organize metadata
                    for books, theses, and research papers.</p>
            </div>

            <div
                class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                <i data-lucide="bot"
                    class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                <h3 class="text-xl font-semibold mb-3">AI Library Chatbot</h3>
                <p class="text-base text-gray-600 dark:text-gray-400">Get instant assistance for literature reviews,
                    resource finding, and academic inquiries.</p>
            </div>

            <div
                class="p-8 bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-indigo-600">
                <i data-lucide="lock"
                    class="w-10 h-10 text-indigo-600 mb-4 bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full"></i>
                <h3 class="text-xl font-semibold mb-3">Secure Campus Access</h3>
                <p class="text-base text-gray-600 dark:text-gray-400">Login safely using your university ID for access
                    to exclusive materials and your profile.</p>
            </div>
        </div>
    </section>

    <!-- Chatbot Floating UI -->
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <div id="chatbox"
            class="hidden w-72 sm:w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-4 mb-3 animate-fade-in border border-indigo-200 dark:border-indigo-900">
            <div class="flex justify-between items-center mb-3 border-b pb-2 dark:border-gray-700">
                <h4 class="font-bold text-indigo-600 dark:text-indigo-400 flex items-center">
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

    <!-- Login Modal -->
    <div id="login-modal" aria-expanded="false"
        class="hidden fixed inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm z-[100] items-center justify-center transition-opacity duration-300">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-80 sm:w-96 p-8 relative animate-fade-in border border-indigo-300 dark:border-indigo-700">
            <button id="close-login" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 transition p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <h3 class="text-2xl font-bold text-center mb-6 text-indigo-600 dark:text-indigo-400">
                <i data-lucide="user-check" class="inline-block w-6 h-6 mr-1 align-text-bottom"></i> Campus Access
            </h3>
            <form id="login" class="space-y-4">
                <input type="text" id="university-id" placeholder="University ID or Email " 
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition text-gray-900 dark:text-gray-100">
                <input type="password" id="password" placeholder="Password"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition text-gray-900 dark:text-gray-100">
                <p id="login-message" class="text-sm text-center hidden"></p>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition transform hover:scale-[1.01]">Sign
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
            <h3 class="text-xl font-bold mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2 dark:border-gray-700">
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

    <!-- Main jQuery Script -->
    <script>
        $(document).ready(function () {
            // 1. Initial Icon Rendering & Footer Year
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                // Renders all Lucide icons initially
                lucide.createIcons();
            }
            $("#current-year").text(new Date().getFullYear());

            $('#dark-mode-icon').on('click', function () {
                alert("Under maintenance!")
            });
           

            // 3. Modal helper (Used for Login and Search)
            function toggleModal(modal, show) {
                if (show) {
                    modal.removeClass("hidden").addClass("flex");
                    $("body").css("overflow", "hidden");
                    modal.attr("aria-expanded", "true");
                } else {
                    modal.addClass("hidden").removeClass("flex");
                    $("body").css("overflow", "");
                    modal.attr("aria-expanded", "false");
                }
            }

            // Login Modal
            const loginModal = $("#login-modal");
            $("#login-btn").on("click", () => toggleModal(loginModal, true));
            $("#close-login, #login-modal").on("click", function (e) {
                // Only close if clicked on the X button or the backdrop (e.target is the modal itself)
                if (e.target === this || e.target.id === 'close-login' || $(e.target).closest('#close-login').length) {
                    toggleModal(loginModal, false);
                }
            });

            /* $("#login-form").on("submit", function (e) {
                e.preventDefault();
                const u = $("#username").val(),
                    p = $("#password").val(),
                    msg = $("#login-message");
                msg.removeClass("hidden text-red-500 text-green-500").addClass("text-gray-500").text("Attempting login...");
                setTimeout(() => {
                    if (u === "admin" && p === "123") {
                        msg.removeClass("text-gray-500").addClass("text-green-500").text("Login successful! Redirecting...");
                        setTimeout(() => toggleModal(loginModal, false), 1500);
                    } else {
                        msg.removeClass("text-gray-500").addClass("text-red-500").text("Login failed. Invalid credentials.");
                    }
                }, 1000);
            }); */

            // 4. Chatbot Logic
            const chatbox = $("#chatbox");
            const chatInput = $("#chat-input");
            const chatMessages = $("#chat-messages");

            $("#chatbot-toggle").on("click", () => chatbox.toggleClass("hidden"));
            $("#close-chat").on("click", () => chatbox.addClass("hidden"));

            function sendMessage() {
                const msg = chatInput.val().trim();
                if (!msg) return;

                // User message
                chatMessages.append(`<div class='text-right'><span class='inline-block bg-indigo-500 text-white p-2 rounded-lg max-w-[80%]'>${msg}</span></div>`);
                chatInput.val("");
                chatMessages.scrollTop(chatMessages[0].scrollHeight); // Scroll to bottom

                // Assistant response
                setTimeout(() => {
                    let reply = "I’ll look that up for you! Please log in for detailed assistance.";
                    if (msg.toLowerCase().includes("hours")) {
                        reply = "The main library is open 8:00 AM – 9:00 PM (Mon–Fri).";
                    } else if (msg.toLowerCase().includes("metadata")) {
                        reply = "Our Smart Metadata Management automatically tags and organizes research papers for easy citation.";
                    }

                    chatMessages.append(`<div class='text-left'><span class='inline-block bg-gray-200 dark:bg-gray-700 p-2 rounded-lg max-w-[80%]'>${reply}</span></div>`);
                    chatMessages.scrollTop(chatMessages[0].scrollHeight); // Scroll to bottom
                }, 700);
            }

            $("#send-btn").on("click", sendMessage);
            chatInput.on("keypress", e => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // 5. Search Logic
            const searchModal = $("#search-modal");
            const searchInput = $("#search-input");
            const searchResults = $("#search-results");

            $("#search-btn, #search-input").on("click keypress", function (e) {
                if (e.type === 'click' || e.key === 'Enter') {
                    performSearch();
                }
            });

            function performSearch() {
                const query = searchInput.val().trim();
                if (!query) return;

                toggleModal(searchModal, true);
                searchResults.html(`<p class='text-gray-500 italic'>Searching for "${query}"...</p>`);

                setTimeout(() => {
                    searchResults.html(`
                        <div class='p-3 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
                            <a href='#' class='font-semibold text-indigo-600 dark:text-indigo-400 hover:underline'>Found: The Future of Digital Libraries</a>
                            <p class='text-sm text-gray-500'>By J. Doe (2023) - Research Paper</p>
                        </div>
                        <div class='p-3 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
                            <a href='#' class='font-semibold text-indigo-600 dark:text-indigo-400 hover:underline'>Book: Advanced Library Systems Design</a>
                            <p class='text-sm text-gray-500'>By M. Reyes (2021) - Available in print</p>
                        </div>
                        <div class='p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
                            <a href='#' class='font-semibold text-indigo-600 dark:text-indigo-400 hover:underline'>Paper: AI in Metadata Extraction</a>
                            <p class='text-sm text-gray-500'>University Research Archive - Open Access</p>
                        </div>
                    `);
                    searchInput.val("");
                }, 800);
            }

            $("#close-search, #search-modal").on("click", function (e) {
                // Only close if clicked on the X button or the backdrop (e.target is the modal itself)
                if (e.target === this || e.target.id === 'close-search' || $(e.target).closest('#close-search').length) {
                    toggleModal(searchModal, false);
                }
            });
        });
    </script>
</body>

</html>