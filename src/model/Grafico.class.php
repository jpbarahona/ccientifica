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
		public function graficarSPLINE($xdata, $ydata, $grado){
			switch($grado){
				case 0:{
					$spline = new Spline($xdata,$ydata);

					list($newx,$newy) = $spline->Get0();

					$linex = array();
					$liney = array();
					
					
					// Create the graph
					$g = new Graph(800,600);
					$g->SetMargin(30,20,40,30);
					$g->title->Set("SPline grado 0");
					//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
					$g->subtitle->Set('(Puntos ingresados en rojo)');
					$g->subtitle->SetColor('darkred');
					$g->SetMarginColor('lightblue');

					
					$g->SetScale('int');

					// We want 1 decimal for the X-label
					$g->xaxis->SetLabelFormat('%1.0f');

					
					$splot = new ScatterPlot($ydata,$xdata);
					$splot->mark->SetFillColor('red@0.3');
					$splot->mark->SetColor('red@0.5');

					foreach($xdata as $key => $x) {
						if(isset($xdata[$key+1])){
							$lplot[$key] = new LinePlot(array($ydata[$key],$ydata[$key]),array($xdata[$key],$xdata[$key+1]));
							$lplot[$key]->SetColor('#0000FF');
							$g->Add($lplot[$key] ); // lineas
						}
					}

					// Add the plots to the graph and stroke
					$g->Add($splot); // puntos
					
				}
				break;
				case 1:{
					// Create the graph
					$g = new Graph(800,600);
					$g->SetMargin(30,20,40,30);
					$g->title->Set("SPline grado 1");
					//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
					$g->subtitle->Set('(Puntos ingresados en rojo)');
					$g->subtitle->SetColor('darkred');
					$g->SetMarginColor('lightblue');

					//$g->img->SetAntiAliasing();

					// We need a linlin scale since we provide both
					// x and y coordinates for the data points.
					$g->SetScale('int');

					// We want 1 decimal for the X-label
					$g->xaxis->SetLabelFormat('%1.0f');

					// We use a scatterplot to illustrate the original
					// contro points.


					$splot = new ScatterPlot($ydata,$xdata);
					$splot->mark->SetFillColor('red@0.3');
					$splot->mark->SetColor('red@0.5');

					foreach($xdata as $key => $x) {
						if(isset($xdata[$key+1])){
							$a[$key] = ($ydata[$key+1] - $ydata[$key])/($xdata[$key+1] - $xdata[$key]);
							$lplot[$key] = new LinePlot(array($ydata[$key],$ydata[$key+1]),array($xdata[$key],$xdata[$key+1]));
							$lplot[$key]->SetColor('#0000FF');
							$g->Add($lplot[$key] ); // lineas
						}
					}
					$g->Add($splot); // puntos
				}
				break;
				case 3:{
					$spline = new Spline($xdata,$ydata);

					// For the new data set we want 40 points to
					// get a smooth curve.
					list($newx,$newy) = $spline->Get(50);

					// Create the graph
					$g = new Graph(800,600);
					$g->SetMargin(30,20,40,30);
					$g->title->Set("SPLine cúbico");
					//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
					$g->subtitle->Set('(Puntos ingresados en rojo)');

					$g->subtitle->SetColor('darkred');
					$g->SetMarginColor('lightblue');

					//$g->img->SetAntiAliasing();

					// We need a linlin scale since we provide both
					// x and y coordinates for the data points.
					$g->SetScale('int');

					// We want 1 decimal for the X-label
					$g->xaxis->SetLabelFormat('%1.1f');

					// We use a scatterplot to illustrate the original
					// contro points.
					$splot = new ScatterPlot($ydata,$xdata);

					// 
					$splot->mark->SetFillColor('red@0.3');
					$splot->mark->SetColor('red@0.5');

					// And a line plot to stroke the smooth curve we got
					// from the original control points
					$lplot = new LinePlot($newy,$newx);
					$lplot->SetColor('navy');

					// Add the plots to the graph and stroke
					$g->Add($lplot);
					$g->Add($splot);
				}
				break;

				

			}
			$nombrearchivo = implode($xdata).'-'.implode($ydata).'-'.time().'sp0.png';
				$name = SAVE_IMAGEN."/ajuste_de_curvas/SPline/".$nombrearchivo;
				if(!file_exists($name))
					$g->Stroke($name);

				$rutaImg = $this->cad->directorios(SAVE_IMAGEN."/ajuste_de_curvas/SPline/").$name;
					
				$larutaadevoilver =  "src/model/img/ajuste_de_curvas/SPline/".$nombrearchivo;
				echo '<img src="'.$larutaadevoilver.'" />';
		}
	}