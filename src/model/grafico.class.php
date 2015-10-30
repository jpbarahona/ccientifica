<?php 
	$dir = "jpgraph/src/";
	require_once ($dir.'jpgraph.php');
	require_once ($dir.'jpgraph_line.php');
	require_once ($dir.'jpgraph_scatter.php');
	require_once ($dir.'jpgraph_regstat.php');

	require_once "Leer_archivo.class.php";
	require_once "eos-1.0.0/eos.class.php";

	/* Class grafico.class.php
	*
	* Esta clase permite graficar la solucion entregada por el algoritmo, leyendo los resultados
	* desde un archivo de texto como salida. Esta clase recibe los valores de los parametros de entrada
	* ingresados por el usuario, el nombre del fundamento y método, los cuales corresponden al txt de
	* solución y por ultimo la tabla de resultados obtenidos de él, junto con el resultado final.
	* 
	* Variables:
	* 	* $g: Objeto de la clase jpgraph.
	* 	* $xdata: (array)Contiene los puntos de x para lograr graficar la funcion f(x).
	* 	* $ydata: (array)Contiene los puntos en y, de los resultados de xdata en f(x).
	* 	* $leer: Objeto de la clase Leer_archivo.
	* 	* $p_nombre: (array)Contiene los parametros con los nombres del fundamento y método de solución
	* 				 del archivo de texto.
	* 	* $p_entrada: (array)Contiene los parametros de entrada que fueron ingresados por el usuario.
	* 	* $tabla_resultados: (array)Contiene todos los resultados de la tabla del txt.
	* 	* $txt: Ruta del archivo.
	* Returns:
	* 	* f: Valor parseado de f(x);
	* 	* genGrafico: Ruta de la imagen crada.
	* 
	*/
	class grafico extends crear_archivos_directorios{

		private $g, $xdata, $ydata, $leer, $p_nombre, $p_entrada, $tabla_resultados, $txt;

		public function __construct($txt){
			$this->txt = $txt;
			$this->xdata = array();
			$this->ydata = array();
			$this->p_nombre = array();
			$this->p_entrada = array();
			$this->tabla_resultados = array();

			/*=============================================================================*/
			/*Rescata los datos de la tabla de resultados expuesta por el método*/

			$this->leer = new Leer_archivo($this->txt);
			$this->tabla_resultados = $this->leer->tabla_resultados();
			$this->p_nombre = $this->leer->p_nombre();
			$this->p_entrada = $this->leer->parametros_entrada();
			/*=============================================================================*/
		}

		private function f($f,$x) {
			eval("\$fx = \"$f\";");
			$eq = new eqEOS();
			return $eq->solveIF($fx);
		}

		/*
		* Genera la imagen y retorna la ruta.
		*/

		public function genGrafico(){

			$xinicio = $this->p_entrada[1][1];
			$xfin = $this->p_entrada[2][1];

			// 	END PARAMETROS
			$val = 0;

			for($i = $xinicio; $i <= $xfin; $i+=0.1){
				$this->xdata[$val] = $i;
				$this->ydata[$val] = $this->f($this->p_entrada[0][1],$i);
				$val++;	
			}

			// Create the graph
			$this->g = new Graph(800,600);
			$this->g->SetMargin(30,20,40,30);
			$this->g->title->Set("Grafico de F(x)");

			$this->g->subtitle->Set('(Puntos de intervalo en azul)');
			$this->g->subtitle->SetColor('darkred');
			$this->g->SetMarginColor('lightblue');

			$this->g->SetScale('int');

			$lplot = new LinePlot($this->ydata,$this->xdata);
			$this->g->Add($lplot);

			for ($i=1; $i < count($this->tabla_resultados); $i++) { 
				$pplot = new ScatterPlot(array($this->f($this->p_entrada[0][1], $this->tabla_resultados[$i][1]), 
											   $this->f($this->p_entrada[0][1],$this->tabla_resultados[$i][2])), 
				    					 array($this->tabla_resultados[$i][1],$this->tabla_resultados[$i][2]));
				$this->g->Add($pplot);
				$pplot->SetImpuls();
			}

			$img = time().'test22gr.jpg';
			$ruta = $this->directorios(SAVE_IMAGEN."\\".$this->p_nombre[0]."\\".$this->p_nombre[1]).$img;
			$string = $this->p_nombre[0];
			for ($i=0; $i < strlen($string) ; $i++) { 
				if ($string[$i] == " ") $string[$i] = "_";
			}
			$rutaImg = "../../src/model/img/".$string."/".$this->p_nombre[1]."/".$img;
			$this->g->Stroke($ruta);
			
			return $rutaImg;
		}
	}

?>

