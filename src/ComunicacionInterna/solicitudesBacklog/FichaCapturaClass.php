<?php error_reporting(0); ?>
<?php
require_once("MailNuevaFuncionalidad.php");
/*
Clase para captura de la informacion de las fichas de captura de solicitudes
*/
//class FichaCaptura{

$estatus;
	
function fichaCaptura($usuario,$tipoSolicitud,$tipoFicha,$fecha,$grupo,$ciudad,$sistema,$titulo,$descripcion,$archivo,$extension,$prioridad,$justificacion,$fechaLimite,$solicitanteOriginal,$conexion){
		
	$year = date('Y', strtotime($fecha));
		
	/*VERIFICACION DE CAMPOS*/
		
	if(empty($usuario)){return "No hay un nombre de usuario";}
	else if(empty($tipoSolicitud)){return "Debes de seleccionar el tipo de Solicitud.";}
	else if(empty($grupo)){return "Debes de seleccionar tu Grupo";}
	else if(empty($ciudad)){return "Debes de seleccionar tu ciudad";}
	else if(empty($fecha)){return "Debes de poner una fecha en la solicitud";}
	else if(empty($titulo)){return "Debes de escribir un titulo corto";}
	else{
				
		$maximo= $conexion->getOne("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE  YEAR(xd_fecha) = '$year' ");
		$maximo++;
		$codigoSolicitud = obtenerCodigo($year,$ciudad,$tipoSolicitud,$grupo,$conexion);
		
		$s= $conexion->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE  YEAR(xd_fecha) = '$year' ");
				
		if($conexion->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_status, xt_grupo, xt_tipoSolicitud) VALUES ('$tipoSolicitud', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuario', '', '$grupo', '$tipoFicha')")){
			//inserto en tabla Estatus deacuerdo al tipo de ficha
						
			if($tipoFicha == "ST"){
							
				$conexion->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario) VALUES ('$codigoSolicitud', 1, 'ASIGNADA', '', '', '$fecha', '', 'Juan_Manuel_Ortiz')");
										
				//actualizo el status en la tabla de quejas_Solicitudesv2
							
				$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status ='ASIGNADA', xt_pdr = 'Juan_Manuel_Ortiz'	WHERE xt_quejaSolicitud = '$codigoSolicitud'");
							
				//funcion para subir archivo
				subirArchivo($usuario,$codigoSolicitud,$archivo,$extension,$conexion);
						
				//funcion para asignar prioridad
				asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion);	
						
				//funcion para agregar a que sistema pertenece
				asignaSistema($codigoSolicitud, $sistema, $conexion);	
						
				return $codigoSolicitud;
				//return $prueba;
						
							
			}
						
			if($tipoFicha == "AV"){
							
				$conexion->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario) VALUES ('$codigoSolicitud', '$maximo', 'SIN ASIGNAR', '', '', '$fecha', '', '$usuario')");
										
				//actualizo el status en la tabla de quejas_Solicitudesv2
							
				$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status ='SIN ASIGNAR' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
							
				//funcion para subir archivo
				subirArchivo($usuario,$codigoSolicitud,$archivo,$extension,$conexion);
						
				//funcion para asignar prioridad
				asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion);	
						
				//funcion para agregar a que sistema pertenece
				asignaSistema($codigoSolicitud, $sistema, $conexion);	
						
				return $codigoSolicitud;
						
			}
						
			if($tipoFicha == "AB"){
							
				$conexion->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario) VALUES ('$codigoSolicitud', '$maximo', 'ASIGNADA', '', '', '$fecha', '', '$usuario')");
										
				//actualizo el status en la tabla de quejas_Solicitudesv2
							
				$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status ='ASIGNADA' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
							
				//funcion para subir archivo
				subirArchivo($usuario,$codigoSolicitud,$archivo,$extension,$conexion);
						
				//funcion para asignar prioridad
				asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion);	
						
				//funcion para agregar a que sistema pertenece
				asignaSistema($codigoSolicitud, $sistema, $conexion);	
						
				return $codigoSolicitud;
							
			}
						
			if($tipoFicha == "MT"){
							
							
				$conexion->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario) VALUES ('$codigoSolicitud', 1, 'SIN ASIGNAR', '', '', '$fecha', '', '') ");
										
				//actualizo el status en la tabla de quejas_Solicitudesv2
							
				$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status ='SIN ASIGNAR', xt_pdr = 'Rodrigo_Romo' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
							
				//funcion para subir archivo
				subirArchivo($usuario,$codigoSolicitud,$archivo,$extension,$conexion);
						
				//funcion para asignar prioridad
				asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion);	
						
				//funcion para agregar a que sistema pertenece
				asignaSistema($codigoSolicitud, $sistema, $conexion);	
							
				return $codigoSolicitud;
						
			}
						
			if($tipoFicha == "DS"){
							
				//inserto en la tabla de status
				$conexion->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario, xt_pdr) VALUES ('$codigoSolicitud', '$maximo', 'ASIGNADA', '', '', '$fecha', '', '$usuario'.'Rodrigo_Romo') ");
										
				//actualizo el status en la tabla de quejas_Solicitudesv2
				$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status ='ASIGNADA' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
							
										
				if($solicitanteOriginal != ''){
								
					$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET  xt_solicitanteOriginal = '$solicitanteOriginal' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
								
				}
										
				if($fechaLimite != ''){
								
					$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET  xd_fechaLimite = '$fechaLimite' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
								
				}
							
				if($justificacion != ''){
								
					$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_justificacion = '$justificacion' WHERE xt_quejaSolicitud = '$codigoSolicitud'");
								
				}
							
				//funcion para subir archivo
				subirArchivo($usuario,$codigoSolicitud,$archivo,$extension,$conexion);
						
				//funcion para asignar prioridad
				asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion);	
						
				//funcion para agregar a que sistema pertenece
				asignaSistema($codigoSolicitud, $sistema, $conexion);
				
				new MailNuevaFuncionalidad($codigoSolicitud, "", "", "gsistemas@escalante.com.mx", "Gerente de Sistemas", "", "", "ValidacionTecnica");		
				return $codigoSolicitud;
						
			}
						
		}else {return 0;}
			
	}
}
	
	
function obtenerCodigo($fechaCodigo,$ciudadCodigo,$tipoCodigo,$grupoCodigo,$conexion){
		
	//OBTENEMOS EL ID MAXIMO GUARDADO EN LA BD	
	$maximo = 0;	
	$maximo = $conexion->getOne("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha)=$fechaCodigo AND xt_tipo='B' AND xt_ciudad='$ciudadCodigo' AND xt_grupo='$grupoCodigo'");				
	$maximo+= 1;
	
	if(($ciudadCodigo != "") && ($ciudadCodigo != "GEN")){		
		$codigo = "GE-B-".$ciudadCodigo."-";		
	}else{
		$codigo = $grupoCodigo."-B-";
	}
	
	$anio = date('y', strtotime($fechaCodigo));
	
	if(strlen($maximo) == 1){
		$codigo = $codigo.$anio."-00".$maximo;
	}else if(strlen($maximo) == 2){		
		$codigo = $codigo.$anio."-0".$maximo;		
	}else if(strlen($maximo) >= 3){		
		$codigo = $codigo.$anio."-".$maximo;		
	}
	
	//REROTNAMOS EL VALOR DEL CODIGO
	return $codigo;						
		
}

