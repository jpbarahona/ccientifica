<?php

	class AlgoritmoController extends Controller{
		
		public function AlgoritmoController(){
			parent::Controller();
		}
		
		/**
		 * @ClassDependency: {'model.principal', 'model.Algoritmo'}
		 */
		/*'model.crear_archivos_directorios', 'model.grafico', 'model.Leer_archivo',*/
		public function exeMetodo(){
		
			$fx	= $this->request->getParam('fx');
			$xi	= $this->request->getParam('xi');
			$xf	= $this->request->getParam('xf');
			$errto	= $this->request->getParam('errto');
			$imax	= $this->request->getParam('imax');
			
			$exeFundamento = $this->request->getParam('exeFundamento');
			$exeMetodo = $this->request->getParam('exeMetodo');

			/*=============================================================================*/
			/*Ejecucion de los algoritmos y creacion de los resultados*/
			$main = new principal($fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo);

			/*parametros de retorno y almacenamiento en la db.*/
			$result [0] = $main->getRutaImg();
			$result [1] = $main->getRutaArchivo();
			$result ['resultados'] = $main->getResultados();
			/*=============================================================================*/

			return $result;
		}
		
	}

?>