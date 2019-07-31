<?php
class Lists {
	private $conn;
	private $table = 'list';

	public $black_url;
	public $white_url;
	public $user_id;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function read() {
		$sql = 'SELECT black_url, white_url FROM '.$this->table;
		
		$stmt = $this->conn->prepare($sql);

		$stmt->execute();

		return $stmt;
	}

	public function read_single() {
		$sql  = 'SELECT black_url, white_url FROM '.$this->table.' WHERE user_id = ? LIMIT 0,1';
	
		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(1, $this->user_id);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->black_url = $row['black_url'];
		$this->white_url = $row['white_url'];
	}

	public function create() {
		$sql = 'INSERT INTO '.$this->table.' SET 
			black_url = :black_url,
			white_url = :white_url,
			user_id = :user_id';

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':black_url', $this->black_url);
		$stmt->bindParam(':white_url', $this->white_url);
		$stmt->bindParam(':user_id', $this->user_id);

		if($stmt->execute()) {
			return true; 
		} else {
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}

	public function update($field) {

		$sql = 'UPDATE '.$this->table.' SET
			'.$field.' = :url 
			WHERE user_id = :user_id';

		$stmt = $this->conn->prepare($sql);

		if($field == 'black_url') {
			$stmt->bindParam(':url', $this->black_url);
		} else if($field == 'white_url') {
			$stmt->bindParam(':url', $this->white_url);
		}
		
		$stmt->bindParam(':user_id', $this->user_id);

		if($stmt->execute()) {
			return true; 
		} else {
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}
}