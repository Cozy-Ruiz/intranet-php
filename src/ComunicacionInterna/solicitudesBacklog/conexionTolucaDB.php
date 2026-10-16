<?php error_reporting(0); ?>
<?php
    
    require_once("../Librerias/adodb/adodb.inc.php");
	ini_set("display_errors", 1);
	ini_set('display_errors', 'On');
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	///////////////////////////////////////////////////////////
	//Conexion Para TIACE
	//direccion actualizada cada hora 201.144.217.246
	//direccion actualizada cada dia 201.144.217.251
	
	$SCIATOLUCA = ADONewConnection("oci8");
	
    $TOLUCA ="
    (DESCRIPTION = 
       (ADDRESS_LIST =
         (ADDRESS = (PROTOCOL = TCP)(HOST = nyetoluca.dyndns.org)(PORT = 33200))
       )
     (CONNECT_DATA =
       (SERVICE_NAME = TOLUCA11g)
     ) 
    )";
    $SCIATOLUCA->Connect($TOLUCA, "scia", "scia");
	
	

	///////////////////////////////////////////////////////////
	
?>
