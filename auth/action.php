<?php
header('Content-Type: application/json');
include 'admin_class.php';

$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';
$crud = new Action();

switch ($action) {
    case 'installation':
        echo $crud->installation();
        break;

    case 'login':
        echo $crud->login();
        break;

    case 'logout':
        echo $crud->logout();
        break;

    
  
    case 'GetFaculty':
        echo $crud->readUserDetails();
        break;

    case 'createFolder':
        echo $crud->createFolder();
        break;

    case 'getFolders':
        echo $crud->getFolders();
        break;

    case 'deleteFolder':
        echo $crud->deleteFolder();
        break;

    case 'uploadFile':
        echo $crud->uploadFile();
        break;

    case 'uploadFolder':
        echo $crud->uploadFolder();
        break;

    case 'getMetadata':
        echo $crud->getMetadata();
        break;

    case 'viewmeta':
        echo $crud->viewmeta();
        break;

    case 'editmeta':
        echo $crud->editmeta();
        break;

    case 'deletemeta':
        echo $crud->deletemeta();
        break;

    case 'searching':
        echo $crud->searching();
        break;

    case 'check_login':
        echo $crud->check_login();
        break;

    case 'readingbooks':
        echo $crud->readingbooks();
        break;

    case 'end_reading':
        echo $crud->endReading();
        break;

    case 'toggle_favorite':
        echo $crud->toggleFavorite();
        break;

    case 'get_favorite_books':
        echo $crud->get_favorite_books();
        break;

    case 'change_password':
        echo $crud->change_password();
        break;

    case 'register_user':
        echo $crud->register_user();
        break;

    case 'settingupdate':
        echo $crud->setting();
        break;

    /* ---------- USER CRUD SECTION ---------- */
    case 'GetUser':
        echo $crud->usercrude();
        break;
    case 'retrieveLogs':
        echo $crud->usercrude();
        break;
    default:
        echo json_encode(['status' => 0, 'message' => 'Invalid or missing action.']);
        break;
}
