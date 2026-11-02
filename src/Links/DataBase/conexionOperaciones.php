<?php

ini_set("display_errors", 1);
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../Librerias/adodb/adodb.inc.php");
	
class ConexionOperaciones {
	
	private static $db_host = 'gea-aicm.dyndns.org:8097';
	private static $db_user = 'OPERACIONES';
	private static $db_pass = 'operaciones';
	private static $db_name = 'ORA11G';

	public $conexion ;
		
    function __construct(){
		$this->conexion = ADONewConnection("oci8");
		$this->conexion->connectSID = true;
		$this->conexion->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	
	function Query($consulta){
		$s = $this->conexion->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->conexion->GetArray($consulta);
		return $s;
	}
	
	function GetAll($consulta){
		$s = $this->conexion->getAll($consulta);
		return $s;
	}
	
	function GetCol($consulta){
		$s = $this->conexion->getCol($consulta);
		return $s;
	}
	
	function GetRow($consulta){
		$s = $this->conexion->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		return $this->conexion->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->conexion->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->conexion->close();
	}
	
}


?>
