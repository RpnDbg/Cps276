<?php


require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST' 
    || !isset($_POST['ids']) 
    || !is_array($_POST['ids'])
) {
    header('Location: index.php?page=deleteContacts');
    exit;
}


$ids = array_map('intval', $_POST['ids']);
if (empty($ids)) {
    $_SESSION['msg'] = [
      'type' => 'warning',
      'text' => 'No contacts selected to delete.'
    ];
    header('Location: index.php?page=deleteContacts');
    exit;
}


$placeholders = [];
$bindings     = [];
foreach ($ids as $i => $id) {
    $param = ":id{$i}";
    $placeholders[] = $param;
    $bindings[]     = [$param, $id, 'int'];
}


$sql = "DELETE FROM contacts WHERE id IN (" . implode(',', $placeholders) . ")";
try {
    $pdo = new Pdo_methods();
    $pdo->otherBinded($sql, $bindings);
    $_SESSION['msg'] = [
      'type' => 'success',
      'text' => count($ids) . " contact(s) deleted."
    ];
} catch (PDOException $e) {
    $_SESSION['msg'] = [
      'type' => 'danger',
      'text' => 'DB error: ' . $e->getMessage()
    ];
}


header('Location: index.php?page=deleteContacts');
exit;
