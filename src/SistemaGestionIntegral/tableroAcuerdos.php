<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'tableroAcuerdos.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$contador = 0;
$t = $INTRANET->Execute("SELECT O.xt_codigoCiudad, (SELECT CO.xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA CO WHERE CO.xt_oficina = O.xt_codigoCiudad) FROM IntranetGEA_Usuarios_Oficina O WHERE O.kf_usuarioId  = '$usuarioId' AND O.xt_codigoCiudad in(SELECT A.xt_ciudad FROM SGI_Acuerdos A)");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

$todas = $INTRANET->getOne("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' AND xt_codigoCiudad = 'ALL'");

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
$mesNombre[13]  = "Todos";

$index = 0;
$tt = $INTRANET->Execute("SELECT
							DISTINCT
							CONCAT(
								LEFT (xt_status, 1),
								LOWER(SUBSTRING(xt_status FROM 2))
							)
						FROM
							SGI_Acuerdos
						ORDER BY
							xt_status");
while($kk = $tt->fetchRow()){
	$statusAcuerdoVal[$index] = $kk[0];
	$index++;	
}unset($kk);unset($tt);unset($index);

$indice 				= 0;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Acuerdos</title>
             <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
        	<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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

$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos </a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>Acuerdos</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
			echo"<tr>"; 
				echo"<td align='center' valign='top' height='20px'>";
					echo "<table border='0' align='center'>";
						echo "<tr height='20px'>";
							echo "<td valign='middle'>";
								echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
								echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
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
		include("../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
/////////////////////////
///////INHOUSE/////////// 
/////////////////////////
	if($categoriaUsr == "Inhouse"){
		
		echo "<table border='0' align='center'  width='700px'>";
		///CABECERA		
			echo "<tr id='titulo2'>";
				echo "<td width='115px' align='center'>Código</td>";
				echo "<td width='420px' align='left'>Título</td>";
				echo "<td width='80px' align='center'>Fecha</td>";
				echo "<td width='10px'></td>";
				echo "<td width='70px' align='left'>Status</td>";
				echo "<td width='5px' align='right'></td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
		echo "</table>";
		
		$banderaInicio = 0;
		
		$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos WHERE xt_ciudad = '$ciudadDefault' ORDER BY xt_claveAcuerdo DESC ");
								
		while($r = $s->fetchRow()){
			
			$acuerdoID 		= $r[0];
			$claveAcuerdo 	= $r[1];
			$tituloAcuerdo 	= $r[2];
			$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
			$status 		= $r[4];
			
			
			if($banderaInicio == 0){
				
				echo "<table align='center' border='0' width='700px'>";
				
			}
			
			echo "<tr id='fileItem'>";	
			///CLAVE Y VINCULO AL ACUERDO	
				echo "<td width='115px' align='center'>"; 
					echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
				echo "</td>";
			///TITULO ACUERDO
				echo "<td width='420px' align='left'>".$tituloAcuerdo."</td>";
			///FECHA
				echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
				
				echo "<td width='10px'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='70px' align='left'>".$status."</td>";
				
				echo "<td width='5px' align='center'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
			$banderaInicio++;
			
		} unset($r);
		
		if($banderaInicio >= 1){
			
				echo"<tr height='10px'><td colspan='6'></td></tr>";
			echo"</table>";
			
		} else{
		///NO HUBO REGISTROS
			echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td></td></tr>";
						echo"</table>";
			
		}
		
/////////////////////////
//////ADMINISTRADOR////// 
/////////////////////////		
	} else if($categoriaUsr == "Administrador"){
		
		$currentYear  = date('Y');
		$currentMonth = date('m');
		
		if($_POST['ciudad'] != ""){
			
			$ciudadElegida = $_POST['ciudad'];
			
		} else{
			
			$ciudadElegida = $ciudadDefault;
			
		}
		//echo $ciudadElegida."<br>";
		
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
		
		$estatusAcuerdoElegido 	= "";
		
		if($_POST['estAcuerdo'] != ""){
			
			$estatusAcuerdoElegido = $_POST['estAcuerdo'];
			
		} else{
			
			$estatusAcuerdoElegido 	= "Abierto";
			
		}
		
		echo "<form method='POST' action='tableroAcuerdos.php'>";
	///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='750px' id='ocultar' style='display:block;'>";
			echo "<tr>";
				echo "<td align='left' id='iconosTexto2' onClick='show(1);' width='750px'>Filtrar</td>";
			echo "</tr>";
		echo "</table>";
	///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='750px' id='mostrar' style='display:none;'>";
			echo "<tr>";
				echo "<td colspan='6' align='left' id='iconosTexto2' onClick='show(0);'>Filtrar</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
		///CATEGORIAS DE LOS FILTROS
			echo "<tr id='fileItem'>";
				echo "<td align='center' width='150px'>Ciudad</td>";
				echo "<td align='center' width='90px'>Año</td>";
				echo "<td align='center' width='130px'>Mes</td>";
				echo "<td align='center' width='150px'>Estatus</td>";
				echo "<td align='center' width='130px'></td>";
				echo "<td align='center' width='100px'></td>";
		///INPUT QUE INDICA QUE EL FILTRO HA SIDO ACTIVADO
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
				
			echo "<tr>";
				echo "<td align='center' valign='top'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					echo "<select name='ciudad'>";
					
						for($a = 0; $a <count($cdValor); $a++){
							
							if($cdValor[$a] != $ciudadElegida){
								
								echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								
							} else{
								
								echo "<option value='".$cdValor[$a]."' selected='selected'>".$ciudades[$a]."</option>";
								
							}
							
						} unset($a);
						
						if($todas != ''){
						echo "<option value='ALL'>Todas</option>";
					}
						
					echo "</select>";
				echo"</td>";
			///OPCIONES PARA AÑOS
				echo "<td align='center' valign='top'>";
					echo "<select name='anio'>";
						///Muestra solo 5 años, del actual y los cuatro anteriores consecutivos
						for($o = $currentYear; $o >= ($currentYear-4); $o--){
							
							if($anio != $o){
								
								echo "<option value='".$o."'>".$o."</option>";
								
							} else{
								
								echo "<option value='".$o."' selected='selected'>".$o."</option>";
								
							}
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			///OPCIONES PARA MESES
				echo "<td align='center' valign='top'>";
					echo "<select name='mes'>";
						///Muestra los meses consecutivamente
						for($o = 1; $o <= 13; $o++){
							
							if($mes != $o){
								
								echo "<option value='".$o."'>".$mesNombre[$o]."</option>";
								
							} else{
								
								echo "<option value='".$o."' selected='selected'>".$mesNombre[$o]."</option>";
								
							}
							
						} unset($o);
						
					echo "</select>";
				echo"</td>";
			///ESTATUS ACUERDOS
				echo "<td align='center' valign='top'>";
					echo "<select name='estAcuerdo'>";
					
					
						for($o = 0; $o<count($statusAcuerdoVal); $o++){
							
							if($estatusAcuerdoElegido == $statusAcuerdoVal[$o]){
									
								echo "<option value='".$statusAcuerdoVal[$o]."' selected='selected'>".$statusAcuerdoVal[$o]."</option>";
								
							} else{
								
								echo "<option value='".$statusAcuerdoVal[$o]."'>".$statusAcuerdoVal[$o]."</option>";
								
							}
							
						} unset($o);
					
						
					//	if($todas != ''){
							echo "<option value='ALL' selected='selected'>Todos</option>";
						//}
						
					echo "</select>";
				echo"</td>";
			///CAMPO VACIO
				echo "<td align='center' valign='top'>";
				
				echo"</td>";
			///CAMPO VACIO
				echo "<td align='center' valign='top'>";
					
				echo"</td>";
	
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='6'></td></tr>";
			
			echo"<tr>";
				echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='25'></td>";
			echo"</tr>";
		echo"</table>";
		
		echo "</form>";
		
		echo "<table align='center' border='0'>";
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
		
		$banderaInicio = 0;
		$numeroScripts = 1;
	///CIUDAD ESPECIFICA
		if($ciudadElegida != "ALL"){
			
			echo "<table border='0' align='center'  width='700px'>";
			///CABECERA		
				echo "<tr id='titulo2'>";
					echo "<td width='115px' align='center'>Código</td>";
					echo "<td width='420px' align='left'>Título</td>";
					echo "<td width='80px' align='center'>Fecha</td>";
					echo "<td width='10px'></td>";
					echo "<td width='70px' align='left'>Status</td>";
					echo "<td width='5px' align='right'></td>";	
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='6'></td></tr>";
			echo "</table>";
		///MES ESPECIFICO
			if($mes != 13){
			///ESTATUS ESPECIFICO
				if($estatusAcuerdoElegido != "ALL"){
					
					$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, xt_status FROM SGI_Acuerdos 
											 WHERE xt_ciudad = '$ciudadElegida' AND YEAR(xd_fecha) = $anio AND MONTH(xd_fecha) = $mes AND CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) = '$estatusAcuerdoElegido' 
											 ORDER BY xt_claveAcuerdo DESC ");
											
					while($r = $s->fetchRow()){
						
						$acuerdoID 		= $r[0];
						$claveAcuerdo 	= $r[1];
						$tituloAcuerdo 	= $r[2];
						$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
						$status 		= $r[4];
					
						$banderaElementos = 0;
						$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
						
						echo "<table align='center' border='0' width='700px'>";
							echo "<tr id='fileItem'>";	
							///CLAVE Y VINCULO AL ACUERDO	
								echo "<td width='115px' align='center'>"; 
									echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
								echo "</td>";
							///TITULO ACUERDO
								echo "<td width='420px' align='left'>";
									if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
										
										echo "
											<script>
												function showElement".$numeroScripts."(valor){
													if(valor == 1){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
														
													} else if (valor == 0){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
													}
												}
											</script>
											";
											
										echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
										echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
									} else{
										
										echo $tituloAcuerdo;
										
									}
								echo "</td>";
							///FECHA
								echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
								
								echo "<td width='10px'></td>";
							///STATUS EN BASE A LAS ETAPAS
								echo "<td width='70px' align='center'>".$status."</td>";
								
								echo "<td width='5px' align='center'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'><td colspan='6'></td></tr>";
						
						echo"</table>";
						
						if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
							
							$letras = "a";
							
							echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
								echo "<tr>";
									echo "<td width='700px'>";
									
									$numeroDealElement		= "";
									$tituloDealElement		= "";
									$contenidoDealElement 	= "";
									$rutaDealElement		= "";
									
									$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
									
									while($t = $u->fetchRow()){
										
										$numeroDealElement		= $t[0];
										$tituloDealElement		= $t[1];
										$contenidoDealElement 	= nl2br($t[2]);
										$rutaDealElement		= $t[3];
										$fechaElement			= date('Y-m-d', strtotime($t[4]));
										
										/*if($tituloDealElement == 'FILE'){
											///ES UN ARCHIVO
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td width='30px'></td>";
													
													echo "<td width='670px' id='textIntro'>";
														echo "<i>".$rutaDealElement."</i> ";
														echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
															echo "<img src='../Imagenes/ICN_Archivo.png'>";
														echo "</a>";
													echo "</td>";
												echo "</tr>";
												
												echo "<tr height='10px'><td colspan='2'></td></tr>";
											echo "</table>";
											
										///ES UN CODIGO DE UN ITEM EL ELEMENTO
										} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
											//RiesgoID
											if(substr($tituloDealElement, 5) == "J"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//SolicitudID
											} else if(substr($tituloDealElement, 5) == "B"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//BoletinID	
											} else if(substr($tituloDealElement, 5) == "H"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//PreventivaID
											} else if(substr($tituloDealElement, 5) == "D"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//CorrectivaID
											} else if(substr($tituloDealElement, 5) == "E"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//ItemID
											} else if(substr($tituloDealElement, 5) == "GE"){
												
												$group 	= "";
												$area 	= "";
												$type 	= "";
												$num	= "";
												$code	= "";
												$title	= "";
												
												$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$group 	= $v[0];
													$area 	= $v[1];
													$type 	= $v[2];
													$num	= $v[3];
													$code	= $v[4];
													$title	= $v[5];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											}				
										///ES TEXTO EL ELEMENTO
										} else if($tituloDealElement != 'FILE'){
											
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td></td>";
													
													echo "<td id='textIntro'>";
														echo $letras.") ";
														echo $tituloDealElement;
													echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												
											echo "</table>";
											
											$letras++;
										}
										
									} unset($t);
									
									
									echo "</td>";
								echo "</tr>";
							echo"</table>";
							
							$numeroScripts++;
							
						}
						
						$banderaInicio++;
						
					} unset($r);
					
					if($banderaInicio >= 1){
						
						echo "<table border='0' align='center' width='700px'>";
							
							echo "<tr>";
								echo "<td width='700px' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
						echo"</table>";
						
					} else{
					///NO HUBO REGISTROS
						echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td width='700px'></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
						echo"</table>";
						
					}
					
			///TODOS LOS ESTATUS
				} else {
					
					$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
											 WHERE xt_ciudad = '$ciudadElegida' AND YEAR(xd_fecha) = $anio AND MONTH(xd_fecha) = $mes 
											 ORDER BY xt_claveAcuerdo DESC ");
											
					while($r = $s->fetchRow()){
						
						$acuerdoID 		= $r[0];
						$claveAcuerdo 	= $r[1];
						$tituloAcuerdo 	= $r[2];
						$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
						$status 		= $r[4];
						
						
						$banderaElementos = 0;
						$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
						
						echo "<table align='center' border='0' width='700px'>";
							echo "<tr id='fileItem'>";	
							///CLAVE Y VINCULO AL ACUERDO	
								echo "<td width='115px' align='center'>"; 
									echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
								echo "</td>";
							///TITULO ACUERDO
								echo "<td width='420px' align='left'>";
									if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
										
										echo "
											<script>
												function showElement".$numeroScripts."(valor){
													if(valor == 1){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
														
													} else if (valor == 0){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
													}
												}
											</script>
											";
											
										echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
										echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
									} else{
										
										echo $tituloAcuerdo;
										
									}
								echo "</td>";
							///FECHA
								echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
								
								echo "<td width='10px'></td>";
							///STATUS EN BASE A LAS ETAPAS
								echo "<td width='70px' align='center'>".$status."</td>";
								
								echo "<td width='5px' align='center'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'><td colspan='6'></td></tr>";
						
						echo"</table>";
						
						if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
							
							$letras = "a";
							
							echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
								echo "<tr>";
									echo "<td width='700px'>";
									
									$numeroDealElement		= "";
									$tituloDealElement		= "";
									$contenidoDealElement 	= "";
									$rutaDealElement		= "";
									
									$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
									
									while($t = $u->fetchRow()){
										
										$numeroDealElement		= $t[0];
										$tituloDealElement		= $t[1];
										$contenidoDealElement 	= nl2br($t[2]);
										$rutaDealElement		= $t[3];
										$fechaElement			= date('Y-m-d', strtotime($t[4]));
										
										/*if($tituloDealElement == 'FILE'){
											///ES UN ARCHIVO
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td width='30px'></td>";
													
													echo "<td width='670px' id='textIntro'>";
														echo "<i>".$rutaDealElement."</i> ";
														echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
															echo "<img src='../Imagenes/ICN_Archivo.png'>";
														echo "</a>";
													echo "</td>";
												echo "</tr>";
												
												echo "<tr height='10px'><td colspan='2'></td></tr>";
											echo "</table>";
											
										///ES UN CODIGO DE UN ITEM EL ELEMENTO
										} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
											//RiesgoID
											if(substr($tituloDealElement, 5) == "J"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//SolicitudID
											} else if(substr($tituloDealElement, 5) == "B"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//BoletinID	
											} else if(substr($tituloDealElement, 5) == "H"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//PreventivaID
											} else if(substr($tituloDealElement, 5) == "D"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//CorrectivaID
											} else if(substr($tituloDealElement, 5) == "E"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//ItemID
											} else if(substr($tituloDealElement, 5) == "GE"){
												
												$group 	= "";
												$area 	= "";
												$type 	= "";
												$num	= "";
												$code	= "";
												$title	= "";
												
												$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$group 	= $v[0];
													$area 	= $v[1];
													$type 	= $v[2];
													$num	= $v[3];
													$code	= $v[4];
													$title	= $v[5];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											}				
										///ES TEXTO EL ELEMENTO
										} else if($tituloDealElement != 'FILE'){
											
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td></td>";
													
													echo "<td id='textIntro'>";
														echo $letras.") ";
														echo $tituloDealElement;
													echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												
											echo "</table>";
											
											$letras++;
										}
										
									} unset($t);
									
									
									echo "</td>";
								echo "</tr>";
							echo"</table>";
							
							$numeroScripts++;
							
						}
						
						$banderaInicio++;
						
					} unset($r);
					
					if($banderaInicio >= 1){
						
						echo "<table border='0' align='center' width='700px'>";
							
							echo "<tr>";
								echo "<td width='700px' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
						echo"</table>";
						
					} else{
					///NO HUBO REGISTROS
						echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td width='700px'></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
						echo"</table>";
						
					}
					
				}
		///TODOS LOS MESES
			} else{
				
				if($estatusAcuerdoElegido != "ALL"){
					
					$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
											 WHERE xt_ciudad = '$ciudadElegida' AND YEAR(xd_fecha) = $anio AND CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) = '$estatusAcuerdoElegido' 
											 ORDER BY xt_claveAcuerdo DESC ");
											
					while($r = $s->fetchRow()){
						
						$acuerdoID 		= $r[0];
						$claveAcuerdo 	= $r[1];
						$tituloAcuerdo 	= $r[2];
						$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
						$status 		= $r[4];
						
					
						
						$banderaElementos = 0;
						$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
						
						echo "<table align='center' border='0' width='700px'>";
							echo "<tr id='fileItem'>";	
							///CLAVE Y VINCULO AL ACUERDO	
								echo "<td width='115px' align='center'>"; 
									echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
								echo "</td>";
							///TITULO ACUERDO
								echo "<td width='420px' align='left'>";
									if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
										
										echo "
											<script>
												function showElement".$numeroScripts."(valor){
													if(valor == 1){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
														
													} else if (valor == 0){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
													}
												}
											</script>
											";
											
										echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
										echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
									} else{
										
										echo $tituloAcuerdo;
										
									}
								echo "</td>";
							///FECHA
								echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
								
								echo "<td width='10px'></td>";
							///STATUS EN BASE A LAS ETAPAS
								echo "<td width='70px' align='center'>".$status."</td>";
								
								echo "<td width='5px' align='center'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'><td colspan='6'></td></tr>";
						
						echo"</table>";
						
						if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
							
							$letras = "a";
							
							echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
								echo "<tr>";
									echo "<td width='700px'>";
									
									$numeroDealElement		= "";
									$tituloDealElement		= "";
									$contenidoDealElement 	= "";
									$rutaDealElement		= "";
									
									$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
									
									while($t = $u->fetchRow()){
										
										$numeroDealElement		= $t[0];
										$tituloDealElement		= $t[1];
										$contenidoDealElement 	= nl2br($t[2]);
										$rutaDealElement		= $t[3];
										$fechaElement			= date('Y-m-d', strtotime($t[4]));
										
										/*if($tituloDealElement == 'FILE'){
											///ES UN ARCHIVO
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td width='30px'></td>";
													
													echo "<td width='670px' id='textIntro'>";
														echo "<i>".$rutaDealElement."</i> ";
														echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
															echo "<img src='../Imagenes/ICN_Archivo.png'>";
														echo "</a>";
													echo "</td>";
												echo "</tr>";
												
												echo "<tr height='10px'><td colspan='2'></td></tr>";
											echo "</table>";
											
										///ES UN CODIGO DE UN ITEM EL ELEMENTO
										} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
											//RiesgoID
											if(substr($tituloDealElement, 5) == "J"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//SolicitudID
											} else if(substr($tituloDealElement, 5) == "B"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//BoletinID	
											} else if(substr($tituloDealElement, 5) == "H"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//PreventivaID
											} else if(substr($tituloDealElement, 5) == "D"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//CorrectivaID
											} else if(substr($tituloDealElement, 5) == "E"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//ItemID
											} else if(substr($tituloDealElement, 5) == "GE"){
												
												$group 	= "";
												$area 	= "";
												$type 	= "";
												$num	= "";
												$code	= "";
												$title	= "";
												
												$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$group 	= $v[0];
													$area 	= $v[1];
													$type 	= $v[2];
													$num	= $v[3];
													$code	= $v[4];
													$title	= $v[5];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											}				
										///ES TEXTO EL ELEMENTO
										} else if($tituloDealElement != 'FILE'){
											
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td></td>";
													
													echo "<td id='textIntro'>";
														echo $letras.") ";
														echo $tituloDealElement;
													echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												
											echo "</table>";
											
											$letras++;
										}
										
									} unset($t);
									
									
									echo "</td>";
								echo "</tr>";
							echo"</table>";
							
							$numeroScripts++;
							
						}
						
						$banderaInicio++;
						
					} unset($r);
					
					if($banderaInicio >= 1){
						
						echo "<table border='0' align='center' width='700px'>";
							
							echo "<tr>";
								echo "<td width='700px' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
						echo"</table>";
						
					} else{
					///NO HUBO REGISTROS
						echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td width='700px'></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
						echo"</table>";
						
					}
					
			///TODOS LOS ESTATUS
				} else {
					
					$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
											 WHERE xt_ciudad = '$ciudadElegida' AND YEAR(xd_fecha) = $anio 
											 ORDER BY xt_claveAcuerdo DESC ");
											
					while($r = $s->fetchRow()){
						
						$acuerdoID 		= $r[0];
						$claveAcuerdo 	= $r[1];
						$tituloAcuerdo 	= $r[2];
						$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
						$status 		= $r[4];
						
						
						$banderaElementos = 0;
						$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
						
						echo "<table align='center' border='0' width='700px'>";
							echo "<tr id='fileItem'>";	
							///CLAVE Y VINCULO AL ACUERDO	
								echo "<td width='115px' align='center'>"; 
									echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
								echo "</td>";
							///TITULO ACUERDO
								echo "<td width='420px' align='left'>";
									if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
										
										echo "
											<script>
												function showElement".$numeroScripts."(valor){
													if(valor == 1){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
														
													} else if (valor == 0){
														document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
														document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
														document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
													}
												}
											</script>
											";
											
										echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
										echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
											echo $tituloAcuerdo;
										echo "</font>";
										
									} else{
										
										echo $tituloAcuerdo;
										
									}
								echo "</td>";
							///FECHA
								echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
								
								echo "<td width='10px'></td>";
							///STATUS EN BASE A LAS ETAPAS
								echo "<td width='70px' align='center'>".$status."</td>";
								
								echo "<td width='5px' align='center'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'><td colspan='6'></td></tr>";
						
						echo"</table>";
						
						if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
							
							$letras = "a";
							
							echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
								echo "<tr>";
									echo "<td width='700px'>";
									
									$numeroDealElement		= "";
									$tituloDealElement		= "";
									$contenidoDealElement 	= "";
									$rutaDealElement		= "";
									
									$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
									
									while($t = $u->fetchRow()){
										
										$numeroDealElement		= $t[0];
										$tituloDealElement		= $t[1];
										$contenidoDealElement 	= nl2br($t[2]);
										$rutaDealElement		= $t[3];
										$fechaElement			= date('Y-m-d', strtotime($t[4]));
										
										/*if($tituloDealElement == 'FILE'){
											///ES UN ARCHIVO
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td width='30px'></td>";
													
													echo "<td width='670px' id='textIntro'>";
														echo "<i>".$rutaDealElement."</i> ";
														echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
															echo "<img src='../Imagenes/ICN_Archivo.png'>";
														echo "</a>";
													echo "</td>";
												echo "</tr>";
												
												echo "<tr height='10px'><td colspan='2'></td></tr>";
											echo "</table>";
											
										///ES UN CODIGO DE UN ITEM EL ELEMENTO
										} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
											//RiesgoID
											if(substr($tituloDealElement, 5) == "J"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//SolicitudID
											} else if(substr($tituloDealElement, 5) == "B"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//BoletinID	
											} else if(substr($tituloDealElement, 5) == "H"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//PreventivaID
											} else if(substr($tituloDealElement, 5) == "D"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//CorrectivaID
											} else if(substr($tituloDealElement, 5) == "E"){
												
												$code 	= "";
												$title 	= "";
												
												$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
												
												while($v = $w->fetchRow()){
													
													$code 	= $v[0];
													$title 	= $v[1];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											//ItemID
											} else if(substr($tituloDealElement, 5) == "GE"){
												
												$group 	= "";
												$area 	= "";
												$type 	= "";
												$num	= "";
												$code	= "";
												$title	= "";
												
												$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
												
												while($v = $w->fetchRow()){
													
													$group 	= $v[0];
													$area 	= $v[1];
													$type 	= $v[2];
													$num	= $v[3];
													$code	= $v[4];
													$title	= $v[5];
													
												} unset($v);
												
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																echo $code;
															echo "</a> ";
															echo $title;
														echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												echo "</table>";
												
												$letras++;
											}				
										///ES TEXTO EL ELEMENTO
										} else if($tituloDealElement != 'FILE'){
											
											echo "<table border='0' align='center' width='700px'>";
												echo "<tr>";
													echo "<td></td>";
													
													echo "<td id='textIntro'>";
														echo $letras.") ";
														echo $tituloDealElement;
													echo "</td>";
														
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
														echo "<td></td>";
													echo "</tr>";
													
													echo "<tr height='10px'>";
														echo "<td width='130px'></td>";
														echo "<td width='380px'></td>";
														echo "<td width='90px'></td>";
														echo "<td width='100px'></td>";
													echo "</tr>";
												
											echo "</table>";
											
											$letras++;
										}
										
									} unset($t);
									
									
									echo "</td>";
								echo "</tr>";
							echo"</table>";
							
							$numeroScripts++;
							
						}
						
						$banderaInicio++;
						
					} unset($r);
					
					if($banderaInicio >= 1){
						
						echo "<table border='0' align='center' width='700px'>";
							
							echo "<tr>";
								echo "<td width='700px' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
						echo"</table>";
						
					} else{
					///NO HUBO REGISTROS
						echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td width='700px'></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
						echo"</table>";
						
					}
					
				}
				
			}
	///TODAS LAS CIUDADES
		} else{
			
			$banderaGlobal = 0;
		///RECORRE CIUDADES
			//for($allCities = 1; $allCities <= 6; $allCities++){
			for($allCities = 0; $allCities <count($cdValor); $allCities++){
				
				$banderaInicio = 0;
			///MES ESPECIFICO
				if($mes != 13){
				///ESTATUS ESPECIFICO
					if($estatusAcuerdoElegido != "ALL"){
						
						$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
												 WHERE xt_ciudad = '$cdValor[$allCities]' AND YEAR(xd_fecha) = $anio AND MONTH(xd_fecha) = $mes AND CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) = '$estatusAcuerdoElegido' 
												 ORDER BY xt_claveAcuerdo DESC ");
												
						while($r = $s->fetchRow()){
							
							$acuerdoID 		= $r[0];
							$claveAcuerdo 	= $r[1];
							$tituloAcuerdo 	= $r[2];
							$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
							$status 		= $r[4];
							
							
							if($banderaInicio == 0){
								
								echo "<table align='center' border='0' width='850px'>";
									echo "<tr height='20px'><td></td></tr>";
									
									echo "<tr>";
										echo "<td width='850px' id='titulo2Blanco'>".$ciudades[$allCities]."</td>";
									echo "</tr>";
									
									echo "<tr height='20px'><td></td></tr>";
								echo "</table>";
								
								echo "<table border='0' align='center'  width='700px'>";
								///CABECERA		
									echo "<tr id='titulo2'>";
										echo "<td width='115px' align='center'>Código</td>";
										echo "<td width='420px' align='left'>Título</td>";
										echo "<td width='80px' align='center'>Fecha</td>";
										echo "<td width='10px'></td>";
										echo "<td width='70px' align='left'>Status</td>";
										echo "<td width='5px' align='right'></td>";	
									echo "</tr>";
									
									echo "<tr>";
										echo "<td colspan='6' id='titleBlueLineTop'></td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='6'></td></tr>";
								echo "</table>";
								
								$banderaGlobal++;
								
							}
							
							$banderaElementos = 0;
							$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
							
							echo "<table align='center' border='0' width='700px'>";
								echo "<tr id='fileItem'>";	
								///CLAVE Y VINCULO AL ACUERDO	
									echo "<td width='115px' align='center'>"; 
										echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
									echo "</td>";
								///TITULO ACUERDO
									echo "<td width='420px' align='left'>";
										if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
											
											echo "
												<script>
													function showElement".$numeroScripts."(valor){
														if(valor == 1){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
															
														} else if (valor == 0){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
														}
													}
												</script>
												";
												
											echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
											echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
										} else{
											
											echo $tituloAcuerdo;
											
										}
									echo "</td>";
								///FECHA
									echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
									
									echo "<td width='10px'></td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='70px' align='center'>".$status."</td>";
									
									echo "<td width='5px' align='center'></td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='6'></td></tr>";
							
							echo"</table>";
							
							if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
								
								$letras = "a";
								
								echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
									echo "<tr>";
										echo "<td width='700px'>";
										
										$numeroDealElement		= "";
										$tituloDealElement		= "";
										$contenidoDealElement 	= "";
										$rutaDealElement		= "";
										
										$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
										
										while($t = $u->fetchRow()){
											
											$numeroDealElement		= $t[0];
											$tituloDealElement		= $t[1];
											$contenidoDealElement 	= nl2br($t[2]);
											$rutaDealElement		= $t[3];
											$fechaElement			= date('Y-m-d', strtotime($t[4]));
											
											/*if($tituloDealElement == 'FILE'){
												///ES UN ARCHIVO
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td width='30px'></td>";
														
														echo "<td width='670px' id='textIntro'>";
															echo "<i>".$rutaDealElement."</i> ";
															echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
																echo "<img src='../Imagenes/ICN_Archivo.png'>";
															echo "</a>";
														echo "</td>";
													echo "</tr>";
													
													echo "<tr height='10px'><td colspan='2'></td></tr>";
												echo "</table>";
												
											///ES UN CODIGO DE UN ITEM EL ELEMENTO
											} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
												//RiesgoID
												if(substr($tituloDealElement, 5) == "J"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "</td>";
															
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//SolicitudID
												} else if(substr($tituloDealElement, 5) == "B"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//BoletinID	
												} else if(substr($tituloDealElement, 5) == "H"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//PreventivaID
												} else if(substr($tituloDealElement, 5) == "D"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//CorrectivaID
												} else if(substr($tituloDealElement, 5) == "E"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//ItemID
												} else if(substr($tituloDealElement, 5) == "GE"){
													
													$group 	= "";
													$area 	= "";
													$type 	= "";
													$num	= "";
													$code	= "";
													$title	= "";
													
													$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$group 	= $v[0];
														$area 	= $v[1];
														$type 	= $v[2];
														$num	= $v[3];
														$code	= $v[4];
														$title	= $v[5];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												}				
											///ES TEXTO EL ELEMENTO
											} else if($tituloDealElement != 'FILE'){
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo $tituloDealElement;
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													
												echo "</table>";
												
												$letras++;
											}
											
										} unset($t);
										
										
										echo "</td>";
									echo "</tr>";
								echo"</table>";
								
								$numeroScripts++;
								
							}
							
							$banderaInicio++;
							
						} unset($r);
						
						if($banderaInicio >= 1){
							
							echo "<table border='0' align='center' width='700px'>";
							
								echo "<tr>";
									echo "<td width='750px' id='titleBlueLineBottom'></td>";
								echo "</tr>";
								
							echo"</table>";
						
						}
						
					///TODOS LOS ESTATUS
					} else {
						
						$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
												 WHERE xt_ciudad = '$cdValor[$allCities]' AND YEAR(xd_fecha) = $anio AND MONTH(xd_fecha) = $mes 
												 ORDER BY xt_claveAcuerdo DESC ");
												
						while($r = $s->fetchRow()){
							
							$acuerdoID 		= $r[0];
							$claveAcuerdo 	= $r[1];
							$tituloAcuerdo 	= $r[2];
							$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
							$status 		= $r[4];
							
							
							if($banderaInicio == 0){
								
								echo "<table align='center' border='0' width='850px'>";
									echo "<tr height='20px'><td></td></tr>";
									
									echo "<tr>";
										echo "<td width='850px' id='titulo2Blanco'>".$ciudades[$allCities]."</td>";
									echo "</tr>";
									
									echo "<tr height='20px'><td></td></tr>";
								echo "</table>";
								
								echo "<table border='0' align='center'  width='700px'>";
								///CABECERA		
									echo "<tr id='titulo2'>";
										echo "<td width='115px' align='center'>Código</td>";
										echo "<td width='420px' align='left'>Título</td>";
										echo "<td width='80px' align='center'>Fecha</td>";
										echo "<td width='10px'></td>";
										echo "<td width='70px' align='left'>Status</td>";
										echo "<td width='5px' align='right'></td>";	
									echo "</tr>";
									
									echo "<tr>";
										echo "<td colspan='6' id='titleBlueLineTop'></td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='6'></td></tr>";
								echo "</table>";
								
								$banderaGlobal++;
								
							}
							
							$banderaElementos = 0;
							$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
							
							echo "<table align='center' border='0' width='700px'>";
								echo "<tr id='fileItem'>";	
								///CLAVE Y VINCULO AL ACUERDO	
									echo "<td width='100px' align='center'>"; 
										echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
									echo "</td>";
								///TITULO ACUERDO
									echo "<td width='420px' align='left'>";
										if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
											
											echo "
												<script>
													function showElement".$numeroScripts."(valor){
														if(valor == 1){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
															
														} else if (valor == 0){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
														}
													}
												</script>
												";
												
											echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
											echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
										} else{
											
											echo $tituloAcuerdo;
											
										}
									echo "</td>";
								///FECHA
									echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
									
									echo "<td width='20px'></td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='70px' align='center'>".$status."</td>";
									
									echo "<td width='10px' align='center'></td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='6'></td></tr>";
							
							echo"</table>";
							
							if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
								
								$letras = "a";
								
								echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
									echo "<tr>";
										echo "<td width='700px'>";
										
										$numeroDealElement		= "";
										$tituloDealElement		= "";
										$contenidoDealElement 	= "";
										$rutaDealElement		= "";
										
										$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
										
										while($t = $u->fetchRow()){
											
											$numeroDealElement		= $t[0];
											$tituloDealElement		= $t[1];
											$contenidoDealElement 	= nl2br($t[2]);
											$rutaDealElement		= $t[3];
											$fechaElement			= date('Y-m-d', strtotime($t[4]));
											
											/*if($tituloDealElement == 'FILE'){
												///ES UN ARCHIVO
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td width='30px'></td>";
														
														echo "<td width='670px' id='textIntro'>";
															echo "<i>".$rutaDealElement."</i> ";
															echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
																echo "<img src='../Imagenes/ICN_Archivo.png'>";
															echo "</a>";
														echo "</td>";
													echo "</tr>";
													
													echo "<tr height='10px'><td colspan='2'></td></tr>";
												echo "</table>";
												
											///ES UN CODIGO DE UN ITEM EL ELEMENTO
											} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
												//RiesgoID
												if(substr($tituloDealElement, 5) == "J"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//SolicitudID
												} else if(substr($tituloDealElement, 5) == "B"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//BoletinID	
												} else if(substr($tituloDealElement, 5) == "H"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//PreventivaID
												} else if(substr($tituloDealElement, 5) == "D"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//CorrectivaID
												} else if(substr($tituloDealElement, 5) == "E"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//ItemID
												} else if(substr($tituloDealElement, 5) == "GE"){
													
													$group 	= "";
													$area 	= "";
													$type 	= "";
													$num	= "";
													$code	= "";
													$title	= "";
													
													$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$group 	= $v[0];
														$area 	= $v[1];
														$type 	= $v[2];
														$num	= $v[3];
														$code	= $v[4];
														$title	= $v[5];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												}				
											///ES TEXTO EL ELEMENTO
											} else if($tituloDealElement != 'FILE'){
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo $tituloDealElement;
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													
												echo "</table>";
												
												$letras++;
											}
											
										} unset($t);
										
										
										echo "</td>";
									echo "</tr>";
								echo"</table>";
								
								$numeroScripts++;
								
							}
							
							$banderaInicio++;
							
						} unset($r);
						
						if($banderaInicio >= 1){
							
							echo "<table border='0' align='center' width='700px'>";
							
								echo "<tr>";
									echo "<td width='750px' id='titleBlueLineBottom'></td>";
								echo "</tr>";
								
							echo"</table>";
						
						}
						
					}
				///TODOS LOS MESES
				} else{
					
					if($estatusAcuerdoElegido != "ALL"){
						
						$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
												 WHERE xt_ciudad = '$cdValor[$allCities]' AND YEAR(xd_fecha) = $anio AND CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) = '$estatusAcuerdoElegido' 
												 ORDER BY xt_claveAcuerdo DESC ");
												
						while($r = $s->fetchRow()){
							
							$acuerdoID 		= $r[0];
							$claveAcuerdo 	= $r[1];
							$tituloAcuerdo 	= $r[2];
							$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
							$status 		= $r[4];
							
						
							
							if($banderaInicio == 0){
								
								echo "<table align='center' border='0' width='850px'>";
									echo "<tr height='20px'><td></td></tr>";
									
									echo "<tr>";
										echo "<td width='850px' id='titulo2Blanco'>".$ciudades[$allCities]."</td>";
									echo "</tr>";
									
									echo "<tr height='20px'><td></td></tr>";
								echo "</table>";
								
								echo "<table border='0' align='center'  width='700px'>";
								///CABECERA		
									echo "<tr id='titulo2'>";
										echo "<td width='115px' align='center'>Código</td>";
										echo "<td width='420px' align='left'>Título</td>";
										echo "<td width='80px' align='center'>Fecha</td>";
										echo "<td width='10px'></td>";
										echo "<td width='70px' align='left'>Status</td>";
										echo "<td width='5px' align='right'></td>";	
									echo "</tr>";
									
									echo "<tr>";
										echo "<td colspan='6' id='titleBlueLineTop'></td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='6'></td></tr>";
								echo "</table>";
								
								$banderaGlobal++;
								
							}
							
							$banderaElementos = 0;
							$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
							
							echo "<table align='center' border='0' width='700px'>";
								echo "<tr id='fileItem'>";	
								///CLAVE Y VINCULO AL ACUERDO	
									echo "<td width='100px' align='center'>"; 
										echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
									echo "</td>";
								///TITULO ACUERDO
									echo "<td width='420px' align='left'>";
										if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
											
											echo "
												<script>
													function showElement".$numeroScripts."(valor){
														if(valor == 1){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
															
														} else if (valor == 0){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
														}
													}
												</script>
												";
												
											echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
											echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
										} else{
											
											echo $tituloAcuerdo;
											
										}
									echo "</td>";
								///FECHA
									echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
									
									echo "<td width='20px'></td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='70px' align='center'>".$status."</td>";
									
									echo "<td width='10px' align='center'></td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='6'></td></tr>";
							
							echo"</table>";
							
							if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
								
								$letras = "a";
								
								echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
									echo "<tr>";
										echo "<td width='700px'>";
										
										$numeroDealElement		= "";
										$tituloDealElement		= "";
										$contenidoDealElement 	= "";
										$rutaDealElement		= "";
										
										$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
										
										while($t = $u->fetchRow()){
											
											$numeroDealElement		= $t[0];
											$tituloDealElement		= $t[1];
											$contenidoDealElement 	= nl2br($t[2]);
											$rutaDealElement		= $t[3];
											$fechaElement			= date('Y-m-d', strtotime($t[4]));
											
											/*if($tituloDealElement == 'FILE'){
												///ES UN ARCHIVO
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td width='30px'></td>";
														
														echo "<td width='670px' id='textIntro'>";
															echo "<i>".$rutaDealElement."</i> ";
															echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
																echo "<img src='../Imagenes/ICN_Archivo.png'>";
															echo "</a>";
														echo "</td>";
													echo "</tr>";
													
													echo "<tr height='10px'><td colspan='2'></td></tr>";
												echo "</table>";
												
											///ES UN CODIGO DE UN ITEM EL ELEMENTO
											} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
												//RiesgoID
												if(substr($tituloDealElement, 5) == "J"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//SolicitudID
												} else if(substr($tituloDealElement, 5) == "B"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//BoletinID	
												} else if(substr($tituloDealElement, 5) == "H"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//PreventivaID
												} else if(substr($tituloDealElement, 5) == "D"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//CorrectivaID
												} else if(substr($tituloDealElement, 5) == "E"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//ItemID
												} else if(substr($tituloDealElement, 5) == "GE"){
													
													$group 	= "";
													$area 	= "";
													$type 	= "";
													$num	= "";
													$code	= "";
													$title	= "";
													
													$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$group 	= $v[0];
														$area 	= $v[1];
														$type 	= $v[2];
														$num	= $v[3];
														$code	= $v[4];
														$title	= $v[5];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												}				
											///ES TEXTO EL ELEMENTO
											} else if($tituloDealElement != 'FILE'){
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo $tituloDealElement;
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													
												echo "</table>";
												
												$letras++;
											}
											
										} unset($t);
										
										
										echo "</td>";
									echo "</tr>";
								echo"</table>";
								
								$numeroScripts++;
								
							}
							
							$banderaInicio++;
							
						} unset($r);
						
						if($banderaInicio >= 1){
							
							echo "<table border='0' align='center' width='700px'>";
							
								echo "<tr>";
									echo "<td width='750px' id='titleBlueLineBottom'></td>";
								echo "</tr>";
								
							echo"</table>";
						
						}
						
					///TODOS LOS ESTATUS
					} else {
						
						$s = $INTRANET->Execute("SELECT kp_acuerdoID, xt_claveAcuerdo, xt_titulo, xd_fecha, CONCAT(LEFT(xt_status,1),LOWER(SUBSTRING(xt_status FROM 2))) FROM SGI_Acuerdos 
												 WHERE xt_ciudad = '$cdValor[$allCities]' AND YEAR(xd_fecha) = $anio 
												 ORDER BY xt_claveAcuerdo DESC ");
												
						while($r = $s->fetchRow()){
							
							$acuerdoID 		= $r[0];
							$claveAcuerdo 	= $r[1];
							$tituloAcuerdo 	= $r[2];
							$fechaAcuerdo	= date('Y-m-d', strtotime($r[3]));
							$status 		= $r[4];
							
							
							if($banderaInicio == 0){
								
								echo "<table align='center' border='0' width='850px'>";
									echo "<tr height='20px'><td></td></tr>";
									
									echo "<tr>";
										echo "<td width='850px' id='titulo2Blanco'>".$ciudades[$allCities]."</td>";
									echo "</tr>";
									
									echo "<tr height='20px'><td></td></tr>";
								echo "</table>";
								
								echo "<table border='0' align='center'  width='700px'>";
								///CABECERA		
									echo "<tr id='titulo2'>";
										echo "<td width='115px' align='center'>Código</td>";
										echo "<td width='420px' align='left'>Título</td>";
										echo "<td width='80px' align='center'>Fecha</td>";
										echo "<td width='10px'></td>";
										echo "<td width='70px' align='left'>Status</td>";
										echo "<td width='5px' align='right'></td>";	
									echo "</tr>";
									
									echo "<tr>";
										echo "<td colspan='6' id='titleBlueLineTop'></td>";
									echo "</tr>";
									
									echo "<tr height='10px'><td colspan='6'></td></tr>";
								echo "</table>";
								
								$banderaGlobal++;
								
							}
							
							$banderaElementos = 0;
							$banderaElementos = $INTRANET->getOne("SELECT kp_elementoAcuerdoID FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID AND xn_numero = 1 ");
							
							echo "<table align='center' border='0' width='700px'>";
								echo "<tr id='fileItem'>";	
								///CLAVE Y VINCULO AL ACUERDO	
									echo "<td width='100px' align='center'>"; 
										echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
									echo "</td>";
								///TITULO ACUERDO
									echo "<td width='420px' align='left'>";
										if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
											
											echo "
												<script>
													function showElement".$numeroScripts."(valor){
														if(valor == 1){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"block\";
															
														} else if (valor == 0){
															document.getElementById(\"showElemento".$numeroScripts."\").style.display=\"none\";
															document.getElementById(\"mostrarE".$numeroScripts."\").style.display=\"block\";
															document.getElementById(\"ocultarE".$numeroScripts."\").style.display=\"none\";
														}
													}
												</script>
												";
												
											echo "<font id='mostrarE".$numeroScripts."' style='display: block;' onclick='showElement".$numeroScripts."(1);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
											echo "<font id='ocultarE".$numeroScripts."' style='display: none;' onclick='showElement".$numeroScripts."(0);'>";
												echo $tituloAcuerdo;
											echo "</font>";
											
										} else{
											
											echo $tituloAcuerdo;
											
										}
									echo "</td>";
								///FECHA
									echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
									
									echo "<td width='20px'></td>";
								///STATUS EN BASE A LAS ETAPAS
									echo "<td width='70px' align='center'>".$status."</td>";
									
									echo "<td width='10px' align='center'></td>";
								echo "</tr>";
								
								echo "<tr height='10px'><td colspan='6'></td></tr>";
							
							echo"</table>";
							
							if(($banderaElementos != "") && ($banderaElementos != NULL) && ($banderaElementos != 0)){
								
								$letras = "a";
								
								echo "<table align='center' border='0' width='700px' id='showElemento".$numeroScripts."' style='display: none;' >";
									echo "<tr>";
										echo "<td width='700px'>";
										
										$numeroDealElement		= "";
										$tituloDealElement		= "";
										$contenidoDealElement 	= "";
										$rutaDealElement		= "";
										
										$u = $INTRANET->Execute("SELECT xn_numero, xt_titulo, xt_contenido, xt_ruta, xd_fecha FROM SGI_Acuerdos_Elementos WHERE kf_acuerdoID = $acuerdoID ORDER BY xn_numero ");
										
										while($t = $u->fetchRow()){
											
											$numeroDealElement		= $t[0];
											$tituloDealElement		= $t[1];
											$contenidoDealElement 	= nl2br($t[2]);
											$rutaDealElement		= $t[3];
											$fechaElement			= date('Y-m-d', strtotime($t[4]));
											
											/*if($tituloDealElement == 'FILE'){
												///ES UN ARCHIVO
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td width='30px'></td>";
														
														echo "<td width='670px' id='textIntro'>";
															echo "<i>".$rutaDealElement."</i> ";
															echo "<a href='downloadAcuerdoElemento.php?file=".$rutaDealElement."'>";
																echo "<img src='../Imagenes/ICN_Archivo.png'>";
															echo "</a>";
														echo "</td>";
													echo "</tr>";
													
													echo "<tr height='10px'><td colspan='2'></td></tr>";
												echo "</table>";
												
											///ES UN CODIGO DE UN ITEM EL ELEMENTO
											} else */if(substr($tituloDealElement, 0, 5) == 'CODE-'){
												//RiesgoID
												if(substr($tituloDealElement, 5) == "J"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaRiesgo.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//SolicitudID
												} else if(substr($tituloDealElement, 5) == "B"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $contenidoDealElement AND xt_tipo = 'B' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaSolicitud.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//BoletinID	
												} else if(substr($tituloDealElement, 5) == "H"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveBoletin, xt_titulo FROM SGI_Boletines WHERE kp_boletinID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='../ComunicacionInterna/fichaBoletin.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration: none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//PreventivaID
												} else if(substr($tituloDealElement, 5) == "D"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'D' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaPreventiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//CorrectivaID
												} else if(substr($tituloDealElement, 5) == "E"){
													
													$code 	= "";
													$title 	= "";
													
													$w = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $contenidoDealElement AND xt_tipo = 'E' ");
													
													while($v = $w->fetchRow()){
														
														$code 	= $v[0];
														$title 	= $v[1];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='fichaCorrectiva.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												//ItemID
												} else if(substr($tituloDealElement, 5) == "GE"){
													
													$group 	= "";
													$area 	= "";
													$type 	= "";
													$num	= "";
													$code	= "";
													$title	= "";
													
													$w = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_codigo, xt_nombre FROM SGI_Item WHERE kp_itemID = $contenidoDealElement ");
													
													while($v = $w->fetchRow()){
														
														$group 	= $v[0];
														$area 	= $v[1];
														$type 	= $v[2];
														$num	= $v[3];
														$code	= $v[4];
														$title	= $v[5];
														
													} unset($v);
													
													
													echo "<table border='0' align='center' width='700px'>";
														echo "<tr>";
															echo "<td></td>";
															
															echo "<td id='textIntro'>";
																echo $letras.") ";
																echo "<a href='FichaItem.php?id=".$contenidoDealElement."' id='textIntro' style='text-decoration:none;'>";
																	echo $code;
																echo "</a> ";
																echo $title;
															echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													echo "</table>";
													
													$letras++;
												}				
											///ES TEXTO EL ELEMENTO
											} else if($tituloDealElement != 'FILE'){
												
												echo "<table border='0' align='center' width='700px'>";
													echo "<tr>";
														echo "<td></td>";
														
														echo "<td id='textIntro'>";
															echo $letras.") ";
															echo $tituloDealElement;
														echo "<td id='textIntro' align='center'>".$fechaElement."</td>";
															echo "<td></td>";
														echo "</tr>";
														
														echo "<tr height='10px'>";
															echo "<td width='130px'></td>";
															echo "<td width='380px'></td>";
															echo "<td width='90px'></td>";
															echo "<td width='100px'></td>";
														echo "</tr>";
													
												echo "</table>";
												
												$letras++;
											}
											
										} unset($t);
										
										
										echo "</td>";
									echo "</tr>";
								echo"</table>";
								
								$numeroScripts++;
								
							}
							
							$banderaInicio++;
							
						} unset($r);
						
						if($banderaInicio >= 1){
							
							echo "<table border='0' align='center' width='700px'>";
							
								echo "<tr>";
									echo "<td width='750px' id='titleBlueLineBottom'></td>";
								echo "</tr>";
								
							echo"</table>";
						
						}
						
					}
					
				}
			///FIN DEL FOR QUE RECORRE CIUDADES
			}
			
				///NO HUBO REGISTROS
			if($banderaGlobal == 0){
			
				echo "<table align='center' border='0' width='700px'>";
					echo"<tr height='30px'><td id='titleBlueLineTop' width='750px'></td></tr>";
					
					echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
					
					echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
				echo"</table>";
				
			}
			
		}
		
	}
	
	///LINEA
	echo "<table border='0' align='center'>";
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
		 
echo "</div>";
?>
		</body>
	</html>
<?php
