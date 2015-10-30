<?php
	class MenuController extends Controller {
	
		public function MenuController(){
			parent::Controller();
		}
		
		/**
		 *@Privilege AUTHENTICATED
		 */
		public function index(){
			return 'index';
		}
	}
?>