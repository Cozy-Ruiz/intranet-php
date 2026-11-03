<?php
require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionValidacionPago {
	
	public $VP;	
	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.138:33300';

	//Desarrollo
	/*
	private static $db_host = 'gea-aicm.dyndns.org:1621';
	private static $db_user = 'VALIDACION_PAGO';
	private static $db_pass = 'validacion_pago';
	private static $db_name = 'LINKSDESA11G';
	*/

	//Pruebas
	private static $db_host = 'localhost:3306';
	private static $db_user = 'VALIDACION_PAGO';
	private static $db_pass = 'validacion_pago';
	private static $db_name = 'VALIDACION_PAGO';
	
    function __construct() {
		$this->VP = ADONewConnection("mysqli");
		
		//Desarrollo
		//$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass);

		//Pruebas
		$this->VP->connectSID = true;
		$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->VP->Execute("SET NAMES 'utf8'");  
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
	
	function GetOne($consulta){
		$s = $this->VP->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->VP->close();
	}
	
}

?>
