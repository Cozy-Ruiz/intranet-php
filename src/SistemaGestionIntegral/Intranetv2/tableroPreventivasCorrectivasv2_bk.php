<?php

 
$nombrephp = 'tableroPreventivasCorrectivas.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);


$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Tablero de Acciones Preventivas y Correctivas</title>
             <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png"> 
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

echo "<div id='wrapperFichaCorrectivasPreventivas' align='center'>";
	echo "<table border='0' align='center' width='1000px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Tablero de Acciones <br> Preventivas y Correctivas";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
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
		echo"<tr height='60'><td></td></tr>";
	echo "</table>"; 


	///ACCIONES PREVENTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center'>";
				echo "<a href='altaPreventivaCorrectivaPopUpv2.php'>";
					echo "<img src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
				echo "</a>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70px'><td></td></tr>";
		echo"</table>";
		
		
		echo"<br><br><form action='tableroPreventivasCorrectivasv2.php'  method='POST'>";
							echo "<table border='0' align='center'>";
								echo "<tr>";
									echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
										echo"<b>Filtra Status:</b>";
									echo"</td>";
								echo"<tr>";
										echo"<td align='center'>";							
										//Consulta para mostrar N° de Cliente, nombre y rfc de los Clientes
										
										//$s = $INTRANET->Execute("SELECT DISTINCT xt_titulo FROM IntranetGEA.SGI_Seguimiento_Etapas WHERE xt_titulo in('ASIGNAR','ANALISIS','DECISION','SOLICITUD','EVALUACION')");
										echo "<select name='etapaActual'>";
											echo "<option value='' SELECTED>";
											//while($r = $s->fetchRow()){
											 
											 //$etapaSeleccion = $r[0];	
											
											//	if($etapaSeleccion == "ASIGNAR"){
												echo "<option value='SINASIGNAR'>Sin Asignar</option>"; 
												echo "<option value='ASIGNAR'>Asignada</option>";
												//}else if($etapaSeleccion == "ANALISIS"){
												echo "<option value='ANALISIS'>Análisis de causa raíz</option>";
												//}else if($etapaSeleccion == "DECISION"){
												echo "<option value='DECISION'>Decisión</option>";
												//}else if($etapaSeleccion == "SOLICITUD"){
												echo "<option value='SOLICITUD'>Plan de acción</option>";
												//}else if($etapaSeleccion == "EVALUACION"){
												echo "<option value='EVALUACION'>Eficaz</option>";

												echo "<option value='NOEFICAZ'>No Eficaz</option>";
												//}
											//}
										echo"</select>";
										echo"</td>";
									echo"</tr>";
									echo"<tr height='8'></tr>";
									echo "<tr>";
									echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
										echo"<b>Ciudad:</b>";
									echo"</td>";
								echo"<tr>";
										echo"<td align='center'>";							
										//Consulta para mostrar las Ciudades que estas disponibles//
										
										$s = $INTRANETV2->Execute("SELECT DISTINCT xt_ciudad FROM SGI_Acciones_Preventivas_Correctivas");
										echo "<select name='ciudad'>";
											echo "<option value='' SELECTED>";
											while($r = $s->fetchRow()){
											 
											 $ciudad = $r[0];	
											
												echo "<option value='".$ciudad."'>$ciudad</option>";
												
											}
											echo "<option value='TODOS'>TODOS</option>";										

										echo"</select>";							

										echo"</td>";
									echo"</tr>";
									echo"<tr height='8'></tr>";
									echo"<tr>";
										echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";									
											echo"<br><input type='submit' value='Buscar'>";
										
										echo"</td>";
									echo"</tr>";
									echo "<tr height='10px'><td></td></tr>";
						echo"</table><br><br><br>";
					echo"</form>";
											
	if($_POST['etapaActual'] == '' && $_POST['ciudad'] == ''){
		
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='110px'>Código</td>";
			echo "<td align='left' width='260px'>Título</td>";
			echo "<td align='center' width='100px'>Fecha</td>";	
			echo "<td align='center' width='90px'>Status</td>";
			echo "<td align='center' width='190x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		
		$s = $INTRANETV2->Execute(" SELECT AA.xt_claveAccion, AA.xt_titulo,
 AA.xd_fecha, AA.xn_status,
(SELECT CE.xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas CE 
where   CE.xt_codigoAccion = AA.xt_claveAccion ORDER BY CE.xd_fecha DESC LIMIT 1) 
, AA.xt_pdr FROM SGI_Acciones_Preventivas_Correctivas   AA 	WHERE AA.xt_tipo = 'D' ORDER BY AA.xd_fecha DESC
");
								
		while($r = $s->fetchRow()){
			
			//$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[0];
			$tituloPreventiva 	= $r[1];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa              = $r[4];
			$pdr				= $r[5];
			
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
			
			
			
				

			//}
			
			echo "<tr height='25px' id='fileItem'>";	
			///***CLAVE Y VINCULO A LA ACCION PREVENTIVA***		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='center' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
								echo "Evaluado";
							 
							
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
							if($etapa == "EVALUACION" && $status == 1){
								echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
							} else if($etapa == "EVALUACION" && $status == 0){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
							}

													
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//***ACCIONES CORRECTIVAS***
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='110px'>Código</td>";
			echo "<td align='left' width='270px'>Título</td>";
			echo "<td align='center' width='100px'>Fecha</td>";	
			echo "<td align='center' width='100px'>Status</td>";
			echo "<td align='center' width='180x'>PDR</td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xd_fecha, xn_status, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E'  ORDER BY xd_fecha DESC");
								
		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa				= "";
				
			//if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, (SELECT E.xt_nombreCorto FROM INTRANET2.SGI_Empleados E WHERE E.kf_usuario = SGU.xt_pdr) FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$claveCorrectiva' AND SGU.xt_tipo = 'E' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ORDER BY SCPE.xd_fecha");
			
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u); 
			
			//}
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='center' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							
							echo "";
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
					
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							echo "Evaluado";
							
						}
						
					}
				echo "</td>
				<td width='50px' align='left' valign='top'>";

							if($etapa == "EVALUACION" && $status == 1){
								echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
							} else if($etapa == "EVALUACION" && $status == 0){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
							}

				echo "</td><td width='10px'></td>";
				if($etapa != ''){
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				}else{
					echo "<td width='170px' align='left' valign='top'></td>";
				}
				
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
	
	//***FILTRAR POR CIUDAD ***
	}else if($_POST['etapaActual'] == '' && $_POST['ciudad'] != 'TODOS'){
		$ciudadBuscar =  $_POST['ciudad'];
		
		echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td width='170px' align='center' valign='top'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
	
		//echo"SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
			//					WHERE xt_tipo = 'D' AND xt_ciudad = '$ciudadBuscar' ORDER BY xd_fecha DESC";
		
								
		$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xd_fecha, xn_status, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'D' AND xt_ciudad = '$ciudadBuscar' ORDER BY xd_fecha DESC");
		
								
		while($r = $s->fetchRow()){
			
			//$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[0];
			$tituloPreventiva 	= $r[1];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa              = "";
			
			//if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
			
				$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SCPE.xt_usuario FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$clavePreventiva' AND SGU.xt_tipo = 'D' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion");
				
			
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			//}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='center' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=8 height=8>";
							if($status == 1){
								echo "Eficaz";
							} else if($status == 0){
								
								echo "No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";


				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170px'>PDR</td>";
			//echo "<td width='20px' align='center'></td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xd_fecha, xn_status, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xt_ciudad = '$ciudadBuscar' ORDER BY xt_claveAccion DESC ");
		
		
		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa				= "";
				
			//if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SGU.xt_pdr FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$claveCorrectiva' AND SGU.xt_tipo = 'E' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ORDER BY SCPE.xn_etapa");
			
			

			
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			//}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Eficaz";
							} else if($status == 0){
								echo "No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
		
	// ***FILTRAR POR ETAPA Y CIUDAD**//	
	}else if($_POST['etapaActual'] != '' && $_POST['ciudad'] != 'TODOS'){
		
		
		
		$BuscaTitulo = $_POST['etapaActual'];
		$ciudadBuscar= $_POST['ciudad'];
		
	echo "<table border='0' align='center'>";
	echo $ciudadBuscar;
	echo $BuscaTitulo;
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";
	
		echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		
		if($BuscaTitulo == 'SINASIGNAR'){
			$s = $INTRANETV2->Execute("SELECT
			AA.xt_claveAccion,
			AA.xt_titulo,
			AA.xd_fecha,
			AA.xn_status,
			AA.xt_pdr
		FROM
			SGI_Acciones_Preventivas_Correctivas AA
		WHERE
			AA.xt_tipo = 'D'
		AND AA.xt_asignador is NULL
		AND AA.xt_pdr IS NULL

		ORDER BY
			AA.xd_fecha DESC");
		}
	
		
	
		if($BuscaTitulo == 'ASIGNAR'){
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'DECISION'){
			
			
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}


	elseif ($BuscaTitulo == 'NOEFICAZ') {
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = 'EVALUACION'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'
			AND SA.xn_status = '0'
			GROUP BY
				t1.xt_codigoAccion");
		}	
		while($r = $s->fetchRow()){
			
			//$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[0];
			$tituloPreventiva 	= $r[1];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa              = $r[7];
			$pdr 				= $r[4];
			
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				/*$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SCPE.xt_usuario FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$clavePreventiva' AND SGU.xt_tipo = 'D' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ");
			
			
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANETV2->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);*/
			//}
			if($etapa != ''){
				echo "<tr height='25px' id='fileItem'>";	
				///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
					echo "<td width='150px' align='center' valign='top'>"; 
						echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
					echo "</td>";
				///TITULO ACCION PREVENTIVA
					echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
				///FECHA
					echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";

					echo "<td width='10px' valign='top'></td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='150px' align='left' valign='top'>";
						if($etapa != ""){
							if($etapa == "ASIGNAR"){
								echo "Asignada";

							}else if($etapa == "ANALISIS"){
								echo "Análisis de causa raíz";

							}else if($etapa == "DECISION"){
								echo "Decisión";

							}else if($etapa == "SOLICITUD"){
								echo "Plan de acción";

							}else if($etapa == "EVALUACION"){

								if($status == 1){
									echo "Eficaz";
								} else if($status == 0){
									echo "No Eficaz";
								}
							}

						}
					echo "</td>";
					//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
					echo "<td width='10px'></td>";
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
					//echo "<td width='20px' align='center' valign='top'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";
			}
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";

		//***Opcion para filtrar sin asignar**//

		if($BuscaTitulo == 'SINASIGNAR'){
			$s = $INTRANETV2->Execute("SELECT
			AA.xt_claveAccion,
			AA.xt_titulo,
			AA.xd_fecha,
			AA.xn_status,
			AA.xt_pdr
			0=etapa
		FROM
			SGI_Acciones_Preventivas_Correctivas AA
		WHERE
			AA.xt_tipo = 'D'
		AND AA.xt_asignador is NULL
		AND AA.xt_pdr IS NULL

		ORDER BY
			AA.xd_fecha DESC");
		}

		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$pdr				= $r[4];
		
					echo "<tr height='25px' id='fileItem'>";	
								//CLAVE Y VINCULO A LA SOLICITUD			
					echo "<td width='150px' align='center' valign='top'>"; 
						echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
					echo "</td>";
				///TITULO SOLICITUD	
					echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
				///FECHA
					echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";

					echo "<td width='10px' valign='top'> </td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='150px' align='left' valign='top'>";
					
					echo "</td>";
					echo "<td width='10px'></td>";
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
					//echo "<td width='20px' align='center' valign='top'> </td>";
				echo "</tr>";


				echo "<tr height='10px'><td colspan='6'> </td></tr>";
				echo"entre a la opcion exitosamente";
	
		} unset($r); unset($s);




	
		if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'DECISION'){
			
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			
			
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = '$BuscaTitulo'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			GROUP BY
				t1.xt_codigoAccion");
		}

		elseif ($BuscaTitulo == 'NOEFICAZ') {
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = 'EVALUACION'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xt_ciudad = '$ciudadBuscar'
			AND SA.xn_status = '0'
			GROUP BY
				t1.xt_codigoAccion");
		}




		/*$s = $INTRANETV2->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xn_numero = $etapaBuscar ORDER BY xt_claveAccion DESC ");
		*/						
		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$pdr				= $r[4];
			$etapa				= $r[7];
				
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				/*$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SGU.xt_pdr FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$claveCorrectiva' AND SGU.xt_tipo = 'E' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ORDER BY SCPE.xn_etapa");
			
			
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANETV2->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);*/
			//}

			if($etapa != ''){
				
				echo "<tr height='25px' id='fileItem'>";	
				///CLAVE Y VINCULO A LA SOLICITUD			
					echo "<td width='150px' align='center' valign='top'>"; 
						echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
					echo "</td>";
				///TITULO SOLICITUD	
					echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
				///FECHA
					echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";

					echo "<td width='10px' valign='top'> </td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='150px' align='left' valign='top'>";
						if($etapa != ""){
							if($etapa == "ASIGNAR"){
								echo "Asignada";

							}else if($etapa == "ANALISIS"){
								echo "Análisis de causa raíz";

							}else if($etapa == "DECISION"){
								echo "Decisión";

							}else if($etapa == "SOLICITUD"){
								echo "Plan de acción";

							}else if($etapa == "EVALUACION"){

								if($status == 1){
									echo "Eficaz";
								} else if($status == 0){
									echo "No Eficaz";
								}

							}

						}
					echo "</td>";
					//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
					echo "<td width='10px'></td>";
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
					//echo "<td width='20px' align='center' valign='top'> </td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'> </td></tr>";
			}
		} unset($r); unset($s);
	
	
	}else if($_POST['etapaActual'] != '' && $_POST['ciudad'] == 'TODOS'){
		
		$BuscaTitulo = $_POST['etapaActual'];
		
		
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";
	
		echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
		if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'D'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'D'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'DECISION'){
			
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'D'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'D'

GROUP BY
	t1.xt_codigoAccion");
		}
			
		else if($BuscaTitulo == 'EVALUACION'){
			
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'D'
GROUP BY
	t1.xt_codigoAccion");
		}

	elseif ($BuscaTitulo == 'NOEFICAZ') {
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = 'EVALUACION'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'D'
			AND SA.xn_status = '0'
			GROUP BY
				t1.xt_codigoAccion");
		}




		while($r = $s->fetchRow()){
			
			//$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[0];
			$tituloPreventiva 	= $r[1];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$pdr 				= $r[4];
			$etapa              = $r[7];
			
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				/*$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SCPE.xt_usuario FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$clavePreventiva' AND SGU.xt_tipo = 'D' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANETV2->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
					

					
				} unset($t); unset($u);*/
			//}
			
			if($etapa != ''){
				echo "<tr height='25px' id='fileItem'>";	
				///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
					echo "<td width='150px' align='center' valign='top'>"; 
						echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
					echo "</td>";
				///TITULO ACCION PREVENTIVA
					echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
				///FECHA
					echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";

					echo "<td width='10px' valign='top'></td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='150px' align='left' valign='top'>";
						if($etapa != ""){
							if($etapa == "ASIGNAR"){
								echo "Asignada";

							}else if($etapa == "ANALISIS"){
								echo "Análisis de causa raíz";

							}else if($etapa == "DECISION"){
								echo "Decisión";

							}else if($etapa == "SOLICITUD"){
								echo "Plan de acción";

							}else if($etapa == "EVALUACION"){

								if($status == 1){
									echo "Eficaz";
								} else if($status == 0){
									echo "No Eficaz";
								}

							}

						}
					echo "</td>";
					//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";

					echo "<td width='10px'></td>";
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
					//echo "<td width='20px' align='center' valign='top'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";
			}
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
			if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'E'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'E'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'DECISION'){
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'E'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'E'

GROUP BY
	t1.xt_codigoAccion");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANETV2->Execute("SELECT
	SA.xt_claveAccion,
	SA.xt_titulo,
	SA.xd_fecha,
	SA.xn_status,
	SA.xt_pdr,
	MAX(t1.xn_etapa) estado,
	t1.xt_codigoAccion,
	(
		SELECT
			t2.xt_titulo
		FROM
			SGI_Acciones_Preventivas_Correctivas_Etapas t2
		WHERE
			t1.xt_codigoAccion = t2.xt_codigoAccion
		AND MAX(t1.xn_etapa) = t2.xn_etapa
		AND t2.xt_titulo = '$BuscaTitulo'
	) etapa
FROM
	SGI_Acciones_Preventivas_Correctivas_Etapas t1,
	SGI_Acciones_Preventivas_Correctivas SA
WHERE
	SA.xt_claveAccion = t1.xt_codigoAccion
AND SA.xt_tipo = 'E'

GROUP BY
	t1.xt_codigoAccion");
		}

	elseif ($BuscaTitulo == 'NOEFICAZ') {
			$s = $INTRANETV2->Execute("SELECT
				SA.xt_claveAccion,
				SA.xt_titulo,
				SA.xd_fecha,
				SA.xn_status,
				SA.xt_pdr,
				MAX(t1.xn_etapa) estado,
				t1.xt_codigoAccion,
				(
					SELECT
						t2.xt_titulo
					FROM
						SGI_Acciones_Preventivas_Correctivas_Etapas t2
					WHERE
						t1.xt_codigoAccion = t2.xt_codigoAccion
					AND MAX(t1.xn_etapa) = t2.xn_etapa
					AND t2.xt_titulo = 'EVALUACION'
				) etapa
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas t1,
				SGI_Acciones_Preventivas_Correctivas SA
			WHERE
				SA.xt_claveAccion = t1.xt_codigoAccion
			AND SA.xt_tipo = 'E'
			AND SA.xn_status = '0'
			GROUP BY
				t1.xt_codigoAccion");
		}													
		/*$s = $INTRANETV2->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xn_numero = $etapaBuscar ORDER BY xt_claveAccion DESC ");
		*/						
		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa				= $r[7];
			$pdr				= $r[4];
				
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				/*$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SGU.xt_pdr FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$claveCorrectiva' AND SGU.xt_tipo = 'E' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ORDER BY SCPE.xn_etapa");
			
			

				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANETV2->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);*/
			//}

			if($etapa != ''){
				echo "<tr height='25px' id='fileItem'>";	
				///CLAVE Y VINCULO A LA SOLICITUD			
					echo "<td width='150px' align='center' valign='top'>"; 
						echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
					echo "</td>";
				///TITULO SOLICITUD	
					echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
				///FECHA
					echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";

					echo "<td width='10px' valign='top'> </td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='150px' align='left' valign='top'>";
						if($etapa != ""){
							if($etapa == "ASIGNAR"){
								echo "Asignada";

							}else if($etapa == "ANALISIS"){
								echo "Análisis de causa raíz";

							}else if($etapa == "DECISION"){
								echo "Decisión";

							}else if($etapa == "SOLICITUD"){
								echo "Plan de acción";

							}else if($etapa == "EVALUACION"){

								if($status == 1){
									echo "Eficaz";
								} else if($status == 0){

							
									echo "No Eficaz";
								}

							}

						}
					echo "</td>";
					//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
					echo "<td width='10px'></td>";
					echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
					//echo "<td width='20px' align='center' valign='top'> </td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'> </td></tr>";
			}
		} unset($r); unset($s);
		
	}else if($_POST['etapaActual'] == '' && $_POST['ciudad'] == 'TODOS'){
		
		$ciudadBuscar =  $_POST['ciudad'];
		
		echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
	
								
		$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xd_fecha, xn_status, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'D'  ORDER BY xt_claveAccion DESC");
								
		while($r = $s->fetchRow()){
			
			//$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[0];
			$tituloPreventiva 	= $r[1];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa              = "";
			
			//if($INTRANETV2->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
				$u = $INTRANETV2->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SCPE.xt_usuario FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$clavePreventiva' AND SGU.xt_tipo = 'D' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ");
				
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			//}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Eficaz";
							} else if($status == 0){
								echo "No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170px'>PDR</td>";
			//echo "<td width='20px' align='center'></td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANETV2->Execute("SELECT xt_claveAccion, xt_titulo, xd_fecha, xn_status, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E'  ORDER BY xt_claveAccion DESC");
		
		
								
		while($r = $s->fetchRow($s)){
			
			//$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[0];
			$tituloCorrectiva 	= $r[1];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[2]));
			$status 			= $r[3];
			$etapa				= "";
				
			//if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SCPE.xt_titulo, SCPE.xd_fecha, SGU.xt_pdr FROM SGI_Acciones_Preventivas_Correctivas_Etapas SCPE, SGI_Acciones_Preventivas_Correctivas SGU WHERE SCPE.xt_codigoAccion = '$claveCorrectiva' AND SGU.xt_tipo = 'E' AND SGU.xt_claveAccion = SCPE.xt_codigoAccion ORDER BY SCPE.xn_etapa");
			
			

				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					//$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			//}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectivav2.php?id=$claveCorrectiva' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Eficaz";
							} else if($status == 0){
								echo "No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='50px' align='left' valign='top'>";					
						if($etapa == "EVALUACION"){
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
						}
						else
							echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";						
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
	}
	
	
	
		
		echo "<tr height='10px'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' >";
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='80'><td></td></tr>";
	echo "</table>";
		 
echo "</div>";

?>
		</body>
	</html>
<?php
