<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
require_once("asignarPDR.php");

$solicitud  = $_POST["codigo"];
$sistema    =  $_POST["codigoE"];


$INTRANET->Execute("UPDATE IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal SET xt_codigoEntregable = $codigoEntregable WHERE xt_quejaSolicitud = '$solicitud' AND xt_sistema = '$sistema' ");

?>
