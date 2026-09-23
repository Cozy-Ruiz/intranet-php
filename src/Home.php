<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='Home.php';
require_once("ConexionDBT.php");
require_once("compruebaUsuario.php");

//var_dump($_SESSION);

$fechaInicioVisualizadorDocumentos = '2025-01-13';

$documentosNuevos = $INTRANETV2->getArray("
	SELECT
		md.xt_codigoDocumento,
		md.xt_nombre,
		md.xd_fechaCreacion as xd_fecha
	FROM
		sgi_manuales_documentos md
	WHERE
		md.xd_fechaCreacion > '".$fechaInicioVisualizadorDocumentos."'
		AND md.xt_codigoDocumento NOT IN (SELECT ccd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos ccd WHERE ccd.xt_codigoDocumento	= md.xt_codigoDocumento)
		AND md.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$_SESSION["sesionUsuario"]."')
");
	
$documentosActualizados = $INTRANETV2->getArray("
	SELECT
	ccd.xt_codigoDocumento,
	md.xt_nombre,
	ccd.xn_version,
	ccd.xd_fechaCambio as xd_fecha
	FROM
	sgi_control_de_cambios_documentos ccd,
	sgi_manuales_documentos md
	WHERE
	ccd.xn_version > 0 
	AND ccd.xd_fechaCambio > '".$fechaInicioVisualizadorDocumentos."'
	AND md.xt_codigoDocumento = ccd.xt_codigoDocumento
	AND ccd.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$_SESSION["sesionUsuario"]."' AND cvd.xt_codigoDocumento = ccd.xt_codigoDocumento AND cvd.xn_version = ccd.xn_version)
");

$expedientesRechazados = $INTRANET->getArray("SELECT * FROM sgi_expediente_personal WHERE xt_usuario_empleado = '".$_SESSION["sesionUsuario"]."' AND YEAR(xd_fecha) = YEAR(NOW()) AND xt_estatus = 'Rechazado' ");
$datosRechazados = $INTRANET->getArray("SELECT * FROM sgi_empleados WHERE kf_usuario = '".$_SESSION["sesionUsuario"]."' AND xt_estatusDatosPersonales = 'Rechazado' ");
$actualizacionDatosPendiente = $INTRANET->getOne("SELECT IF(YEAR(xd_fechaActualizaciondatos) = YEAR(NOW()), 0, 1) FROM intranetgea.sgi_empleados WHERE kf_usuario = '".$_SESSION["sesionUsuario"]."' ");
$cartaCompromisoPendiente = $INTRANET->getOne("SELECT IF(YEAR(xd_aceptacioncartaCompromiso) = YEAR(NOW()), 0, 1) FROM intranetgea.sgi_empleados WHERE kf_usuario = '".$_SESSION["sesionUsuario"]."' ");
$perfilPuestoPendiente = $INTRANET->getOne("SELECT IF(YEAR(xd_aceptacionPerfilPuesto) = YEAR(NOW()), 0, 1) FROM intranetgea.sgi_empleados WHERE kf_usuario = '".$_SESSION["sesionUsuario"]."' ");
$PreventivasCorrectivasPendientes = $INTRANETV2->getArray("
	SELECT
		apc.xt_claveAccion,
		apc.xd_fecha,
		apc.xt_titulo,
		apce.xt_titulo xt_etapa
	FROM
		sgi_acciones_preventivas_correctivas apc,
		sgi_acciones_preventivas_correctivas_etapas apce 
	WHERE
		apc.xt_pdr = '".$_SESSION["sesionUsuario"]."' 
		AND apce.xt_codigoAccion = apc.xt_claveAccion
		AND apce.xd_fechaCreacion = (SELECT MAX(apce2.xd_fechaCreacion) FROM sgi_acciones_preventivas_correctivas_etapas apce2 WHERE apce2.xt_codigoAccion = apc.xt_claveAccion)
		AND apce.xt_titulo != 'EVALUACION'
		ORDER BY apc.xd_fecha desc
");

$solicitudesPendientes = $INTRANETV2->getArray("
	SELECT
		qs.xt_quejaSolicitud,
		qs.xd_fecha,
		qs.xt_titulo,
		qse.xt_estatus
	FROM
		sgi_quejas_solicitudesv2 qs,
		sgi_quejas_solicitudes_estatusv2 qse 
	WHERE
		qs.xt_pdr = '".$_SESSION["sesionUsuario"]."'
		AND qs.xt_tipo not in ('Q') 
		AND qse.xt_quejaSolicitud = qs.xt_quejaSolicitud
		AND qse.xn_numero = (SELECT MAX(qse2.xn_numero) FROM sgi_quejas_solicitudes_estatusv2 qse2 WHERE qse2.xt_quejaSolicitud = qs.xt_quejaSolicitud)
		AND qse.xt_estatus NOT IN ('TERMINADA', 'RECHAZADA')
		ORDER BY qs.xd_fecha desc
");

if(count($documentosNuevos)>0 || count($documentosActualizados)>0/* || count($expedientesRechazados)>0*/ ){
	require_once("controlVisualizacionDocumentos.php");
}else{
	


?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8">
				<title>Home Page</title>
				<?php
					if($estiloUsuario == 1){
            			echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage2.css'/>";
					}
				?>
				<link rel="shortcut icon" type="image/x-icon" href="Imagenes/ICN_PestanaWebGE.png">
                
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
	$breadcrumb="<a href='Home.php' id='breadcrumbs'>Home</a>";
	
	echo"<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		////CERRAR SESION
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
				
				$fecha 	= $INTRANET->getOne("SELECT MAX(xd_fechaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '$usuarioId'  ");

				$hora 	= $INTRANET->getOne("SELECT xt_horaEntrada FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '$usuarioId' AND  xd_fechaEntrada = '$fecha' ");
				
				echo "<td align='right'><a href='cerrarSesion.php' id='breadcrumbs'>Cerrar Sesión</a></td>";
			echo "</tr>";
			
			echo"<tr>";
			echo"</tr>";
			
			echo"<tr height='5px'></tr>";
			
			echo"<tr height='5px'><td align='left' id='breadcrumbs'>Fecha: ".$fecha." ".$hora."</td></tr>";
			echo"<tr height='5px'><td align='left' id='breadcrumbs'>Versión: 3.0</td></tr>";
			
			echo"<tr height='10px'></tr>";
			
			echo "<tr >";
				echo "<td align='center' id='titulo1' colspan='2'>";
					echo "<font>GRUPO ESCALANTE</font>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo"<tr>";
				echo"<td align='center' id='titulo1' colspan='2'>";
					echo "<font>Intranet</font>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
			
			echo "<tr height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<td align='center' valign='top'>";
						echo "<img src='Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
						echo "<img src='Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
					echo "</td>";
					
					echo "<td valign='middle'>";
						echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
					echo "</td>";
				echo "</table>";
			echo "</tr>";
			
		echo"</tr>";
	echo "</table>"; 
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("navegacion_banana.php");
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

	
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo "<tr >";
				/*
				echo "<td align='center' width='150' >";
					echo "<img src='Imagenes/ICN_Riesgos.png'> ";
				echo "</td>";
				*/
				echo "<td align='center' width='150' >";
					echo "<a href='ComunicacionInterna/comunicacionInterna.php'><img src='Imagenes/ICN_ComInterna.png'></a> ";
				echo "</td>";
				
				echo "<td align='center' width='150'>";
					echo "<a href='SistemaGestionIntegral/homeSGI.php'> <img src='Imagenes/ICN_Certif.png'> </a> ";
				echo "</td>";
				
				echo "<td align='center' width='150'>";
					echo "<a href='Aplicaciones/aplicaciones.php'> <img src='Imagenes/ICN_Modulos.png'> </a> ";
				echo "</td>";
				
				echo "<td align='center' width='150'>";
					echo " <a href='Registros/Registros.php'><img src='Imagenes/ICN_Registros.png'> </a> ";
				echo "</td>";
				
				echo "<td align='center' width='150'>";
					echo " <a href='Configuraciones/configuraciones.php'><img src='Imagenes/ICN_Settings.png'> </a> ";
				echo "</td>";

				echo "<td align='center' width='150'>";
					echo " <a href='SistemaGestionIntegral/busquedaManuales.php'><img src='Imagenes/ICN_Busqueda.png'> </a> ";
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='miCuenta.php'>";
						echo "<img src='Imagenes/ICN_Reuniones.png'>";
						if( count($expedientesRechazados) + count($datosRechazados) + count($PreventivasCorrectivasPendientes) + count($solicitudesPendientes) + $actualizacionDatosPendiente + $cartaCompromisoPendiente + $perfilPuestoPendiente > 0 ){
							echo '
								<div style="position: absolute; top: 0; right: 0; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.(count($expedientesRechazados) + count($datosRechazados) + count($PreventivasCorrectivasPendientes) + count($solicitudesPendientes) + $actualizacionDatosPendiente + $cartaCompromisoPendiente + $perfilPuestoPendiente).'</div>';
						}
					echo "</a>";
				echo "</td>";

				if($usuarioId == "Francisco_Perez" || $usuarioId == "Jesus_PerezS" || $usuarioId == "Norma_Tapia" || $usuarioId == "Barbara_Cortes" || $usuarioId == "Alejandra_Garcia" || $usuarioId == "cozy" || $usuarioId == "Elena_Hernandez" || $usuarioId == "sdelap" || $usuarioId == "Elionay_Aldana" || $usuarioId == "Pedro_Moyotl" || $usuarioId == "Ana_Ortiz" || $usuarioId == "Byron_Lopez" || $usuarioId == "Cindy_Fuentes" || $usuarioId == "Daniel_Guadarrama" || $usuarioId == "Carlos_Jimenez"|| $usuarioId == "Mariana_Escalante" || $usuarioId == "Adlemy_Tah"|| $usuarioId == "Denisse_Valladares" || $usuarioId == "Miguel_Patiño" || $usuarioId == "Barbara_Cortes"){
				//if($usuarioId == "cozy" || $usuarioId == "Elena_Hernandez" || $usuarioId == "sdelap" || $usuarioId == "Pedro_Moyotl"){

					echo "<td align='center' width='150'>";
						echo " <a href='ComunicacionInterna/Personal/revisionRH.php'><img src='Imagenes/ICN_Auditorias.png'></a> ";
					echo "</td>";
					
				}

			echo "</tr>";
			
			echo"<tr id='iconosTexto'>";
				/*
				echo"<td align='center' width='150' >";
					echo "Riesgos";
				echo"</td>";
				*/
				echo"<td align='center' width='150' >";
					echo "Comunicación interna";
				echo"</td >";
				
				echo"<td align='center' width='150'>";
					echo "Gestión Integral";
				echo"</td>";
				
				echo"<td align='center' width='150'>";
					echo "Aplicaciones";
				echo"</td>";
				echo"<td align='center' width='150'>";
					echo "Registros";
				echo"</td>";
				echo"<td align='center' width='150'>";
					echo "Configuraciones";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Búsqueda";
				echo"</td>";
		
				echo"<td align='center' width='150'>";
					echo "Mi cuenta";
				echo"</td>";

				if($usuarioId == "Francisco_Perez" || $usuarioId == "Jesus_PerezS" || $usuarioId == "Norma_Tapia" || $usuarioId == "Barbara_Cortes" || $usuarioId == "Alejandra_Garcia" || $usuarioId == "cozy" || $usuarioId == "Elena_Hernandez" || $usuarioId == "sdelap" || $usuarioId == "Elionay_Aldana" || $usuarioId == "Pedro_Moyotl" || $usuarioId == "Ana_Ortiz" || $usuarioId == "Byron_Lopez" || $usuarioId == "Cindy_Fuentes" || $usuarioId == "Daniel_Guadarrama" || $usuarioId == "Carlos_Jimenez"|| $usuarioId == "Mariana_Escalante" || $usuarioId == "Adlemy_Tah"|| $usuarioId == "Denisse_Valladares" || $usuarioId == "Miguel_Patiño" || $usuarioId == "Barbara_Cortes"){
					echo"<td align='center' width='150'>";
                        echo "Recursos Humanos";
                    echo"</td>";
					
                }
				
			echo"</tr>";
		echo "</table>";
	echo"</div>";
?>
		</body>
	</html>
<?php
}
?>