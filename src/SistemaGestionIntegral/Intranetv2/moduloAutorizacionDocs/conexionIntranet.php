<?php
//require_once("../../../../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionIntranet {
	
	public $conexionDB;	
	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.138:33300';


	//Pruebas
	private static $db_host = 'master.escalante.com.mx:3306';
	private static $db_user = 'sistemas';
	private static $db_pass = 'gescalante1';
	private static $db_name = 'INTRANET2';
	
    function __Construct() {
    		$this->conexionDB = ADONewConnection("mysqli");
		
		//Desarrollo
		//$this->VP->Connect(self::$db_host, self::$db_user, self::$db_pass);

		//Pruebas
		$this->conexionDB->connectSID = true;
		$this->conexionDB->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
	
		
    }
	
	function Query($consulta){
		$s = $this->conexionDB->Execute($consulta);
		return $s;
	}
	
	function GetArray($consulta){
		$s = $this->conexionDB->getArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->conexionDB->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->conexionDB->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->conexionDB->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->conexionDB->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->conexionDB->getOne($consulta);
		return $s;
	}

	function IniciaTransaccion(){

		$this->conexionDB->StartTrans();
	}

	function EjecutaTransaccion($transaccion){
		$this->conexionDB->execute($transaccion);
		if ($this->conexionDB->hasFailedTrans() == true){
		    echo $this->conexionDB->errorMsg()."<br>";
		}
	}

	function FinalizaTransaccion(){
		$this->conexionDB->CompleteTrans();
	}

	function errorMsg(){
		return $this->conexionDB->errorMsg();
	}

	function BeginTrans() {
		return $this->conexionDB->BeginTrans();
	}

	function RollbackTrans() {
		return $this->conexionDB->RollbackTrans();
	}

	function CommitTrans() {
		return $this->conexionDB->CommitTrans();
	}
	
	function Close(){
		$this->conexionDB->close();
	}
	
}
?>
