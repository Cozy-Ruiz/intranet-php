<?php
ini_set('display_errors', 1);
	error_reporting(E_ALL);

require_once("../Librerias/adodb/adodb.inc.php");

//conexion mexico
	
class ConexionSCIAMEX {
	
	public $SCIA;	
	
	//private static $db_host = '192.1.169.32:33300';s
	private static $db_host = '201.147.92.135:33300';
	private static $db_user = 'scia';
	private static $db_pass = 'scia';
	private static $db_name = 'mexico11g';
	
    function __construct(){
		$this->SCIA = ADONewConnection("oci8");
		$this->SCIA->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, true);
    }
	
	function Query($consulta){
		$s = $this->SCIA->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->SCIA->GetArray($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->SCIA->getOne($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->SCIA->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->SCIA->Execute($consulta);
	}
	
	function Close(){
		$this->SCIA->close();
	}
	
}

/*
$conexionSCIA = new ConexionSCIAMEX();
$existeReferencia = $conexionSCIA->GetRow("SELECT p.* from pedimento.pedimentos p where p.referencia = '17-416583' ");
var_dump($existeReferencia);
*/
?>
