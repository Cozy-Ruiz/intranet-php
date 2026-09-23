<?php

$nombrephp = 'AuditoriaActualizar.php';
require_once("../../ConexionIntranet2.php");
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
error_reporting(E_PARSE);
if(!empty($_POST['clave'])){
	$clave = $_POST['clave'];
} else if(!empty($_GET['clave'])){
	$clave = $_GET['clave'];
}

$condicion = $INTRANETV2->getOne("
		SELECT 
			xt_tipo
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

if(@$_POST["programa"] != NULL){
	$programa = $_POST["programa"];
	$INTRANETV2->Execute("
			UPDATE 
				SGI_Auditorias_Planes
			SET 
				xt_descripcion = '".$programa."' 
			WHERE 
				xt_claveAuditoria = '".$clave."'
		");
}
if(@$_POST["informe"] != NULL){	
	$informeAuditoria = $_POST["informe"];
	echo "Post: ".$informeAuditoria."<br>";
	$INTRANETV2->Execute("
			UPDATE 
				SGI_Auditorias_Informes
			SET 
				xt_descripcion = '".$informeAuditoria."' 
			WHERE 
				xt_claveAuditoria = '".$clave."'
		");
}
$personaElaboraPlan = $INTRANETV2->getOne("	
		SELECT
			xt_nombreElabora
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$fechaElaboraPlan = $INTRANETV2->getOne("	
		SELECT
			xd_fechaElabora
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");

$personaApruebaPlan = $INTRANETV2->getOne("	
		SELECT
			xt_nombreAprueba
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$fechaApruebaPlan = $INTRANETV2->getOne("	
		SELECT
			xd_fechaAprueba
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$status = $INTRANETV2->getOne("	
		SELECT
			xn_status
		FROM
			SGI_Auditorias_Planes 
		WHERE 
			xt_claveAuditoria = '$clave'
	");
if(!empty($_POST['elimina'])){
	$registrosSeleccionados = $_POST['elimina'];
	$cantidadSeleccionada = count($registrosSeleccionados);
    for($i=0; $i < $cantidadSeleccionada; $i++){
		$fecha = $registrosSeleccionados[$i];
	
		$INTRANETV2->Execute("
				DELETE FROM 
					SGI_Auditorias_Agenda
				WHERE
					(xt_claveAuditoria = '$clave')
				AND
					(xd_fechaAuditoria = '$fecha')
			");
    }
}
if(@$_POST['existeH'] ==  'si'){

	$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'Si' WHERE xt_claveAuditoria = '".$clave."'");
	
} else if(@$_POST['existeH'] ==  'no'){

	$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'No' WHERE xt_claveAuditoria = '".$clave."'");
}
$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tablero_auditorias.php' id='breadcrumbs'> Auditorías </a>";
$bandera = 0;
$objetivosP = $INTRANETV2->getOne("SELECT xt_objetivosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$alcanceP 	= $INTRANETV2->getOne("SELECT xt_alcanceAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;
$conjuntoRegistroCriterios = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCN.xt_codigoNorma, SCN.xt_nombreNorma, SAC.xt_tipo
	FROM
		SGI_Auditorias_Criterios SAC
	INNER JOIN 
		SGI_Catalogo_Normas SCN
	ON 
		SAC.xt_codigoNorma = SCN.xt_codigoNorma
	WHERE
		SAC.xt_claveAuditoria = '".$clave."'
	AND
		SAC.xt_tipo = 'P'	
	");
while($registroCriterio = $conjuntoRegistroCriterios->fetchRow()){
	$codigoNorma[$index]   = $registroCriterio[0];
	$nombreNorma[$index]   = $registroCriterio[1];
	$tipoNorma[$index]     = $registroCriterio[2];
	$index++;
}

$riesgosP 	= $INTRANETV2->getOne("SELECT xt_riesgosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$recursosP  = $INTRANETV2->getOne("SELECT xt_recursosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;
$conjuntoRegistroEquipo = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCA.xt_claveAuditor , SCA.xt_nombreAuditor
	FROM
		SGI_Auditorias_Equipos SAE
	INNER JOIN 
		SGI_Catalogo_Auditores SCA
	ON 
		SCA.xt_claveAuditor = SAE.xt_claveAuditor
	WHERE
		SAE.xt_claveAuditoria = '".$clave."'
	");
while($registroEquipo = $conjuntoRegistroEquipo->fetchRow()){
	$claveAuditor[$index]    = $registroEquipo[0];
	$nombreAuditor[$index]   = $registroEquipo[1];
	$index++;
}

$contador = 0;
$conjuntoRegistroAgenda = $INTRANETV2->Execute("
		SELECT
			xt_claveAuditoria,
			xt_auditor,
			xt_procesoAuditoria,
			xd_fechaAuditoria
		FROM 
			SGI_Auditorias_Agenda
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'P'
	");
while($registroAgenda = $conjuntoRegistroAgenda->fetchRow()){
	$clave[$contador] = $registroAgenda[0];
	$auditor[$contador] = $registroAgenda[1];
	$proceso[$contador] = $registroAgenda[2];
	$fechaRegistrada[$contador] = $registroAgenda[3];
	$fecha[$contador] = $fechaRegistrada[$contador];
	$hora[$contador] = $fechaRegistrada[$contador];
	$fechaEliminar[$contador] = $fechaRegistrada[$contador];
	$fecha[$contador] = new DateTime($fecha[$contador]);
	$hora[$contador] = new DateTime($hora[$contador]);
	$contador++;
}

$auditorLiderP 	= $INTRANETV2->getOne("SELECT xt_auditorLider FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$statusPlan		= $INTRANETV2->getOne("SELECT xn_status FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$rutaP 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$nombreArchivoPlan = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$programa	= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$objetivosI = $INTRANETV2->getOne("SELECT xt_cumplimientoObjetivos FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$contador = 0;
$conjuntoRegistroCumplimientoAgenda = $INTRANETV2->Execute("
		SELECT
			xt_claveAuditoria,
			xt_auditor,
			xt_procesoAuditoria,
			xt_puestoAuditoria,
			xt_procedimiento,
			xt_punto,
			xt_persona,
			xd_fechaAuditoria
		FROM 
			SGI_Auditorias_Agenda
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'C'
	");
while($registroCumplimientoAgenda = $conjuntoRegistroCumplimientoAgenda->fetchRow()){
	$claveCumplimiento[$contador] = $registroCumplimientoAgenda[0];
	$auditorCumplimiento[$contador] = $registroCumplimientoAgenda[1];
	$procesoCumplimiento[$contador] = $registroCumplimientoAgenda[2];
	$puestoCumplimiento[$contador] = $registroCumplimientoAgenda[3];
	$procedimientoCumplimiento[$contador] = $registroCumplimientoAgenda[4];
	$puntoCumplimiento[$contador] = $registroCumplimientoAgenda[5];
	$personaCumplimiento[$contador] = $registroCumplimientoAgenda[6];
	$fechaRegistradaCumplimiento[$contador] = $registroCumplimientoAgenda[7];
	$fechaCumplimiento[$contador] = $fechaRegistradaCumplimiento[$contador];
	$horaCumplimiento[$contador] = $fechaRegistradaCumplimiento[$contador];
	$fechaEliminarCumplimiento[$contador] = $fechaRegistradaCumplimiento[$contador];
	$fechaCumplimiento[$contador] = new DateTime($fechaCumplimiento[$contador]);
	$horaCumplimiento[$contador] = new DateTime($horaCumplimiento[$contador]);
	$contador++;
}

$comentarioAgenda = $INTRANETV2->getOne("SELECT xt_comentarioAgenda FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;
$conjuntoRegistroCumplimientoCriterios = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCN.xt_codigoNorma, SCN.xt_nombreNorma, SAC.xt_tipo
	FROM
		SGI_Auditorias_Criterios SAC
	INNER JOIN 
		SGI_Catalogo_Normas SCN
	ON 
		SAC.xt_codigoNorma = SCN.xt_codigoNorma
	WHERE
		SAC.xt_claveAuditoria = '".$clave."'
	AND
		SAC.xt_tipo = 'C'
	");
while($registroCumplimientoCriterio = $conjuntoRegistroCumplimientoCriterios->fetchRow()){
	$codigoNormaCumplimiento[$index]   = $registroCumplimientoCriterio[0];
	$nombreNormaCumplimiento[$index]   = $registroCumplimientoCriterio[1];
	$tipoNormaCumplimiento[$index]     = $registroCumplimientoCriterio[2];
	$index++;
}

$conclusion = $INTRANETV2->getOne("SELECT xt_conclusionAuditoria FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$auditorLiderInforme = $INTRANETV2->getOne("SELECT xt_auditorLider FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$comentarioPersona = $INTRANETV2->getOne("SELECT xt_comentariosPersona FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$hallazgos = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$clave."'");

$rutaI 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$informe	= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$nombreArchivoInforme 		= $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");			   
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
		<title>Ficha Auditoría</title>
		<?php
		if($estiloUsuario == 1){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
		} else if($estiloUsuario == 2){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
		}
		?>
		<script language="javascript" type="text/javascript">
	        function ilumina(celda, tipo){
	            celda1 = document.getElementById(celda);
	    
	            var codigo ="<?php echo $clave;?>";
	            var usuario = "<?php echo $usuarioId;?>";
				
				
				if(tipo == 'ValidacionTecnica1'){
					var comentario = document.getElementById('valTecnicaComentarioVerif').value;
					
					document.getElementById("contValidaT").style.display="none";
		   			document.getElementById("cargaValidaT").style.display="block";
		
					if(celda == 'valTecnicaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valTecnicaNoProcede').style.backgroundColor = 'red';
						$('#validacionTecnica').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TECNICA'}, function(data){
							
						})   
					}
			
					if(celda == 'valTecnicaNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valTecnicaProcede').style.backgroundColor  = 'red';
						$('#validacionTecnica').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TECNICA'}, function(data){
						})
					}
				
				}else if(tipo == "ValidacionNegocio"){
					
					var comentario = document.getElementById('valNegocioComentarioVerif').value;
					document.getElementById("contValidaN").style.display="none";
		   			document.getElementById("cargaValidaN").style.display="block";
					
					if(celda == 'valNegocioProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valNegocioNoProcede').style.backgroundColor  = 'red';
						$('#validacionNegocio').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'NEGOCIO'}, function(data){
						})   
					}
			
					if(celda == 'valNegocioNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valNegocioProcede').style.backgroundColor  = 'red';
						$('#validacionNegocio').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'NEGOCIO'}, function(data){
						})
					}
					
				}else if(tipo == "ValidacionFinal"){
					
					var comentario = document.getElementById('valFinalComentarioVerif').value;
					document.getElementById("contValidaF").style.display="none";
		   			document.getElementById("cargaValidaF").style.display="block";
					
					if(celda == 'valFinalProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valFinalNoProcede').style.backgroundColor  = 'red';
						$('#validacionFinal').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'FINAL'}, function(data){
						})   
					}
			
					if(celda == 'valFinalNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valFinalProcede').style.backgroundColor  = 'red';
						$('#validacionFinal').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'FINAL'}, function(data){
						})
					}
				}else if(tipo == "TransladoUsuario"){
					

					var comentario = document.getElementById('transladoUsuarioComentarioVerif').value;

					//document.getElementById("contValidaU").style.display="none";
		   			//document.getElementById("cargaValidaU").style.display="block";
					
					if(celda == 'transladoUsuarioProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('transladoUsuarioNoProcede').style.backgroundColor  = 'red';
						$('#transladoUsuario').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TRASLADO_USUARIO'}, function(data){
						})   
					}
			
					if(celda == 'transladoUsuarioNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('transladoUsuarioProcede').style.backgroundColor  = 'red';
						$('#transladoUsuarioFinal').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TRASLADO_USUARIO'}, function(data){
						})
					}
				}	
			}
	    </script>		
	</head>
	<body>
		<?php 
		if ($condicion == 'EX'){
		?>		
			<div id='wrapperFichaExterna' align='center'>
				<form method='post' id='formularioExterno' action='ficha_auditoria.php'>
					<table border='0' align='center'>
						<tr>
							<td align='left' id='breadcrumbs'>Usuario: <?php echo $usuarioId; ?></td>
						</tr>						
						<tr height='80px'><td></td></tr>
						<!-- ///Titulo  -->
						<tr>
							<td align='center' class='titulo1' width='700px'>
								<?php echo $clave; ?>
							</td>
						</tr>					
						<tr> 
							<td align='center'>
								<?php echo $breadcrumb; ?>
							</td>
						</tr>								
						<tr height='50'><td></td></tr>		
					</table>					
					<table border='0' align='center' width='700px'>	
						<tr height='50px'><td colspan='4'></td></tr>
						<tr>
							<td colspan='3' class='titulo2'><b>Plan de auditoría</b></td>
							<td>
								<?php 
								if (empty($rutaP)){
								?>												
									<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
										<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
									</a>
								<?php 
								}
								?>									
							</td>
						</tr>					
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>				
						<?php 
						if (!empty($rutaP)){
						?>
							<tr height='10px'><td colspan='4'></td></tr>			
							<tr>
								<td></td>
								<td></td>
								<td colspan='2' id='textIntro'>						
										<i></i> <a href='../downloadAuditoria.php?'><img src='../../Imagenes/ICN_Archivo.png'></a>
								</td>
							</tr>
						<?php 
						}
						?>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr>
							<td width='20px'></td>
							<td width='20px'></td>
							<td width='645px'>
								<textarea  name='programa' style='width: 645px; height:200px;'><?php echo $programa; ?></textarea><input type='hidden' name='codigo' value=''>
							</td>
							<td width='15px' align='right'>
								<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>
							</td>
						</tr>		
						<tr height='20px'><td colspan='4'></td></tr>		
					</table>
					<!-- //Informe de la auditoria -->
					<table border='0' align='center' width='700px'>
						<tr>
							<td class='titulo2' colspan='3'><b>Informe de la auditoría</b></td>
							<td>	
								<?php 
								if (empty($rutaI)){
								?>										
									<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
										<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
									</a>
								<?php 
								}
								?>									
							</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>	
						<?php 
						if (!empty($rutaI)){
						?>										
						<tr height='20px'><td colspan='4'></td></tr>				
						<tr>
							<td></td>
							<td></td>
							<td colspan='2' id='textIntro'>					
									<i></i> <a href='downloadAuditoria.php' ><img src='../../Imagenes/ICN_Archivo.png'></a>
							</td>
						</tr>
						<?php 
						}
						?>						
						<tr height='10px'><td colspan='4'></td></tr>				
						<tr>
							<td width='20px'></td>
							<td width='20px'></td>					
							<td width='645px'>
								<textarea name='informe' style='width: 645px; height:200px;'><?php echo $informe; ?></textarea>
							</td>					
							<td width='15px' align='right'>
								<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>
							</td>
						</tr>
						<tr height='20'><td colspan='4'></td></tr>
					</table>		
					<?php
					$contadorHallazgos = 0;
					$contadorTerminadas = 0;
					$d = $INTRANETV2->Execute("SELECT xt_claveHallazgo, xt_titulo, xd_fecha FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
					while($registroHallazgos = $d->fetchRow()) {
						$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
						$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
						$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
						$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
						while($registroTratamientos = $c->fetchRow()) {
							$claveTratamiento = $registroTratamientos[0];
							$semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC");
						}
						if($semaforoTerminada == 'TERMINADA'){
	                        $contadorTerminadas++;
	                    }
						$contadorHallazgos++;
					}
					?>
					<table border='0' align='center' width='900px'>	
						<tr height='30px'><td colspan='4'></td></tr>						
						<tr>
							<td align='left' id='titulo2'><b>Hallazgos</b></td>
							
							<td align='right'>
								<a href='modificarHallazgosInformePopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
								</a>
							</td>	
						</tr>
						
						<tr>
							<td id='titleBlueLineBottom' colspan='2'></td>
						</tr>
						
						<tr height='30'><td colspan='2'></td></tr>
					</table>
				
					<table border='0' align='center' width='900px'>
						<tr id='iconosTexto2'>
							<td align='center' width='120px'>Código</td>
							<td align='left' width='500px'>Titulo</td>
							<td align='center' width='120px'>Correctiva</td>
							<td align='center' width='80px'>Estatus</td>
							<td align='center' width='80px'>Fecha</td>
							<td align='center' width='20px'></td>
						</tr>
						
						<tr height='10px'><td colspan='4'></td></tr>
						<?php
						for($indice=0;$indice<count($claveHallazgo);$indice++){		
							echo "	
							<tr>
								<td align='center' id='fileItem' width='120px'>
									<a href='fichaHallazgo.php?clave=$claveHallazgo' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
								<td align='left' id='fileItem' width='500px'><a href='fichaHallazgo.php?clave=$claveHallazgo' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
								<td align='center' id='fileItem' width='120px'><a href='./Intranetv2/fichaCorrectivav2.php?id='$claveTratamiento' id='fileItem' style='text-decoration:none;'>$claveTratamiento</td>
								<td align='center' id='fileItem' width='80px'>$semaforoTerminada</td>
								<td align='center' id='fileItem' width='80px'>$fechaHallazgo[$indice]</td>
								<td align='right' width='20px'>
										<a href='downloadAuditoria.php'><img src='../../Imagenes/ICN_Archivo.png'></a>
								</td>
							</tr>";
						}
						?>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<?php
					if($contadorHallazgos==$contadorTerminadas){
					?>
					<div id='seccionTerminar'>
						<table width='700px'>
							<tr height='30px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Terminar auditoría</td>	
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>

							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Terminar</font></td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>

										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'></textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='30px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>
					<?php
					}
					?>								
					<!-- //FINALIZAR -->
				</form>					
			</div>
		<?php
		} else {
		?>		
			<div id='wrapperFichaInterna' align='center'>
				<table border='0' align='center'>
					<tr>
						<td align='left' id='breadcrumbs'>Usuario: <?php echo $usuarioId; ?></td>
					</tr>						
					<tr height='80px'><td></td></tr>
					<!-- ///Titulo  -->
					<tr>
						<td align='center' class='titulo1' width='700px'>
							<?php echo $clave; ?>
						</td>
					</tr>					
					<tr>
						<td align='center' id='titulo3' width='700px'>
							Plan de Auditoría
						</td>
					</tr>				
					<tr> 
						<td align='center'>
							<?php echo $breadcrumb; ?>
						</td>
					</tr>								
					<tr height='50'><td></td></tr>		
				</table>				
				<table id='seccionObjetivos' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Objetivos</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarObjetivosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>		
					<tr height='30px'> </tr>					
					<tr>
					<td align='left' width='30px'> </td>
					<td><i style="color:#636262;">Sirven para establecer qué es lo que se va a lograr con la auditoría. Se consideran como objetivos de esta auditoría los que están palomeados.</i></td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<tr>
						<td width='30px'></td>
						<td><?php echo $objetivosP; ?>
						</td>
					</tr>							
					<tr height='30px'><td colspan='4'></td></tr>	
				</table>
				<table id='seccionAlcance' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Alcance de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarAlcancePopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>	
					<tr height='30px'> </tr>						
					<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">Sirve para describir la extensión y los límites de la auditoría, tales como ubicación, unidades de la organización, actividades y procesos que van a ser auditados, así como el período cubierto por la auditoría.</i></td>
						<td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<tr>
						<td width='30px'></td>
						<td><?php echo $alcanceP; ?>
						</td>
					</tr>									
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionCriterios' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarCriteriosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>
					<tr height='30px'> </tr>								
					<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</i></td>
						<td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<?php
					for($i=0;$i<count($codigoNorma);$i++){
						echo "<tr>";
						echo "<td width='30px'></td>";
						echo "<td>$nombreNorma[$i]</td>";
						echo "</tr>";
					}
					?>	
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionRiesgos' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Riesgos de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarRiesgosAuditoriaPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>
					<tr height='30px'><td colspan='4'></td></tr>
					<tr>
						<td width='30px'></td>
						<td><?php echo $riesgosP; ?>
						</td>
					</tr>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionRecursos' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Recursos requeridos</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarRecursosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>	
					<tr height='30px'> </tr>
					<tr>
						<td width='30px'></td>
						<td><?php echo $recursosP; ?>
						</td>
					</tr>															
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionEquipo' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Equipo auditor</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarEquipoPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>			
					<tr height='30px'> </tr>						
					<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">El equipo auditor se define teniendo en cuenta la competencia necesaria para lograr los objetivos de la auditoría. Se considera parte del equipo auditor a las personas palomeadas.</i></td>
						<td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<?php
					for($i=0;$i<count($claveAuditor);$i++){
						echo "<tr>";
						echo "<td width='30px'></td>";
						echo "<td>$claveAuditor[$i] | $nombreAuditor[$i]</td>";
						echo "</tr>";
					}
					?>								
					<tr height='30px'><td colspan='4'></td></tr>	
				</table>
				<table id='seccionLider' border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Auditor líder</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarLiderPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>	
					<tr height='30px'> </tr>
					<tr>
						<td width='30px'></td>
						<td><?php echo $auditorLiderP; ?>
						</td>
					</tr>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionAgenda' order='0' align='center' width='800px'>	
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Agenda de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarAgendaPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=1100,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>				
					<tr height='30px'> </tr>
					<tr width="800px">
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">La junta de apertura se realizará a las nueve de la mañana del primer día de la auditoría y la junta de cierre se realizará según instrucciones del auditor líder.</i></td>
					</tr>
					<tr height='20px'> </tr>
				</table>
				<?php
				if(!empty($auditor[0])){ 
				?>			
				<table class="datos" width="800px" cellspacing="0" cellpadding="0" border="1" align="center" width="100%" >
					<tr>
						<td>Auditor
						</td>
						<td>Proceso a auditar
						</td>
						<td>Fecha
						</td>
						<td>Hora
						</td>
						<td>Modificar
						</td>
						<td>Eliminar
						</td>							
					</tr>
					<?php
						for ($indice=0; $indice < count($auditor); $indice++){
							echo "<tr>";
								echo "<td>";
									echo $auditor[$indice];
								echo "</td>";
								echo "<td>";
									echo $proceso[$indice];
								echo '</td>';							
								echo "<td>";
									echo $fecha[$indice]->format('d-m-Y');
								echo '</td>';
								echo "<td>";
									echo $hora[$indice]->format('H:i:s');
								echo '</td>';		
								echo '<td align="center">';		
									echo '<input type="checkbox" name="modificar[]" value="" />';
	  							echo '</td>';										
								echo '<td align="center">';		
									echo '<input type="checkbox" name="elimina[]" value="'.$fechaEliminar[$indice].'" />';
	  							echo '</td>';
							echo "</tr>";
						}
					?>	
				</table>
				<?php
				}
				if(empty($statusPlan)||$statusPlan==''){
				?>
					<div id='seccionElaborar'>
						<table width='700px'>
							<tr height='60px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Elaborarar plan de auditoría</td>	
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../../../INTRANET_GEA/Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Procede</font></td>
									</tr>
								
									<tr height="10px"></tr>
								
									<tr height="25px" align="center">
										<td id="valTecnicaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valTecnicaNoProcede', 'ValidacionTecnica')"><font color="white">No procede</font></td>
									</tr>
									<tr height='10px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>		
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'></textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='50px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>
				<?php
				} else if ($statusPlan=='1') {
				?>
					<div id='seccionRevisar'>
						<table width='700px'>
							<tr height='60px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Revisar plan de auditoría</td>	
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../../../INTRANET_GEA/Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Procede</font></td>
									</tr>
								
									<tr height="10px"></tr>
								
									<tr height="25px" align="center">
										<td id="valTecnicaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valTecnicaNoProcede', 'ValidacionTecnica')"><font color="white">No procede</font></td>
									</tr>
									<tr height='10px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>		
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'></textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='50px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>
				<?php
				} else if ($statusPlan=='2') {
				?>
					<div id='seccionRevisar'>
						<table width='700px'>
							<tr height='60px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Aprobar plan de auditoría</td>	
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../../../INTRANET_GEA/Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Procede</font></td>
									</tr>
								
									<tr height="10px"></tr>
								
									<tr height="25px" align="center">
										<td id="valTecnicaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valTecnicaNoProcede', 'ValidacionTecnica')"><font color="white">No procede</font></td>
									</tr>
									<tr height='10px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>		
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'></textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='50px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>
				<?php
				}
				?>				
				<table id='seccionAlcanceInforme' order='0' align='center' width='700px'>
					<tr align="center">
						<td colspan='3' class='titulo3'><b>Informe de auditoría</b></td>
					</tr>
					<tr height='30px'><td colspan='4'></td></tr>	
					<tr height='30px'><td colspan='4'></td></tr>							
					<tr>
						<td class='titulo2' colspan='3'><b>Cumplimiento de Objetivos, alcance, auditor líder y equipo de auditores</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarCumplimientoObjetivosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
						</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>				
					<tr height='30px'><td colspan='4'></td></tr>
					<tr>
						<td style='width: 30px;'>
						</td>
						<td><?php echo $objetivosI; ?>
						</td>
					</tr>
					<tr height='30px'><td colspan='4'></td></tr>						
				</table>
				<table id='seccionCumplimiento' order='0' align='center' width='1000px'>	
					<tr height='30px'><td colspan='4'></td></tr>
					<tr>
						<td class='titulo2' colspan='3'><b>Cumplimiento de la agenda de la auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarCumplimientoAgendaPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=1500,height=450,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
						</td>
					</tr>
					<tr>
						<td class='titleBlueLineBottom' colspan='7'></td>
					</tr>							
					<tr height='30px'><td colspan='7'></td></tr>
				</table>
				<?php
				if(!empty($auditorCumplimiento[0])){ 
				?>									
				<table class="datos" width="1000px" cellspacing="0" cellpadding="0" border="1" align="center">
					<tr>
						<td style='width: 130px;'>Auditor
						</td>
						<td style='width: 130px;'>Proceso a auditar
						</td>
						<td style='width: 100px;'>Punto de la norma
						</td>
						<td style='width: 130px;'>Proceso/Procedimiento/Documento
						</td>
						<td style='width: 130px;'>Persona evaluada
						</td>
						<td style='width: 80px;'>Fecha 
						</td>
						<td style='width: 80px;'>Hora
						</td>
						<td>Modificar
						</td>
						<td>Eliminar
						</td>
					</tr>
					<?php
						for ($indice=0; $indice < count($auditorCumplimiento); $indice++){
							echo "<tr>";
								echo "<td>";
									echo $auditorCumplimiento[$indice];
								echo "</td>";
								echo "<td>";
									echo $procesoCumplimiento[$indice];
								echo '</td>';
								echo "<td>";
									echo $puntoCumplimiento[$indice];
								echo '</td>';
								echo "<td>";
									echo $procedimientoCumplimiento[$indice];
								echo '</td>';									
								echo "<td>";
									echo $personaCumplimiento[$indice];
								echo '</td>';
								echo "<td>";
									echo $fechaCumplimiento[$indice]->format('d-m-Y');
								echo '</td>';
								echo "<td>";
									echo $horaCumplimiento[$indice]->format('H:i:s');
								echo '</td>';		
								echo '</td>';
								echo '<td align="center">';		
									echo '<input type="checkbox" name="modificarCumplimiento[]" value="" />';
	  							echo '</td>';										
								echo '<td align="center">';		
									echo '<input type="checkbox" name="eliminaCumplimiento[]" value="'.$fechaEliminarCumplimiento[$indice].'" />';
	  							echo '</td>';
							echo "</tr>";
						}
					?>								
				</table>
				<?php
				}
				?>
				<table>
					<tr height='60px'><td colspan='4'></td></tr>							
					<tr>
						<td class='titulo2' colspan='3'><b>Comentarios de la agenda de la auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarComentariosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
						</td>
					</tr>
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>				
					<tr height='30px'><td colspan='4'></td></tr>
					<tr>
						<td style='width: 30px;'>
						</td>
						<td><?php echo $comentarioAgenda; ?>
						</td>
					</tr>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>					
				<table id='seccionCriteriosInforme' border='0' align='center' width='700px'>
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarCriteriosInformePopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>
					<tr height='30px'> </tr>								
					<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</i></td>
						<td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<?php
					for($i=0;$i<count($codigoNormaCumplimiento);$i++){
						echo "<tr>";
						echo "<td width='30px'></td>";
						echo "<td>$nombreNormaCumplimiento[$i]</td>";
						echo "</tr>";
					}
					?>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<table id='seccionConclusiones' border='0' align='center' width='700px'>
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Conclusiones de la Auditoría</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarConclusionesPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>
					<tr height='30px'> </tr>								
					<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">Valoración del equipo auditor respecto a la conformidad del sistema de gestión de calidad con los requisitos establecidos en los criterios, así como valoración de que si éste se ha implementado y se mantiene de manera eficaz.</i></td>
						<td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<tr>
						<td style='width: 30px;'>
						</td>
						<td><?php echo $conclusion; ?>
						</td>
					</tr>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<div id="seccionRevisarInforme">
					<table class="datos"  width="700px" cellspacing="0" cellpadding="0" border="0" align="center">
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Auditor que aprueba</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='modificarAuditorApruebaPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>	
						<tr>
							<td style='width: 30px;'>
							</td>
							<td><?php echo $auditorLiderInforme; ?>
							</td>
						</tr>
						<tr height='20px'> </tr>
					</table>
				</div>
				<table id='seccionComentarios' border='0' align='center' width='700px'>
					<tr height='30px'><td colspan='4'></td></tr>		
					<tr>
						<td class='titulo2' colspan='3'><b>Comentarios de la persona auditada</b></td>
						<td align='right'>
							<!-- //Agregar competencia -->
							<a href='modificarComentariosPersonaPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
							<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
							</a>
					</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>
					<tr height='30px'><td colspan='4'></td></tr>
					<tr>
						<td style='width: 30px;'>
						</td>
						<td><?php echo $comentarioPersona; ?>
						</td>
					</tr>								
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<?php
				$contadorHallazgos = 0;
				$contadorTerminadas = 0;
				$d = $INTRANETV2->Execute("SELECT xt_claveHallazgo, xt_titulo, xd_fecha FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
				while($registroHallazgos = $d->fetchRow()) {
					$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
					$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
					$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
					$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
					while($registroTratamientos = $c->fetchRow()) {
						$claveTratamiento = $registroTratamientos[0];
						$semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC");
					}
					if($semaforoTerminada == 'TERMINADA'){
                        $contadorTerminadas++;
                    }
					$contadorHallazgos++;
				}
				?>
				<table border='0' align='center' width='900px'>	
					<tr height='30px'><td colspan='4'></td></tr>						
					<tr>
						<td align='left' id='titulo2'><b>Hallazgos</b></td>
						
						<td align='right'>
							<a href='modificarHallazgosInformePopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
							</a>
						</td>	
					</tr>
					
					<tr>
						<td id='titleBlueLineBottom' colspan='2'></td>
					</tr>
					
					<tr height='30'><td colspan='2'></td></tr>
				</table>
			
				<table border='0' align='center' width='900px'>
					<tr id='iconosTexto2'>
						<td align='center' width='120px'>Código</td>
						<td align='left' width='500px'>Titulo</td>
						<td align='center' width='120px'>Correctiva</td>
						<td align='center' width='80px'>Estatus</td>
						<td align='center' width='80px'>Fecha</td>
						<td align='center' width='20px'></td>
					</tr>
					
					<tr height='10px'><td colspan='4'></td></tr>
					<?php
					for($indice=0;$indice<count($claveHallazgo);$indice++){		
						echo "	
						<tr>
							<td align='center' id='fileItem' width='120px'>
								<a href='fichaHallazgo.php?clave=$claveHallazgo' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
							<td align='left' id='fileItem' width='500px'><a href='fichaHallazgo.php?clave=$claveHallazgo' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
							<td align='center' id='fileItem' width='120px'><a href='./Intranetv2/fichaCorrectivav2.php?id='$claveTratamiento' id='fileItem' style='text-decoration:none;'>$claveTratamiento</td>
							<td align='center' id='fileItem' width='80px'>$semaforoTerminada</td>
							<td align='center' id='fileItem' width='80px'>$fechaHallazgo[$indice]</td>
							<td align='right' width='20px'>
									<a href='downloadAuditoria.php'><img src='../../Imagenes/ICN_Archivo.png'></a>
							</td>
						</tr>";
					}
					?>
					<tr height='30px'><td colspan='4'></td></tr>
				</table>
				<?php
				if($contadorHallazgos==$contadorTerminadas){
				?>
				<div id='seccionTerminar'>
					<table width='700px'>
						<tr height='30px'><td colspan='4'></td></tr>
						
						<tr>
							<td align='left' id='titulo2'>Terminar auditoría</td>	
						</tr>
						
						<tr>
							<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
							</td>
						</tr>

						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<!-- //div donde muestr gif de cargando -->
					<div id='cargaValidaT' style='display:none' align='center'>
		    			<img src='../../Imagenes/img_load.gif' />
		  			</div>
					
					<div id='contValidaT' style='display:block'>
					
						<div id='validacionTecnica'>
							<table align='center' width='20%'>
								<tr height='20px'></tr>
								<tr height="25px" align="center">
									<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Terminar</font></td>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>
							</table>
							
							<div id='valTecnicaComentario'>
								<table  border='0' align='center' width='500px'>
									<tr>
										<td style='color:#007CBD;'>Comentarios</td>
									</tr>
						
									<tr>
										<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>

									<tr height='30px'><td colspan='4'></td></tr>										
									<tr align='center'>
										<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'></textarea></td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>
								</table>
							</div>
						</div>
					</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
				</div>
				<?php
				}
				?>
				<table border='0' align='center' width='700px'>
					<tr>
						<td id='titleBlueLineBottom'></td>
					</tr>
					
					<tr height='40'>
						<td valign='bottom' align='right'>
							<a href='ficha_auditoria.php?id=$id'><input type='image' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>
						</td>
					</tr>
					
					<tr height='50px'><td></td></tr>
				</table>											
			</div>
		<?php
		}
		?>		
		<br><br><br>
		<table border='0' align='center' name='Cuerpo' width='100%'>
			<tr>
				<td id='titleBlueLineBottom' colspan='3' width='100%'></td>
			</tr>
			<tr>
				<td id='nota_al_pie'>
					<center>Created by: Grupo Escalante Agencias Aduanales.</center>
				</td>
			</tr>
		</table>
		<br><br>		
	</body>
</html>