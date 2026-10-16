<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
$solicitudID = $_POST['codigo'];
$status = $_POST['status'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario']; 

//hago consulta para saber que validacion tiene asignada
       
$statusValidacionT = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'TECNICA'");

if (empty($statusValidacionT)){


	$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'TECNICA', '$usuario', '$comentario')");
	
}else{
	
	$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'TECNICA'");
	
}

?>
<script>
	window.location.reload();
</script>
