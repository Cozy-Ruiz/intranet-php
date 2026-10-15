<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
require_once("MailSolicitudAsignar.php");
$fecha = date("Y-m-d");

//obtengo los datos de codigo y PDR
$solicitudID      = $_POST['codigo'];
$pdr              = $_POST['pdr'];
$sistema          = $_POST['sistema'];
$tituloEntregable = $_POST['titulo'];
$descripcionE     = $_POST['descripcion'];
$ciudadSolicitud  = $_POST['ciudad'];
$tipoSolicitud    = $_POST['tipoS'];


//obtenemos el titulo y la descripcion de la solicitd a partir del codigo de la solicitud
$n = $INTRANET->Execute("SELECT xt_titulo, xt_descripcion FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");

while($listDatosSol = $n->fetchRow()){
	
	$tituloSol = $listDatosSol[0];
	$descripcionSol = $listDatosSol[1];
}


//obtenemos datos de PDR y solicitante
//primero obtengo el usuario de solicitante a partir de la solicitud
$usuarioSolicitante = $INTRANET->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
$j = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitante'");

while($listDatos = $j->fetchRow()){
	
	$nombreSolicitante = $listDatos[0];
	$correoSolicitante = $listDatos[1];
}

//obtenemos datos del PDR
$r = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr'");

while($listDatosPDR = $r->fetchRow()){
	
	$nombrePDR = $listDatosPDR[0];
	$correoPDR = $listDatosPDR[1];
}



