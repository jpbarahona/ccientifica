<?php
	/* Class crear_archivos_directorios.class.php
	* 
	* Esta clase permite generar archivos nuevos de salida para los métodos, mediante el ingreso de
	* nuevos parámetros (nombre_archivo ($lenguaje, $exeFundamento, $exeMetodo, $stream, $ext, $count)).
	* También genera y organiza directorios con los fundamentos y métodos matematicos respectivos,
	* correspondientes al archivo de salida (directorios($ruta)).
	* 
	* Returns:
	*	* nombre_archivo: El nombre y ruta destinada del archivo.
	*	* digitos: El número del archivo.
	*	* directorios: Ruta validada si los directorios existen, de lo contrario los crea.
	*	* fundamento: Las primeras tres letras iniciales del fundamento.
	*	* metodo: Las primeras dos letras iniciales del método.
	* 
	*/
	class crear_archivos_directorios{

		public function __construct(){

		}

		/*
		* Define el nombre del archivo para el nuevo resultado del algoritmo. Utiliza el siguiente criterio: 
		* "Direcotorio""lenguaje""fundamento""método""n°fichero""stream""extencion"
		* 
		* Ejemplo: CCERBI000OUT.txt -  CCERBI000OUT.php - CCERBI000OUT.py ...
		* 
		* dirMetodo: Directorio salida.
		* name: Nombre inicial del fichero. ("lenguaje""fundamento""método")
		*/
		public function nombre_archivo ($lenguaje, $exeFundamento, $exeMetodo, $stream, $ext, $count){
			
			$str = $lenguaje.$this->fundamento($exeFundamento).$this->metodo($exeMetodo)."000";
			$str2 = strtoupper($stream).".".$ext;
			
			$str1 = $this->directorios($_SERVER['DOCUMENT_ROOT']."\\ccientifica.\\src\\model\\app\\out\\".strtolower($exeFundamento)."\\".strtolower($exeMetodo)).strtoupper($str);
			$salida = $str1.$str2;
			$len = strlen($str1);

			$salida[$len-3] = '0';
			$salida[$len-2] = '0';
			$salida[$len-1] = '1';

			for ($i = 1; $i <= $count; ++$i){
				$c = $this->digitos(3,$i+1,$i);
				$salida[$len-3] = $c[0];
				$salida[$len-2] = $c[1];
				$salida[$len-1] = $c[2];
				if ($txtFile = @fopen($salida, "x")){
					fclose($txtFile);
					break;
				}
			}
			
			return $salida;
		}

		/*
		* Determina el numero correspondiente al nuevo archivo de texto
		*/
		private function digitos ($dig_len, $limit, $start){
			$i = $start;
			$n = $limit;
			$c = array();

			if(($start/10)%10 < 10 && ($start/10)%10 > 0){
				$c[1] = ($start/10)%10 +'0';
			}else $c[1] = '0';
			if($start/100 < 10 && $start/100 > 0){
				$c[0] = $start/100 +'0';
			}else $c[0] = '0';
			if($i%10 == 0){ $c[2] = '0'; return $c;}
			else{
				$i = $i%10;
				$j = ($start/10)%10 * 10 ;
				$n = $n-$j;
				if($start/100>0){
					$p = ($start/100)%10 * 100 ;
					$n = $n - $p;
				}
			}
			while ($i<$n){
				$c[2] = $i+'0';
				if($c[2] == '9' && $i+1 != $n){
					if($c[1] == '9' && $i+1 != $n)
					{
						$c[1] = '0';
						$c[0] ++;
					}else $c[1] ++;
					$i = -1;
					$n = $n-10;
				}
				$i++;
			}
			return $c;
		}

		/*
		* Esta función valida y genera si los directorios ingresados no existen.
		*/
		protected function directorios($ruta){
			$token = strtok($ruta,"\\");
			$token = $this->union($token);
			$rutav = $token."\\";
			$token = strtok("\\");
			while ($token!=false) {
				$token = $this->union($token);
				$rutav = $rutav.$token."\\";
				@mkdir($rutav."\\", 0755,true);
				$token = strtok("\\");
			}
			for ($i=0; $i < strlen($rutav); $i++) { 
				if ($rutav[$i] == "\\") {
					$rutav[$i] = "/";
				}
			}
			return $rutav;
		}

		/*
		* Remplazar las palabras con el guion bajo si existe un espacio, motivo para crear carpeta con dicho nombre.
		*/
		public function union($string){
			for ($i=0; $i < strlen($string) ; $i++) { 
				if ($string[$i] == " ") $string[$i] = "_";
			}
			return $string;
		}

		/*
		* Retorna para el nombre del archivo las primeras 3 letras del fundamento.
		*/
		private function fundamento($exeFundamento){
			return $exeFundamento[0].$exeFundamento[1].$exeFundamento[2];
		}

		/*
		* Retorna para el nombre del archivo las primeras 2 letras del método.
		*/
		private function metodo($exeMetodo){
			return $exeMetodo[0].$exeMetodo[1];
		}
	}

?>