<?php
    ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require_once("Librerias/adodb/adodb.inc.php"); 
	$INTRANET = ADONewConnection('mysqli');
	//$INTRANET -> Connect("master.escalante.com.mx:3306","sistemas", "gescalante1", "getenv('LINKS_DB_NAME')");
	// $INTRANET->EXECUTE("set names 'utf8'");
		//$INTRANET	 ->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), getenv('LINKS_DB_NAME_V2'), true);
	$INTRANET -> Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER')), getenv('LINKS_DB_PASS'), getenv('LINKS_DB_NAME'));
	//$INTRANET->EXECUTE("SET NAMES 'utf8'");
	$INTRANET->setCharset('utf8');
	
	 //echo "Conexion Exitosa";
	
	 $INTRANETV2 = ADONewConnection('mysqli');
	 //$INTRANETV2 -> Connect("master.escalante.com.mx:3306","sistemas", "gescalante1", getenv('LINKS_DB_NAME_V2'), true); 	    $MASTER_GE- "MASTER_GE");
 
	 $INTRANETV2 ->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), getenv('LINKS_DB_NAME_V2'), true);
	 //$INTRANETV2->EXECUTE("SET NAMES 'utf8'");
	 $INTRANETV2->setCharset('utf8');

?>
