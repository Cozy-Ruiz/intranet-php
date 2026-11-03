<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../Librerias/adodb/adodb.inc.php");
putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
	
class ConexionCorresponsalias {
	
	public $CorresponsaliasDB;
	
	//private static $db_host = '192.1.169.35:33300';
	//private static $db_host = '201.147.92.138:33300';
	/*private static $db_host = 'gea-aicm.dyndns.org:1621';
	private static $db_user = 'CORRESPONSALIAS';
	private static $db_pass = 'corresponsalias';
	private static $db_name = 'LINKSDESA11G';*/

	private static $db_host = '192.1.172.9:3306';
    private static $db_user = 'GEA';
    private static $db_pass = '7b1QqK#m1F3m';
    private static $db_name = 'CORRESPONSALIAS';


	
   

     function __construct(){
		$this->CorresponsaliasDB = ADONewConnection("mysqli");
		$this->CorresponsaliasDB->Connect(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }
	
	function Query($consulta){
		$s = $this->CorresponsaliasDB->Execute($consulta);
		return $s;
	}


	
	function GetArray($consulta){
		$s = $this->CorresponsaliasDB->GetArray($consulta);
		return $s;
	}

	
	function GetAll($consulta){
		$s = $this->CorresponsaliasDB->getAll($consulta);
		return $s;
	}

	function GetCol($consulta){
		$s = $this->CorresponsaliasDB->getCol($consulta);
		return $s;
	}

	function GetRow($consulta){
		$s = $this->CorresponsaliasDB->getRow($consulta);
		return $s;
	}
	
	function Execute($consulta){
		$this->CorresponsaliasDB->Execute($consulta);
	}
	
	function GetOne($consulta){
		$s = $this->CorresponsaliasDB->getOne($consulta);
		return $s;
	}
	
	function Close(){
		$this->CorresponsaliasDB->close();
	}
	
} 


?>
