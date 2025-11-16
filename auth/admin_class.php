<?php
session_start();
/* require_once __DIR__ . '/../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 */

class Action
{
    private $db;

    public function __construct()
    {

        include 'config.php';

        if (!isset($pdo)) {
            die("Database not connected.");
        }
        $this->db = $pdo;
    }

    function __destruct()
    {
        $this->db = null;
    }


    /* function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        session_unset();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        return json_encode([
            'status' => 1,
            'redirect_url' => './index.php'
        ]);
    } */

    function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ✅ Capture user role before destroying the session
        $role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : 'student';

        // ✅ Clear all session data
        $_SESSION = [];
        session_unset();
        session_destroy();

        // ✅ Remove session cookie safely
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // ✅ Return structured JSON for frontend handling
        return json_encode([
            'status' => 1,
            'user_role' => $role,
            'message' => 'Logged out successfully.',
            'redirect_url' => '../../'
        ]);
    }

    function check_login()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!empty($_SESSION['admin'])) {
            return json_encode(['status' => 1, 'role' => 'admin', 'user_data' => $_SESSION['admin']]);
        } elseif (!empty($_SESSION['faculty'])) {
            return json_encode(['status' => 1, 'role' => 'faculty', 'user_data' => $_SESSION['faculty']]);
        } elseif (!empty($_SESSION['student'])) {
            return json_encode(['status' => 1, 'role' => 'student', 'user_data' => $_SESSION['student']]);
        } else {
            return json_encode(['status' => 0]);
        }
    }


    function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            return json_encode(['status' => 0, 'message' => 'Username and password are required.']);
        }

        try {
            // Admin login
            $stmt = $this->db->prepare("
            SELECT * FROM admin 
            WHERE JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.username')) = ? 
               OR JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.email')) = ? 
            LIMIT 1
        ");
            $stmt->execute([$username, $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $auth = json_decode($admin['authentication_data'], true);
                $per = json_decode($admin['personal_details'], true);
                if (password_verify($password, $auth['password'] ?? '')) {
                    $_SESSION['admin'] = [
                        'firstname' => $per['firstname'] ?? '',
                        'middlename' => $per['middlename'] ?? '',
                        'lastname' => $per['lastname'] ?? '',
                        'suffix' => $per['suffix'] ?? '',
                        'email' => $auth['email'] ?? '',
                        'username' => $auth['username'] ?? '',
                        'user_role' => $auth['user_role'] ?? '',
                        'admin_id' => $admin['admin_id'] ?? null,
                        'created_date' => $admin['created_date'] ?? '',
                        'profile_pic' => $per['admin_profile_pic'] ?? null  // <-- added profile pic
                    ];
                    return json_encode([
                        'status' => 1,
                        'message' => 'Admin login successful',
                        'redirect_url' => 'src/admin/index.php',
                        'user_data' => $_SESSION['admin']
                    ]);
                }
                return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
            }

            $stmt = $this->db->prepare("
            SELECT * FROM user 
            WHERE JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.username')) = ? 
            OR JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.email')) = ? 
            LIMIT 1
                ");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return json_encode(['status' => 0, 'message' => 'Incorrect username or password.']);
            }

            $auth = json_decode($user['authentication_data'], true);
            $person = json_decode($user['personal_details'], true);

            if (!password_verify($password, $auth['password'] ?? '')) {
                return json_encode(['status' => 0, 'message' => 'Incorrect username or password.']);
            }

            $role = strtolower($auth['user_role'] ?? '');
            $validRoles = ['faculty', 'student'];

            if (!in_array($role, $validRoles)) {
                return json_encode(['status' => 4, 'message' => 'User role not permitted.']);
            }

            // ✅ Common session data
            $sessionData = [
                'firstname' => $person['firstname'] ?? '',
                'middlename' => $person['middlename'] ?? '',
                'lastname' => $person['lastname'] ?? '',
                'suffix' => $person['suffix'] ?? '',
                'department' => $person['department'] ?? '',
                'email' => $auth['email'] ?? '',
                'username' => $auth['username'] ?? '',
                'user_role' => $role,
                'user_id' => $user['user_id'] ?? null,
                'created_date' => $user['created_date'] ?? '',
                'profile_pic' => $person['profile_pic'] ?? null
            ];

            // 🧠 Store session dynamically by role
            $_SESSION[$role] = $sessionData;

            // Determine redirect path
            $redirect = ($role === 'faculty') ? 'src/faculty/' : './';

            $_SESSION['user'] = [
                'role' => $role,
                'user_id' => $user['user_id'] ?? null
            ];

            return json_encode([
                'status' => 1,
                'message' => 'Login successful.',
                'redirect_url' => $redirect,
                'user_role' => $role,
                'user_id' => $user['user_id'] ?? null,
                'user_name' => trim(($person['firstname'] ?? '') . ' ' . ($person['lastname'] ?? '')),
                'user_data' => $sessionData
            ]);


        } catch (Exception $e) {
            return json_encode(['status' => 500, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
    function installation()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['system_details'], $input['admin_details'])) {
            return json_encode(['status' => 0, 'message' => 'Invalid input data.']);
        }

        $system = $input['system_details'];
        $admin = $input['admin_details'];

        // Validate required fields
        $required_system = ['system_title', 'system_description'];
        $required_admin = ['firstname', 'lastname', 'email', 'username', 'password'];

        foreach ($required_system as $field) {
            if (empty($system[$field]))
                return json_encode(['status' => 0, 'message' => "System field '$field' is required."]);
        }
        foreach ($required_admin as $field) {
            if (empty($admin[$field]))
                return json_encode(['status' => 0, 'message' => "Admin field '$field' is required."]);
        }

        // Handle system logo
        if (!empty($system['system_logo'])) {
            $system['system_logo'] = $this->saveBase64Image($system['system_logo'], 'logo_');
        }

        // Handle admin profile picture
        if (!empty($admin['admin_profile_pic'])) {
            $admin['admin_profile_pic'] = $this->saveBase64Image($admin['admin_profile_pic'], 'admin_');
        }

        // Hash password
        $admin['password'] = password_hash($admin['password'], PASSWORD_BCRYPT);

        try {
            $this->db->beginTransaction();

            // Insert admin
            $stmt1 = $this->db->prepare(
                "INSERT INTO admin (personal_details, authentication_data, admin_book_data) VALUES (?, ?, ?)"
            );
            $stmt1->execute([
                json_encode([
                    'firstname' => $admin['firstname'],
                    'middlename' => $admin['middlename'] ?? '',
                    'lastname' => $admin['lastname'],
                    'admin_profile_pic' => $admin['admin_profile_pic'] ?? ''
                ]),
                json_encode([
                    'username' => $admin['username'],
                    'password' => $admin['password'],
                    'user_role' => 'Admin',
                    'email' => $admin['email']
                ]),
                json_encode([]) // Empty admin_book_data
            ]);

            // Insert system
            $stmt2 = $this->db->prepare(
                "INSERT INTO system (system_details) VALUES (?)"
            );
            $stmt2->execute([
                json_encode($system)
            ]);

            $this->db->commit();
            return json_encode(['status' => 1, 'message' => 'Installation completed successfully.', 'url' => '../']);
        } catch (Exception $e) {
            $this->db->rollBack();
            return json_encode(['status' => 0, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    private function saveBase64Image($base64, $prefix)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $type))
            return '';
        $data = substr($base64, strpos($base64, ',') + 1);
        $data = base64_decode($data);
        if ($data === false)
            return '';

        $ext = strtolower($type[1]);
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
            return '';

        $upload_dir = '../assets/image/';
        if (!is_dir($upload_dir))
            mkdir($upload_dir, 0777, true);

        $filename = $prefix . uniqid() . '.' . $ext;
        file_put_contents($upload_dir . $filename, $data);
        return $filename;
    }



    /* function register_user()
    {
        $role = json_decode($_POST['role'], true);
        if (!isset($role['role'])) {
            return json_encode(['status' => 0, 'message' => 'User role is required']);
        }

        $role = strtolower($role['role']);
        if (!in_array($role, ['student', 'faculty'])) {
            return json_encode(['status' => 0, 'message' => 'Invalid role']);
        }

        // Common required fields
        $required = ['firstname', 'lastname', 'username', 'password', 'email', 'department'];
        foreach ($required as $f) {
            if (empty($_POST[$f])) {
                return json_encode(['status' => 0, 'message' => "Missing required field: $f"]);
            }
        }

        // Role-specific
        if ($role === 'student') {
            foreach (['course', 'year_level', 'section'] as $f) {
                if (empty($_POST[$f])) {
                    return json_encode(['status' => 0, 'message' => "Missing student field: $f"]);
                }
            }
        } else { // faculty
            if (empty($_POST['position'])) {
                return json_encode(['status' => 0, 'message' => "Missing faculty field: position"]);
            }
        }

        // Sanitize & gather inputs
        $data = array_map('trim', $_POST);
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

        // Handle file upload
        $uploadDir = __DIR__ . '/uploads/' . $role . '_profiles/';
        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0755, true);

        $profile_pic = 'assets/default-profile.png';
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
            $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
                return json_encode(['status' => 0, 'message' => 'Invalid image type']);
            }
            $filename = uniqid($role . '_') . '.' . $ext;
            $filepath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filepath)) {
                $profile_pic = 'uploads/' . $role . '_profiles/' . $filename;
            }
        }

        // Prepare DB JSON
        $personal_details = json_encode([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'middlename' => $data['middlename'] ?? '',
            'suffix' => $data['suffix'] ?? '',
            'department' => $data['department'],
            'birthdate' => $data['birthdate'] ?? null,
            'gender' => $data['gender'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'position' => $data['position'] ?? null,
            'course' => $data['course'] ?? null,
            'year_level' => $data['year_level'] ?? null,
            'section' => $data['section'] ?? null,
            'profile_pic' => $profile_pic
        ]);

        $auth_data = json_encode([
            'username' => $data['username'],
            'password' => $hashed_password,
            'user_role' => $role,
            'email' => $data['email']
        ]);

        try {
            $stmt = $this->db->prepare("INSERT INTO user (personal_details, authentication_data) VALUES (?, ?)");
            $stmt->execute([$personal_details, $auth_data]);
            return json_encode(['status' => 1, 'message' => ucfirst($role) . ' registered successfully']);
        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } */

    function register_user()
    {
        // Get raw JSON input from frontend
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            return json_encode(['status' => 0, 'message' => 'Invalid input data']);
        }

        // Validate role
        if (!isset($input['role'])) {
            return json_encode(['status' => 0, 'message' => 'User role is required']);
        }
        $role = strtolower($input['role']);
        if (!in_array($role, ['student', 'faculty'])) {
            return json_encode(['status' => 0, 'message' => 'Invalid role']);
        }

        // Common required fields
        $requiredFields = ['firstname', 'lastname', 'username', 'password', 'email', 'department', 'role'];
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                return json_encode(['status' => 0, 'message' => "Missing required field: $field"]);
            }
        }

        // Role-specific fields
        if ($role === 'student') {
            foreach (['student_id', 'section'] as $field) {
                if (empty($input[$field])) {
                    return json_encode(['status' => 0, 'message' => "Missing student field: $field"]);
                }
            }
        } else { // faculty
            if (empty($input['employee_id'])) {
                return json_encode(['status' => 0, 'message' => "Missing faculty field: employee_id"]);
            }
        }

        // Sanitize inputs
        $data = array_map('trim', $input);

        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

        // Handle profile pic (Base64)
        $profile_pic = 'assets/default-profile.png';
        if (!empty($data['profile_pic'])) {
            $uploadDir = __DIR__ . '/uploads/' . $role . '_profiles/';
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0755, true);

            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $data['profile_pic'], $type)) {
                $imgData = substr($data['profile_pic'], strpos($data['profile_pic'], ',') + 1);
                $imgData = base64_decode($imgData);
                $ext = strtolower($type[1]);
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return json_encode(['status' => 0, 'message' => 'Invalid image type']);
                }
                $filename = uniqid($role . '_') . '.' . $ext;
                $filepath = $uploadDir . $filename;
                if (file_put_contents($filepath, $imgData)) {
                    $profile_pic = 'uploads/' . $role . '_profiles/' . $filename;
                }
            }
        }

        // Prepare personal_details JSON
        $personal_details = json_encode([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'middlename' => $data['middlename'] ?? '',
            'suffix' => $data['suffix'] ?? '',
            'course' => $data['course'] ?? null,
            'department' => $data['department'],
            'student_id' => $data['student_id'] ?? null,
            'section' => $data['section'] ?? null,
            'employee_id' => $data['employee_id'] ?? null,
            'profile_pic' => $profile_pic
        ]);

        // Prepare authentication_data JSON
        $auth_data = json_encode([
            'username' => $data['username'],
            'password' => $hashed_password,
            'user_role' => $role,
            'email' => $data['email']
        ]);

        // Insert into database
        try {
            $stmt = $this->db->prepare("INSERT INTO user (personal_details, authentication_data) VALUES (?, ?)");
            $stmt->execute([$personal_details, $auth_data]);
            return json_encode(['status' => 1, 'message' => ucfirst($role) . ' registered successfully']);
        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }


    function readUserDetails()
    {
        try {
            // Fetch all faculty users
            $stmt = $this->db->prepare("
            SELECT 
                user_id,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.firstname')) AS firstname,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.lastname')) AS lastname,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.profile_pic')) AS profile_pic,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.department')) AS department,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.email')) AS email,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.user_role')) AS user_role,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.username')) AS username
            FROM user
            ORDER BY user_id DESC
        ");
            $stmt->execute();
            $faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 1,
                'data' => $faculties
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    function createFolder()
    {
        // Validate input
        $folderName = isset($_REQUEST['folder_name']) ? trim($_REQUEST['folder_name']) : null;
        if (!$folderName) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder name is required'
            ]);
        }

        // Sanitize folder name (allow letters, numbers, space, dash, underscore)
        $folderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $folderName);
        if (!$folderName) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder name contains invalid characters'
            ]);
        }

        // Define base path
        $baseDir = __DIR__ . '/files/';
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        $folderPath = $baseDir . $folderName;

        // Check if folder already exists
        if (file_exists($folderPath)) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder already exists'
            ]);
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM folder_structure WHERE folder_name = ?");
        $stmt->execute([$folderName]);
        if ($stmt->fetchColumn() > 0) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder already exists in database'
            ]);
        }

        // Create folder
        if (!mkdir($folderPath, 0777, true)) {
            return json_encode([
                'status' => 0,
                'message' => 'Failed to create folder'
            ]);
        }

        try {
            $sql = "INSERT INTO folder_structure (folder_name) VALUES (?)";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([$folderName])) {
                return json_encode([
                    'status' => 1,
                    'folder' => $folderName,
                    'message' => 'Folder created successfully'
                ]);
            }


        } catch (PDOException $e) {
            if (file_exists($folderPath)) {
                rmdir($folderPath);
            }
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    function getFolders()
    {

        $baseDir = __DIR__ . '/files/';

        // Make sure directory exists
        if (!is_dir($baseDir))
            mkdir($baseDir, 0777, true);

        $folders = [];

        foreach (scandir($baseDir) as $f) {
            if ($f === '.' || $f === '..')
                continue;

            $folderPath = $baseDir . $f;
            if (is_dir($folderPath)) {
                $files = [];
                foreach (scandir($folderPath) as $file) {
                    if ($file === '.' || $file === '..')
                        continue;
                    $files[] = $file;
                }
                $folders[] = ['name' => $f, 'files' => $files];
            }
        }

        return json_encode(['status' => 1, 'folders' => $folders]);
    }

    function deleteFolder()
    {
        // Get folder name from request
        $folderName = isset($_POST['folder_name']) ? trim($_POST['folder_name']) : null;

        if (!$folderName) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder name is required'
            ]);
        }

        // Sanitize folder name
        $folderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $folderName);

        $baseDir = __DIR__ . '/files/';
        $folderPath = $baseDir . $folderName;

        if (!is_dir($folderPath)) {
            return json_encode([
                'status' => 0,
                'message' => 'Folder does not exist'
            ]);
        }

        // Recursive delete function - safely remove directory and its contents
        $removeDir = function ($dir) use (&$removeDir) {
            if (!is_dir($dir)) {

            }
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    $removeDir($path);
                } else {
                    @unlink($path);
                }
            }
            @rmdir($dir);
        };

        $removeDir($folderPath);

        // Optional: log deletion in database with current timestamp
        try {
            $sql = "DELETE FROM folder_structure WHERE folder_name = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$folderName]);
            return json_encode([
                'status' => 1,
                'message' => "Folder '$folderName' deleted successfully"
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    function uploadFile()
    {
        // Suppress notices/warnings for clean JSON output
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        ob_start(); // start output buffering

        $baseDir = __DIR__ . '/files/';
        $folderName = $_POST['folder'] ?? null;

        if (!$folderName) {
            ob_clean();
            return json_encode(['status' => 0, 'message' => 'Folder name is required.']);

        }

        $safeFolderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $folderName);
        if (empty($safeFolderName)) {
            ob_clean();
            return json_encode(['status' => 0, 'message' => 'Invalid folder name.']);

        }

        $targetDir = $baseDir . $safeFolderName . '/';
        $coverDir = $targetDir . 'covers/';

        if (!is_dir($targetDir))
            mkdir($targetDir, 0777, true);
        if (!is_dir($coverDir))
            mkdir($coverDir, 0777, true);

        // Fetch existing folder metadata
        $stmtFolder = $this->db->prepare("SELECT folder_id, folder_data FROM folder_structure WHERE folder_name = ?");
        $stmtFolder->execute([$safeFolderName]);
        $folderData = $stmtFolder->fetch(PDO::FETCH_ASSOC);

        $folderId = $folderData['folder_id'] ?? null;
        $existingMetadata = [];
        if (!empty($folderData['folder_data'])) {
            $existingMetadata = json_decode($folderData['folder_data'], true);
            if (!is_array($existingMetadata))
                $existingMetadata = [];
        }

        $uploadedFiles = [];
        $uploadedCovers = [];

        // Random code generator
        $generateRandomCode = function ($length = 8): string {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
            return $code;
        };

        // === Upload files safely ===
        if (!empty($_FILES['files']['name'])) {
            foreach ($_FILES['files']['name'] as $i => $filename) {
                if (empty($filename) || ($_FILES['files']['error'][$i] ?? 1) !== UPLOAD_ERR_OK)
                    continue;

                $tmpName = $_FILES['files']['tmp_name'][$i] ?? '';
                if (!$tmpName)
                    continue;

                $ext = pathinfo($filename, PATHINFO_EXTENSION) ?: 'pdf';
                $newFileName = $generateRandomCode(12) . '.' . $ext;
                $destination = $targetDir . $newFileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $uploadedFiles[$filename] = $newFileName;
                }
            }
        }

        // === Upload covers safely ===
        if (!empty($_FILES['covers']['name'])) {
            foreach ($_FILES['covers']['name'] as $i => $filename) {
                if (empty($filename) || ($_FILES['covers']['error'][$i] ?? 1) !== UPLOAD_ERR_OK)
                    continue;

                $tmpName = $_FILES['covers']['tmp_name'][$i] ?? '';
                if (!$tmpName)
                    continue;

                $ext = pathinfo($filename, PATHINFO_EXTENSION) ?: 'png';
                $newCoverName = $generateRandomCode(8) . '.' . $ext;
                $destination = $coverDir . $newCoverName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $uploadedCovers[$filename] = $newCoverName;
                }
            }
        }

        // === Process metadata safely ===
        $newMetadata = [];
        if (!empty($_POST['metadata'])) {
            $metadataJson = $_POST['metadata'];
            $decodedMetadata = json_decode($metadataJson, true);
            if (is_array($decodedMetadata)) {
                foreach ($decodedMetadata as $meta) {
                    if (!is_array($meta))
                        continue;
                    $metaId = $generateRandomCode(12);
                    $originalFile = $meta['filename'] ?? '';
                    $meta['id'] = $metaId;
                    $meta['folder_id'] = $folderId;

                    if (!empty($originalFile) && isset($uploadedFiles[$originalFile])) {
                        $meta['filename'] = $uploadedFiles[$originalFile];
                        $meta['file_path'] = 'files/' . $safeFolderName . '/' . $uploadedFiles[$originalFile];
                    }

                    if (!empty($meta['cover']) && isset($uploadedCovers[$meta['cover']])) {
                        $coverKey = $meta['cover'];
                        $meta['cover'] = $uploadedCovers[$coverKey];
                        $meta['cover_path'] = 'files/' . $safeFolderName . '/covers/' . $uploadedCovers[$coverKey];
                    }

                    $newMetadata[] = $meta;
                }
            }
        }

        // Merge with existing metadata avoiding duplicates
        $existingFilenames = array_column($existingMetadata, 'filename');
        foreach ($newMetadata as $meta) {
            if (!empty($meta['filename']) && !in_array($meta['filename'], $existingFilenames)) {
                $existingMetadata[] = $meta;
            }
        }

        // Update database
        $stmtUpdate = $this->db->prepare("UPDATE folder_structure SET folder_data = ? WHERE folder_name = ?");
        $stmtUpdate->execute([json_encode($existingMetadata, JSON_UNESCAPED_UNICODE), $safeFolderName]);

        // Save metadata JSON file
        file_put_contents(
            $targetDir . 'metadata.json',
            json_encode($existingMetadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Clean any stray output and return JSON
        ob_clean();
        return json_encode([
            'status' => 1,
            'message' => 'Uploaded successfully',
            'folder_name' => $safeFolderName,
            'folder_id' => $folderId,
            'files' => $uploadedFiles,
            'covers' => $uploadedCovers,
            'metadata_count' => count($existingMetadata)
        ]);

    }




    function uploadFolder()
    {
        header('Content-Type: application/json'); // force JSON output
        ini_set('display_errors', 0); // suppress PHP warnings/notices

        $baseDir = __DIR__ . '/files/';
        $rootFolderName = $_POST['folder'] ?? null;

        if (!$rootFolderName) {
            ob_clean();
            return json_encode(['status' => 0, 'message' => 'Target folder name not provided.']);

        }

        $safeRootFolderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $rootFolderName);
        if (empty($safeRootFolderName)) {
            ob_clean();
            return json_encode(['status' => 0, 'message' => 'Invalid folder name after sanitization.']);

        }

        $targetDir = $baseDir . $safeRootFolderName . '/';
        $coverDir = $targetDir . 'covers/';

        if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true)) {
            ob_clean();
            return json_encode(['status' => 0, 'message' => 'Failed to create target folder.']);

        }

        if (!is_dir($coverDir)) {
            mkdir($coverDir, 0777, true);
        }

        $uploadedFiles = [];
        $uploadedCovers = [];

        $generateId = function ($length = 12): string {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $id = '';
            for ($i = 0; $i < $length; $i++) {
                $id .= $chars[random_int(0, strlen($chars) - 1)];
            }
            ob_clean();
            return $id;
        };

        // === Fetch existing folder or create new ===
        $stmt = $this->db->prepare("SELECT folder_id, folder_data FROM folder_structure WHERE folder_name = ?");
        $stmt->execute([$safeRootFolderName]);
        $folderData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($folderData) {
            $folderId = $folderData['folder_id'];
            $existingMetadata = json_decode($folderData['folder_data'], true) ?: [];
        } else {
            $this->db->prepare("INSERT INTO folder_structure (folder_name, folder_data) VALUES (?, ?)")
                ->execute([$safeRootFolderName, json_encode([], JSON_UNESCAPED_UNICODE)]);
            $folderId = $this->db->lastInsertId();
            $existingMetadata = [];
        }

        // === Upload main files ===
        if (!empty($_FILES['files']['name'][0])) {
            foreach ($_FILES['files']['name'] as $i => $name) {
                if (!isset($_FILES['files']['error'][$i]) || $_FILES['files']['error'][$i] !== UPLOAD_ERR_OK)
                    continue;

                $tmpName = $_FILES['files']['tmp_name'][$i];
                $ext = pathinfo($name, PATHINFO_EXTENSION) ?: 'pdf';
                $newFileName = $generateId() . '.' . $ext;
                $destination = $targetDir . $newFileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $uploadedFiles[$name] = $newFileName; // original → generated
                }
            }
        }

        // === Upload covers safely ===
        if (!empty($_FILES['covers']['name'])) {
            foreach ($_FILES['covers']['name'] as $i => $filename) {
                if (!isset($_FILES['covers']['error'][$i]) || $_FILES['covers']['error'][$i] !== UPLOAD_ERR_OK)
                    continue;

                $tmpName = $_FILES['covers']['tmp_name'][$i];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)) ?: 'png';
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                    continue;

                $newCoverName = $generateId(8) . '.' . $ext;
                $destination = $coverDir . $newCoverName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $uploadedCovers[$filename] = $newCoverName;
                }
            }
        }

        // === Handle metadata safely ===
        $newMetadata = [];
        if (!empty($_POST['metadata'])) {
            $decoded = json_decode($_POST['metadata'], true);
            if (is_array($decoded)) {
                foreach ($decoded as $meta) {
                    $metaId = $generateId();
                    $originalFile = $meta['filename'] ?? '';
                    $meta['id'] = $metaId;
                    $meta['folder_id'] = $folderId;
                    $meta['foldername'] = $safeRootFolderName;

                    // Safe file assignment
                    if (!empty($originalFile) && isset($uploadedFiles[$originalFile])) {
                        $meta['filename'] = $uploadedFiles[$originalFile];
                        $meta['file_path'] = 'files/' . $safeRootFolderName . '/' . $uploadedFiles[$originalFile];
                    } else {
                        $meta['filename'] = null;
                        $meta['file_path'] = null;
                    }

                    // Safe cover assignment
                    $coverFile = $meta['cover'] ?? '';
                    if (!empty($coverFile) && isset($uploadedCovers[$coverFile])) {
                        $meta['cover'] = $uploadedCovers[$coverFile];
                        $meta['cover_path'] = 'files/' . $safeRootFolderName . '/covers/' . $uploadedCovers[$coverFile];
                    } else {
                        $meta['cover'] = null;
                        $meta['cover_path'] = null;
                    }

                    $newMetadata[] = $meta;
                }
            }
        }

        // Merge with existing metadata safely
        $existingFilenames = array_column($existingMetadata, 'filename');
        foreach ($newMetadata as $meta) {
            if (!in_array($meta['filename'], $existingFilenames, true) && !empty($meta['filename'])) {
                $existingMetadata[] = $meta;
            }
        }

        // Update DB
        $stmtUpdate = $this->db->prepare("UPDATE folder_structure SET folder_data = ? WHERE folder_id = ?");
        $stmtUpdate->execute([json_encode($existingMetadata, JSON_UNESCAPED_UNICODE), $folderId]);

        // Save metadata JSON file
        file_put_contents(
            $targetDir . 'metadata.json',
            json_encode($existingMetadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
        ob_clean();
        return json_encode([
            'status' => 1,
            'message' => 'Folder Uploaded successfully',
            'folder_id' => $folderId,
            'folder_name' => $safeRootFolderName,
            'files_uploaded' => $uploadedFiles,
            'covers_uploaded' => $uploadedCovers,
            'total_books' => count($existingMetadata)
        ]);

    }







    function getMetadata()
    {
        $sql = "SELECT folder_name, folder_data FROM folder_structure";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $metadataArray = [];

        // Recursive function to traverse nested folder_data
        $traverseFiles = function ($files, $folderName) use (&$metadataArray, &$traverseFiles) {
            foreach ($files as $file) {
                if (isset($file['filename'])) {
                    $meta = $file['metadata'] ?? [];

                    // Book ID
                    $bookId = $file['id'] ?? 'NA';

                    // Title
                    $title = $meta['Title']
                        ?? ($meta['dc:title'] ?? null)
                        ?? ($meta['pdf:title'] ?? null)
                        ?? ($meta['title'] ?? null)
                        ?? pathinfo($file['filename'], PATHINFO_FILENAME);

                    // Author
                    $author = $meta['Author']
                        ?? ($meta['dc:creator'][0] ?? null)
                        ?? ($meta['pdf:author'] ?? null)
                        ?? ($meta['author'] ?? null)
                        ?? 'Unknown';

                    // ISBN
                    $isbn = '';
                    if (!empty($meta['prism:isbn'])) {
                        if (is_array($meta['prism:isbn'])) {
                            $isbn = $meta['prism:isbn']['ISBN'] ?? '';
                            $isbn = $meta['isbn'] ?? '';
                        } else {
                            $isbn = $meta['prism:isbn'];
                            $isbn = $meta['isbn'] ?? '';
                        }
                    }

                    $metadataArray[] = [
                        'book_id' => $bookId,
                        'foldername' => $folderName,
                        'filename' => $file['filename'], // actual file name
                        'title' => $title,
                        'author' => $author,
                        'isbn' => $isbn
                    ];
                }

                // Recurse for nested subfolders
                if (!empty($file['children']) && is_array($file['children'])) {
                    $traverseFiles($file['children'], $folderName);
                }
            }
        };

        foreach ($rows as $row) {
            $data = json_decode($row['folder_data'], true);
            if (!empty($data) && is_array($data)) {
                $traverseFiles($data, $row['folder_name']);
            }
        }

        return json_encode([
            'status' => 1,
            'data' => $metadataArray
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // View metadata
    function viewmeta()
    {
        $bookId = $_POST['book_id'] ?? '';
        if (!$bookId) {
            return json_encode(['status' => 0, 'message' => 'Book ID not provided']);
        }

        $sql = "SELECT folder_id, folder_name, folder_data FROM folder_structure";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $folderId = $row['folder_id'];
            $folderName = $row['folder_name'];
            $data = json_decode($row['folder_data'], true) ?? [];

            foreach ($data as $file) {
                if (!empty($file['id']) && $file['id'] === $bookId) {
                    $file['foldername'] = $folderName;
                    $file['folder_id'] = $folderId;
                    return json_encode([
                        'status' => 1,
                        'data' => $file
                    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
            }
        }

        return json_encode(['status' => 0, 'message' => 'Book not found']);
    }


    function editmeta()
    {
        $bookId = $_POST['book_id'] ?? '';
        $metadataJson = $_POST['metadata'] ?? '';

        if (!$bookId || empty($metadataJson)) {
            return json_encode(['status' => 0, 'message' => 'Invalid input']);
        }

        $newMetadata = json_decode($metadataJson, true);
        if (!is_array($newMetadata)) {
            return json_encode(['status' => 0, 'message' => 'Invalid metadata format']);
        }

        // Get all folders
        $sql = "SELECT folder_name, folder_data FROM folder_structure";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $folderName = $row['folder_name'];
            $data = json_decode($row['folder_data'], true) ?? [];
            $updated = false;

            foreach ($data as &$file) {
                if (!empty($file['id']) && $file['id'] === $bookId) {
                    // Update metadata
                    $file['metadata'] = array_merge($file['metadata'] ?? [], $newMetadata);
                    $updated = true;

                }
            }

            if ($updated) {
                // Save to database
                $updateSql = "UPDATE folder_structure SET folder_data = ? WHERE folder_name = ?";
                $stmtUpdate = $this->db->prepare($updateSql);
                $stmtUpdate->execute([json_encode($data, JSON_UNESCAPED_UNICODE), $folderName]);

                // Save to metadata.json
                $folderPath = __DIR__ . '/files/' . $folderName . '/metadata.json';
                file_put_contents($folderPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return json_encode(['status' => 1, 'message' => 'Metadata updated successfully']);
            }
        }

        return json_encode(['status' => 0, 'message' => 'Book not found']);
    }

    function deletemeta()
    {
        $bookId = $_POST['book_id'] ?? '';
        if (!$bookId) {
            return json_encode(['status' => 0, 'message' => 'Book ID not provided']);
        }

        $sql = "SELECT folder_id, folder_name, folder_data FROM folder_structure";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $folderId = $row['folder_id'];
            $folderName = $row['folder_name'];
            $data = json_decode($row['folder_data'], true) ?? [];
            $newData = [];
            $deleted = false;

            foreach ($data as $file) {
                if (!empty($file['id']) && $file['id'] === $bookId) {
                    // Delete the file from folder if it exists
                    $filePath = __DIR__ . '/files/' . $folderName . '/' . ($file['filename'] ?? '');
                    if (file_exists($filePath))
                        unlink($filePath);
                    $deleted = true;
                    continue; // skip adding this file to newData
                }
                $newData[] = $file;
            }

            if ($deleted) {
                // Update DB
                $updateSql = "UPDATE folder_structure SET folder_data = ? WHERE folder_id = ?";
                $stmtUpdate = $this->db->prepare($updateSql);
                $stmtUpdate->execute([json_encode($newData, JSON_UNESCAPED_UNICODE), $folderId]);

                // Update metadata.json
                $folderPath = __DIR__ . '/files/' . $folderName . '/metadata.json';
                file_put_contents($folderPath, json_encode($newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return json_encode(['status' => 1, 'message' => 'Book deleted successfully']);
            }
        }

        return json_encode(['status' => 0, 'message' => 'Book not found']);
    }

    public function searching()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $query = $_POST['q'] ?? '';
            $query = trim($query);

            if (!$query) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Search query not provided',
                    'data' => []
                ], JSON_UNESCAPED_UNICODE);

            }

            $results = [];

            // Fetch all folders
            $sql = "SELECT folder_id, folder_name, folder_data FROM folder_structure";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $folderId = $row['folder_id'];
                $folderName = $row['folder_name'];
                $data = json_decode($row['folder_data'], true) ?? [];

                foreach ($data as $file) {
                    $metadata = $file['metadata'] ?? [];

                    // Flatten searchable fields safely
                    $title = $metadata['dc:title'] ?? $metadata['Title'] ?? '';
                    if (is_array($title))
                        $title = implode(' ', $title);

                    $author = $metadata['dc:creator'] ?? $metadata['Author'] ?? '';
                    if (is_array($author))
                        $author = implode(', ', $author);

                    $isbn = $metadata['prism:isbn'] ?? '';
                    if (is_array($isbn))
                        $isbn = implode(' ', $isbn);

                    $doi = $metadata['xmp:identifier'] ?? $metadata['dc:identifier'] ?? '';
                    if (is_array($doi))
                        $doi = implode(' ', $doi);

                    $subject = $metadata['dc:subject'] ?? '';
                    if (is_array($subject))
                        $subject = implode(' ', $subject);

                    $category = $metadata['Custom']['EBX_PUBLISHER'] ?? '';
                    if (is_array($category))
                        $category = implode(' ', $category);

                    // Case-insensitive search
                    if (
                        stripos($title, $query) !== false ||
                        stripos($author, $query) !== false ||
                        stripos($isbn, $query) !== false ||
                        stripos($doi, $query) !== false ||
                        stripos($subject, $query) !== false ||
                        stripos($category, $query) !== false
                    ) {
                        $file['foldername'] = $folderName;
                        $file['folder_id'] = $folderId;
                        $results[] = $file;
                    }
                }
            }

            if (count($results) > 0) {
                return json_encode([
                    'status' => 1,
                    'message' => 'Results found',
                    'data' => $results
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                return json_encode([
                    'status' => 0,
                    'message' => 'No results found',
                    'data' => []
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Server error: ' . $e->getMessage(),
                'data' => []
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    function readingbooks()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $book_title = $_POST['book_title'] ?? 'Unknown Title';
        $book_author = $_POST['book_author'] ?? 'Unknown Author';
        $file = $_POST['file'] ?? null;
        if (!$file) {
            return json_encode([
                'status' => 0,
                'message' => 'Missing file parameter.'
            ]);
        }

        $user_id = $_SESSION['student']['user_id'] ?? null;
        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.',
                'session' => $_SESSION['student'] ?? null
            ]);
        }

        try {
            if (!isset($_SESSION['pdf_tokens'])) {
                $_SESSION['pdf_tokens'] = [];
            }

            $token = bin2hex(random_bytes(16));
            $_SESSION['pdf_tokens'][$token] = [
                'file' => $file,
                'book_title' => $book_title,
                'book_author' => $book_author,
                'created' => time(),
                'expires' => time() + 300
            ];

            // ✅ Check if the reading log exists
            $stmt = $this->db->prepare("SELECT id FROM reading_logs WHERE user_id = ? AND file = ?");
            $stmt->execute([$user_id, $file]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // ✅ Update existing reading session
                $update = $this->db->prepare("
                UPDATE reading_logs 
                SET start_time = NOW(), end_time = NULL, total_read_time = 0, updated_at = NOW()
                WHERE id = ?
            ");
                $update->execute([$row['id']]);
            } else {
                // ✅ Insert new reading session
                $insert = $this->db->prepare("
                INSERT INTO reading_logs (user_id, book_title, book_author, file, start_time, is_favorite) 
                VALUES (?, ?, ?, ?, NOW(), 0)
            ");
                $insert->execute([$user_id, $book_title, $book_author, $file]);
            }

            // ✅ Build secure viewer URL
            $baseURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/UniversityLibrary/";
            $secure_view_url = $baseURL . "auth/viewer.php?token=" . urlencode($token);

            return json_encode([
                'status' => 1,
                'user_id' => $user_id,
                'message' => 'Reading session started.',
                'data' => $secure_view_url
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function endReading()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $file = $_POST['file'] ?? null;
        $duration = (int) ($_POST['duration'] ?? 0);
        // $book_title = $_POST['book_title'] ?? 'Unknown Title';
        // $book_author = $_POST['book_author'] ?? 'Unknown Author';


        $user_id = $_SESSION['student']['user_id'] ?? null;
        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.'
            ]);
        }

        if (!$file) {
            return json_encode([
                'status' => 0,
                'message' => 'Missing file parameter.'
            ]);
        }

        try {
            // ✅ Find the active reading session
            $stmt = $this->db->prepare("SELECT id, total_read_time, start_time FROM reading_logs WHERE user_id = ? AND file = ? ORDER BY id DESC LIMIT 1");
            $stmt->execute([$user_id, $file]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$log) {
                return json_encode([
                    'status' => 0,
                    'message' => 'No active reading session found.'
                ]);
            }

            // ✅ Calculate total reading time (add to previous total)
            $new_total = $log['total_read_time'] + $duration;

            // ✅ Update the reading log
            $update = $this->db->prepare("
            UPDATE reading_logs 
            SET end_time = NOW(), duration = ?, total_read_time = ?, updated_at = NOW()
            WHERE id = ?
        ");
            $update->execute([$duration, $new_total, $log['id']]);

            return json_encode([
                'status' => 1,
                'message' => 'Reading session ended successfully.',
                'duration' => $duration,
                'total_read_time' => $new_total
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function toggleFavorite()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');
        $book_title = $_POST['book_title'] ?? 'Unknown Title';
        $book_author = $_POST['book_author'] ?? 'Unknown Author';

        $file = $_POST['file'] ?? null;
        $favorite = isset($_POST['favorite']) ? (int) $_POST['favorite'] : 0;
        $user_id = $_SESSION['student']['user_id'] ?? null;

        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.'
            ]);
        }

        if (!$file) {
            return json_encode([
                'status' => 0,
                'message' => 'Missing file parameter.'
            ]);
        }

        try {
            // ✅ Check if entry exists
            $stmt = $this->db->prepare("SELECT id FROM reading_logs WHERE user_id = ? AND file = ? LIMIT 1");
            $stmt->execute([$user_id, $file]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($log) {
                $update = $this->db->prepare("UPDATE reading_logs SET is_favorite = ?, SET 	book_title = ?, book_author = ?, updated_at = updated_at = NOW() WHERE id = ?");
                $update->execute([$favorite, $book_title, $book_author, $log['id']]);
            } else {
                $insert = $this->db->prepare("INSERT INTO reading_logs (user_id, book_title, book_author, file, is_favorite,  start_time) VALUES (?, ?, ?, ?, ?, NOW())");
                $insert->execute([$user_id, $book_title, $book_author, $file, $favorite]);
            }

            return json_encode([
                'status' => 1,
                'message' => $favorite ? 'Added to favorites.' : 'Removed from favorites.'
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }



    function get_favorite_books()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $user_id = $_SESSION['student']['user_id'] ?? $_SESSION['faculty']['user_id'] ?? null;
        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.'
            ]);

        }

        try {
            $baseURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/UniversityLibrary/";

            // Step 1: Get user's favorite reading logs
            $stmt = $this->db->prepare("
                SELECT * FROM reading_logs 
                WHERE user_id = ? AND is_favorite = 1
                ORDER BY updated_at DESC
            ");
            $stmt->execute([$user_id]);
            $readingLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            /* if (!$readingLogs) {
                return json_encode([
                    'status' => 1,
                    'message' => 'No favorite books found.',
                    'data' => []
                ]);
            } */

            $result = [];

            // Folder lookup
            $stmtFolder = $this->db->prepare("
                SELECT *
                FROM folder_structure
                WHERE JSON_CONTAINS(folder_data, JSON_OBJECT('filename', ?), '$')
            ");
            $folderRow = [];
            $title = 'Unknown';
            $author = 'Unknown';
            $cover_url = null;
            $folder_name = '';
            $file_name = '';
            foreach ($readingLogs as $log) {
                $log_file_name = pathinfo($log['file'], PATHINFO_BASENAME);

                $stmtFolder->execute([$log_file_name]);
                $folderRow = $stmtFolder->fetch(PDO::FETCH_ASSOC);


                if ($folderRow) {
                    $folderData = json_decode($folderRow['folder_data'], true) ?? [];
                    foreach ($folderData as $file) {
                        if (!is_array($folderData))
                            $folderData = [];
                        if (($file['filename'] ?? '') === $log_file_name) {
                            $metadata = $file['metadata'] ?? [];

                            // Title extraction
                            $title = $metadata['Title']
                                ?? ($metadata['dc:title'] ?? null)
                                ?? ($metadata['pdf:title'] ?? null)
                                ?? ($metadata['title'] ?? null)
                                ?? $title;

                            // Author extraction
                            $author = $metadata['Author']
                                ?? ($metadata['dc:creator'][0] ?? null)
                                ?? ($metadata['pdf:author'] ?? null)
                                ?? ($metadata['author'] ?? null)
                                ?? $author;

                            // Cover URL
                            if (!empty($file['cover'])) {
                                $cover_url = $baseURL . "auth/files/" . $folderRow['folder_name'] . "/covers/" . $file['cover'];
                            }

                            $folder_name = $folderRow['folder_name'];
                            break;
                        }
                    }
                }

                // Secure token setup (unchanged)
                if (!isset($_SESSION['pdf_tokens'])) {
                    $_SESSION['pdf_tokens'] = [];
                }
                $token = bin2hex(random_bytes(16));
                $_SESSION['pdf_tokens'][$token] = [
                    'title' => $title,
                    'author' => $author,
                    'file' => $baseURL . "auth/" . $log['file'],
                    'created' => time(),
                    'expires' => time() + 300
                ];

                $result[] = [
                    'file' => pathinfo($log['file'], PATHINFO_FILENAME),
                    'title' => $title,
                    'author' => $author,
                    'file_name' => $file_name,
                    'cover_url' => $cover_url,
                    'folder_name' => $folder_name,
                    'start_time' => $log['start_time'],
                    'updated_at' => $log['updated_at'],
                    'duration' => $log['duration'],
                    'file_url' => $log['file'],
                    'secure_view_url' => $baseURL . "auth/viewer.php?token=" . urlencode($token)
                ];
            }

            return json_encode([
                'status' => 1,
                'message' => 'Favorite books retrieved successfully.',
                'data' => $result
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }

    }


    function change_password()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $current = $_POST['current'] ?? '';
        $newPass = $_POST['newPass'] ?? '';

        // Identify session user
        $user = $_SESSION['student'] ?? $_SESSION['faculty'] ?? null;

        if (!$user || empty($user['user_id'])) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.'
            ]);

        }

        $user_id = $user['user_id'];

        try {
            // ✅ Fetch authentication data JSON
            $stmt = $this->db->prepare("SELECT authentication_data FROM user WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return json_encode([
                    'status' => 0,
                    'message' => 'User not found.'
                ]);

            }

            $auth = json_decode($row['authentication_data'], true);

            // ✅ Verify current password
            if (!isset($auth['password']) || !password_verify($current, $auth['password'])) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Current password is incorrect.'
                ]);

            }

            // ✅ Hash and update password in JSON
            $auth['password'] = password_hash($newPass, PASSWORD_DEFAULT);
            $newJson = json_encode($auth, JSON_UNESCAPED_UNICODE);

            $update = $this->db->prepare("UPDATE user SET authentication_data = ? WHERE user_id = ?");
            $update->execute([$newJson, $user_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Password updated successfully.'
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function setting()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $user = $_SESSION['student'] ?? $_SESSION['faculty'] ?? null;
        if (!$user || empty($user['user_id'])) {
            return json_encode(['status' => 0, 'message' => 'User not logged in.']);

        }

        $user_id = $user['user_id'];
        $role = $user['role'] ?? ($user['user_role'] ?? 'student');

        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $middlename = trim($_POST['middlename'] ?? '');
        $suffix = trim($_POST['suffix'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        try {
            // Fetch current data
            $stmt = $this->db->prepare("SELECT personal_details, authentication_data FROM user WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return json_encode(['status' => 0, 'message' => 'User not found.']);

            }

            $personal = json_decode($row['personal_details'], true) ?? [];
            $auth = json_decode($row['authentication_data'], true) ?? [];

            // Handle password change
            if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
                if (empty($auth['password']) || !password_verify($current_password, $auth['password'])) {
                    return json_encode(['status' => 0, 'message' => 'Current password is incorrect.']);

                }
                if ($new_password !== $confirm_password) {
                    return json_encode(['status' => 0, 'message' => 'New passwords do not match.']);

                }
                if (strlen($new_password) < 6) {
                    return json_encode(['status' => 0, 'message' => 'Password must be at least 6 characters long.']);

                }
                $auth['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }

            // Handle profile picture upload
            if (isset($_FILES['profile-upload']) && $_FILES['profile-upload']['error'] === 0) {
                $file = $_FILES['profile-upload'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($ext, $allowed)) {
                    return json_encode(['status' => 0, 'message' => 'Invalid image type.']);

                }

                $uploadDir = __DIR__ . '/uploads/' . ($role === 'faculty' ? 'faculty_profiles/' : 'student_profiles/');
                if (!is_dir($uploadDir))
                    mkdir($uploadDir, 0755, true);

                $filename = uniqid($role . '_') . '.' . $ext;
                $destPath = $uploadDir . $filename;

                if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                    return json_encode(['status' => 0, 'message' => 'Failed to upload profile picture.']);

                }

                // Delete old image if exists
                if (!empty($personal['profile_pic']) && file_exists(__DIR__ . '/' . $personal['profile_pic'])) {
                    @unlink(__DIR__ . '/' . $personal['profile_pic']);
                }

                $personal['profile_pic'] = 'uploads/' . ($role === 'faculty' ? 'faculty_profiles/' : 'student_profiles/') . $filename;
            }

            // Update personal details
            $personal['firstname'] = $firstname;
            $personal['lastname'] = $lastname;
            $personal['middlename'] = $middlename;
            $personal['suffix'] = $suffix;
            $personal['department'] = $department;
            $auth['email'] = $email;

            // Update database
            $update = $this->db->prepare("UPDATE user SET personal_details = ?, authentication_data = ? WHERE user_id = ?");
            $update->execute([
                json_encode($personal, JSON_UNESCAPED_UNICODE),
                json_encode($auth, JSON_UNESCAPED_UNICODE),
                $user_id
            ]);

            // Update session
            $updatedSession = $user;
            $updatedSession['firstname'] = $firstname;
            $updatedSession['lastname'] = $lastname;
            $updatedSession['middlename'] = $middlename;
            $updatedSession['suffix'] = $suffix;
            $updatedSession['department'] = $department;
            $updatedSession['email'] = $email;
            if (!empty($personal['profile_pic']))
                $updatedSession['profile_pic'] = $personal['profile_pic'];

            if ($role === 'faculty')
                $_SESSION['faculty'] = $updatedSession;
            else
                $_SESSION['student'] = $updatedSession;

            return json_encode([
                'status' => 1,
                'message' => 'Account updated successfully.',
                'new_image' => $updatedSession['profile_pic'] ?? null
            ]);

        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    function usercrude()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $action = $_POST['action'] ?? '';
        $user_id = $_POST['user_id'] ?? '';


        switch ($action) {
            case 'GetFaculty':
                try {
                    $stmt = $this->db->prepare("SELECT personal_details, authentication_data FROM user WHERE user_id = ?");
                    $stmt->execute([$user_id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$row) {
                        return json_encode(['status' => 0, 'message' => 'User not found.']);
                    }

                    $personal = json_decode($row['personal_details'], true) ?? [];
                    $auth = json_decode($row['authentication_data'], true) ?? [];

                    $data = array_merge($personal, $auth);

                    return json_encode(['status' => 1, 'data' => $data]);

                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
                }


            case 'GetUser':
                try {
                    $userId = $_POST['user_id'] ?? 0;
                    $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = ?");
                    $stmt->execute([$userId]);
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($data) {
                        return json_encode(['status' => 1, 'data' => $data]);
                    } else {
                        return json_encode(['status' => 0, 'message' => 'User not found']);
                    }
                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
                }
            case 'retrieveLogs':
                try {
                    $userId = $_POST['user_id'] ?? 0;
                    $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ?");
                    $stmt->execute([$userId]);
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($data) {
                        return json_encode(['status' => 1, 'data' => $data]);
                    } else {
                        return json_encode(['status' => 0, 'message' => 'User not found']);
                    }
                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
                }


            case 'UpdateUser':
                try {
                    $userId = $_POST['user_id'] ?? 0;
                    $firstname = trim($_POST['firstname'] ?? '');
                    $lastname = trim($_POST['lastname'] ?? '');
                    $email = trim($_POST['email'] ?? '');
                    $department = trim($_POST['department'] ?? '');

                    if (!$userId || !$firstname || !$lastname || !$email) {
                        return json_encode(['status' => 0, 'message' => 'Missing required fields.']);

                    }

                    $stmt = $this->db->prepare("UPDATE user SET firstname=?, lastname=?, email=?, department=? WHERE user_id=?");
                    $stmt->execute([$firstname, $lastname, $email, $department, $userId]);

                    return json_encode(['status' => 1, 'message' => 'User updated successfully.']);
                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Update failed: ' . $e->getMessage()]);
                }

            case 'recently_viewed':
                try {
                    $userId = $_POST['user_id'] ?? 0;

                    if (empty($userId) || !is_numeric($userId)) {
                        return json_encode([
                            'status' => 0,
                            'message' => 'Invalid user ID.'
                        ]);
                    }

                    $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ? ORDER BY updated_at DESC LIMIT 10");
                    $stmt->execute([$userId]);
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return json_encode([
                        'status' => 1,
                        'data' => $data
                    ]);
                } catch (PDOException $e) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Error retrieving logs: ' . $e->getMessage()
                    ]);
                }

            case 'DeleteUser':
                try {
                    $userId = $_POST['user_id'] ?? 0;

                    if (empty($userId) || !is_numeric($userId)) {
                        return json_encode([
                            'status' => 0,
                            'message' => 'Invalid user ID.'
                        ]);
                    }

                    $check = $this->db->prepare("SELECT user_id FROM user WHERE user_id = ?");
                    $check->execute([$userId]);

                    if ($check->rowCount() === 0) {
                        return json_encode([
                            'status' => 0,
                            'message' => 'User not found.'
                        ]);
                    }

                    // Delete user
                    $stmt = $this->db->prepare("DELETE FROM user WHERE user_id = ?");
                    $stmt->execute([$userId]);

                    return json_encode([

                        'status' => 1,
                        'message' => 'User deleted successfully.'
                    ]);
                } catch (PDOException $e) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Delete failed: ' . $e->getMessage()
                    ]);
                }

            default:
                return json_encode(['status' => 0, 'message' => 'Invalid action.']);

        }
    }













}