function subirArchivo($usuario,$codigo,$archivo,$extension,$conexion){
	
	if($extension != ''){
		
		$ruta = "D:/INTRANET/documentosSolicitudes/";
		$directorioCompleto = $ruta.$codigo;
			 # si exsite la carpeta o se ha creado
			if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
				//verifico si ya existe nombre de archivo
				$nombreNuevo = "Solicitud_".$codigo;
				
				$nombreArchivo = $directorioCompleto."/".$nombreNuevo.".".$extension;

				# movemos el archivo
				if(@move_uploaded_file($archivo, $nombreArchivo)){
					//Actualizo el registro en ruta
					$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta ='$nombreArchivo' WHERE xt_quejaSolicitud = '$codigo'");
								  
					
				}else{return 0;}
				
			}else{
				if(mkdir($directorioCompleto)){	
					$nombreNuevo = "Solicitud_".$codigo;
					$nombreArchivo = $directorioCompleto."/".$nombreNuevo.".".$extension;
					# movemos el archivo
					if(@move_uploaded_file($archivo, $nombreArchivo)){
							
						//Actualizo el registro en ruta
						$conexion->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta ='$nombreArchivo' WHERE xt_quejaSolicitud = '$codigo'");
							
					}else{return 0;}
				}						
			}                       

	}//fin del if de verificacion si subio archivo
	
}


function asignaPrioridad($usuario,$codigoSolicitud,$prioridad,$justificacion,$conexion){
	
	//verificamos si la solicitud tiene prioridad
	if($prioridad != ''){
		
		//insertamos prioridad de la solicitud si existe
		$conexion->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud, xt_prioridad, xt_usuario, xt_justificacion) VALUES ('$codigoSolicitud', '$prioridad', '$usuario', '$justificacion')");
		
	}
	
	
}//fin de funcion asignarPrioridad


function asignaSistema($codigoSolicitud, $sistema, $conexion){
	
	//verificamos si la solicitud tiene prioridad
	if($sistema != ''){
		
		//insertamos prioridad de la solicitud si existe
		$conexion->Execute("INSERT INTO SGI_Backlog_Ubicacion (xt_quejaSolicitud, xt_sistema) VALUES ('$codigoSolicitud', '$sistema')");
		
	}
	
	
	
}//fin de funcion asignarSistema





