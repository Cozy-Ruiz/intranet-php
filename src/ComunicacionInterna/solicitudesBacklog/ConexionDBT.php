<?php error_reporting(0); ?>
<?php
    

	require_once("../../Librerias/adodb/adodb.inc.php");
	/*$db = ADONewConnection('mysql');
	$db -> Connect("207.249.139.195","kio", "kionetworks", "_radar_portafolio");
	$db->EXECUTE("set names 'utf8'"); */
	
	$INTRANET = ADONewConnection('mysql');
	$INTRANET -> Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "IntranetGEA");
	//$INTRANET->EXECUTE("set names 'utf8'");
	
	
	
	 //echo "Conexion Exitosa";

	//Conexion Para Servidor Desarrollo
	$MASTER_GE = ADONewConnection('mysql');
    $MASTER_GE->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "MASTER_GE",true);
	
	
	
	
	

?>
