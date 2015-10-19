<?php
	class SubMenuController extends Controller {
	
		public function SubMenuController(){
			parent::Controller();
		}
		
		/**
		 *@Privilege AUTHENTICATED
		 */
		public function algBrent(){
			return 'algoritmos/sidebar-left';
		}
	}
?>