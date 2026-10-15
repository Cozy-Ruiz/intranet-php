<?php

	require_once("Librerias/adodb/adodb.inc.php");
	/*$db = ADONewConnection('mysql');
	$db -> Connect("207.249.139.195","kio", "kionetworks", "_radar_portafolio");
	$db->EXECUTE("set names 'utf8'"); */
	
	$INTRANETV2 = ADONewConnection('mysqli');
	$INTRANETV2 -> Connect("71.144.19.152:3306","sistemas", "gescalante1", "INTRANET2", true);
	mysqli_set_charset( $INTRANETV2, 'utf8');
	// $INTRANETV2->EXECUTE("set names 'utf8'");
	
	 //echo "Conexion Exitosa";
	
	

?>