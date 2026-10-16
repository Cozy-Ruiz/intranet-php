<?php
$nombrephp = 'fichaPreventiva.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);

$preventivaID = $_GET['id'];

// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );

    return $string;
}

///CUERPO PREVENTIVA
$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xt_descripcion, xt_ruta, xn_status, xt_ciudad, xt_grupo FROM SGI_Acciones_Preventivas_Correctivas 
						 WHERE xt_claveAccion = '$preventivaID'");

while($r = $s->fetchRow()){
	
	$clave 			= $r[0];
	$titulo 		= $r[1];
	$ruta 			= $r[3];
	$status 		= $r[4];
	$ciudad 		= $r[5];
	$grupo			= $r[6];
	$descripcion 	= nl2br($r[2]);
	
	//echo "".substr($descripcion, 0, 36).".<br>";
	if(substr($descripcion, 0, 36) == "Se vincula con la Acción Preventiva"){
		//echo "".substr($descripcion, 37, 11).".<br>";
		$codigoOrigen = trim(substr($descripcion, 37, 15));
		
		$idOrigen = $INTRANETV2->getOne("SELECT xt_claveAccion FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoOrigen' AND xt_tipo = 'D' ");
		
		if($idOrigen  != ""){
			
			$descripcion = "Se vincula con la Acción Preventiva<a href='fichaPreventivav2.php?id=".$idOrigen."' id='iconosTexto' style='text-decoration:none'>";
			$descripcion = $descripcion."<b>".$codigoOrigen."</b></a> ".substr($descripcion, 48);
		}
	}
	
} unset($r);

//AUDITORIA E ISSUE
/*$s = $INTRANETV2->Execute("SELECT A.kp_auditoriaID, A.xt_claveAuditoria, AI.kp_issueID, AI.xt_claveIssue 
FROM SGI_Auditorias_Issues AI, SGI_Auditorias A, SGI_Auditorias_Issues_Tratamientos AIT 
WHERE AI.kf_auditoriaID = A.kp_auditoriaID AND AIT.kf_issueID = AI.kp_issueID AND AIT.xt_tipoTratamiento = 'PREVENTIVA' AND AIT.xt_codigo = '$clave' ");
	
while($r = $s->fetchRow()){
	
	$auditoriaID 		= $r[0];
	$auditoriaCodigo 	= $r[1];
	$issueID 		= $r[2];
	$issueCodigo 		= $r[3];
	
} unset($r);*/

///SEGUIMIENTO
$seguimientoID 	= "";
$fechaReg 		= "";
$codigoS 		= "";
$asignador 		= "";
$pdrID 			= "";
$pdrNombre 		= $INTRANETV2->getOne("SELECT xt_pdr FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$preventivaID'");
$pdrApPate 		= "";
$pdrApMate 		= "";
$show			= "";

/*$s = $INTRANETV2->Execute("SELECT SGU.kp_seguimientoID, SGU.xd_fechaRegistro, SGU.xt_codigoSeguimiento, EMP.xt_nombreCorto, SGU.kf_pdrID 
						 FROM SGI_Seguimientos SGU, SGI_Empleados EMP WHERE xt_tipoOrigen = 'D' AND kf_itemOrigenID = $preventivaID 
						 AND SGU.kf_asignadorID = EMP.kp_personalId");

while($r = $s->fetchRow()){
	
	$seguimientoID 	= $r[0];
	$fechaReg 		= date('Y-m-d', strtotime($r[1]));
	$codigoS 		= $r[2];
	$asignador 		= $r[3];
	$pdrID 			= $r[4];
	
	$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId = $pdrID ");
	
	while($t = $u->fetchRow()){
		
		$pdrNombre = $t[0];
		$pdrApPate = $t[1];
		$pdrApMate = $t[2];
		
	} unset($u); unset($t);
	
} unset($r);*/

$exisEtapas = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$preventivaID'");

///ETAPAS SEGUIMIENTO
if($exisEtapas != ""){
	
	
	$index = 1;
			
	$s = $INTRANETV2->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta, xn_etapa, xt_usuario FROM SGI_Acciones_Preventivas_Correctivas_Etapas 
							 WHERE xt_codigoAccion = '$preventivaID' ORDER BY xn_etapa ");
	
	while($r = $s->fetchRow()){
		
		if(($r[0] != "") || ($r[0] != NULL)){
			
			$fechaEtapa[$index] = date('Y-m-d', strtotime($r[0]));
			
		} else {
			
			$fechaEtapa[$index] = "";
			
		}
		
		$tituloEtapa[$index] 	= $r[1];
		$contenidoEtapa[$index] = nl2br($r[2]);
		$rutaEtapa[$index] 		= $r[3];
		$asingadorUser[$index]  = $r[5];
		$etapa[$index] 			= $r[4];
		
		/*if($asingadorUser[$index] != ''){
		
		$nombreAsigna[$index] = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kf_usuario = '$asingadorUser[$index]' ");
	
		}*/
		
		
		
		
		if($tituloEtapa[$index] == "ASIGNAR"){
			
			$show 					= "Asignada";
			$tituloEtapa[$index] 	= "Asignada";
			
		} else if($tituloEtapa[$index] == "ANALISIS"){
			
			$show 					= "Análisis de la causa raíz";
			$tituloEtapa[$index] 	= "Análisis de la causa raíz";
			
		} else if($tituloEtapa[$index] == "DECISION"){
			
			$show 					= "Decisión";
			$tituloEtapa[$index] 	= "Decisión";
			
		} else if($tituloEtapa[$index] == "SOLICITUD"){
			
			$show 					= "Plan de acción";
			$tituloEtapa[$index] 	= "Plan de acción";
			
		} else if($tituloEtapa[$index] == "EVALUACION"){
			
			$show 					= "Evaluado";
			$tituloEtapa[$index] 	= "Evaluación de la eficacia";
		
			
			//echo "".substr($contenidoEtapa[$index], -48, 36).".<br>";
			if(substr($contenidoEtapa[$index], -48, 36) == "Se vincula con la Acción Preventiva"){
				//echo "".substr($contenidoEtapa[$index], -11).".<br>";
				$codigoSegunda =  trim(substr($contenidoEtapa[$index], -15));
				
				$idSegundaPreventiva = $INTRANETV2->getOne("SELECT xt_claveAccion FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoSegunda' AND xt_tipo = 'D' ");
				
				if($idSegundaPreventiva != ""){
					
					$contenidoEtapa[$index] = substr($contenidoEtapa[$index], 0, -11)."<a href='fichaPreventivav2.php?id=".$idSegundaPreventiva."' id='iconosTexto' style='text-decoration:none'>";
					$contenidoEtapa[$index] = $contenidoEtapa[$index]."<b>".$codigoSegunda."</b></a>";
				}
			}
		}
		
		$index++;
		
	}unset($r); unset($s);
	
}

