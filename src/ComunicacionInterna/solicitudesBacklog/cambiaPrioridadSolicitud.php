<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

 $solicitudID = $_POST['codigoS'];
 $prioridadAnt = $_POST['prioridadAnt'];
 $prioridadNueva = $_POST['prioridadNueva'];
 $usuario = $_POST['usuario'];
 $justificacionP = $_POST['prioriJustifica'];
 
 //primero verifico si existe entregables asignados
 $s = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.ENTREGABLES WHERE xt_solicitud = '$solicitudID'");
 
 //declaro arreglo donde guardare las claves de entregables si existe un programador asignado a el
 $arrEntregableP = array();
 $index = 0;
 
 while($listEntregables = $s->fetchRow()){
	 
	 $codEntregable =  $listEntregables[0];
	 
	 //verifico si tiene algun programador asignado
 	$programadorAsignado = $INTRANET->getOne("SELECT xt_programador FROM BACKLOG.PDR WHERE xt_codigoEntregable = 		
	'$codEntregable'");
	
	//si existe programador asignado registro en los arreglos
	if($programadorAsignado != ''){
	//aqui voy a registrar el cod de Entregable en un arreglo y el nombre de programador en otro asi como las posiciones y voy a 	incrementar index
		
		$arrProgramador[$index] = $programadorAsignado;
		$arrEntregableP[$index] = $codEntregable;
		
		$index ++;
		
	}
	 
 }


//si index es igual a 0(porque no tiene programadores asignados) y no hay entregables entonces solo cambio prioridad
if($index == 0 && $codEntregable == ''){
	
	//inserto la nueva prioridad 

	if($INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud, xt_prioridad, xt_usuario, 	
	xt_justificacion) VALUES ('$solicitudID', '$prioridadNueva', '$usuario', '$justificacionP')")){
		
	
	//recargo pagina 
	?>
	<script>
		alert("Prioridad Asignada");
		window.location.reload();
	</script>
	<?php
	
	}
}

//si index es igual a 0(porque no tiene programadores asignados) pero si hay entregables asignado entonces solo cambio prioridad
if($index == 0 && $codEntregable != ''){
	
	//inserto la nueva prioridad 
	if($INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud, xt_prioridad, xt_usuario, xt_justificacion) VALUES ('$solicitudID', '$prioridadNueva', '$usuario', '$justificacionP')")){
		
		//actualizo el campo de prioridad en la tabla de ENTREGABLES
		$INTRANET->Execute("UPDATE BACKLOG.ENTREGABLES SET xt_prioridad = '$prioridadNueva' WHERE xt_solicitud = '$solicitudID'");
	
	//recargo pagina 
	?>
	<script>
		alert("Prioridad Asignada");
		window.location.reload();
	</script>
	<?php
	
	}
	
}

//EXISTE PDR ASIGNADO AL ENTREGABLE

