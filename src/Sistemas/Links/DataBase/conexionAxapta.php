<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../Librerias/adodb/adodb.inc.php");

//conexion mexico
	
class ConexionAxapta {
	
	public $AXAPTA;	
	
	private static $db_host = '192.1.169.32:33300';
	private static $db_user = 'bmssa3';
	private static $db_pass = 'AxaptaGEA0301';
	private static $db_name = 'MEXICO11g';
	
    function __construct(){
		$this->AXAPTA = ADONewConnection("oci8");
		$this->AXAPTA->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->AXAPTA->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->AXAPTA->GetArray($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->AXAPTA->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->AXAPTA->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->AXAPTA->Execute($consulta);
	}
	
	function Close(){
		$this->AXAPTA->close();
	}
	
}

/*
$conexionSCIA = new ConexionSCIAMEX();
$existeReferencia = $conexionSCIA->GetRow("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.PEDIMENTOS p where p.referencia = '19-408865' ");
var_dump($existeReferencia);
*/
?>
