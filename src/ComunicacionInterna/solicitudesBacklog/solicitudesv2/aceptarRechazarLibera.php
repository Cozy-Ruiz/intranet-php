<?php error_reporting(0); ?>

<?php

require_once("../../../ConexionDBT.php");
require_once("MailNuevaFuncionalidad.php");
require_once("../../../ConexionIntranet2.php");


$solicitudID = $_POST['codigo'];
$status = $_POST['status'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];
           
$statusLiberada = $INTRANETV2->getOne("SELECT xt_status FROM SGI_Backlog_Liberacion_Funcionalidad where xt_quejaSolicitud ='$solicitudID'");

if (empty($statusLiberada)){

	$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Liberacion_Funcionalidad (xt_quejaSolicitud, xt_status, xt_usuario, xt_comentarios) VALUES ('$solicitudID', '$status', '$usuario', '$comentario')");
	//actualizo status en la solicitud
	$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	
}else{

	$INTRANETV2->Execute("UPDATE SGI_Backlog_Liberacion_Funcionalidad SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
	//actualizo status en la solicitud
	$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");
}

$s = $INTRANETV2->Execute("SELECT
							(select xt_nombre FROM IntranetGEA.IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId), 
							(select xt_correo FROM IntranetGEA.IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId) 
							FROM SGI_Quejas_Solicitudesv2 QS2
							where QS2.xt_quejaSolicitud = '$solicitudID'");
while($r = $s->FetchRow()){
	$nombreSolicitante = $r[0];
	$correoSolicitante = $r[1];
}

new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, '', '', '', '', 'LiberacionProcede');


?>
<script>
	window.location.reload();
</script>
