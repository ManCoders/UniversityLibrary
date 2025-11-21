<?php

function db_connect()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'universitydb';

    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tableQueries = [

            // Librarian (Admin) Table
            "CREATE TABLE IF NOT EXISTS admin (
                admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                isLogined TINYINT(1) DEFAULT 0,
                personal_details JSON,
                authentication_data JSON,
                admin_book_data JSON,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS books (
                books_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                books_details JSON,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS user (
                user_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                isLogined TINYINT(1) DEFAULT 0,
                personal_details JSON,
                authentication_data JSON,
                user_book_data JSON,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS system (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                system_details JSON,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS folder_structure (
                folder_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                folder_name VARCHAR(50) NOT NULL,
                folder_data JSON,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
            ",
            "CREATE TABLE IF NOT EXISTS reading_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                file VARCHAR(255) NOT NULL,
                book_title VARCHAR(255) NOT NULL,
                book_author VARCHAR(255) NOT NULL,
                duration INT DEFAULT 0,
                is_favorite TINYINT(1) DEFAULT 0,
                start_time DATETIME NOT NULL,
                target_time INT DEFAULT 99999,
                end_time DATETIME DEFAULT NULL,
                total_read_time INT DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_readinglogs_user FOREIGN KEY (user_id) REFERENCES user(user_id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS user_logs (
                log_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                activity VARCHAR(255) NOT NULL,
                log_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_userlogs_user FOREIGN KEY (user_id) REFERENCES user(user_id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
            )"
        ];

        foreach ($tableQueries as $sql) {
            $pdo->exec($sql);
        }

        return $pdo;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Initialize database
$pdo = db_connect();
