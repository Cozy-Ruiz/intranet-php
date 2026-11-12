<?php
require_once("../Librerias/adodb/adodb.inc.php");

//conexion Laredo
class ConexionBODEGA{
	
	public $BODEGA;	
	
	private static $db_host = '192.1.171.71:1521';
	private static $db_user = 'bodega';
	private static $db_pass = 'bodega';
	private static $db_name = 'laredo';
	
    function __construct(){
		$this->BODEGA = ADONewConnection("oci8");
		$this->BODEGA->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->BODEGA->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->BODEGA->GetArray($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->BODEGA->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->BODEGA->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->BODEGA->Execute($consulta);
	}
	
	function Close(){
		$this->BODEGA->close();
	}
	
}

?>