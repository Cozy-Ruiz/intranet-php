<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio F. García Robles
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='fichaSolicitudModificar.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

if($_GET['id'] != ""){
	$solicitudID = $_GET['id'];
	
} else if($_POST['id'] != ""){
	$solicitudID = $_POST['id'];
	
}

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a>";
			
///
if($_POST['modificar'] == ""){
	
	///DATOS DE LA SOLICITUD
	$clave 				= "";
	$titulo 			= "";
	$descripcion 		= "";
	$ruta 				= "";
	$solicitanteID 		= "";
	$fechaSolicitud 	= "";
	$nombreSolicitante	= "";
	$apllPaSolicitante 	= "";
	$apllMaSolicitante 	= "";
	
	$s = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, xt_ruta, kf_usuarioId, xd_fecha FROM SGI_Quejas_Solicitudes 
							WHERE kp_quejaSolicitudID = $solicitudID AND xt_tipo = 'B' ");
	
	while($r = $s->fetchRow()){
		$clave 				= $r[0];
		$titulo 			= $r[1];
		$descripcion 		= nl2br ($r[2]);
		$ruta 				= $r[3];
		$solicitanteID 		= $r[4];
		
		if($solicitanteID != ""){
			
			$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$solicitanteID' ");
			
			while($t = $u->fetchRow()){
				$nombreSolicitante = $t[0];
				$apllPaSolicitante = $t[1];
				$apllMaSolicitante = $t[2];
				$solEmpId		   = $t[3];
				
			} unset($t); unset($u);
			
		}
		
		$fechaSolicitud 	= date('Y-m-d', strtotime($r[5]));
		
	} unset($r); unset($s);
	
	
	///PDR
	$pdrNombre 	= "";
	$pdrApPate 	= "";
	$pdrApMate 	= "";
	$pdrUserId 	= "";
	$pdrID		= "";
		
	$s = $INTRANET->Execute("SELECT SEM.xt_Nombre, SEM.xt_ApellidoPaterno, SEM.xt_ApellidoMaterno, SEM.kf_usuario, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Empleados SEM 
							WHERE SGU.xt_tipoOrigen = 'B' AND SGU.kf_itemOrigenID = $solicitudID AND SEM.kp_personalId = SGU.kf_pdrID ");
	
	while($r = $s->fetchRow()){
		$pdrNombre 	= $r[0];
		$pdrApPate 	= $r[1];
		$pdrApMate 	= $r[2];
		$pdrUserId 	= $r[3];
		$pdrID		= $r[4];
		
	} unset($r); unset($s);
	
	
	///AUDITORIA ISSUE
	$auditoriaID 		= "";
	$auditoriaCodigo 	= "";
	$issueID 			= "";
	$issueCodigo 		= "";
	
	$s = $INTRANET->Execute("SELECT A.kp_auditoriaID, A.xt_claveAuditoria, AI.kp_issueID, AI.xt_claveIssue FROM SGI_Auditorias_Issues AI, SGI_Auditorias A 
							WHERE AI.xt_claveIssue = '$clave' AND AI.kf_auditoriaID = A.kp_auditoriaID ");
							
	while($r = $s->fetchRow()){
		$auditoriaID 		= $r[0];
		$auditoriaCodigo 	= $r[1];
		$issueID 			= $r[2];
		$issueCodigo 		= $r[3];
		
	} unset($r); unset($s);
	
	
	///SEGUIMIENTO
	$codigo = "";
	$id 	= "";
	
	$s = $INTRANET->Execute("SELECT xt_codigoSeguimiento, kp_seguimientoID FROM SGI_Seguimientos WHERE xt_tipoOrigen = 'B' AND kf_itemOrigenID = $solicitudID ");
	
	while($r = $s->fetchRow()){
		$codigo = $r[0];
		$id 	= $r[1];
		
	}unset($s); unset($r);
	
	if($id != ""){
		////los estatus siguientes que seran mandados a AgregarSeguimientoSolicitud.php
		$estatusMax = 0;
		
		$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $id ");
		
		while($r = $s->fetchRow()){
			
			$estatusMax = $r[0];
			
		} unset($r); unset($s);
		
		$estatusMax++;
	}
	
	$solcitudEstatus 	= "";
	$show 				= "";
	$numeroEtapa		= NULL;
	$estatusEtapa		= NULL;
	$contenidoEtapa		= NULL;
	$fechaEtapa 		= NULL;
	$rutaEtapa 			= NULL;
			
	if($id != ""){
	
		$s = $INTRANET->Execute("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $id ");
		
		while($r = $s->fetchRow()){
			
			$solcitudEstatus = $r[0];
			
		} unset($r); unset($s);
		
		
		$i 		= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numero, xt_estatus, xt_contenido, xd_fecha, xt_ruta FROM SGI_Quejas_Solicitudes_Estatus 
								WHERE kf_seguimientoID = $id ORDER BY xn_numero ");
				
		while($r = $s->fetchRow()){
			
			$numeroEtapa[$i]	= $r[0];
			$estatusEtapa[$i]	= $r[1];
			
			$contenidoEtapa[$i]	= $r[2];
			$contenidoEtapa = str_replace("<br />", "", $contenidoEtapa);
			
			$fechaEtapa[$i] 	= date('Y-m-d', strtotime($r[3]));
			$rutaEtapa[$i] 		= $r[4];
			
			if($estatusEtapa[$i] == "ABIERTA"){
				$show = "Asignada";
				
			} else if($estatusEtapa[$i] == "REVISION"){
				$show = "Para Revisión";
				
			} else if($estatusEtapa[$i] == "RECHAZADA"){
				$show = "Rechazada";
				
			} else if($estatusEtapa[$i] == "TERMINADA"){
				$show = "Terminada";
				
			}
			
			$i++;
			
		}unset($r); unset($s); unset($i);
	
	}
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Modificar Solicitud</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
			<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript">
     <?php
	 		if($codigo != ""){
				
				if(count($numeroEtapa) >= 1){
					
					for($a = 1; $a <= count($numeroEtapa); $a++){
						echo "
							$(function(){
								$(\".DatP".$a."\").datepicker({ dateFormat: 'yy-mm-dd',
								 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
								 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
								
								 });
							});
						";
					}
				}
			}
	?>
            </script>
        </head>
        <body>
    <?php
	
		echo "<div id='wrapper'>";
			echo "<form method='POST' action='fichaSolicitudModificar.php?id=".$solicitudID."'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Modificar Solicitud</font>";
					echo"</td>";
				echo"</tr>";
				echo"<tr>"; 
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		///CUERPO DE LA SOLICITUD
			echo "<table border='0' align='center' width='700'>";
				echo"<tr>";
					echo"<td align='left' id='titulo2'><b>".$clave."</b></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
		///CASO QUE SEA SOLICITANTE O ADMINISTRADOR PUEDEN MODIFICAR 
			if(($solicitanteID == $usuarioId) || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'sdelap') || ($usuarioId == "Manuel_Escalante")){
			
				echo "<table border='0' align='center' width='700'>";
					echo "<tr>";
						echo "<td> </td>";
						echo "<td align='left'>";
							echo "<input type='text' name='solicitudTitulo' value='".$titulo."' size='99'>";
							echo "<input type='hidden' name='modificar' value='1'>";
						echo "</td>";
					echo "</tr>";
					
					if ($ruta != NULL){
						echo"<tr height='10'> </tr>";
						
						echo "<tr>";
							echo "<td> </td>";
							echo"<td id='iconosTexto' align='left'>";
								echo "<img src='../Imagenes/ICN_Archivo.png'>".$ruta."<br>";
								echo "<a href='CambiarArchivoSolicitud.php?solicitudID=".$solicitudID."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
									echo "<img src='../Imagenes/ICN_BotonModificar.png'>";
								echo "</a>";
							echo "</td>";
						echo "</tr>";
					}
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr>";
						echo "<td width='20'> </td>";
						echo "<td width='680' align='justify'><textarea name='descripcionSolicitud' style='width: 610px; height: 100px;'>".$descripcion."</textarea></td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
					
					
			///SOLICITANTE
				
				echo "<table border='0' align='center' width='700'>";	
					echo "<tr>";
						echo "<td align='left' id='titulo2' colspan='2'><b>Solicitante</b></td>";
					echo"</tr>";
					
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
					
					echo "<tr>";
						echo "<td width='20px'></td>";
						echo "<td align='left' width='680px' id='iconosTexto'>";
							
							echo "<select name='solicitante'>";
								if($solicitanteID != ""){
									echo "<option value='".$solicitanteID."' selected='selected'>".$nombreSolicitante." ".$apllPaSolicitante." ".$apllMaSolicitante."</option>";
								}
							
								$s = $INTRANET->Execute("SELECT IUS.kp_usuario, SEM.xt_Nombre, SEM.xt_ApellidoPaterno, SEM.xt_ApellidoMaterno FROM IntranetGEA_USUARIOS IUS, SGI_Empleados SEM 
														 WHERE SEM.kf_usuario = IUS.kp_usuario ORDER BY SEM.xt_Nombre ");
								
								while($r = $s->fetchRow()){
									if($solicitanteID != $r[0]){
										echo "<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
									}
								} unset($r); unset($s);
							
							echo "</select>";
							
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
					
				echo "</table>";
					
			} else{
			
				echo "<table border='0' align='center' width='700'>";
					echo "<tr>";
						echo "<td> </td>";
						echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
						if ($ruta != NULL){
							echo"<td id='iconosTexto' width='50' align='right'><a href='downloadQuejaSolicitud.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a> </td>";
						}else {
							echo"<td id='iconosTexto' width='50' align='right'></td>";
						}
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr>";
						echo "<td width='20'> </td>";
						echo "<td width='20'> </td>";
						echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
				
			///SOLICITANTE
				if($solicitanteID != ""){
					echo "<table border='0' align='center' width='700'>";	
						echo "<tr>";
							echo "<td align='left' id='titulo2' colspan='2'><b>Solicitante</b></td>";
						echo"</tr>";
						
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
						echo "<tr>";
							echo "<td width='20px'></td>";
							echo "<td align='left' width='680px' id='iconosTexto'><b>$nombreSolicitante $apllPaSolicitante $apllMaSolicitante</b></td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
					echo "</table>";
				}
			}
		///PDR
			if($pdrNombre != ""){
				if(($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'sdelap') || ($usuarioId == "Manuel_Escalante")){
					
					echo "<table border='0' align='center' width='700'>";	
						echo "<tr>";
							echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
						echo"</tr>";
						
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
						echo "<tr>";
							echo "<td width='20px'></td>";
							echo "<td align='left' width='680px' id='iconosTexto'>";
								
								echo "<select name='pdr'>";
									echo "<option value='".$pdrID."'>".$pdrNombre." ".$pdrApPate." ".$pdrApMate."</option>";
										
									$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno, EMP.xt_ApellidoMaterno FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
															WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad='PDR' ");
										
									while($r= $s -> fetchRow()){
										if($r[0] != $pdrID){
											echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
										}
										
									} unset($r); unset ($s);
									
								echo"</select>";
							echo "</td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
					echo "</table>";
				} else{
					
					echo "<table border='0' align='center' width='700'>";	
						echo "<tr>";
							echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
						echo"</tr>";
						
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
						echo "<tr>";
							echo "<td width='20px'></td>";
							echo "<td align='left' width='680px' id='iconosTexto'><b>$pdrNombre $pdrApPate $pdrApMate</b></td>";
						echo "</tr>";
						
						echo"<tr height='30'> </tr>";
						
					echo "</table>";
					
				}
			}
			
		//AUDITORIA E ISSUE
			if($auditoriaID != ""){
				
				echo "<table border='0' align='center' width='700'>";			
					echo"<tr>";
						echo"<td align='left'  id='titulo2'><b>Auditoría relacionada</b></td>";
					echo"</tr>";
					
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' width='700'></td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center' width='700'>";
					
					echo "<tr>";
						echo "<td width='40'> </td>";
						echo "<td id='fichaRef' width='660'>";
							if(($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'sdelap') || ($usuarioId == "Manuel_Escalante")){
								
								echo "AUDITORIA: $auditoriaCodigo ";
								echo "ISSUE: $issueCodigo";
								
							} else{
								
								echo "<b>$auditoriaCodigo, Issue $issueCodigo</b>";
								
							}
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
				
			}
	
		///SEGUIMIENTO
			echo "<table border='0' align='center' width='700'>";	
				echo"<tr>";
					echo"<td align='left' id='titulo2'><b>Seguimiento</b></td>";
					echo"<td align='right' id='iconosTexto2'><b>$codigo</b></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
		
		///CODIGO MOSTRAR SEGUIMIENTO
			if($codigo != ""){
				
				if(count($numeroEtapa) >= 1){
					
					for($a = 1; $a <= count($numeroEtapa); $a++){
						
						$show = "";
						
						if($estatusEtapa[$a] == "ABIERTA"){
							$show = "Asignada"; 
							
						} else if($estatusEtapa[$a] == "REVISION"){
							$show = "Para Revisión";
							
						} else if($estatusEtapa[$a] == "RECHAZADA"){
							$show = "Rechazada";
							
						} else if($estatusEtapa[$a] == "TERMINADA"){
							$show = "Terminada";
							
						}
						echo "<table border='0' align='center' width='700'>";
						
							if($estatusEtapa[$a] == "ABIERTA"){
								if(($usuarioId == "sdelap") || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Rodrigo_Romo")){
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>";
											echo "<input type='text' class='DatP".$a."' size=10 maxlength=10 name='fecha".$a."' value='".$fechaEtapa[$a]."'> ";
											echo "<b>$show</b>";
										echo "</td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<img src='../Imagenes/ICN_Archivo.png'>".$rutaEtapa[$a]." ";
												echo "<a href='CambiarArchivoSolicitudEtapa.php?solicitudID=".$solicitudID."&etapa=".$a."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
													echo "<img src='../Imagenes/ICN_BotonModificar.png' width='70px' height='20px'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo"<tr height='10'> </tr>";
									
								} else{
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>$fechaEtapa[$a] <b>$show</b> </td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<a href='downloadSeguimientoSolicitudQueja.php?file=$rutaEtapa[$a]'>";
													echo "<img src='../Imagenes/ICN_Archivo.png'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo"<tr height='10'> </tr>";
								}
								
							} else if($estatusEtapa[$a] == "REVISION"){
								if(($usuarioId == $pdrUserId) || ($usuarioId == "sdelap") || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Manuel_Escalante")){
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>";
											echo "<input type='text' class='DatP".$a."' size=10 maxlength=10 name='fecha".$a."' value='".$fechaEtapa[$a]."'> ";
											echo "<b>$show</b>";
										echo "</td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<img src='../Imagenes/ICN_Archivo.png'>".$rutaEtapa[$a]." ";
												echo "<a href='CambiarArchivoSolicitudEtapa.php?solicitudID=".$solicitudID."&etapa=".$a."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
													echo "<img src='../Imagenes/ICN_BotonModificar.png' width='70px' height='20px'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo "<tr>";
										echo "<td > </td>";
										echo "<td align='justify' id='fileItem' colspan='2'>";
											echo "<textarea name='descripcionEtapa".$a."' style='width:610px; height:100px;'>".$contenidoEtapa[$a]."</textarea>";
										echo "</td>";
									echo "</tr>";
									
								} else{
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>$fechaEtapa[$a] <b>$show</b> </td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<a href='downloadSeguimientoSolicitudQueja.php?file=$rutaEtapa[$a]'>";
													echo "<img src='../Imagenes/ICN_Archivo.png'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo "<tr>";
										echo "<td > </td>";
										echo "<td align='justify' id='fileItem' colspan='2'>$contenidoEtapa[$a]</td>";
									echo "</tr>";
								}
							} else if(($estatusEtapa[$a] == "RECHAZADA") || ($estatusEtapa[$a] == "TERMINADA")){
								if(($solicitanteID == $usuarioId) || ($usuarioId == "sdelap") || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Manuel_Escalante")){
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>";
											echo "<input type='text' class='DatP".$a."' size=10 maxlength=10 name='fecha".$a."' value='".$fechaEtapa[$a]."'> ";
											echo "<b>$show</b>";
										echo "</td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<img src='../Imagenes/ICN_Archivo.png'>".$rutaEtapa[$a]." ";
												echo "<a href='CambiarArchivoSolicitudEtapa.php?solicitudID=".$solicitudID."&etapa=".$a."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
													echo "<img src='../Imagenes/ICN_BotonModificar.png' width='70px' height='20px'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo "<tr>";
										echo "<td > </td>";
										echo "<td align='justify' id='fileItem' colspan='2'>";
											echo "<textarea name='descripcionEtapa".$a."' style='width:610px; height:100px;'>".$contenidoEtapa[$a]."</textarea>";
										echo "</td>";
									echo "</tr>";
									
								} else{
									echo "<tr>";
										echo "<td width='20'> </td>";
										echo "<td width='200' id='iconosTexto' align='left'>$fechaEtapa[$a] <b>$show</b> </td>";
									
										echo "<td width='480' id='iconosTexto' align='right'>";
										if ($rutaEtapa[$a] != NULL){
												
												echo "<a href='downloadSeguimientoSolicitudQueja.php?file=$rutaEtapa[$a]'>";
													echo "<img src='../Imagenes/ICN_Archivo.png'>";
												echo "</a>";
												
										}
										echo "</td>";
									echo "</tr>";
									
									echo "<tr>";
										echo "<td > </td>";
										echo "<td align='justify' id='fileItem' colspan='2'>$contenidoEtapa[$a]</td>";
									echo "</tr>";
								}
							}
							
							echo"<tr height='10'><td colspan='2'> </td></tr>";
							
							echo"<tr height='30'><td colspan='2'> </td></tr>";
						echo "</table>";
						
					}
					
				}
				
			}
			
			echo "<table border='0' align='center' width='700'>";	
		///LINEA FINAL
				echo "<tr height='30px'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo"<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td align='right'>";
						echo "<input type='image' src='../Imagenes/ICN_BotonModificar.png' width='90' height='29' onclick='SubmitForm(this.form);'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='40px'> </tr>";
			echo "</table>";
			
			
			echo "<table border=0 align='center'>";
				echo "<tr height='50'><td> </td></tr>";
			echo "</table>";
		echo "</form>";
?>
        </body>
    </html>
<?php

////SE ACTIVO EL BOTON DE ENVIAR Y ENTONCES SE MANDA LA VARIABLE 'MODIFICAR'
} else if($_POST['modificar'] != ""){
	
	$solicitudTituloInsert 		= $_POST['solicitudTitulo'];
	$descripcionSolicitudInsert = $_POST['descripcionSolicitud'];
	$solicitanteInsert 			= $_POST['solicitante'];
	
	if($solicitudTituloInsert  != ""){
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_titulo = '$solicitudTituloInsert' WHERE kp_quejaSolicitudID = $solicitudID ");
	}
	
	if($descripcionSolicitudInsert  != ""){
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_descripcion = '$descripcionSolicitudInsert' WHERE kp_quejaSolicitudID = $solicitudID ");
	}
	
	if($solicitanteInsert  != ""){
		$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET kf_usuarioId = '$solicitanteInsert' WHERE kp_quejaSolicitudID = $solicitudID ");
	}
	
	$pdrInsertpdr = $_POST['pdr'];
	
	$idSegu	= "";
	
	$s = $INTRANET->Execute("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE xt_tipoOrigen = 'B' AND kf_itemOrigenID = $solicitudID ");
	
	while($r = $s->fetchRow()){
		$idSegu = $r[0];
		
	}unset($s); unset($r);
	
	if($idSegu != ""){
		
		if($pdrInsertpdr != ""){
			
			$INTRANET->Execute("UPDATE SGI_Seguimientos SET kf_pdrID = $pdrInsertpdr WHERE xt_tipoOrigen = 'B' AND kf_itemOrigenID = $solicitudID ");
			
			$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET kf_pdrId = $pdrInsertpdr WHERE kp_quejaSolicitudID = $solicitudID ");
		}
		
		$i 		= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numero, xt_estatus FROM SGI_Quejas_Solicitudes_Estatus 
								WHERE kf_seguimientoID = $idSegu ORDER BY xn_numero ");
				
		while($r = $s->fetchRow()){
			
			$numeroEtapa[$i]	= $r[0];
			$estatusEtapa[$i]	= $r[1];
			
			$i++;
			
		}unset($r); unset($s); unset($i);
		
		for($a = 1; $a <= count($numeroEtapa); $a++){
			$fechaInsert 			= $_POST["fecha$a"];
			$descripcionEtapaInsert = $_POST["descripcionEtapa$a"];
			
			if($fechaInsert != ""){
				$fechaInsert = date('Y-m-d', strtotime($fechaInsert));
				$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatus SET xd_fecha = '$fechaInsert' WHERE kf_seguimientoID = $idSegu AND xn_numero = $a  ");
			}
			
			if($descripcionEtapaInsert != ""){
				$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatus SET xt_contenido = '$descripcionEtapaInsert'  WHERE kf_seguimientoID = $idSegu AND xn_numero = $a  ");
			}
			
			
		}
	
	}
	
	
	
	header("Location: fichaSolicitud.php?id=$solicitudID");
	
}

?>