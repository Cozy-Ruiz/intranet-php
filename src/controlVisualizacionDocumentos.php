<?php error_reporting(0); ?>
<?php
/*
 *@author Cozy Ruiz
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='Home.php';
require_once("ConexionDBT.php");
require_once("compruebaUsuario.php");


?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8">
				<title>Control Visualización Documentos</title>
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

					function abrirVentana(url) {
						// Abre la nueva ventana manteniendo la relación con la ventana padre
						window.open(url, '_blank');
					}
				</script>
            
			</head>
			
			<body>
	
	<?php
	$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/miCuenta.php' id='breadcrumbs'>Mi cuenta";
	
	echo"<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		////CERRAR SESION
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";

				$fecha 	= $INTRANET->getOne("SELECT MAX(xd_fechaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '$usuarioId'  ");
				$hora 	= $INTRANET->getOne("SELECT MAX(xt_horaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '$usuarioId' AND  xd_fechaEntrada = '$fecha' ");
				
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
	
		/*
		echo "<table border='0' align='center'>";
			echo"<tr height='100'><td></td></tr>";
		echo "</table>"; 
		*/

		if($_GET["usuario"]){
			$usuario = $_GET["usuario"];
		}else{
			$usuario = $_SESSION["sesionUsuario"];
		}

		

		$nombreUsuario = $INTRANET->getOne("SELECT xt_nombre from perfiles.usuarios WHERE xt_usuario = '".$usuario."' ");
		$diasSinAcceso = $INTRANET->getOne("SELECT DATEDIFF('".$fecha."', MAX(xd_fechaEntrada)) AS dias_diferencia FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '".$usuario."' and xd_fechaEntrada < '".$fecha."' ");
		$ultimoAcceso = $INTRANET->getOne("SELECT MAX(xd_fechaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = '".$usuario."' and xd_fechaEntrada < '".$fecha."' ");


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
				AND md.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$usuario."' AND cvd.xt_codigoDocumento = md.xt_codigoDocumento AND cvd.xn_version = 0)
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
				AND ccd.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$usuario."' AND cvd.xt_codigoDocumento = ccd.xt_codigoDocumento AND cvd.xn_version = ccd.xn_version)
		");


		$documentosVisualizados = $INTRANETV2->getArray("
			SELECT
				cvd.xt_codigoDocumento,
				md.xt_nombre,
				cvd.xn_version,
				cvd.xd_fecha
			FROM
				sgi_control_de_cambios_documentos_copy1 cvd,
				sgi_manuales_documentos md
			WHERE
				cvd.xt_usuario = '".$usuario."'
				AND md.xt_codigoDocumento = cvd.xt_codigoDocumento
				ORDER BY xd_fecha DESC
		");

		$expedientesRechazados = $INTRANET->getArray("SELECT * FROM sgi_expediente_personal WHERE xt_usuario_empleado = '".$usuario."' AND YEAR(xd_fecha) = YEAR(NOW()) AND xt_estatus = 'Rechazado' ");
		$datosRechazados = $INTRANET->getArray("SELECT * FROM sgi_empleados WHERE kf_usuario = '".$usuario."' AND xt_estatusDatosPersonales = 'Rechazado' ");


		echo "<p><h3>Hola ".$nombreUsuario.".</h3></p>"; 

		//echo "<p>Tienes " . $diasSinAcceso . " " . ($diasSinAcceso < 2 ? "día" : "días") . " sin acceder a INTRANET.</p>";
		
		echo "<p>Tu último acceso a Intranet fue " .$ultimoAcceso. ".</p>";

		echo "<div align='left' style='width:500px;'>";

			echo "<p>Desde entonces, ha habido (".count($documentosNuevos).") altas y (".count($documentosActualizados).") modificaciones a los siguientes documentos.</p>";
			
			echo "<p>Para que puedas acceder a Intranet, es necesario que antes conozcas dichos cambios.</p>";

			echo "<p>1.- Cada uno de los documentos listados en esta página cuenta con un hipervínculo.</p>";

			echo "<p>2.- Haz click en cada hipervínculo. Lo cual te llevará al documento en cuestión.</p>";

			echo "<p>3.- Familiarízate con el documento en su versión vigente. Léelo y, si tienes alguna duda o crees que requiere ser modificado, contacta al área de calidad.</p>";

			echo "<p>4.- Al final del documento encontrarás un botón que confirma que lo has leído. Haz click en él.</p>";

			echo "<p>5.- Repite los pasos 2, 3 y 4 por cada documento listado.</p>";

		echo "</div>";

		//echo "<p>Hago constar que estoy informado de los cambios a nivel documental del SGI.</p>"; 

		//echo "<p>Confirmo que he leído cada uno de ellos en su versión VIGENTE. Los acepto y estoy OBLIGADO a su cumplimiento tal cual se encuentran documentados.</p>";

		
	

		if($documentosNuevos != null){

			echo "<table border='0' align='center' name='Cuerpo' width='850px'>";

				echo "<tr >";
					echo "<td colspan=3 align='center'><h2>Documentos Nuevos</h2></td>";
				echo "</tr>";

				echo "<tr >";
					echo "<td><h4>Codigo</h4></td>";
					echo "<td align='center'><h4>Nombre</h4></td>";
					echo "<td align='center'><h4>Fecha</h4></td>";
				echo "</tr>";

				foreach($documentosNuevos as $documento){
					echo "<tr >";
						echo "<td>".$documento['xt_codigoDocumento']."</td>";
						echo "<td><a href='visualizacionDocumentos.php?documentoId=".$documento['xt_codigoDocumento']."&version=0' onclick='abrirVentana(this.href); return false;'>".$documento['xt_nombre']."</a></td>";
						echo "<td align='center'>".$documento['xd_fecha']."</td>";
					echo "</tr>";
				}

			echo "</table>";
		}	

		echo "<br><br>";

		if(count($expedientesRechazados) + count($datosRechazados) > 0){

			echo "<table border='0' align='center' name='Cuerpo' width='500px'>";

				echo "<tr >";
					echo "<td colspan=4 align='center'><h2>Expedientes Rechazados</h2></td>";
				echo "</tr>";

				echo "<tr >";
					echo "<td><h4>Expediente</h4></td>";
					echo "<td align='center'><h4>Estatus</h4></td>";
					echo "<td align='center'><h4></h4></td>";
				echo "</tr>";

				foreach($expedientesRechazados as $expediente){
					echo "<tr >";
						echo "<td>".$expediente['xt_tipo_expediente']."</td>";
						echo "<td align='center'>".$expediente['xt_estatus']."</td>";
						echo "<td align='center'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/Personal/expedientePersonal.php'><img src='Imagenes/ICN_BotonNaranja.png' width='15' height='15'></a></td>";
					echo "</tr>";
				}

				foreach($datosRechazados as $datos){
					echo "<tr >";
						echo "<td>Datos Personales</td>";
						echo "<td align='center'>".$datos['xt_estatusDatosPersonales']."</td>";
						echo "<td align='center'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/Personal/datosPersonal.php'><img src='Imagenes/ICN_BotonNaranja.png' width='15' height='15'></a></td>";
					echo "</tr>";
				}

			echo "</table>";
		}
		
		echo "<br><br>";
	
		if($documentosActualizados != null){

			echo "<table border='0' id='documentosActualizados' align='center' name='Cuerpo' width='850px'>";

				echo "<tr >";
					echo "<td colspan=4 align='center'><h2>Documentos Actualizados</h2></td>";
				echo "</tr>";

				echo "<tr >";
					echo "<td><h4>Codigo</h4></td>";
					echo "<td align='center'><h4>Nombre</h4></td>";
					echo "<td align='center'><h4>Versión</h4></td>";
					echo "<td align='center'><h4>Fecha</h4></td>";
				echo "</tr>";

				foreach($documentosActualizados as $documento){
					echo "<tr >";
						echo "<td>".$documento['xt_codigoDocumento']."</td>";
						echo "<td><a href='visualizacionDocumentos.php?documentoId=".$documento['xt_codigoDocumento']."&version=".$documento['xn_version']."' onclick='abrirVentana(this.href); return false;'>".$documento['xt_nombre']."</a></td>";
						echo "<td align='center'>".$documento['xn_version']."</td>";
						echo "<td align='center'>".$documento['xd_fecha']."</td>";
					echo "</tr>";
				}

			echo "</table>";
		}
		
		echo "<br><br>";
	
		if($documentosVisualizados != null){

			echo "<table border='0' align='center' name='Cuerpo' width='850px'>";

				echo "<tr >";
					echo "<td colspan=4 align='center'><h2>Documentos Visualizados</h2></td>";
				echo "</tr>";

				echo "<tr >";
					echo "<td><h4>Codigo</h4></td>";
					echo "<td align='center'><h4>Nombre</h4></td>";
					echo "<td align='center'><h4>Versión</h4></td>";
					echo "<td align='center'><h4>Fecha</h4></td>";
				echo "</tr>";

				foreach($documentosVisualizados as $documento){
					echo "<tr >";
						echo "<td>".$documento['xt_codigoDocumento']."</td>";
						echo "<td><a href='visualizacionDocumentos.php?documentoId=".$documento['xt_codigoDocumento']."&version=".$documento['xn_version']."' onclick='abrirVentana(this.href); return false;'>".$documento['xt_nombre']."</a></td>";
						echo "<td align='center'>".$documento['xn_version']."</td>";
						echo "<td align='center'>".$documento['xd_fecha']."</td>";
					echo "</tr>";
				}

			echo "</table>";
		}

		echo "<br><br>";

	echo"</div>";
?>
		</body>
	</html>
<?php
