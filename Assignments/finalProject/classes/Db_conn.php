<?php
class DatabaseConn {
    private ?PDO $conn = null;

    public function dbOpen(): PDO {
        if ($this->conn) {
            return $this->conn;
        }

        $dbHost = 'localhost';
        $dbName = 'rdabbaghian';
        $dbUsr  = 'rdabbaghian';
        $dbPass = '9hBryArU5DHD';
        $dsn    = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, $dbUsr, $dbPass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
            return $this->conn;
        } catch (PDOException $e) {
            // In production, log this instead of dying
            die("DB connection failed: " . $e->getMessage());
        }
    }
}
