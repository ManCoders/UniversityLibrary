$(document).ready(function () {
  $("#systemLogo").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#systemLogoPreview").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  $("#install-form").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);

    const system_details = {};
    const admin_details = {};
    let fileReadCount = 0;

    const fileInputs = $form.find("input[type=file]");
    const totalFiles = fileInputs.length;

    function sendIfReady() {
      if (fileReadCount >= totalFiles) {
        const payload = {
          system_details,
          admin_details,
        };

        // console.log("JSON payload ready:", payload);

        $.ajax({
          url: `${base_url}auth/action.php?action=installation`,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify(payload),
          dataType: "json",
          beforeSend: function () {
            $form
              .find("button[type=submit]")
              .prop("disabled", true)
              .text("Saving...");
          },
          success: function (response) {
            console.log("Server response:", response);
            if (response.status === 1) {
              Swal.fire({
                icon: "success",
                title: "Installation Complete",
                text: response.message || "Library system activated!",
                timer: 2500,
                showConfirmButton: false,
              }).then(() => (window.location.href = response.url));
            } else {
              Swal.fire({
                icon: "error",
                title: "Installation Failed",
                text: response.message || "Check your inputs and try again.",
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            Swal.fire({
              icon: "error",
              title: "Installation Failed",
              text: "AJAX request failed. Check console for details.",
            });
          },
          complete: function () {
            $form
              .find("button[type=submit]")
              .prop("disabled", false)
              .text("ACTIVATE LIBRARY SYSTEM");
          },
        });
      }
    }

    // Process all file inputs
    fileInputs.each(function () {
      const name = $(this).attr("name");
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          if (name.startsWith("system")) {
            system_details[name] = e.target.result; // System logo
          } else {
            admin_details[name] = e.target.result; // Admin profile pic
          }
          fileReadCount++;
          sendIfReady();
        };
        reader.readAsDataURL(file);
      } else {
        if (name.startsWith("system")) system_details[name] = null;
        else admin_details[name] = null;
        fileReadCount++;
        sendIfReady();
      }
    });

    // Collect non-file inputs
    $("#step-1")
      .find("input:not([type=file])")
      .each(function () {
        const name = $(this).attr("name");
        if (name) system_details[name] = $(this).val() || "";
      });

    $("#step-2")
      .find("input:not([type=file])")
      .each(function () {
        const name = $(this).attr("name");
        if (name) admin_details[name] = $(this).val() || "";
      });

    // If there are no file inputs, send immediately
    if (totalFiles === 0) {
      fileReadCount = 1;
      sendIfReady();
    }
  });

  if (typeof lucide !== "undefined" && lucide.createIcons) {
    lucide.createIcons();
  }
  $("#current-year").text(new Date().getFullYear());

  const THEME_KEY = "theme";
  const htmlElement = $("html");
  const darkModeIcon = $("#dark-mode-icon");

  /**
   * Applies the 'dark' class, updates the stored preference, and refreshes the Lucide icon.
   * @param {boolean} isDark
   */

  function applyTheme(isDark) {
    htmlElement.toggleClass("dark", isDark).toggleClass("light", !isDark);

    darkModeIcon.attr("data-lucide", isDark ? "sun" : "moon");

    if (typeof lucide !== "undefined" && lucide.createIcons) {
      lucide.createIcons();
    }
  }

  const isDarkInitial = htmlElement.hasClass("dark");
  applyTheme(isDarkInitial);

  // Dark Mode Toggle Click Handler
  $("#dark-mode-toggle").on("click", function () {
    const isDark = !htmlElement.hasClass("dark");
    applyTheme(isDark);
    localStorage.setItem(THEME_KEY, isDark ? "dark" : "light");
  });
  $(".theme-select").on("click", function () {
    const theme = $(this).data("theme");
    let isDark;

    if (theme === "system") {
      localStorage.removeItem(THEME_KEY);
      isDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    } else {
      isDark = theme === "dark";
      localStorage.setItem(THEME_KEY, theme);
    }
    applyTheme(isDark);

    // Update active state in settings
    $(".theme-select")
      .removeClass("bg-indigo-100 dark:bg-indigo-900 border-indigo-500")
      .addClass("border-gray-300 dark:border-gray-600");
    $(this)
      .addClass("bg-indigo-100 dark:bg-indigo-900 border-indigo-500")
      .removeClass("border-gray-300 dark:border-gray-600");
  });
  // ==========================
  // Global Variables & Setup
  // ==========================
  const loginModal = $("#login-modal");
  const profileBtn = $("#profile-btn");
  const signInBtn = $("#auth-sign-in-btn");
  const profileDropdown = $("#profile-dropdown");
  const allNavLinks = $(".nav-link");
  const allViewSections = $(".view-section");
  const $loginMessage = $("#login-message");

  // Global userState
  const userState = JSON.parse(
    sessionStorage.getItem("loggedIn") || JSON.stringify({ isLoggedIn: false })
  );
  sessionStorage.setItem("loggedIn", JSON.stringify(userState));

  // ==========================
  // Helper Functions
  // ==========================
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

  function showMessage(message, type = "gray") {
    $loginMessage
      .removeClass("text-gray-500 text-green-500 text-red-500")
      .addClass(`text-${type}-500`)
      .text(message)
      .show();
  }

  function updateHeaderUI() {
    if (userState.isLoggedIn) {
      signInBtn.addClass("hidden");
      profileBtn.removeClass("hidden");
      lucide?.createIcons?.();
    } else {
      signInBtn.removeClass("hidden");
      profileBtn.addClass("hidden");
      profileDropdown.addClass("hidden");
      profileBtn.attr("aria-expanded", "false");
      showView("home");
    }
  }

  function showView(viewId) {
    allViewSections.addClass("hidden");
    $(`#${viewId}-section`).removeClass("hidden");

    allNavLinks.each(function () {
      const $link = $(this);
      const isActive = $link.data("view") === viewId;
      $link
        .toggleClass(
          "text-indigo-600 dark:text-indigo-400 border-indigo-600 dark:border-indigo-400 font-semibold",
          isActive
        )
        .toggleClass(
          "text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 border-transparent hover:border-indigo-300 dark:hover:border-indigo-600",
          !isActive
        );
    });

    toggleProfileDropdown(false);
  }

  function toggleProfileDropdown(show) {
    const isVisible = profileDropdown.hasClass("hidden");
    show = show === undefined ? isVisible : show;

    profileDropdown.toggleClass("hidden", !show);
    profileBtn.attr("aria-expanded", show);
  }

  // ==========================
  // Event Handlers
  // ==========================
  profileBtn.on("click", () => toggleProfileDropdown());

  $(document).on("click", function (e) {
    if (
      userState.isLoggedIn &&
      !$(e.target).closest("#user-auth-container").length
    ) {
      toggleProfileDropdown(false);
    }
  });

  allNavLinks.on("click", function () {
    showView($(this).data("view"));
  });

  $("[data-view-target]").on("click", (e) => {
    e.preventDefault();
    showView($(e.currentTarget).data("view-target"));
  });

  signInBtn.on("click", () => toggleModal(loginModal, true));

  $("#close-login, #login-modal").on("click", function (e) {
    if (
      e.target === this ||
      e.target.id === "close-login" ||
      $(e.target).closest("#close-login").length
    ) {
      toggleModal(loginModal, false);
    }
  });

  // ==========================
  // Login Form
  // ==========================
  $("#login").on("submit", function (e) {
    e.preventDefault();

    const username = $("#username-input").val().trim();
    const password = $("#password-input").val().trim();

    if (!username || !password)
      return showMessage("Please enter both username and password.", "red");

    const $btn = $(this).find("button[type=submit]");
    $("#upload-spinner").removeClass("hidden").show();
    $btn.prop("disabled", true).text("Logging in...");
    showMessage("Authenticating...", "gray");

    $.ajax({
      url: `${base_url}auth/action.php?action=login`,
      method: "POST",
      data: { username, password },
      dataType: "json",
    })
      .done((res) => {
        if (res.status === 1) {
          userState.isLoggedIn = true;
          userState.user = res.user_data || {};
          sessionStorage.setItem("loggedIn", JSON.stringify(userState));

          showMessage(res.message || "Login successful!", "green");

          if (res.redirect_url) {
            setTimeout(() => {
              window.location.href = res.redirect_url;
            }, 600);
            return;
          }

          updateHeaderUI();
          showView("home");
          toggleModal(loginModal, false);
        } else {
          showMessage(res.message || "Invalid credentials.", "red");
        }
      })
      .fail(() => {
        showMessage("Server error. Try again later.", "red");
      })
      .always(() => {
        $("#upload-spinner").hide();
        $btn.prop("disabled", false).text("Sign In");
      });
  });

  // ==========================
  // Logout
  // ==========================
  $("body").on("click", "#logout", function (e) {
    e.preventDefault();
    const $btn = $(this);
    $("#upload-spinner").removeClass("hidden").hide();
    $btn.text("Logging out...");

    $.post(
      `${base_url}auth/action.php?action=logout`,
      function (res) {
        userState.isLoggedIn = false;
        userState.user = {};
        sessionStorage.setItem("loggedIn", JSON.stringify(userState));

        if (res.status == 1) {
          if (
            ["admin", "faculty"].includes((res.user_role || "").toLowerCase())
          ) {
            window.location.href = res.redirect_url; // direct redirect
          } else {
            updateHeaderUI();
            showView("home");
            window.location.href = res.redirect_url;
          }
        } else {
          console.warn("Logout failed:", res.message);
        }
      },
      "json"
    )
      .fail((err) => console.error("AJAX logout error:", err))
      .always(() => {
        $("#upload-spinner").removeClass("hidden").hide();
        $btn.text("Log Out");
      });
  });

  // ==========================
  // Initial UI Setup
  // ==========================
  updateHeaderUI();
  showView("home");
  // --- Chatbot Elements ---
  const chatbox = $("#chatbox");
  const chatInput = $("#chat-input");
  const chatMessages = $("#chat-messages");
  const sendBtn = $("#send-btn");

  $("#chatbot-toggle").on("click", () => chatbox.toggleClass("hidden"));
  $("#close-chat").on("click", () => chatbox.addClass("hidden"));

  // --- Send Message Function ---
  function sendMessage() {
    const msg = chatInput.val()?.trim();
    if (!msg) return;

    // Lock input
    chatInput.prop("disabled", true);
    sendBtn.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");

    // Render user message
    const userContainer = $('<div class="text-right mb-4"></div>');
    const userBubble = $(
      '<div class="inline-block bg-[#b03060] text-white px-4 py-2 rounded-2xl rounded-tr-none max-w-[85%] text-left shadow-sm break-words"></div>'
    );
    userBubble.text(msg);
    userContainer.append(userBubble);
    chatMessages.append(userContainer);
    scrollToBottom();

    // Render AI bubble + typing indicator
    const aiContainer = $('<div class="text-left mb-4"></div>');
    const aiBubble = $(
      '<div class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-2xl rounded-tl-none max-w-[90%] shadow-sm break-words leading-relaxed"></div>'
    );
    const typingIndicator = $(`
      <div id="typing-indicator" class="flex space-x-1 mt-1">
          <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
          <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-75"></div>
          <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-150"></div>
      </div>
  `);
    aiBubble.append(typingIndicator);
    aiContainer.append(aiBubble);
    chatMessages.append(aiContainer);
    scrollToBottom();

    // --- AJAX Call to PHP Proxy ---
    $.ajax({
      url: `${base_url}auth/action.php?action=chatSupportAI`,
      type: "POST",
      data: { message: msg },
      dataType: "json",
      success: function (res) {
        $("#typing-indicator").remove();

        const reply = res.status === 1 ? res.reply : `[ERROR] ${res.reply}`;

        // Word-by-word typing
        const words = reply.split(/\s+/);
        let idx = 0;
        const wordDelay = 150; // ms per word

        function typeWord() {
          if (idx < words.length) {
            aiBubble.html(formatAIResponse(words.slice(0, idx + 1).join(" ")));
            scrollToBottom();
            idx++;
            setTimeout(typeWord, wordDelay);
          }
        }

        typeWord();
      },
      error: function () {
        $("#typing-indicator").remove();
        aiBubble.html(
          '<span class="text-red-600 text-xs">Service unavailable.</span>'
        );
        scrollToBottom();
      },
      complete: function () {
        chatInput.val("").prop("disabled", false).focus();
        sendBtn
          .prop("disabled", false)
          .removeClass("opacity-50 cursor-not-allowed");
      },
    });
  }

  // --- Helpers ---
  function scrollToBottom() {
    chatMessages
      .stop()
      .animate({ scrollTop: chatMessages[0].scrollHeight }, 100);
  }

  function formatAIResponse(text) {
    if (!text) return "";
    let safe = text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;");

    // Code block formatting
    safe = safe.replace(
      /```([\s\S]*?)```/g,
      '<pre class="bg-gray-800 text-white p-2 rounded my-2 overflow-x-auto text-sm font-mono">$1</pre>'
    );

    // Inline code formatting
    safe = safe.replace(
      /`(.*?)`/g,
      '<code class="bg-gray-200 dark:bg-gray-600 px-1 rounded text-sm font-mono text-red-500">$1</code>'
    );

    // Bold
    safe = safe.replace(/\*\*(.*?)\*\*/g, "<b>$1</b>");
    // Italic
    safe = safe.replace(/\*(.*?)\*/g, "<i>$1</i>");
    safe = safe.replace(/\n/g, "<br>");

    return safe;
  }

  // --- Event Listeners ---
  sendBtn.on("click", sendMessage);
  chatInput.on("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

  // --- Elements ---
  const searchModal = $("#search-modal");
  const searchInput = $("#search-input");
  const searchResults = $("#search-results");

  function performSearch() {
    const query = searchInput.val();
    if (!query) return;

    toggleModal(searchModal, true);
    searchResults.html(
      `<p class='text-gray-700 dark:text-gray-300 italic'>Searching for "${query}"...</p>`
    );

    $.ajax({
      url: `${base_url}auth/action.php?action=searching`,
      type: "POST",
      data: { q: query },
      dataType: "json",
      success: function (res) {
        let html = "";
        if (
          res.status === 1 &&
          Array.isArray(res.data) &&
          res.data.length > 0
        ) {
          res.data.forEach((book) => {
            const title =
              book.metadata["dc:title"] || book.metadata.Title || book.metadata.title || " ";
            const author = book.metadata["dc:creator"]
              ? Array.isArray(book.metadata["dc:creator"])
                ? book.metadata["dc:creator"].join(", ")
                : book.metadata["dc:creator"]
              : book.metadata.Author || "Unknown Author";

            const coverPath = book.cover_path || "";
            const coverFile = book.cover || "default-cover.png";

            const cover =
              base_url +
              "auth/" +
              coverPath.split("/").map(encodeURIComponent).join("/");

            html += `
            <div class='p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition flex items-center space-x-3'>
              <img src='${cover}' alt='Cover' class='w-12 h-16 object-cover rounded-md'/>
              <div class='flex-1'>
                <button 
                  type="button" 
                  class="font-semibold text-indigo-700 dark:text-indigo-400 hover:underline text-left w-full file-link"
                  data-file="${book.file_path}" data-title='${title}' data-author='${author}'>
                  ${title}
                </button>
                <p class='text-sm text-gray-700 dark:text-gray-300'>${author}</p>
              </div>
            </div>
          `;
          });
        } else {
          html = `<p class='text-gray-700 dark:text-gray-300 italic'>No results found for "${query}".</p>`;
        }

        searchResults.html(html);
        searchInput.val("");

        // ---------- FILE LINK CLICK ----------
        $(".file-link")
          .off("click")
          .on("click", function () {
            const filePath = $(this).data("file");
            const title = $(this).data("title");
            const author = $(this).data("author");
            if (!filePath) {
              alert("File not found.");
              return;
            }

            // Check login before starting reading session
            checkLogin(() => {
              $.ajax({
                type: "POST",
                url: `${base_url}auth/action.php?action=readingbooks`,
                data: {
                  file: filePath,
                  book_title: title,
                  book_author: author,
                }, // relative path
                dataType: "json",
                success: function (res) {
                  if (res.status === 1 && res.data) {
                    window.open(res.data, "_blank");
                  } else {
                    alert(res.message || "Cannot open book.");
                  }
                },
                error: function (_xhr, _status, error) {
                  console.error("AJAX error:", error);
                  alert("Server error while opening the book.");
                },
              });
            });
          });

        // ---------- LOGIN CHECK ----------
        function checkLogin(callback) {
          $.ajax({
            url: `${base_url}auth/action.php?action=check_login`,
            type: "GET",
            dataType: "json",
            success: function (res) {
              if (res.status === 1) {
                callback();
              } else {
                toggleModal(loginModal, true);
                toggleModal(searchModal, false);
                window.pendingAction = callback;
              }
            },
            error: function () {
              alert("Error checking login status. Please refresh the page.");
            },
          });
        }
        onLoginSuccess();
        // ---------- AFTER LOGIN ----------
        function onLoginSuccess() {
          if (window.pendingAction) {
            window.pendingAction();
            window.pendingAction = null;
          }
        }
      },
      error: function (xhr, status, err) {
        console.error("Search AJAX error:", err, xhr.responseText);
        searchResults.html(
          `<p class='text-red-500 italic'>Error fetching results. Please try again.</p>`
        );
      },
    });
  }

  // --- Bind search triggers (no login needed to search) ---
  $("#search-btn").on("click", (e) => {
    e.preventDefault();
    performSearch(); // anyone can search
  });

  searchInput.on("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      performSearch(); // anyone can search
    }
  });

  $("#close-search, #search-modal").on("click", function (e) {
    if (
      e.target === this ||
      e.target.id === "close-search" ||
      $(e.target).closest("#close-search").length
    ) {
      toggleModal(searchModal, false);
    }
  });

  $("#change-password-form").on("submit", function (e) {
    e.preventDefault();

    const current = $("#current-password").val().trim();
    const newPass = $("#new-password").val().trim();
    const confirm = $("#confirm-password").val().trim();

    if (newPass !== confirm) {
      alert("New passwords do not match!");
      return;
    }

    $.ajax({
      url: `${base_url}auth/action.php?action=change_password`,
      type: "POST",
      data: { current, newPass },
      dataType: "json",
      success: function (res) {
        if (res.status === 1) {
          alert(res.message);
          $("#change-password-form")[0].reset();
        } else {
          alert(res.message);
        }
      },
      error: function () {
        alert("Server error. Please try again.");
      },
    });
  });
});
