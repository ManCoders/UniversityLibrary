<?php
header('Content-Type: application/json');


$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';

include 'admin_class.php';

$crud = new Action();

if ($action === 'installation') {
	$installer = $crud->installation();

	if ($installer) {
		echo $installer;
	}
}


/* if ($action === 'admin_in') {
	$installer = $crud->admin_staff_register();

	if ($installer) {
		echo $installer;
	}
} */

if ($action === 'login') {
	$login = $crud->login();
	if ($login) {
		echo $login;
	}
}

if ($action === 'logout') {
	$logout = $crud->logout();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'Regfaculty'){
	$logout = $crud->register_faculty();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'Regstudent'){
	$logout = $crud->register_student();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'GetFaculty'){
	$logout = $crud->readUserDetails();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'createFolder'){
	$logout = $crud->createFolder();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'getFolders'){
	$logout = $crud->getFolders();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'deleteFolder'){
	$logout = $crud->deleteFolder();
	if ($logout) {
		echo $logout;
	}
}
if($action === 'uploadFile'){
	$logout = $crud->uploadFile();
	if ($logout) {
		echo $logout;
	}
}
if($action === 'uploadFolder'){
	$logout = $crud->uploadFolder();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'getMetadata'){
	$logout = $crud->getMetadata();
	if ($logout) {
		echo $logout;
	}
}




if($action === 'viewmeta'){
	$logout = $crud->viewmeta();
	if ($logout) {
		echo $logout;
	}
}


if($action === 'editmeta'){
	$logout = $crud->editmeta();
	if ($logout) {
		echo $logout;
	}
}


if($action === 'deletemeta'){
	$logout = $crud->deletemeta();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'searching'){
	$logout = $crud->searching();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'check_login'){
	$logout = $crud->check_login();
	if ($logout) {
		echo $logout;
	}
}

if($action === 'openbooks'){
	$logout = $crud->readingbooks();
	if ($logout) {
		echo $logout;
	}
}












/* ************** Start section ************** */


