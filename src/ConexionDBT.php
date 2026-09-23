<?php
    ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require_once("Librerias/adodb/adodb.inc.php"); 
	$INTRANET = ADONewConnection('mysqli');
	//$INTRANET -> Connect("master.escalante.com.mx:3306","sistemas", "gescalante1", "IntranetGEA");
	// $INTRANET->EXECUTE("set names 'utf8'");
		//$INTRANET	 ->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "INTRANET2", true);
	$INTRANET -> Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "IntranetGEA");
	//$INTRANET->EXECUTE("SET NAMES 'utf8'");
	$INTRANET->setCharset('utf8');
	
	 //echo "Conexion Exitosa";
	
	 $INTRANETV2 = ADONewConnection('mysqli');
	 //$INTRANETV2 -> Connect("master.escalante.com.mx:3306","sistemas", "gescalante1", "INTRANET2", true); 	    $MASTER_GE- "MASTER_GE");
 
	 $INTRANETV2 ->Connect("192.1.172.9:3306","GEA", "7b1QqK#m1F3m", "INTRANET2", true);
	 //$INTRANETV2->EXECUTE("SET NAMES 'utf8'");
	 $INTRANETV2->setCharset('utf8');

?>
