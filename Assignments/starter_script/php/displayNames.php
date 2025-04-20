<?php
header('Content-Type: application/json');
require_once "../classes/Pdo_methods.php";

$pdo = new PdoMethods();
$sql = "SELECT name FROM names ORDER BY name ASC";
$records = $pdo->selectNotBinded($sql);

$response = [];

if ($records === 'error') {
    $response['status'] = 'error';
    $response['data'] = [];
} else {
    $response['status'] = 'success';
    $response['data'] = [];

    foreach ($records as $row) {
        $response['data'][] = $row['name'];
    }
}

echo json_encode($response);
?>
