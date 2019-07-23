<?php
class User {	
	private $conn;
	private $table = 'user';

	public $sn;
	public $id;
	public $password;
	public $email;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function read() {
		$sql = 'SELECT id, password, email FROM '.$this->table;
		
		$stmt = $this->conn->prepare($sql);

		$stmt->execute();

		return $stmt;
	}

	public function read_single() {
		$sql  = 'SELECT id, password, email FROM '.$this->table.' WHERE id = ? LIMIT 0,1';

		// Prepare statement
		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(1, $this->id);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->password = $row['password'];
		$this->email = $row['email'];
	}

	private function guid(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = chr(123)// "{"
	            .substr($charid, 0, 8).$hyphen
	            .substr($charid, 8, 4).$hyphen
	            .substr($charid,12, 4).$hyphen
	            .substr($charid,16, 4).$hyphen
	            .substr($charid,20,12)
	            .chr(125);// "}"
	        return $uuid;
	    }
	}

	public function create() {
		$sql = 'INSERT INTO '.$this->table.' SET 
			id = :id,
			password = :password,
			email = :email';

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':email', $this->email);

		if($stmt->execute()) {
			return true;
		} else {
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}

	public function update() {
		$sql = 'UPDATE '.$this->table.' SET			
			password = :password,
			email = :email
			WHERE id = :id';

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':email', $this->email);
		//$stmt->bindParam(':sn', $this->sn);

		if($stmt->execute()) {
			return true;
		} else {
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}

	public function delete() {
		$sql = 'DELETE FROM '.$this->table.' WHERE sn = :sn';

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':sn', $this->sn);

		if($stmt->execute()) {
			return true;
		} else {
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}
}