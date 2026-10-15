<?php error_reporting(0); ?>
<?php


$nombrephp = 'guardaAltaBaja_Usuario.php';
require_once("../../ConexionDBT.php");
require_once("MailSolicitudAsignar.php");

if(isset($_POST['titulo'])){
	$usuarioId = $_GET['usuario'];
	$fecha         = $_POST['fecha'];
	$grupo         = $_POST['grupo'];
	$ciudad        = $_POST['ciudad'];
	$titulo        = $_POST['titulo'];
	$descripcion   = $_POST['descripcion'];
	$sistema       = $_POST['sistema'];
	$tipoSolicitud = $_POST['tipoSolicitud'];
	$sistemasBaja  = $_POST['sistemaActual'];
	$asignaPDR     = 'Alberto_Martinez';  
	
	
	//Datos para el Envío FTP
	$host = "71.144.19.155";
	$port = 21;
	$user = "Imagenes";
	$pass = "Img2012Server";
  

	$anio   = date('Y', strtotime($_POST['fecha']));
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");
	
	while($r = $s->fetchRow()){	
		$maximo = $r[0];	
	} unset($r); unset($s);
	
	$maximo++;
	$año   = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		$codigo = $codigo."-0000".$maximo;
	}else if(strlen($maximo) == 2){		
		$codigo = $codigo."-000".$maximo;	
	}else if(strlen($maximo) == 3){		
		$codigo = $codigo."-00".$maximo;	
	}else if(strlen($maximo) == 4){		
		$codigo = $codigo."-0".$maximo;		
	}else if(strlen($maximo) >= 5){		
		$codigo = $codigo."-".$maximo;		
	}
	//Se crea codigo para la Solicitud
	 $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigo;
	 
	 
	 if($tipoSolicitud == 'BAJA'){
		 
			if($sistemasBaja == ''){
				?>
                <script type="text/javascript">
				  alert("Debes de seleccionar un usuario de la lista");
				</script>            
                
                <?php
				echo"<script language='javascript'>window.location='altaBaja_Usuario.php'</script>;";
			 
			 }else{
			 
				if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR','$asignaPDR') ")){
					
					$INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
					

											
					if(count($sistemasBaja) > 0){
						foreach($sistemasBaja as $sistemas) {
							 //echo" INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ";
							 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
						 }
					}/*else if(count($sistema) == 0 && count($sistemasBaja) > 0){
						/*foreach($sistemasBaja as $sistemas) {
							 echo"INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ";
							 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
						}
					}*/
				 //Envia a correo al PDR y Solicitante
				}
				 
				if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){

						 $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION); 
						 
						 if($extension != ''){
						  
						  $directorioCompleto = "FotoSolicitudTemporal";
					  
							 if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
									
									$nombreArchivo = "FotoBaja.".$extension;
					
									$ruta_archivo = $directorioCompleto."/".$nombreArchivo;
									
									if (@move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)){
										
								
										  $conFtp = @ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
										  
										  if($conFtp){
											  
											  if(@ftp_login($conFtp, $user, $pass)){
								
												  $ruta = "/INTRANET/documentosSolicitudes/$codigoSolicitud/";//"/pub/inbound/";
												  
												   $dir = "/INTRANET/documentosSolicitudes/".$codigoSolicitud;//"/pub/inbound/";
												  
												  //Iniciamos en modo pasivo
												  ftp_pasv($conFtp, true);
												  
												   if (@ftp_mkdir($conFtp, $dir)) {
								
													  //Cambiamos al directorio solicitado
													  if(@ftp_chdir($conFtp, $ruta)){
									
															  if(ftp_put($conFtp, $nombreArchivo, $ruta_archivo, FTP_BINARY)){
																  
																  $nombreArchivoSolcitud = "D:/INTRANET/documentosSolicitudes/".$codigoSolicitud."/".$nombreArchivo;
																  
																  if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$nombreArchivoSolcitud' WHERE xt_quejaSolicitud = '$codigoSolicitud' AND xt_tipoSolicitud = 'AB' ")){
				
																  
																  unlink($ruta_archivo);
																  
																  }
																 
															  }else{
									
																  echo "Error al mover el archivo";
															  }
													  }else{
									
														  echo "Error al tratar de entrar al directorio solicitado.";
													  }
												   }
								
											  }else{
								
												  echo "Error al acceder al FTP.";
											  }
										  }
									}
							 }
						
															
					$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					
					$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
					$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			
					if(($correoPDRMail != "") && ($nombrePDRMail != "")){
							
					//	new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion, $entregable= null, $prioridad = null, $posicion = null);
					
					}
					
				 }
					echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigoSolicitud)."'</script>;";
			 }
		} 
	 }else{
		 
				if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR','$asignaPDR') ")){
					
					$INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
														
					if(count($sistema) >0 && count($sistemasBaja) == 0){
						foreach($sistema as $sistemas) {
							// echo"INSERT INTO SGI_Backlog_Ubicacion (xt_quejaSolicitud, xt_sistema) VALUES ('$codigoSolicitud','$sistemas') ";
							 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
						 }
					}else if(count($sistema) == 0 && count($sistemasBaja) > 0){
						foreach($sistemasBaja as $sistemas) {
							// echo"INSERT INTO SGI_Backlog_Ubicacion (xt_quejaSolicitud, xt_sistema) VALUES ('$codigoSolicitud','$sistemas') ";
							 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
						}
					}
				 //Envia a correo al PDR y Solicitante
				}
				 
				if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
					
			
						 $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION); 
						 
						 if($extension != ''){
						  
						  $directorioCompleto = "FotoSolicitudTemporal";
					  
							 if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
									
									$nombreArchivo = "FotoAlta.".$extension;
					
									$ruta_archivo = $directorioCompleto."/".$nombreArchivo;
									
									if (@move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)){
										
								
										  $conFtp = @ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
										  
										  if($conFtp){
											  
											  if(@ftp_login($conFtp, $user, $pass)){
								
												  $ruta = "/INTRANET/documentosSolicitudes/$codigoSolicitud/";//"/pub/inbound/";
												  
												   $dir = "/INTRANET/documentosSolicitudes/$codigoSolicitud";//"/pub/inbound/";
												  
												  //Iniciamos en modo pasivo
												  ftp_pasv($conFtp, true);
												  
												   if (file_exists($conFtp, $dir) || @ftp_mkdir($conFtp, $dir)) {
								
													  //Cambiamos al directorio solicitado
													  if(@ftp_chdir($conFtp, $ruta)){
														  
														
															  if(ftp_put($conFtp, $nombreArchivo, $ruta_archivo, FTP_BINARY)){
																  
																  $nombreArchivoSolcitud = "D:/INTRANET/documentosSolicitudes/".$codigoSolicitud."/".$nombreArchivo;
																  
																  if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$nombreArchivoSolcitud' WHERE xt_quejaSolicitud = '$codigoSolicitud' AND xt_tipoSolicitud = 'AB' ")){
				
																  
																  unlink($ruta_archivo);
																  
																  }
																 
															  }else{
									
																  echo "Error al mover el archivo";
															  }
													  }else{
									
														  echo "Error al tratar de entrar al directorio solicitado.";
													  }
												   }
								
											  }else{
								
												  echo "Error al acceder al FTP.";
											  }
										  }
									}
							 }
						 }
		 											
					$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					
					$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
					$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			
					if(($correoPDRMail != "") && ($nombrePDRMail != "")){
							
						//new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion, $entregable= null,  $prioridad = null, $posicion = null);
					
					}
					
			
					echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigoSolicitud)."'</script>;";
				}
		 }
}
			
