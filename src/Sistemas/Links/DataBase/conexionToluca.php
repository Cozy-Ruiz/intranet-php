<?php
require_once("../Librerias/adodb/adodb.inc.php");

//conexion a Toluca
class ConexionSCIATOL{
	
	public $SCIATOL;	
	
	private static $db_host = '192.1.167.202:1521';
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	private static $db_name = 'TOLUCA11G';
	
    function __construct() {
		$this->SCIATOL = ADONewConnection("oci8");
		$this->SCIATOL->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->SCIATOL->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->SCIATOL->GetArray($consulta);
		return $s;
	}

	function GetOne($consulta){
		$s = $this->SCIATOL->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->SCIATOL->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$s = $this->SCIATOL->Execute($consulta);
		return $s;
	}
	
	function Close(){
		$this->SCIATOL->close();
	}

	function errorMsg(){
		return $this->SCIATOL->errorMsg();
	}
	
} 

?>
