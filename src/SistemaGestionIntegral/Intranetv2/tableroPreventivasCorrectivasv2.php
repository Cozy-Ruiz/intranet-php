<?php

 
$nombrephp = 'tableroPreventivasCorrectivas.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);

if (!empty($_POST['etapaFiltro'])) {
	$etapa = $_POST['etapaFiltro'];
	$filtroEtapa = "AND (SELECT
					CE.xt_titulo
				FROM
					SGI_Acciones_Preventivas_Correctivas_Etapas CE
				WHERE
					CE.xt_codigoAccion = AA.xt_claveAccion
					
				ORDER BY
					CE.xn_etapa DESC
				LIMIT 1
		) = '$etapa'";

	if ($etapa=='E' || $etapa == 'NE') {
		if($etapa=='E'){
			$etapa=1;
		}elseif($etapa=='NE'){
			$etapa=0;
		}
	$filtroEtapa = "AND (SELECT
				CE.xt_titulo
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas CE
			WHERE
				CE.xt_codigoAccion = AA.xt_claveAccion
					
			ORDER BY
				CE.xn_etapa DESC
			LIMIT 1
		) = 'EVALUACION' AND AA.xn_status = $etapa";
	}
}

if (!empty($_POST['ciudad'])) {
	$ciudad = $_POST['ciudad'];
	if($ciudad=="LAR")
	{
		$filtroCiudad = "AND AA.xt_ciudad IN ('LRD' , 'LAR' )  "; //$filtroCiudad = "AND (AA.xt_ciudad = '$ciudad' OR AA.xt_ciudad = 'LAR' ";

	}
	else
	{
		$filtroCiudad = "AND AA.xt_ciudad = '$ciudad'";
	}
	
	if ($ciudad=='TODOS') {
	$filtroCiudad = " ";
	}

}
$thisyear = date("Y");
if (!empty($_POST['filtroAño'])) {
	$año = $_POST['filtroAño'];
	$filtroAño = "AND YEAR(AA.xd_fecha) = '$año'";

}
else
{
	$filtroAño = "AND YEAR(AA.xd_fecha) = '$thisyear'";
}

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> 
			   <a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a>
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

$s = $INTRANETV2->Execute("SELECT DISTINCT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas");

										echo "<select name='etapaFiltro'>";
											echo "<option value='' SELECTED>Seleccionar...</option>";
											while($r = $s->fetchRow()){
											 
												$etapaSeleccion = $r[0];
												$selected = "";	
												if ($etapa == $etapaSeleccion) {
													$selected = "selected";
												}
												if($etapaSeleccion == "ASIGNAR"){
													$seleccion="ASIGNADA";
												}elseif($etapaSeleccion == "SOLICITUD"){
													$seleccion="PLAN DE ACCION";
												}else{
													$seleccion = $etapaSeleccion;
												}
												if ($etapaSeleccion != "EVALUACION") {
													echo "<option $selected value='$etapaSeleccion'>$seleccion</option>"; 
												}
											}
										
											if (isset($_POST['etapaFiltro'])) {
												if ($_POST['etapaFiltro'] == 'E' && $etapaSeleccion == "EVALUACION") {
													echo "<option selected value='E'>EFICAZ</option>";
													echo "<option  value='NE'>NO EFICAZ</option></select>";
												}elseif ($_POST['etapaFiltro'] == 'NE' && $etapaSeleccion == "EVALUACION") {
													echo "<option value='E'>EFICAZ</option>";
													echo "<option selected value='NE'>NO EFICAZ</option>";
												}
											}else{
												echo "<option value='E'>EFICAZ</option>";
												echo "<option value='NE'>NO EFICAZ</option>";
											}

										echo"</select></td>";
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
											echo "<option value='' SELECTED>Seleccionar...</option>";
											while($r = $s->fetchRow()){

												if($r[0] !="LRD")
												{
													$ciudad = $r[0];	
													if ($_POST['ciudad'] == $ciudad) {
														echo "<option selected value='".$ciudad."'>$ciudad</option>";
													}else{
														echo "<option value='".$ciudad."'>$ciudad</option>";
													}
												}

											 
												
											}
											echo "<option value='TODOS'>TODOS</option>";										

										echo"</select>";							

										echo"</td>";
									echo"</tr>";

								//filtro año
								echo "<tr>";
									echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
										echo"<b>Año:</b>";
									echo"</td>";
								echo"<tr>";
										echo"<td align='center'>";							
										//Consulta para mostrar las Ciudades que estas disponibles//
										
										$a = $INTRANETV2->Execute("SELECT DISTINCT YEAR(xd_fecha) FROM SGI_Acciones_Preventivas_Correctivas WHERE 	YEAR (xd_fecha) > 2013 ORDER BY YEAR(xd_fecha) DESC");
										echo "<select name='filtroAño'>";
											echo "<option value='' SELECTED>Seleccionar...</option>";
											while($r = $a->fetchRow()){
											 
											 $año = $r[0];	
											
											 if ($_POST['filtroAño'] == $año) {
												echo "<option selected value='".$año."'>$año</option>";
											 }else{
												echo "<option value='".$año."'>$año</option>";
											 }
											}									

										echo"</select>";							

										echo"</td>";
									echo"</tr>";//filtro año

									echo"<tr height='8'></tr>";
									echo"<tr>";
										echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";									
											echo"<br><input type='submit' value='Buscar'>";
										
										echo"</td>";
									echo"</tr>";
									echo "<tr height='10px'><td></td></tr>";
						echo"</table><br><br><br>";
					echo"</form>";

