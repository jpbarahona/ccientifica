<?php
	class copyAlgoritmo {

		public $p_entrada;
		public $exeFundamento;
		public $exeMetodo;

		public function __construct($fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo){

			$this->p_entrada = array();
			$this->p_entrada["fx"]		= $fx;
			$this->p_entrada["xi"]		= $xi;
			$this->p_entrada["xf"]		= $xf;
			$this->p_entrada["errto"]	= $errto;
			$this->p_entrada["imax"] 	= $imax;
			
			$this->exeFundamento		= $exeFundamento;
			$this->exeMetodo 			= $exeMetodo;
		}
	}