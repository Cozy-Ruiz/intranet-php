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
	
	$SCIAVERACRUZ = ADONewConnection("oci8");
	
    $VERACRUZ ="
    (DESCRIPTION = 
       (ADDRESS_LIST =
         (ADDRESS = (PROTOCOL = TCP)(HOST = 187.157.180.68)(PORT = 1521))
       )
     (CONNECT_DATA =
       (SERVICE_NAME = veracruz)
     ) 
    )";
    $SCIAVERACRUZ->Connect($VERACRUZ, "scia", "scia");
	

	
	

	///////////////////////////////////////////////////////////
	
?>
