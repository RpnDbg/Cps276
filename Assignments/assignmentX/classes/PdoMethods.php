<?php
require_once 'Db_conn.php';

class PdoMethods extends Db_conn {

    public function selectBinded($sql, $bindings) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        foreach ($bindings as $binding) {
            $stmt->bindValue($binding[0], $binding[1], PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function otherBinded($sql, $bindings) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        foreach ($bindings as $binding) {
            $stmt->bindValue($binding[0], $binding[1], PDO::PARAM_STR);
        }
        if ($stmt->execute()) return true;
        else return "error";
    }
}
