<?php error_reporting(0); ?>
<?PHP
$nombrephp="UpdatePersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

$IDpersonal		= $_POST['Id'];
$nombre 		= $_POST['nombre'];
$apellidoP 		= $_POST['apellidoP'];
$apellidoM 		= $_POST['apellidoM'];
$estatus 		= $_POST['estatus'];
$empresa 		= $_POST['empresa'];
$tipo 			= $_POST['tipo'];
$ciudad 		= $_POST['ciudad'];
$extencion 		= $_POST['extencion'];
$puesto 		= $_POST['puesto'];

$date = date('Y-m-d H:i:s');

$stamp = date('Y-m-d H:i:s',time() + 2191 );

$INTRANET->Execute("
	UPDATE SGI_Empleados SET xt_Nombre= '$nombre', xt_ApellidoPaterno= '$apellidoP', xt_ApellidoMaterno= '$apellidoM', xt_Estatus=$estatus, xt_Empresa= '$empresa', xt_tipo='$tipo', xt_modificado='$usuarioId,
	 $stamp',xt_ciudad='$ciudad', xt_extensionTel= '$extencion', xt_puesto='$puesto' WHERE kp_personalId= $IDpersonal ");

	
	header("Location: fichaPersonal.php?ID=$IDpersonal");




?>