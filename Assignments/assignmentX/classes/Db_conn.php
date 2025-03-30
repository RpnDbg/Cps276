<?php

class Db_conn {

  protected $conn;

  protected function connect() {
    try {
      $dbHost = 'localhost';
      $dbName = 'rdabbaghian';
      $dbUsr = 'rdabbaghian';
      $dbPass = '9hBryArU5DHD'; // Corrected based on latest password you posted

      $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsr, $dbPass);

      $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
      $this->conn->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $this->conn;

    } catch(PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }
}
