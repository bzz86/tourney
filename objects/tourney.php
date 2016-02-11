<?php
class Tourney{
 
    // database connection and table name
    private $conn;
    private $table_name = "tourney";
 
    // object properties
    public $id;
    public $title;
	public $description;
	public $registration_start;
	public $registration_end;
 
    public function __construct($db){
        $this->conn = $db;
    }
 

    function readAll(){
        //select all data
        $query = "SELECT
                    id, title, description, registration_start, registration_end
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }
	
	function readOne(){
 
		$query = "SELECT
					id, title, description, registration_start, registration_end
				FROM
					" . $this->table_name . "
				WHERE
					id = ?
				LIMIT
					0,1";
	 
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
	 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		$this->id = $row['id'];
		$this->title = $row['title'];
		$this->description = $row['description'];
		$this->registration_start = $row['registration_start'];
		$this->registration_end = $row['registration_end'];
	}
	
	function getAllParticipants(){	
		$query = "SELECT
                    p.id, p.name, p.description, p.type
                FROM tourney_participant tp join 
                    participant p on tp.participant_id = p.id
				WHERE tp.tourney_id = ?	
                ORDER BY
                    p.name";  
 
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
        $stmt->execute();
 
        return $stmt;
	}
		
}	
?>
