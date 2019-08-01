<?php
class Database {
    private $host = '35.201.195.234';
    private $db_name = 'extension';
    private $username = 'root';
    private $password = 'iagily';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}",  $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connect error: '.$e->getMessage();
        }

        return $this->conn;
    }
}