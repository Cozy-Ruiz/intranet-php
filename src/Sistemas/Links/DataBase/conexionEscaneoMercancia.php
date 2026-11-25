<?php
require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionEscaneoMercancia {
	
	public $VP;	
	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.138:33300';
	private static $db_host = getenv('LINKS_DB_HOST');
	private static $db_user = getenv('LINKS_DB_USER');
	private static $db_pass = getenv('LINKS_DB_PASS');
	private static $db_name = 'ESCANEO_MERCANCIA';
	
    function __construct() {
		/*$this->VP = ADONewConnection("oci8");
		$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass);*/
		$this->VP = ADONewConnection("mysqli");
		$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	function Query($consulta){
		$s = $this->VP->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->VP->GetArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->VP->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->VP->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->VP->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->VP->Execute($consulta);
	}
	
	function getOne($consulta){
		$s = $this->VP->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->VP->close();
	}
	
} 

?>
