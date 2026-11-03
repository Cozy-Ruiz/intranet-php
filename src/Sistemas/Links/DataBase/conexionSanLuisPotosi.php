<?php
require_once("../Librerias/adodb/adodb.inc.php");

//conexion Laredo
class ConexionSLP{
	
	public $SCIALAR;	
	
	private static $db_host = '71.144.19.158:1521';
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	private static $db_name = 'LAREDO';
	
    function __construct(){
		$this->SCIALAR = ADONewConnection("oci8");
		$this->SCIALAR->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->SCIALAR->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->SCIALAR->GetArray($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->SCIALAR->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->SCIALAR->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->SCIALAR->Execute($consulta);
	}
	
	function Close(){
		$this->SCIALAR->close();
	}
	
}

?>