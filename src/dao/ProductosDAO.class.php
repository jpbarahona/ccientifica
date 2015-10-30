<?php
require_once '../Michelf/MarkdownExtra.class.php';

/**
 * Clase que encripta y desencripta un string.
 * 
 *
 */
class Encrypter {

	private static $Key = "jota777"; //Clave secreta de la encriptación.

	public static function encrypt ($input) {
		$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
		return $output;
	}

	public static function decrypt ($input) {
		$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))), "\0");
		return $output;
	}

}

class ProductosDAO {
	
	private $connection;
	protected $logger;
	
	public function __construct(){
		$this->connection = new DataSource();
		$this->logger = Logger::getLogger();
	}

	/**
	 * Añade el producto a la base de datos con el nombre, medida, descripcion, rutaimagen, categoria y familia.
	 *
	 * @param $nombreprod string.
	 * @param $precioprod string.
	 * @param $medidas string.
	 * @param $descripcionprod string.
	 * @param $rutaimagen string.
	 * @param $idcategoria int.
	 * @param $idfamilia int.
	 * @return boolean.
	
	 */
	public function agregarProducto($nombreprod, $precioprod, $medidas, $descripcionprod, $rutaimagen, $idcategoria, $idfamilia){
		$Markdown = new Markdown();
		
		$my_html  =  $Markdown->transform($descripcionprod);
		
		$query = "INSERT INTO producto(nombreprod, precioprod, medidas, descripcionprod, rutaimagen, categoria_idcategoria, categoria_familia_idfamilia)".
				 "VALUES('$nombreprod', '$precioprod', '$medidas','$my_html', '$rutaimagen', '$idcategoria', '$idfamilia');";
		
		$this->logger->getLogger($query);
		$result= $this->connection->query($query);

		return $result;		
	}
	
	/**
	 * Seleccionar la lista de los productos de una familia.
	 * Se utiliza la tabla producto ubicada en la base de datos.
	 *
	 * @param int $idfamilia = id familia de los productos.
	 * @return Array de los productos de la familia.
	 */
	public function cargarFamiliaProductos($idfamilia){
		$query = 'SELECT idproducto, nombreprod, precioprod, medidas, descripcionprod, rutaimagen '.
				 'FROM producto '."WHERE categoria_familia_idfamilia = '$idfamilia'";
		
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		
		for ($i = 0; $i < sizeof($result); $i++){
			$result[$i]["idproducto"] = Encrypter::encrypt($result[$i]["idproducto"]);
		}
		
		return $result;
	}
	
	/**
	 * Seleccionar los productos de una categoria.
	 * Se utiliza la tabla producto ubicada en la base de datos.
	 *
	 * @param int $idCategoria = id categoria de los productos.
	 * @return Array con los nombres de los productos.
	 */
	public function cargarCategoriaProductos($idCategoria){
	
		$query = 'SELECT idproducto, nombreprod, precioprod, medidas, descripcionprod, rutaimagen FROM producto '."WHERE categoria_idcategoria = '$idCategoria'";
	
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		
		for ($i = 0; $i < sizeof($result); $i++){
			$result[$i]["idproducto"] = Encrypter::encrypt($result[$i]["idproducto"]);
		}
		
		return $result;
	}
	
	/**
	 * Seleccionar los nombres de las familias de productos.
	 * Se utiliza la tabla familia ubicada en la base de datos.
	 * 
	 * @return Array con los nombres de la familias.	
	 */
	public function cargarFamilia(){
		
		$query = 'SELECT idfamilia, nombrefami FROM familia';
		
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		
		return $result;
	}
	
	/**
	 * Seleccionar las categorias de la familia.
	 *
	 * @param int $idfamilia = id familia de los productos.
	 * @return Array de las categorias de la familia.
	 */
	public function cargarCategoriaFamilia($idfamilia){
		$query = 'SELECT idcategoria, nombrecate FROM categoria '."WHERE familia_idfamilia = '$idfamilia'";
	
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		return $result;
	}
	
	/**
	 * Seleccionar el producto.
	 * 
	 * @param int $idproducto = id producto.
	 * @return Array atributos del producto.
	 */
	public function cargarProducto($idproducto){
		
		$idproducto = Encrypter::decrypt($idproducto);
		
		$query = 'SELECT nombreprod, precioprod, medidas, descripcionprod, rutaimagen, categoria_idcategoria FROM producto '."WHERE idproducto = '$idproducto'";
	
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		
		switch ($result[0]["categoria_idcategoria"]){
			case 1: {$result[0]["categoria_idcategoria"] = "Arrimo"; break;}
			case 2: {$result[0]["categoria_idcategoria"] = "Juego de terraza"; break;}
			case 3: {$result[0]["categoria_idcategoria"] = "Mesa centro"; break;}
			case 4: {$result[0]["categoria_idcategoria"] = "Mesa lateral"; break;}
			case 5: {$result[0]["categoria_idcategoria"] = "Sillón"; break;}
			case 6: {$result[0]["categoria_idcategoria"] = "Sitial"; break;}
			case 7: {$result[0]["categoria_idcategoria"] = "Sofá"; break;}
			case 8: {$result[0]["categoria_idcategoria"] = "Juego comedor"; break;}
			case 9: {$result[0]["categoria_idcategoria"] = "Mesa piedra pizarra"; break;}
			case 10: {$result[0]["categoria_idcategoria"] = "Mesa vidrio"; break;}
			case 11: {$result[0]["categoria_idcategoria"] = "Piso"; break;}
			case 12: {$result[0]["categoria_idcategoria"] = "Silla"; break;}
			case 13: {$result[0]["categoria_idcategoria"] = "Banqueta"; break;}
			case 14: {$result[0]["categoria_idcategoria"] = "Brasero"; break;}
			case 15: {$result[0]["categoria_idcategoria"] = "Escaño"; break;}
			case 16: {$result[0]["categoria_idcategoria"] = "Reposera"; break;}
			case 17: {$result[0]["categoria_idcategoria"] = "Toldos"; break;}
			case 18: {$result[0]["categoria_idcategoria"] = "Cojín"; break;}
			//default: { $dirCat = arrimos; break; }
		}
		
		return $result;
	}
	
	/**
	 * Ver la cantidad de productos que existen en un id especifico, que puede ser dependiendo de la familia o la categoria.
	 *
	 * @param int $idTipo = idFamilia o idCaterogira.
	 * @param String $String = familia o categoria.
	 * @return Array atributos del producto.
	 */
	public function cantidadProductos($tipo, $idTipo){
		
		$query = 'SELECT idproducto FROM producto '."WHERE ".$tipo." like '$idTipo'";
		
		$result = $this->connection->query($query);
		$this->logger->getLogger($query);
		
		return $result;
	}
}
/*$uploadfile = UPLOAD_IMAGEN.'/'.basename($_FILES['muebleimage']['name']);
   		$file = $filename = $_FILES['muebleimage']['tmp_name'];
*/