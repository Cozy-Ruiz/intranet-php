<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio F. García Robles
 *@version 2.2
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'tableroSolicitudesyQuejas.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";

$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

if(		  $_POST['ciudad'] != ""){
	$ciudadShow = $_POST['ciudad'];
	
} else if($_GET['ciudad'] != ""){
	$ciudadShow = $_GET['ciudad'];
	
} else{
	$ciudadShow = $ciudadDefault;
}

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Tablero de Solicitudes y Quejas</title>
             <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					} else if (valor == 0){
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					}
				}
			</script>
        </head>
        <body>
<?php

	echo "<div id='wrapperRiesgos'>";
	echo "<form method='POST' action='tableroSolicitudesyQuejas.php'>";
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Solicitudes y Quejas</font>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
				echo"<td align='center'>";
					echo "<font>$breadcrumb</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<a href='altaSolicitudQuejaPopUp.php'><img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		if($categoriaUsr == "Inhouse"){
			
			///SOLICITUDES
			echo "<table border='0' align='center'>";
				echo"<tr>";
					echo"<td align='center' id='titulo2'>Solicitudes</td>";
				echo"</tr>";
			echo "</table>";
			
			$bandera = 0;
			
			///RECORREMOS LAS CIUDADES
			for($a = 1; $a <= 6; $a++){
				///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
				if(in_array($cdValor[$a], $ciudadesDisponibles)){
					
					$solicitudID 		= NULL;
					$claveSolicitud 	= NULL;
					$tituloSolicitud 	= NULL;
					$fechaSolicitud 	= NULL;
					$solicitanteUsr		= NULL;
					$status 			= NULL;
					$pdr				= NULL;
					
					$i = 1;
					///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
					$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
											FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM WHERE SQS.xt_ciudad = '$cdValor[$a]' AND SQS.xt_tipo = 'B' 
											AND SQS.kf_usuarioId = '$usuarioId' AND SQS.kf_usuarioId = SEM.kf_usuario 
											
											UNION 
											
											SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
											FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM, SGI_Seguimientos SSE WHERE SQS.xt_ciudad = '$cdValor[$a]' 
											AND SQS.xt_tipo = 'B' AND SSE.xt_tipoOrigen = 'B' AND SQS.kp_quejaSolicitudID = SSE.kf_itemOrigenID 
											AND SSE.kf_pdrID = SEM.kp_personalId AND SEM.kf_usuario = '$usuarioId' ORDER BY xt_claveQuejaSolicitud DESC ");
											
					while($r = $s->fetchRow($s)){
						
						$solicitudID[$i] 		= $r[0];
						$claveSolicitud[$i] 	= $r[1];
						$tituloSolicitud[$i] 	= $r[2];
						$fechaSolicitud[$i] 	= date('Y-m-d', strtotime($r[3]));
						
						if($r[4] != ""){
							
							$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
							
							while($t = $u->fetchRow()){
								
								$solicitanteUsr[$i] = $t[0]." ".$t[1];
								
							} unset($t);
							
						} else{
							
							$solicitanteUsr[$i] = "";
							
						}
						
						$status[$i] 			= "";
						$pdr[$i]				= "";
						
						if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $solicitudID[$i] AND xt_tipoOrigen = 'B' ")){
							
							$u = $INTRANET->Execute("SELECT SQSE.xt_estatus, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
													FROM SGI_Seguimientos SGU, SGI_Quejas_Solicitudes_Estatus SQSE, SGI_Empleados SEM 
													WHERE SGU.kf_itemOrigenID = $solicitudID[$i] AND SGU.xt_tipoOrigen = 'B' 
													AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID 
													AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_numero ASC ");
							
							while($t = $u->fetchRow()){
								
								$status[$i] 		= $t[0];
								$fechaSolicitud[$i] = date('Y-m-d', strtotime($t[1]));
								$pdr[$i] 			= $t[2]." ".$t[3];
								
							} unset($t);
							
							if(		  $status[$i] == "ABIERTA"){
								$status[$i] = "Asignada";
								
							} else if($status[$i] == "REVISION"){
								$status[$i] = "Para Revisión";
								
							} else if($status[$i] == "RECHAZADA"){
								$status[$i] = "Rechazada";
								
							} else if($status[$i] == "TERMINADA"){
								$status[$i] = "Terminada";
								
							}
							
						}
						
						$i++;
						
					}
				
				}
				///SI HUBO RESULTADOS IMPRIME LA TABLA
				if(count($solicitudID) >= 1){
						
					$bandera = 1;
					
					if(in_array($cdValor[$a],$ciudadesDisponibles)){
						echo "<table border='0' align='center' width='1030px'>";
						
							echo "<tr height='10px'><td> </td></tr>";
							/*
							echo "<tr>";
								echo "<td id='titulo2Blanco' align='left' width='1030px'>".$ciudades[$a]."</td>";
							echo "</tr>";
							*/
						echo "</table>";
						
						echo "<table border='0' align='center'  width='1030px'>";
						///CABECERA		
							echo"<tr id='titulo2'>";
								echo "<td width='30px'> </td>";
								echo "<td width='100px' align='center'>Código</td>";
								echo "<td width='380px' align='left'>Título</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='80px' align='center'>Fecha</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='110px' align='left'>Status</td>";
								echo "<td width='150px' align='left'>Solicitante</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='150px' align='left'>PDR</td>";
							echo"</tr>";
							
							echo "<tr>";
								echo "<td> </td>";
								echo "<td colspan='9' id='titleBlueLineTop'></td>";
							echo "</tr>";
							
							echo"<tr height='10px'><td colspan='10'> </td></tr>";
						echo "</table>";
						
						echo "<table border='0' align='center' width='1030px'>";
							for($o = 1; $o <= count($solicitudID); $o++){
								
								echo "<tr height='25' id='fileItem'>";
									echo "<td width='30px'> </td>";
								///CLAVE Y VINCULO A LA SOLICITUD			
									echo "<td width='100px' align='center' valign='top'>"; 
										echo "<a href='fichaSolicitud.php?id=".$solicitudID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveSolicitud[$o]."</a>";
									echo "</td>";
								///TITULO SOLICITUD	
									echo "<td width='380px' align='left' valign='top'>".$tituloSolicitud[$o]."</td>";
									echo "<td width='10px'> </td>";
								///FECHA
									echo "<td width='80px' align='center' valign='top'>".$fechaSolicitud[$o]."</td>";
									echo "<td width='10px'> </td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
								///SOLICITANTE
									echo "<td width='150px' align='left' valign='top'>".$solicitanteUsr[$o]."</td>";
									echo "<td width='10px'> </td>";
								///PDR
									echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='10'> </td></tr>";
								
							}
						echo "</table>";
						
					}
					
				}
				
			}
			
			if($bandera == 0){
				
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'><td> </td></tr>";
					echo"<tr>";
						echo"<td align='center' id='titulo12'<i>No hay Solicitudes</i></td>";
					echo"</tr>";
				echo "</table>";
				
			}
				
			///QUEJAS
			echo "<table border='0' align='center'>";
				echo "<tr height='70px'><td> </td></tr>";
				echo"<tr>";
					echo"<td align='center' id='titulo2'>Quejas</td>";
				echo"</tr>";
			echo "</table>";
			
			$bandera = 0;
			
			///RECORREMOS LAS CIUDADES
			for($a = 1; $a <= 6; $a++){
				///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
				if(in_array($cdValor[$a], $ciudadesDisponibles)){
					
					$quejaID 		= NULL;
					$claveQueja 	= NULL;
					$tituloQueja 	= NULL;
					$fechaQueja 	= NULL;
					$quejosoUsr		= NULL;
					$status 		= NULL;
					$pdr			= NULL;
					
					$i = 1;
					///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
					$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
											FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM WHERE SQS.xt_ciudad = '$cdValor[$a]' AND SQS.xt_tipo = 'C' 
											AND SQS.kf_usuarioId = '$usuarioId' AND SQS.kf_usuarioId = SEM.kf_usuario 
											
											UNION 
											
											SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
											FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM, SGI_Seguimientos SSE WHERE SQS.xt_ciudad = '$cdValor[$a]' 
											AND SQS.xt_tipo = 'C' AND SSE.xt_tipoOrigen = 'C' AND SQS.kp_quejaSolicitudID = SSE.kf_itemOrigenID 
											AND SSE.kf_pdrID = SEM.kp_personalId AND SEM.kf_usuario = '$usuarioId' ORDER BY xt_claveQuejaSolicitud DESC ");
											
					while($r = $s->fetchRow($s)){
						
						$quejaID[$i] 		= $r[0];
						$claveQueja[$i] 	= $r[1];
						$tituloQueja[$i] 	= $r[2];
						$fechaQueja[$i] 	= date('Y-m-d', strtotime($r[3]));
						
						if($r[4] != ""){
							
							$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
							
							while($t = $u->fetchRow()){
								
								$quejosoUsr[$i] = $t[0]." ".$t[1];
								
							} unset($t);
							
						} else{
							
							$quejosoUsr[$i] = "";
							
						}
						
						$status[$i] 			= "";
						$pdr[$i]				= "";
						
						if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $quejaID[$i] AND xt_tipoOrigen = 'C' ")){
							
							$u = $INTRANET->Execute("SELECT SQSE.xn_etapa, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
													FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SQSE, SGI_Empleados SEM 
													WHERE SGU.kf_itemOrigenID = $quejaID[$i] AND SGU.xt_tipoOrigen = 'C' 
													AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID
													AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_etapa ASC");
							
							while($t = $u->fetchRow()){
								
								$status[$i] 		= $t[0];
								$fechaQueja[$i] 	= date('Y-m-d', strtotime($t[1]));
								$pdr[$i] 			= $t[2]." ".$t[3];
								
							} unset($t);
							
							if(		  $status[$i] == 1){
								$status[$i] = "Asignada";
								
							} else if($status[$i] == 2){
								$status[$i] = "Evaluación Inicial";
								
							} else if($status[$i] == 3){
								$status[$i] = "Investigación";
								
							} else if($status[$i] == 4){
								$status[$i] = "Respuesta";
								
							} else if($status[$i] == 5){
								$status[$i] = "Comunicación";
								
							} else if($status[$i] == 6){
								$status[$i] = "Cierre";
								
							}
							
						}
						
						$i++;
						
					}
				
				}
				///SI HUBO RESULTADOS IMPRIME LA TABLA
				if(count($quejaID) >= 1){
					
					$bandera = 1;
					
					if(in_array($cdValor[$a], $ciudadesDisponibles)){
						echo "<table border='0' align='center' width='1030px'>";
						
							echo "<tr height='10px'><td> </td></tr>";
							/*
							echo "<tr>";
								echo "<td id='titulo2Blanco' align='left' width='1030px'>".$ciudades[$a]."</td>";
							echo "</tr>";
							*/
						echo "</table>";
						
						echo "<table border='0' align='center'  width='1030px'>";
						///CABECERA		
							echo"<tr id='titulo2'>";
								echo "<td width='30px'> </td>";
								echo "<td width='100px' align='center'>Código</td>";
								echo "<td width='380px' align='left'>Título</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='80px' align='center'>Fecha</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='110px' align='left'>Status</td>";
								echo "<td width='150px' align='left'>Solicitante</td>";
								echo "<td width='10px'> </td>";
								echo "<td width='150px' align='left'>PDR</td>";
							echo"</tr>";
							
							echo "<tr>";
								echo "<td> </td>";
								echo "<td colspan='9' id='titleBlueLineTop'></td>";
							echo "</tr>";
							
							echo"<tr height='10px'><td colspan='10'> </td></tr>";
						echo "</table>";
						
						echo "<table border='0' align='center' width='1030px'>";
							for($o = 1; $o <= count($quejaID); $o++){
								
								echo "<tr height='25' id='fileItem'>";
									echo "<td width='30px'> </td>";
								///CLAVE Y VINCULO A LA SOLICITUD			
									echo "<td width='100px' align='center' valign='top'>"; 
										echo "<a href='fichaQueja.php?id=".$quejaID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveQueja[$o]."</a>";
									echo "</td>";
								///TITULO SOLICITUD	
									echo "<td width='380px' align='left' valign='top'>".$tituloQueja[$o]."</td>";
									echo "<td width='10px'> </td>";
								///FECHA
									echo "<td width='80px' align='center' valign='top'>".$fechaQueja[$o]."</td>";
									echo "<td width='10px'> </td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
								///SOLICITANTE
									echo "<td width='150px' align='left' valign='top'>".$quejosoUsr[$o]."</td>";
									echo "<td width='10px'> </td>";
								///PDR
									echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='9'> </td></tr>";
								
							}
						echo "</table>";
						
					}
					
				}
				
			}
			
			if($bandera == 0){
				
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'><td> </td></tr>";
					echo"<tr>";
						echo"<td align='center' id='titulo12'><i>No hay Quejas</i></td>";
					echo"</tr>";
				echo "</table>";
				
			}
			
			
		} else if($categoriaUsr == "Administrador"){
			
			$mesNombre[1] 	= "Enero";
			$mesNombre[2] 	= "Febrero";
			$mesNombre[3] 	= "Marzo";
			$mesNombre[4] 	= "Abril";
			$mesNombre[5] 	= "Mayo";
			$mesNombre[6] 	= "Junio";
			$mesNombre[7] 	= "Julio";
			$mesNombre[8] 	= "Agosto";
			$mesNombre[9] 	= "Septiembre";
			$mesNombre[10] 	= "Octubre";
			$mesNombre[11] 	= "Noviembre";
			$mesNombre[12] 	= "Diciembre";

			$estatusSol[1]	= "Sin asignar";
			$estatusSol[2]	= "Asignada";
			$estatusSol[3]	= "Para revisión";
			$estatusSol[4]	= "Rechazada";
			$estatusSol[5]	= "Terminada";
			
			$estatusQue[1]	= "Sin asignar";
			$estatusQue[2]	= "Asignada";
			$estatusQue[3]	= "Evaluación Inicial";
			$estatusQue[4]	= "Investigación";
			$estatusQue[5]	= "Respuesta";
			$estatusQue[6]	= "Comunicación";
			$estatusQue[7]	= "Cierre";
			
			$currentYear  = date('Y');
			$currentMonth = date('m');
			
			if($_POST['ciudad'] != ""){
				$i = 1;
				foreach($_POST['ciudad'] as $city){
					$cdElegida[$i] = $city;
					$i++;
				}
				
			} else{
				$cdElegida = NULL;
			}
			
			if($_POST['anio'] != ""){
				$anio = $_POST['anio'];
			} else{
				$anio = $currentYear;
			}
			
			if($_POST['mes'] != ""){
				$mes = $_POST['mes'];
			} else{
				$mes = $currentMonth;
			}
			
			if($_POST['estSol'] != ""){
				$i = 1;
				foreach($_POST['estSol'] as $statSol){
					$estSolElegida[$i] = $statSol;
					$i++;
				}
				
			} else{
				$estSolElegida = NULL;
			}
			
			if($_POST['estQue'] != ""){
				$i = 1;
				foreach($_POST['estQue'] as $statQue){
					$estQueElegida[$i] = $statQue;
					$i++;
				}
				
			} else{
				$estQueElegida = NULL;
			}
			
			if($_POST['pdr'] != ""){
				$pdrFiltro = $_POST['pdr'];
			} else{
				$pdrFiltro = "Todos";
			}
		////////////////////////////////
		///CASO SIN OPCIONES ELEGIDAS///
		////////////////////////////////
			if($cdElegida == NULL){
			///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
				echo "<table border='0' align='center' width='770px' id='ocultar' style='display:block;'>";
					echo"<tr>";
						echo"<td align='left' id='iconosTexto2' onClick='show(1);' width='770px'>Filtrar</td>";
					echo"</tr>";
				echo"</table>";
			///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
				echo "<table border='0' align='center' width='770px' id='mostrar' style='display:none;'>";
					echo"<tr>";
						echo"<td colspan='6' align='left' id='iconosTexto2' onClick='show(0);'>Filtrar</td>";
					echo"</tr>";
					
					echo"<tr height='10px'><td colspan='6'> </td></tr>";
				///CATEGORIAS DE LOS FILTROS
					echo "<tr id='iconosTexto3'>";
						echo "<td align='left' width='130px' >Ciudad</td>";
						echo "<td align='left' width='80px' >Año</td>";
						echo "<td align='left' width='130px' >Mes</td>";
						echo "<td align='left' width='130px' >Solicitud</td>";
						echo "<td align='left' width='150px' >Quejas</td>";
						echo "<td align='left' width='150px' >PDR</td>";
					echo "</tr>";
						
					echo"<tr height='10px'><td colspan='6'> </td></tr>";
					
					echo "<tr>";
						echo "<td id='breadcrumbs' valign='top'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
						for($a = 1; $a <= 6; $a++){
							if(in_array($cdValor[$a],$ciudadesDisponibles)){
								echo"<input type='checkbox' name='ciudad[]' value='".$cdValor[$a]."' checked='checked'>".$ciudades[$a]."<br>";
							}
						}
						echo"</td>";
					///OPCIONES PARA AÑOS
						echo "<td id='breadcrumbs' valign='top'>";
						
							echo "<select name='anio'>";
								echo "<option value='".$anio."' selected='selected'>".$anio."</option>";
								///Muestra solo 5 años, del actual y los cuatro anteriores consecutivos
								for($o = $currentYear; $o >= ($currentYear-4); $o--){
									if($anio != $o){
										echo "<option value='".$o."'>".$o."</option>";
									}
								} unset($o);
								
							echo "</select>";
							
						echo"</td>";
					///OPCIONES PARA MESES
						echo "<td id='breadcrumbs' valign='top'>";
						
							echo "<select name='mes'>";
								///Muestra los meses consecutivamente
								for($o = 1; $o <= 12; $o++){
									if($mes != $o){
										echo "<option value='".$o."'>".$mesNombre[$o]."</option>";
									} else if($mes == $o && $mes != 'Todos'){
										echo "<option value='".$o."' selected='selected'>".$mesNombre[$o]."</option>";
									}
								} unset($o);
								
								if($mes == 'Todos'){
									echo "<option value='Todos' selected='selected'>Todos</option>";
								} else{
									echo "<option value='Todos'>Todos</option>";
								}
								
							echo "</select>";
								
						echo"</td>";
					///OPCIONES SOLICITUDES
						echo "<td id='breadcrumbs' valign='top'>";
							for($a = 1; $a <= 5; $a++){
								echo"<input type='checkbox' name='estSol[]' value='".$estatusSol[$a]."' checked='checked'>".$estatusSol[$a]."<br>";
							}
						echo"</td>";
					///OPCIONES PARA QUEJAS
						echo "<td id='breadcrumbs' valign='top'>";
							for($a = 1; $a <= 7; $a++){
								echo"<input type='checkbox' name='estQue[]' value='".$estatusQue[$a]."' checked='checked'>".$estatusQue[$a]."<br>";
							}
							
						echo"</td>";
					///OPCIONES PARA CATEGORIA TRATAMIENTO
						echo "<td id='breadcrumbs' valign='top'>";
							echo "<select name='pdr'>";
								
								$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno 
														FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
														WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad = 'PDR' ");
									
								while($r= $s -> fetchRow()){
									
									echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
									
								} unset($r); unset ($s);
								
								if($pdrFiltro == "Todos"){
									echo"<option value='Todos' selected='selected'>Todos</option>";
									
								} else{
									echo"<option value='Todos'>Todos</option>";
								}
							echo"</select>";
						echo"</td>";
			
					echo "</tr>";
					
					echo"<tr height='20px'><td colspan='6'> </td></tr>";
					
					echo"<tr>";
						echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>";
					echo"</tr>";
				echo"</table>";
				
				
				///SOLICITUDES
				echo "<table border='0' align='center'>";
					echo "<tr height='30px'><td ></td></tr>";
					
					echo"<tr>";
						echo"<td align='center' id='titulo2'>Solicitudes</td>";
					echo"</tr>";
				echo "</table>";
				
				$bandera = 0;
				
				///RECORREMOS LAS CIUDADES
				for($a = 1; $a <= 6; $a++){
					///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
					if(in_array($cdValor[$a], $ciudadesDisponibles)){
						
						$solicitudID 		= NULL;
						$claveSolicitud 	= NULL;
						$tituloSolicitud 	= NULL;
						$fechaSolicitud 	= NULL;
						$solicitanteUsr		= NULL;
						$status 			= NULL;
						$pdr				= NULL;
						
						$i = 1;
						///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
						$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
												FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$cdValor[$a]' AND SQS.xt_tipo = 'B' 
												AND YEAR(SQS.xd_fecha) = $currentYear AND MONTH(SQS.xd_fecha) = $currentMonth 
												ORDER BY xt_claveQuejaSolicitud DESC ");
												
						while($r = $s->fetchRow($s)){
							
							$solicitudID[$i] 		= $r[0];
							$claveSolicitud[$i] 	= $r[1];
							$tituloSolicitud[$i] 	= $r[2];
							$fechaSolicitud[$i] 	= date('Y-m-d', strtotime($r[3]));
							
							if($r[4] != ""){
								
								$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
								
								while($t = $u->fetchRow()){
									
									$solicitanteUsr[$i] = $t[0]." ".$t[1];
									
								} unset($t);
								
							} else{
								
								$solicitanteUsr[$i] = "";
								
							}
							
							$status[$i] 			= "";
							$pdr[$i]				= "";
							
							if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $solicitudID[$i] AND xt_tipoOrigen = 'B' ")){
								
								$u = $INTRANET->Execute("SELECT SQSE.xt_estatus, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
														FROM SGI_Seguimientos SGU, SGI_Quejas_Solicitudes_Estatus SQSE, SGI_Empleados SEM 
														WHERE SGU.kf_itemOrigenID = $solicitudID[$i] AND SGU.xt_tipoOrigen = 'B' 
														AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID 
														AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_numero ASC ");
								
								while($t = $u->fetchRow()){
									
									$status[$i] 		= $t[0];
									$fechaSolicitud[$i] = date('Y-m-d', strtotime($t[1]));
									$pdr[$i] 			= $t[2]." ".$t[3];
									
								} unset($t);
								
								if(		  $status[$i] == "ABIERTA"){
									$status[$i] = "Asignada";
									
								} else if($status[$i] == "REVISION"){
									$status[$i] = "Para Revisión";
									
								} else if($status[$i] == "RECHAZADA"){
									$status[$i] = "Rechazada";
									
								} else if($status[$i] == "TERMINADA"){
									$status[$i] = "Terminada";
									
								}
								
							}
							
							$i++;
							
						}
					
					}
					///SI HUBO RESULTADOS IMPRIME LA TABLA
					if(count($solicitudID) >= 1){
						
						$bandera = 1;
						
						if(in_array($cdValor[$a],$ciudadesDisponibles)){
							echo "<table border='0' align='center' width='1030px'>";
							
								echo "<tr height='10px'><td> </td></tr>";
								
								echo "<tr>";
									echo "<td id='titulo2Blanco' align='left' width='1030px'>".$ciudades[$a]."</td>";
								echo "</tr>";
								
							echo "</table>";
							
							echo "<table border='0' align='center'  width='1030px'>";
							///CABECERA		
								echo"<tr id='titulo2'>";
									echo "<td width='30px'> </td>";
									echo "<td width='100px' align='center'>Código</td>";
									echo "<td width='380px' align='left'>Título</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='80px' align='center'>Fecha</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='110px' align='left'>Status</td>";
									echo "<td width='150px' align='left'>Solicitante</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='150px' align='left'>PDR</td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td> </td>";
									echo "<td colspan='9' id='titleBlueLineTop'></td>";
								echo "</tr>";
								
								echo"<tr height='10px'><td colspan='10'> </td></tr>";
							echo "</table>";
							
							echo "<table border='0' align='center' width='1030px'>";
								for($o = 1; $o <= count($solicitudID); $o++){
									
									echo "<tr height='25' id='fileItem'>";
										echo "<td width='30px'> </td>";
									///CLAVE Y VINCULO A LA SOLICITUD			
										echo "<td width='100px' align='center' valign='top'>"; 
											echo "<a href='fichaSolicitud.php?id=".$solicitudID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveSolicitud[$o]."</a>";
										echo "</td>";
									///TITULO SOLICITUD	
										echo "<td width='380px' align='left' valign='top'>".$tituloSolicitud[$o]."</td>";
										echo "<td width='10px'> </td>";
									///FECHA
										echo "<td width='80px' align='center' valign='top'>".$fechaSolicitud[$o]."</td>";
										echo "<td width='10px'> </td>";
									///STATUS EN BASE A LAS ETAPAS
										echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
									///SOLICITANTE
										echo "<td width='150px' align='left' valign='top'>".$solicitanteUsr[$o]."</td>";
										echo "<td width='10px'> </td>";
									///PDR
										echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='10'> </td></tr>";
									
								}
							echo "</table>";
							
						}
						
					}
					
				}
				
				if($bandera == 0){
					
					echo "<table border='0' align='center'>";
						echo "<tr height='20px'><td> </td></tr>";
						echo"<tr>";
							echo"<td align='center' id='titulo12'<i>No hay Solicitudes</i></td>";
						echo"</tr>";
					echo "</table>";
					
				}
					
				///QUEJAS
				echo "<table border='0' align='center'>";
					echo "<tr height='70px'><td> </td></tr>";
					echo"<tr>";
						echo"<td align='center' id='titulo2'>Quejas</td>";
					echo"</tr>";
				echo "</table>";
				
				$bandera = 0;
				
				///RECORREMOS LAS CIUDADES
				for($a = 1; $a <= 6; $a++){
					///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
					if(in_array($cdValor[$a], $ciudadesDisponibles)){
						
						$quejaID 		= NULL;
						$claveQueja 	= NULL;
						$tituloQueja 	= NULL;
						$fechaQueja 	= NULL;
						$quejosoUsr		= NULL;
						$status 		= NULL;
						$pdr			= NULL;
						
						$i = 1;
						///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
						$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
												FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$cdValor[$a]' AND SQS.xt_tipo = 'C' 
												AND YEAR(SQS.xd_fecha) = $currentYear AND MONTH(SQS.xd_fecha) = $currentMonth 
												ORDER BY xt_claveQuejaSolicitud DESC ");
												
						while($r = $s->fetchRow($s)){
							
							$quejaID[$i] 		= $r[0];
							$claveQueja[$i] 	= $r[1];
							$tituloQueja[$i] 	= $r[2];
							$fechaQueja[$i] 	= date('Y-m-d', strtotime($r[3]));
							
							if($r[4] != ""){
								
								$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
								
								while($t = $u->fetchRow()){
									
									$quejosoUsr[$i] = $t[0]." ".$t[1];
									
								} unset($t);
								
							} else{
								
								$quejosoUsr[$i] = "";
								
							}
							
							$status[$i] 			= "";
							$pdr[$i]				= "";
							
							if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $quejaID[$i] AND xt_tipoOrigen = 'C' ")){
								
								$u = $INTRANET->Execute("SELECT SQSE.xn_etapa, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
														FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SQSE, SGI_Empleados SEM 
														WHERE SGU.kf_itemOrigenID = $quejaID[$i] AND SGU.xt_tipoOrigen = 'C' 
														AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID
														AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_etapa ASC");
								
								while($t = $u->fetchRow()){
									
									$status[$i] 		= $t[0];
									$fechaQueja[$i] 	= date('Y-m-d', strtotime($t[1]));
									$pdr[$i] 			= $t[2]." ".$t[3];
									
								} unset($t);
								
								if(		  $status[$i] == 1){
									$status[$i] = "Asignada";
									
								} else if($status[$i] == 2){
									$status[$i] = "Evaluación Inicial";
									
								} else if($status[$i] == 3){
									$status[$i] = "Investigación";
									
								} else if($status[$i] == 4){
									$status[$i] = "Respuesta";
									
								} else if($status[$i] == 5){
									$status[$i] = "Comunicación";
									
								} else if($status[$i] == 6){
									$status[$i] = "Cierre";
									
								}
								
							}
							
							$i++;
							
						}
					
					}
					///SI HUBO RESULTADOS IMPRIME LA TABLA
					if(count($quejaID) >= 1){
						
						$bandera = 1;
						
						if(in_array($cdValor[$a], $ciudadesDisponibles)){
							echo "<table border='0' align='center' width='1030px'>";
							
								echo "<tr height='10px'><td> </td></tr>";
								
								echo "<tr>";
									echo "<td id='titulo2Blanco' align='left' width='1030px'>".$ciudades[$a]."</td>";
								echo "</tr>";
								
							echo "</table>";
							
							echo "<table border='0' align='center'  width='1030px'>";
							///CABECERA		
								echo"<tr id='titulo2'>";
									echo "<td width='30px'> </td>";
									echo "<td width='100px' align='center'>Código</td>";
									echo "<td width='380px' align='left'>Título</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='80px' align='center'>Fecha</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='110px' align='left'>Status</td>";
									echo "<td width='150px' align='left'>Solicitante</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='150px' align='left'>PDR</td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td> </td>";
									echo "<td colspan='9' id='titleBlueLineTop'></td>";
								echo "</tr>";
								
								echo"<tr height='10px'><td colspan='10'> </td></tr>";
							echo "</table>";
							
							echo "<table border='0' align='center' width='1030px'>";
								for($o = 1; $o <= count($quejaID); $o++){
									
									echo "<tr height='25' id='fileItem'>";
										echo "<td width='30px'> </td>";
									///CLAVE Y VINCULO A LA SOLICITUD			
										echo "<td width='100px' align='center' valign='top'>"; 
											echo "<a href='fichaQueja.php?id=".$quejaID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveQueja[$o]."</a>";
										echo "</td>";
									///TITULO SOLICITUD	
										echo "<td width='380px' align='left' valign='top'>".$tituloQueja[$o]."</td>";
										echo "<td width='10px'> </td>";
									///FECHA
										echo "<td width='80px' align='center' valign='top'>".$fechaQueja[$o]."</td>";
										echo "<td width='10px'> </td>";
									///STATUS EN BASE A LAS ETAPAS
										echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
									///SOLICITANTE
										echo "<td width='150px' align='left' valign='top'>".$quejosoUsr[$o]."</td>";
										echo "<td width='10px'> </td>";
									///PDR
										echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='9'> </td></tr>";
									
								}
							echo "</table>";
							
						}
						
					}
					
				}
				
				if($bandera == 0){
					
					echo "<table border='0' align='center'>";
						echo "<tr height='20px'><td> </td></tr>";
						echo"<tr>";
							echo"<td align='center' id='titulo12'><i>No hay Quejas</i></td>";
						echo"</tr>";
					echo "</table>";
					
				}
		
		////////////////////////////////
		///CASO CON OPCIONES ELEGIDAS///
		////////////////////////////////
			} else{
			///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
				echo "<table border='0' align='center' width='770px' id='ocultar' style='display:block;'>";
					echo"<tr>";
						echo"<td align='left' id='iconosTexto2' onClick='show(1);' width='770px'>Filtrar</td>";
					echo"</tr>";
				echo"</table>";
			///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
				echo "<table border='0' align='center' width='770px' id='mostrar' style='display:none;'>";
					echo"<tr>";
						echo"<td colspan='6' align='left' id='iconosTexto2' onClick='show(0);'>Filtrar</td>";
					echo"</tr>";
					
					echo"<tr height='10px'><td colspan='6'> </td></tr>";
				///CATEGORIAS DE LOS FILTROS
					echo "<tr id='iconosTexto3'>";
						echo "<td align='left' width='130px' >Ciudad</td>";
						echo "<td align='left' width='80px' >Año</td>";
						echo "<td align='left' width='130px' >Mes</td>";
						echo "<td align='left' width='130px' >Solicitud</td>";
						echo "<td align='left' width='150px' >Quejas</td>";
						echo "<td align='left' width='150px' >PDR</td>";
				///INPUT QUE INDICA QUE EL FILTRO HA SIDO ACTIVADO
				echo "<input type='hidden' name='filtro' value='1'>";
					echo "</tr>";
						
					echo"<tr height='10px'><td colspan='6'> </td></tr>";
					
					echo "<tr>";
						echo "<td id='breadcrumbs' valign='top'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									if(in_array($cdValor[$a], $cdElegida)){
										echo"<input type='checkbox' name='ciudad[]' value='".$cdValor[$a]."' checked='checked'>$ciudades[$a]<br>";
									} else{
										echo"<input type='checkbox' name='ciudad[]' value='".$cdValor[$a]."'>$ciudades[$a]<br>";
									}
									
								}
							}
						echo"</td>";
					///OPCIONES PARA AÑOS
						echo "<td id='breadcrumbs' valign='top'>";
						
							echo "<select name='anio'>";
								///Muestra solo 5 años, del actual y los cuatro anteriores consecutivos
								for($o = $currentYear; $o >= ($currentYear-4); $o--){
									if($anio != $o){
										echo "<option value='".$o."'>".$o."</option>";
									} else if($anio == $o){
										echo "<option value='".$o."' selected='selected'>".$o."</option>";
									}
								} unset($o);
								
							echo "</select>";
							
						echo"</td>";
					///OPCIONES PARA MESES
						echo "<td id='breadcrumbs' valign='top'>";
						
							echo "<select name='mes'>";
								///Muestra los meses consecutivamente
								for($o = 1; $o <= 12; $o++){
									if($mes != $o){
										echo "<option value='".$o."'>".$mesNombre[$o]."</option>";
									} else if($mes == $o && $mes != 'Todos'){
										echo "<option value='".$o."' selected='selected'>".$mesNombre[$o]."</option>";
									}
								} unset($o);
								
								if($mes == 'Todos'){
									echo "<option value='Todos' selected='selected'>Todos</option>";
								} else{
									echo "<option value='Todos'>Todos</option>";
								}
								
							echo "</select>";
								
						echo"</td>";
					///OPCIONES SOLICITUDES
						echo "<td id='breadcrumbs' valign='top'>";
							if($estSolElegida != NULL){
								for($a = 1; $a <= 5; $a++){
									if(in_array($estatusSol[$a], $estSolElegida)){
										echo"<input type='checkbox' name='estSol[]' value='".$estatusSol[$a]."' checked='checked'>".$estatusSol[$a]."<br>";
									} else{
										echo"<input type='checkbox' name='estSol[]' value='".$estatusSol[$a]."' >".$estatusSol[$a]."<br>";
									}
								}
						///SI NO HUBO VALORES
							} else{
								for($a = 1; $a <= 5; $a++){
									echo"<input type='checkbox' name='categoriaI[]' value='".$estatusSol[$a]."' checked='checked'>".$estatusSol[$a]."<br>";
								}
							}
						echo"</td>";
					///OPCIONES PARA QUEJAS
						echo "<td id='breadcrumbs' valign='top'>";
							if($estQueElegida != NULL){
								for($a = 1; $a <= 7; $a++){
									if(in_array($estatusQue[$a], $estQueElegida)){
										echo"<input type='checkbox' name='estQue[]' value='".$estatusQue[$a]."' checked='checked'>".$estatusQue[$a]."<br>";
									} else{
										echo"<input type='checkbox' name='estQue[]' value='".$estatusQue[$a]."' >".$estatusQue[$a]."<br>";
									}
								}
						///SI NO HUBO VALORES
							} else{
								for($a = 1; $a <= 7; $a++){
									echo"<input type='checkbox' name='estQue[]' value='".$estatusQue[$a]."' checked='checked'>".$estatusQue[$a]."<br>";
								}
							}
							
						echo"</td>";
					///OPCIONES PARA CATEGORIA TRATAMIENTO
						echo "<td id='breadcrumbs' valign='top'>";
							echo "<select name='pdr'>";
								
								$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno 
														FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
														WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad = 'PDR' ");
									
								while($r= $s -> fetchRow()){
									if($pdrFiltro == $r[0]){
										echo"<option value='".$r[0]."' selected='selected'>".$r[1]." ".$r[2]."</option>";
									} else{
										echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
									}
									
								} unset($r); unset ($s);
								
								if($pdrFiltro == "Todos"){
									echo"<option value='Todos' selected='selected'>Todos</option>";
									
								} else{
									echo"<option value='Todos'>Todos</option>";
								}
							echo"</select>";
						echo"</td>";
			
					echo "</tr>";
					
					echo"<tr height='20px'><td colspan='6'> </td></tr>";
					
					echo"<tr>";
						echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>";
					echo"</tr>";
				echo"</table>";
				
				
				///SOLICITUDES
				echo "<table border='0' align='center'>";
					echo "<tr height='30px'><td ></td></tr>";
					
					echo"<tr>";
						echo"<td align='center' id='titulo2'>Solicitudes</td>";
					echo"</tr>";
				echo "</table>";
				
				$bandera = 0;
				
				///RECORREMOS LAS CIUDADES
				foreach($_POST['ciudad'] as $city){
					
					for($a = 1; $a <= 6; $a++){
						if($cdValor[$a] == $city){
							$cityShow = $ciudades[$a];
						}
					}
					
					///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
					if(in_array($city, $ciudadesDisponibles)){
						
						$solicitudID 		= NULL;
						$claveSolicitud 	= NULL;
						$tituloSolicitud 	= NULL;
						$fechaSolicitud 	= NULL;
						$solicitanteUsr		= NULL;
						$status 			= NULL;
						$pdr				= NULL;
						
						$i = 1;
						///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
						///DEPENDIENDO DEL AÑO Y MES ELEGIDO
						if($mes != "Todos"){
							$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
													FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$city' AND SQS.xt_tipo = 'B' 
													AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes 
													ORDER BY xt_claveQuejaSolicitud DESC ");
						} else{
							$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
													FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$city' AND SQS.xt_tipo = 'B' 
													AND YEAR(SQS.xd_fecha) = $anio 
													ORDER BY xt_claveQuejaSolicitud DESC ");
						}
						
						while($r = $s->fetchRow($s)){
							
							$solicitudID[$i] 		= $r[0];
							$claveSolicitud[$i] 	= $r[1];
							$tituloSolicitud[$i] 	= $r[2];
							$fechaSolicitud[$i] 	= date('Y-m-d', strtotime($r[3]));
							
							if($r[4] != ""){
								
								$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
								
								while($t = $u->fetchRow()){
									
									$solicitanteUsr[$i] = $t[0]." ".$t[1];
									
								} unset($t);
								
							} else{
								
								$solicitanteUsr[$i] = "";
								
							}
							
							$status[$i] 			= "";
							$pdr[$i]				= "";
							
							if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $solicitudID[$i] AND xt_tipoOrigen = 'B' ")){
								
								$u = $INTRANET->Execute("SELECT SQSE.xt_estatus, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
														FROM SGI_Seguimientos SGU, SGI_Quejas_Solicitudes_Estatus SQSE, SGI_Empleados SEM 
														WHERE SGU.kf_itemOrigenID = $solicitudID[$i] AND SGU.xt_tipoOrigen = 'B' 
														AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID 
														AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_numero ASC ");
								
								while($t = $u->fetchRow()){
									
									$status[$i] 		= $t[0];
									$fechaSolicitud[$i] = date('Y-m-d', strtotime($t[1]));
									$pdr[$i] 			= $t[2]." ".$t[3];
									
								} unset($t);
								
								if(		  $status[$i] == "ABIERTA"){
									$status[$i] = "Asignada";
									
								} else if($status[$i] == "REVISION"){
									$status[$i] = "Para Revisión";
									
								} else if($status[$i] == "RECHAZADA"){
									$status[$i] = "Rechazada";
									
								} else if($status[$i] == "TERMINADA"){
									$status[$i] = "Terminada";
									
								}
								
							}
							
							$i++;
							
						}
					
					}
					///SI HUBO RESULTADOS IMPRIME LA TABLA
					if(count($solicitudID) >= 1){
						
						$bandera = 1;
						
						if(in_array($city, $ciudadesDisponibles)){
							echo "<table border='0' align='center' width='1030px'>";
							
								echo "<tr height='10px'><td> </td></tr>";
								
								echo "<tr>";
									echo "<td id='titulo2Blanco' align='left' width='1030px'>".$cityShow."</td>";
								echo "</tr>";
								
							echo "</table>";
							
							echo "<table border='0' align='center'  width='1030px'>";
							///CABECERA		
								echo"<tr id='titulo2'>";
									echo "<td width='30px'> </td>";
									echo "<td width='100px' align='center'>Código</td>";
									echo "<td width='380px' align='left'>Título</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='80px' align='center'>Fecha</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='110px' align='left'>Status</td>";
									echo "<td width='150px' align='left'>Solicitante</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='150px' align='left'>PDR</td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td> </td>";
									echo "<td colspan='9' id='titleBlueLineTop'></td>";
								echo "</tr>";
								
								echo"<tr height='10px'><td colspan='10'> </td></tr>";
							echo "</table>";
							
							echo "<table border='0' align='center' width='1030px'>";
								for($o = 1; $o <= count($solicitudID); $o++){
									
									echo "<tr height='25' id='fileItem'>";
										echo "<td width='30px'> </td>";
									///CLAVE Y VINCULO A LA SOLICITUD			
										echo "<td width='100px' align='center' valign='top'>"; 
											echo "<a href='fichaSolicitud.php?id=".$solicitudID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveSolicitud[$o]."</a>";
										echo "</td>";
									///TITULO SOLICITUD	
										echo "<td width='380px' align='left' valign='top'>".$tituloSolicitud[$o]."</td>";
										echo "<td width='10px'> </td>";
									///FECHA
										echo "<td width='80px' align='center' valign='top'>".$fechaSolicitud[$o]."</td>";
										echo "<td width='10px'> </td>";
									///STATUS EN BASE A LAS ETAPAS
										echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
									///SOLICITANTE
										echo "<td width='150px' align='left' valign='top'>".$solicitanteUsr[$o]."</td>";
										echo "<td width='10px'> </td>";
									///PDR
										echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='10'> </td></tr>";
									
								}
							echo "</table>";
							
						}
						
					}
					
				}
				
				if($bandera == 0){
					
					echo "<table border='0' align='center'>";
						echo "<tr height='20px'><td> </td></tr>";
						echo"<tr>";
							echo"<td align='center' id='titulo12'<i>No hay Solicitudes</i></td>";
						echo"</tr>";
					echo "</table>";
					
				}
					
				///QUEJAS
				echo "<table border='0' align='center'>";
					echo "<tr height='70px'><td> </td></tr>";
					echo"<tr>";
						echo"<td align='center' id='titulo2'>Quejas</td>";
					echo"</tr>";
				echo "</table>";
				
				$bandera = 0;
				
				///RECORREMOS LAS CIUDADES
				foreach($_POST['ciudad'] as $city){
					
					for($a = 1; $a <= 6; $a++){
						if($cdValor[$a] == $city){
							$cityShow = $ciudades[$a];
						}
					}
					///PERO SOLO LAS QUE EL USUARIO TENGA DISPONIBLES
					if(in_array($city, $ciudadesDisponibles)){
						
						$quejaID 		= NULL;
						$claveQueja 	= NULL;
						$tituloQueja 	= NULL;
						$fechaQueja 	= NULL;
						$quejosoUsr		= NULL;
						$status 		= NULL;
						$pdr			= NULL;
						
						$i = 1;
						///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
						if($mes != "Todos"){
							$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
													FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$city' AND SQS.xt_tipo = 'C' 
													AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes 
													ORDER BY xt_claveQuejaSolicitud DESC ");
						} else{
							$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId 
													FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_ciudad = '$city' AND SQS.xt_tipo = 'C' 
													AND YEAR(SQS.xd_fecha) = $anio 
													ORDER BY xt_claveQuejaSolicitud DESC ");
						}
												
						while($r = $s->fetchRow($s)){
							
							$quejaID[$i] 		= $r[0];
							$claveQueja[$i] 	= $r[1];
							$tituloQueja[$i] 	= $r[2];
							$fechaQueja[$i] 	= date('Y-m-d', strtotime($r[3]));
							
							if($r[4] != ""){
								
								$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
								
								while($t = $u->fetchRow()){
									
									$quejosoUsr[$i] = $t[0]." ".$t[1];
									
								} unset($t);
								
							} else{
								
								$quejosoUsr[$i] = "";
								
							}
							
							$status[$i] 			= "";
							$pdr[$i]				= "";
							
							if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $quejaID[$i] AND xt_tipoOrigen = 'C' ")){
								
								$u = $INTRANET->Execute("SELECT SQSE.xn_etapa, SQSE.xd_fecha, SEM.xt_Nombre, SEM.xt_ApellidoPaterno 
														FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SQSE, SGI_Empleados SEM 
														WHERE SGU.kf_itemOrigenID = $quejaID[$i] AND SGU.xt_tipoOrigen = 'C' 
														AND SGU.kp_seguimientoID = SQSE.kf_seguimientoID
														AND SGU.kf_pdrID = SEM.kp_personalId ORDER BY SQSE.xn_etapa ASC");
								
								while($t = $u->fetchRow()){
									
									$status[$i] 		= $t[0];
									$fechaQueja[$i] 	= date('Y-m-d', strtotime($t[1]));
									$pdr[$i] 			= $t[2]." ".$t[3];
									
								} unset($t);
								
								if(		  $status[$i] == 1){
									$status[$i] = "Asignada";
									
								} else if($status[$i] == 2){
									$status[$i] = "Evaluación Inicial";
									
								} else if($status[$i] == 3){
									$status[$i] = "Investigación";
									
								} else if($status[$i] == 4){
									$status[$i] = "Respuesta";
									
								} else if($status[$i] == 5){
									$status[$i] = "Comunicación";
									
								} else if($status[$i] == 6){
									$status[$i] = "Cierre";
									
								}
								
							}
							
							$i++;
							
						}
					
					}
					///SI HUBO RESULTADOS IMPRIME LA TABLA
					if(count($quejaID) >= 1){
						
						$bandera = 1;
						
						if(in_array($city, $ciudadesDisponibles)){
							echo "<table border='0' align='center' width='1030px'>";
							
								echo "<tr height='10px'><td> </td></tr>";
								
								echo "<tr>";
									echo "<td id='titulo2Blanco' align='left' width='1030px'>".$cityShow."</td>";
								echo "</tr>";
								
							echo "</table>";
							
							echo "<table border='0' align='center'  width='1030px'>";
							///CABECERA		
								echo"<tr id='titulo2'>";
									echo "<td width='30px'> </td>";
									echo "<td width='100px' align='center'>Código</td>";
									echo "<td width='380px' align='left'>Título</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='80px' align='center'>Fecha</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='110px' align='left'>Status</td>";
									echo "<td width='150px' align='left'>Solicitante</td>";
									echo "<td width='10px'> </td>";
									echo "<td width='150px' align='left'>PDR</td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td> </td>";
									echo "<td colspan='9' id='titleBlueLineTop'></td>";
								echo "</tr>";
								
								echo"<tr height='10px'><td colspan='10'> </td></tr>";
							echo "</table>";
							
							echo "<table border='0' align='center' width='1030px'>";
								for($o = 1; $o <= count($quejaID); $o++){
									
									echo "<tr height='25' id='fileItem'>";
										echo "<td width='30px'> </td>";
									///CLAVE Y VINCULO A LA SOLICITUD			
										echo "<td width='100px' align='center' valign='top'>"; 
											echo "<a href='fichaQueja.php?id=".$quejaID[$o]."' id='fileItem' style='text-decoration:none;'>".$claveQueja[$o]."</a>";
										echo "</td>";
									///TITULO SOLICITUD	
										echo "<td width='380px' align='left' valign='top'>".$tituloQueja[$o]."</td>";
										echo "<td width='10px'> </td>";
									///FECHA
										echo "<td width='80px' align='center' valign='top'>".$fechaQueja[$o]."</td>";
										echo "<td width='10px'> </td>";
									///STATUS EN BASE A LAS ETAPAS
										echo "<td width='110px' align='left' valign='top'>".$status[$o]."</td>";
									///SOLICITANTE
										echo "<td width='150px' align='left' valign='top'>".$quejosoUsr[$o]."</td>";
										echo "<td width='10px'> </td>";
									///PDR
										echo "<td width='150px' align='left' valign='top'>".$pdr[$o]."</td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='9'> </td></tr>";
									
								}
							echo "</table>";
							
						}
						
					}
					
				}
				
				if($bandera == 0){
					
					echo "<table border='0' align='center'>";
						echo "<tr height='20px'><td> </td></tr>";
						echo"<tr>";
							echo"<td align='center' id='titulo12'><i>No hay Quejas</i></td>";
						echo"</tr>";
					echo "</table>";
					
				}

			}
		}
	
		echo "<table border='0' align='center'>";
			echo "<tr height='50px'><td> </td></tr>";
		echo"</table>";
		
	echo "</form>";
	echo "</div>";
?>

</body>
</html>


	 