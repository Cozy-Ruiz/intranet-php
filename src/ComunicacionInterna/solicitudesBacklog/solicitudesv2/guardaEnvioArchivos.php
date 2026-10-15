<?php error_reporting(0); ?>
<?php
$nombrephp='guardaEnvioArchivos.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("MailSolicitudAsignar.php");
//declaro variabes con los datos recibidos
$fecha         = $_POST['fecha'];
$grupo         = $_POST['grupo'];
$ciudad        = $_POST['ciudad'];
$titulo        = $_POST['titulo'];
$descripcionRequerimiento = $_POST['descripcion'];
$solicitante   = $_POST['solicitante'];
$usuarioId   = $_POST['usuario'];
$anio   = date('Y', strtotime($_POST['fecha']));
//defino variables con datos constantes
$asignaPDR   = 'Gerente_Sistemas';
$maximo = 0;
//consulto el valor maximo del id en la tabla de solicitudes
$maximo = $INTRANETV2->GetOne("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo'");
//aumento el valor maximo para el siguiente registro a guardar						
$maximo++;
//defino el año actual
$año = date('y', strtotime($_POST['fecha']));
//completo codigo nuevo
if(strlen($maximo) == 1){
	@$codigoNuevo = $codigo."-0000".$maximo;
}else if(strlen($maximo) == 2){		
	@$codigoNuevo = $codigo."-000".$maximo;
}else if(strlen($maximo) == 3){		
	@$codigoNuevo = $codigo."-00".$maximo;
}else if(strlen($maximo) == 4){		
	@$codigoNuevo = $codigo."-0".$maximo;		
}else if(strlen($maximo) >= 5){		
	@$codigoNuevo = $codigo."-".$maximo;		
}
//Se crea codigo para la Solicitud
echo $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigoNuevo;

//echo "INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_solicitanteOriginal, xt_pdr) VALUES('EA', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcionRequerimiento', '$usuarioId', '$grupo', 'SIN ASIGNAR', '$solicitante', '$asignaPDR') <br>";
if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_solicitanteOriginal, xt_pdr) VALUES('EA', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcionRequerimiento', '$usuarioId', '$grupo', 'SIN ASIGNAR', '$solicitante', '$asignaPDR') ")){
		
	//echo "INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId') <br>";
	$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
	
	//Envia a correo al PDR y Solicitante
	//echo "INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') <br>";
	if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) 
		VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
													
													
		$correoPDRMail = 'gsistemas@escalante.com.mx';//$INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		$nombrePDRMail = 'Gerente de Sistemas';//$INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		
		$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
		$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");

		echo $correoSolicitante." - ".$nombreSolicitante." - ".$correoPDRMail." - ".$nombrePDRMail; 
		
		
		if(($correoPDRMail != "") && ($nombrePDRMail != "")){
			$mailSolicitudEnviar = new MailSolicitudAsignar;
			$mailSolicitudEnviar->mailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcionRequerimiento, $entregable = null, $prioridad = null, $posicion = null);
		}	
		
		echo "Envie correos";

		?>
		<!-- recargo pagina-->
		<script language="javascript">
			window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaEnvioArchivos.php?codigo=<?php echo $codigoSolicitud; ?>"
		</script>
		<?php
	}
}

?>