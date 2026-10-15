<?php error_reporting(0); ?>
<?php
$nombrephp='guardaEnvioArchivos.php';
require_once("../../ConexionDBT.php");
require_once("MailSolicitudAsignar.php");


$fecha         = $_POST['fecha'];
$grupo         = $_POST['grupo'];
$ciudad        = $_POST['ciudad'];
$titulo        = $_POST['titulo'];
$descripcionRequerimiento = $_POST['descripcion'];
$solicitante   = $_POST['solicitante'];
$asignaPDR   = 'Rodrigo_Romo';
$usuarioId   = $_POST['usuario'];

/*
if($_POST["descripcion1"] != ''){
	$descripcion = $_POST["descripcion1"];
	$tipoEnvio   = $_POST["tipo"];
	$rfc         = $_POST["RFC1"];

}else if($_POST["descripcion2"] != ''){		
	$descripcion = $_POST["descripcion2"];
	$tipoEnvio   = $_POST["tipo"];
	$rfc         = $_POST["RFC2"];		

}else if($_POST["descripcion3"] != ''){		
	$descripcion = $_POST["descripcion3"];
	$tipoEnvio   = $_POST["tipo"];
	$rfc         = $_POST["RFC3"];		

}else if($_POST["descripcion4"] != ''){		
	$descripcion = $_POST["descripcion4"];
	$tipoEnvio   = $_POST["tipo"];
	$rfc         = $_POST["RFC4"];		
}
*/
$anio   = date('Y', strtotime($_POST['fecha']));
$maximo = 0;

$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");
			while($r = $s->fetchRow()){	
				$maximo = $r[0];	
			} unset($r); unset($s);
						
$maximo++;
$año   = date('y', strtotime($_POST['fecha']));

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
 $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigoNuevo;
 
if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_solicitanteOriginal, xt_pdr) VALUES('EA', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcionRequerimiento', '$usuarioId', '$grupo', 'SIN ASIGNAR', '$solicitante', '$asignaPDR') ")){
													   
	$INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
	
	//Envia a correo al PDR y Solicitante
	 
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) 
												VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
													
													
		$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		
		$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
		$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");

		if(($correoPDRMail != "") && ($nombrePDRMail != "")){
				
			new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcionRequerimiento, $entregable = null);
		
		 }
		 //$INTRANET->Execute("INSERT INTO SGI_Backlog_Documentos(xt_quejaSolicitud, xt_tipoDocumento, xt_nombreArchivo, xt_ruta, xt_usuario) VALUES ('$codigoSolicitud','$tipoEnvio', '', '','$usuarioId')");
												
												
	}
}
?>
  <!-- recargo pagina -->
  <script language="javascript">
      window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=<?php echo $codigoSolicitud; ?>"
  </script>
 <?php
   						

?>