if($pdr != '' &&  $solicitudID != ''){
	
	//verifico si el tipo de solicitud es A/B o C/U el PDR sera el gerente de sistemas
	//if($tipoSolicitud == 'MT'){
		
		//actualizo registro en SGI_Quejas_Solicitudesv2 asignando el pdr 
  		//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'EN ESPERA', xt_pdr ='$pdr' WHERE xt_quejaSolicitud = '$solicitudID'");
	  
	//}else{
		
		//actualizo registro en SGI_Quejas_Solicitudesv2 asignando el pdr 
  		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'EN ESPERA', xt_pdr ='Rodrigo_Romo' WHERE xt_quejaSolicitud = '$solicitudID'");
	
	//}
  
  //actualizo registro en SGI_Quejas_Solicitudesv2 asignando el pdr 
 // if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'EN ESPERA', xt_pdr ='$pdr' WHERE xt_quejaSolicitud = '$solicitudID'")){
	  
	  //verificar si existe asignado un pdr en el status
	  $exisRev = $INTRANET->getOne("SELECT xt_estatus from SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus = 'EN ESPERA'");
	  
	  if($exisRev == ''){
		  
		  //registro en la tabla de estatus que fue asignada
		  $INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$solicitudID',3,'ASIGNADA','Se Asigno PDR','$fecha','$pdr')");	
		  
		  //registro en la tabla de estatus que se encuentra en revision
		  $INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud,xn_numero,xt_estatus,xt_contenido,xd_fecha,kf_usuario) VALUES ('$solicitudID',4,'EN ESPERA','Se Asigno PDR','$fecha','$pdr')");	
	  
		  //inserto en la tabla de entregables
	  
		  //obtengo el ultimo codigo de entregable insertado para definir el sig codigo
		  $maximo = 0;
		  $maximo = $INTRANET->getOne("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
		  if($maximo == ''){
			  $maximo = 1;
		  }else{
			   $maximo+= 1;
		  }
	  
		  if($maximo<10){ $clave = "0000".$maximo; }else if($maximo <100){$clave = "000".$maximo;}else if($maximo < 1000){$clave = "00".$maximo;}
			  else if($maximo<10000){$clave = "0".$maximo;}else if($maximo<100000){$clave = $maximo;}
	  
			  //inserto en la tabla de entregables los datos correspondientes
	  
			  //obtengo la prioridad de la solicitud
			  $prioridadS = $INTRANET->getOne("Select xt_prioridad FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fecha DESC");
	  
			  //defino el codigo de entregable
			  $codigoEntregable = $ciudadSolicitud.'-'.$tipoSolicitud.'-'.$clave;
	  
	  
			  if($INTRANET->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable, xt_titulo, xt_descripcion, xt_solicitud, xt_tipo, xt_prioridad, xn_consecutivo, xn_progreso) VALUES ('$codigoEntregable', '$tituloEntregable', '$descripcionE', '$solicitudID', '', '$prioridadS', $maximo, 0)")){
		  
				  //Prioridad NORMAL
				  if($prioridadS == 'Normal'){
		  
					  //ahora inserto en la tabla de PDR
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
	  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
					  }else{
						  $pos+= 1;	
					  }
  
					  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codigoEntregable','$pdr', $pos)");
		  
					  //Inserto en la tala de Historial_entregable
					  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', $pos)");
			  
			  		  //mando llamar a script de envio de correo de asignacion de PDR
					  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
					  
				  }//fin del if de verificacion de prioridad NORMAL
		  
		  
				  //Prioridad URGENTE
				  if($prioridadS == 'Urgente'){
		  
					  //ahora inserto en la tabla de PDR
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
	  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
				  
						  //inserto registro
						  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable','$pdr', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
						  VALUES ('$codigoEntregable', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
				  		 unset($pos);
					  }
				  
					  if($pos == 1){
					  
						  //inserto entregable urgente en segunda posicion
						  $pos+= 1;
						  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable','$pdr', $pos)");
			  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					 	 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
					  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
					  }
			  
					  if($pos > 1){
					  
						  $entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE xt_programador = '$pdr' ORDER BY xn_posicion ASC");
					  
						  $banderaCambio = 0;
						  $posModificado = 0;
						  while($r = $entPos->fetchRow()){
						  
							  $listCodE = $r[0];
							  $listPos = $r[1];
						  
							   //$codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
							   $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
						  
							  if($listPos > 1){
							  
								  //echo "es mayor a 1";
							  
								  if($listPos <= $pos && $prioridadCodS == "Normal"){
							  
									  //echo "fue normal";
							  
									  $banderaCambio = 1;
									  $posModificado = $listPos;
							  
									  break;
							  
								  }
							  
							  }//fin del if de verificacion de pos menor a 1, menor a pos e igual a urgente
						  
							  //limpio variables
							  unset($codS);
							  unset($prioridadCodS);
							  unset($listPos);
						  
						  }//fin del while 
				  
					  //verifico si existe anderaCambio = 1, para modificar posiciones
				  
					  if($banderaCambio == 1){
					  
					  
						  //modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
						  for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						  
							  $posOriginal = $recorre;
							  $nuevasPos = $recorre + 1;
						  
							  //actualizo las posiciones
							  //echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND xn_posicion = 	
							  //$posOriginal";
							  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND 	
							  xn_posicion = $posOriginal");
						  
							  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND xn_posicion = 	
							  $posOriginal");
						  
							  //Inserto en la tala de Historial_entregable
							  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 
							  VALUES ('$codH', '$pdr', $nuevasPos)");
						  
						  }//fin del for de actualización de posiciones
					  
						  //inserto el entregable en la posicion asignada
						  
					  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
						  ('$codigoEntregable','$pdr', $posModificado)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable', '$pdr', $posModificado)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
					  
					  
					  }else{
					  
						  //echo "entro else no bndera";
						  $pos+= 1;
					  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable','$pdr', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
					  
					  }//fin del else de verificacion de bandera cambio
				  
				 	 }// fin del if de verificacion donde pos sea mayor a 1
			  
			 	  }//fin del if de verificacion de prioridad URGENTE
		  
			      //PRIORIDAD EMERGENCIA
			  
				  if($prioridadS == "Emergencia"){
					  
					  //obtengo el numero total de posiciones de entregables en el pdr
					  $pos = 0;
			  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
					  '$pdr'");
			  
					  if($pos == ''){
				  
						  $pos = 1;
						  
						  //inserto registro
								  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
								  ('$codigoEntregable','$pdr', $pos)");
				  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
								  xn_posicion) VALUES ('$codigoEntregable', '$pdr', $pos)");
								  
							//mando llamar a script de envio de correo de asignacion de PDR
					  		$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
						  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
						  
					  }//fin del if donde pos es igual a vacio
					  
					  if($pos >= 1){
					  
						  $entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
						  xt_programador = '$pdr' ORDER BY xn_posicion ASC");
						  
						  $banderaCambio = 0;
						  $posModificado = 0;
						  $prioridadPosS = '';
						  
						  while($r = $entPos->fetchRow()){
							  
							   $listCodE = $r[0];
							   $listPos = $r[1];
									  
									  
							   $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
							  
							  if($listPos >= 1){
								  
								  //aqui defino si la prioridad es normal o urgente
								  if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
								  
									  $banderaCambio = 1;
									  $posModificado = $listPos;
											  
									  $prioridadPosS = $prioridadCodS;
								  
									  break;
								  
								  }
								  
							  }//fin del if de verificacion de pos mayor a 1, menor a pos e igual a urgente
							  
							  //limpio variables
							  unset($codS);
							  unset($prioridadCodS);
							  unset($listPos);
					  
						  }//fin del while 
				  
					  //verifico si existe anderaCambio = 1, para modificar posiciones
					  
					  if($banderaCambio == 1){
								  
						  //verifico la prioridad
						  if($prioridadPosS == "Urgente"){
						  
							  //modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
							  for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							  
								  $posOriginal = $recorre;
								  $nuevasPos = $recorre + 1;
							  
									  //actualizo las posiciones
									  
									  //obtengo el codigo del entregable para insertar en tabla historial
									  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							  
									  //actualizo posicion del entregable
									  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							  
									  //Inserto en la tala de Historial_entregable
										  
									  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
									  xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
							  
							  
							  }//fin del for de actualización de posiciones
									  
									  
							  //inserto el entregable en la posicion asignada
									  
							  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
							  xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
			  
							  //Inserto en la tala de Historial_entregable
							  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
							  xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', $posModificado)");
							  
							  //mando llamar a script de envio de correo de asignacion de PDR
					 		  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
								  
						  }//fin del if de verificacion cuando la prioridad del entregable donde se tomara su lugar sea URGENTE
								  
				       	 if($prioridadPosS == "Normal"){
									
							//verifico si las prioridades de los entregables que le siguen son urgentes y la pondre 	
							//despues del ultimo urgente, pero si todas son normales entonces solo bajare sus posiciones
									
							//verifico si es el unico entregale en la lista
							if($posModificado == $pos){
										
								//solo incremente posiciones
										
								//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las 		
								//actualizaciones de las posiciones en el for.
								for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							
									$posOriginal = $recorre;
									$nuevasPos = $recorre + 1;
							
									//actualizo las posiciones
									
									  //obtengo el codigo del entregable para insertar en tabla historial
									  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
					  
									  //actualizo posicion del entregable
									  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
					  
									  //Inserto en la tala de Historial_entregable
									  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
									  xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
							
							
								}//fin del for de actualización de posiciones
									
								//inserto el entregable en la posicion asignada
							
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
								xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
	
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
								xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
								$posModificado)");
								
								//mando llamar a script de envio de correo de asignacion de PDR
					  			$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
							
									  
						 	 }else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
						  
								  //echo "no es el unico entregable";
								  $banderaCambioP = 0;
								  $posModificadoP = 0;
					  
								  //obtengo los codigos de los entregables deacuerdo a su posicion
								  
								   $posSig = $posModificado + 1;
								  
								   for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
				  
										  //obtengo el codigo del entregable deacuedo a su posicion
										  $codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
										  xn_posicion = $recorrePos AND xt_programador = '$pdr'");
										  
										  //obtengo su prioridad
										  $prioriCodEP = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES 
										  WHERE xt_codigoEntregable = '$codEP'");
					  
										  if($prioriCodEP == 'Urgente'){
											    
											  $posModificadoP = $recorrePos;
											  $banderaCambioP = 1;
											  
										  }
							  
								   }//fin del for
										
									//verifico la banderacanbioP
									if($banderaCambioP == 1){
										//echo "entro bandera en urgente <br>";
										//pondre el entregable en la posicion inmediata del ultimo entregable con prioridad de emergencia
								
										 $posInserta = $posModificadoP + 1;
										
										//verifico si existe cupado dicho lugar por algun entregable
										$existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR 	
										WHERE xt_programador = '$pdr' AND xn_posicion = $posInserta");
										
										if($existeLugar != ''){
										
										   // echo "el lugar esta ocupado";
											//incremento posiciones
											
											//actualizaciones de las posiciones en el for.
											for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
						
												 $posOriginalU = $recorreU;
												 $nuevasPosU = $recorreU + 1;
						
												//actualizo las posiciones
								
						
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
												WHERE xt_programador = '$pdr' AND xn_posicion = 	
												$posOriginalU");
						
												//actualizo posicion del entregable
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE 	
												xt_programador = '$pdr' AND xn_posicion = $posOriginalU");
						
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 	
												(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 
												'$pdr', $nuevasPosU)");
						
						
											}//fin del for de actualización de posiciones
													  
											  //obtengo el codigo del entregable para insertar en tabla historial
											  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
											  WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
											  
											  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
											  xt_programador = '$pdr' AND xn_posicion = $posModificado");
						  
											  //Inserto en la tala de Historial_entregable
											  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
											  (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
											  '$pdr', $posInserta)");
											  
											  //mando llamar a script de envio de correo de asignacion de PDR
					 						 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codH);
					  
											  
							  
									     }else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
									  
											  //solo actualizo a la posicion
											  
											  //obtengo el codigo del entregable para insertar en tabla historial
											  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
											  
											  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
						  
											  //Inserto en la tala de Historial_entregable
											  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH','$pdr', $posInserta)");	  
											  
											  
										 }//fin del else donde solo actualizo 
												  
											//reasigno el entregable eliminado en el lugar 1
									  
											//inserto el entregable en la posicion asignada
							  
									  		$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
									  		xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
		
									  		//Inserto en la tala de Historial_entregable
									  		$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
									  		xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
									 		 $posModificado)");  
									  
									  		//mando llamar a script de envio de correo de asignacion de PDR
					  						$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
										
								  	 }else{
											
											//todos los entregables son normales
											
											//incrementamos los lugares de los entregables
											
											//actualizaciones de las posiciones en el for.
											for($recorreN = $pos; $recorreN >= 1; $recorreN --){
							
												$posOriginalN = $recorreN;
												$nuevasPosN = $recorreN + 1;
							
												//actualizo las posiciones
							
												//obtengo el codigo del entregable para insertar en tabla historial
													
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND xn_posicion = $posOriginalN");
													
												//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalN";
												//actualizo posicion del entregable
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$pdr' AND xn_posicion = $posOriginalN");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPosN)");
							
							
											}//fin del for de actualización de posiciones
												
												
											//obtengo el codigo del entregable para insertar en tabla historial
											$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND xn_posicion = $codigoEntregable");
											//echo "INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', 1)";
											$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codigoEntregable','$pdr', 1)");
												
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$pdr', 1)");
												
																
										}//fin del else donde bandera cambio no es 1
									
								  
							}//fin del else donde la posicion del entregable no esta en ultimo lugar
								  //obtengo 
								  
						}// fin del if donde verifico la prioridad a NORMAL  			  
					  
					  }else{
					
							//incremento todas las posiciones de entregables
									
							$pos+= 1;
							
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$codigoEntregable','$pdr', $pos)");
				
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$codigoEntregable', '$pdr', $pos)");			  
					
					  }//fin del else
			  
					  }//fin del if pos >= 1		  
			  
				  }//fin del if donde prioridad es EMERGENCIA
				  
			  }//fin del if de insercion en tabla ENTREGABLES  
		  
	  }else{	  
		  
		  //si existe solo actualizo el kf_usuario(pdr)
					  
		  $INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET kf_usuario = '$pdr' WHERE xt_quejaSolicitud = '$solicitudID' AND (xt_estatus = 'EN ESPERA' OR xt_estatus = 'ASIGNADA')");  
		  
		  //obtengo el codigo de entegable, el pdr asignado anteriormente y la posicion actual
	  
		  $ce = $INTRANET->Execute("SELECT E.xt_codigoEntregable, P.xt_programador, P.xn_posicion FROM BACKLOG.ENTREGABLES E INNER JOIN 
		  BACKLOG.PDR P WHERE E.xt_codigoEntregable = P.xt_codigoEntregable AND E.xt_solicitud = '$solicitudID'");
		  
		  while($listCP = $ce->fetchRow()){
		  
			  $codE = $listCP[0];
			  $proE = $listCP[1];
			  $posE = $listCP[2];
		  }
		  
		  //obtengo la maxima posicion de entregables del pdr
		  	  
		  $maxPos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$proE'");
		  
		  //Cuando el entregable esta en la ultima posicion
		  
		  if($posE == $maxPos){
			  
			  //elimino registro del entregable en el pdr asignado anteriormente
		  
			  if($INTRANET->Execute("DELETE FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$codE' AND xt_programador = '$proE'")){
				  
				  //asigno entregable al nuevo programador (pdr)
				  
				  //obtengo la prioridad de la solicitud
				  $prioridadS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$codE'");
				  
				  //Prioridad NORMAL
				  if($prioridadS == 'Normal'){
		  
					  //ahora inserto en la tabla de PDR
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
					  }else{
						  $pos+= 1;	
					  }
	  
  
					  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					  ('$codE','$pdr', $pos)");
		  
					  //Inserto en la tala de Historial_entregable
					  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					  ('$codE', '$pdr', $pos)");
			  
			  		//mando llamar a script de envio de correo de asignacion de PDR
					  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  
			  			
				  }//fin del if de verificacion de prioridad NORMAL
				  
				  
				  //Prioridad URGENTE
				  if($prioridadS == 'Urgente'){
		  
					  
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
	  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
						  
						  //inserto registro
						  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codE','$pdr', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
						  VALUES ('$codE', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  
					  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
					  }
					  
					  
					  if($pos == 1){
				  
						  //inserto entregable urgente en segunda posicion
						  $pos+= 1;
					  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codE','$pdr', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 
						  VALUES ('$codE', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  
						  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
					  }
			  
					  if($pos > 1){
				  
						  $entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE xt_programador = '$pdr' 	
						  ORDER BY xn_posicion ASC");
				  
						  $banderaCambio = 0;
						  $posModificado = 0;
						  
						  while($r = $entPos->fetchRow()){
					  
							  $listCodE = $r[0];
							  $listPos = $r[1];
					  
							  //$codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
							  $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
					  
							  if($listPos > 1){
						  
								  if($listPos <= $pos && $prioridadCodS == "Normal"){
						  
									  $banderaCambio = 1;
									  $posModificado = $listPos;
						  
									  break;
								  }
						  
							  }//fin del if de verificacion de pos menor a 1, menor a pos e igual a urgente
					  
							  //limpio variables
							  unset($codS);
							  unset($prioridadCodS);
							  unset($listPos);
					  
						  }//fin del while 
				  
						  //verifico si existe anderaCambio = 1, para modificar posiciones
				  
						  if($banderaCambio == 1){
					  
							  //modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones en el for.
							  for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						  
								  $posOriginal = $recorre;
								  $nuevasPos = $recorre + 1;
						  
								  //actualizo las posiciones
								  //echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND xn_posicion = 	
								  //$posOriginal";
								  
								  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND 	
								  xn_posicion = $posOriginal");
						  
								  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND 	
								  xn_posicion = $posOriginal");
								  
								  //Inserto en la tala de Historial_entregable
								  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
						  
							  }//fin del for de actualización de posiciones
					  
							  //inserto el entregable en la posicion asignada
					  
							  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
							  ('$codE','$pdr', $posModificado)");
		  
							  //Inserto en la tala de Historial_entregable
							  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
							  VALUES ('$codE', '$pdr', $posModificado)");
							  
							  //mando llamar a script de envio de correo de asignacion de PDR
					  		  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  
					  
						  }else{
					  
							  //echo "entro else no bndera";
							  $pos+= 1;
					  
							  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							  ('$codE','$pdr', $pos)");
		  
							  //Inserto en la tala de Historial_entregable
							  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 		
							  VALUES ('$codE', '$pdr', $pos)");
							  
							  //mando llamar a script de envio de correo de asignacion de PDR
					  		 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  
					  
						  }//fin del else de verificacion de bandera cambio
				  
					  }// fin del if de verificacion donde pos sea mayor a 1
  
				  }//fin del if de verificacion de prioridad URGENTE
				  
				  //PRIORIDAD EMERGENCIA
		  
				  if($prioridadS == "Emergencia"){
			  
					  //obtengo el numero total de posiciones de entregables en el pdr
					  $pos = 0;
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
					  '$pdr'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
				  
						  //inserto registro
						  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						  ('$codigoEntregable','$pdr', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
						  xn_posicion) VALUES ('$codigoEntregable', '$pdr', $pos)");
						  
						  //mando llamar a script de envio de correo de asignacion de PDR
					  	  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
				  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
				  
					  }//fin del if donde pos es igual a vacio
			  
					  if($pos >= 1){
				  
				  
						  $entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
						  xt_programador = '$pdr' ORDER BY xn_posicion ASC");
				  
						  $banderaCambio = 0;
						  $posModificado = 0;
						  $prioridadPosS = '';
				  
						  while($r = $entPos->fetchRow()){
							  			  
							  $listCodE = $r[0];
							  $listPos = $r[1];
						  
							  $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
					  
							  if($listPos >= 1){
						  
								  //aqui defino si la prioridad es normal o urgente
								  if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
							  
									  $banderaCambio = 1;
									  $posModificado = $listPos;
									  $prioridadPosS = $prioridadCodS;
						  
									  break;
						  
								  }						  
							  }//fin del if de verificacion de pos mayor a 1, menor a pos e igual a urgente
					  
							  //limpio variables
							  unset($codS);
							  unset($prioridadCodS);
							  unset($listPos);
					  
						  }//fin del while 
				  
						  //verifico si existe anderaCambio = 1, para modificar posiciones
				  
						  if($banderaCambio == 1){
					  
							  //verifico la prioridad
							  if($prioridadPosS == "Urgente"){
					  
								  //modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
								  for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						  
									  $posOriginal = $recorre;
									  $nuevasPos = $recorre + 1;
						  
									  //actualizo las posiciones
						  
									  //obtengo el codigo del entregable para insertar en tabla historial
									  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
						  
									  //actualizo posicion del entregable
									  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
									  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
						  
									  //Inserto en la tala de Historial_entregable
									  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
									  xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
						  
						  
								  }//fin del for de actualización de posiciones
								  				  
								  //inserto el entregable en la posicion asignada
								  
								  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
								  xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
		  
								  //Inserto en la tala de Historial_entregable
								  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
								  xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
								  $posModificado)");
								  
								  //mando llamar a script de envio de correo de asignacion de PDR
					  			  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
							  
							  }//fin del if de verificacion cuando la prioridad del entregable donde se tomara su lugar sea URGENTE
							  
							  if($prioridadPosS == "Normal"){
								  
								  //verifico si las prioridades de los entregables que le siguen son urgentes y la pondre 	
								  //despues del ultimo urgente, pero si todas son normales entonces solo bajare sus posiciones
								  
								  //verifico si es el unico entregale en la lista
								  if($posModificado == $pos){
									  
									  //solo incremente posiciones
									  
									  //modificar en lugar de incrementar sera decrementar para que no haya conflicto con las 		
									  //actualizaciones de las posiciones en el for.
									  for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						  
										  $posOriginal = $recorre;
										  $nuevasPos = $recorre + 1;
						  
										  //actualizo las posiciones
								  
						  
										  //obtengo el codigo del entregable para insertar en tabla historial
										  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
										  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
						  
										  //actualizo posicion del entregable
										  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
										  xt_programador = '$pdr' AND xn_posicion = $posOriginal");
						  
										  //Inserto en la tala de Historial_entregable
										  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
										  xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
						  
						  
									  }//fin del for de actualización de posiciones
								  
									  //inserto el entregable en la posicion asignada
								  
									  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
									  xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
		  
									  //Inserto en la tala de Historial_entregable
									  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
									  xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
									  $posModificado)");
									  
									  //mando llamar a script de envio de correo de asignacion de PDR
					  				  $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  
									  
									  
								  }else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
								  
									  $banderaCambioP = 0;
									  $posModificadoP = 0;
						  
									  //obtengo los codigos de los entregables deacuerdo a su posicion
									  
									  $posSig = $posModificado + 1;
									  
									  for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
					  
										  //obtengo el codigo del entregable deacuedo a su posicion
										  $codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
										  xn_posicion = $recorrePos AND xt_programador = '$pdr'");
										  
										  //obtengo su prioridad
										  $prioriCodEP = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES 
										  WHERE xt_codigoEntregable = '$codEP'");
					  
										  if($prioriCodEP == 'Urgente'){
											  
											  
											  $posModificadoP = $recorrePos;
											  $banderaCambioP = 1;
											  
										  }
								  
									  }//fin del for
									  
									  //verifico la banderacanbioP
									  if($banderaCambioP == 1){
										  
										  //pondre el entregable en la posicion inmediata del ultimo entregable con prioridad 											de emergencia
								  
										  $posInserta = $posModificadoP + 1;
										  
										  //verifico si existe cupado dicho lugar por algun entregable
										  $existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR 	
										  WHERE xt_programador = '$pdr' AND xn_posicion = $posInserta");
										  
										  if($existeLugar != ''){
											  
											  //incremento posiciones
											  
											  //actualizaciones de las posiciones en el for.
											  for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
						  
												  echo $posOriginalU = $recorreU;
												  echo $nuevasPosU = $recorreU + 1;
						  
												  //actualizo las posiciones
								  
												  //obtengo el codigo del entregable para insertar en tabla historial
												  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
												  WHERE xt_programador = '$pdr' AND xn_posicion = 	
												  $posOriginalU");
						  
												  //actualizo posicion del entregable
												  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE 	
												  xt_programador = '$pdr' AND xn_posicion = $posOriginalU");
						  
												  //Inserto en la tala de Historial_entregable
												  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 	
												  (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 
												  '$pdr', $nuevasPosU)");
						  
						  
											  }//fin del for de actualización de posiciones
											  
											  //obtengo el codigo del entregable para insertar en tabla historial
											  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
											  WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
											  
											  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
											  xt_programador = '$pdr' AND xn_posicion = $posModificado");
						  
											  //Inserto en la tala de Historial_entregable
											  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
											  (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
											  '$pdr', $posInserta)");
											  
											  //mando llamar a script de envio de correo de asignacion de PDR
					  						 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codH);
					  
											  
											  
										  }else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
										  
											  //solo actualizo a la posicion
											  
											  //obtengo el codigo del entregable para insertar en tabla historial
											  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
											  WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
											  
											  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
											  xt_programador = '$pdr' AND xn_posicion = $posModificado");
						  
											  //Inserto en la tala de Historial_entregable
											  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
											  (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
											  '$pdr', $posInserta)");	
											  
											  //mando llamar a script de envio de correo de asignacion de PDR
					  						 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codH);
					  
											   
											  
										  }//fin del else donde solo actualizo 
										  						  
										  //reasigno el entregable eliminado en el lugar 1
										  
										  //inserto el entregable en la posicion asignada
								  
										  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
										  xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
		  
										  //Inserto en la tala de Historial_entregable
										  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
										  xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
										  $posModificado)");					  
										  
										  //mando llamar a script de envio de correo de asignacion de PDR
					  						$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
										  
									  }//fin del if donde bandera cambio es 1	  
								  
								  }//fin del else donde la posicion del entregable no esta en ultimo lugar
								  //obtengo 
								  
							  }// fin del if donde verifico la prioridad a NORMAL
							  
					  
						  }else{
					  
						  //incremento todas las posiciones de entregables
						  
							  $pos+= 1;
					  
							  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							  ('$codigoEntregable','$pdr', $pos)");
		  
							  //Inserto en la tala de Historial_entregable
							  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							  ('$codigoEntregable', '$pdr', $pos)");
							  
				  
						  }//fin del else
			  
					  }//fin del if pos >= 1
			  
			  
				  }//fin del if donde prioridad es EMERGENCIA
				  
	  
			  }//fin del if de eliminar registro de entregable
			  
			  
			  //fin del if de verificacion entregable esta ULTIMA POSICION e inicio del else cuando entregable este en posicion INTERMEDIA	
		  }else{
			  
				//for para decrementar las posiciones que estan despues de la posicion eliminada
				$inicioRecorre = $posE + 1;
				for($rec = $inicioRecorre; $rec <= $maxPos; $rec ++){
				
					 $nuevaPosD = $rec - 1;
					 $posOriginalD = $rec;
				
					//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevaPosD WHERE xt_programador = '$proE' AND xn_posicion = 	
					//$posOriginalD";
					$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$proE' AND xn_posicion = 
					$posOriginalD");
				
					$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevaPosD WHERE xt_programador = '$proE' AND xn_posicion = 	
					$posOriginalD");
				
					//Inserto en la tala de Historial_entregable
					$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
					('$codH', '$proE', $nuevaPosD)");
				
				}//fin del for de decremento de posiciones
			
				//elimino registro del entregable en el pdr asignado anteriormente
		
				if($INTRANET->Execute("DELETE FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$codE' AND xt_programador = '$proE'")){
				
					//asigno entregable al nuevo programador (pdr)
				
					//obtengo la prioridad de la solicitud
					$prioridadS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$codE'");
				
					//Prioridad NORMAL
					if($prioridadS == 'Normal'){
		
						//ahora inserto en la tabla de PDR
						//obtengo el número de posicion para determinar el siguiente.
	
						$pos = 0;
						$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	
						if($pos == ''){
							$pos = 1;
						}else{
							$pos+= 1;	
						}
  
						$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						('$codE','$pdr', $pos)");
			
						//Inserto en la tala de Historial_entregable
						$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						('$codE', '$pdr', $pos)");
						
						//mando llamar a script de envio de correo de asignacion de PDR
					  	$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  									 
			  
					}//fin del if de verificacion de prioridad NORMAL
				  
				  
					//Prioridad URGENTE
					if($prioridadS == 'Urgente'){
		
					
						//obtengo el número de posicion para determinar el siguiente.
	
						$pos = 0;
	
						$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdr'");
	
						if($pos == ''){
		
							$pos = 1;
						
							//inserto registro
						
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$codE','$pdr', $pos)");
		
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
							VALUES ('$codE', '$pdr', $pos)");
							
							//mando llamar a script de envio de correo de asignacion de PDR
					  		$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  									 
					
							//limpio variable pos para que no pase a los demas if
							unset($pos);
						}
					  
						if($pos == 1){
				
							//inserto entregable urgente en segunda posicion
							$pos+= 1;
					
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$codE','$pdr', $pos)");
		
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 
							VALUES ('$codE', '$pdr', $pos)");
							
							//mando llamar a script de envio de correo de asignacion de PDR
					  		$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  									 
						
							//limpio variable pos para que no pase a los demas if
							unset($pos);
						}
			  
						if($pos > 1){
				
							$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE xt_programador = '$pdr' 	
							ORDER BY xn_posicion ASC");
				
							$banderaCambio = 0;
							$posModificado = 0;
						
							while($r = $entPos->fetchRow()){
					
								$listCodE = $r[0];
								$listPos = $r[1];
					
								 //$codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
								 $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
					
								if($listPos > 1){
						
									if($listPos <= $pos && $prioridadCodS == "Normal"){
						
										$banderaCambio = 1;
										$posModificado = $listPos;
						
										break;
						
									}
						
								}//fin del if de verificacion de pos menor a 1, menor a pos e igual a urgente
					
								//limpio variables
								unset($codS);
								unset($prioridadCodS);
								unset($listPos);
					
							}//fin del while 
				
							//verifico si existe anderaCambio = 1, para modificar posiciones
				
							if($banderaCambio == 1){		
					
								//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones en el for.
								for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						
									$posOriginal = $recorre;
									$nuevasPos = $recorre + 1;
						
									//actualizo las posiciones
									//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND xn_posicion = 	
									//$posOriginal";
								
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdr' AND 	
									xn_posicion = $posOriginal");
						
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND 	
									xn_posicion = $posOriginal");
								
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
									xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
						
								}//fin del for de actualización de posiciones
					
								//inserto el entregable en la posicion asignada
					
								/*echo "INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
								('$codigoEntregable','$pdr', $posModificado)";*/
					
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
								('$codE','$pdr', $posModificado)");
		
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
								VALUES ('$codE', '$pdr', $posModificado)");
								
								//mando llamar a script de envio de correo de asignacion de PDR
					  			$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  									 
					
							}else{
					
								//echo "entro else no bndera";
								$pos+= 1;
					
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
								('$codE','$pdr', $pos)");
		
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 		
								VALUES ('$codE', '$pdr', $pos)");
								
								//mando llamar a script de envio de correo de asignacion de PDR
					  			$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codE);
					  									 
					
							}//fin del else de verificacion de bandera cambio
				
						}// fin del if de verificacion donde pos sea mayor a 1
			
					}//fin del if de verificacion de prioridad URGENTE
				
					//PRIORIDAD EMERGENCIA
				
					if($prioridadS == "Emergencia"){
					
						//obtengo el numero total de posiciones de entregables en el pdr
						$pos = 0;
			
						$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
						'$pdr'");
			
						if($pos == ''){
				
							$pos = 1;
						
							//inserto registro
								
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
								('$codigoEntregable','$pdr', $pos)");
				
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
								xn_posicion) VALUES ('$codigoEntregable', '$pdr', $pos)");
								
							//mando llamar a script de envio de correo de asignacion de PDR
					  		$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
						
							//limpio variable pos para que no pase a los demas if
							unset($pos);
						
						}//fin del if donde pos es igual a vacio
					
						if($pos >= 1){
						
						
							$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
							xt_programador = '$pdr' ORDER BY xn_posicion ASC");
						
							$banderaCambio = 0;
							$posModificado = 0;
							$prioridadPosS = '';
						
							while($r = $entPos->fetchRow()){
							
								$listCodE = $r[0];
								$listPos = $r[1];
									
							
								$prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE 
								xt_codigoEntregable = '$listCodE'");
							
								if($listPos >= 1){
								
									//aqui defino si la prioridad es normal o urgente
									if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
								
										$banderaCambio = 1;
										$posModificado = $listPos;
											
										$prioridadPosS = $prioridadCodS;
								
											break;
									}
								
								}//fin del if de verificacion de pos mayor a 1, menor a pos e igual a urgente
							
								//limpio variables
								unset($codS);
								unset($prioridadCodS);
								unset($listPos);
							
							}//fin del while 
						
							//verifico si existe anderaCambio = 1, para modificar posiciones
						
							if($banderaCambio == 1){
									
								//verifico la prioridad
								if($prioridadPosS == "Urgente"){
							
									//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
									for($recorre = $pos; $recorre >= $posModificado; $recorre --){
								
										$posOriginal = $recorre;
										$nuevasPos = $recorre + 1;
								
										//actualizo las posiciones	
							
										//obtengo el codigo del entregable para insertar en tabla historial
										$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
										xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							
										//actualizo posicion del entregable
										$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
										xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
										xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
							
									}//fin del for de actualización de posiciones
												
									//inserto el entregable en la posicion asignada
									
									$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
									xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
			
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
									xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
									$posModificado)");
									
									//mando llamar a script de envio de correo de asignacion de PDR
					  				$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
				
								}//fin del if de verificacion cuando la prioridad del entregable donde se tomara su lugar sea URGENTE
									
								if($prioridadPosS == "Normal"){
									
									//verifico si las prioridades de los entregables que le siguen son urgentes y la pondre 	
									//despues del ultimo urgente, pero si todas son normales entonces solo bajare sus posiciones
									
									//verifico si es el unico entregale en la lista
									if($posModificado == $pos){
										
										//solo incremente posiciones
										
										//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las 		
										//actualizaciones de las posiciones en el for.
										for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							
											$posOriginal = $recorre;
											$nuevasPos = $recorre + 1;
							
											//actualizo las posiciones
									
											//obtengo el codigo del entregable para insertar en tabla historial
											$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
											xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							
											//actualizo posicion del entregable
											$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
											xt_programador = '$pdr' AND xn_posicion = $posOriginal");
							
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
											xt_programador, xn_posicion) VALUES ('$codH', '$pdr', $nuevasPos)");
							
										}//fin del for de actualización de posiciones
									
										//inserto el entregable en la posicion asignada
									
										$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
										xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
			
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
										xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
										$posModificado)");
										
										//mando llamar a script de envio de correo de asignacion de PDR
					  					$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
										
											
									}else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
									
										
										$banderaCambioP = 0;
										$posModificadoP = 0;
							
										//obtengo los codigos de los entregables deacuerdo a su posicion
										
										echo $posSig = $posModificado + 1;
										
										for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
						
											//obtengo el codigo del entregable deacuedo a su posicion
											$codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
											xn_posicion = $recorrePos AND xt_programador = '$pdr'");
											
											//obtengo su prioridad
											$prioriCodEP = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES 
											WHERE xt_codigoEntregable = '$codEP'");
						
											if($prioriCodEP == 'Urgente'){
												
												
												$posModificadoP = $recorrePos;
												$banderaCambioP = 1;
												
											}
										}//fin del for
											
										//verifico la banderacanbioP
										if($banderaCambioP == 1){
											//echo "entro bandera en urgente <br>";
											//pondre el entregable en la posicion inmediata del ultimo entregable con prioridad 											de emergencia
									
										    $posInserta = $posModificadoP + 1;
											
											//verifico si existe cupado dicho lugar por algun entregable
											$existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR 	
											WHERE xt_programador = '$pdr' AND xn_posicion = $posInserta");
											
											if($existeLugar != ''){
												
												//echo "el lugar esta ocupado";
												//incremento posiciones
												
												//actualizaciones de las posiciones en el for.
												for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
							
													$posOriginalU = $recorreU;
													$nuevasPosU = $recorreU + 1;
							
													//actualizo las posiciones
							
													//obtengo el codigo del entregable para insertar en tabla historial
													$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
													WHERE xt_programador = '$pdr' AND xn_posicion = 	
													$posOriginalU");
							
													//actualizo posicion del entregable
													$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE 	
													xt_programador = '$pdr' AND xn_posicion = $posOriginalU");
							
													//Inserto en la tala de Historial_entregable
													$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 	
													(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 
													'$pdr', $nuevasPosU)");
							
												}//fin del for de actualización de posiciones
												
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
												WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
												
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
												xt_programador = '$pdr' AND xn_posicion = $posModificado");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
												(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
												'$pdr', $posInserta)");
												
												//mando llamar a script de envio de correo de asignacion de PDR
					  							 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codH);
					  									 

												
											}else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
											
													//solo actualizo a la posicion
													
													//obtengo el codigo del entregable para insertar en tabla historial
													$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
													WHERE xt_programador = '$pdr' AND xn_posicion = $posModificado");
													
													$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
													xt_programador = '$pdr' AND xn_posicion = $posModificado");
								
													//Inserto en la tala de Historial_entregable
													$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
													(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
													'$pdr', $posInserta)");	
													
													//mando llamar a script de envio de correo de asignacion de PDR
					  						 		$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codH);
					  									 	
													
											}//fin del else donde solo actualizo 
														
											//reasigno el entregable eliminado en el lugar 1
											
											//inserto el entregable en la posicion asignada
									
											$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
											xn_posicion) VALUES ('$codigoEntregable','$pdr', $posModificado)");
			
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
											xt_programador, xn_posicion) VALUES ('$codigoEntregable', '$pdr', 	
											$posModificado)");
											
											//mando llamar a script de envio de correo de asignacion de PDR
					  						 $enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
													
										}else{
											
											//todos los entregables son normales
											
											//incrementamos los lugares de los entregables
											
											//actualizaciones de las posiciones en el for.
											for($recorreN = $pos; $recorreN >= 1; $recorreN --){
							
												$posOriginalN = $recorreN;
												$nuevasPosN = $recorreN + 1;
							
												//actualizo las posiciones
							
												//obtengo el codigo del entregable para insertar en tabla historial
													
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalN");
													
												//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalN";
												//actualizo posicion del entregable
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalN");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPosN)");
							
							
											}//fin del for de actualización de posiciones
												
												
											//obtengo el codigo del entregable para insertar en tabla historial
											$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $arrEntregableP[$a]");
											//echo "INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', 1)";
											$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', 1)");
												
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', 1)");
												
																
										}//fin del else donde bandera cambio no es 1
									
										
									}//fin del else donde la posicion del entregable no esta en ultimo lugar
										//obtengo 
										
								}// fin del if donde verifico la prioridad a NORMAL				
							
							}else{
							
								//incremento todas las posiciones de entregables
								
								$pos+= 1;
							
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
								('$codigoEntregable','$pdr', $pos)");
				
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
								('$codigoEntregable', '$pdr', $pos)");
								
								//mando llamar a script de envio de correo de asignacion de PDR
					  			$enviaCorreo = new MailSolicitudAsignar($solicitudID, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloSol, $descripcionSol, $codigoEntregable);
					  									 
						
							}//fin del else
					
						}//fin del if pos >= 1
					
					}//fin del if donde prioridad es EMERGENCIA
							
			   }//fin del if de eliminar registro de entregable
		 
		  }//fin del else cuando el registro esta INTERMEDIO
	 
	  }//fin del else de verificación de existencia de registro
  
 // }//fin del if de actualización en tabla solicitudesv2

?>
<script>
//alert("PDR Asignado");
window.location.reload();
</script>
<?php
}
?>
