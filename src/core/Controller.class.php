<?php
class Controller {

	protected $request;
	protected $session;
	protected $logger;

	public function Controller(){
		$this->request = Request::getInstance();
		$this->session = Session::getInstance();
		$this->logger = Logger::getLogger();
	}

}