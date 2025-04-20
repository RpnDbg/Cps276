<?php
header('Content-Type: application/json');
require_once "../classes/Pdo_methods.php";

// Get raw JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['name']) || trim($input['name']) === "") {
    echo json_encode(["masterstatus" => "error", "msg" => "No name received"]);
    exit;
}

$fullName = trim($input['name']);
$parts = explode(" ", $fullName);

if (count($parts) != 2) {
    echo json_encode(["masterstatus" => "error", "msg" => "Enter a first and last name."]);
    exit;
}

$first = $parts[0];
$last = $parts[1];
$formatted = "$last, $first";

$pdo = new PdoMethods();
$sql = "INSERT INTO names (name) VALUES (:name)";
$bindings = [[":name", $formatted, "str"]];
$result = $pdo->otherBinded($sql, $bindings);

if ($result === "noerror") {
    echo json_encode(["masterstatus" => "success", "msg" => "Name added"]);
} else {
    echo json_encode(["masterstatus" => "error", "msg" => "Insert failed"]);
}
?>
