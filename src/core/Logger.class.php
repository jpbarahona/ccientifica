<?php
class Logger {
	
	static private $instance = null;
	private $debugEnabled = false;
	private $infoEnabled = false;
	private $warnEnabled = false;
	private $errorEnabled = false;
	
	private function __construct(){
		switch (LOG_LEVEL){
			case 'DEBUG':
				$this->debugEnabled = true;
				$this->infoEnabled = true;
				$this->warnEnabled = true;
				$this->errorEnabled = true;
				break;
			case 'INFO':
				$this->infoEnabled = true;
				$this->warnEnabled = true;
				$this->errorEnabled = true;
				break;
			case 'WARN':
				$this->warnEnabled = true;
				$this->errorEnabled = true;
				break;
			case 'ERROR':
				$this->errorEnabled = true;
				break;
		}
	}
	
	public static function getLogger(){
		if(self::$instance == null){ self::$instance = new Logger(); }
		return self::$instance;
	}
	
	private function write($level, $message){
		$backtrace = debug_backtrace();
		$cache = $backtrace[1]['file'];
		$file = substr($cache, strrpos($cache, '\\')+1, strlen($cache)-1);
		$line = $backtrace[1]['line'];
		$today = date('Y-m-d');
		$time = date("Y-m-d H:i:s");
		$link = fopen( LOG_DIR."/$today.log", 'a+');
		fwrite($link, "[$time][$level] $file:$line $message");
		fwrite($link, chr(10));
		fclose($link);
	}
	
	public function debug($message){ if($this->debugEnabled){ $this->write('DEBUG', $message); }}
	public function info($message){ if($this->infoEnabled) { $this->write('INFO', $message); }}
	public function warn($message){ if ($this->warnEnabled) { $this->write('WARNING', $message); }}
	public function error($message){ if ($this->errorEnabled) { $this->write('ERROR', $message); }}
	public function fatal($message){ $this->write('FATAL', $message); exit(); }
}
