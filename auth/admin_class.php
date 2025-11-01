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
            'redirect_url' => '../'
        ]);
    }




    function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            return json_encode(['status' => 2, 'message' => 'Username and password are required.']);
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
                return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
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
                return json_encode(['status' => 2, 'message' => 'Incorrect username or password.']);
            }

            // Decode stored JSON fields
            $auth = json_decode($user['authentication_data'], true);
            $person = json_decode($user['personal_details'], true);

            // Verify password
            if (!password_verify($password, $auth['password'] ?? '')) {
                return json_encode(['status' => 2, 'message' => 'Incorrect username or password.']);
            }

            // Identify role and session key
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
                'email' => $auth['email'] ?? '',
                'username' => $auth['username'] ?? '',
                'user_role' => $role,
                'civil_id' => $user['civil_id'] ?? null,
                'created_date' => $user['created_date'] ?? '',
                'profile_pic' => $person['profile_pic'] ?? null
            ];

            // 🧠 Store session dynamically by role
            $_SESSION[$role] = $sessionData;

            // Determine redirect path
            $redirect = ($role === 'faculty') ? 'src/faculty/' : './';

            return json_encode([
                'status' => 1,
                'redirect_url' => $redirect,
                'user_name' => trim(($person['firstname'] ?? '') . ' ' . ($person['lastname'] ?? '')),
                'user_data' => $_SESSION[$role]
            ]);


        } catch (Exception $e) {
            return json_encode(['status' => 500, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
    function installation()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['system_details'], $input['admin_details'])) {
            return json_encode(['status' => 2, 'message' => 'Invalid input data.']);
        }

        $system = $input['system_details'];
        $admin = $input['admin_details'];

        // Validate required fields
        $required_system = ['system_title', 'system_description'];
        $required_admin = ['firstname', 'lastname', 'email', 'username', 'password'];

        foreach ($required_system as $field) {
            if (empty($system[$field]))
                return json_encode(['status' => 2, 'message' => "System field '$field' is required."]);
        }
        foreach ($required_admin as $field) {
            if (empty($admin[$field]))
                return json_encode(['status' => 2, 'message' => "Admin field '$field' is required."]);
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
            return json_encode(['status' => 2, 'message' => 'Error: ' . $e->getMessage()]);
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
    function register_faculty()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        $required = ['firstname', 'lastname', 'department', 'username', 'password', 'email'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                return json_encode(['status' => 2, 'message' => "Missing required field: $field"]);

            }
        }

        $firstname = $input['firstname'];
        $lastname = $input['lastname'];
        $department = $input['department'];
        $username = $input['username'];
        $password = $input['password'];
        $email = $input['email'];
        $profilePicBase64 = isset($input['profile_pic']) ? $input['profile_pic'] : null;

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Handle Base64 image
        $profile_pic_path = null;
        if ($profilePicBase64) {
            $uploadDir = __DIR__ . './auth/uploads/faculty_profiles/'; // Make sure this folder exists and is writable
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $profilePicBase64, $type)) {
                $profilePicBase64 = substr($profilePicBase64, strpos($profilePicBase64, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return json_encode(['status' => 2, 'message' => 'Invalid image type']);

                }

                $profilePicBase64 = base64_decode($profilePicBase64);
                if ($profilePicBase64 === false) {
                    return json_encode(['status' => 0, 'message' => 'Base64 decode failed']);

                }

                $fileName = uniqid('faculty_') . '.' . $type;
                $filePath = $uploadDir . $fileName;

                if (file_put_contents($filePath, $profilePicBase64) !== false) {
                    // Store relative path
                    $profile_pic_path = 'uploads/faculty_profiles/' . $fileName;
                } else {
                    return json_encode(['status' => 0, 'message' => 'Failed to save profile picture']);

                }
            } else {
                return json_encode(['status' => 2, 'message' => 'Invalid image format']);

            }
        }

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO user (personal_details, authentication_data) VALUES (?, ?)"
            );

            $personal_details = json_encode([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'department' => $department,
                'profile_pic' => $profile_pic_path // store path instead of Base64
            ]);

            $authentication_data = json_encode([
                'username' => $username,
                'password' => $hashed_password,
                'user_role' => 'faculty',
                'email' => $email
            ]);

            $stmt->execute([$personal_details, $authentication_data]);

            return json_encode(['status' => 1, 'message' => 'Faculty added successfully.', 'data' => $input]);
        } catch (PDOException $e) {
            return json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    function register_student()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            !$input ||
            !isset($input['firstname'], $input['lastname'], $input['course'], $input['username'], $input['password'], $input['email'])
        ) {
            return json_encode(['status' => 2, 'message' => 'Invalid input data.']);
        }

        $firstname = $input['firstname'];
        $lastname = $input['lastname'];
        $course = $input['course'];
        $department = $input['department'];
        $username = $input['username'];
        $password = $input['password'];
        $email = $input['email'];
        $profilePicBase64 = isset($input['profile_pic']) ? $input['profile_pic'] : null;

        // Hash password before storing it
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Handle profile picture if it exists
        $profile_pic_path = null;
        if ($profilePicBase64) {
            $uploadDir = __DIR__ . '/auth/uploads/student_profiles/'; // Make sure this directory exists and is writable

            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    return json_encode(['status' => 0, 'message' => 'Failed to create upload directory for student profile picture']);
                }
            }

            // Extract base64 data from the input
            if (preg_match('/^data:image\/(\w+);base64,/', $profilePicBase64, $type)) {
                $profilePicBase64 = substr($profilePicBase64, strpos($profilePicBase64, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                // Validate image type
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return json_encode(['status' => 2, 'message' => 'Invalid image type']);
                }

                $profilePicBase64 = base64_decode($profilePicBase64);
                if ($profilePicBase64 === false) {
                    return json_encode(['status' => 0, 'message' => 'Base64 decode failed']);
                }
                $fileName = uniqid('student_') . '.' . $type;
                $filePath = $uploadDir . $fileName;

                if (file_put_contents($filePath, $profilePicBase64) === false) {
                    return json_encode(['status' => 0, 'message' => 'Failed to save profile picture']);
                }

                // Store the relative path to the profile picture
                $profile_pic_path = 'uploads/student_profiles/' . $fileName;
            } else {
                return json_encode(['status' => 2, 'message' => 'Invalid image format']);
            }
        }

        try {
            // Prepare the SQL query to insert the user data
            $stmt = $this->db->prepare(
                "INSERT INTO user (personal_details, authentication_data) VALUES (?, ?)"
            );

            $personal_details = json_encode([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'course' => $course,
                'department' => $department,
                'profile_pic' => $profile_pic_path
            ]);

            $authentication_data = json_encode([
                'username' => $username,
                'password' => $hashed_password,
                'user_role' => 'student',
                'email' => $email
            ]);

            $stmt->execute([$personal_details, $authentication_data]);

            return json_encode(['status' => 1, 'message' => 'Student added successfully.']);
        } catch (PDOException $e) {
            // Catch any database errors
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


}