$sql = $INTRANETV2->Execute("SELECT DISTINCT xt_tipo FROM SGI_Acciones_Preventivas_Correctivas ORDER BY xt_tipo ASC");
$c = 0;

while ($tipo = $sql->fetchRow()) {
	
	if ($tipo[0] == 'D') {
		$tipoAccion = 'Acciones Preventivas';
	}elseif ($tipo[0] == 'E') {
		$tipoAccion = 'Acciones Correctivas';
	}
		
		/*$s = $INTRANETV2->Execute("SELECT
									AA.xt_claveAccion,
									AA.xt_titulo,
									AA.xd_fecha,
									AA.xn_status,
									(
										SELECT
											CE.xt_titulo
										FROM
											SGI_Acciones_Preventivas_Correctivas_Etapas CE
										WHERE
											CE.xt_codigoAccion = AA.xt_claveAccion
										ORDER BY
											CE.xd_fecha DESC
										LIMIT 1
									),
									AA.xt_pdr
								FROM
									SGI_Acciones_Preventivas_Correctivas AA
								WHERE
									AA.xt_tipo = '$tipo[0]' $filtroEtapa $filtroCiudad $filtroAño
								ORDER BY
									AA.xd_fecha DESC");*/
								$s = $INTRANETV2->Execute("SELECT
									AA.xt_claveAccion,
									AA.xt_titulo,
									AA.xd_fecha,
									AA.xn_status,
									(
										SELECT
											CE.xt_titulo
										FROM
											SGI_Acciones_Preventivas_Correctivas_Etapas CE
										WHERE
											CE.xt_codigoAccion = AA.xt_claveAccion
										
										ORDER BY
											CE.xn_etapa DESC
										LIMIT 1
									),
									AA.xt_pdr
								FROM
									SGI_Acciones_Preventivas_Correctivas AA
								WHERE
									AA.xt_tipo = '$tipo[0]' $filtroCiudad $filtroEtapa $filtroAño
									AND YEAR (AA.xd_fecha) > 2013
									
								ORDER BY
									AA.xt_claveAccion ASC");
			
		// 	echo "SELECT
		// 	AA.xt_claveAccion,
		// 	AA.xt_titulo,
		// 	AA.xd_fecha,
		// 	AA.xn_status,
		// 	(
		// 		SELECT
		// 			CE.xt_titulo
		// 		FROM
		// 			SGI_Acciones_Preventivas_Correctivas_Etapas CE
		// 		WHERE
		// 			CE.xt_codigoAccion = AA.xt_claveAccion
				
		// 		ORDER BY
		// 			CE.xn_etapa DESC
		// 		LIMIT 1
		// 	),
		// 	AA.xt_pdr
		// FROM
		// 	SGI_Acciones_Preventivas_Correctivas AA
		// WHERE
		// 	AA.xt_tipo = '$tipo[0]' $filtroCiudad $filtroEtapa $filtroAño
		// 	AND YEAR (AA.xd_fecha) > 2013
			
		// ORDER BY
		// 	AA.xt_claveAccion ASC";

					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' id='titulo2'>$tipoAccion</td>";
						echo "</tr>";
					echo "</table>";

					echo "<table border='0' align='center'  width='1020px'>";
					///CABECERA		
						echo "<tr id='titulo2'>";
							echo "<td align='center' width='150px'>Código</td>";
							echo "<td align='left' width='390px'>Título</td>";
							echo "<td align='center' width='185px'>Fecha</td>";	
							echo "<td align='center' width='115px'>Status</td>";
							echo "<td align='center' width='50px'>Evaluacion</td>";
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
				echo "<td width='130px' align='center' valign='top'>"; 

					if ($tipo[0]=='D') {
					echo "<a href='fichaPreventivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
					}elseif($tipo[0]=='E'){
					echo "<a href='fichaCorrectivav2.php?id=".$clavePreventiva."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
					}

				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='390px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='85px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='115px' align='center' valign='top'>";
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
						}else if($etapa == ""){
								echo "Sin asignar";
						}
						
					}
				echo "</td>";
				//***IF para poner semaforo***//
				echo "<td width='100px' align='center' valign='top'>";					
					if($etapa == "EVALUACION" && $status == 1){
						echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
					}else if($etapa == "EVALUACION" && $status == 0){
					echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
					}
													
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='90px' align='left' valign='top'>".$pdr."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	}//fin de while tipos
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	//terminan acciones preventivas y correctivas
		
		echo "<tr height='10px'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' >";
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='80'><td></td></tr>";
	echo "</table>";
		 
//echo "Ciudad: $filtroCiudad";

echo "</div>";
