<?php error_reporting(0); ?>
<?php
    

	require_once("../../Librerias/adodb/adodb.inc.php");
	/*$db = ADONewConnection('mysql');
	$db -> Connect("207.249.139.195","kio", "kionetworks", "_radar_portafolio");
	$db->EXECUTE("set names 'utf8'"); */
	
	$INTRANET = ADONewConnection('mysql');
	$INTRANET -> Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), "IntranetGEA");
	//$INTRANET->EXECUTE("set names 'utf8'");
	
	
	
	 //echo "Conexion Exitosa";

	//Conexion Para Servidor Desarrollo
	$MASTER_GE = ADONewConnection('mysql');
    $MASTER_GE->Connect(getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'),getenv('LINKS_DB_USER'), getenv('LINKS_DB_PASS'), "MASTER_GE",true);
	
	
	
	
	

?>
