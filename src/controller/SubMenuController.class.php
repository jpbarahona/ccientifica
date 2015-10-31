<?php
	class SubMenuController extends Controller {
	
		public function SubMenuController(){
			parent::Controller();
		}
		
		/**
		 *@Privilege AUTHENTICATED
		 */
		public function algBrent(){
			return 'ecuaciones-no-lineales/brent';
		}
		public function algBiseccion(){
			return 'ecuaciones-no-lineales/biseccion';
		}
		public function algSecante(){
			return 'ecuaciones-no-lineales/secante';
		}
		public function algPuntoFijo(){
			return 'ecuaciones-no-lineales/punto-fijo';
		}
		public function algReglaFalsa(){
			return 'ecuaciones-no-lineales/regla-falsa';
		}
	}
?>