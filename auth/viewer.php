<?php
include "../header.php";

// --- Token validation ---
$token = $_GET['token'] ?? null;
$pdfFile = null;
$title = null;
$author = null;

if ($token && isset($_SESSION['pdf_tokens'][$token])) {
  $tokenData = $_SESSION['pdf_tokens'][$token];


  if ($tokenData['expires'] >= time()) {
    $pdfFile = $tokenData['file'];
    $title = $tokenData['book_titlev'] ?? 'Unknown Title';
    $author = $tokenData['book_author'] ?? 'Unknown Author';

  } else {
    echo '<script type="text/javascript">
    window.location.reload(true); // The "true" forces the browser to reload the page from the server, not the cache
      </script>';
    unset($_SESSION['pdf_tokens'][$token]);
  }
}

// Construct secure URL for JS
$pdfUrl = $pdfFile ? htmlspecialchars(base_url() . "auth/" . $pdfFile, ENT_QUOTES, 'UTF-8') : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Secure PDF Viewer</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.3.136/pdf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">

  <header
    class="sticky top-0 z-50 flex items-center justify-between px-2 py-1 bg-gray-800/20 backdrop-blur-sm shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center gap-1">
      <div id="timer" class="text-[10px] md:text-xs font-semibold text-black-200">⏱ 00:00</div>
      <div id="pageInfo" class="text-[10px] md:text-xs text-black-300 md:ml-2">📖 Pages: 0</div>
    </div>
    <div class="flex gap-1">
      <button id="favoriteBtn"
        class="flex items-center gap-1 text-orange-400 text-xs font-semibold py-1 px-2 rounded hover:bg-gray-700/20 transition duration-150"
        title="Add to Favorites">
        <span>★ Favorite</span>
      </button>

      <button id="endBtn"
        class="flex items-center gap-1 text-red-400 text-xs font-semibold py-1 px-2 rounded hover:bg-gray-700/20 transition duration-150"
        title="End Reading">
        <span>⏹ End</span>
      </button>
    </div>
  </header>

  <div id="loader" class="flex-1 flex items-center justify-center">
    <div class="flex flex-col items-center">
      <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-3 text-sm">Loading PDF, please wait...</p>
    </div>
  </div>

  <main id="viewerContainer" class="hidden flex-1 overflow-auto p-2 md:p-4 space-y-4"></main>


  <script>
    $(function () {
      const $timer = $("#timer"),
        $pageInfo = $("#pageInfo"),
        $container = $("#viewerContainer"),
        $loader = $("#loader");

      let pdfDoc = null, seconds = 0, timerInterval = null, isFavorite = false;
      const pdfUrl = "<?php echo $pdfUrl; ?>";
      const isAdmin = <?php echo isset($_SESSION['admin']) ? 'true' : 'false'; ?>; // Check if user is admin (using PHP session or any condition you have)

      if (!pdfUrl) {
        $loader.html(`<p class='text-red-500 font-semibold'>⚠️ Invalid or expired token.</p>`);
        return;
      }
      $(document).on("contextmenu", function (e) {
        e.preventDefault();
      });



      // --- Load PDF ---
      pdfjsLib.getDocument(pdfUrl).promise
        .then(pdf => {
          pdfDoc = pdf;
          $loader.addClass("hidden");
          $container.removeClass("hidden");
          $pageInfo.text(`📖 Pages: ${pdf.numPages}`);

          let promise = Promise.resolve();
          for (let i = 1; i <= pdf.numPages; i++) {
            promise = promise.then(() => renderPage(i));
          }
          promise.then(() => {
            $(document).on("keydown", e => {
              if (e.ctrlKey && ["s", "p", "u", "c"].includes(e.key.toLowerCase())) e.preventDefault();
            });
            $("body").css("user-select", "none");
          });

          function renderPage(i) {
            return pdfDoc.getPage(i).then(page => {
              const viewport = page.getViewport({ scale: 1.3 });
              const canvas = $("<canvas>")
                .addClass("bg-gray-800 rounded-lg shadow-lg mx-auto block w-full max-w-4xl mb-6")[0];
              canvas.height = viewport.height;
              canvas.width = viewport.width;
              $container.append(canvas);
              return page.render({ canvasContext: canvas.getContext("2d"), viewport }).promise;
            });
          }
        })
        .catch(err => {
          console.error("PDF load failed:", err);
          $loader.html(`<p class='text-red-500 font-semibold'>⚠️ Failed to load PDF.</p>`);
        });

      startTimer();
      // --- Timer ---
      function startTimer() {
        timerInterval = setInterval(() => {
          seconds++;
          const mins = String(Math.floor(seconds / 60)).padStart(2, "0");
          const secs = String(seconds % 60).padStart(2, "0");
          $timer.text(`⏱ ${mins}:${secs}`);
        }, 1000);

      }



      if (isAdmin) $("#favoriteBtn").addClass('hidden');

      // --- Favorite button AJAX ---
      $("#favoriteBtn").click(function () {
        isFavorite = !isFavorite;
        const btn = $(this);
        btn.toggleClass("bg-red-600", isFavorite);
        btn.toggleClass("bg-blue-600", !isFavorite);

        $.ajax({
          url: `${base_url}auth/action.php?action=toggle_favorite`,
          type: "POST",
          data: {
            file: "<?php echo $pdfFile; ?>",
            favorite: isFavorite ? 1 : 1
          },
          dataType: "json",
          success: function (response) {
            if (response.status === 1) {
              alert(response.message);
            } else {
              alert(response.message);
            }
          },
          error: function (err) {
            console.error("Favorite update failed:", err);
          }
        });
      });

      // --- End reading session AJAX ---
      $("#endBtn").click(function () {
        clearInterval(timerInterval);

        $.ajax({
          url: `${base_url}auth/action.php?action=end_reading`,
          type: "POST",
          data: {
            file: "<?php echo $pdfFile; ?>",
            book_title: "<?php echo $title; ?>",
            book_author: "<?php echo $author; ?>",
            duration: seconds
          },
          dataType: "json",
          success: function (response) {
            if (response.status === 1) {
              alert(`Reading session ended. You spent ${Math.floor(seconds / 60)}m ${seconds % 60}s.`);

              if (isAdmin) {
                window.close(); // Close the tab for admin
              } else {
                window.location.href = "<?php echo base_url(); ?>"; // Redirect for regular users
              }
            }
          },
          error: function (err) {
            console.error("End reading session failed:", err);
          }
        });

      });

      const token = "<?= $token ?>";

      let expiredShown = false;

      setInterval(() => {
        fetch(`token_check.php?token=${token}`)
          .then(res => res.json())
          .then(data => {
            if (data.status === 'expired' && !expiredShown) {
              expiredShown = true;

              Swal.fire({
                icon: 'info',
                title: 'NOTE ALERT',
                text: 'You’ve reached the time limit. Please open it again to continue.',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
              }).then(() => {
                clearInterval(timerInterval);

                $.ajax({
                  url: `${base_url}auth/action.php?action=end_reading`,
                  type: "POST",
                  data: {
                    file: "<?php echo $pdfFile; ?>",
                    book_title: "<?php echo $title; ?>",
                    book_author: "<?php echo $author; ?>",
                    duration: seconds
                  },
                  dataType: "json",
                  success: function (response) {
                    if (response.status === 1) {
                      alert(`Reading session ended. You spent ${Math.floor(seconds / 60)}m ${seconds % 60}s.`);

                      if (isAdmin) {
                        window.close(); // Close the tab for admin
                      } else {
                        window.location.href = "<?php echo base_url(); ?>"; // Redirect for regular users
                      }
                    }
                  },
                  error: function (err) {
                    console.error("End reading session failed:", err);
                  }
                });
                window.location.href = "http://localhost/UniversityLibrary/index.php";
              });
            }
          });
      }, 1000);
    });
  </script>


</body>

</html>