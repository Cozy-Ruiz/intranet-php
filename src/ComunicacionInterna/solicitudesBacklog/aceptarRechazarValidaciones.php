<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
require_once("MailNuevaFuncionalidad.php");

$solicitudID = $_POST['codigo'];
$status = $_POST['status'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario']; 
$tipo = $_POST['tipo'];

$s = $INTRANET->Execute("SELECT
							(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId), 
							(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = QS2.kf_usuarioId),
							(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = QS2.xt_pdr), 
							(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = QS2.xt_pdr) 
							FROM SGI_Quejas_Solicitudesv2 QS2
							where QS2.xt_quejaSolicitud = '$solicitudID'");
while($r = $s->FetchRow()){
	$nombreSolicitante = $r[0];
	$correoSolicitante = $r[1];
	$nombrePDR = $r[2];
	$correoPDR = $r[3];
}


if($tipo == "TRASLADO_USUARIO"){
	//hago consulta para saber que validacion tiene asignada      
	$statusValidacion = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Traslado_Usuario where xt_quejaSolicitud ='$solicitudID' ");
	
	
	if (empty($statusValidacion)){
	
		$INTRANET->Execute("INSERT INTO SGI_Backlog_Traslado_Usuario (xt_quejaSolicitud, xt_status, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', '$usuario', '$comentario')");
		//actualizo el status
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");

		
	}else{
		
		$INTRANET->Execute("UPDATE SGI_Backlog_Traslado_Usuario SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' ");
		//Actualizo el status
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$solicitudID'");

	}
}else{
	//hago consulta para saber que validacion tiene asignada      
	$statusValidacion = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = '$tipo'");
	
	
	if (empty($statusValidacion)){
	
		$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', '$tipo', '$usuario', '$comentario')");
		//actualizo el status
		//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'ACEPTADA' WHERE xt_quejaSolicitud = '$solicitudID'");
		
	}else{
		
		$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = '$tipo'");
		
	}
}

if($status == "ACEPTADA" && $tipo == "TECNICA"){
	
	//actualizo estado a validar negocio
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'VALIDACION DE NEGOCIO' WHERE xt_quejaSolicitud = '$solicitudID'");

	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, '', '', 'directivos@escalante.com.mx', 'Directivos', 'ValidacionTecnicaProcede');	
	
}else if($status == "ACEPTADA" && $tipo == "NEGOCIO"){
	
	//actualizo estado a validar final
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'VALIDACION FINAL' WHERE xt_quejaSolicitud = '$solicitudID'");
	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, $correoPDR, $nombrePDR, '', '', 'ValidacionNegocioProcede');
		
}else if($status == "ACEPTADA" && $tipo == "FINAL"){
	
	//actualizo estado a ACEPTADA
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'ACEPTADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, '', '', 'directivos@escalante.com.mx', 'Directivos', 'ValidacionFinalProcede');	
	
}else if($status == "RECHAZADA" && $tipo == "TECNICA"){
	
	//actualizo estado a ACEPTADA
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'RECHAZADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, '', '', 'directivos@escalante.com.mx', 'Directivos', 'ValidacionTecnicaNoProcede');	
	
}else if($status == "RECHAZADA" && $tipo == "NEGOCIO"){
	
	//actualizo estado a ACEPTADA
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'RECHAZADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, $correoPDR, $nombrePDR, '', '', 'ValidacionNegocioNoProcede');
		
}else if($status == "RECHAZADA" && $tipo == "FINAL"){
	
	//actualizo estado a ACEPTADA
	$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'RECHAZADA' WHERE xt_quejaSolicitud = '$solicitudID'");
	new MailNuevaFuncionalidad($solicitudID, $correoSolicitante, $nombreSolicitante, '', '', 'directivos@escalante.com.mx', 'Directivos', 'ValidacionFinalNoProcede');	
} 

?>
<script>
	window.location.reload();
</script>
