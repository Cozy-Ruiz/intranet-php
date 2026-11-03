<?php
require_once("../Librerias/adodb/adodb.inc.php");

//Conexion Cancun
class ConexionSCIACUN{
	
	
	public $SCIACUN;	
	/*
	private static $db_host = 'geacancun.dyndns.org:2521';
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	private static $db_name = 'CANCUN11G';
	*/
	private static $db_host = '192.1.166.240:1521';
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	private static $db_name = 'CANCUN11G';
	
    function __construct(){
		$this->SCIACUN = ADONewConnection("oci8");
		$this->SCIACUN->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->SCIACUN->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->SCIACUN->GetArray($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->SCIACUN->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->SCIACUN->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$s = $this->SCIACUN->Execute($consulta);
		return $s;
	}
	
	function Close(){
		$this->SCIACUN->close();
	}

	function errorMsg(){
		return $this->SCIACUN->errorMsg();
	}
	
} 
 
?>