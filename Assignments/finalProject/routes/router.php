<?php

session_start();

$page = $_GET['page'] ?? 'login';

switch ($page) {


    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/../controllers/loginProc.php';
        } else {
            require __DIR__ . '/../views/loginForm.php';
        }
        break;

    case 'logout':
        require __DIR__ . '/../controllers/logoutProc.php';
        break;

 
    case 'welcome':
        require __DIR__ . '/../views/welcomeForm.php';
        break;

 
    case 'addContact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/../controllers/addContactProc.php';
        } else {
            require __DIR__ . '/../views/addContactForm.php';
        }
        break;


    case 'deleteContacts':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/../controllers/deleteContactProc.php';
        } else {
            require __DIR__ . '/../views/deleteContactsTable.php';
        }
        break;

    case 'addAdmin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/../controllers/addAdminProc.php';
        } else {
            require __DIR__ . '/../views/addAdminForm.php';
        }
        break;

 
    case 'deleteAdmins':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/../controllers/deleteAdminProc.php';
        } else {
            require __DIR__ . '/../views/deleteAdminsTable.php';
        }
        break;

 
    default:
        header('Location: index.php?page=login');
        break;
}


exit;
