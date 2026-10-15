<?php error_reporting(0); ?>
<?php
$nombrephp='liberaItem.php';
require_once("../ConexionDBT.php");
//require_once("compruebaUsuario.php");

$itemID  = $_GET['itemID'];
$usuario = $_GET['usuario'];
$tipo    = $_GET['tipo'];

$hoy = date("Y-m-d H:i:s");

$codigo = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID");

if($INTRANET->Execute("INSERT INTO SGI_Libera_Inventarios (kp_codigo, xt_usuario, xd_fecha, xt_tipo) VALUES ('$codigo','$usuario','$hoy','$tipo')") ){
				
	header ("Location: FichaItem.php?id=$itemID");
									
}
?>