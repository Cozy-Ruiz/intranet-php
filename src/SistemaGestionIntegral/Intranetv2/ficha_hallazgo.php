<?php
$nombrephp = 'AuditoriaActualizar.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

$clave = $_GET['clave'];

$tipoAtributo 	= $_POST['atributo'];
$codigoAtributo = $_POST['codigoTratamiento'];
$fechaAtributo  = $_POST['fechaTratamiento'];

if($tipoAtributo != "" || $tipoAtributo != NULL){
	
	$INTRANETV2->Execute("INSERT INTO SGI_Auditorias_Hallazgos_Tratamientos (xt_tipoTratamiento,xt_claveTratamiento,xt_claveHallazgo) VALUES ('$tipoAtributo','$codigoAtributo','$clave')");
	header("Location: ficha_hallazgo.php?clave=$clave");
	
}
		   
$s = $INTRANETV2->Execute("SELECT AI.xt_claveAuditoria, AI.xd_fecha, AI.xt_titulo, AI.xt_descripcion, AI.xt_ruta, A.xt_claveAuditoria, AI.xt_claveHallazgo,AI.xt_status FROM SGI_Auditorias_Hallazgos AI, SGI_Auditorias A WHERE AI.xt_claveAuditoria = A.xt_claveAuditoria AND AI.xt_claveHallazgo = '$clave' ");
while($r = $s->fetchRow()){
	
	$auditoriaID 	= $r[0];
	$fecha 			= date('Y-m-d', strtotime($r[1]));
	$titulo 		= $r[2];
	$descripcion 	= nl2br($r[3]);
	$ruta 			= $r[4];
	$clave 			= $r[5];
	$claveIssue 	= $r[6];
	$statusIssue	= $r[7];

} unset($r); unset($s);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
			<title>Ficha Hallazgo</title>
 			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <script>
				
				function showTratamiento(valor){
					if(valor == 1){
						document.getElementById("tratamiento1").style.display="none";
						document.getElementById("tratamiento0").style.display="block";
						document.getElementById("formTratamiento").style.display="block";
					} else if (valor == 0){
						document.getElementById("tratamiento1").style.display="block";
						document.getElementById("tratamiento0").style.display="none";
						document.getElementById("formTratamiento").style.display="none";
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

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tablero_auditoria.php' id='breadcrumbs'> Auditorías </a>";

echo "<div id='wrapperFichaHallazgos' align='center'>";
	echo "<table border='0' width='800px'>";
	
		echo "<tr align='left'>";
            echo "<td id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
		$fecha_actual = date("d/m/Y");
		echo "<tr align='left'>";
            echo "<td id='breadcrumbs'>Fecha: ".$fecha_actual."</td>";
        echo "</tr>";		
	
	echo"</table>";
	echo "<table border='0' width='800px'>";
		echo "<tr height='40px'><td></td></tr>";
			
		echo "<tr align='center'>";
			echo "<td id='titulo1'>";
				echo "Hallazgo";
			echo "</td>";
		echo "</tr>";
		
		echo "<table border='0' align='center' width='800px'>";
				echo "<tr height='20px'>";
					echo "<td align='center'>";
						echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
						echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "<font>".$breadcrumb."</font>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		
		echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
		
	//banana de navegacion intranet
	  echo "<table border='0' align='center' id='mapaIntranet' style='display:none;' width='800px'>";
			  include("../../navegacion_banana.php");
		  echo "</table>";
		  
        echo "</td>";
    echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	
	//CUERPO FICHA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>".$claveIssue."</b></td>";
			//echo "<td id='iconosTexto2' align='right'><b>Status: ".$statusIssue."</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td></td>";
			
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
			
			echo "<td id='iconosTexto' width='50' align='right'>";
			
				if ($ruta != NULL){
					
					echo"<a href='downloadAuditoria.php?file=".$ruta."'><img src='../../Imagenes/ICN_Archivo.png'></a>";
					
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='4'></td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'></td>";
			echo "<td width='20px'></td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td></td>";
			if(($usuarioId == $pdrUserId) || ($usuarioId == "sdelap") || ($usuarioId ==	"Elena_Hernandez") || ($usuarioId == "Saday_Hernandez")){?>
		 <td>
			<a href='modificaObjetivoHallazgoAuditoria.php?claveHallazgo=<?php echo $claveIssue; ?>&clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
				<input style='cursor: pointer; background-color: transparent; border: 0;' 	id='breadcrumbs' type='button' name='modificarDescripcion' value='Modificar'/>
			</a>
		</td>
		<?php }
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='4'></td></tr>";
	echo "</table>";
	
	///AUDITORIA
	echo "<table border='0' align='center' width='800px'>";			
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>Auditoría relacionada</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='800px'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td width='40px'></td>";
			echo "<td id='fichaRef' width='660px'>";
				echo "<b><a href='auditoria_actualizar.php?clave=".$auditoriaID."' id='fichaRef'>".$clave."</a></b>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	

	///TRATAMIENTO
	echo "<table border='0' align='center' width='800px'>";			
		echo "<tr>";
			echo "<td align='left' id='titulo2' width='680'><b>Tratamiento</b></td>";
			
			echo "<td align='right' width='20' >"; 
				 echo"<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' id='tratamiento1' style='display:block;' onclick='showTratamiento(1);'>";
				 echo"<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' id='tratamiento0' style='display:none;' onclick='showTratamiento(0);'>"; 
			echo"</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2' width='800px'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
		
	echo "</table>";

	$conjuntoRegistrosTratamientos = $INTRANETV2-> Execute ("
			SELECT
				xt_claveTratamiento,
				xd_fecha,
				xt_tipoTratamiento
			FROM
				SGI_Auditorias_Hallazgos_Tratamientos
			WHERE
				xt_claveHallazgo = '".$claveIssue."'
			ORDER BY
				xd_fecha ASC
		");

	echo "<table border='0' align='center' width='800px'>";			
		echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='130px' align='left' id='iconosTexto2'>Código</td>";				
				echo "<td width='250px' align='left' id='iconosTexto2'>Actividad</td>";	
				echo "<td width='150px' align='left' id='iconosTexto2'>PDR</td>";				
				echo "<td width='100px' align='left' id='iconosTexto2'>Status</td>";			
				
			echo "</tr>";
		
	echo "</table>";
			
			$indice = 0;	
			while($registrosTratamientos= $conjuntoRegistrosTratamientos -> fetchRow()){
				$codigoTratamiento 	= $registrosTratamientos[0]; 
				$fechaTratamiento	= date('Y-m-d', strtotime($registrosTratamientos[1]));
				$tipoTratamiento    = $registrosTratamientos[2]; 
				
		    $indice++;
			
			//$x = $INTRANET->Execute("SELECT AC.kp_accionesID, AC.xt_titulo, SE.kf_pdrID FROM SGI_Acciones_Preventivas_Correctivas AC, SGI_Seguimientos SE WHERE AC.xt_claveAccion = '$codigoTratamiento' AND AC.kp_accionesID = SE.kf_itemOrigenID AND SE.xt_tipoOrigen = 'E'");
			
			if($tipoTratamiento == 'SOLICITUD'){
				$tipoSolicitud = $INTRANETV2->getOne("
						SELECT
							xt_tipoSolicitud
						FROM
							SGI_Quejas_Solicitudesv2
						WHERE
							xt_quejaSolicitud = '$codigoTratamiento'
					");

				$conjuntoRegistrosSolicitudes = $INTRANETV2->Execute("SELECT xt_titulo, xt_pdr, xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoTratamiento'");

				while($registrosSolicitudes= $conjuntoRegistrosSolicitudes -> fetchRow()){
					$tituloCorrectiva = $registrosSolicitudes[0];
					$pdrCorrectiva    = $registrosSolicitudes[1];
					$statusSol = $registrosSolicitudes[2];

					$etapa = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$codigoTratamiento' ORDER BY xn_etapa DESC");

					if ($etapa == 'SOLICITUD') {
					$etapa = 'Plan de acción';
					}
					if($etapa == 'ASIGNAR'){
					$etapa = 'Asignada';
					}
							//mostrar status de hallazgo
                        
							$evaluacionAccion = $INTRANETV2->getOne("SELECT xn_status 	
																	FROM SGI_Acciones_Preventivas_Correctivas 
																	WHERE xt_claveAccion = '$codigoTratamiento'");
							if ($etapa == 'EVALUACION' && $evaluacionAccion == 1) {
								$semaforoEvaluado = "EVALUADO <IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";	
																
							}elseif ($etapa == 'EVALUACION' && $evaluacionAccion == 0) {
								$semaforoEvaluado = "EVALUADO <IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";									
							}else{
								$semaforoEvaluado = $etapa;
							}

					
					if($tipoSolicitud == 'MT'){
						$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
					} else if ($tipoSolicitud == 'PY'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
					} else if ($tipoSolicitud == 'AV'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
					} else if ($tipoSolicitud == 'AB'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
					} else if ($tipoSolicitud == 'ST'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
					} else if ($tipoSolicitud == 'DS'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
					} else if ($tipoSolicitud == 'EA'){
						$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
					}
					$enlaceCorrectiva = "<a href='".$pagina."codigo=".$codigoTratamiento."' id='fichaRef'>".$codigoTratamiento."</a>";	

							if ($INTRANETV2->getOne("SELECT
								xt_status
							FROM
								SGI_Quejas_Solicitudesv2
							WHERE
								xt_quejaSolicitud = '$codigoTratamiento'
							ORDER BY
								xd_fecha DESC")) {
								$tituloEtapa = $statusSol;
								}


							if($tituloEtapa == "TERMINADA"){
								$tituloEtapa 	= "Terminada";
								
							} else if($tituloEtapa == "ENTREGABLE RECHAZADO"){
								
								$tituloEtapa 	= "Entregable rechazado";
								
							} else if($tituloEtapa == "EN PROCESO"){
								
								$tituloEtapa 	= "En proceso";
								
							} else if($tituloEtapa == "RECHAZADA"){
								
								$tituloEtapa 	= "Rechazada";

							} else if($tituloEtapa == "ACEPTADA"){
								
								$tituloEtapa 	= "Aceptada";

							} else if($tituloEtapa == "REVISION"){
								
								$tituloEtapa 	= "Revision";

							} else if($tituloEtapa == "SIN ASIGNAR"){

								$tituloEtapa 	= "Sin asignar";
							
							} else if($tituloEtapa == "VALIDACION TECNICA"){

								$tituloEtapa 	= "Validacion tecnica";
							
							} else if($tituloEtapa == "VALIDACION DE NEGOCIO"){

								$tituloEtapa 	= "Validacion de negocio";
							
							} else if($tituloEtapa == "ASIGNADA"){

								$tituloEtapa 	= "Asignada";
							
							}
							$semaforoEvaluado = $tituloEtapa;
					///SCRIPT OCULTAR BLOQUES DE LA ACCION CORRECTIVA
					echo "<script>
							function showCorrectiva".$indice."(valor){
								if(valor == 1){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"block\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"none\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.alignContent = \"center\";
								} else if (valor == 0){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"none\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"none\";
								}
							}
						</script> ";

					echo "<!-- hallazgo 1 -->
					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."ON' style='display:block;'>
						<tr onclick='showCorrectiva".$indice."(1);'>
							<td width='20px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='300px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>	
						</tr>
					</table>
					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."OFF' style='display:none;'>
						<tr height='5px' onclick='showCorrectiva".$indice."(0);'>
							<td width='15px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='300px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>
						</tr>
					</table>
					
					<table border='0' align='center' width='800px' id='seguimientoCorrectiva".$indice."' style='display:none;'>
						<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
							<td width='430px'></td>
							<td width='50px'></td>
						</tr>";



						$conjuntoRegistrosStatus = $INTRANETV2->Execute("
							SELECT DISTINCT
								xt_status,
								xd_fecha
							FROM
								SGI_Quejas_Solicitudesv2
							WHERE
								xt_quejaSolicitud = '$codigoTratamiento'
							ORDER BY
								xd_fecha DESC
						");

						while($registrosStatus = $conjuntoRegistrosStatus->fetchRow()){
							
							$tituloEtapa		= $registrosStatus[0];
							$fechaEtapa 		= date('Y-m-d', strtotime($registrosStatus[1]));

							if($tituloEtapa == "TERMINADA"){
								$tituloEtapa 	= "Terminada";
								
							} else if($tituloEtapa == "ENTREGABLE RECHAZADO"){
								
								$tituloEtapa 	= "Entregable rechazado";
								
							} else if($tituloEtapa == "EN PROCESO"){
								
								$tituloEtapa 	= "En proceso";
								
							} else if($tituloEtapa == "RECHAZADA"){
								
								$tituloEtapa 	= "Rechazada";

							} else if($tituloEtapa == "ACEPTADA"){
								
								$tituloEtapa 	= "Aceptada";

							} else if($tituloEtapa == "REVISION"){
								
								$tituloEtapa 	= "Revision";

							} else if($tituloEtapa == "SIN ASIGNAR"){

								$tituloEtapa 	= "Sin asignar";
							
							} else if($tituloEtapa == "VALIDACION TECNICA"){

								$tituloEtapa 	= "Validacion tecnica";
							
							} else if($tituloEtapa == "VALIDACION DE NEGOCIO"){

								$tituloEtapa 	= "Validacion de negocio";
							
							} else if($tituloEtapa == "ASIGNADA"){

								$tituloEtapa 	= "Asignada";
							
							}

					if ($INTRANETV2->getOne("SELECT
								xt_status
							FROM
								SGI_Quejas_Solicitudesv2
							WHERE
								xt_quejaSolicitud = '$codigoTratamiento'
							ORDER BY
								xd_fecha DESC")) {
								$semaforoEvaluado = $tituloEtapa;
								}

							echo "<tr height='15px'>
								<td colspan='6'></td>
							</tr>
							<tr>							
								<td width='430px' align='left' id='textIntro'><b>".$semaforoEvaluado."</b></td>
								<td width='50px'></td>
							</tr>

							
							<tr height='15px'>
								<td colspan='6'> </td>
							</tr>";
						}	
						
						echo "<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
						</tr>
					
					
						<tr height='30px'>
							<td colspan='6'></td>
						</tr>
					</table>";
				}
			}else if ($tipoTratamiento == 'PREVENTIVA'){
				$conjuntoRegistrosPreventivas = $INTRANETV2->Execute("SELECT xt_titulo, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoTratamiento'");
				while($registrosPreventivas= $conjuntoRegistrosPreventivas -> fetchRow()){
					$tituloCorrectiva = $registrosPreventivas[0];
					$pdrCorrectiva    = $registrosPreventivas[1];
					$enlaceCorrectiva = "<a href='fichaPreventivav2.php?codigo=".$codigoTratamiento."' id='fichaRef'>".$codigoTratamiento."</a>";
					///SCRIPT OCULTAR BLOQUES DE LA ACCION CORRECTIVA
					echo "<script>
							function showCorrectiva".$indice."(valor){
								if(valor == 1){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"block\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"none\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.alignContent = \"center\";
								} else if (valor == 0){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"none\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"none\";
								}
							}
						</script> ";

					echo "<!-- hallazgo 2 -->
					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."ON' style='display:block;'>
						<tr onclick='showCorrectiva".$indice."(1);'>
							<td width='20px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='290px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>

					</table>
					

					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."OFF' style='display:none;'>
						<tr height='5px' onclick='showCorrectiva".$indice."(0);'>
							<td width='20px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='290px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>
						</tr>
					</table>
					
					<table border='0' align='center' width='800px' id='seguimientoCorrectiva".$indice."' style='display:none;'>
						<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
							<td width='430px'></td>
							<td width='50px'></td>
						</tr>";

							$conjuntoRegistrosCorrectivas = $INTRANETV2->Execute("
								SELECT DISTINCT
									SSE.xt_titulo,
									SSE.xd_fecha
								FROM
									SGI_Acciones_Preventivas_Correctivas_Etapas SSE
								WHERE
									SSE.xt_codigoAccion = '$codigoTratamiento'
								ORDER BY
									SSE.xn_etapa, SSE.xd_fecha DESC
							");

							while($registrosCorrectivas = $conjuntoRegistrosCorrectivas->fetchRow()){
								
								$tituloEtapa		= $registrosCorrectivas[0];
								$fechaEtapa 		= date('Y-m-d', strtotime($registrosCorrectivas[1]));
								
							if($tituloEtapa == "TERMINADA"){
				
								$tituloEtapa 	= "Terminada";
								
							} else if($tituloEtapa == "ENTREGABLE RECHAZADO"){
								
								$tituloEtapa 	= "Entregable rechazado";
								
							} else if($tituloEtapa == "EN PROCESO"){
								
								$tituloEtapa 	= "En proceso";
								
							} else if($tituloEtapa == "RECHAZADA"){
								
								$tituloEtapa 	= "Rechazada";

							} else if($tituloEtapa == "ACEPTADA"){
								
								$tituloEtapa 	= "Aceptada";

							} else if($tituloEtapa == "REVISION"){
								
								$tituloEtapa 	= "Revision";

							} else if($tituloEtapa == "SIN ASIGNAR"){

								$tituloEtapa 	= "Sin asignar";
							
							} else if($tituloEtapa == "VALIDACION TECNICA"){

								$tituloEtapa 	= "Validacion tecnica";
							
							} else if($tituloEtapa == "VALIDACION DE NEGOCIO"){

								$tituloEtapa 	= "Validacion de negocio";
							
							} else if($tituloEtapa == "ASIGNADA"){

								$tituloEtapa 	= "Asignada";
							
							}
								echo "<tr height='15px'>
									<td colspan='6'></td>
								</tr>
								<tr>
									<td width='150px'></td>
									<td width='100px' align='center' id='textIntro'><b>$fechaEtapa</b></td>
									<td width='430px' align='left' id='textIntro'><b>$tituloEtapa</b></td>
									<td width='50px'></td>
								</tr>
								
								<tr height='15px'>
									<td colspan='6'> </td>
								</tr>";
							}							
							
						
						echo "<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
						</tr>
					
					
						<tr height='30px'>
							<td colspan='6'></td>
						</tr>
					</table>";
				}					
			} else if ($tipoTratamiento == 'CORRECTIVA'){

				$conjuntoRegistrosPreventivas = $INTRANETV2->Execute("SELECT xt_titulo, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoTratamiento'");
				while($registrosPreventivas= $conjuntoRegistrosPreventivas -> fetchRow()){
					$tituloCorrectiva = $registrosPreventivas[0];
					$pdrCorrectiva    = $registrosPreventivas[1];
					$enlaceCorrectiva = "<a href='fichaCorrectivav2.php?id=".$codigoTratamiento."' id='fichaRef'>".$codigoTratamiento."</a>";
					
					$etapa = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$codigoTratamiento' ORDER BY xn_etapa DESC");
					if ($etapa == 'SOLICITUD') {
					$etapa = 'Plan de acción';
					}
					if($etapa == 'ASIGNAR'){
					$etapa = 'Asignada';
					}
							//mostrar status de hallazgo
                        
							$evaluacionAccion = $INTRANETV2->getOne("SELECT xn_status 	
																	FROM SGI_Acciones_Preventivas_Correctivas 
																	WHERE xt_claveAccion = '$codigoTratamiento'");
							if ($etapa == 'EVALUACION' && $evaluacionAccion == 1) {
								$semaforoEvaluado = "EVALUADO <IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";	
																
							}elseif ($etapa == 'EVALUACION' && $evaluacionAccion == 0) {
								$semaforoEvaluado = "EVALUADO <IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";									
							}else{
								$semaforoEvaluado = $etapa;
							}

					///SCRIPT OCULTAR BLOQUES DE LA ACCION CORRECTIVA
					echo "<script>
							function showCorrectiva".$indice."(valor){
								if(valor == 1){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"block\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"none\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.alignContent = \"center\";
								} else if (valor == 0){
									document.getElementById(\"cuerpoCorrectiva".$indice."OFF\").style.display=\"none\";
									document.getElementById(\"cuerpoCorrectiva".$indice."ON\").style.display=\"block\";
									document.getElementById(\"seguimientoCorrectiva".$indice."\").style.display=\"none\";
								}
							}
						</script> ";


					echo "<!-- hallazgo 3 -->
					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."ON' style='display:block;'>
						<tr onclick='showCorrectiva".$indice."(1);'>
							<td width='20px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='300px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>	
						</tr>
					</table>
					<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$indice."OFF' style='display:none;'>
						<tr height='5px' onclick='showCorrectiva".$indice."(0);'>
							<td width='15px'></td>
							<td width='150px' align='left' id='iconosTexto3' valign='top'>$enlaceCorrectiva</td>
							<td width='300px' align='left' id='iconosTexto3' valign='top'>$tituloCorrectiva</td>						
							<td width='170px' align='left' id='iconosTexto3' valign='top'>$pdrCorrectiva</td>
							<td width='120px' align='left' id='iconosTexto3' valign='top'>$semaforoEvaluado</td>
						</tr>
					</table>
					
					<table border='0' align='center' width='800px' id='seguimientoCorrectiva".$indice."' style='display:none;'>
						<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
							<td width='430px'></td>
							<td width='50px'></td>
						</tr>";

							$conjuntoRegistrosCorrectivas = $INTRANETV2->Execute("
								SELECT
									SSE.xt_titulo,
									SSE.xd_fecha
								FROM
									SGI_Acciones_Preventivas_Correctivas_Etapas SSE
								WHERE
									SSE.xt_codigoAccion = '$codigoTratamiento'
								ORDER BY
									SSE.xn_etapa, SSE.xd_fecha DESC
							");

							while($registrosCorrectivas = $conjuntoRegistrosCorrectivas->fetchRow()){
								
								$tituloEtapa		= $registrosCorrectivas[0];
								$fechaEtapa 		= date('Y-m-d', strtotime($registrosCorrectivas[1]));
								
							if($tituloEtapa == "TERMINADA"){
				
								$tituloEtapa 	= "Terminada";
								
							} else if($tituloEtapa == "ENTREGABLE RECHAZADO"){
								
								$tituloEtapa 	= "Entregable rechazado";
								
							} else if($tituloEtapa == "EN PROCESO"){
								
								$tituloEtapa 	= "En proceso";
								
							} else if($tituloEtapa == "RECHAZADA"){
								
								$tituloEtapa 	= "Rechazada";

							} else if($tituloEtapa == "ACEPTADA"){
								
								$tituloEtapa 	= "Aceptada";

							} else if($tituloEtapa == "REVISION"){
								
								$tituloEtapa 	= "Revision";

							} else if($tituloEtapa == "SIN ASIGNAR"){

								$tituloEtapa 	= "Sin asignar";
							
							} else if($tituloEtapa == "VALIDACION TECNICA"){

								$tituloEtapa 	= "Validacion tecnica";
							
							} else if($tituloEtapa == "VALIDACION DE NEGOCIO"){

								$tituloEtapa 	= "Validacion de negocio";
							
							} else if($tituloEtapa == "ASIGNADA"){

								$tituloEtapa 	= "Asignada";
							
							}
								echo "<tr height='15px'>
									<td colspan='6'></td>
								</tr>
								<tr>
									<td width='150px'></td>
									<td width='100px' align='center' id='textIntro'><b>$fechaEtapa</b></td>
									<td width='430px' align='left' id='textIntro'><b>$tituloEtapa</b></td>
									<td width='50px'></td>
								</tr>
								
								<tr height='15px'>
									<td colspan='6'> </td>
								</tr>";
							}						
						
						
						echo "<tr height='5px'>
							<td></td>
							<td id='titleBlueLineBottom' colspan=\"2\"></td>
						</tr>
					
					
						<tr height='30px'>
							<td colspan='6'></td>
						</tr>
					</table>";
				}					
			}				
		}

	echo "<form method='post' action='ficha_hallazgo.php?clave=$claveIssue' id='formTratamiento' style='display:none;'>";
		echo "<table border='0' align='center' width='800px'>";	
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Agregar tratamiento</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='30px'></td>";
				echo "<td width='150px' align='left' id='iconosTexto2'>Código</td>";
				echo "<td width='400px' align='left' id='iconosTexto2'> Tipo </td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td></td>";
				echo "<td></td>";
				
				echo "<td align='left'>";
					echo "<input type='text' size=20 maxlength=100 name='codigoTratamiento'>";
				echo "</td>";
				
				echo "<td align='left'>";
					echo "<select id='seleccion' name='atributo'>";
						echo "<option value='' selected=''>Elegir...</option>";					
						echo "<option value='SOLICITUD'>Solicitud</option>";
						echo "<option value='PREVENTIVA'>Acción Preventiva</option>";
						echo "<option value='CORRECTIVA'>Acción Correctiva</option>";
					echo "</select>";
				echo "</td>";
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
	
	
	///LINEA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td></td></tr>";
	echo "</table>";
	
echo "</div>";
			
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
<?php
						
