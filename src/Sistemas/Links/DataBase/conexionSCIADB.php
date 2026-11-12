<?php
require_once("../Librerias/adodb/adodb.inc.php");
    
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
	$SCIAX = ADONewConnection('oci8');
    $succes= $SCIAX->Connect("192.1.171.71:1521", "scia", "scia", "LAREDO");

if (!$succes) {
	die("Error de conexión: " . $SCIAX->ErrorMsg());
}else{
	//echo "Succes conection!";
}
	

	///////////////////////////////////////////////////////////
	
?>