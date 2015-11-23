<?php
class DataSource {
	
	static private $conn;
	
	public function __construct(){
	}
	
	private function open(){
		self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if (self::$conn->connect_errno) {
			die("Connect failed: ".self::$conn->connect_error);
		}
		return self::$conn;
	}
	
	public function query($sql){
		$this->open();
		$sqlType = $this->getSqlType($sql);
		switch ($sqlType) {
			case 'SELECT': { $result = $this->select($sql); break; }
			default: { $result = $this->sql($sql); break; }
		}
		$this->close();
		return $result;
	}
	
	private function getSqlType($sql){
		$tmp = explode(" ", $sql); return $tmp[0];
	}
	
	private function select($sql){
		$result = array();
		$query = self::$conn->query($sql);
		if ($query){ while ($row = $query->fetch_assoc()){ $result[] = $row; } }
		return $result;
	}
	
	private function sql($sql){
		return self::$conn->query($sql);
	}
	
	private function close(){
		return self::$conn->close();
	}
	
}