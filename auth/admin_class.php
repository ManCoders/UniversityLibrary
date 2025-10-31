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


    function logout()
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
    }



    function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            return json_encode(['status' => 2, 'message' => 'Username and password are required.']);
        }

        try {
            // ==== Admin Login ====
            $stmtAdmin = $this->db->prepare("
            SELECT * FROM admin WHERE JSON_EXTRACT(authentication_data, '$.username') = ? 
            OR JSON_EXTRACT(authentication_data, '$.email') = ? LIMIT 1
        ");
            $stmtAdmin->execute([$username, $username]);
            $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $authAdmin = json_decode($admin['authentication_data'], true);

                if (is_array($authAdmin) && password_verify($password, $authAdmin['password'])) {
                    $_SESSION['admin'] = [
                        'firstname' => $admin['firstname'] ?? '',
                        'middlename' => $admin['middlename'] ?? '',
                        'lastname' => $admin['lastname'] ?? '',
                        'email' => $authAdmin['email'] ?? '',
                        'user_role' => 'Admin',
                        'username' => $authAdmin['username'] ?? '',
                        'admin_id' => $admin['admin_id'] ?? null,
                        'created_date' => $admin['created_date'] ?? ''
                    ];

                    return json_encode([
                        'status' => 1,
                        'message' => 'Admin login success',
                        'redirect_url' => 'src/admin/index.php',
                        'user_data' => $_SESSION['admin']
                    ]);
                } else {
                    return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
                }
            }

            // ==== Senior Citizen / Employee Login ====
            $stmtCitizen = $this->db->prepare("
            SELECT * FROM civil_data 
            WHERE JSON_EXTRACT(authentication_data, '$.username') = ? 
            OR JSON_EXTRACT(authentication_data, '$.email') = ? LIMIT 1
        ");
            $stmtCitizen->execute([$username, $username]);
            $row = $stmtCitizen->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $authCitizen = json_decode($row['authentication_data'], true);

                if (
                    is_array($authCitizen) &&
                    ($username === $authCitizen['username'] || $username === $authCitizen['email']) &&
                    password_verify($password, $authCitizen['password'])
                ) {

                    $_SESSION['citizen'] = [
                        'firstname' => $row['firstname'] ?? '',
                        'middlename' => $row['middlename'] ?? '',
                        'lastname' => $row['lastname'] ?? '',
                        'email' => $authCitizen['email'] ?? '',
                        'user_role' => $row['user_role'] ?? 'unknown',
                        'username' => $authCitizen['username'] ?? '',
                        'civil_id' => $row['civil_id'] ?? null,
                        'created_date' => $row['created_date'] ?? ''
                    ];

                    if (($row['user_role'] ?? '') !== 'senior-citizen') {
                        return json_encode([
                            'status' => 4,
                            'message' => 'User role not matched'
                        ]);
                    }

                    return json_encode([
                        'status' => 1,
                        'redirect_url' => 'src/citizen/',
                        'user_name' => trim(($row['firstname'] ?? '') . " " . ($row['lastname'] ?? '')),
                        'user_data' => $_SESSION['citizen']
                    ]);
                } else {
                    return json_encode([
                        'status' => 2,
                        'message' => 'Incorrect username or password.'
                    ]);
                }
            }

            return json_encode([
                'status' => 4,
                'message' => 'User not found. Please check your username or email.'
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }



    function installation()
    {
        $firstname = htmlspecialchars($_POST['firstname'] ?? '');
        $middlename = htmlspecialchars($_POST['middlename'] ?? '');
        $lastname = htmlspecialchars($_POST['lastname'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $username = htmlspecialchars($_POST['username'] ?? '');
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
        $system_title = htmlspecialchars($_POST['system_title'] ?? '');
        $system_description = htmlspecialchars($_POST['system_description'] ?? '');

        if (!isset($_FILES['system_logo']) || $_FILES['system_logo']['error'] !== 0) {
            return json_encode(['status' => 2, 'message' => 'Logo file is required.']);
        }

        $logo = $_FILES['system_logo'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if ($logo['size'] > 10 * 1024 * 1024) {
            return json_encode(['status' => 2, 'message' => 'Logo file size exceeds 2MB.']);
        }

        if (!in_array($logo['type'], $allowed_types)) {
            return json_encode(['status' => 2, 'message' => 'Invalid logo file type.']);
        }

        $upload_dir = '../assets/image/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $logo_name = uniqid('logo_');
        $upload_path = $upload_dir . $logo_name;
        if (!move_uploaded_file($logo['tmp_name'], $upload_path)) {
            return json_encode(['status' => 2, 'message' => 'Failed to upload logo file.']);
        }

        try {
            $stmt1 = $this->db->prepare("INSERT INTO admin_data (firstname, middlename, lastname, email, username, password, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $adminInsert = $stmt1->execute([$firstname, $middlename, $lastname, $email, $username, $password, 'Admin']);

            if ($adminInsert) {
                $stmt2 = $this->db->prepare("INSERT INTO system (system_title, system_description, system_logo) VALUES (?, ?, ?)");
                $systemInsert = $stmt2->execute([$system_title, $system_description, $logo_name]);

                if ($systemInsert) {
                    return json_encode(['status' => 1, 'message' => 'Installation data saved successfully.']);
                } else {
                    return json_encode(['status' => 2, 'message' => 'Failed to save system data.']);
                }
            } else {
                return json_encode(['status' => 2, 'message' => 'Failed to save admin data.']);
            }
        } catch (Exception $e) {

            return json_encode(['status' => 2, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    function admin_staff_register()
    {
        extract($_POST);
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);

        try {

            switch ($user_role) {
                case 'admin':
                    $data = $this->db->prepare("INSERT INTO admin_data (admin_email, admin_password, admin_user_role) VALUES (?, ?, ?)
                     ");
                    $data->execute([$email, $hashpassword, $user_role]);
                    $info = "Admin Account registered Successful!";
                    break;
                /* case 'HRSM':
                    $data = $this->db->prepare("INSERT INTO employee_data (email, password, user_role
                    ) VALUES (?, ?, ?)
                     ");
                    $data->execute([$email, $hashpassword, $user_role]);
                    $info = "Hr Account registered Successful!";
                    break;
                case 'EMPLOYEE':
                    $data = $this->db->prepare("INSERT INTO employee_data (email, password) VALUES (?, ?, ?)
                     ");
                    $data->execute([$email, $hashpassword, $user_role]);
                    $info = "Employee Account registered Successful!";
                    break;
 */
                default:
                    $info = "Account registered Failed!";
                    break;
            }


            return json_encode([
                'status' => 1,
                'message' => $info
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }


    function registration_form()
    {

        $lastName = htmlspecialchars(trim($_POST["lastName"]));
        $firstName = htmlspecialchars(trim($_POST["firstName"]));
        $middleName = htmlspecialchars(trim($_POST["middleName"] ?? ''));
        $suffix = htmlspecialchars(trim($_POST["suffix"] ?? ''));
        $employeeID = htmlspecialchars(trim($_POST["employeeID"]));
        $jobTitle_id = htmlspecialchars(trim($_POST["jobTitle_id"]));
        $Department_id = filter_var(trim($_POST["Department_id"]), FILTER_SANITIZE_EMAIL);
        $gender = htmlspecialchars(trim($_POST["gender"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $contact = $_POST["contact"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        // Validation code remains the same...

        try {
            $stmtGetSalary = $this->db->prepare("SELECT salary FROM jobtitles WHERE jobTitles_id = '$jobTitle_id'");
            $stmtGetSalary->execute();
            $salaryResult = $stmtGetSalary->fetch(PDO::FETCH_ASSOC);
            $salary = $salaryResult["salary"] ?? '';


            // Check if username exists using prepared statement
            $stmt = $this->db->prepare("SELECT username FROM civil WHERE username = ?");
            $stmt->execute([$username]);
            $usernameTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usernameTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Username ' . $usernameTaken["username"] . ' already taken please try another username'
                ]);
            }

            $stmt = $this->db->prepare("SELECT employeeID FROM hr_data WHERE employeeID = ?");
            $stmt->execute([$employeeID]);
            $employeeIDTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($employeeIDTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'employee ID:  ' . $employeeIDTaken["employeeID"] . ' already taken please try another Employee ID'
                ]);
            }

            // Check if email exists
            $stmt = $this->db->prepare("SELECT email FROM employee_data WHERE email = ?");
            $stmt->execute([$email]);
            $emailTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($emailTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Email address already registered'
                ]);
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user_role = "EMPLOYEE";
            // FIXED: Use $this->db instead of $pdo
            $query = "INSERT INTO employee_data (firstname, middlename, lastname, suffix, email, contact, gender, username, password, user_role, user_request) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

            $stmt = $this->db->prepare($query); // CHANGED: $pdo to $this->db
            $stmt->execute([
                $firstName,
                $middleName,
                $lastName,
                $suffix,
                $email,
                $contact,
                $gender,
                $username,
                $hashedPassword,
                $user_role
            ]);

            $employee_id = $this->db->lastInsertId();

            $stmt = $this->db->prepare("INSERT INTO hr_data (employee_id, jobTitle_id, employeeID, Department_id, salary) VALUES ('$employee_id', '$jobTitle_id', '$employeeID', '$Department_id', '$salary')");
            $stmt->execute();

            $stmtLeaveCounts = $this->db->prepare("INSERT INTO leavecounts (employee_id) VALUES ('$employee_id')");
            $stmtLeaveCounts->execute();

            return json_encode([
                'status' => 1,
                'message' => 'Account created successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }

    function feedback()
    {
        try {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $title = trim($_POST['title'] ?? '');

            if (!$name || !$email || !$message) {
                throw new Exception('All fields are required.');
            }

            $stmt = $this->db->prepare("INSERT INTO feedback (name, email, title,  message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $success = $stmt->execute([$name, $email, $title, $message]);

            if (!$success) {
                throw new Exception('Failed to save feedback.');
            }

            return json_encode([
                'success' => true,
                'message' => 'Thank you for your feedback!'
            ]);
        } catch (Throwable $e) {
            return json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    function read_feedback()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM feedback ORDER BY created_at DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(['success' => true, 'data' => $data]);
        } catch (Throwable $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    function delete_feedback()
    {
        try {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception('Missing feedback ID');
            }

            $id = (int) $_POST['id']; // sanitize ID



            $stmt = $this->db->prepare("DELETE FROM feedback WHERE id = ?");
            $success = $stmt->execute([$id]);

            if ($success) {
                return json_encode(['success' => true, 'message' => 'Feedback deleted successfully']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to delete feedback']);
            }
        } catch (Throwable $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    function verifying()
    {
        // 🧠 Decode raw JSON input instead of $_POST
        $input = json_decode(file_get_contents("php://input"), true);

        $first = $input['first_name'] ?? '';
        $middle = $input['middle_name'] ?? '';
        $last = $input['last_name'] ?? '';
        $suffix = $input['suffix'] ?? '';
        $birth = $input['birth_date'] ?? '';
        $osca = $input['osca_number'] ?? '';

        // 🧩 Validate input
        if (empty($first) || empty($last) || empty($birth) || empty($osca)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Please fill out all required fields.'
            ]);
        }

        // 🧠 Search in JSON fields
        $stmt = $this->db->prepare("
        SELECT * FROM civil_data
        WHERE 
            osca_id = ?
            AND JSON_UNQUOTE(JSON_EXTRACT(identification_data, '$.first_name')) = ?
            AND JSON_UNQUOTE(JSON_EXTRACT(identification_data, '$.last_name')) = ?
            AND JSON_UNQUOTE(JSON_EXTRACT(birth_data, '$.birth_date')) = ?
    ");

        $stmt->execute([$osca, $first, $last, $birth]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            return json_encode([
                'status' => 'success',
                'message' => 'Record verified successfully.',
                'data' => $record
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'No matching record found in the database.',
            ]);
        }
    }

    function registerSenior()
    {
        try {
            // 🧩 Capture form data (JSON from frontend)
            $input = json_decode(file_get_contents("php://input"), true);

            $first = trim($input['first_name'] ?? '');
            $middle = trim($input['middle_name'] ?? '');
            $last = trim($input['last_name'] ?? '');
            $suffix = trim($input['suffix'] ?? '');
            $birth = trim($input['birth_date'] ?? '');
            $osca = trim($input['osca_number'] ?? '');
            $emName = trim($input['emergency_contact'] ?? '');
            $emPhone = trim($input['emergency_phone'] ?? '');

            $emailaddress = trim($input['email'] ?? '');
            $username = trim($input['username'] ?? '');
            $password = trim($input['password'] ?? '');
            $cpassword = trim($input['conpassword'] ?? '');


            if (!$password === $cpassword) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Passwords do not match'
                ]);
            }

            // 🧠 Validate required fields
            if (empty($first) || empty($last) || empty($birth) || empty($osca) || empty($emName) || empty($emPhone)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'All required fields must be filled.'
                ]);
            }

            // 🧾 Check if already exists
            $check = $this->db->prepare("SELECT osca_id FROM civil_data WHERE osca_id = ?");
            $check->execute([$osca]);
            if ($check->fetch(PDO::FETCH_ASSOC)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'OSCA Number already registered.'
                ]);
            }

            // 🧱 Build JSON data
            $identification_data = json_encode([
                'first_name' => $first,
                'middle_name' => $middle,
                'last_name' => $last,
                'suffix' => $suffix
            ], JSON_UNESCAPED_UNICODE);

            $birth_data = json_encode([
                'birth_date' => $birth
            ], JSON_UNESCAPED_UNICODE);

            $contact_data = json_encode([
                'emergency_contact' => $emName,
                'emergency_phone' => $emPhone
            ], JSON_UNESCAPED_UNICODE);

            $authentication = json_encode([
                'username' => $username,
                'email' => $emailaddress,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ], JSON_UNESCAPED_UNICODE);

            /* $username = strtolower($first . '.' . $last);
            $password = password_hash('default123', PASSWORD_DEFAULT); */
            $role = 'senior-citizen';

            // 💾 Insert into DB
            $stmt = $this->db->prepare("
            INSERT INTO civil_data (
                osca_id, identification_data, birth_data, contact_data, authentication_data,  user_role
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");
            $stmt->execute([$osca, $identification_data, $birth_data, $contact_data, $authentication, $role]);

            return json_encode([
                'status' => 'success',
                'message' => 'Senior Citizen successfully registered!',
                'username' => $username
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    function SeniorCitizens()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM civil_data ORDER BY created_at DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = array_map(function ($row) {
                $ident = json_decode($row['identification_data'], true) ?? [];
                $contact = json_decode($row['contact_data'], true) ?? [];
                $address = json_decode($row['authentication_data'], true) ?? [];
                $gov = json_decode($row['government_data'], true) ?? [];
                $economic = json_decode($row['economic_data'], true) ?? [];

                return [
                    "id" => $row['civil_id'],
                    "osca_id" => $row['osca_id'],

                    "ProfileInfo" => strtoupper(trim((($ident['last_name'] ?? '') . ', ' . $ident['first_name'] ?? '') . ' ' . ($ident['middle_name'][0] ?? '') . '.')),
                    "ContanctInfo" => strtoupper($contact['emergency_phone'] ?? 'N/A'),
                    "AddressInfo" => $address['barangay'] ?? 'N/A',
                    "PensionStatus" => $economic['pension_status'] ?? 'Unknown',
                    "Type" => $row['user_role'] ?? 'User',
                    "status" => $row['status'] ?? 'NA'
                ];
            }, $rows);

            return json_encode(["success" => true, "data" => $data]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    function getSeniorCitizen()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            return json_encode(['success' => false, 'message' => 'No ID provided']);
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM civil_data WHERE civil_id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return json_encode(['success' => false, 'message' => 'No record found']);
            }

            // Decode JSON fields safely
            $ident = json_decode($row['identification_data'], true) ?? [];
            $contact = json_decode($row['contact_data'], true) ?? [];
            $address = json_decode($row['authentication_data'], true) ?? [];
            $economic = json_decode($row['economic_data'], true) ?? [];
            $birth = json_decode($row['birth_data'], true) ?? [];

            // Build structured response
            $data = [
                "id" => $row['civil_id'],
                "osca_id" => $row['osca_id'],
                'DateBirth' => $birth['birth_date'],
                "ProfileInfo" => strtoupper(trim((($ident['last_name'] ?? '') . ', ' . ($ident['first_name'] ?? '') . ' ' . ($ident['middle_name'] ?? '') . '.'))),
                "ContanctEmerNum" => strtoupper($contact['emergency_phone'] ?? 'N/A'),
                "ContanctEmerName" => strtoupper($contact['emergency_contact'] ?? 'N/A'),
                "AddressInfo" => strtoupper($address['barangay'] ?? 'N/A'),
                "PensionStatus" => strtoupper($economic['pension_status'] ?? 'UNKNOWN'),
                "Type" => strtoupper($row['user_role'] ?? 'senior-citizen'),
                "status" => strtoupper($row['status'] ?? 'N/A')
            ];

            return json_encode(["success" => true, "data" => $data]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    function updatedatainfo()
    {

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data) || !is_array($data)) {
                echo json_encode([
                    'status' => 0,
                    'message' => 'No data received or invalid format.'
                ]);
                return;
            }

            $receivedData = [];
            $osid = '';

            foreach ($data as $key => $value) {
                // Clean string values
                if (is_string($value)) {
                    $value = trim($value);
                }

                // Convert checkbox "on" to boolean
                if ($value === "on") {
                    $value = true;
                }

                // Capture oscaId specifically
                if ($key === 'oscaId') {
                    $osid = $value;
                }

                // Store all fields dynamically
                $receivedData[$key] = $value;
            }


            echo json_encode([
                'status' => 1,
                'message' => 'Data received successfully.',
                'data' => $receivedData
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'status' => 0,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }





}
