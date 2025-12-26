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


    function base_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'] ?? 'zppsu-library.great-site.net'; // Detects local or live automatically

        return "$protocol://$host/UniversityLibrary/";
    }

    /* function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $base = $this->base_url();
        $role = null;
        $library_id = null;
        $table = null;
        $log_message = null;

        // Determine user role + IDs
        if (!empty($_SESSION['admin'])) {
            $role = 'admin';
            $table = 'admin';
            $library_id = $_SESSION['admin']['admin_id'] ?? null;
            $stmt = $this->db->prepare("UPDATE admin SET is_logged_in = 0, updated_date =NOW()  WHERE user_id =");
            $stmt->execute([$library_id]);
            $log_message = "Admin logged out successfully.";
        } elseif (!empty($_SESSION['faculty'])) {
            $role = 'faculty';
            $table = 'user';
            $library_id = $_SESSION['faculty']['user_id'] ?? null;
            $stmt = $this->db->prepare("UPDATE user SET is_logged_in = 0, updated_date =NOW()  WHERE user_id =");
            $stmt->execute([$library_id]);
            $log_message = "Faculty logged out successfully.";
        } elseif (!empty($_SESSION['student'])) {
            $role = 'student';
            $table = 'user';
            $library_id = $_SESSION['student']['user_id'] ?? null;
            $stmt = $this->db->prepare("UPDATE user SET is_logged_in = 0, updated_date =NOW()  WHERE user_id =");
            $stmt->execute([$library_id]);
            $log_message = "Student logged out successfully.";
        } else {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in',
                'redirect_url' => $base . 'index.php'
            ]);
        }

        // Mark user offline
        $stmt = $this->db->prepare("UPDATE {$table} SET is_logged_in = 0, SET updated_date = NOW() WHERE {$table}_id = ?");
        $stmt->execute([$library_id]);

        // Log activity
        $this->users_logs($log_message);

        // Destroy session + cookies
        $_SESSION = [];
        session_unset();
        session_destroy();

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
            'user_role' => $role,
            'message' => 'Logged out successfully.',
            'redirect_url' => $base . 'index.php'
        ]);
    } */




    function logout($auto = false)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $base = $this->base_url();
        $role = null;
        $library_id = null;
        $table = null;
        $log_message = null;
        $id_column = 'user_id';

        // Identify logged-in role
        if (!empty($_SESSION['admin'])) {
            $role = 'admin';
            $table = 'admin';
            $library_id = $_SESSION['admin']['admin_id'];
            $id_column = 'admin_id';
            $log_message = $auto ? "Admin auto-logged out due to inactivity." : "Admin logged out successfully.";

        } elseif (!empty($_SESSION['faculty'])) {
            $role = 'faculty';
            $table = 'user';
            $library_id = $_SESSION['faculty']['user_id'];
            $log_message = $auto ? "Faculty auto-logged out due to inactivity." : "Faculty logged out successfully.";

        } elseif (!empty($_SESSION['student'])) {
            $role = 'student';
            $table = 'user';
            $library_id = $_SESSION['student']['user_id'];
            $log_message = $auto ? "Student auto-logged out due to inactivity." : "Student logged out successfully.";

        } else {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in',
                'redirect_url' => $base . 'index.php'
            ]);
        }

        // Update login status
        $stmt = $this->db->prepare("
            UPDATE {$table} 
            SET is_logged_in = 0, updated_date = NOW() 
            WHERE {$id_column} = ?
        ");

        $stmt->execute([$library_id]);

        // Log action
        $this->users_logs($log_message);

        // Destroy session
        $_SESSION = [];
        session_unset();
        session_destroy();

        // Delete session cookie
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
            'auto' => $auto,
            'user_role' => $role,
            'message' => $auto ? 'Auto-logged out due to inactivity.' : 'Logged out successfully.',
            'redirect_url' => $base . 'index.php'
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

    function users_logs($logs = '')
    {
        $user_id = $_SESSION['student']['user_id'] ?? $_SESSION['faculty']['user_id'] ?? $_SESSION['admin']['admin_id'] ?? null;

        if (!$user_id || !$logs) {
            return json_encode([
                'status' => 0,
                'message' => 'User ID and logs are required'
            ]);
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO user_logs (user_id, activity) VALUES (?, ?)");
            $stmt->execute([$user_id, $logs]);

            $stmt = $this->db->prepare("UPDATE user SET is_logged_in = 1, updated_date =NOW()  WHERE user_id =");
            $stmt->execute([$user_id]);

            return json_encode([
                'status' => 1,
                'message' => 'User activity logged successfully',
                'data' => $logs
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id();
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
                    $stmt = $this->db->prepare("UPDATE admin SET is_logged_in = 1 WHERE admin_id = ?");
                    if ($stmt->execute([$admin['admin_id']])) {
                        $this->users_logs("Admin logged in successfully.");
                    }
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
            WHERE JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.library_id')) = ? 
                OR JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.email')) = ?
                OR JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.student_id')) = ?
                OR JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.employee_id')) = ?
            LIMIT 1
                ");
            $stmt->execute([$username, $username,$username,$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return json_encode(['status' => 0, 'message' => 'Incorrect username or password.']);
            }


            $auth = json_decode($user['authentication_data'], true);
            $person = json_decode($user['personal_details'], true);
            $accountStatus = strtolower($auth['account_status'] ?? '');

            if ($accountStatus !== 'approved') {
                switch ($accountStatus) {
                    case 'declined':
                        return json_encode([
                            'status' => 0,
                            'message' => 'Account has been declined.'
                        ]);
                    case 'pending':
                    default:
                        return json_encode([
                            'status' => 0,
                            'message' => 'Account is pending approval.'
                        ]);
                }
            }


            if (!password_verify($password, $auth['password'] ?? '')) {
                return json_encode(['status' => 0, 'message' => 'Incorrect username or password.']);
            }



            $role = strtolower($auth['user_role'] ?? '');
            $validRoles = ['faculty', 'student', 'admin', 'visitor'];

            if (!in_array($role, $validRoles)) {

                return json_encode(['status' => 4, 'message' => 'User role not permitted.']);
            }
            $completename = trim(($person['firstname'] ?? '') . (' ' . $person['middlename'][1] ?? '') . ' ' . ($person['lastname'] ?? ''));


            // ✅ Common session data
            $sessionData = [
                'completename' => $completename,
                'firstname' => $person['firstname'] ?? '',
                'middlename' => $person['middlename'] ?? '',
                'lastname' => $person['lastname'] ?? '',
                'suffix' => $person['suffix'] ?? '',
                'department' => $person['department'] ?? '',
                'email' => $auth['email'] ?? '',
                'username' => $auth['username'] ?? '',
                'library_id' => $person['library_id'] ?? null,
                'student_id' => $person['student_id'] ?? null,
                'section' => $person['section'] ?? null,
                'employee_id' => $person['employee_id'] ?? null,
                'course' => $person['course'] ?? null,
                'user_role' => $role,
                'user_id' => $user['user_id'] ?? null,
                'created_date' => $user['created_date'] ?? '',
                'profile_pic' => $person['profile_pic'] ?? null
            ];

            // 🧠 Store session dynamically by role
            $_SESSION[$role] = $sessionData;

            // Determine redirect path
            $redirect = ($role === 'faculty') ? 'src/faculty/index.php' : './';


            /* $_SESSION['user'] = [
                'role' => $role,
                'user_id' => $user['user_id'] ?? null
            ]; */
            $stmt = $this->db->prepare("UPDATE user SET is_logged_in = 1 WHERE user_id = ?");
            if ($stmt->execute([$user['user_id']])) {
                $this->users_logs("User logged in successfully.");
            }

            return json_encode([
                'status' => 1,
                'message' => 'Login successful.',
                'redirect_url' => $redirect,
                'user_role' => $role,
                'library_id' => $person['library_id'] ?? null,
                'student_id' => $person['student_id'] ?? null,
                'section' => $person['section'] ?? null,
                'employee_id' => $person['employee_id'] ?? null,
                'account_status' => $auth['account_status'] ?? null,
                'course' => $person['course'] ?? null,
                'department' => $person['department'] ?? null,
                'user_id' => $user['user_id'] ?? null,
                'user_name' => $completename,
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
                    'library_id' => 'admin-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
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


    function register_user()
{
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        return json_encode(['status' => 0, 'message' => 'Invalid input data']);
    }

    if (!isset($input['role'])) {
        return json_encode(['status' => 0, 'message' => 'User role is required']);
    }

    $role = strtolower($input['role']);
    $validRoles = ['student', 'faculty', 'visitor', 'admin_office'];

    if (!in_array($role, $validRoles)) {
        return json_encode(['status' => 0, 'message' => 'Invalid role']);
    }

    $data = array_map('trim', $input);

    // ===== COMMON REQUIRED FIELDS =====
    $requiredCommon = ['firstname', 'lastname', 'password', 'confirm_password', 'email'];
    foreach ($requiredCommon as $field) {
        if (empty($data[$field])) {
            return json_encode(['status' => 0, 'message' => "Missing required field: $field"]);
        }
    }

    // ===== ROLE-SPECIFIC VALIDATION =====
    switch ($role) {
        case 'student':
            $studentFields = ['student_id', 'student_gender', 'student_department', 'course'];
            foreach ($studentFields as $f) {
                if (empty($data[$f])) {
                    return json_encode(['status' => 0, 'message' => "Missing student field: $f"]);
                }
            }
            break;

        case 'faculty':
            $facultyFields = ['employee_id', 'faculty_gender', 'faculty_department'];
            foreach ($facultyFields as $f) {
                if (empty($data[$f])) {
                    return json_encode(['status' => 0, 'message' => "Missing faculty field: $f"]);
                }
            }
            break;

        case 'visitor':
            $visitorFields = ['visitor_gender', 'schoolname'];
            foreach ($visitorFields as $f) {
                if (empty($data[$f])) {
                    return json_encode(['status' => 0, 'message' => "Missing visitor field: $f"]);
                }
            }
            break;

        case 'admin_office':
            if (empty($data['admin_employee_id'])) {
                return json_encode(['status' => 0, 'message' => "Missing admin field: admin_employee_id"]);
            }
            break;
    }

    // ===== PASSWORD CHECK =====
    if ($data['password'] !== $data['confirm_password']) {
        return json_encode(['status' => 0, 'message' => 'Confirm password does not match']);
    }

    // ===== CHECK DUPLICATES =====
    try {
        // Check email duplication
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE JSON_EXTRACT(authentication_data, '$.email') = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetchColumn() > 0) {
            return json_encode(['status' => 0, 'message' => 'Email already registered']);
        }

        // Role-specific unique IDs
        if ($role === 'student') {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE JSON_EXTRACT(personal_details, '$.student_id') = ?");
            $stmt->execute([$data['student_id']]);
            if ($stmt->fetchColumn() > 0) {
                return json_encode(['status' => 0, 'message' => 'Student ID already registered']);
            }
        }

        if ($role === 'faculty' || $role === 'admin_office') {
            $uniqueId = $role === 'faculty' ? $data['employee_id'] : $data['admin_employee_id'];
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE JSON_EXTRACT(personal_details, '$.employee_id') = ?");
            $stmt->execute([$uniqueId]);
            if ($stmt->fetchColumn() > 0) {
                return json_encode(['status' => 0, 'message' => 'Employee ID already registered']);
            }
        }

        if ($role === 'visitor') {
            // For visitors, maybe combine name + schoolname as unique check
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE JSON_EXTRACT(personal_details, '$.firstname') = ? AND JSON_EXTRACT(personal_details, '$.lastname') = ? AND JSON_EXTRACT(personal_details, '$.schoolname') = ?");
            $stmt->execute([$data['firstname'], $data['lastname'], $data['schoolname']]);
            if ($stmt->fetchColumn() > 0) {
                return json_encode(['status' => 0, 'message' => 'Visitor already registered']);
            }
        }

    } catch (PDOException $e) {
        return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
    }

    $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

    // ===== HANDLE PROFILE PICTURE =====
    $profile_pic = 'assets/default-profile.png';
    if (!empty($data['profile_pic'])) {
        $uploadDir = __DIR__ . '/uploads/' . $role . '_profiles/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        if (preg_match('/^data:image\/(\w+);base64,/', $data['profile_pic'], $type)) {
            $imgData = base64_decode(substr($data['profile_pic'], strpos($data['profile_pic'], ',') + 1));
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

    $account_id = 'lib-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    $personal_details = [
        'library_id' => $account_id,
        'firstname' => $data['firstname'],
        'lastname' => $data['lastname'],
        'middlename' => $data['middlename'] ?? '',
        'suffix' => $data['suffix'] ?? '',
        'profile_pic' => $profile_pic,
    ];

    if ($role === 'student') {
        $personal_details['student_id'] = $data['student_id'];
        $personal_details['gender'] = $data['student_gender'];
        $personal_details['department'] = $data['student_department'];
        $personal_details['course'] = $data['course'];
    }
    if ($role === 'faculty') {
        $personal_details['employee_id'] = $data['employee_id'];
        $personal_details['gender'] = $data['faculty_gender'];
        $personal_details['department'] = $data['faculty_department'];
    }
    if ($role === 'visitor') {
        $personal_details['gender'] = $data['visitor_gender'];
        $personal_details['schoolname'] = $data['schoolname'];
    }
    if ($role === 'admin_office') {
        $personal_details['employee_id'] = $data['admin_employee_id'];
        $personal_details['admin_gender'] = $data['admin_gender'];
        $personal_details['admin_offices'] = $data['admin_offices'];
    }

    $auth_data = [
        'email' => $data['email'],
        'password' => $hashed_password,
        'account_role' => $role,
        'user_role' => in_array($role, ['visitor', 'student']) ? 'student' : 'faculty',
        'account_status' => 'Pending'
    ];

    try {
        $stmt = $this->db->prepare("INSERT INTO user (personal_details, authentication_data) VALUES (?, ?)");
        $stmt->execute([
            json_encode($personal_details),
            json_encode($auth_data)
        ]);
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
                *,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.firstname')) AS firstname,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.lastname')) AS lastname,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.middlename')) AS middlename,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.profile_pic')) AS profile_pic,
                JSON_UNQUOTE(JSON_EXTRACT(personal_details, '$.department')) AS department,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.email')) AS email,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.user_role')) AS user_role,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.username')) AS username,
                JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) AS account_status
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
            $this->users_logs("Folder '$folderName' created successfully.");
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

        // Ensure directory exists
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

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
                    $files[] = $file; // Collect file names
                }

                // Optional: fetch folder info from DB if needed
                $stmt = $this->db->prepare("SELECT folder_id, folder_data FROM folder_structure WHERE folder_name = ?");
                $stmt->execute([$f]); // Use folder name, not files array
                $folderData = $stmt->fetch(PDO::FETCH_ASSOC);

                $folders[] = [
                    'name' => $f,
                    'files' => $files,
                    'db_data' => $folderData ?? null
                ];
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
        $baseDir = __DIR__ . '/files/';

        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        $folderName = $_POST['folder'] ?? null;
        if (!$folderName) {

            return json_encode(['status' => 0, 'message' => 'Folder name is required.']);
        }

        $safeFolderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $folderName);
        if (empty($safeFolderName)) {

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



        // === Improved Duplicate Protection ===

        // Build quick-lookup arrays
        $existingFilenames = array_column($existingMetadata, 'filename');
        $existingTitles = array_map('strtolower', array_column($existingMetadata, 'title'));
        $existingCovers = array_column($existingMetadata, 'cover');

        foreach ($newMetadata as $meta) {
            $filename = $meta['filename'] ?? '';
            $title = strtolower($meta['title'] ?? '');
            $cover = $meta['cover'] ?? '';

            // Skip if filename already exists
            if (!empty($filename) && in_array($filename, $existingFilenames)) {
                continue;
            }

            // Skip if title already exists
            if (!empty($title) && in_array($title, $existingTitles)) {
                continue;
            }

            // Skip if cover already exists
            if (!empty($cover) && in_array($cover, $existingCovers)) {
                continue;
            }

            // If unique, add metadata
            $existingMetadata[] = $meta;

            // Update lookup arrays
            if (!empty($filename))
                $existingFilenames[] = $filename;
            if (!empty($title))
                $existingTitles[] = $title;
            if (!empty($cover))
                $existingCovers[] = $cover;
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
        header('Content-Type: application/json');

        $baseDir = __DIR__ . '/files/';
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        // --- Folder name ---
        $rootFolderName = $_POST['folder'] ?? $_POST['foldername'] ?? null;
        if (!$rootFolderName) {
            return json_encode(['status' => 0, 'message' => 'Target folder name not provided.']);
        }

        // Sanitize folder name
        $safeRootFolderName = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $rootFolderName);
        if (empty($safeRootFolderName)) {
            return json_encode(['status' => 0, 'message' => 'Invalid folder name after sanitization.']);
        }

        $targetDir = $baseDir . $safeRootFolderName . '/';
        $coverDir = $targetDir . 'covers/';

        // Create directories if not exist
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                return json_encode(['status' => 0, 'message' => 'Failed to create target folder.']);
            }
        }

        if (!is_dir($coverDir)) {
            mkdir($coverDir, 0777, true);
        }

        $uploadedFiles = [];
        $uploadedCovers = [];

        // ID generator
        $generateId = function ($length = 12): string {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $id = '';
            for ($i = 0; $i < $length; $i++) {
                $id .= $chars[random_int(0, strlen($chars) - 1)];
            }
            return $id;
        };

        // ==========================
        // Fetch folder info or create new
        // ==========================

        $stmt = $this->db->prepare("SELECT folder_id, folder_data FROM folder_structure WHERE folder_name = ?");
        $stmt->execute([$safeRootFolderName]);
        $folderData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($folderData) {
            $folderId = $folderData['folder_id'];
            $existingMetadata = json_decode($folderData['folder_data'], true) ?: [];
        } else {
            $this->db->prepare("INSERT INTO folder_structure (folder_name, folder_data) VALUES (?, ?)")
                ->execute([$safeRootFolderName, json_encode([])]);
            $folderId = $this->db->lastInsertId();
            $existingMetadata = [];
        }

        // ==========================
        // Upload main files
        // ==========================

        if (!empty($_FILES['files']['name'][0])) {
            foreach ($_FILES['files']['name'] as $i => $name) {

                if ($_FILES['files']['error'][$i] !== UPLOAD_ERR_OK)
                    continue;

                $tmp = $_FILES['files']['tmp_name'][$i];
                $ext = pathinfo($name, PATHINFO_EXTENSION) ?: 'pdf';

                $newName = $generateId() . '.' . $ext;
                $destination = $targetDir . $newName;

                if (move_uploaded_file($tmp, $destination)) {
                    $uploadedFiles[$name] = $newName;
                }
            }
        }

        // ==========================
        // Upload cover images
        // ==========================

        if (!empty($_FILES['covers']['name'])) {
            foreach ($_FILES['covers']['name'] as $i => $name) {

                if ($_FILES['covers']['error'][$i] !== UPLOAD_ERR_OK)
                    continue;

                $tmp = $_FILES['covers']['tmp_name'][$i];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                    continue;

                $newCoverName = $generateId(8) . '.' . $ext;
                $destination = $coverDir . $newCoverName;

                if (move_uploaded_file($tmp, $destination)) {
                    $uploadedCovers[$name] = $newCoverName;
                }
            }
        }

        // ==========================
        // Handle metadata processing
        // ==========================

        $newMetadata = [];

        if (!empty($_POST['metadata'])) {
            $metadata = json_decode($_POST['metadata'], true);

            if (is_array($metadata)) {
                foreach ($metadata as $meta) {

                    $id = $generateId();
                    $originalFile = $meta['filename'] ?? '';

                    $meta['id'] = $id;
                    $meta['folder_id'] = $folderId;
                    $meta['foldername'] = $safeRootFolderName;

                    // Assign file
                    if (!empty($originalFile) && isset($uploadedFiles[$originalFile])) {
                        $meta['filename'] = $uploadedFiles[$originalFile];
                        $meta['file_path'] = "files/$safeRootFolderName/" . $uploadedFiles[$originalFile];
                    } else {
                        $meta['filename'] = null;
                        $meta['file_path'] = null;
                    }

                    // Assign cover
                    $originalCover = $meta['cover'] ?? '';

                    if (!empty($originalCover) && isset($uploadedCovers[$originalCover])) {
                        $meta['cover'] = $uploadedCovers[$originalCover];
                        $meta['cover_path'] = "files/$safeRootFolderName/covers/" . $uploadedCovers[$originalCover];
                    } else {
                        $meta['cover'] = null;
                        $meta['cover_path'] = null;
                    }

                    $newMetadata[] = $meta;
                }
            }
        }

        // Prevent duplicate metadata entries
        // ============================================
        // Strong Duplicate Protection for Metadata
        // ============================================

        // Build quick-lookup indexes
        $existingFiles = array_column($existingMetadata, 'filename');
        $existingTitles = array_map('strtolower', array_column($existingMetadata, 'title'));
        $existingAuthors = array_map('strtolower', array_column($existingMetadata, 'author'));
        $existingCovers = array_column($existingMetadata, 'cover');

        // Avoid duplicates based on:
        // - filename
        // - title
        // - title + author combination
        // - cover image

        foreach ($newMetadata as $meta) {

            $filename = $meta['filename'] ?? '';
            $title = strtolower($meta['title'] ?? '');
            $author = strtolower($meta['author'] ?? '');
            $cover = $meta['cover'] ?? '';

            // Check duplicate by filename
            if (!empty($filename) && in_array($filename, $existingFiles)) {
                continue;
            }

            // Check duplicate by title
            if (!empty($title) && in_array($title, $existingTitles)) {
                continue;
            }

            // Check duplicate by title + author
            if (!empty($title) && !empty($author)) {
                foreach ($existingMetadata as $e) {
                    if (
                        strtolower($e['title'] ?? '') === $title &&
                        strtolower($e['author'] ?? '') === $author
                    ) {
                        continue 2; // skip this metadata
                    }
                }
            }

            // Check duplicate by cover filename
            if (!empty($cover) && in_array($cover, $existingCovers)) {
                continue;
            }

            // If we reach here → metadata is unique
            $existingMetadata[] = $meta;

            // Update lookup arrays dynamically
            if (!empty($filename))
                $existingFiles[] = $filename;
            if (!empty($title))
                $existingTitles[] = $title;
            if (!empty($author))
                $existingAuthors[] = $author;
            if (!empty($cover))
                $existingCovers[] = $cover;
        }


        // Save to database
        $this->db->prepare("UPDATE folder_structure SET folder_data = ? WHERE folder_id = ?")
            ->execute([json_encode($existingMetadata, JSON_UNESCAPED_UNICODE), $folderId]);

        // Save metadata JSON file
        file_put_contents(
            $targetDir . 'metadata.json',
            json_encode($existingMetadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Final response
        return json_encode([
            'status' => 1,
            'message' => 'Folder uploaded successfully.',
            'folder_id' => $folderId,
            'folder_name' => $safeRootFolderName,
            'files_uploaded' => $uploadedFiles,
            'covers_uploaded' => $uploadedCovers,
            'total_books' => count($existingMetadata)
        ]);
    }

    function getMetadata()
    {
        $sql = "SELECT * FROM folder_structure";
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

                    $isbn = '';

                    // Check for 'prism:isbn'
                    if (!empty($meta['prism:isbn'])) {
                        if (is_array($meta['prism:isbn'])) {
                            // If 'prism:isbn' is an array, try 'ISBN' key first
                            $isbn = $meta['prism:isbn']['ISBN'] ?? ($meta['isbn'] ?? '');
                        } else {
                            // If it's a string, directly use it, fallback to 'isbn'
                            $isbn = $meta['prism:isbn'] ?? ($meta['isbn'] ?? '');
                        }
                    }

                    // Fallback to 'isbn' field directly
                    if (empty($isbn)) {
                        $isbn = $meta['isbn'] ?? '';
                    }

                    // Further fallback to 'dc:identifier' or 'dc:source'
                    if (empty($isbn)) {
                        $isbn = $meta['dc:identifier'] ?? $meta['dc:source'] ?? '';
                    }

                    // If still empty, set a default value
                    if (empty($isbn)) {
                        $isbn = 'ISBN Not Available';
                    }

                    // Extract copyright / metadata date
                    $metadataDate = '';
                    if (!empty($meta['xmp:metadatadate'])) {
                        $metadataDate = $meta['xmp:metadatadate'];
                    } elseif (!empty($meta['xap:metadatadate'])) {
                        $metadataDate = $meta['xap:metadatadate'];
                    } elseif (!empty($meta['ModDate'])) {
                        $metadataDate = $meta['ModDate'];
                    } elseif (!empty($meta['CreationDate'])) {
                        $metadataDate = $meta['CreationDate'];
                    }

                    // Optionally format the date to YYYY-MM-DD
                    if ($metadataDate) {
                        $date = preg_replace('/^D:/', '', $metadataDate); // remove PDF D: prefix
                        $metadataDateFormatted = date('Y-m-d', strtotime($date));
                    } else {
                        $metadataDateFormatted = 'NA';
                    }

                    $sql = "SELECT * FROM reading_logs WHERE book_title = ? ";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([$title]);
                    $readinglog = $stmt->fetchAll(PDO::FETCH_ASSOC);



                    $metadataArray[] = [
                        'book_id' => $bookId,
                        'foldername' => $folderName,
                        'filename' => $file['filename'], // actual file name
                        'title' => $title,
                        'author' => $author,
                        'copyright' => $metadataDateFormatted,
                        'readinglog' => $readinglog,
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
            'data' => $metadataArray,
            'table' => $rows
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // View metadata
    function viewmeta()
    {
        $bookId = $_POST['book_id'] ?? $_GET['book_id'] ?? '';
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
        $this->users_logs("Attempting to delete book with ID: $bookId");
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
            $unique = []; // To track duplicates by ISBN + title + author

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

                    // Flatten searchable fields
                    $title = $metadata['dc:title'] ?? $metadata['title'] ??  $metadata['Title'] ?? '';
                    if (is_array($title))
                        $title = implode(' ', $title);

                    $author = $metadata['dc:creator'] ?? $metadata['Author'] ?? $metadata['author'] ?? '';
                    if (is_array($author))
                        $author = implode(', ', $author);

                    $isbn = $metadata['prism:isbn'] ?? $metadata['isbn'] ?? $metadata['Isbn'] ?? $metadata['ISBN'] ?? $metadata['dc:identifier'] ?? '';
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
                        // Unique key based only on ISBN + Title + Author
                        $uniqueKey = strtolower(
                            trim($isbn) . '|' . trim($title) . '|' . trim($author)
                        );

                        // Skip if already added
                        if (isset($unique[$uniqueKey])) {
                            continue;
                        }

                        // Mark as added
                        $unique[$uniqueKey] = true;

                        // Add result
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

        // Check for different user roles: student, faculty, and admin
        $user_role = '';
        $user_id = null;

        // Check for admin session
        if (!empty($_SESSION['admin'])) {
            $user_role = 'admin';
            $user_id = $_SESSION['admin']['admin_id'];  // Admin has admin_id
        }
        // Check for student session
        elseif (!empty($_SESSION['student'])) {
            $user_role = 'student';
            $user_id = $_SESSION['student']['user_id'];  // Student has user_id
        }
        // Check for faculty session
        elseif (!empty($_SESSION['faculty'])) {
            $user_role = 'faculty';
            $user_id = $_SESSION['faculty']['user_id'];  // Faculty has user_id
        }

        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.',
                'session' => $_SESSION ?? null
            ]);
        }

        try {
            // For session management: storing PDF tokens
            if (!isset($_SESSION['pdf_tokens'])) {
                $_SESSION['pdf_tokens'] = [];
            }

            $token = bin2hex(random_bytes(16));
            $_SESSION['pdf_tokens'][$token] = [
                'file' => $file,
                'book_title' => $book_title,
                'book_author' => $book_author,
                'created' => time(),
                'expires' => time() + 60 // Token valid for 10 seconds
            ];

            if ($user_role === 'student' || $user_role === 'faculty') {
                $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ? AND file = ?");
                $stmt->execute([$user_id, $file]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->users_logs("User Starting Reading book '$book_title' by '$book_author'");

                if ($row) {
                    // Update existing reading session
                    $update = $this->db->prepare("
                    UPDATE reading_logs 
                    SET start_time = NOW(), end_time = NULL, count_user = count_user + 1, access_count = access_count + 1, updated_at = NOW()
                    WHERE id = ?
                ");
                    $update->execute([$row['id']]);
                } else {
                    // Insert new reading session
                    $insert = $this->db->prepare("
                    INSERT INTO reading_logs (user_id, book_title, count_user, access_count, book_author, file, start_time, is_favorite) 
                    VALUES (?, ?, 1, 1, ?, ?, NOW(), 0)
                ");
                    $insert->execute([$user_id, $book_title, $book_author, $file]);
                }
            }

            // For admin, we skip the logging step but still generate a secure URL
            if ($user_role === 'admin') {
                // Build secure viewer URL for the admin
                $baseURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/UniversityLibrary/";
                $secure_view_url = $baseURL . "auth/viewer.php?token=" . urlencode($token);

                return json_encode([
                    'status' => 1,
                    'user_id' => $user_id,
                    'message' => 'Admin reading detected, no log recorded.',
                    'data' => $secure_view_url  // Return the secure view URL for the admin
                ]);
            }

            // Build secure viewer URL for the user
            $baseURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/UniversityLibrary/";
            $secure_view_url = $baseURL . "auth/viewer.php?token=" . urlencode($token);

            return json_encode([
                'status' => 1,
                'user_id' => $user_id,
                'role' => $user_role,
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

        // Check if the user is logged in (admin, student, faculty, etc.)
        $user_id = $_SESSION['student']['user_id'] ?? $_SESSION['faculty']['user_id'] ?? $_SESSION['admin']['admin_id'] ?? null;

        if (!$user_id) {
            return json_encode([
                'status' => 0,
                'message' => 'User not logged in.'
            ]);
        }

        // If the user is an admin, skip reading log updates.
        if (isset($_SESSION['admin']) && $_SESSION['admin']['admin_id']) {
            return json_encode([
                'status' => 1,
                'message' => 'Admin reading session does not require logging.'
            ]);
        }

        $this->users_logs("User ended the reading session, time: $duration seconds");

        if (!$file) {
            return json_encode([
                'status' => 0,
                'message' => 'Missing file parameter.'
            ]);
        }

        try {
            $stmt = $this->db->prepare("SELECT id, total_read_time, start_time FROM reading_logs WHERE user_id = ? AND file = ? ORDER BY id DESC LIMIT 1");
            $stmt->execute([$user_id, $file]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$log) {
                return json_encode([
                    'status' => 0,
                    'message' => 'No active reading session found.'
                ]);
            }

            $new_total_read_time = $log['total_read_time'] + $duration;

            // Update the reading log for non-admin users
            $update = $this->db->prepare("
            UPDATE reading_logs 
            SET end_time = NOW(), duration = ?, total_read_time = ?, access_count = 0, updated_at = NOW()
            WHERE id = ?
        ");
            $update->execute([$duration, $new_total_read_time, $log['id']]);

            return json_encode([
                'status' => 1,
                'message' => 'Reading session ended successfully.',
                'duration' => $duration,
                'total_read_time' => $new_total_read_time
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
            $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ? AND file = ? LIMIT 1");
            $stmt->execute([$user_id, $file]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);
            $book_title = $log['book_title'] ?? 'Unknown Title';
            $book_author = $log['book_author'] ?? 'Unknown Author';


            if ($log) {
                $update = $this->db->prepare("UPDATE reading_logs SET is_favorite = ?, updated_at = NOW() WHERE id = ?");
                $update->execute([$favorite, $log['id']]);
                $this->users_logs("User has " . ($favorite ? "added" : "removed") . " a favorite book titled: '$book_title' by '$book_author'");
            } else {
                $insert = $this->db->prepare("INSERT INTO reading_logs (user_id, file, is_favorite,  start_time) VALUES (?, ?, ?, NOW())");
                $insert->execute([$user_id, $file, $favorite]);
                $this->users_logs("User has " . ($favorite ? "added" : "removed") . " a favorite book titled: '$book_title' by '$book_author'");
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
            $book_id = '';
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
                            $book_id = $user_id;
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
                    'book_id' => $book_id,
                    'title' => $title,
                    'author' => $author,
                    'file' => $baseURL . "auth/" . $log['file'],
                    'created' => time(),
                    'expires' => time() + 300
                ];

                $result[] = [
                    'book_id' => $book_id,
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

    function GetStudentActivities()
    {
        try {
            $user_id = $_POST['user_id'] ?? $_GET['user_id'] ?? null; // accept POST or GET
            if (!$user_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'User ID not provided.'
                ]);
            }

            $stmt = $this->db->prepare("
            SELECT id, book_title, start_time, end_time, total_read_time, is_favorite
            FROM reading_logs
            WHERE user_id = ?
            ORDER BY updated_at DESC
            LIMIT 10
            ");


            $stmt->execute([$user_id]);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            function formatDuration($seconds)
            {
                if ($seconds < 60) {
                    return $seconds . ' sec';
                } elseif ($seconds < 3600) {
                    $minutes = floor($seconds / 60);
                    $secs = $seconds % 60;
                    return "{$minutes} min {$secs} sec";
                } else {
                    $hours = floor($seconds / 3600);
                    $minutes = floor(($seconds % 3600) / 60);
                    return "{$hours} hr {$minutes} min";
                }
            }
            $activities = array_map(function ($log) {

                return [
                    'id' => $log['id'],
                    'book_title' => $log['book_title'],
                    'start_time' => $log['start_time'],
                    'end_time' => $log['end_time'] ?? null,
                    'total_read_time' => formatDuration($log['total_read_time']),
                    'remark' => $log['is_favorite'] ? 'Favorited' : ''
                ];
            }, $logs);

            return json_encode([
                'status' => 1,
                'message' => 'Student activities retrieved successfully.',
                'data' => $activities
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
                    return json_encode(['status' => 0, 'message' => 'New password not match!']);
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

    function updatedetails()
    {

        try {

            $userId = $_POST['user_id'] ?? $_SESSION['student']['user_id'] ?? $_SESSION['faculty']['user_id'] ?? 0;
            if ($userId <= 0) {
                return json_encode(['status' => 0, 'message' => 'Invalid user ID.']);
            }

            // Fetch user
            $stmt = $this->db->prepare("SELECT personal_details, authentication_data FROM user WHERE user_id = ?");
            $stmt->execute([$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return json_encode(['status' => 0, 'message' => 'User not found.']);
            }

            $personal = json_decode($row['personal_details'], true) ?: [];
            $auth = json_decode($row['authentication_data'], true) ?: [];

            // Role used for folder placement
            $role = $_POST['role'] ?? ($auth['role'] ?? 'student');

            // Update personal fields
            $personal['firstname'] = $_POST['firstname'] ?? ($personal['firstname'] ?? '');
            $personal['lastname'] = $_POST['lastname'] ?? ($personal['lastname'] ?? '');
            $personal['middlename'] = $_POST['middlename'] ?? ($personal['middlename'] ?? '');
            $personal['suffix'] = $_POST['suffix'] ?? ($personal['suffix'] ?? '');
            $personal['course'] = $_POST['course'] ?? ($personal['course'] ?? '');
            $personal['department'] = $_POST['department'] ?? ($personal['department'] ?? '');

            // Handle profile picture
            if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === 0) {

                $file = $_FILES['profile_pic'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($ext, $allowed)) {
                    return json_encode(['status' => 0, 'message' => 'Invalid image type.']);
                }

                // Where to store
                $uploadDir = __DIR__ . '/uploads/' . ($role === 'faculty' ? 'faculty_profiles/' : 'student_profiles/');

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // New filename
                $filename = uniqid($role . '_') . '.' . $ext;
                $destPath = $uploadDir . $filename;

                if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                    return json_encode(['status' => 0, 'message' => 'Failed to upload profile picture.']);
                }

                // Delete old file if exists
                if (!empty($personal['profile_pic'])) {
                    $oldFullPath = __DIR__ . '/' . $personal['profile_pic'];
                    if (file_exists($oldFullPath)) {
                        @unlink($oldFullPath);
                    }
                }

                // Save relative path
                $personal['profile_pic'] = 'uploads/' . ($role === 'faculty' ? 'faculty_profiles/' : 'student_profiles/') . $filename;
            }

            // Update auth fields
            $auth['email'] = $_POST['email'] ?? ($auth['email'] ?? '');
            $auth['account_status'] = $_POST['account_status'] ?? ($auth['account_status'] ?? '');
            $auth['username'] = $_POST['username'] ?? ($auth['username'] ?? '');

            // Save JSON back to DB
            $stmt = $this->db->prepare("
                        UPDATE user 
                        SET personal_details = ?, authentication_data = ?
                        WHERE user_id = ?
                    ");

            $stmt->execute([
                json_encode($personal, JSON_UNESCAPED_UNICODE),
                json_encode($auth, JSON_UNESCAPED_UNICODE),
                $userId
            ]);

            $this->users_logs('User updated their details');
            return json_encode([
                'status' => 1,
                'message' => 'User updated successfully.',
                'data' => [
                    'personal' => $personal,
                    'auth' => $auth
                ]
            ]);
        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    function usercrude()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $action = $_POST['action'] ?? $_GET['action'];


        switch ($action) {
            case 'GetUser':
                try {
                    $userId = $_POST['user_id'] ?? $_GET['user_id'];

                    /* ===== USER + AGGREGATES ===== */
                    $stmt = $this->db->prepare("
                        SELECT 
                            u.user_id,
                            u.personal_details,
                            u.authentication_data,
                            u.created_date,

                            COUNT(DISTINCT rl.id) AS total_books_read,
                            COALESCE(SUM(rl.total_read_time), 0) AS total_read_time,
                            COUNT(DISTINCT ul.log_id) AS total_logs
                        FROM user u
                        LEFT JOIN reading_logs rl ON rl.user_id = u.user_id
                        LEFT JOIN user_logs ul ON ul.user_id = u.user_id
                        WHERE u.user_id = ?
                        GROUP BY u.user_id
                    ");
                    $stmt->execute([$userId]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$row) {
                        return json_encode([
                            'status' => 0,
                            'message' => 'User not found.'
                        ]);
                    }

                    $personal = json_decode($row['personal_details'], true) ?? [];
                    $auth = json_decode($row['authentication_data'], true) ?? [];

                    /* ===== ACTIVITY TIMELINE ===== */
                    $stmt = $this->db->prepare("
                            SELECT 
                                'reading' AS type,
                                rl.book_title,
                                rl.start_time,
                                rl.end_time,
                                rl.total_read_time,
                                rl.count_user,
                                rl.created_at AS activity_time
                            FROM reading_logs rl
                            WHERE rl.user_id = ?

                            UNION ALL

                            SELECT
                                'log' AS type,
                                ul.activity AS book_title,
                                ul.log_time AS start_time,
                                NULL AS end_time,
                                NULL AS end_time,
                                NULL AS total_read_time,
                                ul.log_time AS activity_time
                            FROM user_logs ul
                            WHERE ul.user_id = ?

                            ORDER BY activity_time DESC
                            LIMIT 100
                        ");
                    $stmt->execute([$userId, $userId]);
                    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    function formatDuration($seconds)
                    {
                        if ($seconds < 60) {
                            return $seconds . ' sec';
                        } elseif ($seconds < 3600) {
                            $minutes = floor($seconds / 60);
                            $secs = $seconds % 60;
                            return "{$minutes} min {$secs} sec";
                        } else {
                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);
                            return "{$hours} hr {$minutes} min";
                        }
                    }
                    /* ===== FINAL RESPONSE ===== */
                    return json_encode([
                        'status' => 1,
                        'user_id' => $row['user_id'],
                        'created_date' => $row['created_date'],
                        'stats' => [
                            'total_books_read' => (int) $row['total_books_read'],
                            'total_read_time' => formatDuration($row['total_read_time']),
                            'total_logs' => (int) $row['total_logs'],
                        ],
                        'data' => [
                            'personal' => $personal,
                            'auth' => $auth
                        ],
                        'activities' => $activities
                    ]);

                } catch (PDOException $e) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Database error: ' . $e->getMessage()
                    ]);
                }

            case 'UpdateUser':
                try {
                    $userId = $_POST['user_id'] ?? $_GET['user_id'];
                    $account_status = $_POST['account_status'] ?? $_GET['account_status'];

                    if (!$userId || !$account_status) {
                        return json_encode(['status' => 0, 'message' => 'User ID or account status missing']);

                    }

                    $stmt = $this->db->prepare(
                        "UPDATE user 
                            SET authentication_data = JSON_SET(authentication_data, '$.account_status', ?)
                            WHERE user_id = ?"
                    );
                    $stmt->execute([$account_status, $userId]);

                    if ($stmt->rowCount() > 0) {
                        return json_encode(['status' => 1, 'message' => "User status updated to $account_status"]);
                    } else {
                        return json_encode(['status' => 0, 'message' => 'No changes made or user not found']);
                    }

                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
                }

            case 'Approved':
                try {
                    $userId = $_POST['user_id'] ?? 0;

                    $stmt = $this->db->prepare(
                        "UPDATE user 
                            SET authentication_data = JSON_SET(authentication_data, '$.account_status', 'Approved') 
                            WHERE user_id = ?"
                    );
                    $stmt->execute([$userId]);

                    if ($stmt->rowCount() > 0) {
                        return json_encode(['status' => 1, 'message' => 'User approved successfully']);
                    } else {
                        return json_encode(['status' => 0, 'message' => 'User not found or already approved']);
                    }
                } catch (PDOException $e) {
                    return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
                }
            case 'Declined':
                try {
                    $userId = $_POST['user_id'] ?? 0;

                    $stmt = $this->db->prepare(
                        "UPDATE user 
                            SET authentication_data = JSON_SET(authentication_data, '$.account_status', 'Declined') 
                            WHERE user_id = ?"
                    );
                    $stmt->execute([$userId]);

                    if ($stmt->rowCount() > 0) {
                        return json_encode(['status' => 1, 'message' => 'User Declined successfully']);
                    } else {
                        return json_encode(['status' => 0, 'message' => 'User not found or already Declined']);
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
            case 'recently_viewed':
                try {
                    $userId = $_GET['user_id'] ?? 0;

                    if (empty($userId) || !is_numeric($userId)) {
                        return json_encode([
                            'status' => 0,
                            'message' => 'Invalid user ID.'
                        ]);
                    }

                    $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ?");
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

    function getDashboardStats()
    {
        try {
            // -------------------- Requests by Status --------------------
            $totals = [];
            $totals['pending'] = (int) $this->db
                ->query("SELECT COUNT(*) FROM user WHERE JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) = 'Pending'")
                ->fetchColumn();

            $totals['approved'] = (int) $this->db
                ->query("SELECT COUNT(*) FROM user WHERE JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) = 'Approved'")
                ->fetchColumn();

            $totals['declined'] = (int) $this->db
                ->query("SELECT COUNT(*) FROM user WHERE JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) = 'Declined'")
                ->fetchColumn();

            // -------------------- Active Users --------------------

            // Admin ID / user ID of current session (for validation)
            $user_id = $_SESSION['student']['user_id']
                ?? $_SESSION['faculty']['user_id']
                ?? $_SESSION['admin']['admin_id']
                ?? null;

            if (!isset($_SESSION['admin']) && !$user_id) {
                return json_encode(['status' => 0, 'message' => 'User not logged in']);
            }

            // Count online users (students + faculty)
            $stmtActiveUsers = $this->db->query("
                SELECT *
                FROM user
                WHERE is_logged_in = 1
                AND JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) = 'approved'
            ");
            $activeUsers = $stmtActiveUsers->fetchAll(PDO::FETCH_ASSOC);


            // Count online admins
            $stmtActiveAdmins = $this->db->query("
                    SELECT *
                    FROM admin
                    WHERE is_logged_in = 1
                ");
            $activeAdmins = $stmtActiveAdmins->fetchAll(PDO::FETCH_ASSOC);


            // Total active users including admins
            $totalActiveUsers = array_merge($activeUsers, $activeAdmins);
            // $totalActiveUsers = $activeUsers + $activeAdmins;

            // Count offline users (students + faculty)
            $stmtOfflineUsers = $this->db->query("
                SELECT *
                FROM user
                WHERE is_logged_in = 0
                AND JSON_UNQUOTE(JSON_EXTRACT(authentication_data, '$.account_status')) = 'approved'
            ");
            $offlineUsers = $stmtOfflineUsers->fetchAll(PDO::FETCH_ASSOC);


            // Count offline admins
            $stmtOfflineAdmins = $this->db->query("
                SELECT *
                FROM admin
                WHERE is_logged_in = 0
            ");
            $offlineAdmins = $stmtOfflineAdmins->fetchAll(PDO::FETCH_ASSOC);

            // Total offline users including admins
            // $totalOfflineUsers = $offlineUsers + $offlineAdmins;
            $totalOfflineUsers = array_merge($offlineUsers, $offlineAdmins);
            // -------------------- Recent Activity --------------------
            $stmt = $this->db->query("
            SELECT activity AS message, DATE_FORMAT(log_time, '%Y-%m-%d %H:%i') AS time 
            FROM user_logs 
            ORDER BY log_time DESC 
            LIMIT 10
            ");
            $recentActivity = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // -------------------- Folder Department Activity --------------------

            $stmt = $this->db->query("
                SELECT folder_id, folder_name, folder_data, created_date
                FROM folder_structure
                ORDER BY created_date DESC
            ");

            $departments = [];
            $books = [];
            $filesInFolders = [];
            $totalBooks = 0;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $departments[] = $row;

                // Decode folder_data JSON

                $folderJson = isset($row['folder_data']) ? json_decode($row['folder_data'], true) : [];

                // Count books
                $bookCount = isset($folderJson['foldername']) ? count($folderJson['foldername']) : 0;
                $books[$row['folder_name']] = $folderJson;

                $totalBooks += $bookCount;

                // Extract filenames
                $files = isset($folderJson['filename']) ? $folderJson['filename'] : [];
                $filesInFolders[$row['folder_data']] = $files;
            }

            $totalFolders = count($departments);
            $folderNames = array_map(fn($d) => $d['folder_name'], $departments);



            $stmt = $this->db->prepare("
                    SELECT *
                    FROM user
                    ORDER BY created_date ASC
                ");
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 1,
                'stats' => [
                    'users' => $users,
                    'booksperfolder' => $books,
                    'filesperfolder' => $filesInFolders,
                    'totalBooks' => $totalBooks,
                    'totalDepartment' => $totalFolders,
                    'department' => $departments,
                    'folder_names' => $folderNames,
                    'requests' => $totals,
                    'online_users' => $totalActiveUsers,
                    'offline_users' => $totalOfflineUsers,
                    'online' => count($totalActiveUsers),
                    'offline' => count($totalOfflineUsers),
                    'totalusers' => count($totalActiveUsers) + count($totalOfflineUsers)
                ],
                'recent' => $recentActivity
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }


    function remove_favorite()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header('Content-Type: application/json');

        $file = $_POST['file'] ?? null;
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
            $stmt = $this->db->prepare("SELECT * FROM reading_logs WHERE user_id = ? AND book_title = ? LIMIT 1");
            $stmt->execute([$user_id, $file]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($log) {
                $update = $this->db->prepare("UPDATE reading_logs SET is_favorite = 0, updated_at = NOW() WHERE id = ?");
                $update->execute([$log['id']]);
            }

            return json_encode([
                'status' => 1,
                'message' => 'Removed from favorites.'
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function get_activity_log()
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
            $stmt = $this->db->prepare("
                SELECT * FROM user_logs 
                WHERE user_id = ?
                ORDER BY log_time DESC
            ");
            $stmt->execute([$user_id]);
            $readingLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($readingLogs) {
                return json_encode([
                    'status' => 1,
                    'message' => 'Activity log retrieved successfully.',
                    'data' => $readingLogs
                ]);
            } else {
                return json_encode([
                    'status' => 1,
                    'message' => 'No activity found.',
                    'data' => []
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function update_profile()
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

        $firstname = $_POST['firstname'] ?? '';
        $middlename = $_POST['middlename'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $suffix = $_POST['suffix'] ?? '';
        $department = $_POST['department'] ?? '';
        $email = $_POST['email'] ?? '';

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
            // Handle profile picture upload
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/' . $role . '_profiles/';
                if (!is_dir($uploadDir))
                    mkdir($uploadDir, 0755, true);

                $fileTmp = $_FILES['profile_pic']['tmp_name'];
                $fileExt = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($fileExt, $allowed)) {
                    return json_encode(['status' => 0, 'message' => 'Invalid image type.']);
                }

                $filename = uniqid($role . '_') . '.' . $fileExt;
                $filepath = $uploadDir . $filename;
                if (move_uploaded_file($fileTmp, $filepath)) {
                    $profile_pic = 'uploads/' . $role . '_profiles/' . $filename;
                }
            }

            // Update personal details
            $personal['firstname'] = $firstname;
            $personal['middlename'] = $middlename;
            $personal['lastname'] = $lastname;
            $personal['suffix'] = $suffix;
            $personal['department'] = $department;
            $personal['profile_pic'] = $profile_pic;
            $auth['email'] = $email;

            // Update database (fixed: removed extra comma before WHERE)
            $update = $this->db->prepare("UPDATE user SET personal_details = ?, authentication_data = ? WHERE user_id = ?");
            $update->execute([
                json_encode($personal, JSON_UNESCAPED_UNICODE),
                json_encode($auth, JSON_UNESCAPED_UNICODE),
                $user_id
            ]);

            // Update session
            $updatedSession = $user;
            $updatedSession['firstname'] = $firstname;
            $updatedSession['middlename'] = $middlename;
            $updatedSession['lastname'] = $lastname;
            $updatedSession['suffix'] = $suffix;
            $updatedSession['department'] = $department;
            $updatedSession['email'] = $email;
            $updatedSession['profile_pic'] = $profile_pic;

            if ($role === 'faculty') {
                $_SESSION['faculty'] = $updatedSession;
            } else {
                $_SESSION['student'] = $updatedSession;
            }

            return json_encode([
                'status' => 1,
                'message' => 'Profile updated successfully.',
                'data' => [
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'suffix' => $suffix,
                    'department' => $department,
                    'email' => $email,
                    'role' => $role,
                    'profile_pic' => $profile_pic
                ]
            ]);
        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }


    function chatSupportAI()
    {
        try {
            ini_set('max_execution_time', 15); // Enough time for API

            // --- Input Validation ---
            $userMsg = trim($_POST['message'] ?? '');
            if (empty($userMsg)) {
                return json_encode([
                    'status' => 0,
                    'reply' => 'Please enter a message.'
                ]);
            }

           // Fetch admin_book_data
            $stmt = $this->db->query("SELECT admin_book_data FROM admin");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Decode JSON
            $data = $row ? json_decode($row['admin_book_data'], true) : [];

            // Get API key
            $apiKey = $data['api'] ?? null;
            
            $model = 'gemini-2.5-flash';
            $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

            // --- Librarian assistant system prompt ---
            $booksMetadata = [];

            $stmt = $this->db->query("SELECT folder_id, folder_name, folder_data, created_date FROM folder_structure ORDER BY created_date DESC");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $folderData = json_decode($row['folder_data'], true);

                if (is_array($folderData)) {
                    foreach ($folderData as $book) {
                        $booksMetadata[] = $book;
                    }
                }
            }

            // Prepare JSON for AI system prompt
            $booksJSON = json_encode($booksMetadata, JSON_UNESCAPED_UNICODE);

            // Define AI system prompt with metadata access
            $systemPrompt = "
                You are a professional and polite Zamboanga Peninsula Polytechnic State University digital librarian assistant. 
                Your goal is to help users explore the library and the research journey, recommend books, authors, or topics, and guide users in finding reliable information online.
                make it short the responce only the important matters.
                You have secure access to the following books metadata:

                $booksJSON
                Rules:
                - Only use the provided library metadata for direct book references (Title, Author, ISBN).
                - Suggest online resources, journals, or reading guidance when relevant.
                - Never reveal user credentials, personal information, or internal system data.
                - Keep responses concise, clear, and appropriate for professors, teachers, students, or academic researchers.
                - If a book or resource is not found, respond politely: 'No matching book found in the library database.'
                - Encourage exploration, learning, and research while keeping guidance professional and short.
                    You are DLORAS Assistant.

                    If a guest asks for your name, respond:
                    “My name is DLORAS Assistant.”

                    If a guest asks who created, developed, or made you, respond proudly:
                    “I was created and developed by Manuel Daligdig in 2025.”

                    If a guest asks about your creator or developer in general, you respond:
                    My creator is among the best in the world, and I was built with pride and purpose.

                Library Assistant Guidelines:

                    Only reference books using the library’s metadata: Title, Author, ISBN.

                    Suggest credible online resources, journals, or reading guidance when appropriate.

                    Never reveal user credentials, personal information, or internal system data.

                    Never reveal list of books if not ask.

                    Keep all responses concise, clear, and professional, suitable for professors, students, and academic researchers.

                    If a book or resource is not found, respond politely:
                    `No matching book found in the library database.`

                    Encourage exploration, learning, and research, maintaining a professional tone.

                    Maintain neutrality; do not express personal opinions about authors or publications.

                    Ensure recommendations are relevant to the query or topic.
                                        
                    Do not link to unofficial, non-academic, or unsafe sources.

                    Use formal academic language, accessible to all users.

                    Avoid repeating information in the same response.

                    Suggest alternative resources if the exact book is unavailable.

                    Prioritize clarity, correctness, and accessibility over exhaustive detail.

                    Support academic integrity and responsible research practices.

                    Responses must be suitable for all knowledge levels, from beginners to advanced users.

                    Always stay within the scope of academic guidance; never speculate or provide unverified information.

                    Encourage critical thinking and responsible use of resources.

                    Responses should be safe, professional, and appropriate for a university or research environment.       

                User Types You Will Assist:
                - Professors
                - Teachers
                - Students
                - Academic researchers
                - Other educational or research professionals

                Guidelines for interaction:

                1. If a user asks if there are available books, respond with a concise list in the format: 'Title - Author' and 5-10 items only.
                2. If a user provides an ISBN, search the metadata and return only the matching book's Title and Author.
                3. Tailor your responses politely based on the user type, keeping them appropriate for an academic or research context.
                4. Never expose folder IDs, internal metadata, timestamps, or any sensitive system information to users.
                5. Keep all responses concise, clear, and professional.
                6. Handle user queries politely, including requests for book recommendations, authors, or research topics.
                7. Do not guess or fabricate book data; only use the metadata you have access to.
                8. If a book is not found, respond politely with: 'No matching book found in the library database.'
                9. If user credentials or any personal not related in the books responce 
                10. if user give a details don't give directly details or information if they are not ask for help.
                

                Important Security Rules:
                - Do not access or disclose any user credentials, emails, session info, or any personal data.
                - Only answer based on the provided books metadata.
                - Responses should include only 'Title - Author' or 'Title - Author - ISBN' if specifically requested.
                - 
                Your goal is to provide quick, accurate, context-aware, and secure assistance to users regarding the library's collection.
                ";


            // --- Payload ---
            $data = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $systemPrompt],
                            ["text" => $userMsg]
                        ]
                    ]
                ],
                "generationConfig" => [
                    "temperature" => 2.0,        // Slightly conservative for factual answers
                    "maxOutputTokens" => 7000,
                    "topP" => 0.95,              // Limit randomness
                    "topK" => 40
                ]
            ];

            // --- cURL Request ---
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_TIMEOUT => 60
            ]);

            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                unset($ch);
                return json_encode([
                    'status' => 0,
                    'reply' => 'Connection Error: ' . $error_msg
                ]);
            }
            unset($ch);

            // --- Parse Response ---
            $res = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return json_encode([
                    'status' => 0,
                    'reply' => 'Invalid JSON response from AI.'
                ]);
            }

            if (isset($res['error'])) {
                return json_encode([
                    'status' => 0,
                    'reply' => 'API Error: ' . ($res['error']['message'] ?? 'Unknown error')
                ]);
            }

            // --- Extract AI Reply ---
            $replyText = $res['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated.';

            // --- Post-processing ---
            $replyText = trim($replyText);                  // Remove extra whitespace
            $replyText = preg_replace('/\s+/', ' ', $replyText); // Single spaces

            return json_encode([
                'status' => 1,
                'reply' => $replyText
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'reply' => 'Server Exception: ' . $e->getMessage()
            ]);
        }
    }


    function getAnalyticsStats()
    {
        $response = [
            "status" => false,
            "data" => []
        ];

        try {
            // ========== UTILIZATION: Top 5 most accessed books ==========
            $q1 = $this->db->query("
                SELECT 
                    book_title, 
                    SUM(count_user) AS total_access
                FROM reading_logs
                GROUP BY book_title
                ORDER BY total_access DESC
                LIMIT 5
            ");

            $utilLabels = [];
            $utilValues = [];

            while ($row = $q1->fetch(PDO::FETCH_ASSOC)) {
                $utilLabels[] = $row['book_title'];
                $utilValues[] = (int) $row['total_access'];
            }


            // ========== USERS: Top 5 users by ebook access ==========
            $q2 = $this->db->query("
                SELECT 
                    JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.firstname')) AS firstname,
                    JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.lastname')) AS lastname,
                    JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.middlename')) AS middlename,
                    SUM(r.access_count) AS total_access
                FROM reading_logs r
                JOIN user u ON u.user_id = r.user_id
                GROUP BY r.user_id
                ORDER BY total_access DESC
                LIMIT 5
            ");

            $userLabels = [];
            $userValues = [];

            while ($row = $q2->fetch(PDO::FETCH_ASSOC)) {
                $fullname = trim($row['firstname'] . ' ' . ($row['middlename'] ?? '') . ' ' . $row['lastname']);
                $userLabels[] = $fullname;
                $userValues[] = (int) $row['total_access'];
            }


            // ========== RESOURCES: Count accessed vs not accessed ==========
            $q3 = $this->db->query("
                SELECT
                    SUM(CASE WHEN access_count > 0 THEN 1 ELSE 0 END) AS accessed,
                    SUM(CASE WHEN access_count = 0 THEN 1 ELSE 0 END) AS not_accessed
                FROM reading_logs
            ");

            $resLabels = ['Access', 'Not Access'];
            $resValues = [];

            if ($row = $q3->fetch(PDO::FETCH_ASSOC)) {
                $resValues[] = (int) $row['accessed'];
                $resValues[] = (int) $row['not_accessed'];
            }



            // Final response
            $response["status"] = true;
            $response["data"] = [
                "utilization" => [
                    "labels" => $utilLabels ?: ["No Data"],
                    "values" => $utilValues ?: [0]
                ],
                "users" => [
                    "labels" => $userLabels ?: ["No Data"],
                    "values" => $userValues ?: [0]
                ],
                "resources" => [
                    "labels" => $resLabels ?: ["No Data"],
                    "values" => $resValues ?: [0]
                ]
            ];

        } catch (Exception $e) {
            $response["status"] = false;
            $response["message"] = "Error: " . $e->getMessage();
        }

        // Return JSON
        return json_encode($response);
    }
    function formatDuration($seconds)
    {
        if ($seconds < 60)
            return $seconds . ' sec';
        if ($seconds < 3600)
            return floor($seconds / 60) . ' min ' . ($seconds % 60) . ' sec';
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return $hours . ' hr ' . $minutes . ' min';
    }

    function getDetailedReport()
    {
        try {
            $stmt = $this->db->query("
            SELECT 
                rl.user_id,

                -- Personal Info (one time only)
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.firstname')) AS firstname,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.lastname')) AS lastname,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.middlename')) AS middlename,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.student_id')) AS student_id,
                JSON_UNQUOTE(JSON_EXTRACT(u.authentication_data, '$.email')) AS email,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.course')) AS course,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.department')) AS department,
                JSON_UNQUOTE(JSON_EXTRACT(u.personal_details, '$.gender')) AS gender,

                -- Aggregates
                COUNT(DISTINCT rl.count_user) AS book_count,
                SUM(rl.count_user) AS count_access,
                SUM(rl.total_read_time) AS total_read_time,
                MAX(rl.end_time) AS last_read_time

            FROM reading_logs rl
            INNER JOIN user u ON rl.user_id = u.user_id
            GROUP BY rl.user_id
            ORDER BY total_read_time DESC, book_count DESC
        ");

            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$formattedLogs = array_map(function ($log, $index) {
    $fullname = trim(
        $log['lastname'] . ' ' .
        $log['firstname'] . ' ' .
        ($log['middlename'] ?? '')
    );

    return [
        'user_id' => $log['user_id'],
        'fullname' => $fullname,
        'student_id' => $log['student_id'],
        'email' => $log['email'],
        'course' => $log['course'],
        'department' => $log['department'],
        'gender' => $log['gender'],
        'count_access'=>$log['count_access'],
        // Aggregated results
        'book_count' => $log['book_count'],                 // ✅ different books only
        'total_read_time' => $log['total_read_time'],
        'total_read_time_formatted' => $this->formatDuration($log['total_read_time']),
        'last_read_time' => $log['last_read_time'],

        // Ranking
        'remark' => 'TOP ' . ($index + 1)
    ];
}, $logs, array_keys($logs));


            return json_encode([
                'status' => 1,
                'data' => $formattedLogs,
                
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }

    }

}
