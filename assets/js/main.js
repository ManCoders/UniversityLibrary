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

  /* $("#login").on("submit", function (e) {
    e.preventDefault();

    const username = $("#university-id").val().trim();
    const password = $("#password").val().trim();

    if (!username || !password) {
      $("#login-message")
        .removeClass("hidden text-green-500")
        .addClass("text-red-500")
        .text("Please enter both username and password.");
      return;
    }

    $.ajax({
      url: `${base_url}auth/action.php?action=login`,
      type: "POST",
      data: { username: username, password: password },
      dataType: "json",

      beforeSend: function () {
        $("#login button[type=submit]")
          .prop("disabled", true)
          .text("Logging in...");
        $("#login-message")
          .removeClass("hidden text-red-500 text-green-500")
          .addClass("text-gray-500")
          .text("Authenticating...");
      },

      success: function (res) {
        try {
          // Handle plain-text JSON responses safely
          if (typeof res === "string") res = JSON.parse(res);

          if (res.status === 1) {
            $("#login-message")
              .removeClass("text-gray-500 text-red-500 hidden")
              .addClass("text-green-500")
              .text(res.message || "Login successful! Redirecting...");

            setTimeout(() => {
              window.location.href = res.redirect_url || "./dashboard.php";
            }, 800);
          } else {
            $("#login-message")
              .removeClass("text-gray-500 text-green-500 hidden")
              .addClass("text-red-500")
              .text(res.message || "Invalid username or password.");
          }
        } catch (err) {
          console.error("JSON parse error:", err);
          $("#login-message")
            .removeClass("text-gray-500 text-green-500 hidden")
            .addClass("text-red-500")
            .text("Unexpected server response. Please try again.");
        }
      },

      error: function (xhr, status, error) {
        console.error("Login AJAX error:", error);
        $("#login-message")
          .removeClass("text-gray-500 text-green-500 hidden")
          .addClass("text-red-500")
          .text("Network error. Please try again later.");
      },

      complete: function () {
        $("#login button[type=submit]").prop("disabled", false).text("Sign In");
      },
    });
  }); */

  /* $("body").on("click", "#logout", function (e) {
    e.preventDefault();
    const $this = $(this);
    $.ajax({
      url: base_url + "auth/action.php?action=logout",
      method: "POST",
      dataType: "json",
      beforeSend: function () {
        $this.text("Logging out.");
      },
      success: function (response) {
        if (response.status == 1) {
          window.location.href =
            base_url + (response.redirect_url || "index.php");
        } else {
          console.log(response.message);
        }
      },
      error: function () {
        console.error("AJAX error");
      },
    });
  }); */
  /* END LIBRARIAN SETTING PROFILE */

  /* INDEX FUNCTION */

  // --- GLOBAL STATE ---
  let userState = {
    isLoggedIn: false,
    username: "guest",
    role: "N/A",
    profilePic: null,
  };

  // --- SESSION PERSISTENCE ---
  // Check localStorage for a saved user session
  const savedState = localStorage.getItem("userState");
  if (savedState) {
    try {
      const parsedState = JSON.parse(savedState);
      if (parsedState.isLoggedIn) {
        userState = parsedState;
      }
    } catch (e) {
      console.error("Failed to parse saved user state:", e);
      localStorage.removeItem("userState"); // Clear corrupted state
    }
  }

  // 1. Initial Icon Rendering & Footer Year
  if (typeof lucide !== "undefined" && lucide.createIcons) {
    // Renders all Lucide icons initially
    lucide.createIcons();
  }
  $("#current-year").text(new Date().getFullYear());

  // 2. Dark Mode Logic (Synchronization and Listener)
  const THEME_KEY = "theme";
  const htmlElement = $("html");
  const darkModeIcon = $("#dark-mode-icon");

  /**
   * Applies the 'dark' class, updates the stored preference, and refreshes the Lucide icon.
   * @param {boolean} isDark - True to set dark mode, false for light.
   */
  function applyTheme(isDark) {
    // Toggle classes based on new state
    htmlElement.toggleClass("dark", isDark).toggleClass("light", !isDark);

    // Update the icon attribute (sun for dark mode, moon for light mode)
    darkModeIcon.attr("data-lucide", isDark ? "sun" : "moon");

    // Re-render the specific icon element
    if (typeof lucide !== "undefined" && lucide.createIcons) {
      lucide.createIcons();
    }
  }

  // SYNCHRONIZE INITIAL ICON STATE: Check the theme set by the FOUC script and set the correct icon
  const isDarkInitial = htmlElement.hasClass("dark");
  applyTheme(isDarkInitial);

  // Dark Mode Toggle Click Handler
  $("#dark-mode-toggle").on("click", function () {
    // Determine the new state (toggle the current state)
    const isDark = !htmlElement.hasClass("dark");
    applyTheme(isDark);
    // Persist the preference
    localStorage.setItem(THEME_KEY, isDark ? "dark" : "light");
  });

  // Theme selectors in Settings
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

  // 4. User Authentication & Profile Logic
  const loginModal = $("#login-modal");
  const profileBtn = $("#profile-btn");
  const signInBtn = $("#auth-sign-in-btn");
  const profileDropdown = $("#profile-dropdown");
  const allNavLinks = $(".nav-link");
  const allViewSections = $(".view-section");

  /**
   * Updates the header UI based on the login state.
   */
  function updateHeaderUI() {
    if (userState.isLoggedIn) {
      signInBtn.addClass("hidden");
      profileBtn.removeClass("hidden");
      // Use the 'username' from state, which is set from 'user_name' or 'user_data.username' on login
      const usernameText = `User: ${userState.username}`;
      $("#profile-username").text(usernameText);
      $("#profile-view-username").text(userState.username); // Update profile view name

      // Use a mock ID or a real one if the backend provided it
      $("#profile-view-id").text(
        userState.civil_id ||
          (userState.username === "admin" ? "U142-993-A" : "T200-111-B")
      );
      $("#profile-role").text(userState.role || "Student"); // Update role from state

      // Re-render user icon (in case it wasn't rendered on load)
      if (typeof lucide !== "undefined" && lucide.createIcons) {
        lucide.createIcons();
      }
    } else {
      signInBtn.removeClass("hidden");
      profileBtn.addClass("hidden");
      profileDropdown.addClass("hidden"); // Ensure dropdown is closed on logout
      profileBtn.attr("aria-expanded", "false");
      // Ensure we are back on the home view on logout
      showView("home");
    }
  }

  // Simple View Manager (for main tabs)
  function showView(viewId) {
    // Hide all view sections
    allViewSections.addClass("hidden");
    // Show the requested section
    $(`#${viewId}-section`).removeClass("hidden");

    // Update navigation active state
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

    // Close profile dropdown if view was changed from there
    toggleProfileDropdown(false);
  }

  // Hide/Show Profile Dropdown
  function toggleProfileDropdown(show) {
    const isVisible = profileDropdown.hasClass("hidden");
    show = show === undefined ? isVisible : show; // Toggle if no argument provided

    if (show) {
      profileDropdown.removeClass("hidden");
      profileBtn.attr("aria-expanded", "true");
    } else {
      profileDropdown.addClass("hidden");
      profileBtn.attr("aria-expanded", "false");
    }
  }

  // Listeners for Profile/Dropdown
  profileBtn.on("click", () => toggleProfileDropdown());
  // Close dropdown if user clicks anywhere outside of the button or dropdown
  $(document).on("click", function (e) {
    if (
      userState.isLoggedIn &&
      !$(e.target).closest("#user-auth-container").length
    ) {
      toggleProfileDropdown(false);
    }
  });

  // Click listener for main navigation buttons
  allNavLinks.on("click", function () {
    const viewId = $(this).data("view");
    showView(viewId);
  });

  // Update profile dropdown links to use showView
  $("[data-view-target]").on("click", (e) => {
    e.preventDefault();
    showView($(e.currentTarget).data("view-target"));
  });

  // Link Sign In button to open the Login Modal
  signInBtn.on("click", () => toggleModal(loginModal, true));

  // Close Login Modal
  $("#close-login, #login-modal").on("click", function (e) {
    // Only close if clicked on the X button or the backdrop
    if (
      e.target === this ||
      e.target.id === "close-login" ||
      $(e.target).closest("#close-login").length
    ) {
      toggleModal(loginModal, false);
    }
  });

  // ✅ Handle Login Form Submission (REAL BACKEND)
  $("#login").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);
    const $submitButton = $form.find("button[type=submit]");
    const $message = $("#login-message");

    // ✅ FIXED SELECTORS
    const username = $("#username-input").val();
    const password = $("#password-input").val();

    if (!username || !password) {
      $message
        .removeClass("hidden text-green-500 text-gray-500")
        .addClass("text-red-500")
        .text("Please enter both username and password.")
        .show();
      return;
    }

    $.ajax({
      url: `${base_url}auth/action.php?action=login`, // Using base_url
      type: "POST",
      data: { username: username, password: password },
      dataType: "json",

      beforeSend: function () {
        // ✅ FIXED SELECTOR
        $("#login-form button[type=submit]")
          .prop("disabled", true)
          .text("Logging in...");
        $message
          .removeClass("hidden text-red-500 text-green-500")
          .addClass("text-gray-500")
          .text("Authenticating...")
          .show();
      },

      success: function (res) {
        try {
          if (typeof res === "string") res = JSON.parse(res);

          if (res.status === 1) {
            const userData = res.user_data || {};
            userState.isLoggedIn = true;
            userState.username = res.user_name || userData.username || username;
            userState.role = userData.user_role || "student";
            userState.profilePic = userData.profile_pic || null;
            userState.civil_id = userData.civil_id || null;

            $message
              .removeClass("text-gray-500 text-red-500")
              .addClass("text-green-500")
              .text(res.message || "Login successful!")
              .show();

            // ✅ Save user data locally
            localStorage.setItem("userState", JSON.stringify(userState));

            // ✅ Determine role-based redirection
            const role = userState.role.toLowerCase();
            if (role === "admin" && res.redirect_url) {
              setTimeout(() => {
                window.location.href = res.redirect_url; // e.g. src/admin/
              }, 1000);
              return;
            }

            if (role === "faculty" && res.redirect_url) {
              setTimeout(() => {
                window.location.href = res.redirect_url; // e.g. src/faculty/
              }, 1000);
              return;
            }

            // 👨‍🎓 Student stays on SPA
            updateHeaderUI();
            showView("home");

            // ✅ Close login modal after delay
            setTimeout(() => {
              toggleModal(loginModal, false);
              $message.hide().text("");
            }, 1500);
          } else {
            // ❌ Login failed
            userState.isLoggedIn = false;
            $message
              .removeClass("text-gray-500 text-green-500")
              .addClass("text-red-500")
              .text(res.message || "Login failed. Invalid credentials.")
              .show();
            localStorage.removeItem("userState");
          }
        } catch (err) {
          console.error("JSON parse error:", err, res);
          $message
            .removeClass("text-gray-500 text-green-500")
            .addClass("text-red-500")
            .text("Unexpected server response. Please try again.")
            .show();
        }
      },

      error: function (xhr, status, error) {
        console.error("Login AJAX error:", error);
        $message
          .removeClass("text-gray-500 text-green-500")
          .addClass("text-red-500")
          .text("Network error. Please try again later.")
          .show();
      },

      complete: function () {
        // ✅ FIXED SELECTOR
        $("#login-form button[type=submit]")
          .prop("disabled", false)
          .text("Sign In");
      },
    });
  });

  // Handle Logout
  // ✅ Handle Logout (Full Reset for Admin/Faculty)
  $("body").on("click", "#logout", function (e) {
    e.preventDefault();

    const $this = $(this);

    $.ajax({
      url: base_url + "auth/action.php?action=logout",
      method: "POST",
      dataType: "json",
      beforeSend: function () {
        $this.text("Logging out...");
      },
      success: function (response) {
        // Always clear frontend session
        localStorage.removeItem("userState");
        userState = {
          isLoggedIn: false,
          username: null,
          role: null,
          profilePic: null,
          civil_id: null,
        };

        const role = (response.user_role || "").toLowerCase();

        if (response.status == 1) {
          // 🧠 Redirect admin/faculty to index.php
          if (role === "admin" || role === "faculty") {
            console.log(`${role} logged out — returning to index...`);
            setTimeout(() => {
              window.location.href = base_url + "index.php";
            }, 400);
          } else {
            // 👨‍🎓 Student logout just resets the SPA
            updateHeaderUI();
            showView("home");
            setTimeout(() => location.reload(), 500);
          }
        } else {
          console.warn("Logout failed:", response.message);
        }
      },
      error: function (xhr, status, err) {
        console.error("AJAX logout error:", err);
      },
      complete: function () {
        $this.text("Loging out...");
        setTimeout(() => {
          window.location.href = base_url +"./index.php";
        }, 400);
      },
    });
  });

  // Initialize UI state (checks localStorage)
  updateHeaderUI();
  showView("home"); // Ensure we start on the home tab

  // 5. Chatbot Logic
  const chatbox = $("#chatbox");
  const chatInput = $("#chat-input");
  const chatMessages = $("#chat-messages");

  $("#chatbot-toggle").on("click", () => chatbox.toggleClass("hidden"));
  $("#close-chat").on("click", () => chatbox.addClass("hidden"));

  function sendMessage() {
    const msg = chatInput.val().trim();
    if (!msg) return;

    // User message (right-aligned)
    chatMessages.append(`
    <div class="text-right">
      <span class="inline-block bg-indigo-600 text-white p-2 rounded-lg max-w-[80%]">
        ${msg}
      </span>
    </div>
  `);
    chatInput.val("");
    chatMessages.scrollTop(chatMessages[0].scrollHeight); // Scroll to bottom

    // Assistant reply
    setTimeout(() => {
      let reply =
        "I’ll look that up for you! Please log in for detailed assistance.";

      if (msg.toLowerCase().includes("hours")) {
        reply = "The main library is open 8:00 AM – 9:00 PM (Mon–Fri).";
      } else if (msg.toLowerCase().includes("metadata")) {
        reply =
          "Our Smart Metadata Management automatically tags and organizes research papers for easy citation.";
      }

      chatMessages.append(`
      <div class="text-left">
        <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 rounded-lg max-w-[80%]">
          ${reply}
        </span>
      </div>
    `);
      chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }, 700);
  }

  $("#send-btn").on("click", sendMessage);
  chatInput.on("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

  // 6. Search Logic
  const searchModal = $("#search-modal");
  const searchInput = $("#search-input");
  const searchResults = $("#search-results");

  $("#search-btn").on("click", function (e) {
    e.preventDefault();
    performSearch();
  });
  searchInput.on("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      performSearch();
    }
  });

  function performSearch() {
    const query = searchInput.val().trim();
    if (!query) return;

    toggleModal(searchModal, true);

    // 🟣 Searching state
    searchResults.html(
      `<p class='text-gray-700 dark:text-gray-300 italic'>Searching for "${query}"...</p>`
    );

    setTimeout(() => {
      // 🟢 Simulated results
      searchResults.html(`
      <div class='p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
        <a href='#' class='font-semibold text-indigo-700 dark:text-indigo-400 hover:underline'>
          Found: The Future of Digital Libraries
        </a>
        <p class='text-sm text-gray-700 dark:text-gray-300'>By J. Doe (2023) — Research Paper</p>
      </div>

      <div class='p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
        <a href='#' class='font-semibold text-indigo-700 dark:text-indigo-400 hover:underline'>
          Book: Advanced Library Systems Design
        </a>
        <p class='text-sm text-gray-700 dark:text-gray-300'>By M. Reyes (2021) — Available in print</p>
      </div>

      <div class='p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition'>
        <a href='#' class='font-semibold text-indigo-700 dark:text-indigo-400 hover:underline'>
          Paper: AI in Metadata Extraction
        </a>
        <p class='text-sm text-gray-700 dark:text-gray-300'>University Research Archive — Open Access</p>
      </div>
    `);

      searchInput.val("");
    }, 800);
  }

  $("#close-search, #search-modal").on("click", function (e) {
    // Only close if clicked on the X button or the backdrop (e.target is the modal itself)
    if (
      e.target === this ||
      e.target.id === "close-search" ||
      $(e.target).closest("#close-search").length
    ) {
      toggleModal(searchModal, false);
    }
  });

  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        fontFamily: {
          sans: ["Inter", "sans-serif"],
        },
        colors: {
          "indigo-700": "#4338ca",
          "indigo-600": "#4f46e5",
          "indigo-50": "#eef2ff",
        },
      },
    },
  };

  // --- Apply theme early (before paint) ---
  $(function () {
    const prefersDark = window.matchMedia(
      "(prefers-color-scheme: dark)"
    ).matches;
    const storedTheme = localStorage.getItem(THEME_KEY);
    const isDark =
      storedTheme === "dark" || (storedTheme === null && prefersDark);

    // Apply dark or light mode
    if (isDark) {
      $("html").addClass("dark");
    } else {
      $("html").removeClass("dark");
    }
  });
});
