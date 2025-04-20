<?php
require_once "Db_conn.php";

class PdoMethods extends DatabaseConn {

  private $sth;
  private $conn;
  private $db;

  public function selectBinded($sql, $bindings) {
    try {
      $this->db_connection();
      $this->sth = $this->conn->prepare($sql);
      $this->createBinding($bindings);
      $this->sth->execute();
      $results = $this->sth->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      echo $e->getMessage();
      return 'error';
    }
    $this->conn = null;
    return $results;
  }

  public function selectNotBinded($sql) {
    try {
      $this->db_connection();
      $this->sth = $this->conn->prepare($sql);
      $this->sth->execute();
      $results = $this->sth->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      echo $e->getMessage();
      return 'error';
    }
    $this->conn = null;
    return $results;
  }

  public function otherBinded($sql, $bindings) {
    try {
      $this->db_connection();
      $this->sth = $this->conn->prepare($sql);
      $this->createBinding($bindings);
      $this->sth->execute();
    } catch(PDOException $e) {
      echo $e->getMessage();
      return 'error';
    }
    $this->conn = null;
    return 'noerror';
  }

  public function otherNotBinded($sql) {
    try {
      $this->db_connection();
      $this->sth = $this->conn->prepare($sql);
      $this->sth->execute();
    } catch(PDOException $e) {
      echo $e->getMessage();
      return 'error';
    }
    $this->conn = null;
    return 'noerror';
  }

  private function db_connection() {
    $this->db = new DatabaseConn();
    $this->conn = $this->db->dbOpen();
  }

  private function createBinding($bindings) {
    foreach($bindings as $value){
      switch($value[2]){
        case "str":
          $this->sth->bindParam($value[0], $value[1], PDO::PARAM_STR);
          break;
        case "int":
          $this->sth->bindParam($value[0], $value[1], PDO::PARAM_INT);
          break;
      }
    }
  }
}