///AGREGAR ETAPAS
$stats = $_POST['status'];

if($stats != ""){
///AGREGAR ASIGNACION
	if(($stats == "ASIGNAR") && ($_POST['pdr'] != "") && ($_POST['fechaAsignar'] != "")){
					
		$pdrInsert 		= $_POST['pdr'];
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaAsignar']));
		
		/*$maximo=0;
		
		$anio = date('Y',strtotime($_POST['fechaAsignar']));
		
		$s= $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Seguimientos WHERE  YEAR(xd_fechaRegistro) = '$anio' ");
		
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		}
		
		$maximo++;
		unset($r); unset($s);
		
		$anio = date('y',strtotime($_POST['fechaAsignar']));
		
		if(strlen($maximo) == 1){
			
			$codigo = "S-".$anio."-00".$maximo;
			
		} else if(strlen($maximo) == 2){
			
			$codigo = "S-".$anio."-0".$maximo;
			
		} else if(strlen($maximo) == 3){
			
			$codigo = "S-".$anio."-".$maximo;
			
		}else if(strlen($maximo) == 4){
			
			$codigo = "S-".$anio."-".$maximo;
			
		}*/
		
		//$INTRANETV2->Execute("INSERT INTO SGI_Seguimientos (xt_tipoOrigen, kf_itemOrigenID, xn_numero, xd_fechaRegistro, xt_codigoSeguimiento, kf_asignadorID, kf_pdrID) 
													// VALUES ('D', $preventivaID, $maximo, '$fechaInsert', '$codigo', 97, $pdrInsert)  ");
		
		//$seguimientoInsert = $INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE xt_codigoSeguimiento = '$codigo' ");
		//ACTUALIZO PDR
		$INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xt_pdr = '$pdrInsert' WHERE xt_claveAccion = '$preventivaID'");
		
		//INSERTO ETAPA DE ASIGNADA
		$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo, xt_usuario) 
														VALUES ('$preventivaID', 1, '$fechaInsert', 'ASIGNAR', '$usuarioId') ");
		
		header("Location: fichaPreventivav2.php?id=$preventivaID");
																
	///AGREGAR ANALISIS DE CAUSA RAIZ
	} else if(($stats == "ANALISIS") && ($_POST['fechaAnalisis'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaAnalisis']));
		
		$archivo = $_FILES['archivoAnalisis']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "../SeguimientoEtapas/$archivo";
			
			if (move_uploaded_file($_FILES['archivoAnalisis']['tmp_name'], $destino)){
				
				$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo, xt_ruta) 
																VALUES ('$preventivaID', 2, '$fechaInsert', 'ANALISIS', '$archivo') ");
		
			}
		}
		
		header("Location: fichaPreventivav2.php?id=$preventivaID");
																
	///AGREGAR DECISION
	} else if(($stats == "DECISION") && ($_POST['fechaDecision'] != "") && ($_POST['decision'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaDecision']));
		
		$decisionInsert = $_POST['decision'];
				
		$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo, xt_contenido, xt_usuario) 
														VALUES ('$preventivaID', 3, '$fechaInsert', 'DECISION', '$decisionInsert', '$usuarioId') ");
														
		if($decisionInsert == 'No es necesario un plan de acción'){
			
			$INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xn_status = 1 WHERE xt_claveAccion = '$preventivaID' ");
			
			$etapaMax 	= 0;
		
			$etapaMax = $INTRANETV2->getOne("SELECT MAX(xn_etapa) FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$preventivaID' ");
			
			$etapaMax++;
				
															
			$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo, xt_contenido) 
															VALUES ('$preventivaID', $etapaMax, '$fechaInsert', 'EVALUACION', '$solicitudID')");
  			
		}
		
		header("Location: fichaPreventivav2.php?id=$preventivaID");
		
	
		////AGREGAR SOLICITUD
	} else if(($stats == "SOLICITUD") && ($_POST['fechaSolicitud'] != "") && ($_POST['codigoSolicitud'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaSolicitud']));
		
		$codigoSolicitud = trim($_POST['codigoSolicitud']);
		
		$etapaMax 	= 0;
		
		$etapaMax = $INTRANETV2->getOne("SELECT MAX(xn_etapa) FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$preventivaID'");
		
		/*while($r = $s->fetchRow()){
			
			$etapaMax = $r[0];
			
		} unset($r);*/
		
		$etapaMax++;
		
		$solicitudID = $INTRANETV2->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoSolicitud' ");
		
		if($solicitudID != ""){
															
			$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo) 
															VALUES ('$preventivaID', $etapaMax, '$fechaInsert', 'SOLICITUD') ");
			
			$INTRANETV2->Execute("INSERT INTO SGI_Preventivas_Correctivas_Plan_Accion (xt_codigoAccion, xt_codigoSolicitud) 
															VALUES ('$preventivaID', '$solicitudID') ");
		}
		
		//AQUI ME QUEDE DEBO CHECAR SI LA RUTA A CORRECTIB¿VA ES CORRECTA
		
		header("Location: fichaPreventivav2.php?id=$preventivaID");
		
	///AGREGAR EVALUACION
	} else if(($stats == "EVALUACION") && ($_POST['fechaEvaluacion'] != "") && ($_POST['evaluacion'] != "")){
		
		
		
		$fechaInsert 		= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
		
		$contenidoInsert	= " ";
		
		if($_POST['contenidoEvaluacion'] != ""){
			
			$contenidoInsert = $_POST['contenidoEvaluacion'];
		}
		
		$evaluacion  = $_POST['evaluacion'];
		
		$etapaMax = 0;
		
		$etapaMax = $INTRANETV2->getOne("SELECT MAX(xn_etapa) FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$preventivaID' ");
		
		$etapaMax++;
		
		///CALIFICACION EFICIENTE
		if($evaluacion == 1){			
											
			$INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xn_status = 1 WHERE xt_claveAccion = '$preventivaID'");
		///CALIFICACION NO EFICIENTE
		} else{
			
			$fechaInsertNueva	= $fechaInsert;
			$tituloInsertNueva	= $titulo;
			
			$ciudadNueva		= $ciudad;
			$anioNueva			= date('Y', strtotime($fechaInsert));
			
			$maximoNueva = 0;
			
			$maximoNueva = $INTRANETV2->getOne("SELECT MAX(xn_numero) FROM SGI_Acciones_Preventivas_Correctivas WHERE YEAR(xd_fecha) = $anioNueva 
									 AND xt_tipo = 'E' AND xt_ciudad = '$ciudadNueva' AND xt_grupo = '$grupo' ");
			
			
			$maximoNueva++;
			
			$codigoNueva = $grupo."-E";
	
			if($ciudadNueva != ""){
				
				$codigoNueva = $codigoNueva."-".$ciudadNueva;
				
			}
			
			$anioNueva = date('y', strtotime($fechaInsert));
			
			if(		  strlen($maximoNueva) == 1){
				
				$codigoNueva = $codigoNueva."-".$anioNueva."-00".$maximoNueva;
				
			} else if(strlen($maximoNueva) == 2){
				
				$codigoNueva = $codigoNueva."-".$anioNueva."-0".$maximoNueva;
				
			} else if(strlen($maximoNueva) == 3){
				
				$codigoNueva = $codigoNueva."-".$anioNueva."-".$maximoNueva;
				
			}
			
			$descripcionNueva 	= "Se vincula con la Acción Preventiva $clave \n\r \n\r".$descripcion;
			
			$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas(xt_tipo, xn_numero, xd_fecha, xt_claveAccion, xt_titulo, xt_descripcion, xt_ciudad, xt_grupo) 
								  VALUES('E', $maximoNueva, '$fechaInsertNueva', '$codigoNueva', '$tituloInsertNueva', '$descripcionNueva', '$ciudadNueva', '$grupo') ");
			
			$contenidoInsert = $contenidoInsert."\n\r \n\r Se vincula con la Acción Preventiva $codigoNueva";
			
		}
		
		$INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas_Etapas (xt_codigoAccion, xn_etapa, xd_fecha, xt_titulo, xt_contenido, xt_usuario) 
														VALUES ('$preventivaID', $etapaMax, '$fechaInsert', 'EVALUACION', '$contenidoInsert', '$usuarioId') ");
		
		//$etapaSeguimientoID = $INTRANET->getOne("SELECT kp_etapaID FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = $etapaMax ");
		
		$archivo = $_FILES['archivoEvaluacion']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "../SeguimientoEtapas/".$archivo;
			
			if (move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $destino)){
				//echo "UPDATE SGI_Seguimiento_Etapas SET xt_ruta = '$destino' WHERE kp_etapaID = $etapaSeguimientoID <br>";
				$INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas_Etapas SET xt_ruta = '$archivo' WHERE xt_codigoAccion = '$preventivaID' AND xt_titulo = 'EVALUACION'");
				
			}
		}
		
		header("Location: fichaPreventivav2.php?id=$preventivaID");
		
	}
}


