<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (empty($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}


$page = $_GET['page'] ?? '';
if (in_array($page, ['addAdmin','deleteAdmins'], true)
    && ($_SESSION['user']['status'] ?? '') !== 'admin'
) {
    header('Location: index.php?page=login');
    exit;
}
