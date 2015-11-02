<?php
	class MenuController extends Controller {
	
		public function MenuController(){
			parent::Controller();
		}
		public function index(){
			return 'index';
		}
		public function algBrent(){
			return 'example';
		}
		public function repost(){
			return 'repost';
		}
			public function calculator(){
			return 'sidebar-left';
		}
	}
?>