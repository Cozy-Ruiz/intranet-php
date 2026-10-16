<?php error_reporting(0); ?>

<?php

require_once("../../ConexionDBT.php");
require_once("MailNuevaFuncionalidad.php");

$solicitudID = $_POST['codigo'];
$status = $_POST['status'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];
           
$statusLiberada = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Liberacion_Funcionalidad where xt_quejaSolicitud ='$solicitudID'");

if (empty($statusLiberada)){

	$INTRANET->Execute("INSERT INTO SGI_Backlog_Liberacion_Funcionalidad (xt_quejaSolicitud, xt_status, xt_usuario, xt_comentarios) VALUES ('$solicitudID', '$status', '$usuario', '$comentario')");
	//actualizo status en la solicitud
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	
}else{

	$INTRANET->Execute("UPDATE SGI_Backlog_Liberacion_Funcionalidad SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
	//actualizo status en la solicitud
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");
}

$s = $INTRANET->Execute("SELECT
							(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId), 
							(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId) 
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
