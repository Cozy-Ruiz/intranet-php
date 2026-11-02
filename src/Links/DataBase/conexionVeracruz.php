<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(__DIR__ . "/../Librerias/adodb/adodb.inc.php");

//conexion Veracruz

class ConexionSCIAVER{
	
	public $SCIAVER;	
	
	//private static $db_host = '187.157.180.68:1521';
	//private static $db_host = 'nyeveracruz.dyndns.org:33300'; 
	private static $db_host = '192.1.168.4:33300'; 
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	//private static $db_name = 'VERACRUZ';
	private static $db_name = 'VERACRUZ11g';
	
    function __construct() {
		$this->SCIAVER = ADONewConnection("oci8");
		$this->SCIAVER->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->SCIAVER->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->SCIAVER->GetArray($consulta);
		return $s;
	}

	function GetOne($consulta){
		$s = $this->SCIAVER->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->SCIAVER->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$s = $this->SCIAVER->Execute($consulta);
		return $s;
	}
	
	function Close(){
		$this->SCIAVER->close();
	}

	function errorMsg(){
		return $this->SCIAVER->errorMsg();
	}
	
} 

?>