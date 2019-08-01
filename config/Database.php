<?php
class Database {
    private $host = null;
    private $db_name = 'extension';
    private $username = 'root';
<<<<<<< HEAD
    private $password = 'iagily';
=======
    private $password = '61g4iagily';
>>>>>>> a9c55924b2278279adf515aa9b72b4d19c1056e2
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