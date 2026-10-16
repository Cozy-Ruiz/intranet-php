<?php

$nombrephp = 'AuditoriaActualizar.php';
require_once("../../ConexionIntranet2.php");
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
//error_reporting(E_PARSE);
function obtenerCodigo(){
	if(!empty($_POST['codigo'])){
		$codigo = $_POST['codigo'];
	} else if(!empty($_GET['id'])){
		$codigo = $_GET['id'];
	}
	return $codigo;
}
function evaluarAuditoria($INTRANETV2, $codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$condicion = $INTRANETV2->getOne("
			SELECT 
				xt_tipo
			FROM
				SGI_Auditorias
			WHERE
				xt_claveAuditoria = '$codigo'
		");
	return $condicion;
}
function validarAuditoriaExterna($INTRANETV2, $codigo){
	if(@$_POST["programa"] != NULL){
		$programa = $_POST["programa"];
		$INTRANETV2->Execute("set names 'utf8'");	
		$INTRANETV2->Execute("
				UPDATE 
					SGI_Auditorias 
				SET 
					xt_descripcionPlan = '".$programa."' 
				WHERE 
					xt_claveAuditoria = '".$codigo."'
			");
	}
	if(@$_POST["informe"] != NULL){		
		$informe = $_POST["informe"];
		$INTRANETV2->Execute("set names 'utf8'");	
		$INTRANETV2->Execute("
				UPDATE 
					SGI_Auditorias 
				SET 
					xt_descripcionInforme = '".$informe."' 
				WHERE 
					xt_claveAuditoria = '".$codigo."'
			");
	}	
}
function validarAuditoriaInterna($INTRANETV2, $codigo){
	if(@$_POST["objetivos"] != NULL){			
		$objetivosPlan = $_POST["objetivos"];
		$objetivosPlan = implode(",",$objetivosPlan);
		$INTRANETV2->Execute("set names 'utf8'");
		$objetivosActuales = $INTRANETV2->getOne("
				SELECT
					xt_objetivosAuditoria 
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($objetivosActuales != ("" || NULL)){
			if($objetivosPlan != $objetivosActuales){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_objetivosAuditoria = '".$objetivosPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_objetivosAuditoria = '".$objetivosPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["alcances"] != NULL){	
		$alcancesPlan = $_POST["alcances"];	
		$INTRANETV2->Execute("set names 'utf8'");
		$alcancesActuales = $INTRANETV2->getOne("
				SELECT
					xt_alcanceAuditoria
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");

		if($alcancesActuales != ("" || NULL)){
			if($alcancesPlan != $alcancesActuales){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_alcanceAuditoria = '".$alcancesPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_alcanceAuditoria = '".$alcancesPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}	
	if(@$_POST["criterios"] != NULL){	
		$criteriosPlan = $_POST["criterios"];
		$criteriosPlan = implode(",",$criteriosPlan);
		$INTRANETV2->Execute("set names 'utf8'");
		$criteriosActuales = $INTRANETV2->getOne("
				SELECT
					xt_criteriosAuditoria
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($criteriosActuales != ("" || NULL)){
			if($criteriosPlan != $criteriosActuales){
				$INTRANETV2->Execute("set names 'utf8'");				
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_criteriosAuditoria = '".$criteriosPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_criteriosAuditoria = '".$criteriosPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["riesgos"] != NULL){	
		$riesgosPlan = $_POST["riesgos"];
		$INTRANETV2->Execute("set names 'utf8'");
		$riesgosActuales = $INTRANETV2->getOne("
				SELECT
					xt_riesgosAuditoria
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($riesgosActuales != ("" || NULL)){
			if($riesgosPlan != $riesgosActuales){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_riesgosAuditoria = '".$riesgosPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");			
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_riesgosAuditoria = '".$riesgosPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["recursos"] != NULL){	
		$recursosPlan = $_POST["recursos"];
		$INTRANETV2->Execute("set names 'utf8'");
		$recursosActuales = $INTRANETV2->getOne("
				SELECT
					xt_recursosAuditoria
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($recursosActuales != ("" || NULL)){
			if($recursosPlan != $recursosActuales){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_recursosAuditoria = '".$recursosPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_recursosAuditoria = '".$recursosPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["equipo"] != NULL){	
		$equipoPlan = $_POST["equipo"];
		$equipoPlan = implode(",",$equipoPlan);
		$INTRANETV2->Execute("set names 'utf8'");
		$equipoActual = $INTRANETV2->getOne("
				SELECT
					xt_equipoAuditor
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");

		if($equipoActual != ("" || NULL)){
			if($equipoPlan != $equipoActual){
				$INTRANETV2->Execute("set names 'utf8'");	
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_equipoAuditor = '".$equipoPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {	
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_equipoAuditor = '".$equipoPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["lider"] != NULL){	
		$liderPlan = $_POST["lider"];	
		$INTRANETV2->Execute("set names 'utf8'");
		$liderActual = $INTRANETV2->getOne("
				SELECT
					xt_auditorLider
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($liderActual != ("" || NULL)){
			if($liderPlan != $liderActual){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_auditorLider = '".$liderPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_auditorLider = '".$liderPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["otrosObjetivos"] != NULL){	
		$otrosObjetivosPlan = $_POST["otrosObjetivos"];	
		$INTRANETV2->Execute("set names 'utf8'");
		$otrosObjetivosActual = $INTRANETV2->getOne("
				SELECT
					xt_otrosObjetivos
				FROM
					SGI_AUDITORIAS_PLANES
				WHERE
					xt_claveAuditoria = '".$codigo."'
			");
		if($otrosObjetivosActual != ("" || NULL)){
			if($otrosObjetivosPlan != $otrosObjetivosActual){
				$INTRANETV2->Execute("set names 'utf8'");
				$INTRANETV2->Execute("
						UPDATE 
							SGI_AUDITORIAS_PLANES 
						SET 
							xt_otrosObjetivos = '".$otrosObjetivosPlan."' 
						WHERE 
							xt_claveAuditoria = '".$codigo."'
					");
			}
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					UPDATE 
						SGI_AUDITORIAS_PLANES 
					SET 
						xt_otrosObjetivos = '".$otrosObjetivosPlan."' 
					WHERE 
						xt_claveAuditoria = '".$codigo."'
				");
		}
	}
	if(@$_POST["nuevoAuditor"] != NULL){	
		$nuevoAuditorPlan = $_POST["nuevoAuditor"];	
		$INTRANETV2->Execute("set names 'utf8'");
		$maxPosicion = $INTRANETV2->getOne("
				SELECT 
					MAX(xn_posicion)
				FROM 
					SGI_Catalogo_Auditores
			");
		++$maxPosicion;
		$claveAuditor = "A".$maxPosicion."";
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->Execute("
				INSERT INTO
					SGI_Catalogo_Auditores (xt_claveAuditor, xt_nombreAuditor, xn_posicion) 
				VALUES 
					('$claveAuditor' , '$nuevoAuditorPlan', $maxPosicion)
			");
	}
}
function actualizarAuditorElabora($INTRANETV2, $codigo, $usuarioId){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("	
			UPDATE 
				SGI_AUDITORIAS_PLANES 
			SET 
				xt_nombreElabora = '$usuarioId'
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function obtenerAuditorElabora($INTRANETV2, $codigo, $usuarioId){
	$INTRANETV2->Execute("set names 'utf8'");
	$auditorElabora = $INTRANETV2->getOne("
			SELECT
				CONCAT(SGI_Empleados.xt_Nombre, ' ', SGI_Empleados.xt_ApellidoPaterno) as nombre
			FROM
				SGI_Empleados, SGI_AUDITORIAS_PLANES
			WHERE 
				SGI_Empleados.kf_usuario = '$usuarioId'
			AND
				SGI_AUDITORIAS_PLANES.xt_claveAuditoria = '$codigo'
		");
	return $auditorElabora;
}
function actualizarFechaElabora($INTRANETV2, $codigo){
	$fechaActual = date("Y-m-d H:i:s");
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("	
			UPDATE 
				SGI_AUDITORIAS_PLANES 
			SET 
				xd_fechaElabora = '$fechaActual'
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function obtenerFechaElabora($INTRANETV2, $codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$fechaElabora = $INTRANETV2->getOne("	
			SELECT
				xd_fechaElabora
			FROM
				SGI_AUDITORIAS_PLANES
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
	return $fechaElabora;
}
function cambiarStatusElabora($INTRANETV2,$codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("	
			UPDATE 
				SGI_AUDITORIAS_PLANES 
			SET 
				xn_status = 1
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function actualizarAuditorRevisa($INTRANETV2, $codigo, $usuarioId){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("	
			UPDATE 
				SGI_AUDITORIAS_PLANES 
			SET 
				xt_nombreAprueba = '$usuarioId'
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function obtenerAuditorRevisa($INTRANETV2, $codigo, $usuarioId){
	$INTRANETV2->Execute("set names 'utf8'");
	$auditorRevisa = $INTRANETV2->getOne("
			SELECT
				CONCAT(SGI_Empleados.xt_Nombre, ' ', SGI_Empleados.xt_ApellidoPaterno) as nombre
			FROM
				SGI_Empleados, SGI_AUDITORIAS_PLANES
			WHERE 
				SGI_Empleados.kf_usuario = '$usuarioId'
			AND
				SGI_AUDITORIAS_PLANES.xt_claveAuditoria = '$codigo'
		");
	return $auditorRevisa;
}
function actualizarFechaRevisa($INTRANETV2, $codigo){
	$fechaActual = date("Y-m-d H:i:s");
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("
			UPDATE 
				SGI_AUDITORIAS_PLANES
			SET 
				xd_fechaAprueba = '$fechaActual'
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function obtenerFechaRevisa($INTRANETV2, $codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$fechaElabora = $INTRANETV2->getOne("	
			SELECT
				xd_fechaAprueba
			FROM
				SGI_AUDITORIAS_PLANES
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
	return $fechaElabora;
}
function cambiarStatusRevisa($INTRANETV2,$codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("	
			UPDATE 
				SGI_AUDITORIAS_PLANES 
			SET 
				xn_status = 2
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
}
function obtenerStatus($INTRANETV2,$codigo){
	$INTRANETV2->Execute("set names 'utf8'");
	$status = $INTRANETV2->getOne("	
			SELECT
				xn_status
			FROM
				SGI_AUDITORIAS_PLANES 
			WHERE 
				xt_claveAuditoria = '$codigo'
		");
	return $status;
}
function insertarRegistroAgenda($INTRANETV2, $codigo){
	if((@$_POST["auditor"] != NULL)||(@$_POST["manual"] != NULL)||(@$_POST["puesto"] != NULL)||(@$_POST["fecha"] != NULL)||(@$_POST["hora"] != NULL)){
		$codigo  		= $codigo;
		$auditor 		= $_POST["auditor"];
		$proceso 		= $_POST["manual"];
		$puesto  		= $_POST["puesto"];
		$fecha   		= $_POST["fecha"];
		$fecha			= new DateTime ($fecha);
		$fecha			= $fecha->format("Y-m-d");
		$hora    		= $_POST["hora"];
		$fechaAuditoria = $fecha . " " . $hora;
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->Execute("
				INSERT INTO
					SGI_Auditorias_Agenda (xt_claveAuditoria, xt_auditor,xt_procesoAuditoria, xt_puestoAuditoria, xd_fechaAuditoria) 
				VALUES 
					('$codigo' , '$auditor', '$proceso', '$puesto', '$fechaAuditoria')
			");
	}
}
function eliminarRegistroAgenda($INTRANETV2, $codigo){
	if(!empty($_POST['elimina'])){
		$registrosSeleccionados = $_POST['elimina'];
		$cantidadSeleccionada = count($registrosSeleccionados);
	    for($i=0; $i < $cantidadSeleccionada; $i++){
			$fecha = $registrosSeleccionados[$i];
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("
					DELETE FROM 
						SGI_Auditorias_Agenda
					WHERE
						(xt_claveAuditoria = '$codigo')
					AND
						(xd_fechaAuditoria = '$fecha')
				");
	    }
	}
}
function evaluarHallazgos($INTRANETV2, $codigo){
	if(@$_POST['existeH'] ==  'si'){
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'Si' WHERE xt_claveAuditoria = '".$codigo."'");
		
	} else if(@$_POST['existeH'] ==  'no'){
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'No' WHERE xt_claveAuditoria = '".$codigo."'");
	}
}
$codigo = obtenerCodigo();
$condicion = evaluarAuditoria($INTRANETV2,$codigo);
$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Auditorías </a>";
$bandera = 0;
validarAuditoriaInterna($INTRANETV2, $codigo);
validarAuditoriaExterna($INTRANETV2, $codigo);
if(!empty($codigo)){
	$INTRANETV2->Execute("set names 'utf8'");
	$registro 		= $INTRANETV2->getOne("SELECT * FROM SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");
	if($registro == null){
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->Execute("
				INSERT INTO
					SGI_AUDITORIAS_PLANES (xt_claveAuditoria) 
				VALUES 
					('$codigo')
			");
	}
	$INTRANETV2->Execute("set names 'utf8'");
	$alcanceP 		= $INTRANETV2->getOne("SELECT xt_alcanceAuditoria FROM SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$riesgosP 		= $INTRANETV2->getOne("SELECT xt_riesgosAuditoria FROM SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$recursosP 		= $INTRANETV2->getOne("SELECT xt_recursosAuditoria FROM SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$liderP 		= $INTRANETV2->getOne("SELECT xt_auditorLider FROM SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");		
	$INTRANETV2->Execute("set names 'utf8'");
	$rutaP 		= $INTRANETV2->getOne("SELECT xt_rutaPlan FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$nombreArchivoPlan 		= $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_rutaPlan,'/',-1)FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");	
	$informe = $INTRANETV2->getOne("SELECT xt_descripcionInforme FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$programa	= $INTRANETV2->getOne("SELECT xt_descripcionPlan FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$rutaI 		= $INTRANETV2->getOne("SELECT xt_rutaInforme FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$nombreArchivoInforme 		= $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_rutaInforme,'/',-1)FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
	$INTRANETV2->Execute("set names 'utf8'");
	$otrosObjetivosPlan	= $INTRANETV2->getOne("SELECT xt_otrosObjetivos FROM 	SGI_AUDITORIAS_PLANES WHERE xt_claveAuditoria = '".$codigo."'");
	insertarRegistroAgenda($INTRANETV2, $codigo);
	eliminarRegistroAgenda($INTRANETV2, $codigo);
	evaluarHallazgos($INTRANETV2, $codigo);
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
				<title>Actualizar Auditoría</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				} else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
				?> 
			   	<link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
			    <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
			    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.7.1.min.js"></script>
			    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.17.custom.min.js"></script>		
			    <script type="text/javascript">
			    	$(document).ready(function() {
			    		var status    = '<?php echo obtenerStatus($INTRANETV2,$codigo); ?>';
				    	var condicion = '<?php echo $condicion; ?>';
				    	if ((status == '') || (status == null)) {
				    		document.getElementById("seccionElaboracion").style.display="block";
				    	} else if(status == 1){
				    		var fechaElabora   = '<?php echo obtenerFechaElabora($INTRANETV2,$codigo); ?>';
				    		var auditorElabora = '<?php echo obtenerAuditorElabora($INTRANETV2,$codigo,$usuarioId); ?>';
				    		document.getElementById("fechaElabora").innerHTML = fechaElabora;
				    		document.getElementById("auditorElabora").innerHTML = auditorElabora;
				    		document.getElementById("seccionElaboracion").style.display="none";
							document.getElementById("seccionRevision").style.display="block";
				    	} else if (status == 2){
				    		var fechaRevision   = '<?php echo obtenerFechaRevisa($INTRANETV2,$codigo); ?>';
				    		var auditorRevision = '<?php echo obtenerAuditorRevisa($INTRANETV2,$codigo,$usuarioId); ?>';	
				    		document.getElementById("fechaRevisa").innerHTML = fechaRevision;
				    		document.getElementById("auditorRevisa").innerHTML = auditorRevision;
							document.getElementById("seccionRevision").style.display="none";
							document.getElementById("seccionEnvio").style.display="block";
							$("#elementosOperar :input").attr("disabled", true);				    		
				    	}
				    	if(condicion == 'EX'){
				    		$('#wrapperFichaExterna').show();
				    	} else {
				    		$('#wrapperFichaInterna').show();
				    	}
			    		if (document.getElementById("otrosObjetivos").checked==true){
			    			document.getElementById("agregaObjetivo").style.display="block";
			    		} else {
			    			document.getElementById("agregaObjetivo").style.display="none";
			    		}
						$("#otrosObjetivos").change(function() {
						    if(this.checked) {
								document.getElementById("agregaObjetivo").style.display="block";
						    } else if (!this.checked){
								document.getElementById("agregaObjetivo").style.display="none";
						    }
						});					  
						$("#otroAuditor").change(function() {
						    if(this.checked) {
								document.getElementById("agregaAuditor").style.display="block";
						    } else if (!this.checked){
								document.getElementById("agregaAuditor").style.display="none";
						    }
						});					  
					});				
			    	function validarRegistroAgenda(){
	    		    	var inputAuditor = document.forms["formulario"]["auditor"].value;
	    		    	var inputManual = document.forms["formulario"]["manual"].value;
	    		    	var inputPuesto = document.forms["formulario"]["puesto"].value;
	    		    	var inputFecha = document.forms["formulario"]["fecha"].value;
	    		    	var inputHora = document.forms["formulario"]["hora"].value;
					    if ((inputAuditor !=  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )) {
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el manual y puesto a auditar con su respectiva fecha y hora.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y puesto a auditar con su respectiva fecha y hora.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y manual a auditar con su respectiva fecha y hora.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha != "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor, manual y puesto a auditar con su respectiva hora.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor, manual y puesto a auditar con su respectiva hora.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar con su respectiva fecha y hora.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la fecha y la hora.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora == "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la hora.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la fecha.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y manual a auditar.");
					        return false;
					    } else if ((inputAuditor ==  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el proceso a auditar.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar con su respectiva fecha.");
					        return false;
					    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha != "" ) && (inputHora != "" )){
					        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar.");
					        return false;
					    }
			    	}


					$.datepicker.regional['es'] = {
					 closeText: 'Cerrar',
					 prevText: '< Ant',
					 nextText: 'Sig >',
					 currentText: 'Hoy',
					 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
					 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
					 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
					 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
					 weekHeader: 'Sm',
					 dateFormat: 'dd/mm/yy',
					 firstDay: 1,
					 isRTL: false,
					 showMonthAfterYear: false,
					 yearSuffix: ''
					 };
					 $.datepicker.setDefaults($.datepicker.regional['es']);			    	
					$(function(){
						$( "#datepicker" ).datepicker();
					});																	
			    </script>		
			</head>
			<body>
	<?php
	// CONTENEDOR DE LA FICHA DE AUDITORIA EXTERNA
	echo "<div id='wrapperFichaExterna' align='center' style='display:none'>";
		echo "<form method='post' id='formularioExterno' action='AuditoriaActualizarv2.php?id=$codigo'>";
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";						
				echo "<tr height='80px'><td></td></tr>";
				///Titulo 
				echo "<tr>";
					echo "<td align='center' class='titulo1' width='700px'>";
						echo $codigo;
					echo "</td>";
				echo "</tr>";					
				echo "<tr>"; 
					echo "<td align='center'>";
						echo $breadcrumb;
					echo "</td>";
				echo "</tr>";							
				echo "<tr height='50'><td></td></tr>";		
			echo "</table>";					
			echo"<table border='0' align='center' width='700px'>";	
				echo"<tr height='50px'><td colspan='4'></td></tr>";
				echo "<tr>";
					echo "<td colspan='3' class='titulo2'><b>Plan de auditoría</b></td>";
					echo "<td>";							
						if(($rutaP == "") || ($rutaP == NULL)){								
							echo "<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php?id=".$codigo."&tipo=PROGRAMA' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
								echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
							echo "</a>";								
						}
					echo "</td>";
				echo "</tr>";					
				echo "<tr>";
					echo "<td class='titleBlueLineBottom' colspan='4'></td>";
				echo "</tr>";				
				echo"<tr height='10px'><td colspan='4'></td></tr>";			
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td colspan='2' id='textIntro'>";
						if($rutaP != ""){								
							echo "<i>".$nombreArchivoPlan."</i> <a href='../downloadAuditoria.php?file=".$rutaP."'><img src='../../Imagenes/ICN_Archivo.png'></a>";
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10px'><td colspan='4'></td></tr>";
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";
					echo "<td width='645px'>";
						echo "<textarea  name='programa' style='width: 645px; height:200px;'>".$programa."</textarea><input type='hidden' name='codigo' value='".$codigo."'>";
					echo "</td>";
					echo "<td width='15px' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
					echo "</td>";
				echo "</tr>";		
				echo"<tr height='20px'><td colspan='4'></td></tr>";		
			echo "</table>";
			//Informe de la auditoria
			echo "<table border='0' align='center' width='700px'>";
				echo "<tr>";
					echo "<td class='titulo2' colspan='3'><b>Informe de la auditoría</b></td>";
					echo "<td>";					
						if($rutaI == ("" || NULL)){
						
							echo "<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php?id=".$codigo."&tipo=INFORME' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
								echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
							echo "</a>";
						
						}
					echo "</td>";
				echo "</tr>";				
				echo "<tr>";
					echo "<td class='titleBlueLineBottom' colspan='4'></td>";
				echo "</tr>";				
				echo"<tr height='20px'><td colspan='4'></td></tr>";				
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td colspan='2' id='textIntro'>";					
						if($rutaI != ""){
							echo "<i>".$rutaI."</i> <a href='downloadAuditoria.php?file=".$rutaI."' ><img src='../../Imagenes/ICN_Archivo.png'></a>";
						}					
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10px'><td colspan='4'></td></tr>";				
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";					
					echo "<td width='645px'>";
						echo "<textarea name='informe' style='width: 645px; height:200px;'>".$informe."</textarea>";
					echo "</td>";					
					echo "<td width='15px' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='20'><td colspan='4'></td></tr>";
			echo "</table>";	
			echo"<table border='0' align='center' width='700px'>";	
				echo"<tr height='30px'><td colspan='4'></td></tr>";			
				echo "<tr>";
					echo "<td class='titulo2' colspan='3'><b>Hallazgos</b></td>";
				echo "</tr>";					
				echo "<tr>";
					echo "<td class='titleBlueLineBottom' colspan='4'></td>";
				echo "</tr>";					
				echo"<tr height='20px'><td colspan='4'></td></tr>";					
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";						
					$existeCheck = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");		
					if($existeCheck != ''){							
						echo "<td>";
							echo"¿Existen Hallazgos?";
						echo "</td>";
						echo "<td>";
						if($existeCheck == 'Si'){
							echo "<input type='radio' name='existeH' value='si' checked>SI<br>";
							echo "<input type='radio' name='existeH' value='no'>NO<br>";
						}
						if($existeCheck == 'No'){
							echo "<input type='radio' name='existeH' value='si' >SI<br>";
							echo "<input type='radio' name='existeH' value='no' checked>NO<br>";
						}
						echo "</td>";						
						echo "<td width='15px' align='right' >";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
						echo "</td>";												
					} else {						
						echo "<td>";
							echo"¿Existen Hallazgos?";
						echo "</td>";
						echo "<td>";
						echo "<input type='radio' name='existeH' value='si'>SI<br>";
						echo "<input type='radio' name='existeH' value='no'>NO<br>";						
						echo "</td>";						
						echo "<td width='15px' align='right' >";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
						echo "</td>";						
					}
				echo "</tr>";					
				echo"<tr height='20px'><td colspan='4'></td></tr>";					
			echo "</table>";				
			//FINALIZAR
			echo "<table border='0' align='center' width='700px'>";
				echo "<tr>";
					echo "<td class='titleBlueLineBottom'></td>";
				echo "</tr>";					
				echo "<tr height='20px'><td></td></tr>";					
				echo "<tr>";
					echo "<td align='right'>";
						echo "<a href='../FichaAuditoriav2.php?id=".$codigo."&end=1'>";
							echo "<img src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "</a>";
					echo "</td>";	
				echo "</tr>";
				echo "<tr height='50'px><td></td></tr>";
			echo "</table>";
		echo "</form>";					
	echo "</div>";
	// CONTENEDOR DE LA FICHA DE AUDITORIA INTERNA
	echo "<div id='wrapperFichaInterna' align='center' style='display:none'>";
		echo "<form method='post' id='formulario' action='AuditoriaActualizarv2.php?id=$codigo' onsubmit='return validarRegistroAgenda()'>";
			echo "<div id='elementosOperar'>";
				echo "<table border='0' align='center'>";
					echo "<tr>";
						echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
					echo "</tr>";					
					echo "<tr height='80px'><td></td></tr>";
					///Titulo 
					echo "<tr>";
						echo "<td align='center' id='titulo1' width='700px'>";
							echo $codigo;
						echo "</td>";
					echo "</tr>";	
					echo "<tr>";
						echo "<td align='center' id='titulo3' width='700px'>";
							echo "Plan de Auditoría";
						echo "</td>";
					echo "</tr>";				
					echo "<tr>"; 
						echo "<td align='center'>";
							echo $breadcrumb;
						echo "</td>";
					echo "</tr>";						
					echo "<tr height='50'><td></td></tr>";		
				echo "</table>";				
				echo"<table id='seccionObjetivos' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Objetivos</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='modificarObjetivosPopUp.php?codigo=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";		
					echo "<tr height='30px'> </tr>";					
					echo '<tr>';
					echo "<td align='left' width='30px'> </td>";
					echo "<td>Sirven para establecer qué es lo que se va a lograr con la auditoría. Se consideran como objetivos de esta auditoría los que están palomeados.</td>";
					echo '</tr>';
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					$INTRANETV2->Execute("set names 'utf8'");
					$u = $INTRANETV2->Execute("
						SELECT 
							xt_objetivosAuditoria
						FROM 
							SGI_AUDITORIAS_PLANES
						WHERE 
							xt_claveAuditoria = '".$codigo."'
						");
					while($t = $u->fetchRow()){
						$objetivos= $t[0];
						$objetivosActivos = explode(',',$objetivos);
					}
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Determinar el grado de conformidad del sistema de gestión integral, o de parte de él, con las disposiciones planificadas, con los criterios de auditoría y con los requisitos establecidos.</td>";
						if(in_array("1", $objetivosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='objetivos[]' value='1'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='objetivos[]' value='1'/>";
							echo "</td>";
						}
					echo '</tr>';	
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Determinar si el sistema de gestión integral se ha implementado y se mantiene de manera eficaz.</td>";
						if(in_array("2", $objetivosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='objetivos[]' value='2'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='objetivos[]' value='2'/>";
							echo "</td>";
						}
					echo '</tr>';		
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Evaluar la capacidad del sistema de gestión para asegurar el cumplimiento de los requisitos legales, reglamentarios y contractuales.</td>";
						if(in_array("3", $objetivosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='objetivos[]' value='3'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='objetivos[]' value='3'/>";
							echo "</td>";
						}
					echo '</tr>';
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Identificar áreas de mejora potencial del sistema de gestión.</td>";
						if(in_array("4", $objetivosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='objetivos[]' value='4'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='objetivos[]' value='4'/>";
							echo "</td>";
						}
					echo '</tr>';	
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Otros</td>";
						if(in_array("5", $objetivosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' id='otrosObjetivos' name='objetivos[]' value='5'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' id='otrosObjetivos' name='objetivos[]' value='5'/>";
							echo "</td>";
						}
					echo '</tr>';	
					echo '<tr id="agregaObjetivo" style="display:none">';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>";
							echo "<textarea  name='otrosObjetivos' placeholder='Favor ingrese el objetivo de la auditoría.' style='width: 550px; height:80px;'>".$otrosObjetivosPlan."</textarea>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";	
				echo '</table>';
				echo"<table id='seccionAlcance' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Alcance de la Auditoría</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";	
					echo "<tr height='30px'> </tr>";						
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo '<td>Sirve para describir la extensión y los límites de la auditoría, tales como ubicación, unidades de la organización, actividades y procesos que van a ser auditados, así como el período cubierto por la auditoría.</td>';
						echo '<td>';
					echo '</tr>';
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";			
					echo "<tr>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='645px'>";
							echo "<textarea  name='alcances' placeholder='Favor ingrese el alcance de la auditoría.' style='width: 600px; height:120px;'>".$alcanceP."</textarea><input type='hidden' name='codigo' value='".$codigo."'>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";
				echo"<table id='seccionCriterios' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";
					echo "<tr height='30px'> </tr>";								
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo '<td>Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</td>';
						echo '<td>';
					echo '</tr>';
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					$INTRANETV2->Execute("set names 'utf8'");
					$u = $INTRANETV2->Execute("
						SELECT 
							xt_criteriosAuditoria 
						FROM 
							SGI_AUDITORIAS_PLANES
						WHERE 
							xt_claveAuditoria = '".$codigo."'
						");
					while($t = $u->fetchRow()){
						$criterios= $t[0];
						$criteriosActivos = explode(',',$criterios);
					}
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>SCC</td>";
						if(in_array("SCC", $criteriosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='criterios[]' value='SCC'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='criterios[]' value='SCC'/>";
							echo "</td>";
						}
					echo '</tr>';										
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>ISO 9001:2015</td>";
						if(in_array("ISO", $criteriosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='criterios[]' value='ISO'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='criterios[]' value='ISO'/>";
							echo "</td>";
						}
					echo '</tr>';			
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>NMX-R-026-SCFI-2016</td>";
						if(in_array("NMX", $criteriosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='criterios[]' value='NMX'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='criterios[]' value='NMX'/>";
							echo "</td>";
						}
					echo '</tr>';	
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Otros</td>";
						if(in_array("OTROS", $criteriosActivos)){
							echo '<td>';
								echo "<input type='checkbox' checked='true' class='LoginInicio' name='criterios[]' value='OTROS'/>";
							echo "</td>";							
						}else{
							echo '<td>';
								echo "<input type='checkbox' class='LoginInicio' name='criterios[]' value='OTROS'/>";
							echo "</td>";
						}
					echo '</tr>';	
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo '</table>';
				echo"<table id='seccionRiesgos' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Riesgos de la Auditoría</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";
					echo "<tr height='30px'> </tr>";	
					echo "<tr>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='645px'>";
							echo "<textarea  name='riesgos' placeholder='Favor ingresar los riesgos de la auditoría.'style='width: 600px; height:120px;'>".$riesgosP."</textarea>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";
				echo"<table id='seccionRecursos' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Recursos requeridos</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";	
					echo "<tr height='30px'> </tr>";							
					echo "<tr>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='645px'>";
							$recursos = "";
							echo "<textarea  name='recursos' placeholder='Favor ingresar los recursos requeridos.'style='width: 600px; height:120px;'>".$recursosP."</textarea>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";
				echo"<table id='seccionEquipo' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Equipo auditor</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";			
					echo "<tr height='30px'> </tr>";						
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo '<td>El equipo auditor se define teniendo en cuenta la competencia necesaria para lograr los objetivos de la auditoría. Se considera parte del equipo auditor a las personas palomeadas.</td>';
						echo '<td>';
					echo '</tr>';
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					$INTRANETV2->Execute("set names 'utf8'");
					$u = $INTRANETV2->Execute("
						SELECT 
							xt_equipoAuditor 
						FROM 
							SGI_AUDITORIAS_PLANES
						WHERE 
							xt_claveAuditoria = '".$codigo."'
						");
					while($t = $u->fetchRow()){
						$miembro= $t[0];
						$miembrosActivos = explode(',',$miembro);
					}
					$INTRANETV2->Execute("set names 'utf8'");
					$u = $INTRANETV2->Execute("
							SELECT 
								xt_claveAuditor, xt_nombreAuditor 
							FROM 
								SGI_Catalogo_Auditores
							ORDER BY
								xn_posicion
						");
					while($t = $u->fetchRow()){
						$clave = $t[0];
						// CODIFICAMOS LOS DATOS DE ISO-8859-1 A UTF-8 PARA PODER RECUPERAR LOS CARACTERES ESPECIALES COMO LETRAS CON ACENTO Y LA LETRA Ñ.
						$nombre = $t[1];
						echo '<tr>';
							echo "<td align='left' width='30px'> </td>";
							echo "<td>$nombre</td>";
							if(in_array($clave, $miembrosActivos)){
								echo "<td><input type='checkbox' checked='true' class='LoginInicio' name='equipo[]' value='$clave'/></td>";
							}else{
								echo "<td><input type='checkbox' class='LoginInicio' name='equipo[]' value='$clave'/></td>";
							}						
						echo '</tr>';										
					}
					echo '<tr>';
						echo "<td align='left' width='30px'> </td>";
						echo "<td>Otro auditor</td>";
						echo '<td>';
							echo "<input type='checkbox' class='LoginInicio' id='otroAuditor' name='otroAuditor' value=''/>";
						echo "</td>";
					echo '<tr id="agregaAuditor" style="display:none">';
					echo "<td>";
						echo "<input type='text' name='nuevoAuditor' size='50' placeholder='Favor ingrese el nombre del auditor.'/>";
					echo "</td>";
					echo "<td><a href='javascript:{}' style='padding-left: 30px;'onclick=\"document.getElementById('formulario').submit();\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
					echo "</tr>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";	
				echo '</table>';
				echo"<table id='seccionLider' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Auditor líder</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";	
					echo "<tr height='30px'> </tr>";									
					echo "<tr>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='645px'>";
							echo "<textarea  name='lider' placeholder='Favor ingrese el nombre del auditor lider.' style='width: 600px; height:40px;'>".$liderP."</textarea>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";
				echo "</table>";
				echo"<table id='seccionAgenda' order='0' align='center' width='1000px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";		
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Agenda de la Auditoría</b></td>";
						echo "<td align='right'>";
							//Agregar competencia
							echo "<a href='#' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')\">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>";
					echo "</td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";				
					echo "<tr height='30px'> </tr>";
					echo '<tr width="1000px">';
						echo "<td align='left' width='30px'> </td>";
						echo '<td>La junta de apertura se realizará a las nueve de la mañana del primer día de la auditoría y la junta de cierre se realizará según instrucciones del auditor líder.</td>';
					echo '</tr>';
					echo "<tr height='20px'> </tr>";
				echo "</table>";
				echo "<tr height='10px'><td colspan='4'></td></tr>";
				echo"</table>";					
				echo '<table class="datos" width="1000px" cellspacing="0" cellpadding="0" border="1" align="center" width="100%">';
					echo "<tr>";
						echo "<td>Auditor";
						echo '</td>';
						echo "<td>Proceso a auditar";
						echo '</td>';
						echo "<td>Puesto a auditar";
						echo '</td>';
						echo "<td>Fecha";
						echo '</td>';
						echo "<td>Hora";
						echo '</td>';		
						echo "<td>";
						echo "Eliminar";
						echo '</td>';										
					echo '</tr>';
					$contador = 0;
					$INTRANETV2->Execute("set names 'utf8'");
					$conjuntoRegistroAgenda = $INTRANETV2->Execute("
							SELECT
								xt_claveAuditoria as clave,
								xt_auditor as auditor,
								xt_procesoAuditoria as proceso,
								xt_puestoAuditoria as puesto,
								xd_fechaAuditoria as fecha
							FROM 
								SGI_Auditorias_Agenda
							WHERE
								xt_claveAuditoria = '".$codigo."'
						");
					while($registroAgenda = $conjuntoRegistroAgenda->fetchRow()){
						$clave[$contador] = $registroAgenda[0];
						// CODIFICAMOS LOS DATOS DE ISO-8859-1 A UTF-8 PARA PODER RECUPERAR LOS CARACTERES ESPECIALES COMO LETRAS CON ACENTO Y LA LETRA Ñ.
						$auditor[$contador] = $registroAgenda[1];
						$proceso[$contador] = $registroAgenda[2];
						$puesto[$contador]  = $registroAgenda[3];
						$fechaRegistrada[$contador]   = $registroAgenda[4];
						$fecha[$contador] = $fechaRegistrada[$contador];
						$hora[$contador] = $fechaRegistrada[$contador];
						$fechaEliminar[$contador] = $fechaRegistrada[$contador];
						$fecha[$contador] = new DateTime($fecha[$contador]);
						$hora[$contador] = new DateTime($hora[$contador]);
						$contador++;
					}
					for ($indice=0; $indice < $contador; $indice++){
						echo "<tr>";
							echo "<td>";
								echo $auditor[$indice];
							echo "</td>";
							echo "<td>";
								echo $proceso[$indice];
							echo '</td>';							
							echo "<td>";
								echo $puesto[$indice];
							echo '</td>';
							echo "<td>";
								echo $fecha[$indice]->format('d-m-Y');
							echo '</td>';
							echo "<td>";
								echo $hora[$indice]->format('H:i:s');
							echo '</td>';		
							echo '</td>';
							echo '<td align="center">';		
								echo '<input type="checkbox" name="elimina[]" value="'.$fechaEliminar[$indice].'" />';
  							echo '</td>';
						echo "</tr>";
					}
				echo "</table>";
				echo "<br>";
				echo '<table id="seccionAgregar" class="datos" width="1000px" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo "<tr height='30px'></td></tr>";
					echo '<tr>';
						echo '<td><div align="center">Agregar un nuevo auditor a la agenda</div></td>';
					echo "</tr>";
				echo "</table>";						
				echo '<table class="datos" width="1000px" cellspacing="0" cellpadding="0" border="1" align="center" width="100%">';
					echo "<tr>";
						echo "<td>Auditor";
						echo '</td>';
						echo "<td>Proceso a auditar";
						echo '</td>';
						echo "<td>Puesto a auditar";
						echo '</td>';
						echo "<td>Fecha";
						echo '</td>';
						echo "<td>Hora";
						echo '</td>';						
					echo '</tr>';
					echo "<tr>";
						echo "<td>";
							echo "<select name='auditor'>";
								echo "<option value=''>Favor seleccionar un auditor.</option>";
								$INTRANETV2->Execute("set names 'utf8'");
								$conjuntoRegistroAuditores = $INTRANETV2->Execute("
										SELECT
											xt_claveAuditor, xt_nombreAuditor 
										FROM 
											SGI_Catalogo_Auditores
										ORDER BY
											xn_posicion
									");
								while($registroAuditor = $conjuntoRegistroAuditores->fetchRow()){
									$clave = $registroAuditor[0];
									// CODIFICAMOS LOS DATOS DE ISO-8859-1 A UTF-8 PARA PODER RECUPERAR LOS CARACTERES ESPECIALES COMO LETRAS CON ACENTO Y LA LETRA Ñ.
									$nombre = $registroAuditor[1];
								echo "<option value='$nombre'>$clave | $nombre</option>";
								}
							echo "</select>";
		 				echo "</td>";
						echo "<td>";
			 				echo "<select name='manual'>";
									echo "<option value=''>Favor seleccionar un manual.</option>";
									$INTRANETV2->Execute("set names 'utf8'");
									$conjuntoRegistrosManaual = $INTRANETV2->Execute("
											SELECT 
												xt_codigoManual, xt_nombre
											FROM 
												SGI_Catalogo_Manuales
										");
									while($registroManual = $conjuntoRegistrosManaual->fetchRow()){
										$clave = $registroManual[0];
										// CODIFICAMOS LOS DATOS DE ISO-8859-1 A UTF-8 PARA PODER RECUPERAR LOS CARACTERES ESPECIALES COMO LETRAS CON ACENTO Y LA LETRA Ñ.
										$nombre = utf8_decode($registroManual[1]);
										echo "<option value='$nombre'>$clave | $nombre</option>";
									}
							echo "</select>";
						echo "</td>";
						echo "<td><input type='text' placeholder='Favor ingrese el puesto a auditar.' name='puesto' width='20'/>";
						echo '</td>';
						echo "<td align='center'>";
							echo "<input type='text' placeholder='Favor ingresar la fecha.'name='fecha' id='datepicker' size='11'/>";
						echo '</td>';
						echo "<td align='center'>";
							echo "<input type='time' name='hora' id='time'>";
						echo '</td>';						
					echo "</tr>";
				echo "</table>";
				echo "<br>";								
				echo '<table id="seccionElaboracion" class="datos" width="600px" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo "<tr height='30px'><td colspan='4'></td></tr>";
					echo '<tr align="center">';
						echo '<td colspan = "2" align="center">';
							echo'<a id="elaboracion" style="cursor:pointer;font-weight: bold;" onClick="elaborar()"><font color="#007CBD">Elaborar Informe</font></a>';
						echo "</td>";
					echo "</tr>";	
					echo '<tr align="right" width="100%">';
						echo "<td style='height:5px; vertical-align:top; width:300px;'>";
						echo "</td>";					
						echo "<td style='height:5px; vertical-align:top; width:300px;'>";
							echo "<input type='image' style='cursor:pointer;' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>";
						echo "</td>";
					echo "</tr>";				
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";
				echo '<table id="seccionRevision" class="datos" width="600px" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo "<tr height='30px'><td colspan='4'></td></tr>";				
					echo '<tr>';
						echo '<td style="height:5px; vertical-align:top; width:300px;">Fecha de elaboración:<br><br></td>';
						echo '<td style="height:5px; vertical-align:top; width:300px;">Nombre de la persona que elabora:<br><br></td>';
					echo '</tr>';		
					echo "<tr>";
						echo "<td width = '300px'>";
							echo "<span id='fechaElabora'></span>";
						echo "</td>";
						echo "<td width = '300px'>";	
							echo "<span id='auditorElabora'></span>";
						echo "</td>";						
					echo "</tr>";		
					echo "<tr height='10px'><td colspan='4'></td></tr>";			
					echo '<tr>';
						echo '<td colspan = "2" align="center">';
							echo'<a style="cursor:pointer;font-weight: bold;" onClick="revisar()"><font color="#007CBD">Revisar Informe</font></a>';
						echo '</td>';
					echo "</tr>";	
					echo '<tr align="right" width="100%">';
						echo "<td>";
						echo "</td>";
						echo "<td>";
						echo "<input type='image' style='cursor:pointer;' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>";
						echo "</td>";
					echo "</tr>";						
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";	
				echo '<table id="seccionEnvio" class="datos" width="600px" cellspacing="0" cellpadding="0" border="0" align="center">';	
					echo "<tr height='30px'><td colspan='4'></td></tr>";				
					echo '<tr>';
						echo '<td style="height:5px; vertical-align:top; width:300px;">Fecha de revisión:<br><br></td>';
						echo '<td style="height:5px; vertical-align:top; width:300px;">Nombre de la persona que revisa:<br><br></td>';
					echo '</tr>';		
					echo "<tr>";
						echo "<td width = '300px'>";
							echo "<span id='fechaRevisa'></span>";
						echo "</td>";
						echo "<td width = '300px'>";	
							echo "<span id='auditorRevisa'></span>";
						echo "</td>";						
					echo "</tr>";		
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo '<tr align="right" width="100%">';
						echo "<td style='height:5px; vertical-align:top; width:300px;'>";
						echo "</td>";	
						echo "<td style='height:5px; vertical-align:top; width:300px;'>";
							echo "<input type='image' style='cursor:pointer;' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png'  width='90' height='29'>";
						echo "</td>";	
					echo "</tr>";						
					echo "<tr height='30px'><td colspan='4'></td></tr>";
				echo "</table>";
				/*
				echo '<div id="seccionElabora" style="display:none">';
					echo '<table class="datos" width="600px" cellspacing="0" cellpadding="0" border="0" align="center">';
						echo '<tr>';
							echo '<td style="height:5px; vertical-align:top; width:300px;">Fecha de elaboración:<br><br></td>';
							echo '<td style="height:5px; vertical-align:top; width:300px;">Nombre de la persona que elabora:<br><br></td>';
						echo '</tr>';		
						echo "<tr>";
							echo "<td width = '300px'>";
								echo "<span id='fechaElabora'></span>";
							echo "</td>";
							echo "<td width = '300px'>";	
								echo "<span id='auditorElabora'></span>";
							echo "</td>";						
						echo "</tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "</table>";
				echo '</div>';
				echo '<div id="seccionRevisa" style="display:none">';
					echo '<table class="datos" width="1000px" cellspacing="0" cellpadding="0" border="0" align="center">';
						echo '<tr>';
							echo '<td style=" height:5px; vertical-align:top; width:300px;"><div>Fecha de la revisión:<br><br></div></td>';
							echo '<td style=" height:5px; vertical-align:top; width:300px;"><div>Nombre de la persona que revisa y aprueba:<br><br></div></td>';
						echo '</tr>';		
						echo "<tr>";
							echo "<td align = 'center' width = '300px'>";
								echo "<span id='fechaRevisa'></span>";
							echo "</td>";
							echo "<td align = 'center' width = '300px'>";
								echo "<span id='auditorRevisa'></span>";
							echo "</td>";						
						echo "</tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "</table>";
				echo '</div>';
				echo '<div id="seccionElaborar">';
					echo '<table class="datos"  width="1000px" cellspacing="0" cellpadding="0" border="0" align="center">';
						echo '<tr>';
							echo '<td align="center">';
							echo'<a id="elaboracion" style="cursor:pointer;font-weight: bold;" onClick="elaborar()"><font color="#007CBD">Elaborar Informe</font></a>';
							echo'<a id="revision" style="cursor:pointer;font-weight: bold; display:none;" onClick="revisar()"><font color="#007CBD">Revisar Informe</font></a>';
							echo '</td>';
						echo "</tr>";	
					echo "</table>";
				echo '</div>';
				echo '<div id="seccionRevisar">';				
					echo '<table class="datos"  width="1000px" cellspacing="0" cellpadding="0" border="0" align="center">';				
						echo '<tr align="right" width="100%">';
							echo "<td id='modificar'>";
							echo "<input type='image' style='cursor:pointer;' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
						echo "<tr  align = 'right'>";
							echo "<td id='enviar' style='display:none'>";
								echo "<input type='image' style='cursor:pointer;' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png'  width='90' height='29'>";
							echo "</td>";	
						echo "</tr>";					
						echo "<tr height='10px'><td colspan='4'></td></tr>";
						echo "<tr height='10px'><td colspan='4'></td></tr>";
					echo "</table>";
				echo '</div>';
				*/
				//Informe de la auditoria
				echo "<table id='seccionInforme' border='0' align='center' width='700px'>";
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Informe de la auditoría</b></td>";
						echo "<td>";
							if($rutaI == ("" || NULL)){							
								echo "<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php?id=".$codigo."&tipo=INFORME' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
									echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
								echo "</a>";							
							}
						echo "</td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";	
					echo "<tr height='30px'> </tr>";							
					echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td colspan='2'>";						
							if($rutaI != ""){
								echo "<i>".$nombreArchivoInforme."</i> <a href='../downloadAuditoria.php?file=".$rutaI."' ><img src='../../Imagenes/ICN_Archivo.png'></a>";
							}						
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10px'><td colspan='4'></td></tr>";					
					echo "<tr>";
						echo "<td width='20px'></td>";
						echo "<td width='20px'></td>";						
						echo "<td width='645px'>";
						echo "</td>";						
						echo "<td width='15px' align='right'>";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr height='30'><td colspan='4'></td></tr>";
				echo "</table>";
				echo"<table id='seccionHallazgos' border='0' align='center' width='700px'>";	
					echo"<tr height='30px'><td colspan='4'></td></tr>";			
					echo "<tr>";
						echo "<td class='titulo2' colspan='3'><b>Hallazgos</b></td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td class='titleBlueLineBottom' colspan='4'></td>";
					echo "</tr>";
					echo "<tr height='30px'> </tr>";								
					echo "<tr>";
						echo "<td width='20px'></td>";
						echo "<td width='20px'></td>";						
						$existeCheck = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$codigo."'");
						if($existeCheck != ''){							
						echo "<td>";
							echo"¿Existen Hallazgos?";
						echo "</td>";
						echo "<td>";
						if($existeCheck == 'Si'){
							echo "<input type='radio' name='existeH' value='si' checked>SI<br>";
							echo "<input type='radio' name='existeH' value='no'>NO<br>";
						}
						if($existeCheck == 'No'){
							echo "<input type='radio' name='existeH' value='si' >SI<br>";
							echo "<input type='radio' name='existeH' value='no' checked>NO<br>";
						}
						echo "</td>";						
						echo "<td width='15px' align='right' >";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
						echo "</td>";												
						} else {						
						echo "<td>";
							echo"¿Existen Hallazgos?";
						echo "</td>";
						echo "<td>";
						echo "<input type='radio' name='existeH' value='si'>SI<br>";
						echo "<input type='radio' name='existeH' value='no'>NO<br>";
						echo "</td>";						
						echo "<td width='15px' align='right' >";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
						echo "</td>";											
						}
					echo "</tr>";					
					echo"<tr height='30px'><td colspan='4'></td></tr>";					
				echo "</table>";		
				//FINALIZAR
				echo "<table id='seccionFinalizar' border='0' align='center' width='700px'>";
					echo "<tr height='30px'><td colspan='4'></td></tr>";
					echo "<tr>";
						echo "<td class='titleBlueLineBottom'></td>";
					echo "</tr>";
					echo "<tr height='30px'> </tr>";					
					echo "<tr height='20px'><td></td></tr>";					
					echo "<tr>";
						echo "<td align='right'>";
							echo "<a href='../FichaAuditoriav2.php?id=".$codigo."&end=1'>";
								echo "<img src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</a>";
						echo "</td>";	
					echo "</tr>";
					echo "<tr height='30'px><td></td></tr>";
				echo "</table>";
			echo "</div>";
		echo "</form>";
	echo "</div>";
} else {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
				<title>Auditoría Proceso</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				} else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
				?> 
			</head>
			<body>
	<?php
	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center'>";		
			echo "<tr height='150px'><td></td></tr>";
			echo "<tr>";
				echo "<td>";
					echo "Error!!!";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}
	?>
	    	</body>		
	    </html>