<?php
include "config.php";

$pdo = db_connect();

function initInstaller()
{
    $pdo = db_connect();

    try {
        // Check if admin exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE JSON_EXTRACT(personal_details, '$.user_role') = ?");
        $stmt->execute(['Admin']);
        $adminCount = $stmt->fetchColumn();

        // Current request path
        $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $installerPath = 'installation'; // no leading slash, match after trim

        if ($adminCount > 0) {
            // Admin exists → block access to installer
            if (strpos($currentPath, $installerPath) === 0) {
                header("Location: " . base_url() . "/");
                exit;
            }
        } else {
            // No admin → force installer page
            if (strpos($currentPath, $installerPath) !== 0) {
                header("Location: " . base_url() . "installation/");
                exit;
            }
        }

    } catch (PDOException $e) {
        die("Installer check failed: " . $e->getMessage());
    }

    $pdo = null;
}




function base_url()
{
    // Detect protocol (HTTP or HTTPS)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $local_ips = ['127.0.0.1', '::1', '192.168.1.117'];

    // If running locally
    if (in_array($_SERVER['REMOTE_ADDR'], $local_ips)) {
        return $protocol . "://localhost/UniversityLibrary/";
    }

    // ✅ LIVE SITE PATH
    return $protocol . "://campus-chat-rooms.gamer.gd/UniversityLibrary/";
}

function get_current_page()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    return $protocol . '://' . $host . $uri;
}

function render_styles()
{

    $styles = [
        base_url() . 'assets/css/all-tailwind-classes-full-min.css',
        base_url() . 'assets/css/all.min.css'

    ];

    foreach ($styles as $style) {
        echo '<link rel="stylesheet" href="' . $style . '">';
    }

}

function render_installer_styles()
{

    $styles = [
        base_url() . 'assets/css/all-tailwind-classes-full-min.css',
    ];

    foreach ($styles as $style) {
        echo '<link rel="stylesheet" href="' . $style . '">';
    }

}

function render_scripts()
{

    $scripts = [
        base_url() . 'assets/js/jquery.min.js',
        base_url() . 'assets/js/sweetalert.min.js',
        base_url() . 'assets/js/main.js',
        base_url() . 'assets/js/tailwind.js',
        base_url() . 'assets/js/tailwindcss.js',
        base_url() . 'assets/js/landingpage.js',
        base_url() . 'assets/js/lucide.js'
    ];

    foreach ($scripts as $script) {
        echo '<script type="text/javascript" src="' . $script . '"></script>';
    }

}

function get_option($key)
{
    try {
        $pdo = db_connect();

        // Fetch the system JSON column
        $stmt = $pdo->prepare("SELECT system_details FROM system LIMIT 1");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['system_details'])) {
            // Decode JSON to array
            $details = json_decode($row['system_details'], true);

            // Return the requested key if it exists
            if (isset($details[$key])) {
                return $details[$key];
            }
        }

        return ''; // Key not found or no system data

    } catch (PDOException $e) {
        error_log("Database error in get_option(): " . $e->getMessage());
        return '';
    }
}



function get_unique_routes()
{
    try {
        $pdo = db_connect();
        // Fetch only distinct origin–destination pairs
        $stmt = $pdo->prepare("SELECT DISTINCT origin, destination FROM routes ORDER BY origin ASC, destination ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in get_unique_routes(): " . $e->getMessage());
        return [];
    }
}
