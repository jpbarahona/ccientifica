<?php

	require_once "../model/Principal.class.php";
	/*=============================================================================*/

	/*Parametros ingresados por el usuario*/
	$p_entrada = array();
	$p_entrada["fx"] = "log(x)";
	$p_entrada["x"] = 2.5;
	$p_entrada["g"] = 2;
	$p_entrada["xptos"] = "2;3;4";

	$exeFundamento = "Ajuste de curvas";
	$exeMetodo = "lagrange";

	/*$p_entrada["fx"] = "x*log(x/3)-x";
	$p_entrada["xi"] = 1.5;
	$p_entrada["xf"] = 20.1;
	$p_entrada["errto"] = 0.00001;
	$p_entrada["imax"] = 25;

	$exeFundamento = "Ecuacion de raices";
	$exeMetodo = "Secante";*/

	/*=============================================================================*/
	/*Ejecucion de los algoritmos y creacion de los resultados*/
	$main = new principal($p_entrada, $exeFundamento, $exeMetodo);

	/*parametros de retorno y almacenamiento en la db.*/
	echo $main->getCodigo()."|".$main->getRutaImg()."|".$main->getRutaArchivo()."</br>";
	echo '<img src="'.$main->getRutaImg().'" /></br>';
	/*=============================================================================*/