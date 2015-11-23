<?php
class AnnotationProccess {
	
	private $method;
	private $annotations;
	
	public function AnnotationProccess($method){
		$this->method = $method;
		$this->annotations = array();
		$this->init();
	}
	
	private function init(){
		preg_match_all('#@(.*?)\n#s', $this->method->getDocComment(), $tmp);
		$methodAnnotation = $tmp[1];
		foreach ($methodAnnotation as $text) {
			array_push($this->annotations, new Annotation($text));
		}
	}
	
	public function getAnnotationByName($name){
		$out = null;
		foreach ($this->annotations as $tmp){
			if ($tmp->name == $name){
				$out = $tmp;
				break;
			}
		}
		return $out;
	}
}

class Annotation {
	
	public $name;
	public $value;
	
	public function Annotation($text){
		$middle = strpos($text, ":");
		$this->name = substr($text, 0, $middle);
		$this->value = trim(substr($text, $middle+1, strlen($text)));
	}
	
	public function getValues(){
		if (strpos($this->value, '}') == -1){
			throw new Exception("Annotation $name has only value");
		}
		$out = array();
		$lines = explode(',', $this->value);
		foreach ($lines as $line){
			$line = preg_replace(array("(\{|'|\})", '(\.)'), array('', '/'), $line);
			array_push($out, trim($line));
		}
		return $out;
	}
}

class PrivilegeAnnotation {	
	public static function process(Annotation $a){
		switch ($a->value){
			case 'AUTHENTICATED': { if(!isset($_SESSION['USER'])){ throw new Exception("USER IS NOT DEFINED"); }; break; }
			default: { throw new Exception("Privilegios Insuficientes => $p"); }
		}
	}
}

class ClassDependencyAnnotation {
	public static function process(Annotation $a){
		$classes = $a->getValues();
		foreach ($classes as $class){
			$classFile = "../$class.class.php";
			if (file_exists($classFile)){ include_once $classFile; }
			else { throw new Exception("$classFile DO NOT EXIST"); }
		}
	}
}


