<?php
ini_set( 'upload_max_filesize' , '64M' );
ini_set( 'post_max_size', '64M');
ini_set("memory_limit","500M");
error_reporting(0);
$nombrephp = 'guardaAltaBaja_Usuario.php';
require_once("../../../../ConexionDBT.php");
require_once("../../../../ConexionIntranet2.php");
require_once("MailSolicitudAsignar.php");

if(isset($_POST['titulo'])){
	$usuarioId = $_GET['usuario'];
	$fecha         = $_POST['fecha'];
	$grupo         = $_POST['grupo'];
	$ciudad        = $_POST['ciudad'];
	$titulo        = $_POST['titulo'];
	$descripcion   = $_POST['descripcion'];
	$descripcion = str_replace("\n", "<br>", $descripcion);
	$rfc   = $_POST['rfc'];

	$descripcion .="<br> ".$rfc;
	$sistema       = $_POST['sistema'];	
	$tipoSolicitud = @$_POST['tipoSolicitud'];
	$sistemasBaja  = @$_POST['sistemaActual'];
	$asignaPDR     = 'Gerente_Sistemas';
	//Datos del servidor para el deposito del Archivo
	$host = "71.144.19.155";
	$port = 21;
	$user = "Imagenes";
	$pass = "Img2012Server";
  

	$anio   = date('Y', strtotime($_POST['fecha']));
	$maximo = 0;	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");	
	while($r = $s->fetchRow()){	
		$maximo = $r[0];	
	} unset($r); unset($s);
	
	$maximo++;
	$año   = date('y', strtotime($_POST['fecha']));
	$codigo = "";
	
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
	 
	 if($tipoSolicitud == 'BAJA' || $tipoSolicitud == 'BAJA_TOTAL'){	
		 
			if($sistemasBaja == ''){
				?>
                <script type="text/javascript">
				  alert("Debes de seleccionar un usuario de la lista");
				</script>            
                
                <?php
				echo"<script language='javascript'>window.location='altaBaja_Usuario.php'</script>;";
			 
			 }else{			 
				if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR','$asignaPDR') ")){
					
					$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
					

											
					if(count($sistemasBaja) > 0){	
						foreach($sistemasBaja as $sistemas) {
							  $INTRANETV2->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo, xt_codigoEntregable) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud', '') ");
						 }
					}/*else if(count($sistema) == 0 && count($sistemasBaja) > 0){
						/*foreach($sistemasBaja as $sistemas) {
							 echo"INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ";
							 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
						}
					}*/
				 //Envia a correo al PDR y Solicitante
				}				 
				if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){

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
																  
																  if($INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$nombreArchivoSolcitud' WHERE xt_quejaSolicitud = '$codigoSolicitud' AND xt_tipoSolicitud = 'AB' ")){
				
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
						
															
					//$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					$correoPDRMail = "gsistemas@escalante.com.mx";
					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
					
					$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
					$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			
					if(($correoPDRMail != "") && ($nombrePDRMail != "")){
						
						$mailSolicitudEnviar = new MailSolicitudAsignar;
						$mailSolicitudEnviar->mailSolicitudAsignarAcceso($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion, $entregable= null, $prioridad = null, $posicion = null);
					}					
				 }
					echo"<script language='javascript'>window.location='../fichaAltaBajaUsuario.php?codigo=".urlencode($codigoSolicitud)."'</script>;";
			 }
		} 
	 }else if($tipoSolicitud == 'ALTA'){	
					
		//echo "INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR','$asignaPDR') ";
		//echo $tipoSolicitud;
	  				if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR','$asignaPDR') ")){
	  					echo " ---paso";
	  					$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','Normal','$usuarioId')");
	  														
	  					if(count($sistema) >0 && count($sistemasBaja) == 0){
	  						foreach($sistema as $sistemas) {
	  							 $INTRANETV2->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo, xt_codigoEntregable) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud', '')");
							}
	  					}else if(count($sistema) == 0 && count($sistemasBaja) > 0){ 
	  						foreach($sistemasBaja as $sistemas) {

	  							 $INTRANETV2->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo, xt_codigoEntregable) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud', '')");

	  						}
	  					}
	  				 //Envia a correo al PDR y Solicitante
	  				}
	  				 
	  			if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
						echo "   --paso2";
						if(is_uploaded_file($_FILES['archivo']['tmp_name'])) {

					//if($SolicitanIntranet == 2){		
						//print_r($_FILES['archivo']);
						//$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
			  			$extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION); 
			  			$extension = strtolower($extension);
			  			/*if($extension == "tiff" || $extension == "jfif" || $extension == "bmp"|| $extension == "png"|| $extension == "jpeg"|| $extension == "jpg"|| $extension == "tif"|| $extension == "pjpeg"|| $extension == "png"){ 
			  						 if($extension != ''){*/
									
								echo "   --paso3";
			  						  $directorioCompleto = "FotoSolicitudTemporal";
									
			  							 if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
											echo "   --paso4";
										
			  									$nombreArchivo = "FotoAlta_".$codigoSolicitud."-".$sistemas.".".$extension;
										
			  									$ruta_archivo = $directorioCompleto."/".$nombreArchivo;
			  									///////EIBAR aki no sube ---->
												  if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
													echo "todo OK";
													}
			  									if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)){
												
													echo "   --paso5";
													$conFtp = @ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
												
			  										  if($conFtp){echo "   --paso conftp";	
													
			  											  if(@ftp_login($conFtp, $user, $pass)){echo "   --login";	
														
			  												  $ruta = "/INTRANET/documentosSolicitudes/$codigoSolicitud/";//"/pub/inbound/";
														
			  												   $dir = "/INTRANET/documentosSolicitudes/$codigoSolicitud";//"/pub/inbound/";
														
			  												  //Iniciamos en modo pasivo
			  												  ftp_pasv($conFtp, true);
														
			  												   if (@file_exists($conFtp, $dir) || @ftp_mkdir($conFtp, $dir)) {
																echo "   --pasomkdir";	
			  													  //Cambiamos al directorio solicitado
			  													  if(@ftp_chdir($conFtp, $ruta)){
																	echo "   --pasoftpchdir";	
																
			  															  if(ftp_put($conFtp, $nombreArchivo, $ruta_archivo, FTP_BINARY)){
																			echo "   --pasoput";	
			  																  $nombreArchivoSolcitud = "D:/INTRANET/documentosSolicitudes/".$codigoSolicitud."/".$nombreArchivo;
																		
			  																	if($INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$nombreArchivoSolcitud' WHERE xt_quejaSolicitud = '$codigoSolicitud' AND xt_tipoSolicitud = 'AB' ")){  	
																					echo "   --paso6";			
			  																		unlink($ruta_archivo);
			  																	}
										  								  	}else
										  								  		echo "Error al mover el archivo";
																		 	
																		}else
																			echo "Error al tratar de entrar al directorio solicitado.";
																	 }else
																	 echo "file exist";
																}else
																	echo "Error al acceder al FTP.";
															}else
															echo "Error con el conftp";
													  }else
													  echo "Error al mover foto";
											   }else
											   echo "Error archivo inexistente";
											} else
											echo "fallo de carga archiv";
										/*}
								}//extension*/
							//}solicitud  intranet
	  					//$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
	  					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
	  					$correoPDRMail = "gsistemas@escalante.com.mx";
	  					
	  					$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
	  					$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
	  			
	  					if(($correoPDRMail != "") && ($nombrePDRMail != "")){
	  							
	  						//new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion, $entregable= null,  $prioridad = null, $posicion = null);
	  						$mailSolicitudEnviar = new MailSolicitudAsignar;
	  						$mailSolicitudEnviar->mailSolicitudAsignarAcceso($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion, $entregable= null, $prioridad = null, $posicion = null);
	  					
	  					}
	  			
	  					echo"<script language='javascript'>window.location='../fichaAltaBajaUsuario.php?codigo=".urlencode($codigoSolicitud)."'</script>;";
		}
	}
}
		
?>