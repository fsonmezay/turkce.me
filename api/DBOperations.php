<?php

class DBOperations {

	public static $connection;

	public function connect() {
		if(!isset(self::$connection)) {
			try {
			     self::$connection = new mysqli('127.0.0.1', 'root', '123456', 'me_turkce');
			} catch (Exception $e ) {
			     echo "Service unavailable";
			     echo "message: " . $e->message;   // not in live code obviously...
			     exit;
			}

		}

		if(self::$connection === false) {
			return false;
		}
		self::$connection->set_charset("utf8");
		return self::$connection;
	}

	# close connection
	public function close_connection(){
		self::$connection->close();
	}

	public function escape($string) {
		return self::$connection->real_escape_string($string);
	}

	# update delete queries
	public function query($query) {
		try {
			return $this->connect()->query($query);
		} catch (Exception $e ) {
			echo "message: " . $e->message;   // not in live code obviously...
			exit;
		}
		//return $this->connect()->query($query);
	}

	public function lastInsertId() {
		return self::$connection->insert_id;
	}
	public function rowcount($query){
		return $this->query($query)->num_rows;
	}

	# selections only
	public function select($query) {
		$rows = array();
		$result = $this -> query($query);
		if($result === false) {
			return $rows;
		}
		while ($row = $result -> fetch_assoc()) {
			$rows[] = $row;
		}
		return $rows;
	}

	# quote strings
	public function quote($value) {
		$connection = $this -> connect();
		return "'" . $connection -> real_escape_string($value) . "'";
	}

	public function getById($tableName, $id){
		return $this->select("SELECT * from $tableName where id=$id");
	}

	public function getByFieldName($tableName, $fieldName, $fieldValue, $whereClause=""){
		$query = "SELECT * from $tableName where $fieldName='$fieldValue' $whereClause";
		return $this->select($query);
	}

	public function returnNextIdFromTable($tableName){
		$query = "SELECT max(id) as max from $tableName";
		$sonuc = $this->select($query);
		return $sonuc['max']+1;
	}

}

?>
