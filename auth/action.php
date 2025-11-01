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



/* ************** Start section ************** */


