<?php
header('Content-Type: application/json');
require_once "../classes/Pdo_methods.php";

$pdo = new PdoMethods();
$sql = "DELETE FROM names";
$result = $pdo->otherNotBinded($sql);

if ($result == "noerror") {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to clear names."]);
}
?>
