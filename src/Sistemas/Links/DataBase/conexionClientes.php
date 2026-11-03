<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionClientes{
	
	public $ClientesDB;
	
	
    private static $db_host = 'localhost';
    private static $db_user = 'CLIENTES';
    private static $db_pass = 'clientes';
    private static $db_name = 'CLIENTES';


	
   

     function __construct() {
		$this->ClientesDB = ADONewConnection("mysqli");
		$this->ClientesDB->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	function Query($consulta){
		$s = $this->ClientesDB->Execute($consulta);
		return $s;
	}


	
	function GetArray($consulta){
		$s = $this->ClientesDB->GetArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->ClientesDB->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->ClientesDB->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->ClientesDB->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->ClientesDB->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->ClientesDB->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->ClientesDB->close();
	}
	
} 


?>
