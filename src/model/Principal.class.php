<?php
	require_once "Leer_archivo.class.php";
	require_once "Parametros_entrada_exe.class.php";
	require_once "Crear_archivos_directorios.class.php";
	require_once "Grafico.class.php";

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
	* 	* getTabla_resultados: $tabla_resultados.
	* 	* getParametros_entrada: $parametros_entrada.
	* 	* getCodigo: $codigo.
	* 
	*/

	class Principal{

		private $rutaImg, $rutaArchivo,$parametros_nombre ,$parametros_entrada ,$tabla_resultados ,$codigo;

		/*
		* El constructor busca archivos generados previamente y si estos no existen, ejecuta el algoritmo
		* correspondiente con los parametros de entrada ingresados por el usuario.
		*/

		public function __construct($p_entrada, $exeFundamento, $exeMetodo){
			/*Codigo utilizado para validar si ya existe la solucion a estos parametros*/
			$codigo = $this->make_codigo($p_entrada);
			$this->setCodigo($codigo);
			/*Ejecuta .exe desde la carpeta app*/
			$exeFile = fopen(LOAD_MODEL."/app/.cmmdexe", "r") or die("No se encuentra el archivo!");
			while ( !feof($exeFile)) {
				$string = fgets($exeFile);$token = strtok($string,"/");
				$token = strtok(" ");
				$token = strtok($token,".");
				if (strncmp($exeMetodo,$token,strlen($exeMetodo)) == 0) {
					$this->setrutaArchivo(
						$this->exeComando($string, $p_entrada, $exeFundamento, $exeMetodo)
					);
					/**
					 * Se generan tablas e imágenes para métodos númericos de caracteristicas de Eciaciones de raíces y solo Lagrange para Ajuste de curvas
					 */ 
					if ($exeFundamento == "Ecuacion de raices" || $exeMetodo == "Lagrange"){
						$leer = new Leer_archivo($this->getrutaArchivo());
						$this->setParametros_nombre($leer->parametros_nombre());
						$this->setParametros_entrada($leer->parametros_entrada());
						$this->setTabla_resultados($leer->tabla_resultados());
						$g = new grafico($this->getParametros_nombre(), $this->getParametros_entrada(), $this->getTabla_resultados());
						$this->setRutaImg($g->genGrafico());
					}
					break;
				}
			}
			fclose($exeFile);

			/**
			 * Encontrar métodos resueltos. Preferible realizarlo directamente por BBDD.

			if ($this->Busqueda_metodos_resueltos($codigo)){
				$leer = new Leer_archivo($this->getrutaArchivo());
				$this->setResultados($leer->tabla_resultados());
				$this->setParametros($leer->parametros_entrada());
			}else{
				$exeFile = fopen(LOAD_MODEL."/app/.cmmdexe", "r") or die("No se encuentra el archivo!");
				while ( !feof($exeFile)) {
					$string = fgets($exeFile);$token = strtok($string,"/");$token = strtok(" ");$token = strtok($token,".");
					if (strncmp($exeMetodo,$token,strlen($exeMetodo)) == 0) {
						$this->setrutaArchivo($this->exeComando($string, $p_entrada, $exeFundamento, $exeMetodo));
						$leer = new Leer_archivo($this->getrutaArchivo());
						$this->setParametros_nombre($leer->parametros_nombre());
						$this->setParametros_entrada($leer->parametros_entrada());
						$this->setTabla_resultados($leer->tabla_resultados());
						$g = new grafico($this->getParametros_nombre(), $this->getParametros_entrada(), $this->getTabla_resultados());
						$this->setRutaImg($g->genGrafico());
						break;
					}
				}
				fclose($exeFile);
			}*/
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

		private function Busqueda_metodos_resueltos($codigo){
			$File = fopen(LOAD_MODEL."/db.txt", "r") or die("No se encuentra el archivo!");
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
		}

		/*
		* Esta función crea el comando esencial para ejecutar el archivo .exe con los parametros de entrada del usuario,
		* entregando un archivo de salida (.txt), con su ruta de almacenamiento, con los resultados en su interior.
		*/

		private function exeComando($string, $p_entrada, $exeFundamento, $exeMetodo){
			$nv = new Crear_archivos_directorios();
			$nombre_archivo = $nv->nombre_archivo("cc", $exeFundamento, $exeMetodo,"out","txt",9999999);
			$pee = new Parametros_entrada_exe();
			$string = strtok($string, "\r\n");
			$string = $this->directorioexe($string, $exeFundamento);
			$string = "./".$string.$pee->entrada($p_entrada, $exeFundamento, $exeMetodo)." ".$nombre_archivo;
			system($string);
			return $nombre_archivo;
		}

		private function directorioexe($string, $exeFundamento){
			$nv = new Crear_archivos_directorios();
			$token = strtok($string, "/");
			$string = LOAD_ALG."/exe-".$nv->union($exeFundamento)."/".strtok(" ");

			return $string;
		}

		private function make_codigo($p_entrada){

			$string = "";

			foreach ($p_entrada as $key => $value) {
				$string = $string.$value;
			}

			return $string;

		}

		private function setRutaImg($rutaImg){$this->rutaImg = $rutaImg;}
		public function getRutaImg(){return $this->rutaImg;}

		private function setrutaArchivo($rutaArchivo){$this->rutaArchivo = $rutaArchivo;}
		public function getrutaArchivo(){return $this->rutaArchivo;}

		private function setParametros_nombre($parametros_nombre){$this->parametros_nombre = $parametros_nombre;}
		public function getParametros_nombre(){return $this->parametros_nombre;}

		private function setParametros_entrada($parametros_entrada){$this->parametros_entrada = $parametros_entrada;}
		public function getParametros_entrada(){return $this->parametros_entrada;}

		private function setTabla_resultados($tabla_resultados){$this->tabla_resultados = $tabla_resultados;}
		public function getTabla_resultados(){return $this->tabla_resultados;}

		private function setCodigo($codigo){$this->codigo = $codigo;}
		public function getCodigo(){return $this->codigo;}
	}