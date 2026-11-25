<?php error_reporting(0); ?>
<?php

	require_once("Librerias/adodb/adodb.inc.php");
	/*$db = ADONewConnection('mysql');
	$db -> Connect("207.249.139.195","kio", "kionetworks", "_radar_portafolio");
	$db->EXECUTE("set names 'utf8'"); */
	
	$INTRANETV2 = ADONewConnection('mysqli');
	//$INTRANETV2 -> Connect("master.escalante.com.mx:3306","sistemas", "gescalante1", getenv('LINKS_DB_NAME_V2'), true); 	    $MASTER_GE- "MASTER_GE");

	$INTRANETV2 ->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), getenv('LINKS_DB_NAME_V2'), true);
	$INTRANETV2->setCharset('utf8');
	
	//echo "Conexion Exitosa";
	
	

?>