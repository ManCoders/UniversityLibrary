<?php
include '../../header.php';

$allowed_pages = ['dashboard', 'metadata', 'users', 'reports', 'settings'];
$page = 'dashboard'; // default page

if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
  $page = $_GET['page'];
  
}
if (!isset($_SESSION['admin'])) {
  http_response_code(404);
  include '../../404.php';
  exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modular Admin Dashboard</title>

  <style>
    .main-content-wrapper {
      transition: margin-left 0.3s ease-in-out;
    }

    .content-area {
      /* 100vh minus the height of the sticky header/topbar (h-16) and the footer (h-12 approx) */
      min-height: calc(100vh - 4rem);
    }
  </style>
</head>

<body class="min-h-screen bg-gray-100 font-sans">

  <script>
    $(document).ready(function () {
      const initializeSidebarToggle = () => {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');
        const overlay = document.getElementById('sidebar-overlay');

        if (!sidebar || !openBtn || !closeBtn || !overlay) return;

        const toggleSidebar = (isOpen) => {
          sidebar.classList.toggle('-translate-x-full', !isOpen);
          overlay.classList.toggle('opacity-0', !isOpen);
          overlay.classList.toggle('pointer-events-none', !isOpen);
          overlay.classList.toggle('opacity-100', isOpen);
        };

        openBtn.addEventListener('click', () => toggleSidebar(true));
        closeBtn.addEventListener('click', () => toggleSidebar(false));
        overlay.addEventListener('click', () => toggleSidebar(false));

        document.querySelectorAll('.nav-link').forEach(link => {
          link.addEventListener('click', () => {
            if (window.innerWidth < 1024)
              setTimeout(() => toggleSidebar(false), 100);
          });
        });

        const observer = new MutationObserver(() => {
          if (window.innerWidth < 1024)
            document.body.style.overflow =
              sidebar.classList.contains('-translate-x-full') ? '' : 'hidden';
        });
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
      };


      initializeSidebarToggle();
    });
  </script>


    
    
  <!-- Sidebar and Overlay Containers -->
  <div id="sidebar-container"><?php include "./partials/sidebar.php" ?></div>


  <div class="main-content-wrapper lg:ml-64 flex flex-col min-h-screen">
    <div id="topbar-container"><?php include "./partials/topbar.php" ?></div>
    <main id="main-content-area"
      class="content-area flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 content-area flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
      <?php
      $page_file = "pages/{$page}.php";
      if (file_exists($page_file)) {
        include $page_file;
      } else {
        echo "<h1 class='text-2xl font-bold text-red-600'>404 - Page Not Found</h1>";
      }
      ?>
    </main>
    <div id="footer-container"><?php include "./partials/footer.php" ?></div>
  </div>

</body>

</html>