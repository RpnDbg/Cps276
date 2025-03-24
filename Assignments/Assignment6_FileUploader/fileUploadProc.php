<?php
require_once '../../phpmysqltest/classes/PdoMethods.php';

$output = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['filename']) && isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == 0) {
        $fileNameInput = trim($_POST['filename']);
        $file = $_FILES['pdfFile'];

        // Validate size
        if ($file['size'] > 100000) {
            $output = "<p style='color:red'>Error: File is too large (must be under 100KB).</p>";
        }
        // Validate PDF
        elseif ($file['type'] != 'application/pdf') {
            $output = "<p style='color:red'>Error: Only PDF files are allowed.</p>";
        }
        else {
            // Move the file
            $targetDir = "files/";
            $filePath = $targetDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Insert into database
                $pdo = new PdoMethods();
                $sql = "INSERT INTO files (filename, filepath) VALUES (:filename, :filepath)";
                $bindings = [
                    [':filename', $fileNameInput, 'str'],
                    [':filepath', $filePath, 'str']
                ];
                $result = $pdo->otherBinded($sql, $bindings);

                if ($result == "noerror") {
                    $output = "<p style='color:green'>File uploaded and saved in the database successfully!</p>";
                } else {
                    $output = "<p style='color:red'>Database error. Could not save record.</p>";
                }
            } else {
                $output = "<p style='color:red'>Error moving the file. Make sure your <code>files/</code> directory is chmod 777.</p>";
            }
        }
    } else {
        $output = "<p style='color:red'>Please enter a file name and select a PDF file.</p>";
    }
}
?>
