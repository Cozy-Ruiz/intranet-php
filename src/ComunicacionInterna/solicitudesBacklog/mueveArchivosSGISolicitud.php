<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

 $codigoSolicitud = $_POST['codigo'];
 $codigoProceso = $_POST['codP'];
 $codigoRol = $_POST['codR'];
 $codigoActividad = $_POST['codA'];
 $codigoFuncionalidad = $_POST['codF'];
 $codigoCU = $_POST['codCU'];
 $usuario = $_POST['usuario'];

//inserto registro en la tabla de ubicacion

$INTRANET->Execute("UPDATE SGI_Backlog_Ubicacion SET xt_proceso = '$codigoProceso', xt_rol = '$codigoRol', xt_actividad = '$codigoActividad', xt_funcionalidad = '$codigoFuncionalidad', xt_casodeuso = '$codigoCU'");

//muevo archivos llamando a un archivo en laredo

echo '<script>window.location="http://71.144.19.155/INTRANET_GEA/Backlog/mueveArchivosSGISolicitudL.php?codigo='.$codigoSolicitud.'&codigoP='.$codigoProceso.'&codigoA='.$codigoActividad.'&codigoF='.$codigoFuncionalidad.'&codigoCU='.$codigoCU.'&usuario='.$usuario.'";</script>';


?>

