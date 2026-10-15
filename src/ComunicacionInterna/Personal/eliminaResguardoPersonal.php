<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'tableroRoles.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");


if(isset($_REQUEST['resguardoId'])){
  	
	//echo "DELETE FROM sgi_resguardo_articulos WHERE xn_index = '".$_REQUEST['resguardoId']."' ";
	$INTRANETV2->Execute("DELETE FROM sgi_resguardo_articulos WHERE xn_index = '".$_REQUEST['resguardoId']."' ");
	
}
