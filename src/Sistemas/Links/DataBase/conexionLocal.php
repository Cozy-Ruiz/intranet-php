<?php
require_once("../Librerias/adodb/adodb.inc.php");
	
class ConexionLocal {
	
	public $Local_GE;	
	
	/*
	private static $db_host = 'localhost:3306';
	private static $db_user = 'root';
	private static $db_pass = '';
	private static $db_name = 'cartaporte';
	*/
	private static $db_host = '192.1.172.9:3306';
	private static $db_user = 'GEA';
	private static $db_pass = '7b1QqK#m1F3m';
	private static $db_name = 'CARTAPORTE';
	
    function ConexionLocal() {
		$this->Local_GE = ADONewConnection("mysqli");
		//$this->DODA_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->Local_GE->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	function Query($consulta){
		$s = $this->Local_GE->Execute($consulta);
		return $s;
	}

	function NumRows($consulta){
		$s = $this->Local_GE->num_rows($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->Local_GE->GetArray($consulta);
		return $s;
	}
	
	function GetAll($consulta){
		$s = $this->Local_GE->getAll($consulta);
		return $s;
	}
	
	function GetCol($consulta){
		$s = $this->Local_GE->getCol($consulta);
		return $s;
	}
	
	function GetRow($consulta){
		$s = $this->Local_GE->getRow($consulta);
		return $s;
	}
	
	
	function Execute($consulta){
		$s = $this->Local_GE->Execute($consulta);
		return $s;
	}
	
	function GetOne($consulta){
		$s = $this->Local_GE->getOne($consulta);
		return $s;
	}

	function IniciaTransaccion(){

		$this->Local_GE->StartTrans();
	}

	//en caso false comentar-----------------
	function EjecutaTransaccion($transaccion){
		$this->Local_GE->execute($transaccion);
		if ($this->Local_GE->hasFailedTrans() == true){
		    echo $this->Local_GE->errorMsg()."\n";
		}
	}

	function FinalizaTransaccion(){
		$this->Local_GE->CompleteTrans();
	}

	function errorMsg(){
		return $this->Local_GE->errorMsg();
	}

	function BeginTrans() {
		return $this->Local_GE->BeginTrans();
	}

	function RollbackTrans() {
		return $this->Local_GE->RollbackTrans();
	}

	function CommitTrans() {
		return $this->Local_GE->CommitTrans();
	}
	
	/*...........................................*/
	
	function Close(){
		$this->Local_GE->close();
	}
	
} 

?>
