<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once("../Librerias/adodb/adodb.inc.php");
//putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionCFDI {
	
	
	public $CFDI_GE;	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.138:33300';

	

	private static $db_host = '192.1.172.9:3306';
    private static $db_user = 'GEA';
    private static $db_pass = '7b1QqK#m1F3m';
    private static $db_name = 'CFDI';
	

     function __construct() {
		$this->CFDI_GE = ADONewConnection("mysqli");
		$this->CFDI_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);    
		$this->CFDI_GE->Execute("SET NAMES 'utf8'");
	}
	
	function Query($consulta){
		$s = $this->CFDI_GE->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->CFDI_GE->getArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->CFDI_GE->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->CFDI_GE->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->CFDI_GE->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->CFDI_GE->Execute($consulta);
	}
	
	function getOne($consulta){
		$s = $this->CFDI_GE->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->CFDI_GE->close();
	}
	
} 



