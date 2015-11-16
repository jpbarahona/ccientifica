<?php
	/* app config */
	define("CTX_PATH", $_SERVER['DOCUMENT_ROOT'].'/ccientifica');
	define("SITE_MAP", CTX_PATH."/src/controller/site.xml");
	define("WELCOME_PAGE", "index");
	define('LOG_DIR', CTX_PATH.'/logs');
	define('LOG_LEVEL', 'DEBUG');
	define('DEV_MOBILE', '1');
	/* propiedades de conexion */
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'db_ccientifica');
	define('DB_PORT', '3306');
	
	/*LOAD_MODEL */
	define("LOAD_MODEL", CTX_PATH.'/src/model');
	
	/*LOAD_ALG */
	define("LOAD_ALG", '../model/app');

	/*LOAD_IMG */
	define("LOAD_IMG", 'src/model/img');

	/*ALOJAR IMAGENES */
	define("SAVE_IMAGEN", CTX_PATH.'/src/model/img');