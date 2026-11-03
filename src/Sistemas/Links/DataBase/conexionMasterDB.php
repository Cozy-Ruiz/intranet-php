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
    $MASTER_GE->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "MASTER_GE");
	
	//Conexion Para AVON
	$AVON = ADONewConnection('mysqli');
    $AVON->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m",  "AVON",true);
	
	//Conexion Para ALCATEL
	$IMAGENES = ADONewConnection('mysqli');
    $IMAGENES->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m",  "IMAGENES",true);
	
	///////////////////////////////////////////////////////////
	
?>