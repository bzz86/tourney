<?php
class Database{

	public $connection;

	//Connect with database for mysql database
	public function __construct($host, $user, $pass, $db)
	{
		$this->connection = new mysqli($host,$user,$pass);

		$CreateDBsql = "CREATE DATABASE IF NOT EXISTS $db";
		
		// Create Database
		if($this->connection->query($CreateDBsql) === TRUE){
			echo "Database Created succefully! <br>";
		}else{
			echo "Error creating database:".$this->connection->error;
		}

		$this->connection->select_db($db);

		//Check Connection
		if($this->connection->connect_errno){
			die("Connection Fail ".$this->connection->connect_error);
		}
		else{
			echo "Connection is ok <br>";
		}
	}// End of constructor


	//Function to Create Table
	public function CreateTable($sql){
		//Create Table
		if ($this->connection->query($sql) === TRUE) {
		    echo "Table has been created successfully";
		} else {
		    echo "Error to creating table: ".$this->connection->error;
		}
		echo "<br>";
	}//End of function CreateTable



	//Fetch data by accepting table name and columns(1 dimentional array) name
	public function fetch($table, array $columns){
		$columns=implode(",",$columns);
		$result=$this->connection->query("SELECT $columns FROM $table");
	
		if($this->connection->errno){
			die("Fail Select ".$this->connection->error);
		}

		//return tow dimentional array as required columns result
		return $result->fetch_all(MYSQLI_ASSOC);
	}




	# Insert Data within table by accepting TableName and Table column => Data as associative array
	public function insert($tblname, array $val_cols){

		$keysString = implode(", ", array_keys($val_cols));

		$i=0;
		foreach($val_cols as $key=>$value) {
			$StValue[$i] = "'".$value."'";
		    $i++;
		}

		$StValues = implode(", ",$StValue);
		
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		//Perform Insert operation
		if($this->connection->query("INSERT INTO $tblname ($keysString) VALUES ($StValues)") === TRUE){
			echo "New record has been inserted successfully!";
		}else{
			echo "Error ".$this->connection->error;
		}
		echo "<br>";
	}//End of function insert




	//Delete data form table; Accepting Table Name and Keys=>Values as associative array
	public function delete($tblname, array $val_cols){
		//Append each element of val_cols associative array 
		$i=0;
		foreach($val_cols as $key=>$value) {
			$exp[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stexp = implode(" AND ",$exp);

		//Perform Delete operation
		if($this->connection->query("DELETE FROM $tblname WHERE $Stexp") === TRUE){
			if(mysqli_affected_rows($this->connection)){
				echo "Record has been deleted successfully<br>";
			}
			else{
				echo "The Record you want to delete is no loger exists<br>";
			}
		}
		else{
			echo "Error to delete".$this->connection->error;
		}
		echo "<br>";	
	}




	//Update data within table; Accepting Table Name and Keys=>Values as associative array
	public function update($tblname, array $set_val_cols, array $cod_val_cols){
		
		//append set_val_cols associative array elements 
		$i=0;
		foreach($set_val_cols as $key=>$value) {
			$set[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stset = implode(", ",$set);

		//append cod_val_cols associative array elements
		$i=0;
		foreach($cod_val_cols as $key=>$value) {
			$cod[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stcod = implode(" AND ",$cod);

		//Update operation
		if($this->connection->query("UPDATE $tblname SET $Stset WHERE $Stcod") === TRUE){
			if(mysqli_affected_rows($this->connection)){
				echo "Record updated successfully<br>";
			}
			else{
				echo "The Record you want to updated is no loger exists<br>";
			}
		}else{
			echo "Error to update".$this->connection->error;
		}
	}

	//Call destructor function 
	public function __destruct() {
		if($this->connection){
			// Close the connection
        	$this->connection->close();
        	echo "Connection is release";
        }	
	}

}//end of class


// Create Connection
$obj = new Database("localhost","root","","student_info");



// Assign table name
$tablename = "student";

// Create table query
$CreateTableSql = "CREATE TABLE $tablename(Roll INT,Name CHAR(50),Marks DOUBLE)";

//Call Create Table
$obj->CreateTable($CreateTableSql);


//Associative array for insert function
$InsColumnVal = array("Roll"=>4,"Name"=>'Zahan',"Marks"=>64.8);

//Call insert function to insert record
$obj->insert($tablename, $InsColumnVal);


//Associative array for delete function
$DelColumnVal = array("Roll"=>4,"Name"=>'Zahan');

//Call Delete function
$obj->delete($tablename, $DelColumnVal);


//Associative array to set query for update function
$set = array("Roll"=>5,"Marks"=>75.3);

//Associative array to condition query for update function
$condition = array("Roll"=>3,"Name"=>'Hatim');

//call update function
$obj->update($tablename, $set,$condition);


// Fetch data from the table
$show = $obj->fetch($tablename, array("Roll","Name","Marks"));

// Show data from table
echo "<pre>";
print_r($show);
echo "</pre>";

?>