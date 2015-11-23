<?php

	class AlgoritmoController extends Controller{
		
		public function AlgoritmoController(){
			parent::Controller();
		}
		

		/**
		 * @ClassDependency: {'model.Principal'}
		 */
		/*'model.crear_archivos_directorios', 'model.grafico', 'model.Leer_archivo',*/

		public function exeMetodo(){
			
			$p_entrada = array();
			$p_entrada["fx"] = $this->request->getParam('fx');
			$p_entrada["xi"] = $this->request->getParam('xi');
			$p_entrada["xf"] = $this->request->getParam('xf');
			$p_entrada["errto"] = $this->request->getParam('errto');
			$p_entrada["imax"] = $this->request->getParam('imax');
			
			$exeFundamento = $this->request->getParam('exeFundamento');
			$exeMetodo = $this->request->getParam('exeMetodo');

			/*=============================================================================*/
			/*Ejecucion de los algoritmos y creacion de los resultados*/
			$main = new Principal($p_entrada, $exeFundamento, $exeMetodo);

			/*parametros de retorno y almacenamiento en la db.*/
			$result ['img'] = $main->getRutaImg();
			$result ['resultados'] = $main->getTabla_resultados();
			//$result ['archivo'] = $main->getRutaArchivo();
			/*=============================================================================*/

			return $result;
		}

		/**
		 * @ClassDependency: {'model.Principal'}
		 */
		public function exeLagrange(){
			$p_entrada = array();
			$p_entrada["fx"] = $this->request->getParam('fx');
			$p_entrada["x"] = $this->request->getParam('x');
			$p_entrada["g"] = $this->request->getParam('g');
			$p_entrada["xptos"] = $this->request->getParam('xptos');
			
			$exeFundamento = $this->request->getParam('exeFundamento');
			$exeMetodo = $this->request->getParam('exeMetodo');

			/*=============================================================================*/
			/*Ejecucion de los algoritmos y creacion de los resultados*/
			$main = new Principal($p_entrada, $exeFundamento, $exeMetodo);

			/*parametros de retorno y almacenamiento en la db.*/
			$result ['img'] = $main->getRutaImg();
			$result ['resultados'] = $main->getTabla_resultados();
			//$result ['archivo'] = $main->getRutaArchivo();
			/*=============================================================================*/

			return $result;
		}

		/**
		 * @ClassDependency: {'model.Grafico'}
		 */
		public function exeSpline(){
			$valx = $this->request->getParam('valx');
			$valy = $this->request->getParam('valy');
			$grado = $this->request->getParam('gradoSPL');

			$xdata = array();
			$ydata = array();

			foreach($valx as $key1=>$vx){
				if($vx != '')
					array_push($xdata, $vx);
			}
			foreach($valy as $vy){
				if($vy != '')
					array_push($ydata, $vy);
			}

			array_multisort($xdata,$ydata);

			$p_entrada["valx"] = $xdata;
			$p_entrada["valy"] = $ydata;

			$exeFundamento = 'SPLine';
			$exeMetodo = $grado;

			$grafico = new Grafico($exeFundamento, $xdata, $ydata);

			switch($grado){
				case 0:{
					foreach($xdata as $key => $x) {
						if(isset($xdata[$key+1])){
							echo 'S<sub>'.$key.'</sub> = '.$ydata[$key] .' <span class="intervalo">['.$xdata[$key].','.$xdata[$key+1].'[</span><br>';
							
						}
					}				

				}
				break;
				case 1:{
					foreach($xdata as $key => $x) {
						if(isset($xdata[$key+1])){
							echo 'S<sub>'.$key.'</sub> = '.$xdata[$key] .'x + '.$ydata[$key].' <span class="intervalo"> ['.$xdata[$key].','.$xdata[$key+1].'[</span><br>';
						}
					}

				}
				break;
				case 3:{
					//* CALCULO DE COEFICIENTES */
					$h = array();
					$b = array(); 
					$u = array();
					$v = array(); 
					$z = array();
					$a = array();
					$bm = array();
					$c = array();

					for($i = 0; $i < count($ydata); $i++) {
						$z[$i] = 0;
					}

					for($i = 0; $i < count($ydata)-1; $i++) {
						$h[$i] = $xdata[$i+1] - $xdata[$i];	
						$b[$i] = 6*($ydata[$i+1] - $ydata[$i]) / $h[$i];
					}
					$u[1] = 2*($h[0] + $h[1]);
					$v[1] = $b[1] - $b[0];

					for($i=2; $i < count($ydata)-1; $i++) {
						$u[$i] = 2 * ($h[$i] + $h[$i-1]) - (pow($h[$i-1],2)/$u[$i-1]);
						$v[$i] = ($b[$i] - $b[$i-1]) - $h[$i-1]*$v[$i-1]/$u[$i-1];		
					}

					for($i=count($ydata)-2; $i>=1; $i--) {
						$z[$i] = ($v[$i]-$h[$i]*$z[$i+1])/$u[$i];	
					//	echo $z[$i] .'<br>';
					}

					for($i = 0; $i < count($ydata)-1; $i++) {
						$a[$i] = ($z[$i+1] - $z[$i])/(6*$h[$i]);
						$bm[$i] = $z[$i] / 2;
						$c[$i] = (-1*$h[$i]*$z[$i+1]/6) - ($h[$i]*$z[$i]/3) + (($ydata[$i+1] - $ydata[$i])/$h[$i]);
						
					//	echo $a[$i] .' | '. $b[$i] . ' | '. $c[$i] .'<br>';
					}

					for($i = 0; $i < count($ydata)-1; $i++) {
						echo 'S<sub>'.$i.'</sub> = '.$ydata[$i] .
						' + (x - '.$xdata[$i].')*'.
						'['.round($c[$i],4).' + (x - '.$xdata[$i].')*['.round($bm[$i],4).' + (x - '.$xdata[$i].')* '.round($a[$i],4).']]'.
						' <span class="intervalo">['.$xdata[$i].','.$xdata[$i+1].'[</span><br>'; 
					}
				}
				break;
			}
			return $grafico->graficarSPLINE($xdata, $ydata, $grado);
		}
		
	}

?>
