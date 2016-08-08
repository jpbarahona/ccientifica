<?php

	/* Parametros_entrada_exe.class.php
	* 
	* Esta clase separa e identifica correctamente los parametros de entrada que
	* corresponde a cada ejecutador o programa.
	*/

	class Parametros_entrada_exe{

		public function __construct(){

		}

		public function entrada($p_entrada, $exeFundamento, $exeMetodo){

			switch ($exeFundamento) {
				case 'Ecuacion de raices':
					return $this->ecuacion_de_raices($p_entrada, $exeMetodo);
					break;
				
				case 'Ajuste de curvas':
					return $this->ajuste_de_curva($p_entrada, $exeMetodo);
					break;

				default:
					return "fundamento ingresado incorrecto";
					break;
			}

		}

		private function ecuacion_de_raices($p_entrada, $exeMetodo){
			//$string." '".$fx."' ".$xi." ".$xf." ".$errto." ".$imax
			switch ($exeMetodo) {
				case 'Biseccion':
					return " '".$p_entrada["fx"]."' ".$p_entrada["xi"]." ".$p_entrada["xf"]." ".$p_entrada["errto"]." ".$p_entrada["imax"];
					break;
				
				case 'Brent':
					return " '".$p_entrada["fx"]."' ".$p_entrada["xi"]." ".$p_entrada["xf"]." ".$p_entrada["errto"]." ".$p_entrada["imax"];
					break;

				case 'Punto_fijo':
					return " '".$p_entrada["fx"]."' ".$p_entrada["xi"]." ".$p_entrada["xf"]." ".$p_entrada["errto"]." ".$p_entrada["imax"];
					break;

				case 'Regla_falsa':
					return " '".$p_entrada["fx"]."' ".$p_entrada["xi"]." ".$p_entrada["xf"]." ".$p_entrada["errto"]." ".$p_entrada["imax"];
					break;

				case 'Secante':
					return " '".$p_entrada["fx"]."' ".$p_entrada["xi"]." ".$p_entrada["xf"]." ".$p_entrada["errto"]." ".$p_entrada["imax"];
					break;

				default:
					return "metodo ingresado incorrecto";
					break;
			}

		}

		private function ajuste_de_curva($p_entrada, $exeMetodo){
			switch ($exeMetodo) {
				case 'lagrange':
					return " '".$p_entrada["fx"]."' ".$p_entrada["x"]." ".$p_entrada["g"]." '".$p_entrada["xptos"]."'";
					break;

				case 'Regresion_lineal':
					return " ".$p_entrada["i"]." '".$p_entrada["x"]."' '".$p_entrada["y"]."'";
					break;
				
				default:
					return "metodo ingresado incorrecto";
					break;
			}
		}
	}