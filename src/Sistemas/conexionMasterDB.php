<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set('display_errors', 'On');
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	require_once("Librerias/adodb/adodb.inc.php");
	
	//Conexion Para Servidor Desarrollo
	$MASTER_GE = ADONewConnection('mysqli');
    //$MASTER_GE->Connect("master.escalante.com.mx:3306","kio", "kionetworks", "MASTER_GE");

	$MASTER_GE->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), "MASTER_GE");
	$MASTER_GE->setCharset('utf8');

?>
