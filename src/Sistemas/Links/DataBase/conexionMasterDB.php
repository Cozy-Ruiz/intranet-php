<?php
    require_once("../../Librerias/adodb/adodb.inc.php");
    
	ini_set("display_errors", 1);
	ini_set('display_errors', 'On');
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	///////////////////////////////////////////////////////////
	
    //Conexion Para Servidor Desarrollo
	/*$IMAGENES = ADONewConnection('mysqli');
    $IMAGENES->Connect("192.1.172.3:3306","kio", "kionetworks", "IMAGENES");*/
	
	///////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////
	
    //Conexion Para Servidor Desarrollo
	$MASTER_GE = ADONewConnection('mysqli');
    $MASTER_GE->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), "MASTER_GE");
	
	//Conexion Para AVON
	$AVON = ADONewConnection('mysqli');
    $AVON->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'),  "AVON",true);
	
	//Conexion Para ALCATEL
	$IMAGENES = ADONewConnection('mysqli');
    $IMAGENES->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'),  "IMAGENES",true);
	
	///////////////////////////////////////////////////////////
	
?>