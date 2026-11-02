<?php

ini_set("display_errors", 1);
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionLinks {
	
	public $LINKS_GE;

	//Desarrollo
	/*private static $db_host = 'gea-aicm.dyndns.org:3310';
	private static $db_user = 'LINKS';
	private static $db_pass = 'links';
	private static $db_name = 'LINKS';*/

	private static $db_host = '192.1.172.9:3306';
    private static $db_user = 'GEA';
    //private static $db_pass = 'links';
	private static $db_pass = '7b1QqK#m1F3m';
    private static $db_name = 'LINKS';
	
	

     function __construct(){
		$this->LINKS_GE = ADONewConnection("mysqli");
		$this->LINKS_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);  
		$this->LINKS_GE->Execute("SET NAMES 'utf8'");  
	}
	
	
	function Query($consulta){
		$s = $this->LINKS_GE->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->LINKS_GE->GetArray($consulta);
		return $s;
	}
	
	function GetAll($consulta){
		$s = $this->LINKS_GE->getAll($consulta);
		return $s;
	}
	
	function GetCol($consulta){
		$s = $this->LINKS_GE->getCol($consulta);
		return $s;
	}
	
	function GetRow($consulta){
		$s = $this->LINKS_GE->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		return $this->LINKS_GE->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->LINKS_GE->getOne($consulta);
		return $s;
	}
	
	

	function ExecuteTransaccion($transacciones){

		$this->LINKS_GE->StartTrans();

		foreach($transacciones as $transaccion){
			$this->LINKS_GE->execute($transaccion);
			if ($this->LINKS_GE->hasFailedTrans()){
			    echo $this->LINKS_GE->errorMsg()."<br>";
			}
		}

		$this->LINKS_GE->CompleteTrans();
	}

	function errorMsg(){
		return $this->LINKS_GE->errorMsg();
	}

	function BeginTrans() {
		return $this->LINKS_GE->BeginTrans();
	}

	function RollbackTrans() {
		return $this->LINKS_GE->RollbackTrans();
	}

	function CommitTrans() {
		return $this->LINKS_GE->CommitTrans();
	}

	function Close(){
		$this->LINKS_GE->close();
	}

}


?>
