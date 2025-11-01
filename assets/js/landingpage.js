/* $(document).ready(function() {
    // --- Set current year in footer ---
    $('#current-year').text(new Date().getFullYear());

    // --- Utility Functions for Modals and Menu ---
    function setModalState(modalId, isActive) {
        const $modal = $('#' + modalId);
        if (!$modal.length) return;

        if (!isActive) {
            $modal.removeClass('active');
            setTimeout(() => { $modal.hide(); }, 300);
        } else {
            $modal.css('display', 'flex');
            setTimeout(() => { $modal.addClass('active'); }, 10);
        }
    }

    // --- Mobile Menu Functions ---
    function toggleMobileMenu() {
        const $menu = $('#mobile-menu');
        const $openIcon = $('#mobile-menu-icon-open');
        const $closeIcon = $('#mobile-menu-icon-close');

        if ($menu.hasClass('hidden')) {
            $menu.removeClass('hidden');
            $openIcon.addClass('hidden');
            $closeIcon.removeClass('hidden');
        } else {
            $menu.addClass('hidden');
            $openIcon.removeClass('hidden');
            $closeIcon.addClass('hidden');
        }
    }

    function closeMobileMenu() {
        $('#mobile-menu').addClass('hidden');
        $('#mobile-menu-icon-open').removeClass('hidden');
        $('#mobile-menu-icon-close').addClass('hidden');
    }

    // --- Login Modal ---
    function openLoginModal() { setModalState('login-modal', true); }
    function closeLoginModal() {
        setModalState('login-modal', false);
        $('#login-status').addClass('hidden');
    }

    function handleLoginSubmit(e) {
        e.preventDefault();
        const $status = $('#login-status');
        $status.text("Simulated: Login successful! Redirecting to dashboard...")
               .removeClass('hidden text-red-500')
               .addClass('text-green-600');

        setTimeout(() => { closeLoginModal(); }, 1500);
    }

    // --- Chat Modal ---
    function openChatModal() {
        setModalState('chat-modal', true);
        setTimeout(() => { $('#chat-input').focus(); }, 350);
    }

    function closeChatModal() { setModalState('chat-modal', false); }

    function sendMessage(e) {
        e.preventDefault();
        const $input = $('#chat-input');
        const message = $input.val().trim();
        if (!message) return;

        const $messages = $('#chat-messages');

        // User message
        $('<div>', {
            class: 'user-message max-w-[80%] p-3 rounded-xl shadow-md self-end',
            text: message
        }).appendTo($messages);

        $input.val('');
        $messages.scrollTop($messages[0].scrollHeight);

        // Simulate support response
        setTimeout(() => {
            $('<div>', {
                class: 'support-message max-w-[80%] p-3 rounded-xl shadow-md self-start',
                text: `Thank you for your message: "${message}". A support representative will join the chat shortly.`
            }).appendTo($messages);
            $messages.scrollTop($messages[0].scrollHeight);
        }, 1000);
    }

    // --- Guide Modal ---
    function openGuideModal() { setModalState('guide-modal', true); }
    function closeGuideModal() { setModalState('guide-modal', false); }

    // --- Search Message ---
    function performSearch() {
        const query = $('#elibrary-search').val().trim();
        if (!query) return;

        const $msg = $('#search-message');
        $msg.text(`Searching the eLibrary for "${query}"... (Placeholder)`)
            .removeClass('text-red-200')
            .addClass('text-accent-gold');

        setTimeout(() => {
            $msg.text('Example: "Artificial Intelligence Ethics" or "Quarterly Journal of Economics"')
                .removeClass('text-accent-gold')
                .addClass('text-red-200');
        }, 2000);
    }

    // --- Initial State ---
    $('#login-modal, #chat-modal, #guide-modal').hide();

    // --- Expose functions globally if needed ---
    window.toggleMobileMenu = toggleMobileMenu;
    window.closeMobileMenu = closeMobileMenu;
    window.openLoginModal = openLoginModal;
    window.closeLoginModal = closeLoginModal;
    window.handleLoginSubmit = handleLoginSubmit;
    window.openChatModal = openChatModal;
    window.closeChatModal = closeChatModal;
    window.sendMessage = sendMessage;
    window.openGuideModal = openGuideModal;
    window.closeGuideModal = closeGuideModal;
    window.performSearch = performSearch;
}); */