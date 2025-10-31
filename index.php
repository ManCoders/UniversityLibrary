<?php include './header.php'; ?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>University Campus Library Portal</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- 🌙 Dark Mode -->
    <script>
        const THEME_KEY = 'theme';
        const applyTheme = (isDark) => document.documentElement.classList.toggle('dark', isDark);
        const loadTheme = () => {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const stored = localStorage.getItem(THEME_KEY);
            applyTheme(stored ? stored === 'dark' : prefersDark);
        };
        const toggleTheme = () => {
            const isDark = !document.documentElement.classList.contains('dark');
            applyTheme(isDark);
            localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
        };
        document.addEventListener('DOMContentLoaded', loadTheme);
    </script>


    <!-- 🧭 Navigation -->
    <header class="fixed top-0 w-full bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <h1 class="text-lg sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400">Campus Library Portal</h1>
            <div class="flex items-center gap-3">
                <button id="dark-mode-toggle" onclick="toggleTheme()"
                    class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i data-lucide="moon" class="w-5 h-5"></i>
                </button>
                <button id="login-btn"
                    class="bg-indigo-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-indigo-700 transition text-sm sm:text-base">
                    Login
                </button>
            </div>
        </div>
    </header>

    <!-- 🏫 Hero -->
    <section class="pt-24 pb-10 sm:pt-32 sm:pb-16 text-center px-4">
        <h2 class="text-3xl sm:text-5xl font-bold mb-4">University Digital Library</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto text-sm sm:text-base">
            Access research materials, upload publications, and explore campus-wide academic resources.
        </p>

        <!-- 🔍 Search Bar -->
        <div class="flex justify-center mb-8">
            <div class="w-full sm:w-96 relative">
                <input id="search-input" type="text" placeholder="Search books, authors, or papers..."
                    class="w-full border rounded-md p-3 text-sm sm:text-base dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 outline-none">
                <button id="search-btn"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 text-white p-2 rounded-md hover:bg-indigo-700">
                    <i data-lucide="search"></i>
                </button>
            </div>
        </div>

    </section>

    <!-- 📚 Features -->
    <section class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6 pb-20">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
            <i data-lucide="book-open" class="w-10 h-10 text-indigo-600 mb-3"></i>
            <h3 class="text-lg font-semibold mb-2">Smart Metadata Management</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Automatically extract and organize metadata for books
                and theses.</p>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
            <i data-lucide="bot" class="w-10 h-10 text-indigo-600 mb-3"></i>
            <h3 class="text-lg font-semibold mb-2">AI Library Chatbot</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Ask questions, find resources, and get academic help
                instantly.</p>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
            <i data-lucide="lock" class="w-10 h-10 text-indigo-600 mb-3"></i>
            <h3 class="text-lg font-semibold mb-2">Secure Campus Access</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Login safely using your university ID to access
                exclusive materials.</p>
        </div>
    </section>

    <!-- 💬 Chatbot Floating Widget -->
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <div id="chatbox" class="hidden w-72 sm:w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-3">
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-semibold text-indigo-600">Library Assistant</h4>
                <button id="close-chat" class="text-gray-500 hover:text-red-500"><i data-lucide="x"></i></button>
            </div>
            <div id="chat-messages" class="h-48 overflow-y-auto text-sm text-gray-700 dark:text-gray-300 mb-2">
                <p class="text-gray-500 italic">Hi 👋 How can I help?</p>
            </div>
            <div class="flex items-center gap-2">
                <input id="chat-input" type="text" placeholder="Ask a question..."
                    class="flex-1 border rounded-md p-2 text-sm dark:bg-gray-700 dark:border-gray-600">
                <button id="send-btn" class="bg-indigo-600 text-white px-3 py-2 rounded-md hover:bg-indigo-700">
                    <i data-lucide="send"></i>
                </button>
            </div>
        </div>
        <button id="chatbot-toggle"
            class="bg-indigo-600 text-white p-4 rounded-full shadow-lg hover:bg-indigo-700 transition">
            <i data-lucide="message-circle" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- 🔐 Login Modal -->
    <!-- 🔐 Login Modal -->
    <div id="login-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-80 sm:w-96 p-6 relative animate-fade-in">
            <button id="close-login" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 transition">
                <i data-lucide="x"></i>
            </button>

            <h3 class="text-xl font-semibold text-center mb-4 text-indigo-600">
                Campus Access Login
            </h3>

            <form id="login-form" class="space-y-3">
                <input type="text" id="username" placeholder="University ID or Email"
                    class="w-full border rounded-md p-2 dark:bg-gray-700 dark:border-gray-600">
                <input type="password" id="password" placeholder="Password"
                    class="w-full border rounded-md p-2 dark:bg-gray-700 dark:border-gray-600">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
                    Sign In
                </button>
            </form>
        </div>
    </div>




    <!-- 🔎 Search Results Modal -->
    <div id="search-modal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-80 sm:w-96 p-6 relative max-h-[80vh] overflow-y-auto">
            <button id="close-search" class="absolute top-3 right-3 text-gray-500 hover:text-red-500"><i
                    data-lucide="x"></i></button>
            <h3 class="text-lg font-semibold mb-3 text-indigo-600">Search Results</h3>
            <div id="search-results" class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                <p class="text-gray-500 italic">No results yet...</p>
            </div>
        </div>
    </div>

    <!-- 📜 Footer -->
    <footer
        class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-4 text-sm text-gray-600 dark:text-gray-400">
        © <?php echo date('Y'); ?> University Campus Library — All Rights Reserved
    </footer>

    <!-- ⚙️ Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();

            const loginBtn = document.getElementById('login-btn');
            const loginModal = document.getElementById('login-modal');
            const closeLogin = document.getElementById('close-login');
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const chatbox = document.getElementById('chatbox');
            const closeChat = document.getElementById('close-chat');
            const sendBtn = document.getElementById('send-btn');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            const searchModal = document.getElementById('search-modal');
            const closeSearch = document.getElementById('close-search');
            const searchResults = document.getElementById('search-results');

            // 🔐 Login Modal Controls (fixed)
            loginBtn.addEventListener('click', () => {
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // prevent background scroll
            });

            closeLogin.addEventListener('click', () => {
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
                document.body.style.overflow = ''; // restore scroll
            });

            window.addEventListener('click', (e) => {
                if (e.target === loginModal) {
                    loginModal.classList.add('hidden');
                    loginModal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            });


            // Chatbot
            chatbotToggle.addEventListener('click', () => chatbox.classList.toggle('hidden'));
            closeChat.addEventListener('click', () => chatbox.classList.add('hidden'));
            sendBtn.addEventListener('click', () => {
                const msg = chatInput.value.trim();
                if (!msg) return;
                chatMessages.innerHTML += `<p><strong>You:</strong> ${msg}</p>`;
                chatInput.value = '';
                setTimeout(() => {
                    chatMessages.innerHTML += `<p><strong>Assistant:</strong> I’ll look that up for you!</p>`;
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 700);
            });

            // Search
            searchBtn.addEventListener('click', () => {
                const query = searchInput.value.trim();
                if (!query) return;
                searchModal.classList.remove('hidden');
                searchResults.innerHTML = `<p class="text-gray-500 italic">Searching for "${query}"...</p>`;
                setTimeout(() => {
                    searchResults.innerHTML = `
            <div class="border-b pb-2"><strong>Found:</strong> "${query}" by J. Doe (2023)</div>
            <div class="border-b pb-2"><strong>Book:</strong> "Advanced Library Systems" – M. Reyes</div>
            <div><strong>Paper:</strong> "AI in Metadata Extraction" – University Research Archive</div>
          `;
                }, 800);
            });

            closeSearch.addEventListener('click', () => searchModal.classList.add('hidden'));
            window.addEventListener('click', e => { if (e.target === searchModal) searchModal.classList.add('hidden'); });
        });
    </script>
</body>

</html>