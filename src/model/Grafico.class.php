<?php

	$dir = "jpgraph/";
	require_once ($dir.'jpgraph.php');
	require_once ($dir.'jpgraph_line.php');
	require_once ($dir.'jpgraph_scatter.php');
	require_once ($dir.'jpgraph_regstat.php');

	require_once "Crear_archivos_directorios.class.php";
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

	class Grafico{

		private $xdata, $ydata, $p_nombre, $p_entrada, $tabla_resultados, $leer, $cad;

		public function __construct($p_nombre, $p_entrada, $tabla_resultados){
			$this->xdata = array();
			$this->ydata = array();
			$this->p_nombre = $p_nombre;
			$this->p_entrada = $p_entrada;
			$this->tabla_resultados = $tabla_resultados;

			$this->cad = new Crear_archivos_directorios();
		}

		/*Colocar signo dolar ($) en las x de la funcion f(x)*/
		private function add_dolar($str){
			$str1 = "a";/*Se instancia la variables, sino no funciona el método*/
			$j=0;
			for ($i=0; $i < strlen($str); $i++) { 
				if ($str[$i] == 'x') {
					$str1[$j] = '$';
					$j++;
				}
				$str1[$j] = $str[$i];
				$j++;
			}
			//echo $str1."</br>";
			return $str1; /*$x*log($x/3)-$x*/
		}

		private function f($f,$x) {
			$f = $this->add_dolar($f);
			eval("\$fx = \"$f\";");
			$eq = new eqEOS();
			return $eq->solveIF($fx);
		}

		/*
		* Genera la imagen y retorna la ruta.
		*/

		public function genGrafico(){

			return $this->fundamento($this->cad->union($this->p_nombre[0]), $this->cad->union($this->p_nombre[1]));

		}

		/*
		* Función que dependiendo del fundamento y método ingresado, retorna la ruta de la imagen correspondiente,
		* por medio de un switch.
		*/

		private function fundamento($fundamento, $metodos){

			switch ($fundamento) {
				case 'ecuacion_de_raices':{
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
					$g = new Graph(800,600);
					$g->SetMargin(30,20,40,30);
					$g->title->Set("Grafico de F(x)");

					$g->subtitle->Set('(Puntos de intervalo en azul)');
					$g->subtitle->SetColor('darkred');
					$g->SetMarginColor('lightblue');

					$g->SetScale('int');

					// We want 1 decimal for the X-label
					$g->xaxis->SetLabelFormat('%1.0f');

					$lplot = new LinePlot($this->ydata, $this->xdata);
					$g->Add($lplot);

					for ($i=1; $i < count($this->tabla_resultados); $i++) { 
						$pplot = new ScatterPlot(array($this->f($this->p_entrada[0][1], $this->tabla_resultados[$i][1]), 
													   $this->f($this->p_entrada[0][1], $this->tabla_resultados[$i][2])), 
						    					array($this->tabla_resultados[$i][1], $this->tabla_resultados[$i][2]));
						$g->Add($pplot);
						$pplot->SetImpuls();
					}
					
					$img = time().'test22gr.png';
					$rutaImg = $this->cad->directorios(SAVE_IMAGEN."/".$this->p_nombre[0]."/".$this->p_nombre[1])."/".$img;
					$g->Stroke($rutaImg);

					return $this->cad->union(LOAD_IMG."/".$this->p_nombre[0]."/".$this->p_nombre[1])."/".$img;
				}break;
				
				case 'ajuste_de_curvas':{

					$xinicio = -5;
					$xfin = 5;
					
					// Create the graph
					$g = new Graph(800,600);
					$g->SetMargin(30,20,40,30);
					$g->title->Set("Grafico de F(x)");

					$g->subtitle->Set('(Puntos de intervalo en azul)');
					$g->subtitle->SetColor('darkred');
					$g->SetMarginColor('lightblue');

					$g->SetScale('int');

					// We want 1 decimal for the X-label
					$g->xaxis->SetLabelFormat('%1.0f');

					$val = 0;

					for($i = $xinicio; $i <= $xfin; $i+=0.1){
						$this->xdata[$val] = $i;
						$this->ydata[$val] = $this->f($this->tabla_resultados[1][3],$i);
						$val++;	
					}

					$lplot = new LinePlot($this->ydata, $this->xdata);
					$g->Add($lplot);

					$val = 0;

					for($i = $xinicio; $i <= $xfin; $i+=0.1){
						$this->xdata[$val] = $i;
						$this->ydata[$val] = $this->f($this->tabla_resultados[2][3],$i);
						$val++;	
					}

					$lplot = new LinePlot($this->ydata, $this->xdata);
					$g->Add($lplot);
					
					$img = time().'test22gr.png';
					$rutaImg = $this->cad->directorios(SAVE_IMAGEN."/".$this->p_nombre[0]."/".$this->p_nombre[1])."/".$img;
					$g->Stroke($rutaImg);

					return $this->cad->union(LOAD_MODEL."/img/".$this->p_nombre[0]."/".$this->p_nombre[1])."/".$img;
				}break;

				default:
					# code...
					break;
			}
		}
	}