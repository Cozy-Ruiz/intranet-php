<?php error_reporting(0); ?>
<?php
//inclusiones de codigo php y parametros
require_once("../../ConexionDBT.php");

$solicitudID = $_POST['codigo'];
$status = $_POST['status'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];
$hoy = date("Y-m-d");

if($solicitudID != ''){
//hago consulta para saber que validacion tiene asignada

	$tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM IntranetGEA.SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");

	if($tipoSolicitud == 'EA'){
            
		$statusValidacionMS1 = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'ENVIOS'");
		
		if (empty($statusValidacionMS1)){
	
			//inserto en tabla de verificacones
			$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'ENVIOS', '$usuario', '$comentario')");
		
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			//posteriormente debo insertar en la tabla de estatusv2
		
			//$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES ('$solicitudID', 2, '$status', '$hoy', '$usuario')");
		
			//verifico el status si es RECHAZADA mando llamar al script de envio de correo
			if($status == "RECHAZADA"){
				
				//mando llamar a scrip para envio de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		
		}else{
		
			$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'ENVIOS'");
	
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			
			//tengo que hacer un for para definir cual sera el siguiente numero
			//posteriormente debo actualizar en la tabla de estatusv2
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = 2");
		
			//$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'ENVIOS'");
		
			//inserto en tabla de estatus
		
			//obtengo el estatus para definir a cual actualizare
			if($status == "ACEPTADA"){
			
				$statusVerifica = "RECHAZADA";
			
			}else if ($status == "RECHAZADA"){
			
				$statusVerifica = "ACEPTADA";
			}
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status', kf_usuario = '$usuario' WHERE  xt_quejaSolicitud = '$solicitudID' AND xt_estatus = '$statusVerifica'");
		
			if($statusVerifica == "RECHAZADA"){
				
				//mando llamar script de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		}
	}else if($tipoSolicitud == 'AB'){
		
		$statusValidacionMS1 = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'ALTA_BAJA'");
		
		if (empty($statusValidacionMS1)){
	
			//inserto en tabla de verificacones
			$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'ALTA_BAJA', '$usuario', '$comentario')");
		
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			
			//posteriormente debo insertar en la tabla de estatusv2
		
			//$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES ('$solicitudID', 2, '$status', '$hoy', '$usuario')");
		
			//verifico el status si es RECHAZADA mando llamar al script de envio de correo
			if($status == "RECHAZADA"){
				
				//mando llamar a scrip para envio de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		
		}else{
		
			$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'ALTA_BAJA'");
	
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			
			//tengo que hacer un for para definir cual sera el siguiente numero
			//posteriormente debo actualizar en la tabla de estatusv2
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = 2");
		
			//$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'ALTA_BAJA'");
		
			//inserto en tabla de estatus
		
			//obtengo el estatus para definir a cual actualizare
			if($status == "ACEPTADA"){
			
				$statusVerifica = "RECHAZADA";
			
			}else if ($status == "RECHAZADA"){
			
				$statusVerifica = "ACEPTADA";
			}
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status', kf_usuario = '$usuario' WHERE  xt_quejaSolicitud = '$solicitudID' AND xt_estatus = '$statusVerifica'");
		
			if($statusVerifica == "RECHAZADA"){
				
				//mando llamar script de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		}
		
	}
	else if($tipoSolicitud == 'MT'){
			$statusValidacionMS1 = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'MANTENIMIENTO'");
		
		if (empty($statusValidacionMS1)){
	
			//inserto en tabla de verificacones
			$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'MANTENIMIENTO', '$usuario', '$comentario')");
		
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			
			//posteriormente debo insertar en la tabla de estatusv2
		
			//$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES ('$solicitudID', 2, '$status', '$hoy', '$usuario')");
		
			//verifico el status si es RECHAZADA mando llamar al script de envio de correo
			if($status == "RECHAZADA"){
				
				//mando llamar a scrip para envio de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		
		}else{
		
			$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'MANTENIMIENTO'");
	
			//actualizo status en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$status' WHERE xt_quejaSolicitud = '$solicitudID'");
			
			//tengo que hacer un for para definir cual sera el siguiente numero
			//posteriormente debo actualizar en la tabla de estatusv2
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = 2");
		
			//$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'MANTENIMIENTO'");
		
			//inserto en tabla de estatus
		
			//obtengo el estatus para definir a cual actualizare
			if($status == "ACEPTADA"){
			
				$statusVerifica = "RECHAZADA";
			
			}else if ($status == "RECHAZADA"){
			
				$statusVerifica = "ACEPTADA";
			}
		
			//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_estatus = '$status', kf_usuario = '$usuario' WHERE  xt_quejaSolicitud = '$solicitudID' AND xt_estatus = '$statusVerifica'");
		
			if($statusVerifica == "RECHAZADA"){
				
				//mando llamar script de correo 
				echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailValidacion.php?codigo='.$solicitudID.'&usuarioV='.$usuario.'&descripcion='.urlencode($comentario).'";</script>';
			}
		}
	}
}

//recargo la pagina	
?>
<script>
	window.location.reload();
</script>
