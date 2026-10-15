<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'tableroRoles.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");


if(isset($_REQUEST['numeroLlave'], $_REQUEST['usuario'], $_REQUEST['oficina'])){
  	
	$INTRANETV2->Execute("DELETE FROM sgi_control_llaves WHERE xt_numeroLlave = '".$_REQUEST['numeroLlave']."' AND xt_usuario = '".$_REQUEST['usuario']."' AND xt_oficina = '".$_REQUEST['oficina']."' ");
	
}


