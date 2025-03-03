<?php
class Directories {
    private $basePath = "directories/";

    public function createDirectoryAndFile($folderName, $fileContent) {
        $directoryPath = $this->basePath . $folderName;

        // Check if directory already exists
        if (is_dir($directoryPath)) {
            return [
                'success' => false,
                'message' => "A directory already exists with that name."
            ];
        }

        // Try to create directory
        if (!mkdir($directoryPath, 0777, true)) {
            return [
                'success' => false,
                'message' => "Error creating directory."
            ];
        }

        // Create file and write content
        $filePath = $directoryPath . "/readme.txt";
        if (file_put_contents($filePath, $fileContent) === false) {
            return [
                'success' => false,
                'message' => "Error creating file."
            ];
        }

        return [
            'success' => true,
            'path' => $filePath
        ];
    }
}
?>
