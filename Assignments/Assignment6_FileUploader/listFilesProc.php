<?php
require_once '../../phpmysqltest/classes/PdoMethods.php';


$pdo = new PdoMethods();
$sql = "SELECT filename, filepath FROM files";
$records = $pdo->selectNotBinded($sql);

if ($records === 'error' || count($records) === 0) {
    $output = "<p>No files found.</p>";
} else {
    $output = "<ul>";
    foreach ($records as $record) {
        $output .= "<li><a target='_blank' href='{$record['filepath']}'>{$record['filename']}</a></li>";
    }
    $output .= "</ul>";
}
