<?php
class UsuarioDAO {
	
	private $connection;
	protected $logger;
	
	public function __construct(){
		$this->connection = new DataSource();
		$this->logger = Logger::getLogger();
	}
	
	public function isActive($user, $pass){
		$pass = hash('sha256', $pass);
		$query = 'SELECT id FROM usuario '."WHERE rut='$user' AND pass='$pass'";
		$this->logger->debug($query);
		$result = $this->connection->query($query);
		return $result;
	}
	
}