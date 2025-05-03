<?php


require_once __DIR__ . '/../classes/Pdo_methods.php';


$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');


$errors = [];
if ($email === '')    $errors['email']    = 'Please enter your email';
if ($password === '') $errors['password'] = 'Please enter your password';

if ($errors) {
    include __DIR__ . '/../views/loginForm.php';
    exit;
}


$pdo  = new Pdo_methods();
$sql  = "SELECT * FROM admins WHERE email = :email";
$rows = $pdo->selectBinded($sql, [[ ':email', $email, 'str' ]]);


if ($rows === 'error' || count($rows) < 1) {
    $errors['login'] = 'Invalid credentials.';
    include __DIR__ . '/../views/loginForm.php';
    exit;
}

$user = $rows[0];


if (!password_verify($password, $user['password'])) {
    $errors['login'] = 'Invalid credentials.';
    include __DIR__ . '/../views/loginForm.php';
    exit;
}


$_SESSION['user'] = [
    'id'     => $user['id'],
    'name'   => $user['name'],
    'status' => $user['status']
];


header('Location: index.php?page=welcome');
exit;
