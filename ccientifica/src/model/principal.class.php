<?php
	require_once "crear_archivos_directorios.class.php";
	require_once "grafico.class.php";

	/* main.class.php
	* 
	* Esta clase contiene las caracteristicas fundamentales para ejecutar todo tipo de algoritmo trabajado
	* en métodos numéricos. Los parámetros ingresados por el usuario, entran al constructor de esta clase
	* con el fin de buscar soluciones existentes o realizar nuevos resultados.
	* 
	* Variables:
	* 	* $rutaImg: Ruta localizada la imagen.
	* 	* $rutaArchivo: Ruta localizada el archivo.
	*   * $resultados: Matriz de los resultados arrojados por el método.
	* 	* $parametros: Matriz de los parametros utilizados en el método.
	* 	* $codigo: Conjunto de parametros ingresados por el usuario, fundamento y método matemático.
	*  
	* Returns:
	* 	* Busqueda_metodos_resueltos: Busca el $codigo en la db, y es true o false dependiendo de la existencia del archivo.
	* 	* exeComando: Define un comando el cual es ejecutado junto a los parametros ingresados por el usuario al método.
	* 	(Las siguientes funciones definidas como get, nos permite llevar los valores de las variables privadas a otras clases.
	* 	Este acto es por un motivo de buenas practicas, ya que todas las variables miembro de una clase son privadas y su valor
	* 	cambia según la operación solicitada dentro de ella).
	* 	* getRutaImg: $rutaImg.
	*  	* getRutaArchivo: $rutaArchivo.
	* 	* getResultados: $resultados.
	* 	* getParametros: $parametros.
	* 	* getCodigo: $codigo.
	* 
	*/

	class principal{

		private $rutaImg, $rutaArchivo, $resultados, $parametros, $codigo;

		/*
		* El constructor busca archivos generados previamente y si estos no existen, ejecuta el algoritmo
		* correspondiente con los parametros de entrada ingresados por el usuario.
		*/

		public function __construct($fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo){
			/*Codigo utilizado para validar si ya existe la solucion a estos parametros*/
			$codigo = $fx.$xi.$xf.$errto.$imax.$exeFundamento.$exeMetodo;
			$this->setCodigo($codigo);
			/*if ($this->Busqueda_metodos_resueltos($codigo)){
				$leer = new Leer_archivo($this->getrutaArchivo());
				$this->setResultados($leer->tabla_resultados());
				$this->setParametros($leer->parametros_entrada());
			}else{*/
			/*Ejecuta .exe desde la carpeta app*/
				$exeFile = fopen(LOAD_APP."/app/.cmmdexe", "r") or die("No se encuentra el archivo!");
				while ( !feof($exeFile)) {
					$string = fgets($exeFile);$token = strtok($string,"\\");$token = strtok(" ");$token = strtok($token,".");
					if (strncmp($exeMetodo,$token,strlen($exeMetodo)) == 0) {
						$this->setrutaArchivo($this->exeComando(LOAD_APP."/".$string, $fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo));
						$g = new grafico($this->getrutaArchivo());
						$this->setRutaImg($g->genGrafico());
						/**/
						$leer = new Leer_archivo($this->getrutaArchivo());
						$this->setResultados($leer->tabla_resultados());
						$this->setParametros($leer->parametros_entrada());
						break;
					}
				}
				fclose($exeFile);
			//}
		}

		/*
		* Buscar archivos e imagenes ya definidos por los parametros ingresados.
		* Variables:
		* 	- $codigo: contiene todos los parametros de entradas en un solo string.
		* Return:
		* 	- Bolean: true: Si encuentra el archivo, asigna la ruta del archivo y ruta de la imagen en las variables
		*			        miembro de la clase ($rutaImg, $rutaArchivo).
		*			  false: No encuentra nada. (Permite al constructor generar el archivo).
		*/
		/*private function Busqueda_metodos_resueltos($codigo){
			$File = fopen(CTX_PATH."/src/model/db.txt", "r") or die("No se encuentra el archivo!");
			while (!feof($File)) {
				$string = fgets($File);
				$token = strtok($string, "|");
				if ($codigo == $token) {
					$token = strtok("|");
					$this->setRutaImg($token);
					$token = strtok("\r");
					$this->setrutaArchivo($token);
					return true;
				}
			}
			return false;
		}*/

		/*
		* Esta función crea el comando esencial para ejecutar el archivo .exe con los parametros de entrada del usuario,
		* entregando un archivo de salida (.txt), con su ruta de almacenamiento, con los resultados en su interior.
		*/

		private function exeComando($string, $fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo){
			$nv = new crear_archivos_directorios();
			$nombre_archivo = $nv->nombre_archivo("cc", $exeFundamento, $exeMetodo,"out","txt",999);
			$string = strtok($string, "\r\n");
			$string = $string." \"".$fx."\" ".$xi." ".$xf." ".$errto." ".$imax." ".$nombre_archivo;
			$escaped_command = escapeshellcmd($string);
			/*Funcion que permite ejecutar un comando*/
			system($escaped_command);
			return $nombre_archivo;
		}

		private function setRutaImg($rutaImg){$this->rutaImg = $rutaImg;}
		public function getRutaImg(){return $this->rutaImg;}

		private function setrutaArchivo($rutaArchivo){$this->rutaArchivo = $rutaArchivo;}
		public function getrutaArchivo(){return $this->rutaArchivo;}

		private function setResultados($resultados){$this->resultados = $resultados;}
		public function getResultados(){return $this->resultados;}

		private function setParametros($parametros){$this->parametros = $parametros;}
		public function getParametros(){return $this->parametros;}

		private function setCodigo($codigo){$this->codigo = $codigo;}
		public function getCodigo(){return $this->codigo;}
	}
?>