if($index != 0){
	
	//inserto la nueva prioridad en la tabla prioridades
	$INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud, xt_prioridad, xt_usuario, 	
	xt_justificacion) VALUES ('$solicitudID', '$prioridadNueva', '$usuario', '$justificacionP')");
	
	//Actualizo pioridad de los entregables correspondientes a la solicitud
	$INTRANET->Execute("UPDATE BACKLOG.ENTREGABLES SET xt_prioridad = '$prioridadNueva' WHERE xt_solicitud ='$solicitudID'");
		
	//recorro los arreglos 
	//echo count($arrProgramador);
	
	for($a = 0; $a < count($arrProgramador); $a++){
		
		echo "programador:".$arrProgramador[$a];
		echo "entregable:".$arrEntregableP[$a];
		//echo "posicion:".$arrPosE[$a];
		
		//obtengo el numero maximo de posiciones de entregables del pdr
	 	$maxPos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]'");
		
		//obtengo la posicion del entregable
		$posEntregable = $INTRANET->getOne("SELECT xn_posicion FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$arrEntregableP[$a]' AND xt_programador = '$arrProgramador[$a]'");
		
		//verifico si el entregable a eliminar se encuentra en la ultima posicion de ser asi lo unico que se hace es eliminar el				
		//registro sin actualizar los lugares de los entregables asignados al pdr y asignar nuevamente los entregables
		
		if($posEntregable == $maxPos){
		
			//echo "esta ultimo posicion";
			//Elimino entregable del PDR (elimino registro solo de la tabla PDR)
		
			$INTRANET->Execute("DELETE FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$arrEntregableP[$a]' AND xt_programador = '$arrProgramador[$a]'");
				
				//Reasigno los entregables al programador
				//obtengo la prioridad de la solicitud
				
				
				$prioridadS = $INTRANET->getOne("Select xt_prioridad FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fecha DESC");
				
				//Prioridad NORMAL
				if($prioridadS == 'Normal'){
			
					//echo "es normal";
					//ahora inserto en la tabla de PDR
					//obtengo el número de posicion para determinar el siguiente.
		
					$pos = 0;
					
					$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 
					'$arrProgramador[$a]'");
		
					if($pos == ''){
						$pos = 1;
					}else{
						$pos+= 1;	
					}
	
					$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
					('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
					//Inserto en la tala de Historial_entregable
					$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 
					xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
				
				}//fin del if de verificacion de prioridad NORMAL
					
				
				//Prioridad URGENTE
				if($prioridadS == 'Urgente'){
			
					//echo "es urgente";
					//obtengo el número de posicion para determinar el siguiente.
		
					$pos = 0;
		
					 $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 	
					'$arrProgramador[$a]'");
		
					if($pos == ''){
						//echo "pos vacio";
						$pos = 1;
							
						//inserto registro
							
						$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 		
						('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
						//Inserto en la tala de Historial_entregable
						$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
						xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
						
						//limpio variable pos para que no pase a los demas if
						unset($pos);
					}
						
						
					if($pos == 1){
					
							//inserto entregable urgente en segunda posicion
							$pos+= 1;
						
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
							
							//limpio variable pos para que no pase a los demas if
							unset($pos);
					}
				
					if($pos > 1){
					
						  $entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 	
						  xt_programador = '$arrProgramador[$a]' ORDER BY xn_posicion ASC");
				  
						  $banderaCambio = 0;
						  $posModificado = 0;
						  
						  while($r = $entPos->fetchRow()){
					  
							  $listCodE = $r[0];
							  $listPos = $r[1];
					  
							   //$codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
							   
							   $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable ='$listCodE' ");
					  
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
						
								//echo "entro if bandera";
								//echo "pos original".$pos;
						
								//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones en el for.
								for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							
									$posOriginal = $recorre;
									$nuevasPos = $recorre + 1;
							
									//actualizo las posiciones
									
									//obtengo el codigo del entregable para insertar en tabla historial
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador 
									= '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = 		
									'$arrProgramador[$a]' AND xn_posicion = $posOriginal");
									
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
									xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPos)");
							
								}//fin del for de actualización de posiciones
						
								//inserto el entregable en la posicion asignada
						
								
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) 		
								VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 
								xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', 
								$posModificado)");
						
							}else{
						
								//echo "entro else no bndera";
								$pos+= 1;
						
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) 
								VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 
								xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
						
							}//fin del else de verificacion de bandera cambio
					
						}// fin del if de verificacion donde pos sea mayor a 1
	
				
					}//fin del if de verificacion de prioridad URGENTE
					
				
					//PRIORIDAD EMERGENCIA
			
					if($prioridadS == "Emergencia"){
				
						//obtengo el numero total de posiciones de entregables en el pdr
						$pos = 0;
		
						$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
						'$arrProgramador[$a]'");
		
						if($pos == ''){
			
							$pos = 1;
					
							//inserto registro
							
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
							xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
					
							//limpio variable pos para que no pase a los demas if
							unset($pos);
					
						}//fin del if donde pos es igual a vacio
				
						if($pos >= 1){
					
							$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
							xt_programador = '$arrProgramador[$a]' ORDER BY xn_posicion ASC");
					
							$banderaCambio = 0;
							$posModificado = 0;
							$prioridadPosS = '';
					
							while($r = $entPos->fetchRow()){
						
								 $listCodE = $r[0];
								 $listPos = $r[1];
								
						
								 $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
						
								if($listPos >= 1){
							
									//echo "listPos es mayor igual a uno <br>";
									//aqui defino si la prioridad es normal o urgente
									if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
							
										//echo "entro a normal-urgente";
							 			$banderaCambio = 1;
										echo  $posModificado = $listPos;
										  echo $prioridadPosS = $prioridadCodS;
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
						
								//echo "entro bandera cambio 1";
								//verifico la prioridad
								if($prioridadPosS == "Urgente"){
						
									//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
									for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							
										$posOriginal = $recorre;
										$nuevasPos = $recorre + 1;
							
										//actualizo las posiciones
							
										//obtengo el codigo del entregable para insertar en tabla historial
										$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
										xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
										//actualizo posicion del entregable
										$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
										xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPos)");
							
							
									}//fin del for de actualización de posiciones
									
									//inserto el entregable en la posicion asignada
									
									$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $posModificado)");
								
								}//fin del if de verificacion cuando la prioridad del entregable donde se tomara su lugar sea URGENTE
								
								if($prioridadPosS == "Normal"){
									
									//echo "el entregable es normal";
									
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
											xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
											//actualizo posicion del entregable
											$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
											xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
											xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPos)");
							
							
										}//fin del for de actualización de posiciones
									
										//inserto el entregable en la posicion asignada
									
										$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
										xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
										xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', 	
										$posModificado)");
										
										
									}else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
									
										//echo "no es el unico entregable";
										$banderaCambioP = 0;
										$posModificadoP = 0;
							
										//obtengo los codigos de los entregables deacuerdo a su posicion
										
										$posSig = $posModificado + 1;
										
										for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
						
											//obtengo el codigo del entregable deacuedo a su posicion
											$codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
											xn_posicion = $recorrePos AND xt_programador = '$arrProgramador[$a]'");
											
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
											$existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posInserta");
											
											if($existeLugar != ''){
												
												//echo "el lugar esta ocupado";
												//incremento posiciones
												
												//actualizaciones de las posiciones en el for.
												for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
							
													echo $posOriginalU = $recorreU;
													echo $nuevasPosU = $recorreU + 1;
							
													//actualizo las posiciones
									
							
													//obtengo el codigo del entregable para insertar en tabla historial
													$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalU");
							
													//actualizo posicion del entregable
													$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalU");
							
													//Inserto en la tala de Historial_entregable
													$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPosU)");
							
							
												}//fin del for de actualización de posiciones
												
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
												
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $posInserta)");
												
												
											}else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
											
												//solo actualizo a la posicion
												
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
												
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $posInserta)");
												
												
											}//fin del else donde solo actualizo 
											
											
											//reasigno el entregable eliminado en el lugar 1
											
											//inserto el entregable en la posicion asignada
									
											$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $posModificado)");
											
											
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
						
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
								
					
						}//fin del else
				
					}//fin del if pos >= 1
				
				
				}//fin del if donde prioridad es EMERGENCIA
					
			
		}else{//fin del if de verificacion donde el entregable a eliminar esta en la ultimo posicion e inicio del else
		
			//verifico si esta en la primero posicion
			if($posEntregable == 1){
				
				//inserto la nueva prioridad 
				if($BACKLOG->Execute("INSERT INTO IntranetGEA.SGI_Backlog_Prioridad (xt_quejaSolicitud, xt_prioridad, xt_usuario, xt_justificacion) VALUES ('$solicitudID', '$prioridadNueva', '$usuario', '$justificacionP')")){
					
					//actualizo el campo de prioridad en la tabla de ENTREGABLES
					$BACKLOG->Execute("UPDATE BACKLOG.ENTREGABLES SET xt_prioridad = '$prioridadNueva' WHERE xt_solicitud = '$solicitudID'");
				
				//recargo pagina 
				
				
				}
			}else{
			//echo "no esta en ultimo pos";
			//obtengo el numero maximo de posiciones de entregables del pdr
	 		$maxPos=$INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]'");
		
			//for para decrementar las posiciones que estan despues de la posicion que sera eliminada
			$inicioRecorre = $posEntregable + 1;
			
			  for($rec = $inicioRecorre; $rec <= $maxPos; $rec ++){
				  
				   $nuevaPosD = $rec - 1;
				   $posOriginalD = $rec;
				  
				  
				  //echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevaPosD WHERE xt_programador = '$proE' AND xn_posicion = 	
				  //$posOriginalD";
				  
				  //obtengo el codigo del entregable para insertar en tabla historial
				  $codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = 
				  '$arrProgramador[$a]' AND xn_posicion = $posOriginalD");
				  
				  $INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevaPosD WHERE xt_programador = 		
				  '$arrProgramador[$a]' AND xn_posicion = $posOriginalD");
				  
				  //Inserto en la tala de Historial_entregable
				  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 			
				  xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevaPosD)");
				  
			  }//fin del for de decremento de posiciones
				
				
			  //elimino registro del entregable en el pdr 
		  
			  if($INTRANET->Execute("DELETE FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$arrEntregableP[$a]' AND 	
			  xt_programador = '$arrProgramador[$a]'")){
				  
				  //asigno entregable al nuevo programador (pdr)
				  
				  //obtengo la prioridad de la solicitud
				   $prioridadS = $INTRANET->getOne("Select xt_prioridad FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = 
				  '$solicitudID' ORDER BY xd_fecha DESC");
				  
				  //Prioridad NORMAL
				  if($prioridadS == 'Normal'){
		  
					  //ahora inserto en la tabla de PDR
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
	  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 	
					  '$arrProgramador[$a]'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
					  }else{
						  $pos+= 1;	
					  }
	  
  
					  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					  ('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
		  
					  //Inserto en la tala de Historial_entregable
					  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
					  xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
			  
				  }//fin del if de verificacion de prioridad NORMAL
					
					
				  //Prioridad URGENTE
				  if($prioridadS == 'Urgente'){
		  
					  //obtengo el número de posicion para determinar el siguiente.
	  
					  $pos = 0;
	  
					  $pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 	
					  '$arrProgramador[$a]'");
	  
					  if($pos == ''){
		  
						  $pos = 1;
						  
						  //inserto registro
						  
						  $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
		  
						  //Inserto en la tala de Historial_entregable
						  $INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 
						  xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
					  
						  //limpio variable pos para que no pase a los demas if
						  unset($pos);
					  	}
						
						if($pos == 1){
					
							//inserto entregable urgente en segunda posicion
							$pos+= 1;
						
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 
							xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
							
							//limpio variable pos para que no pase a los demas if
							unset($pos);
						}
				
						if($pos > 1){
					
							$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 	
							xt_programador = '$arrProgramador[$a]' ORDER BY xn_posicion ASC");
					
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
									
									//obtengo el codigo del entregable para insertar en tabla historial
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = 
									'$arrProgramador[$a]' AND xn_posicion = $posOriginal");
									
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = 	
									'$arrProgramador[$a]' AND xn_posicion = $posOriginal");
									
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 
									xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', 	
									$nuevasPos)");
							
								}//fin del for de actualización de posiciones
						
								//inserto el entregable en la posicion asignada
						
								
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) 
								VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 
								xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', 	
								$posModificado)");
						
							}else{
						
								//echo "entro else no bndera";
								$pos+= 1;
						
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) 
								VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 
								xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
						
							}//fin del else de verificacion de bandera cambio
					
						}// fin del if de verificacion donde pos sea mayor a 1
	
				
					}//fin del if de verificacion de prioridad URGENTE
					
					
				
					//PRIORIDAD EMERGENCIA
			
					if($prioridadS == "Emergencia"){
				
						//obtengo el numero total de posiciones de entregables en el pdr
						$pos = 0;
		
						$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
						'$arrProgramador[$a]'");
		
						if($pos == ''){
			
							$pos = 1;
					
							//inserto registro
							
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
							('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
							xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
					
							//limpio variable pos para que no pase a los demas if
							unset($pos);
					
						}//fin del if donde pos es igual a vacio
				
						if($pos >= 1){
					
					
							$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
							xt_programador = '$arrProgramador[$a]' ORDER BY xn_posicion ASC");
					
							$banderaCambio = 0;
							$posModificado = 0;
							$prioridadPosS = '';
					
							while($r = $entPos->fetchRow()){
						
								 $listCodE = $r[0];
								 $listPos = $r[1];
								
								 
								 $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
						
								 if($listPos >= 1){
							
									//echo "listPos es mayor igual a uno <br>";
									//aqui defino si la prioridad es normal o urgente
									if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
							
										//echo "entro a normal-urgente";
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
						
								//echo "entro bandera cambio 1";
								//verifico la prioridad
								if($prioridadPosS == "Urgente"){
						
									//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
									for($recorre = $pos; $recorre >= $posModificado; $recorre --){
							
										$posOriginal = $recorre;
										$nuevasPos = $recorre + 1;
							
										//actualizo las posiciones
									
										//obtengo el codigo del entregable para insertar en tabla historial
										$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
										xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
										//actualizo posicion del entregable
										$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador 										= '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
										xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPos)");
							
							
							
									}//fin del for de actualización de posiciones
									
									//inserto el entregable en la posicion asignada
									
									$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
									xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
									xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', 	
									$posModificado)");
								
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
											xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
											//actualizo posicion del entregable
											$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
											xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginal");
							
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
											xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPos)");
							
							
										}//fin del for de actualización de posiciones
									
										//inserto el entregable en la posicion asignada
									
										$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
										xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
										xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', 	
										$posModificado)");
										
										
									}else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
									
										
										$banderaCambioP = 0;
										$posModificadoP = 0;
							
										//obtengo los codigos de los entregables deacuerdo a su posicion
										
										$posSig = $posModificado + 1;
										
										for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
						
											//obtengo el codigo del entregable deacuedo a su posicion
											$codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
											xn_posicion = $recorrePos AND xt_programador = '$arrProgramador[$a]'");
											
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
											
											//pondre el entregable en la posicion inmediata del ultimo entregable con prioridad de emergencia
									
											$posInserta = $posModificadoP + 1;
											
											//verifico si existe cupado dicho lugar por algun entregable
											$existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posInserta");
											
											if($existeLugar != ''){
												
												//echo "el lugar esta ocupado";
												//incremento posiciones
												
												//actualizaciones de las posiciones en el for.
												for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
							
													 $posOriginalU = $recorreU;
													 $nuevasPosU = $recorreU + 1;
							
													//actualizo las posiciones
									
							
													//obtengo el codigo del entregable para insertar en tabla historial
													$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalU");
							
													//actualizo posicion del entregable
													$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalU");
							
													//Inserto en la tala de Historial_entregable
													$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $nuevasPosU)");
							
							
												}//fin del for de actualización de posiciones
												
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
												
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $posInserta)");
												
												
											}else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
											
												//solo actualizo a la posicion
												
												//obtengo el codigo del entregable para insertar en tabla historial
												$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
												
												$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posModificado");
							
												//Inserto en la tala de Historial_entregable
												$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$arrProgramador[$a]', $posInserta)");
												
											}//fin del else donde solo actualizo 
											
											
											//reasigno el entregable eliminado en el lugar 1
											
											//inserto el entregable en la posicion asignada
									
											$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $posModificado)");
			
											//Inserto en la tala de Historial_entregable
											$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $posModificado)");
											
											
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
								
								//echo "entro ultimo else";
							
								$pos+= 1;
						
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', $pos)");
			
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]', '$arrProgramador[$a]', $pos)");
								
					
							}//fin del else
				
						}//fin del if pos >= 1
				
				
					}//fin del if donde prioridad es EMERGENCIA
					
					
				}//fin del if donde se elimina el entregable
			}//fin del else donde el entregable esta en la primera posicion
		
		}//fin del else (cuando entregable no esta en ultima posicion)
		
	
	}//fin del for que recorre el arreglo de programadores
	
	
	
	//recargo pagina 
	?>
	<script>
		//alert("Prioridad Actualizada Correctamente");
		window.location.reload();
	</script>
	<?php
	
}//fin del if de verificacion que existe PDR asignado al entregable


?>
