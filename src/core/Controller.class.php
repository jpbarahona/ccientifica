<?php
class Controller {

	protected $request;

	public function Controller(){
		$this->request = Request::getInstance();
	}

}