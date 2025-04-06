<?php

class DatabaseConn {	

  private $conn;

  public function dbOpen(){

    try {
      $dbHost = 'localhost';
      $dbName = 'rdabbaghian'; // your WCC username
      $dbUsr = 'rdabbaghian';  // your WCC username
      $dbPass = '9hBryArU5DHD'; // password from video

      $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsr, $dbPass);
      $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
      $this->conn->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $this->conn;

    } catch(PDOException $e) { 
      echo $e->getMessage(); 
    }
  }
}
?>