$breadcrumb = "<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroPreventivasCorrectivasv2.php' id='breadcrumbs'> Tablero de Acciones Preventivas </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Acción Preventiva</title>
             <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript">;
            $(function(){
                $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                
                 });
            });
            </script>
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("causaRaiz1").style.display="none";
						document.getElementById("causaRaiz0").style.display="block";
						document.getElementById("causaRaizPdf").style.display="block";
					} else if (valor == 0){
						document.getElementById("causaRaiz1").style.display="block";
						document.getElementById("causaRaiz0").style.display="none";
						document.getElementById("causaRaizPdf").style.display="none";
					}
				}
				
				function showADDPLAN(valor){
					if(valor == 1){
						document.getElementById("masControl1").style.display="none";
						document.getElementById("masControl2").style.display="block";
						document.getElementById("formSolicitud").style.display="block";
					} else if (valor == 0){
						document.getElementById("masControl1").style.display="block";
						document.getElementById("masControl2").style.display="none";
						document.getElementById("formSolicitud").style.display="none";
					}
				}
				
			</script> 
            
            <script>
				function showBanana(valor){
					if(valor == 1){
						document.getElementById("banana1").style.display="inline-block";
						document.getElementById("banana0").style.display="none";
						document.getElementById("mapaIntranet").style.display="inline-block";
					} else if (valor == 0){
						document.getElementById("banana1").style.display="none";
						document.getElementById("banana0").style.display="inline-block";
						document.getElementById("mapaIntranet").style.display="none";
					}
				}
			</script>
        </head>
		<body>
        
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
	  
	  echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
	  
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Acción Preventiva";
			echo "</td>";
		echo "</tr>";
		  echo"<tr height='10'> </tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		
		//echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
	
	
				//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";

		echo "</td>";
			echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		
	///CUERPO Preventiva
	if ($show == 'Evaluado') {
		$ev = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$preventivaID' ");
		if($ev == 1){
			$semaforo = "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
		}elseif($ev == 0){
			$semaforo = "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
		}
	}
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td align='left' id='titulo2' width='250px'><b>".$clave."</b></td>";
				echo "<td align='right' id='iconosTexto2' width='450px'>";
					if($show != ""){
						echo "Estatus: <b>".$show."  </b>".$semaforo;
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='2'></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td></td>";
				
				echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
				
				echo "<td id='iconosTexto' width='50px' align='right'>";
					if ($ruta != NULL || $ruta != ""){
						echo "<a href='../downloadPreventivasCorrectivas.php?file=".$ruta."'><img src='../../Imagenes/ICN_Archivo.png'></a>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='4'></td></tr>";
		echo "</table>";
	///AUDITORIA E ISSUE
		if($auditoriaID != ""){
			
			echo "<table border='0' align='center' width='700px'>";			
				echo "<tr>";
					echo "<td align='left' id='titulo2'><b>Auditoría relacionada</b></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' width='700px'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='700px'>";
				
				echo "<tr>";
					echo "<td width='40px'></td>";
					
					echo "<td id='fichaRef' width='660px'>";
						echo "<b> Auditoria: <a href='FichaAuditoria.php?id=".$auditoriaID."' id='fichaRef'>".$auditoriaCodigo."</a><br><br> ";
						echo "Hallazgo: <a href='fichaIssue.php?id=".$issueID."' id='fichaRef'>".$issueCodigo."</a></b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
			echo "</table>";
		
		}
	///PDR
		if($pdrNombre != ""){
			
			echo "<table border='0' align='center' width='700px'>";	
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'>";
						echo "<b>PDR (Persona Directamente Responsable)</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td align='left' width='680px' id='iconosTexto'>";
						echo "<b>".$pdrNombre."</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
			echo "</table>";
			
		}
	///SEGUIMIENTO
		echo "<table border='0' align='center' width='700px'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Seguimiento. </b> "; 
					
				echo "</td>";
				
				echo "<td align='right' id='iconosTexto2'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='2'></td></tr>";
		echo "</table>";
		
		/*
		echo "<td align='right'>
			<a href='AgregarSeguimiento.php?origen=E&ID=$correctivaID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\"> 
				<img src='../Imagenes/ICN_BotonMas.png' height='15px' width='15'>
			</a>
		</td>";
		
		*/
		
///CODIGO MOSTRAR SEGUIMIENTO
	if($exisEtapas != ""){

		
		if(count($etapa) >= 1){
			
			for($a = 1; $a <= count($etapa); $a++){
				
			///ETAPA ASIGNADA
				if($etapa[$a] == 1){
					
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							
							echo "<td id='iconosTexto' colspan='2' align='left'>".$fechaEtapa[$a]." <b>".$tituloEtapa[$a]."</b></td>";
							
							echo "<td id='iconosTexto' align='right'>";
							
								if($rutaEtapa[$a] != ""){
										
									echo "<a href='downloadSeguimiento.php?file=".$rutaEtapa[$a]."'>";
										echo "<img src='../../Imagenes/ICN_Archivo.png'>";
									echo "</a>";
									
								}
							
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='20px'>";
							echo "<td width='20px'></td>";
							if($asingadorUser[$a] != ''){
							echo "<td id='iconosTexto3' width='20px'><FONT color='#848484'>Asignó:</td>";
							echo "<td id='iconosTexto3' width='610px'><FONT color='#848484'>".$asingadorUser[$a]."</td>";
							}else{
							echo "<td width='20px'></td>";
							echo "<td width='610px'></td>";
							}
							echo "<td width='50px'></td>";
						echo "</tr>";
					echo "</table>";
					
				}
			///ETAPA ANALISIS DE CAUSA RAIZ
				if($etapa[$a] == 2){
	
					echo "<table border='0' align='center' width='700px' id='causaRaiz1' style='display:block;' onclick='show(1);'>";
						echo "<tr >";
							echo "<td width='20px'></td>";
							
							echo "<td width='660px' id='iconosTexto' align='left'>";
								echo $fechaEtapa[$a]." <b>".$tituloEtapa[$a]."</b>";
							echo "</td>";
							if($rutaEtapa[$a] != ""){
							echo "<td width='20px' id='iconosTexto' align='right'>";
								echo "<a href='downloadSeguimiento.php?file=".$rutaEtapa[$a]."'>";
									//echo "<img src='../Imagenes/ICN_Archivo.png'>";
								echo "</a>";
							echo "</td>";
						echo "</tr>";
						}
					
						echo "<tr height='10px'>";
							echo "<td width='20px'></td>";
							echo "<td width='660px'></td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
					echo "</table>";
					
					
					echo "<table border='0' align='center' width='700px' id='causaRaiz0' style='display:none;' onclick='show(0);'>";	
						echo "<tr >";
							echo "<td width='20px'></td>";
							
							echo "<td width='660px' id='iconosTexto' align='left'>";
								echo $fechaEtapa[$a]." <b>".$tituloEtapa[$a]."</b>";
							echo "</td>";
							
							echo "<td width='20px' id='iconosTexto' align='right'>";
								//echo "<img src='../Imagenes/ICN_Archivo.png'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td width='20px'></td>";
							echo "<td width='660px'></td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='950px' id='causaRaizPdf' style='display:block;'>";
						echo "<tr>";
							echo "<td align='left' width='950px'>";
							
								if(substr($rutaEtapa[$a], -4) == ".pdf"){
									
									echo "<br><br>";
										echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../SeguimientoEtapas/".$rutaEtapa[$a]))."'\" type='application/pdf' width='950px' height='700px'>";
										echo "<p>
													Si este mensaje aparece su navegador no soporta el plugin para el PDF.
													No obstante puede descargar el archivo en este <a href='SeguimientoEtapas/".$rutaEtapa[$a]."'>enlance</a>
											  </p>";
									echo "</object>";
									echo "<br><br>";
									
								}
							
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr height='10px'>";
							echo "<td></td>";
						echo "</tr>";
					echo "</table>";
					
				}
				
			///ETAPA DECISION
				if($etapa[$a] == 3){
					
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							
							echo "<td id='iconosTexto' colspan='2' align='left'>";
								echo $fechaEtapa[$a]." <b>".$tituloEtapa[$a].": </b> ".$contenidoEtapa[$a];
							echo "</td>";
							
							echo "<td id='iconosTexto' align='right'></td>";
						echo "</tr>";
						
						echo "<tr height='20px'>";
							echo "<td width='20px'></td>";
							if($asingadorUser[$a] != ''){
							echo "<td id='iconosTexto3' width='20px'><FONT color='#848484'>Decidió:</td>";
							echo "<td id='iconosTexto3' width='610px'><FONT color='#848484'>".$asingadorUser[$a]."</td>";
							}else{
							echo "<td width='20px'></td>";
							echo "<td width='610px'></td>";
							}
							echo "<td width='50px'></td>";
						echo "</tr>";
					echo "</table>";
					
				}
			
			///ETAPA PLAN DE ACCION
				if($a >= 4){
					break;
				}
				
				echo "<table border='0' align='center' width='700px'>";
					echo "<tr height='20px'>";
						echo "<td width='20px'></td>";
						echo "<td width='20px'></td>";
						echo "<td width='610px'></td>";
						echo "<td width='50px'></td>";
					echo "</tr>";
				echo "</table>";
				
			}
			
		}
	}
	////ASIGNAR
	if($exisEtapas == ""){
	///ASIGNAR FORMULARIO
		if((($_POST['pdr'] == "" ) || ($_POST['fechaAsignar'] == "")) && (($usuarioId == "sdelap") || ($usuarioId == "Christian_Martinez") || ($usuarioId == "Jorge_Doring") ||($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "gabriel") || ($usuarioId == "Lizbeth_Guadarrama") || ($usuarioId == "Miguel_Patiño"))){
			
			echo "<form method='post' action='fichaPreventivav2.php?id=".$preventivaID."'>";
				echo "<table border='0' align='center' width='700px'>";
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='4' id='iconosTexto2'>";
							echo "<b style='font-size:16px;'>Asignar PDR (Persona Directamente Responsable)</b>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='4' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='20px'><td colspan='5'></td></tr>";
					
					echo "<tr align='left' height='20px'>";
						echo "<td width='30px'></td>";
						echo "<td width='20px'></td>";
						echo "<td width='315px' id='iconosTexto2' align='left'><b>Fecha</b></td>";
						echo "<td width='315px' id='iconosTexto2' align='left'><b>PDR</b></td>";
						echo "<td width='20px'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='5'></td></tr>";
					
					echo "<tr align='left' height='20px'>";
						echo "<td></td>";
						echo "<td></td>";
						
						echo "<td align='left'>";
							echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaAsignar'>";
							echo "<input type='hidden' name='status' value='ASIGNAR'>";
						echo "</td>";
						
						echo "<td id='iconosTexto2' align='left'>";
			
							if($ciudad == "CMX" || $ciudad == "GRL"){
									
									$ciudad = "DF";
									
								}
			
								if($ciudad == "LRD"){
									
									$ciudad = "LAR";
									
								}
			
			
							echo "<select name='pdr' size='1'>";
								echo "<option value=''>Elegir</option>";
			
								
			
								$s = $INTRANET->Execute("SELECT EMP.kf_usuario, EMP.xt_Nombre, EMP.xt_ApellidoPaterno FROM SGI_EmpleadosActividad EMPA, 
														 SGI_Empleados EMP, IntranetGEA_Usuarios_Oficina USO WHERE EMP.kp_personalId = EMPA.kf_personalID 
														 AND EMPA.xt_actividad='PDR' AND USO.kf_usuarioId = EMP.kf_usuario AND USO.xt_codigoCiudad = '$ciudad' ");
			
			
								
								while($r= $s -> fetchRow()){
									
									echo "<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
									
								} unset($r); unset($s);
								
							echo "</select>";
						echo "</td>";
						
						echo "<td width='20px'></td>";
					echo "</tr>";
					
					echo "<tr height='20px'><td colspan='5'></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='4' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='5'></td></tr>";
					
					echo "<tr height='40px'>";
						echo "<td></td>";
						echo "<td valign='bottom' align='right' colspan='4'>";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='30px'>";
						echo "<td align='right' colspan='5'></td>";
					echo "</tr>";
				echo "</table>";
			echo "</form>";
	///FIN ASIGNAR FORMULARIO
		}
///FIN ASIGNAR
	} else if($etapa[2] == "" || $etapa[2] == NULL){
	///ANALISIS DE LA CAUSA RAIZ
		if(($usuarioId == $pdrUserId) || ($usuarioId == "sdelap")  || ($usuarioId == "Rodrigo_Romo")  || ($usuarioId == "Jorge_Doring")|| ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Christian_Martinez")|| ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "Lizbeth_Guadarrama")){
		///ANALISIS DE LA CAUSA  FORM

			if($_POST['fechaAnalisis'] == ""){
				
				echo "<form method='post' action='fichaPreventivav2.php?id=".$preventivaID."' enctype='multipart/form-data'>";
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Análisis de la causa raíz</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px'>";
							echo "<td width='30px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='100px' id='iconosTexto2' align='left'>Fecha</td>";
							echo "<td width='530px' id='iconosTexto2' align='left'>Archivo</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							
							echo "<td  align='left'>";
								echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaAnalisis'>";
								echo "<input type='hidden' name='status' value='ANALISIS'>";
							echo "</td>";
							
							echo "<td align='left'>";
								echo "<input type='file' name='archivoAnalisis'>";
							echo "</td>";
							
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr height='40px'>";
							echo "<td></td>";
							echo "<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='30px'>";
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
								
					echo "</table>";
					
					echo "</form>";
		///FIN FORM ANALISIS DE LA CAUSA RAIZ		
			}
	///FIN CONDICION USUARIOS ANALISIS DE LA CAUSA RAIZ
		}
///FIN DE ANALISIS DE LA CAUSA RAIZ
	} else if($etapa[3] == "" || $etapa[3] == NULL){
	///DECISION
		if(($usuarioId == "sdelap")|| ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Jorge_Doring")|| ($usuarioId == "Miguel_Patiño")|| ($usuarioId == "Christian_Martinez")|| ($usuarioId == "Daniel_Guadarrama")  || ($usuarioId == "Lizbeth_Guadarrama")){
		///DECISION  FORM
			if($_POST['fechaDecision'] == "" || $_POST['decision'] == ""){
				
				echo "<form name='agregarSeguimiento' method='post' action='fichaPreventivav2.php?id=".$preventivaID."'>";
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Decisión</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px'>";
							echo "<td width='30px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='100px' id='iconosTexto2' align='left'>Fecha</td>";
							echo "<td width='530px' id='iconosTexto2' align='left'>Seleccione una opción:</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td align='left'>";
								echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaDecision'>";
								echo "<input type='hidden' name='status' value='DECISION'>";
							echo "</td>";
							
							echo "<td align='left'>";
								echo "<select name='decision'>";
									echo "<option value=''>Elegir...</option>";
									echo "<option value='Procede plan de acción'>Procede plan de acción</option>";
									echo "<option value='No es necesario un plan de acción'>No es necesario un plan de acción</option>";
								echo "</select>";
							echo "</td>";
							
							echo "<td></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr height='40px'>";
							echo "<td></td>";
							echo "<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
		///FIN DECISION FORM			
			}
	///FIN CONDICION USUARIOS DECISION 
		}
///FIN DECISION
	} else if(($etapa[3] != "") && ($contenidoEtapa[3] == "Procede plan de acción")){
	///PLAN DE ACCION
		$termino = 0;
		
		 $maxEtapaPreventiva = $tituloEtapa[count($etapa)];
		
		if($maxEtapaPreventiva == "EVALUACION"){
			$termino = 1;
		}
	
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td id='iconosTexto' colspan='2' align='left'>".$fechaEtapa[$a]." <b>Plan de acción</b></td>";
				echo "<td id='iconosTexto' align='right'>";
			///CONDICION USER BOTON AGREGAR
					if((($usuarioId == $pdrUserId) || ($usuarioId == "sdelap")||($usuarioId == "Rodrigo_Romo") ||($usuarioId == "Jorge_Doring") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Daniel_Guadarrama") || ($usuarioId == "Lizbeth_Guadarrama")|| ($usuarioId == "Miguel_Patiño")) && ($termino == 0)|| ($usuarioId == "Christian_Martinez")){
							
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15' onclick='showADDPLAN(1);' id='masControl1' style='display:block;'>";
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15' onclick='showADDPLAN(0);' id='masControl2' style='display:none;'>";
					}
				
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				echo "<td width='610px'></td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
		echo "</table>";
		
	///CONDICION DE TERMINO AGREGAR SOLICITUDES USER AGREGAR SOLICITUD
		if((($usuarioId == $pdrUserId) || ($usuarioId == "sdelap")||($usuarioId == "Rodrigo_Romo") ||($usuarioId == "Jorge_Doring") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Christian_Martinez")|| ($usuarioId == "Daniel_Guadarrama") || ($usuarioId == "Lizbeth_Guadarrama")|| ($usuarioId == "Miguel_Patiño")) && ($termino == 0)){
		///CONDICION FORM AGREGAR SOLICITUD
			if(($_POST['fechaSolicitud'] == "") || ($_POST['codigoSolicitud'] == "")){
				
				echo "<form method='post' action='fichaPreventivav2.php?id=".$preventivaID."' id='formSolicitud' style='display:none;'>";
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Agregar Solicitud</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='20px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px'>";
							echo "<td width='30px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='100px' align='left' id='iconosTexto2'>Fecha</td>";
							echo "<td width='530px' align='left' id='iconosTexto2'>Código</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							
							echo "<td align='left'>";
								echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaSolicitud'>";
								echo "<input type='hidden' name='status' value='SOLICITUD'>";
							echo "</td>";
							
							echo "<td align='left'>";
								echo "<input type='text' size=20 maxlength=100 name='codigoSolicitud'>";
							echo "</td>";
							
							echo "<td></td>";
						echo "</tr>";
						
						echo "<tr height='20px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'><td colspan='5'></td></tr>";
						
						echo "<tr height='40px'>";
							echo "<td></td>";
							echo "<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='30px'>";
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
					echo "</table>";
				echo "</form>";
		///FIN CONDICION FORM AGREGAR SOLICITUD
			}
	///FIN CONDICION DE TERMINO AGREGAR SOLICITUDES USER AGREGAR SOLICITUD
		}
		
		if($etapa[4] != ""){
			
			echo "<table border='0' align='center' width='700px'>";
				echo "<tr height='5px'>";
					echo "<td width='20px'></td>";
					echo "<td width='50px'></td>";
					echo "<td width='250px'></td>";
					echo "<td width='130px'></td>";
					echo "<td width='150px'></td>";
					echo "<td width='100px'></td>";
				echo "</tr>";
				
				echo "<tr height='5px'>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td align='left' id='tituloAzul14B'>Actividad</td>";
					echo "<td align='center' id='tituloAzul14B'>Solicitud</td>";
					echo "<td align='center' id='tituloAzul14B'>Responsable</td>";
					echo "<td align='center' id='tituloAzul14B'>Status</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td colspan='4' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='5px'>";
					echo "<td colspan='6'></td>";
				echo "</tr>";
			echo "</table>";
			
			$a = 0;
			
		/*	$y = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID FROM SGI_Seguimiento_Etapas SSE, SGI_Quejas_Solicitudes SQS 
									WHERE SSE.kf_seguimientoID = $seguimientoID AND SSE.xt_titulo = 'SOLICITUD' AND SQS.kp_quejaSolicitudID = SSE.xt_contenido 
									ORDER BY SQS.xt_claveQuejaSolicitud ");
			
			while($x = $y->fetchRow()){
				///OBTENER DATOS SEGUIMIENTO SOLICITUD
				$tituloSol 	= "";
				$claveSol	= "";
				$segSolId	= "";
				$pdrSolId	= "";
				$solicID	= "";
				$estatSol	= "";
				$pdrSNombre	= "";
				$pdrSApPate = "";
				
				$a++;*/
				$y = $INTRANETV2->Execute("SELECT xt_codigoSolicitud FROM SGI_Preventivas_Correctivas_Plan_Accion WHERE xt_codigoAccion = '$preventivaID' ");
				while($x = $y->fetchRow()){
					///OBTENER DATOS SEGUIMIENTO SOLICITUD
					$tituloSol 	= "";
					$claveSol	= "";
					$segSolId	= "";
					$pdrSolId	= "";
					$solicID	= "";
					$estatSol	= "";
					$pdrSNombre	= "";
					$pdrSApPate = "";
					
					$a++;
				
				
				$s = $INTRANETV2->Execute("SELECT xt_titulo, xt_quejaSolicitud, xt_pdr FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$x[0]'");
				
				while($r = $s->fetchRow()){
					
					$tituloSol 	= $r[0];
				    $pdrSolId   = $r[2];
					$claveSol	= "<a href='../../ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?codigo=".$x[0]."' id='iconosTexto3' style='text-decoration:none;' >".$r[1]."</a>";
					$solicitud  = $r[1];
					
				
						//$u = $INTRANET->Execute("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $segSolId ORDER BY SQSE.xn_numero ");
						$estatSol = $INTRANETV2->getOne("SELECT  xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$r[1]'");
					
							
							if($estatSol == "ABIERTA"){
								$estatSol = "Asignada";
								
							} else if($estatSol == "REVISION"){
								$estatSol = "Para Revisión";
								
							} else if($estatSol == "RECHAZADA"){
								$estatSol = "Rechazada";
								
							} else if($estatSol == "TERMINADA"){
								$estatSol = "Terminada";
								
							}
							
						
						
						
						/*
						$u = $INTRANET->Execute("SELECT SEM.xt_Nombre, SEM.xt_ApellidoPaterno FROM SGI_Empleados SEM WHERE SEM.kp_personalId = $pdrSolId ");
						*/
						
						$pdrSNombre = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdrSolId'");
						
					//}
					
				} unset($r); unset($s);
				
				///SCRIPT OCULTAR BLOQUES DE UNA SOLICITUD
				echo "<script>
						function showSolicitud".$a."(valor){
							if(valor == 1){
								document.getElementById(\"cuerpoSol".$a."OFF\").style.display=\"block\";
								document.getElementById(\"cuerpoSol".$a."ON\").style.display=\"none\";
								document.getElementById(\"seguimientoSol".$a."\").style.display=\"block\";
							} else if (valor == 0){
								document.getElementById(\"cuerpoSol".$a."OFF\").style.display=\"none\";
								document.getElementById(\"cuerpoSol".$a."ON\").style.display=\"block\";
								document.getElementById(\"seguimientoSol".$a."\").style.display=\"none\";
							}
						}
					</script> ";
				
				///SEPARACION ENTRE SOLICITUDES
				echo "<table border='0' align='center' width='700px'>";
					echo "<tr height='5px'>";
						echo "<td></td>";
					echo "</tr>";
				echo "</table>";
				
				///MOSTRAR BLOQUE CUERPO SOLICITUD
				echo "<table border='0' align='center' width='700px' id='cuerpoSol".$a."ON' style='display:block;'>";
					echo "<tr onclick='showSolicitud".$a."(1);'>";
						echo "<td width='20px'></td>";
						echo "<td width='50px'></td>";
						echo "<td width='250px' align='left' id='iconosTexto3' valign='top'>".$tituloSol."</td>";
						echo "<td width='130px' align='center' id='iconosTexto3' valign='top'>".$claveSol."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$pdrSNombre."</td>";
						echo "<td width='100px' align='center' id='iconosTexto3' valign='top'>".$estatSol."</td>";
					echo "</tr>";
				echo "</table>";
				
				///OCULTAR BLOQUE CUERPO SOLICITUD
				echo "<table border='0' align='center' width='700px' id='cuerpoSol".$a."OFF' style='display:none;'>";
					echo "<tr height='5px' onclick='showSolicitud".$a."(0);'>";
						echo "<td width='20px'></td>";
						echo "<td width='50px'></td>";
						echo "<td width='250px' align='left' id='iconosTexto3' valign='top'>".$tituloSol."</td>";
						echo "<td width='130px' align='center' id='iconosTexto3' valign='top'>".$claveSol."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$pdrSNombre."</td>";
						echo "<td width='100px' align='center' id='iconosTexto3' valign='top'>".$estatSol."</td>";
					echo "</tr>";
				echo "</table>";
				///BLOQUE CUERPO SOLICITUD
				$numeroEtapaSol		= NULL;
				$estatusEtapaSol	= NULL;
				$contenidoEtapaS	= NULL;
				$fechaEtapaSol 		= NULL;
						
				if($segSolId != ""){
					
					$i 		= 1;
					
					$s = $INTRANETV2->Execute("SELECT xn_numero, xt_estatus, xt_contenido, xd_fecha FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitud' ORDER BY xn_numero");
							
					while($r = $s->fetchRow()){
						
						$numeroEtapaSol[$i]		= $r[0];
						$estatusEtapaSol[$i]	= $r[1];
						$contenidoEtapaS[$i]	= nl2br($r[2]);
						$fechaEtapaSol[$i] 		= date('Y-m-d', strtotime($r[3]));
						
						if($estatusEtapaSol[$i] == "ABIERTA"){
							
							$estatusEtapaSol[$i] = "Asignada";
							
						} else if($estatusEtapaSol[$i] == "REVISION"){
							
							$estatusEtapaSol[$i] = "Para Revisión";
							
						} else if($estatusEtapaSol[$i] == "RECHAZADA"){
							
							$estatusEtapaSol[$i] = "Rechazada";
							
						} else if($estatusEtapaSol[$i] == "TERMINADA"){
							
							$estatusEtapaSol[$i] = "Terminada";
							
						}
						//echo "No: $numeroEtapaSol[$i], Stat: $estatusEtapaSol[$i], Fecha: $fechaEtapaSol[$i], Cont: $contenidoEtapaS[$i]<br>";
						$i++;
						
					}unset($r); unset($s); unset($i);
					
					
					echo "<table border='0' align='center' width='700px' id='seguimientoSol".$a."' style='display:none;'>";
						echo "<tr height='5px'>";
							echo "<td colspan='3'></td>";
							echo "<td colspan='3' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						for($o = 1; $o <= count($numeroEtapaSol); $o++){
							
							echo "<tr height='15px'>";
								echo "<td colspan='6'></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td width='20px'></td>";
								echo "<td width='50px'></td>";
								echo "<td width='50px'></td>";
								echo "<td width='100px' align='center' id='textIntro'><b>".$fechaEtapaSol[$o]."</b></td>";
								echo "<td width='430px' align='left' id='textIntro'><b>".$estatusEtapaSol[$o]."</b></td>";
								echo "<td width='50px'></td>";
							echo "</tr>";
							
							echo "<tr height='5px'>";
								echo "<td colspan='6'></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td width='20px'></td>";
								echo "<td width='50px'></td>"; 
								echo "<td width='50px'></td>";
								echo "<td width='100px'></td>";
								echo "<td width='430px' align='justify' id='textIntro'>".$contenidoEtapaS[$o]."</td>";
								echo "<td width='50px'></td>";
							echo "</tr>";
							
							echo "<tr height='15px'>";
								echo "<td colspan='6'> </td>";
							echo "</tr>";
						}
						
						echo "<tr height='5px'>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td colspan='3' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						
						echo "<tr height='30px'>";
							echo "<td colspan='6'></td>";
						echo "</tr>";
					echo "</table>";
				
				}
				
			}
			
			echo "<table boder='0' align='center' width='300px'>";
				echo "<tr height='40px'><td></td></tr>";
			echo "</table>";
			
		}
		
///FIN PLAN DE ACCION
		
	} 
	///EVALUACION
	if(($etapa[3] != "") && ($tituloEtapa[count($etapa)] != "Evaluación de la eficacia")){
		//echo "etapa:".$etapa[4].", tit:".$tituloEtapa[count($etapa)]."<br>";
		
		if(($usuarioId == "sdelap")|| ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "Jorge_Doring")|| ($usuarioId == "Christian_Martinez") || ($usuarioId == "Lizbeth_Guadarrama")|| ($usuarioId == "Daniel_Guadarrama")){
		///EVALUACION  FORM
			if(($_POST['fechaEvaluacion'] == "") || ($_POST['evaluacion'] == "")){
				
				echo "<form method='post' action='fichaPreventivav2.php?id=$preventivaID'  enctype='multipart/form-data'>";
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Evaluación de la eficacia</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px'>";
							echo "<td width='30px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='100px' id='iconosTexto2' align='left'>Fecha</td>";
							echo "<td width='530px' id='iconosTexto2' align='left'>Evaluación</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							
							echo "<td align='left'>";
								echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
								echo "<input type='hidden' name='status' value='EVALUACION'>";
							echo "</td>";
							
							echo "<td align='left'>";
								echo "<select name='evaluacion'>";
									echo "<option value='' selected=''>Elegir...</option>";
									echo "<option value='1'>Eficaz</option>";
									echo "<option value='0'>No Eficaz</option>";
								echo "</select>";
							echo "</td>";
							
							echo "<td></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px'>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td colspan='2' id='iconosTexto2' align='left'>Contenido</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							
							echo "<td colspan='2' id='iconosTexto2' align='left'>";
								echo "<textarea name='contenidoEvaluacion' style='width: 630px; height: 60px;'></textarea>";
							echo "</td>";
							
							echo "<td></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20px' >";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td colspan='2' id='iconosTexto2' align='left'>Archivo</td>";
							echo "<td width='20px'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr align='left'>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td colspan='2' id='iconosTexto2' align='left'>";
								echo "<input type='file' name='archivoEvaluacion'>";
							echo "</td>";
							echo "<td></td>";
						echo "</tr>";
						
						echo "<tr height='15px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td colspan='4' id='titleBlueLineBottom'></td>";
						echo "</tr>";
						
						echo "<tr height='10px'>";
							echo "<td colspan='5'></td>";
						echo "</tr>";
						
						echo "<tr height='40px'>";
							echo "<td></td>";
							echo "<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='30px'>";
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
		///FIN FORM EVALUACION	
			}
	///FIN CONDICION USUARIOS EVALUACION
		}
///FIN DE EVALUACION
	} else if($tituloEtapa[count($etapa)] == "Evaluación de la eficacia"){
				$cal = "";
		$cal = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$preventivaID'");
		if($cal == 0){
			$cal = "No eficaz";
		} elseif($cal == 1){
			$cal = "Eficaz";
		}
		
		echo "<script>
				function showEvaluacion(valor){
					if(valor == 1){
						document.getElementById(\"cuerpoEvaOFF\").style.display=\"block\";
						document.getElementById(\"cuerpoEvaON\").style.display=\"none\";
						document.getElementById(\"seguimientoEva\").style.display=\"block\";
					} else if (valor == 0){
						document.getElementById(\"cuerpoEvaOFF\").style.display=\"none\";
						document.getElementById(\"cuerpoEvaON\").style.display=\"block\";
						document.getElementById(\"seguimientoEva\").style.display=\"none\";
					}
				}
			</script> ";
		
		echo "<table border='0' align='center' width='700px' id='cuerpoEvaON' style='display:block;' onclick='showEvaluacion(1);'>";
			echo "<tr >";
				echo "<td width='20px'></td>";
				echo "<td width='660px' id='iconosTexto' align='left' >".$fechaEtapa[count($etapa)]." <b>Evaluación de la eficacia:</b> ".$cal."</td>";
				echo "<td width='20px' id='iconosTexto' align='right'>";
					if($rutaEtapa[count($etapa)] != ""){
						//echo "<img src='../Imagenes/ICN_Archivo.png'>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr >";
				echo "<td width='20px'></td>";
				if($asingadorUser[count($etapa)] != ''){
				echo "<td width='660px' id='iconosTexto3' align='left'><FONT color='#848484'>Evalúo: ".$asingadorUser[count($etapa)]."</td>";
				}else{
					echo "<td width='660px' id='iconosTexto3' align='left'><FONT color='#848484'></td>";
				}
				echo "<td width='20px' id='iconosTexto' align='right'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'>";
				echo "<td width='20px'></td>";
				echo "<td width='660px'></td>";
				echo "<td width='20px'></td>";
			echo "</tr>";	
		echo "</table>";
		
		echo "<table border='0' align='center' width='700px' id='cuerpoEvaOFF' style='display:none;' onclick='showEvaluacion(0);'>";	
			echo "<tr >";
				echo "<td width='20px'></td>";
				echo "<td width='660px' id='iconosTexto' align='left'>".$fechaEtapa[count($etapa)]." <b>Evaluación de la eficacia:</b> ".$cal."</td>";
				echo "<td width='20px' id='iconosTexto' align='right'>";
					if($rutaEtapa[count($etapa)] != ""){
						echo "<a href='../downloadSeguimiento.php?file=".$rutaEtapa[count($etapa)]."'>";
						//echo "<img src='../Imagenes/ICN_Archivo.png'>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'>";
				echo "<td width='20px'></td>";
				echo "<td width='660px'></td>";
				echo "<td width='20px'></td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='950px' id='seguimientoEva' style='display:block;'>";
			echo "<tr>";
				echo "<td align='left' width='950px'>";
				
					if(substr($rutaEtapa[count($etapa)], -4) == ".pdf"){
						
						echo "<br><br>";

							echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../SeguimientoEtapas/".$rutaEtapa[$a]))."'\" type='application/pdf' width='950px' height='700px'>";
							
						 echo "<p>
										Si este mensaje aparece su navegador no soporta el plugin para el PDF.
										No obstante puede descargar el archivo en este <a href='SeguimientoEtapas/".$rutaEtapa[count($etapa)]."'>enlance</a>
								  </p>";
						echo "</object>";
						echo "<br><br>";
						
					}
				
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='700px'>";				
			echo "<tr height='5px'>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				echo "<td width='610px'></td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
			
			echo "<tr >";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				echo "<td width='610px' id='fileItem'>".$contenidoEtapa[count($etapa)]."</td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
		echo "</table>";
	}
	
	echo "<table border='0' align='center' width='700px'>";	
///LINEA FINAL
		echo "<tr height='30px'></tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs' width='700px'>";
				echo "<i><a href='imprimeFichaPreventiva.php?id=".$preventivaID."&clave=".$clave."' id='breadcrumbs'>Imprimir</a></i>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		/*echo "<tr>";
			echo "<td align='right'>";
				echo "<a href='fichaSolicitudModificacion.php?id=$solicitudID' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
		echo "</tr>";*/
	
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";

echo "</div>";
?>
		</body>
	</html>
<?php
