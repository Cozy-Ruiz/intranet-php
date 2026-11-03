<?php
require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionCovesEdocuments {
	
	public $VP;	
	
	private static $db_host = '192.1.172.9:3306';
	private static $db_user = 'GEA';
	private static $db_pass = '7b1QqK#m1F3m';
	private static $db_name = 'coves_edocuments';
	
	
    function __construct(){
		$this->VP = ADONewConnection("mysqli");
		
		$this->VP->connectSID = true;
		$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->VP->Execute("SET NAMES 'utf8'");  
    }
	
	function Query($consulta){
		$s = $this->VP->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->VP->GetArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->VP->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->VP->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->VP->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->VP->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->VP->getOne($consulta);
		return $s;
	}

	function IniciaTransaccion(){

		$this->VP->StartTrans();
	}

	function EjecutaTransaccion($transaccion){
		$this->VP->execute($transaccion);
		if ($this->VP->hasFailedTrans() == true){
		    echo $this->VP->errorMsg()."\n";
		}
	}

	function FinalizaTransaccion(){
		$this->VP->CompleteTrans();
	}
	
	function Close(){
		$this->VP->close();
	}
	
}

?>
