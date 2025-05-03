<?php
// finalProject/classes/Pdo_methods.php

require_once __DIR__ . '/Db_conn.php';

class Pdo_methods extends DatabaseConn {
    private ?PDO           $conn = null;
    private ?PDOStatement  $sth  = null;

    /** 
     * Ensure we have a live PDO connection with exceptions turned on 
     */
    private function db_connection(): void {
        if ($this->conn === null) {
            $this->conn = $this->dbOpen();
            // Throw PDOExceptions rather than returning them
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * Run a SELECT with named bindings.
     * @param string $sql
     * @param array  $bindings  [ [':param',$value,'str'|'int'], ... ]
     * @return array            Fetched rows
     * @throws PDOException
     */
    public function selectBinded(string $sql, array $bindings): array {
        $this->db_connection();
        $this->sth = $this->conn->prepare($sql);
        foreach ($bindings as [$param, $val, $type]) {
            $pdoType = $type === 'int' ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->sth->bindValue($param, $val, $pdoType);
        }
        $this->sth->execute();
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Shortcut for SELECT with no bindings.
     * @param string $sql
     * @return array
     * @throws PDOException
     */
    public function selectNotBinded(string $sql): array {
        return $this->selectBinded($sql, []);
    }

    /**
     * Run an INSERT/UPDATE/DELETE with named bindings.
     * Returns 'noerror' on success.
     * @param string $sql
     * @param array  $bindings
     * @return string
     * @throws PDOException
     */
    public function otherBinded(string $sql, array $bindings): string {
        $this->db_connection();
        $this->sth = $this->conn->prepare($sql);
        foreach ($bindings as [$param, $val, $type]) {
            $pdoType = $type === 'int' ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->sth->bindValue($param, $val, $pdoType);
        }
        $this->sth->execute();
        return 'noerror';
    }
}
