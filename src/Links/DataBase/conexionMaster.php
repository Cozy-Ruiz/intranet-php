<?php
ini_set("display_errors", 1);
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionMaster {
	
	public $MASTER_GE;	
	 
	//private static $db_host = '192.1.172.3:3306';USER 'GEA'@'localhost' password '7b1QqK#m1F3m'
	private static $db_host = '192.1.172.9:3306';
	private static $db_user = 'GEA';
	private static $db_pass = '7b1QqK#m1F3m';
	private static $db_name = 'MASTER_GE';
	

    function __construct() {
		$this->MASTER_GE = ADONewConnection("mysqli");
		$this->MASTER_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->MASTER_GE->Execute("SET NAMES 'utf8'");
    }
	
	
	function Query($consulta){
		$s = $this->MASTER_GE->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->MASTER_GE->GetArray($consulta);
		return $s;
	}


	function GetRows($consulta){
		$s = $this->MASTER_GE->GetRows($consulta);
		return $s;
	} 
	
	function GetAll($consulta){
		$s = $this->MASTER_GE->getAll($consulta);
		return $s;
	}
	
	function GetCol($consulta){
		$s = $this->MASTER_GE->getCol($consulta);
		return $s;
	}
	
	function GetRow($consulta){
		$s = $this->MASTER_GE->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->MASTER_GE->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->MASTER_GE->getOne($consulta);
		return $s;
	}
		
function Last(){
		$s = $this->MASTER_GE->getOne("SELECT LAST_INSERT_ID()");
		return $s;
	}

	function Close(){
		$this->MASTER_GE->close();
	}
	
}