/*

$nombrephp = 'guardaAltaBaja_Usuario.php';
require_once("../../ConexionDBT.php");

//Datos para el Envío FTP
$host = "71.144.19.155";
$port = 21;
$user = "Imagenes";
$pass = "Img2012Server";

	 
	 $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION); 
	  
	  $directorioCompleto = "ArchivoTemporal";
  
 		 if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
				
				$nombreArchivo = "FotoAlta.".$extension;

				$ruta_archivo = $directorioCompleto."/".$nombreArchivo;
				
				if (@move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)){
					
			
					  $conFtp = @ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
					  
					  if($conFtp){
						  
						  if(@ftp_login($conFtp, $user, $pass)){
			
							  $ruta = "/INTRANET/documentosSolicitudes/GE-B-DF-16-00915/";//"/pub/inbound/";
							  
							  //Iniciamos en modo pasivo
							  ftp_pasv($conFtp, true);
			
							  //Cambiamos al directorio solicitado
							  if(@ftp_chdir($conFtp, $ruta)){
			
									  if(ftp_put($conFtp, $nombreArchivo, $ruta_archivo, FTP_BINARY)){
										  
										  unlink($ruta_archivo);
										 
									  }else{
			
										  echo "Error al mover el archivo";
									  }
							  }else{
			
								  echo "Error al tratar de entrar al directorio solicitado.";
							  }
			
						  }else{
			
							  echo "Error al acceder al FTP.";
						  }
					  }
				}
		 }*/
		
			?>