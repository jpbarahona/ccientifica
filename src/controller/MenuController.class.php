<?php
	class MenuController extends Controller {
	
		public function MenuController(){
			parent::Controller();
		}
		public function index(){
			return 'index';
		}
		public function Biseccion(){
			return 'algoritmos/raices-de-ecuaciones/biseccion';
		}
		public function Brent(){
			return 'algoritmos/raices-de-ecuaciones/brent';
		}
		public function Secante(){
			return 'algoritmos/raices-de-ecuaciones/secante';
		}
		public function Punto(){
			return 'algoritmos/raices-de-ecuaciones/puntofijo';
		}
		public function Falsa(){
			return 'algoritmos/raices-de-ecuaciones/reglafalsa';
		}
 		/*Curvas*/
		public function Polinomial(){
			return 'algoritmos/ajustes-de-curvas/polinomial';
		}
		public function Lineal(){
			return 'algoritmos/ajustes-de-curvas/lineal';
		}
		public function Newton(){
			return 'algoritmos/ajustes-de-curvas/newton';
		}
		public function Discretos(){
			return 'algoritmos/ajustes-de-curvas/discretos';
		}
		public function Continuos(){
			return 'algoritmos/ajustes-de-curvas/continuos';
		}
		public function Lagrange(){
			return 'algoritmos/ajustes-de-curvas/lagrange';
		}
		public function Spline(){
			return 'algoritmos/ajustes-de-curvas/spline';
		}			
		/*Otros*/
		public function Euler(){
			return 'algoritmos/optimizacion/euler';
		}
		public function Runge(){
			return 'algoritmos/ecuacion-diferencial/runge';
		}
		public function Heun(){
			return 'algoritmos/ecuacion-diferencial/heun';
		}
	}
?>
