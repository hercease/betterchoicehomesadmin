<?php

class Database {
    private $conn;

    public function connect() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}

?>
