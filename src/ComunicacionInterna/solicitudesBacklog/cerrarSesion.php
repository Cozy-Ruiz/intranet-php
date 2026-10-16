<?php error_reporting(0); ?>
<?php
/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 1.0
 *@copyright Copyright (c) 2015, Grupo Escalante Agencias Aduanales S.C.
 */
 
require_once("ConexionDBT.php");

session_start();

$sesionId = $_SESSION["sesionIntranetId"];
$sesionUsuario = $_SESSION["sesionIntranetUsuario"];
$sesionFechaSalida = date('Y-m-d');
$sesionHoraSalida = date('H:i:s');

$INTRANET->Execute("update IntranetGEA_SESIONES_USUARIOS set xd_fechaSalida = '$sesionFechaSalida', xt_horaSalida = '$sesionHoraSalida' where kp_sesionId = $sesionId and kf_usuario = '$sesionUsuario' ");

//session_destroy();
header("Location: https://escalante.com.mx/Sistemas/seleccionaSistema.php");

?>