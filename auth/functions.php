<?php
include "config.php";

$pdo = db_connect();

function initInstaller()
{
    $pdo = db_connect();

    try {
        // Check if admin exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE personal_details = ?");
        $stmt->execute(['Admin']);
        $adminCount = $stmt->fetchColumn();

        // Get clean current path
        $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $installerPath = '/installation';

        if ($adminCount > 0) {
            if (strpos($currentPath, $installerPath) === 0) {
                header("Location: " . base_url() . "src/");
                exit;
            }
        } elseif ($adminCount > 0) {
            /* OPTION BUT SOLID FOR SECURITY */
            if (strpos($currentPath, "/") === 0) {
                header("Location: " . base_url() . "src/");
                exit;
            }
        }
        else {
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

    // Local IPs for development
    $local_ips = ['127.0.0.1', '::1', '192.168.1.117'];

    // If running locally
    if (in_array($_SERVER['REMOTE_ADDR'], haystack: $local_ips)) {
        return $protocol . "://localhost/UNIVERSITYLIBRARY/";
    }

    // ✅ LIVE SITE PATH (InfinityFree)
    return $protocol . "://campus-chat-rooms.gamer.gd/UNIVERSITYLIBRARY/";
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
        base_url() . 'assets/css/all-tailwind-classes-full-min.css'
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
        base_url() . 'assets/js/landingpage.js'
    ];

    foreach ($scripts as $script) {
        echo '<script type="text/javascript" src="' . $script . '"></script>';
    }

}

function get_option($key)
{
    try {
        $pdo = db_connect();

        $stmt = $pdo->prepare("SELECT * FROM system ");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['' . $key . ''];
        }
        return '';

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
