<?php

require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';
require_once __DIR__ . '/../classes/StickyForm.php';

$sf  = new StickyForm();
$pdo = new Pdo_methods();


$formConfig = [
  'name'     => ['id'=>'name','name'=>'name','label'=>'Name','type'=>'text','regex'=>'name',
                 'value'=>$_POST['name']??'','errorMsg'=>'Enter a valid name','required'=>true,'error'=>''],
  'email'    => ['id'=>'email','name'=>'email','label'=>'Email','type'=>'email','regex'=>'email',
                 'value'=>$_POST['email']??'','errorMsg'=>'Enter a valid email','required'=>true,'error'=>''],
  'password' => ['id'=>'password','name'=>'password','label'=>'Password','type'=>'password','regex'=>'none',
                 'value'=>$_POST['password']??'','errorMsg'=>'Enter a password','required'=>true,'error'=>''],
  'status'   => ['id'=>'status','name'=>'status','label'=>'Status','type'=>'select','regex'=>'none',
                 'value'=>$_POST['status']??'','errorMsg'=>'Select a status','required'=>true,'error'=>'',
                 'options'=>['staff'=>'staff','admin'=>'admin']],
];

$formConfig = $sf->validateForm($_POST, $formConfig);
$errors     = array_filter($formConfig, fn($c)=>!empty($c['error']));
if ($errors) {
    include __DIR__ . '/../views/addAdminForm.php';
    exit;
}


$emailVal = trim($formConfig['email']['value']);
$exists = $pdo->selectBinded(
    "SELECT id FROM admins WHERE email = :email LIMIT 1",
    [[ ':email', $emailVal, 'str' ]]
);

if (!empty($exists)) {
    
    $formConfig['email']['error'] = 'That email address already exists';
    include __DIR__ . '/../views/addAdminForm.php';
    exit;
}


$formConfig['password']['value'] = password_hash(
    trim($formConfig['password']['value']),
    PASSWORD_DEFAULT
);

$sql = "INSERT INTO admins (name,email,password,status)
        VALUES (:name,:email,:password,:status)";
$bindings = [
    [':name',     trim($formConfig['name']['value']),     'str'],
    [':email',    $emailVal,                              'str'],
    [':password', $formConfig['password']['value'],       'str'],
    [':status',   $formConfig['status']['value'],         'str'],
];
$res = $pdo->otherBinded($sql, $bindings);


$_SESSION['msg'] = [
  'type' => $res==='noerror' ? 'success' : 'danger',
  'text' => $res==='noerror' ? 'Admin added' : 'Could not add admin',
];
header('Location: index.php?page=addAdmin');
exit;
