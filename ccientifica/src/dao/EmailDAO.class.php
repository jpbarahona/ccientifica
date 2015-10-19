<?php

class EmailDAO {
	
	private $idfecha;
	private $email;
	
	private $connection;
	protected $logger;
	
	public function __construct(){
		$this->connection = new DataSource();
		$this->logger = Logger::getLogger();
	}
	
	public function addEmail ($email){
		if(!$this->ExisteEmail($email)){
			if($this->buscarFecha()){
				$query = "INSERT INTO email (email,fecha_idfecha) VALUES('$email','$this->idfecha');";
			}else{
				$this->addFecha();
				$query = "INSERT INTO email (email,fecha_idfecha) VALUES('$email','$this->idfecha');";
			}
			$this->logger->getLogger($query);
			$result= $this->connection->query($query);

			return $result;
		}
	}
	
	private function addFecha (){
		
		$fecha 	= date("Y-m-d");
		$dia 	= date("l");
		$mes 	= date("m");
		$anho 	= date("Y");
		
		$query = "INSERT INTO fecha (fecha, dia, mes, anho) VALUES ('$fecha','$dia','$mes','$anho');";
		$this->logger->getLogger($query);
		$result= $this->connection->query($query);
		
		$this->buscarFecha();
	}
	
	private function buscarFecha(){
		$fecha 	= date("Y-m-d");
		
		$sql = 'SELECT idfecha, fecha, dia, mes, anho FROM fecha '."WHERE fecha = '$fecha'";
		
		$result = $this->connection->query($sql);
		if($this->idfecha = $result[0]["idfecha"]){
			return true;
		}else{
			return false;
		}
	}
	
	private function ExisteEmail($email){
		$sql = 'SELECT idemail, email, fecha_idfecha FROM email '."WHERE email = '$email'";
		
		$result = $this->connection->query($sql);
		if ($result) {
			return true;
		}else{
			return false;
		}
		$this->connection->close();
	}
	
}