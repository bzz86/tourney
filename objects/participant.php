<?php
class Participant{
 
    // database connection and table name
    private $conn;
    private $table_name = "participant";
 
    // object properties
    public $id;
    public $name;
	public $tourney_id;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // create participant
    function create(){
 
        // to get time-stamp for 'created' field
        //$this->getTimestamp();
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name = ?, type = ?";
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->type);
        //$stmt->bindParam(3, $this->description);
        //$stmt->bindParam(4, $this->category_id);
        //$stmt->bindParam(5, $this->timestamp);
 
        if($stmt->execute()){
			$this->id = $this->conn->lastInsertId('id');
            return true;
        }else{
            return false;
        }
 
    }
	

	function update(){
	 
		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
					type = :type,
					tourney_id  = :tourney_id
				WHERE
					id = :id";
	 
		$stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':tourney_id', $this->tourney_id);
		$stmt->bindParam(':id', $this->id);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
		
	function assignToTourney($tourney_id){
		$query = "INSERT INTO
                    tourney_participant
                SET
                    participant_id = ?, tourney_id = ?";
	 
		$stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $tourney_id);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			echo "id:{$this->id}";
			echo "tourneyid: {$tourney_id}";
			print_r($this->conn->errorInfo());
			return false;
		}
		
	}	
		
	function readAll($page, $from_record_num, $records_per_page){
 
		$query = "SELECT
					id, name
				FROM
					" . $this->table_name . "
				ORDER BY
					name ASC
				LIMIT
					{$from_record_num}, {$records_per_page}";
	 
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
	 
		return $stmt;
	}	
	
	function readOne(){
 
		$query = "SELECT
					name, price, description, category_id
				FROM
					" . $this->table_name . "
				WHERE
					id = ?
				";
	 
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
	 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		$this->name = $row['name'];
		$this->price = $row['price'];
		$this->description = $row['description'];
		$this->category_id = $row['category_id'];
	}
}
?>