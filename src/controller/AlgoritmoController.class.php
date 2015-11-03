<?php

	class AlgoritmoController extends Controller{
		
		public function AlgoritmoController(){
			parent::Controller();
		}
		
		/**
		 * @ClassDependency: {'model.Algoritmo', 'model.Principal'}
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
		
	}

?>