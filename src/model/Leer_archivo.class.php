<?php
	/* Class Leer_archivo.class.php
	*
	* Permite rescatar los resultados de los metodos, hubicados en un archivo de texto.
	*
	* Variables:
	*	* $resultado_final = Solucion final entregada por el método.
	*	* $p_nombre = (array)parametros que contienen el tipo de fundamento y metodo el archivo.
	*	* $p_entrada = (array)parametros de entrada.
	* 	* $resultados = matriz que almacenara los valores rescatados de la tabla de resultados del txt.
	*	* $txt = ruta del archivo de texto de salida.
	* Returns:
	*	* add_dolar: string (f(x): $x*log($x/3)-$x).
	*	* parametros_entrada: array (todos los parametros utilizados en el método).
	*	* tabla_resultados: array (todos los valores entregados por el método).
	* 
	*/
	
	class Leer_archivo{

		private  $resultado_final, $p_nombre, $p_entrada, $resultados, $txt;

		public function __construct($txt){
			$this->resultados = array();
			$this->p_nombre = array();
			$this->p_entrada = array();
			$this->txt = $txt;
		}

		/*Identifica los valores de entrada utilizados en el archivo de texto de salida.
		* Por orden, debe estar primero f(x), sino parametros puestos anterior a este, 
		* no serán identificados.*/
		public function parametros_entrada(){
			$myfile = fopen($this->txt, "r") or die("No se encuentra el archivo!");
			while(!feof($myfile)) {
				$string = fgets($myfile);
				/*Detecta F(x) que está estandarizado en todos los archivos de texto com el inicio de los parametros de entrada*/
				if(strncmp("f(x) =",$string,5) == 0){
					$i=0;
					while (1) {
						$j = 0;
						/*Validar si el primer caracter es un EOL*/
						if($string[0] == "\r" || $string[0] == "\n")break;
						/*Nombre del parametro*/
						$token = strtok($string, " ");
						$this->p_entrada[$i][$j] = $token;
						/*Valor del parametro*/
						$token = strtok(" = ");
						$token = strtok($token,"\r");
						/*Identifica f(x) para añadir el signo dolar ($)*/
						if (strtok($string, " ") == "f(x)") {
							$this->p_entrada[$i++][++$j] = $this->add_dolar($token.".");
						}else $this->p_entrada[$i++][++$j] = $token;
						$string = fgets($myfile);
					}
				break;	
				}
			}
			fclose($myfile);
			return $this->p_entrada;
		}

		/*Tabla de los resultados en el archivo de texto de salida*/
		public function tabla_resultados (){
			$i = $j = 0;
			$myfile = fopen($this->txt, "r") or die("No se encuentra el archivo!");
			while(!feof($myfile)) {
				$string = fgets($myfile);
				/*Encuentra el inicio de la tabla*/
				if(strncmp("Iteracion",$string,1) == 0){
					$token = strtok($string, "|");
					$token = strtok($token, " ");
					/*Ingresa los nombres de los parametros del metodo y los cuales son evaluados*/
					while ($token != false) {
						$this->resultados[$j][$i] = $token;
						$token = strtok(" ");
						if ($token != false) $i++;
						else $j++;
					}
					/*Tabla de resultados*/
					while(!feof($myfile)) {
						$i = 0;
						$string = fgets($myfile);
						/*Validar si el primer caracter es un EOL*/
						if($string[0] == "\r" || $string[0] == "\n")break;
						$token = strtok($string, "|");
						$token = strtok($token, " ");

						/*Final del archivo*/
						if(strncmp("La raíz aproximada",$string,1) == 0){
							$this->resultado_final = strtok($string, ":");
							$this->resultado_final = strtok(" ");
							$this->setResultado_final($this->resultado_final);
							break;
						}

						/*Separando resultados*/
						while ($token != false) {
							$this->resultados[$j][$i] = $token;
							$token = strtok(" ");
							if ($token != false) $i++;
							else $j++;
						}	
					}
					break;
				}
			}
			fclose($myfile);
			return $this->resultados;
		}

		/*Colocar signo dolar ($) en las x de la funcion f(x)*/
		private function add_dolar($str){
			$str1 = "a";/*Se instancia la variables, sino no funciona el método*/
			$i=$j=0;
			while(1){ 
				if ($str[$i] == 'x') {
					$str1[$j] = '$';
					$j++;
				}
				$str1[$j] = $str[$i];
				$i++;$j++;
				if ($str[$i]=='.') {break;}
			}
			return $str1; /*$x*log($x/3)-$x*/
		}

		/*
		* Reconoce el tipo de método y fundamento del archivo, los cuales se encuentra en la parte inicial del archivo.
		* 
		* return:
		* 	* $parametros: (array);
		*/
		public function p_nombre(){
			$myfile = fopen($this->txt, "r") or die("No se encuentra el archivo!");
			while(!feof($myfile)) {
				$string = fgets($myfile);
				/*Detecta F(x) que está estandarizado en todos los archivos de texto com el inicio de los parametros de entrada*/
				if(strncmp("fundamento =",$string,12) == 0){
					for ($i=0; $i < 2; $i++) {
						/*Validar si el primer caracter es un EOL*/
						if($string[0] == "\r" || $string[0] == "\n")break;
						/*Valor del parametro*/
						$token = strtok($string," ");
						$token = strtok("=");
						$token = strtok($token,"\r");
						$this->p_nombre[$i] = $this->dfspace(strtolower($token));
						$string = fgets($myfile);
					}
				break;
				}
			}
			fclose($myfile);
			return $this->p_nombre;
		}

		/*
		* Borra el primer espacio de un string que probiene de un txt.
		* (Esta función fue hecha para poder recibir correctamente el nombre del tipo de fundamento y método
		* proveniente del archivo de salida txt del método y luego poder crear los directorios con dicho nombre.)
		* dfspace -> delete first space.
		* returns:
		*	* mismo string sin el espacio de la primera posición.
		*/
		private function dfspace($string){
			$str = array();
			for ($i=1; $i < strlen($string) ; $i++) { 
				$str[$i-1] = $string[$i];
			}
			$str = implode("",$str);
			return $str;
		}

		private function setResultado_final($rf){
			$this->resultado_final = $rf;
		}
		public function getResultado_final(){
			return $this->resultado_final;
		}
	}
?>