<?php
class Database {
    private $host = null;
    private $db_name = 'extension';
    private $username = 'root';
    private $password = '61g4iagily';
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