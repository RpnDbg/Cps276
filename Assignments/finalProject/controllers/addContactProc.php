<?php

require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';
require_once __DIR__ . '/../classes/Validation.php';

$formConfig = [
    'fname'    => [
        'label'    => '*First Name',
        'name'     => 'fname',
        'id'       => 'fname',
        'type'     => 'text',
        'regex'    => 'name',
        'value'    => $_POST['fname']    ?? '',
        'errorMsg' => 'Enter a valid first name',
        'required' => true,
        'error'    => '',
    ],
    'lname'    => [
        'label'    => '*Last Name',
        'name'     => 'lname',
        'id'       => 'lname',
        'type'     => 'text',
        'regex'    => 'name',
        'value'    => $_POST['lname']    ?? '',
        'errorMsg' => 'Enter a valid last name',
        'required' => true,
        'error'    => '',
    ],
    'address'  => [
        'label'    => '*Address',
        'name'     => 'address',
        'id'       => 'address',
        'type'     => 'text',
        'regex'    => 'address',
        'value'    => $_POST['address']  ?? '',
        'errorMsg' => 'Enter a valid address',
        'required' => true,
        'error'    => '',
    ],
    'city'     => [
        'label'    => '*City',
        'name'     => 'city',
        'id'       => 'city',
        'type'     => 'text',
        'regex'    => 'name',
        'value'    => $_POST['city']     ?? '',
        'errorMsg' => 'Enter a valid city',
        'required' => true,
        'error'    => '',
    ],
    'state'    => [
        'label'    => '*State',
        'name'     => 'state',
        'id'       => 'state',
        'type'     => 'text',
        'regex'    => 'name',
        'value'    => $_POST['state']    ?? '',
        'errorMsg' => 'Enter a valid state',
        'required' => true,
        'error'    => '',
    ],
    'zip'      => [
        'label'    => '*Zip Code',
        'name'     => 'zip',
        'id'       => 'zip',
        'type'     => 'text',
        'regex'    => 'zip',
        'value'    => $_POST['zip']      ?? '',
        'errorMsg' => 'Enter a 5-digit ZIP',
        'required' => true,
        'error'    => '',
    ],
    'phone'    => [
        'label'    => '*Phone',
        'name'     => 'phone',
        'id'       => 'phone',
        'type'     => 'text',
        'regex'    => 'phone',
        'value'    => $_POST['phone']    ?? '',
        'errorMsg' => 'Use 10 digits or 123.456.7890',
        'required' => true,
        'error'    => '',
    ],
    'email'    => [
        'label'    => '*Email',
        'name'     => 'email',
        'id'       => 'email',
        'type'     => 'email',
        'regex'    => 'email',
        'value'    => $_POST['email']    ?? '',
        'errorMsg' => 'Enter a valid email',
        'required' => true,
        'error'    => '',
    ],
    'dob'      => [
        'label'    => '*DOB (mm/dd/yyyy)',
        'name'     => 'dob',
        'id'       => 'dob',
        'type'     => 'text',
        'regex'    => 'none',
        'value'    => $_POST['dob']      ?? '',
        'errorMsg' => 'Enter a valid date',
        'required' => true,
        'error'    => '',
    ],
    'contacts' => [  
        'label'    => 'Contact Methods',
        'name'     => 'contacts',
        'id'       => 'contacts',
        'type'     => 'checkbox',
        'regex'    => 'none',
        'options'  => [
            ['value'=>'Phone','label'=>'Phone'],
            ['value'=>'Email','label'=>'Email'],
            ['value'=>'Mail','label'=>'Mail'],
        ],
        'value'    => $_POST['contacts'] ?? [],
        'errorMsg' => 'Select at least one',
        'required' => false,
        'error'    => '',
    ],
    'age'      => [  
        'label'    => '*Age Range',
        'name'     => 'age',
        'id'       => 'age',
        'type'     => 'radio',
        'regex'    => 'none',
        'options'  => [
            ['value'=>'Under18','label'=>'Under 18'],
            ['value'=>'18-65','label'=>'18–65'],
            ['value'=>'65+','label'=>'65+'],
        ],
        'value'    => $_POST['age'] ?? '',
        'errorMsg' => 'Select age range',
        'required' => true,
        'error'    => '',
    ],
];


$validator = new Validation();
foreach ($formConfig as $key => &$cfg) {
    $val = $cfg['value'];
    if (is_array($val)) {
        $val = implode(',', $val);
        $cfg['value'] = $val;
    }
    if ($cfg['required'] || $val !== '') {
        $ok = $validator->checkFormat($val, $cfg['regex'], $cfg['errorMsg']);
        if (!$ok) {
            $cfg['error'] = $cfg['errorMsg'];
        }
    }
}
unset($cfg);



if ($validator->hasErrors()) {
    include __DIR__ . '/../views/addContactForm.php';
    exit;
}


if (!empty($formConfig['dob']['value'])) {
    $dt = DateTime::createFromFormat('m/d/Y', $formConfig['dob']['value']);
    if ($dt) {
        $formConfig['dob']['value'] = $dt->format('Y-m-d');
    }
}


$pdo = new Pdo_methods();
$sql = "INSERT INTO contacts
    (fname,lname,address,city,state,zip,phone,email,dob,contacts,age)
  VALUES
    (:fname,:lname,:address,:city,:state,:zip,:phone,:email,:dob,:contacts,:age)";

$bindings = [];
foreach ($formConfig as $cfg) {
    $bindings[] = [ ':' . $cfg['name'], $cfg['value'], 'str' ];
}

try {
    $result = $pdo->otherBinded($sql, $bindings);
} catch (PDOException $e) {
    $_SESSION['msg'] = [
        'type' => 'danger',
        'text' => 'DB error: ' . $e->getMessage()
    ];
    header('Location: index.php?page=addContact');
    exit;
}


$_SESSION['msg'] = [
    'type' => $result === 'noerror' ? 'success' : 'danger',
    'text' => $result === 'noerror'
                ? 'Contact information added.'
                : 'Unknown error inserting record.'
];
header('Location: index.php?page=addContact');
exit;
