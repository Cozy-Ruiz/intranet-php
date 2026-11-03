<?php
require_once("../Librerias/adodb/adodb.inc.php");
	
class ConexionDODA {
	
	public $DODA_GE;	
	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.130:33301';
	/*
	private static $db_host = 'gea-aicm.dyndns.org:33301';
	private static $db_user = 'doda_aicm';
	private static $db_pass = '3sc1l1nt3_2017';
	private static $db_name = 'LINKSDESA11G';*/

	private static $db_host = '192.1.172.9:3306';
	private static $db_user = 'GEA';
	private static $db_pass = '7b1QqK#m1F3m';
	private static $db_name = 'DODA';
	
	
    function ConexionDODA() {
		$this->DODA_GE = ADONewConnection("mysqli");
		//$this->DODA_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->DODA_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	function Query($consulta){
		$s = $this->DODA_GE->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->DODA_GE->GetArray($consulta);
		return $s;
	}
	
	function GetAll($consulta){
		$s = $this->DODA_GE->getAll($consulta);
		return $s;
	}
	
	function GetCol($consulta){
		$s = $this->DODA_GE->getCol($consulta);
		return $s;
	}
	
	function GetRow($consulta){
		$s = $this->DODA_GE->getRow($consulta);
		return $s;
	}
	
	
	function Execute($consulta){
		$s = $this->DODA_GE->Execute($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->DODA_GE->getOne($consulta);
		return $s;
	}

	function IniciaTransaccion(){

		$this->DODA_GE->StartTrans();
	}

	//en caso false comentar-----------------
	function EjecutaTransaccion($transaccion){
		$this->DODA_GE->execute($transaccion);
		if ($this->DODA_GE->hasFailedTrans() == true){
		    echo $this->DODA_GE->errorMsg()."\n";
		}
	}

	function FinalizaTransaccion(){
		$this->DODA_GE->CompleteTrans();
	}

	function errorMsg(){
		return $this->DODA_GE->errorMsg();
	}

	function BeginTrans() {
		return $this->DODA_GE->BeginTrans();
	}

	function RollbackTrans() {
		return $this->DODA_GE->RollbackTrans();
	}

	function CommitTrans() {
		return $this->DODA_GE->CommitTrans();
	}
	
	/*...........................................*/
	
	function Close(){
		$this->DODA_GE->close();
	}
	
} 

?>
