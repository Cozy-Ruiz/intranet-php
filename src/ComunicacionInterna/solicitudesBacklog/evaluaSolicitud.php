<?php error_reporting(0); ?>
<?php
	//obtengo valores
	
	require_once("../../ConexionDBT.php");
	require_once("mailRevisionUsuario.php");
	
	  $evaluacion = $_POST['evaluacion'];
	  $descripcion = $_POST['descripcionEvaluacion'];
	  $codigoS = $_GET['codigoS'];
	  $usuario = $_GET['usuario'];
	  $tipoEvaluacion = $_POST['datoOculto'];
	  $fecha = $_GET['fecha'];
	 
	//obtengo el ultimo numero
	$maximo = $INTRANET->getOne("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigoS' ");
	//inserto estado en la tabla de ETAPAS
	$maximo+= 1;
	
	//obtengo el tipo de solicitud
	$tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoS'");
	
	if($tipoEvaluacion == "tipEvaluacion"){
		//si la verificacion es terminada inserto etapa de TERMINADA en la tabla de ETEPAS
		
		if($evaluacion == "TERMINADA"){
			
			//Inserto en la tabla de etapas con la etapa de terminada
			$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) VALUES ('$codigoS', $maximo, 'TERMINADA', '$descripcion', '$fecha', '$usuario')");
			
			//Actualizo estatus en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$codigoS'");
			
			if($tipoSolicitud == 'MT'){
			?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaMantenimiento_Sistema.php?codigo=<?php echo $codigoS; ?>"
				</script>
			<?php
			
			}else if($tipoSolicitud == 'EA'){
				
				?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=<?php echo $codigoS; ?>"
				</script>
				<?php
			
			}else if($tipoSolicitud == 'AB'){
				
				?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaAltaBajaUsuario.php?codigo=<?php echo $codigoS; ?>"
				</script>
				<?php
			
			}
		}
		
		if($evaluacion == "RECHAZADA"){
			
			//Inserto en la tabla de etapas
			$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) VALUES ('$codigoS', $maximo, 'ENTREGABLE RECHAZADO', '$descripcion', '$fecha', '$usuario')");
			//Actualizo estatus en la tabla de solicitudes
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'ENTREGABLE RECHAZADO' WHERE xt_quejaSolicitud = '$codigoS'");
			
			//mando llamar al correo para avisar que ha sido rechazado (se envia a gerente de sistemas)
				if($tipoSolicitud == 'MT'){
					?>
						<!-- recargo pagina -->
						<script language="javascript">
							window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaMantenimiento_Sistema.php?codigo=<?php echo $codigoS; ?>"
						</script>
					<?php
			
				}else if($tipoSolicitud == 'EA'){
				
					?>
					<!-- recargo pagina -->
					<script language="javascript">
						window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=<?php echo $codigoS; ?>"
					</script>
					<?php
			
				}else if($tipoSolicitud == 'AB'){
				
				?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaAltaBajaUsuario.php?codigo=<?php echo $codigoS; ?>"
				</script>
				<?php
			
			}
					
			}
	}
	
	if($tipoEvaluacion == "revision"){
		
		$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) VALUES ('$codigoS', $maximo, 'ENTREGABLE PARA REVISION', '$descripcion', '$fecha', '$usuario')");
		
		//obtengo datos del solicitante
		$usuarioSolicitante = $INTRANET->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoS'");
		$correoSolicitante = $INTRANET->getOne("SELECT xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitante'");
		$nombreSolicitante = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitante'");
		
		//Actualizo estatus en la tabla de solicitudes
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'REVISION' WHERE xt_quejaSolicitud = '$codigoS'");
			
		
		//mando llamar a la clase de correo al ususario para informar que ya se termino su entregable y que lo revise (se envia al usuario)
		//$enviaCorreo = new MailSolicitudAsignar($codigoS, $nombreSolicitante, $correoSolicitante, 'REVISION');
		if($tipoSolicitud == 'MT'){
			  ?>
				  <!-- recargo pagina -->
				  <script language="javascript">
					  window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaMantenimiento_Sistema.php?codigo=<?php echo $codigoS; ?>"
				  </script>
			  <?php
	  
		  }else if($tipoSolicitud == 'EA'){
		  
			  ?>
			  <!-- recargo pagina -->
			  <script language="javascript">
				  window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=<?php echo $codigoS; ?>"
			  </script>
			  <?php
	  
		  }else if($tipoSolicitud == 'AB'){
				
				?>
				<!-- recargo pagina -->
				<script language="javascript">
					window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaAltaBajaUsuario.php?codigo=<?php echo $codigoS; ?>"
				</script>
				<?php
			
			}
	}
	
?>

