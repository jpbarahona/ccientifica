<?php
class ApplicationError {
	
	public static final $BAD_LOGIN = 0;
	
	public static function getError($c){
		$e = 'unknow error';
		switch($c) {
			case $BAD_LOGIN: { $e='Autenticacion Fallida'; break; }
		}
		return $e;
	}
	
}