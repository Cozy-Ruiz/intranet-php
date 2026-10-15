<?php error_reporting(0); ?>
<?php
$nombrephp='guardaEntregableAltaBaja.php';
require_once("../../ConexionDBT.php");
require_once("MailSistemaAsignar.php");
			 
 $asignaSistema = $_POST['asignaAdministrador'];
 $sistemas    = $_POST['sistemas'];
 $codigoAdmin = $_POST['codigoAdministrador'];
 $descripcionAdmin = $_POST['descripcionPermiso'];
 $tituloAdmin = $_POST['tituloPermiso'];
 $oficina     = $_POST['ciudad'];
 $tipoAdm     = $_POST['tipoSol'];

 $consecutivo = 0;
 
 $userSolicitante = $INTRANET->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoAdmin'");

 $s = $INTRANET->Execute("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
	while($r = $s->fetchRow()){
		$consecutivo = $r[0];
	}unset($r);
	
  $consecutivo++;
	  
  $codigoE = $oficina."-AB-";
	  
  //Crea el codigo de la Solicitud para el entregable
  if(strlen($consecutivo) == 1){	
	  $codigoE =$codigoE."0000".$consecutivo;
	  
  } else if(strlen($consecutivo) == 2){
	  $codigoE = $codigoE."000".$consecutivo;
	  
  } else if(strlen($consecutivo) == 3){
	  $codigoE = $codigoE."00".$consecutivo;
	  
  } else if(strlen($consecutivo) == 4){
	  $codigoE = $codigoE."0".$consecutivo;
	  
  }else if(strlen($consecutivo) >= 5){
	  $codigoE = $codigoE.$consecutivo;
	  
  } 
  
  $posicion = 0;
  
  $y = $INTRANET->Execute("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$asignaSistema' ");
  while($q = $y->fetchRow()){
		  
	  $posicion = $q[0];
	  
  } unset($q);
  
  $posicion++;
  
  //echo $codigoAdmin.$codigoE.$descripcionAdmin.$sistemas.$posicion.$asignaSistema;
  
  //Inserta Entregable y nombre del PDR asignado para Alta/Baja de Sistema
  if($INTRANET->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable,xt_titulo,xt_descripcion,xt_solicitud, xn_consecutivo, xn_progreso, xt_prioridad) VALUES ('$codigoE','$tituloAdmin','$descripcionAdmin','$codigoAdmin', '$consecutivo', 0, 'Normal')")){
	  
	  $INTRANET->Execute("INSERT INTO BACKLOG.PDR (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaSistema','$posicion')");
	  
	  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaSistema','$posicion')");
	  
	  $INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud,xt_prioridad,xt_usuario, xt_justificacion) VALUES ('$codigoAdmin','Normal','$asignaSistema','')");
	  
	  $INTRANET->Execute("UPDATE SGI_Backlog_Solicitud_Sistemas_Temporal SET xt_codigoEntregable = '$codigoE' WHERE xt_quejaSolicitud = '$codigoAdmin' and xt_sistema = '$sistemas' ");
	  
	  //$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$codigoAdmin',3,'ASIGNADA','Se Asigno PDR','$fecha','$asignaSistema')"); 
			
      //$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$codigoAdmin',4,'EN ESPERA','Se Asigno PDR','$fecha','$asignaSistema')");
	  
	/*  $INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'EN ESPERA' WHERE xt_quejaSolicitud = '$codigoAdmin'");*/
  
	  $correoAdministrador = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaSistema' ");
	  $nombreAdministrador = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaSistema' ");
	  
	  $correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$userSolicitante' ");
      $nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$userSolicitante' ");
	  
		  new MailSistemaAsignar($codigoE, $codigoAdmin, $correoAdministrador, $nombreAdministrador, $correoSolicitante, $nombreSolicitante, $tipoAdm, $tituloAdmin, $descripcionAdmin,$sistemas,$INTRANET);
		  
		?>
            <!-- recargo pagina -->
            <script language="javascript">
                window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaAltaBajaUsuario.php?codigo=<?php echo $codigoAdmin; ?>"
            </script>
		<?php  														
  
  }
?>