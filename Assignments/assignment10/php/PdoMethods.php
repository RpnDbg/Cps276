<?php
// php/PdoMethods.php

require_once 'Db_conn.php';

class PdoMethods extends DatabaseConn {

    // Execute a SELECT query with no bindings
    public function selectNotBinded($sql) {
        $pdo = $this->dbOpen();
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (count($records) === 0 ? 'error' : $records);
        }
        catch (PDOException $e) {
            return 'error';
        }
    }

    // Execute a SELECT query with bound parameters
    public function selectBinded($sql, $bindings) {
        $pdo = $this->dbOpen();
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute($this->createBindingArray($bindings));
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (count($records) === 0 ? 'error' : $records);
        }
        catch (PDOException $e) {
            return 'error';
        }
    }

    // For INSERT, UPDATE, DELETE queries with bound parameters
    public function otherBinded($sql, $bindings) {
        $pdo = $this->dbOpen();
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute($this->createBindingArray($bindings));
            return 'success';
        }
        catch (PDOException $e) {
            return 'error';
        }
    }

    // Convert user-friendly binding array format into a PDO-ready array
    private function createBindingArray($bindings) {
        $bindingArray = array();
        foreach ($bindings as $value) {
            $bindingArray[$value[0]] = $value[1];
        }
        return $bindingArray;
    }
}
