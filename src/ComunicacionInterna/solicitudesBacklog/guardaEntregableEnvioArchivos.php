<?php error_reporting(0); ?>
<?php

$nombrephp='guardaEntregableEnvioArchivos.php';
require_once("../../ConexionDBT.php");
require_once("MailEnvioAsignar.php");


	   $asignaEnvio   = $_POST['asignaAdministrador'];
       $tipoEnvioAdm  = $_POST['tipoEnvio'];
       $codigoAdmin   = $_POST['codigoAdministrador'];
       $descripcionAdmin = $_POST['descripcionSoli'];
       //$descEnvioAdm  = $_POST['descripcionEnvio'];
       $tituloAdmin   = $_POST['tituloSoli'];
       $oficina       = $_POST['ciudad'];
       $rfc           =  $_POST['rfc'];
	   $fecha         = date("Y-m-d");
       
       $userSolicitante = $INTRANET->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoAdmin'");

       $consecutivo = 0;
        
        $s = $INTRANET->Execute("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
        while($r = $s->fetchRow()){
            
            $consecutivo = $r[0];
            
        } unset($r);
        
        $consecutivo++;
        
        $codigoE = $oficina."-EA-";
        
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
        
        $y = $INTRANET->Execute("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$asignaEnvio' ");
        while($q = $y->fetchRow()){
            
            $posicion = $q[0];
            
        } unset($q);
        
        $posicion++;
		
		//echo $codigoE."-".$posicion;
        
		
        if($INTRANET->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable, xt_titulo, xt_descripcion, xt_solicitud, xt_prioridad, xt_tipo, xn_consecutivo, xn_progreso) VALUES ('$codigoE','$tituloAdmin','$descripcionAdmin','$codigoAdmin', 'Normal', '', '$consecutivo', 0)")){
    
            $INTRANET->Execute("INSERT INTO BACKLOG.PDR (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaEnvio','$posicion')");	
            
            $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaEnvio','$posicion')");	
            
            $INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud,xt_prioridad,xt_usuario, xt_justificacion) VALUES ('$codigoAdmin','Normal','$asignaEnvio','')");
			
			//$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$codigoAdmin',3,'ASIGNADA','Se Asigno PDR','$fecha','$asignaEnvio')"); 
			
    		//$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$codigoAdmin',4,'EN ESPERA','Se Asigno PDR','$fecha','$asignaEnvio')");
			
			$INTRANET->Execute("INSERT INTO SGI_Backlog_Envio_Archivos (xt_quejaSolicitud, xt_entregable, xt_tipoEnvio) VALUES ('$codigoAdmin','$codigoE','$tipoEnvioAdm')");
			
			/*$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'EN ESPERA' WHERE xt_quejaSolicitud = '$codigoAdmin'");
            */
            $correoAdministrador = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaEnvio' ");
            $nombreAdministrador = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaEnvio' ");
			
			$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$userSolicitante' ");
            $nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$userSolicitante' ");
            
                new MailEnvioAsignar($codigoE, $codigoAdmin, $correoAdministrador, $nombreAdministrador, $correoSolicitante, $nombreSolicitante, $tituloAdmin, $descripcionAdmin, $tipoEnvioAdm, $INTRANET);
				
				?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=<?php echo $codigoAdmin; ?>"
				</script>
				<?php
   												
    
        }
		
?>