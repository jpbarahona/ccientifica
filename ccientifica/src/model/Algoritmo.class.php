<?php
	class copyAlgoritmo {

		public $fx;
		public $xi;
		public $xf;
		public $errto;
		public $imax;
		public $exeFundamento;
		public $exeMetodo;

		public function __construct($fx, $xi, $xf, $errto, $imax, $exeFundamento, $exeMetodo){

			$this->fx 					= $fx;
			$this->xi 					= $xi;
			$this->xf					= $xf;
			$this->errto				= $errto;
			$this->imax  				= $imax;
			$this->exeFundamento		= $exeFundamento;
			$this->exeMetodo 			= $exeMetodo;
	}
	}
?>