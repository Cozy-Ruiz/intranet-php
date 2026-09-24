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

//vardump($_SESSION);

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

?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8">
				<title>Mi Cuenta</title>
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

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='controlVisualizacionDocumentos.php'><img src='Imagenes/ICN_Correctivas.png'> </a> ";
					if(count($expedientesRechazados) + count($datosRechazados) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.(count($expedientesRechazados) + count($datosRechazados)).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150'>";
					echo " <a href='ComunicacionInterna/Personal/expedientePersonal.php'><img src='Imagenes/ICN_Reporteador.png'> </a> ";
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='ComunicacionInterna/Personal/datosPersonal.php'><img src='Imagenes/ICN_Visitas.png'> </a> ";
					if(($actualizacionDatosPendiente) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.($actualizacionDatosPendiente).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='ComunicacionInterna/Personal/cartaCompromiso.php'><img src='Imagenes/ICN_FraccVulnerables.png'> </a> ";
					if(($cartaCompromisoPendiente) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.($cartaCompromisoPendiente).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='ComunicacionInterna/Personal/perfilPuesto.php'><img src='Imagenes/ICN_Cuestionarios.png'> </a> ";
					if(($perfilPuestoPendiente) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.($perfilPuestoPendiente).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='accionesPreventivasCorrectivasPersonal.php'><img src='Imagenes/ICN_Riesgos.png'> </a> ";
					if(count($PreventivasCorrectivasPendientes) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.count($PreventivasCorrectivasPendientes).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='solicitudesPersonal.php'><img src='Imagenes/ICN_Solicitudes.png'> </a> ";
					if(count($solicitudesPendientes) > 0){
						echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.count($solicitudesPendientes).'</div>';
					}
				echo "</td>";

				echo "<td align='center' width='150' style='position: relative;'>";
					echo " <a href='ComunicacionInterna/Personal/fichaPersonal.php?ID=".$_SESSION['sessionPersonalId']."'><img src='Imagenes/ICN_ControlDeLla.png' width='50' height='50'> </a> ";
					//if(count($solicitudesPendientes) > 0){
						//echo '<div style="position: absolute; top: 0; right: 15px; width: 20px; height: 20px; background-color: red; color: white; border-radius: 50%; text-align: center; font-size: 12px; line-height: 20px; padding: 0; margin: 0;">'.count($solicitudesPendientes).'</div>';
					//}
				echo "</td>";
				
			echo "</tr>";
			
			echo"<tr id='iconosTexto'>";
				
				echo"<td align='center' width='150'>";
					echo "Visualización Documentos";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Expediente Personal";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Mis datos";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Carta Compromiso";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Perfil Puesto";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Acciones Preventivas y Correctivas";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Solicitudes";
				echo"</td>";

				echo"<td align='center' width='150'>";
					echo "Resguardo";
				echo"</td>";
				
			echo"</tr>";
		echo "</table>";
	echo"</div>";
?>
		</body>
	</html>
<?php
//}
?>