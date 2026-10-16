<?php
$nombrephp = 'tablero_Aduanas.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$patente[1] = 3061;
$patente[2] = 3371;
$patente[3] = 3034;
$patente[4] = 3925;
//$patente[5] = 3633;
//$patente[6] = 3009;
//$patente[7] = 3621;
$patente[8] = "Todas";

$aduanaValor[1] 	= 7;
$aduanaValor[2] 	= 16;
$aduanaValor[3] 	= 20;
$aduanaValor[4] 	= 24;
$aduanaValor[5] 	= 40;
$aduanaValor[6] 	= 43;
$aduanaValor[7] 	= 47;
$aduanaValor[8] 	= 53;
$aduanaValor[9] 	= 65;
$aduanaValor[10] 	= 80;
$aduanaValor[11]	= 44444;

$aduanaShow[1] 		= "Cd. Juarez, Chih.";
$aduanaShow[2] 		= "Manzanillo, Col.";
$aduanaShow[3] 		= "Pantaco, México D.F.";
$aduanaShow[4] 		= "Nuevo Laredo, Tamps";
$aduanaShow[5] 		= "Tijuana, B.C.";
$aduanaShow[6] 		= "Veracruz, Ver.";
$aduanaShow[7] 		= "AICM, México D.F.";
$aduanaShow[8] 		= "Cancún, Q.Roo";
$aduanaShow[9] 		= "Toluca, Méx.";
$aduanaShow[10] 	= "Colombia, N.L.";
$aduanaShow[11]		= "Todas";

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

$currentYear = date('Y');
$currentMonth = date('m');

///Obtiene el año si fue pasado como parametro
if($_GET['y'] != ""){
	$showYear = $_GET['y'];
	//echo "GETshowYear: ".$showYear."<br>";
///Si no el año se asigna como el año en curso	
} else if($_POST['year'] != ""){
	$showYear = $_POST['year'];
	//echo "POSTshowYear: ".$showYear."<br>";

} else{
	$showYear = $currentYear;
	//echo "CURRENTshowYear: ".$showYear."<br>";
	
}

///Obtiene el mes si fue pasado como parametro
if($_POST['m'] != ""){
	$showMonth = $_POST['m'];

} else if($_GET['m'] != ""){
	$showMonth = $_GET['m'];
///Si no el mes se asigna como el mes en curso	
} else if(($_POST['m'] == "") && ($_GET['m'] == "")){
	$showMonth = $currentMonth;
	
}

///Obtiene la patente si fue pasado como parametro
if($_POST['patente'] != ""){
	$showPatente = $_POST['patente'];

} else if($_GET['patente'] != ""){
	$showPatente = $_GET['patente'];
///Si no el mes se asigna como el mes en curso	
} else if(($_POST['patente'] == "") && ($_GET['patente'] == "")){
	$showPatente = "Todas";
	
}

////
if($_POST['aduana'] != ""){
	$showAduana = $_POST['aduana'];

} else if($_GET['aduana'] != ""){
	$showAduana = $_GET['aduana'];
///Si no el mes se asigna como el mes en curso	
} else if(($_POST['aduana'] == "") && ($_GET['aduana'] == "")){
	$showAduana = 47;
	
}

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
<a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";
/*$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../aplicaciones.php' id='breadcrumbs'> Módulos / </a>
			   <a href='../operaciones.php' id='breadcrumbs'> Operaciones / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--Inicia html-->
	<html xmlns="http://www.w3.org/1999/xhtml">
        <!--Inicia de head-->
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Tablero Aduanas</title>
            <!--ESTILOS & SCRIPTS-->
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="stylesheet" href="../../css/jquery-ui.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            <script src="../../css/jquery-1.9.1.js" charset="utf-8"></script>
            <script src="../../css/jquery-ui.js" charset="utf-8"></script>
            <script>
                $(function() {
                $( document ).tooltip();
                });
            </script>
        </head>
        <!--Fin de head-->
        <!--Inicia body-->
        <body>
<?php

echo "<div id='wrapperRiesgos' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Tablero de Aduanas";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>"; 
			echo "<td align='center'>";
				echo $breadcrumb;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70'><td></td></tr>";
	echo "</table>";
							
	echo "<table align='center'>";
		echo "<tr>";
			echo "<td align='right' width='900px' id='breadcrumbs'>";
			echo "<td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	///Formulario para seleccionar Año y Mes a consultar
	echo "<form action='tablero_Aduanas.php'  method='POST'>";
		echo "<table align='center'>";
			echo "<tr id='fileItem'>";
				echo "<td align='center'>Seleccione año:</td>";
				echo "<td align='center'>Seleccione mes:</td>";
				echo "<td align='center'>Seleccione patente:</td>";
				echo "<td align='center'>Seleccione aduana:</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='center' style='min-width: 110px; max-width: 110px;'>";
					//echo "O: ".$o.", CURRENT: ".$currentYear.", SHOW: ".$showYear."<br>";
					echo "<select name='year'>";
						///Muestra solo 4 años, del actual y los tres anteriores consecutivos
						for($o = $currentYear; $o >= ($currentYear-5); $o--){
							
							if($showYear != $o){
								
								echo "<option value=".$o.">".$o."</option>";
								
							} else{
								
								echo "<option value=".$o." selected='selected'>".$o."</option>";
								
							}
							
						} unset($o);
							
					echo "</select>";
				echo "</td>";
				
				echo "<td align='center' style='min-width: 120px; max-width: 120px;'>";
					echo "<select name='m'>";
						///Muestra los meses consecutivamente
						for($o = 1; $o <= 13; $o++){
							
							if($showMonth != $o){
								
								echo "<option value='".$o."'>".$mesNombre[$o]."</option>";
								
							} else{
								
								echo "<option value='".$o."' selected='selected'>".$mesNombre[$o]."</option>";
								
							}
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
				
				echo "<td align='center' style='min-width: 120px; max-width: 120px;'>";
					echo "<select name='patente'>";
						///Muestra los meses consecutivamente
						for($o = 1; $o <= 8; $o++){
							if($patente[$o] != (""||null)){
								if($showPatente != $patente[$o]){
									
									echo "<option value='".$patente[$o]."'>".$patente[$o]."</option>";
									
								} else{
									
									echo "<option value='".$patente[$o]."' selected='selected'>".$patente[$o]."</option>";
									
								}
							}
						} unset($o);
						
					echo "</select>";
				echo "</td>";
				
				echo "<td align='center' style='min-width: 180px; max-width: 180px;'>";
					echo "<select name='aduana'>";
						///Muestra la aduana seleccionada
						for($o = 1; $o <= 11; $o++){
							
							if($showAduana != $aduanaValor[$o]){
								
								echo "<option value='".$aduanaValor[$o]."'>".$aduanaShow[$o]."</option>";
								
							} else{
								
								echo "<option value='".$aduanaValor[$o]."' selected='selected'>".$aduanaShow[$o]."</option>";
								
							}
						} unset($o);
					echo "</select>";	
						
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='4' align='center'>";
					echo "<br><br><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='4' align='center'></td></tr>";
		echo "</table>";
	echo "</form>";
	
	echo "<table border=0 align='center' width='900px'>";		
		echo "<tr>";
			echo "<td align='right' width='900px'>";
				echo "<a href='reporteAduanasExcel.php?y=$showYear&m=$showMonth&patente=$showPatente&aduana=$showAduana'><img src='../../Imagenes/ICN_Archivo.png'></a>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	
	///FOR QUE RECORRE TODAS LAS PATENTES EN BUSCA DE INFORMACION PARA CADA ADUANA
	if($showAduana == 44444){
		
		for($o = 1; $o <= 10; $o++){
			
			$banderaAduana = 0;
			//echo "FRACCION|CLIENTE|RFC<br>";
			if($showMonth != 13){
				
				if($showPatente != "Todas"){
					
					$indice 		= 1;
					$aduana			= NULL;
					$fraccion 		= NULL;
					$clientes 		= NULL;
					$rfc 			= NULL;
					$descripcion 	= NULL;
					$s = $INTRANET->Execute("
					SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
					FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
					WHERE YEAR(PE.xd_fechaPago) = $showYear 
					AND MONTH(PE.xd_fechaPago) = $showMonth 
					AND PE.xt_referencia = PA.xt_referencia 
					AND PE.xn_patente = $showPatente 
					AND PA.xn_fraccionVulnerable in (1, 2, 3) 
					AND PE.xt_nombre LIKE CL.xt_nombre 
					AND PE.xn_aduana LIKE '$aduanaValor[$o]%' 
					AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
					ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
					
					//echo "FRACCION|CLIENTE|RFC<br>";
					while($r = $s->fetchRow()){
						
						$aduana[$indice]		= $r[0];
						$fraccion[$indice] 		= $r[1];
						$clientes[$indice] 		= $r[2];
						$rfc[$indice] 			= $r[3];
						$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
						$descripcion[$indice] 	= $r[4];
						//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
						$indice++;
						
					} unset($r); unset($s);
				
				/////Imprimir tablero
				/////PATENTE 3061
					if(count($fraccion) >= 1){
					///Header patente 3061
						
						if($banderaAduana == 0){
							echo "<table border='0' align='center' width='950px'>";		
								echo "<tr height='40px'><td colspan='2'></td></tr>";
								
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='905px'>".$aduanaShow[$o]."</td>";
									echo "<td width='45px'></td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
							echo "</table>";
							
							$banderaAduana++;
						}
						
						echo "<table border='0' align='center' width='850px'>";
							echo "<tr height='20px'><td></td></tr>";
								
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='850px'>";
										echo "Patente: ".$showPatente;
								echo "</td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td></tr>";
								
							echo "<tr height='10px'><td></td></tr>";
						echo "</table>";
						
						$cuenta 		= 0;
						
						for($a = 1; $a <= count($fraccion); $a++){
							
							if($fraccion[$a] != $fraccion[$a-1]){
								
								$cuenta++;
								
							}
							
						} unset($a);
						
						$renglones = ceil($cuenta/4);
						
						$celdas = 0;
						
						if((	   ($cuenta%4)/4) == 0.25){
							
							$celdas = 1;
							
						} else if((($cuenta%4)/4) == 0.5){
							
							$celdas = 2;
							
						} else if((($cuenta%4)/4) == 0.75){
							
							$celdas = 3;
							
						} else if( ($cuenta%4) 	  == 0){
							
							$celdas = 4;
							
						}
						//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
						echo "<!--Inicia super-->";
						echo "<table border='0' align='center' width='800px'>";
						
						$a = 1;
						$i = 1;
						
						for($e = 1; $e <= $renglones; $e++){
							//echo "A:$a, I:$i, E:$e <br>";
							///RENGLONES
							echo"<tr>";
								///CELDAS
								for($u = 1; $u <= 4; $u++){
									//echo "U:$u <br>";
									//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
										
									echo "<td width='200px'  valign='top'>";
										echo "<table width='200px' align='center' border='0'>";
											echo "<tr height='20px' id='titulo2'>";
												echo "<td width='200px' align='left' colspan='3'>";
													echo "<a href='#' title='".$descripcion[$a]."'>";
														echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
													echo "</a> ".$fraccion[$a];
												echo "</td>";
											echo "</tr>";
											
											do{
												//MUESTRA CLIENTES
												echo "<tr width='200px' id='fileItem'>";
													echo "<td width='10px' align='left'></td>";
													
													echo "<td width='180px' align='left'>";
														echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$showPatente."&aduana=".$aduanaValor[$o]."' id='iconosTexto'>";
															echo $clientes[$a];
														echo "</a>";
													echo "</td>";
													
													echo "<td width='10px' align='left'></td>";
												echo "</tr>";
												
												$a++;
													
											} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
											//echo "FIN DEL WHILE<BR>";
										echo"</table>";
									echo "</td>";
										
									$i++;
									
									if(($renglones == $e) && ($celdas == $u)){
										
										if($celdas == 1){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 2){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 3){
											echo "<td width='200px'></td>";
										}
										
										break;
									}
								}
									
							echo "</tr>";
						}
								
						echo "</table><!--Termina super-->";	
														
					}
					
				} else{
					
					for($allPatentes = 1; $allPatentes <= 7; $allPatentes++){
						
						$indice 		= 1;
						$aduana			= NULL;
						$fraccion 		= NULL;
						$clientes 		= NULL;
						$rfc 			= NULL;
						$descripcion 	= NULL;
						if($patente[$allPatentes] != (""||null)){
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND MONTH(PE.xd_fechaPago) = $showMonth 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $patente[$allPatentes] 
						AND PA.xn_fraccionVulnerable in (1, 2, 3) 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$aduanaValor[$o]%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
						
						//echo "FRACCION|CLIENTE|RFC<br>";
						while($r = $s->fetchRow()){
							
							$aduana[$indice]		= $r[0];
							$fraccion[$indice] 		= $r[1];
							$clientes[$indice] 		= $r[2];
							$rfc[$indice] 			= $r[3];
							$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
							$descripcion[$indice] 	= $r[4];
							//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
							$indice++;
							
						} unset($r); unset($s);
					}
					/////Imprimir tablero
						if(count($fraccion) >= 1){
						///Header patente
							if($banderaAduana == 0){
								echo "<table border='0' align='center' width='950px'>";		
									echo "<tr height='40px'><td colspan='2'></td></tr>";
									
									echo "<tr>";
										echo "<td align='left' id='titulo2Blanco' width='905px'>".$aduanaShow[$o]."</td>";
										echo "<td width='45px'></td>";
									echo"</tr>";
									
									echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
								echo "</table>";
								
								$banderaAduana++;
							}
							
							echo "<table border='0' align='center' width='850px'>";
								echo "<tr height='20px'><td></td></tr>";
									
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='850px'>";
											echo "Patente: ".$patente[$allPatentes];
									echo "</td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td></tr>";
									
								echo "<tr height='10px'><td></td></tr>";
							echo "</table>";
							
							$cuenta 		= 0;
							
							for($a = 1; $a <= count($fraccion); $a++){
								
								if($fraccion[$a] != $fraccion[$a-1]){
									
									$cuenta++;
									
								}
								
							} unset($a);
							
							$renglones = ceil($cuenta/4);
							
							$celdas = 0;
							
							if((	   ($cuenta%4)/4) == 0.25){
								
								$celdas = 1;
								
							} else if((($cuenta%4)/4) == 0.5){
								
								$celdas = 2;
								
							} else if((($cuenta%4)/4) == 0.75){
								
								$celdas = 3;
								
							} else if( ($cuenta%4) 	  == 0){
								
								$celdas = 4;
								
							}
							//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
							echo "<!--Inicia super-->";
							echo "<table border='0' align='center' width='800px'>";
							
							$a = 1;
							$i = 1;
							
							for($e = 1; $e <= $renglones; $e++){
								//echo "A:$a, I:$i, E:$e <br>";
								///RENGLONES
								echo"<tr>";
									///CELDAS
									for($u = 1; $u <= 4; $u++){
										//echo "U:$u <br>";
										//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
											
										echo "<td width='200px'  valign='top'>";
											echo "<table width='200px' align='center' border='0'>";
												echo "<tr height='20px' id='titulo2'>";
													echo "<td width='200px' align='left' colspan='3'>";
														echo "<a href='#' title='".$descripcion[$a]."'>";
															echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
														echo "</a> ".$fraccion[$a];
													echo "</td>";
												echo "</tr>";
												
												do{
													//MUESTRA CLIENTES
													echo "<tr width='200px' id='fileItem'>";
														echo "<td width='10px' align='left'></td>";
														
														echo "<td width='180px' align='left'>";
															echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$patente[$allPatentes]."&aduana=".$aduanaValor[$o]."' id='iconosTexto'>";
																echo $clientes[$a];
															echo "</a>";
														echo "</td>";
														
														echo "<td width='10px' align='left'></td>";
													echo "</tr>";
													
													$a++;
														
												} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
												//echo "FIN DEL WHILE<BR>";
											echo"</table>";
										echo "</td>";
											
										$i++;
										
										if(($renglones == $e) && ($celdas == $u)){
											
											if($celdas == 1){
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												
											} else if($celdas == 2){
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												
											} else if($celdas == 3){
												echo "<td width='200px'></td>";
											}
											
											break;
										}
									}
										
								echo "</tr>";
							}
									
							echo "</table><!--Termina super-->";
						}
						
					}
					
				}
			///Todos los meses
			} else{
				
				if($showPatente != "Todas"){
					
					$indice 		= 1;
					$aduana			= NULL;
					$fraccion 		= NULL;
					$clientes 		= NULL;
					$rfc 			= NULL;
					$descripcion 	= NULL;
					$s = $INTRANET->Execute("
					SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
					FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
					WHERE YEAR(PE.xd_fechaPago) = $showYear 
					AND PE.xt_referencia = PA.xt_referencia 
					AND PE.xn_patente = $showPatente 
					AND PA.xn_fraccionVulnerable in (1, 2, 3) 
					AND PE.xt_nombre LIKE CL.xt_nombre 
					AND PE.xn_aduana LIKE '$aduanaValor[$o]%' 
					AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
					ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
					
					//echo "FRACCION|CLIENTE|RFC<br>";
					while($r = $s->fetchRow()){
						
						$aduana[$indice]		= $r[0];
						$fraccion[$indice] 		= $r[1];
						$clientes[$indice] 		= $r[2];
						$rfc[$indice] 			= $r[3];
						$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
						$descripcion[$indice] 	= $r[4];
						//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
						$indice++;
						
					} unset($r); unset($s);
				
				/////Imprimir tablero
				/////PATENTE 3061
					if(count($fraccion) >= 1){
					///Header patente 3061
						
						if($banderaAduana == 0){
							echo "<table border='0' align='center' width='950px'>";		
								echo "<tr height='40px'><td colspan='2'></td></tr>";
								
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='905px'>".$aduanaShow[$o]."</td>";
									echo "<td width='45px'></td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
							echo "</table>";
							
							$banderaAduana++;
						}
						
						echo "<table border='0' align='center' width='850px'>";
							echo "<tr height='20px'><td></td></tr>";
								
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='850px'>";
										echo "Patente: ".$showPatente;
								echo "</td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td></tr>";
								
							echo "<tr height='10px'><td></td></tr>";
						echo "</table>";
						
						$cuenta 		= 0;
						
						for($a = 1; $a <= count($fraccion); $a++){
							
							if($fraccion[$a] != $fraccion[$a-1]){
								
								$cuenta++;
								
							}
							
						} unset($a);
						
						$renglones = ceil($cuenta/4);
						
						$celdas = 0;
						
						if((	   ($cuenta%4)/4) == 0.25){
							
							$celdas = 1;
							
						} else if((($cuenta%4)/4) == 0.5){
							
							$celdas = 2;
							
						} else if((($cuenta%4)/4) == 0.75){
							
							$celdas = 3;
							
						} else if( ($cuenta%4) 	  == 0){
							
							$celdas = 4;
							
						}
						//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
						echo "<!--Inicia super-->";
						echo "<table border='0' align='center' width='800px'>";
						
						$a = 1;
						$i = 1;
						
						for($e = 1; $e <= $renglones; $e++){
							//echo "A:$a, I:$i, E:$e <br>";
							///RENGLONES
							echo"<tr>";
								///CELDAS
								for($u = 1; $u <= 4; $u++){
									//echo "U:$u <br>";
									//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
										
									echo "<td width='200px'  valign='top'>";
										echo "<table width='200px' align='center' border='0'>";
											echo "<tr height='20px' id='titulo2'>";
												echo "<td width='200px' align='left' colspan='3'>";
													echo "<a href='#' title='".$descripcion[$a]."'>";
														echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
													echo "</a> ".$fraccion[$a];
												echo "</td>";
											echo "</tr>";
											
											do{
												//MUESTRA CLIENTES
												echo "<tr width='200px' id='fileItem'>";
													echo "<td width='10px' align='left'></td>";
													
													echo "<td width='180px' align='left'>";
														echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$showPatente."&aduana=".$aduanaValor[$o]."' id='iconosTexto'>";
															echo $clientes[$a];
														echo "</a>";
													echo "</td>";
													
													echo "<td width='10px' align='left'></td>";
												echo "</tr>";
												
												$a++;
													
											} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
											//echo "FIN DEL WHILE<BR>";
										echo"</table>";
									echo "</td>";
										
									$i++;
									
									if(($renglones == $e) && ($celdas == $u)){
										
										if($celdas == 1){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 2){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 3){
											echo "<td width='200px'></td>";
										}
										
										break;
									}
								}
									
							echo "</tr>";
						}
								
						echo "</table><!--Termina super-->";	
														
					}
				///Todas las patentes
				} else{
					
					for($allPatentes = 1; $allPatentes <= 7; $allPatentes++){
						
						$indice 		= 1;
						$aduana			= NULL;
						$fraccion 		= NULL;
						$clientes 		= NULL;
						$rfc 			= NULL;
						$descripcion 	= NULL;
						if($patente[$allPatentes] != (""||null)){
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $patente[$allPatentes] 
						AND PA.xn_fraccionVulnerable in (1, 2, 3) 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$aduanaValor[$o]%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
						
						//echo "FRACCION|CLIENTE|RFC<br>";
						while($r = $s->fetchRow()){
							
							$aduana[$indice]		= $r[0];
							$fraccion[$indice] 		= $r[1];
							$clientes[$indice] 		= $r[2];
							$rfc[$indice] 			= $r[3];
							$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
							$descripcion[$indice] 	= $r[4];
							//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
							$indice++;
							
						} unset($r); unset($s);
					}
					/////Imprimir tablero
						if(count($fraccion) >= 1){
						///Header patente
							if($banderaAduana == 0){
								echo "<table border='0' align='center' width='950px'>";		
									echo "<tr height='40px'><td colspan='2'></td></tr>";
									
									echo "<tr>";
										echo "<td align='left' id='titulo2Blanco' width='905px'>".$aduanaShow[$o]."</td>";
										echo "<td width='45px'></td>";
									echo"</tr>";
									
									echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
								echo "</table>";
								
								$banderaAduana++;
							}
							
							echo "<table border='0' align='center' width='850px'>";
								echo "<tr height='20px'><td></td></tr>";
									
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='850px'>";
											echo "Patente: ".$patente[$allPatentes];
									echo "</td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td></tr>";
									
								echo "<tr height='10px'><td></td></tr>";
							echo "</table>";
							
							$cuenta 		= 0;
							
							for($a = 1; $a <= count($fraccion); $a++){
								
								if($fraccion[$a] != $fraccion[$a-1]){
									
									$cuenta++;
									
								}
								
							} unset($a);
							
							$renglones = ceil($cuenta/4);
							
							$celdas = 0;
							
							if((	   ($cuenta%4)/4) == 0.25){
								
								$celdas = 1;
								
							} else if((($cuenta%4)/4) == 0.5){
								
								$celdas = 2;
								
							} else if((($cuenta%4)/4) == 0.75){
								
								$celdas = 3;
								
							} else if( ($cuenta%4) 	  == 0){
								
								$celdas = 4;
								
							}
							//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
							echo "<!--Inicia super-->";
							echo "<table border='0' align='center' width='800px'>";
							
							$a = 1;
							$i = 1;
							
							for($e = 1; $e <= $renglones; $e++){
								//echo "A:$a, I:$i, E:$e <br>";
								///RENGLONES
								echo"<tr>";
									///CELDAS
									for($u = 1; $u <= 4; $u++){
										//echo "U:$u <br>";
										//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
											
										echo "<td width='200px'  valign='top'>";
											echo "<table width='200px' align='center' border='0'>";
												echo "<tr height='20px' id='titulo2'>";
													echo "<td width='200px' align='left' colspan='3'>";
														echo "<a href='#' title='".$descripcion[$a]."'>";
															echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
														echo "</a> ".$fraccion[$a];
													echo "</td>";
												echo "</tr>";
												
												do{
													//MUESTRA CLIENTES
													echo "<tr width='200px' id='fileItem'>";
														echo "<td width='10px' align='left'></td>";
														
														echo "<td width='180px' align='left'>";
															echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$patente[$allPatentes]."&aduana=".$aduanaValor[$o]."' id='iconosTexto'>";
																echo $clientes[$a];
															echo "</a>";
														echo "</td>";
														
														echo "<td width='10px' align='left'></td>";
													echo "</tr>";
													
													$a++;
														
												} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
												//echo "FIN DEL WHILE<BR>";
											echo"</table>";
										echo "</td>";
											
										$i++;
										
										if(($renglones == $e) && ($celdas == $u)){
											
											if($celdas == 1){
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												
											} else if($celdas == 2){
												echo "<td width='200px'></td>";
												echo "<td width='200px'></td>";
												
											} else if($celdas == 3){
												echo "<td width='200px'></td>";
											}
											
											break;
										}
									}
										
								echo "</tr>";
							}
									
							echo "</table><!--Termina super-->";
						}
						
					}
					
				}
			///FIN todos los meses	
			}
		///Fin FOR recorre todas las aduanas
		}
	///Fin todas las aduanas
	} else{
		
		$banderaAduana = 0;
		//echo "FRACCION|CLIENTE|RFC<br>";
		if($showMonth != 13){
			
			if($showPatente != "Todas"){
				
				$indice 		= 1;
				$aduana			= NULL;
				$fraccion 		= NULL;
				$clientes 		= NULL;
				$rfc 			= NULL;
				$descripcion 	= NULL;
				$s = $INTRANET->Execute("
				SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
				FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
				WHERE YEAR(PE.xd_fechaPago) = $showYear 
				AND MONTH(PE.xd_fechaPago) = $showMonth 
				AND PE.xt_referencia = PA.xt_referencia 
				AND PE.xn_patente = $showPatente 
				AND PA.xn_fraccionVulnerable in (1, 2, 3) 
				AND PE.xt_nombre LIKE CL.xt_nombre 
				AND PE.xn_aduana LIKE '$showAduana%' 
				AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
				ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
				
				//echo "FRACCION|CLIENTE|RFC<br>";
				while($r = $s->fetchRow()){
					
					$aduana[$indice]		= $r[0];
					$fraccion[$indice] 		= $r[1];
					$clientes[$indice] 		= $r[2];
					$rfc[$indice] 			= $r[3];
					$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
					$descripcion[$indice] 	= $r[4];
					//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
					$indice++;
					
				} unset($r); unset($s);
			
			/////Imprimir tablero
			/////PATENTE 3061
				if(count($fraccion) >= 1){
				///Header patente 3061
					
					if($banderaAduana == 0){
						echo "<table border='0' align='center' width='950px'>";		
							echo "<tr height='40px'><td colspan='2'></td></tr>";
							
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='905px'>";
									for($aux = 1; $aux <= 10; $aux++){
										if($aduanaValor[$aux] == $showAduana){
											echo $aduanaShow[$aux];
										}
									}
								echo "</td>";
								echo "<td width='45px'></td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
						echo "</table>";
						
						$banderaAduana++;
					}
					
					echo "<table border='0' align='center' width='850px'>";
						echo "<tr height='20px'><td></td></tr>";
							
						echo "<tr>";
							echo "<td align='left' id='titulo2Blanco' width='850px'>";
									echo "Patente: ".$showPatente;
							echo "</td>";
						echo"</tr>";
						
						echo "<tr><td id='titleBlueLineTop'></td></tr>";
							
						echo "<tr height='10px'><td></td></tr>";
					echo "</table>";
					
					$cuenta 		= 0;
					
					for($a = 1; $a <= count($fraccion); $a++){
						
						if($fraccion[$a] != $fraccion[$a-1]){
							
							$cuenta++;
							
						}
						
					} unset($a);
					
					$renglones = ceil($cuenta/4);
					
					$celdas = 0;
					
					if((	   ($cuenta%4)/4) == 0.25){
						
						$celdas = 1;
						
					} else if((($cuenta%4)/4) == 0.5){
						
						$celdas = 2;
						
					} else if((($cuenta%4)/4) == 0.75){
						
						$celdas = 3;
						
					} else if( ($cuenta%4) 	  == 0){
						
						$celdas = 4;
						
					}
					//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
					echo "<!--Inicia super-->";
					echo "<table border='0' align='center' width='800px'>";
					
					$a = 1;
					$i = 1;
					
					for($e = 1; $e <= $renglones; $e++){
						//echo "A:$a, I:$i, E:$e <br>";
						///RENGLONES
						echo"<tr>";
							///CELDAS
							for($u = 1; $u <= 4; $u++){
								//echo "U:$u <br>";
								//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
									
								echo "<td width='200px'  valign='top'>";
									echo "<table width='200px' align='center' border='0'>";
										echo "<tr height='20px' id='titulo2'>";
											echo "<td width='200px' align='left' colspan='3'>";
												echo "<a href='#' title='".$descripcion[$a]."'>";
													echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
												echo "</a> ".$fraccion[$a];
											echo "</td>";
										echo "</tr>";
										
										do{
											//MUESTRA CLIENTES
											echo "<tr width='200px' id='fileItem'>";
												echo "<td width='10px' align='left'></td>";
												
												echo "<td width='180px' align='left'>";
													echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$showPatente."&aduana=".$showAduana."' id='iconosTexto'>";
														echo $clientes[$a];
													echo "</a>";
												echo "</td>";
												
												echo "<td width='10px' align='left'></td>";
											echo "</tr>";
											
											$a++;
												
										} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
										//echo "FIN DEL WHILE<BR>";
									echo"</table>";
								echo "</td>";
									
								$i++;
								
								if(($renglones == $e) && ($celdas == $u)){
									
									if($celdas == 1){
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										
									} else if($celdas == 2){
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										
									} else if($celdas == 3){
										echo "<td width='200px'></td>";
									}
									
									break;
								}
							}
								
						echo "</tr>";
					}
							
					echo "</table><!--Termina super-->";	
													
				}
				
			} else{
				
				for($allPatentes = 1; $allPatentes <= 7; $allPatentes++){
					
					$indice 		= 1;
					$aduana			= NULL;
					$fraccion 		= NULL;
					$clientes 		= NULL;
					$rfc 			= NULL;
					$descripcion 	= NULL;
					if($patente[$allPatentes] != (""||null)){
					$s = $INTRANET->Execute("
					SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
					FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
					WHERE YEAR(PE.xd_fechaPago) = $showYear 
					AND MONTH(PE.xd_fechaPago) = $showMonth 
					AND PE.xt_referencia = PA.xt_referencia 
					AND PE.xn_patente = $patente[$allPatentes] 
					AND PA.xn_fraccionVulnerable in (1, 2, 3) 
					AND PE.xt_nombre LIKE CL.xt_nombre 
					AND PE.xn_aduana LIKE '$showAduana%' 
					AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
					ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
					
					//echo "FRACCION|CLIENTE|RFC<br>";
					while($r = $s->fetchRow()){
						
						$aduana[$indice]		= $r[0];
						$fraccion[$indice] 		= $r[1];
						$clientes[$indice] 		= $r[2];
						$rfc[$indice] 			= $r[3];
						$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
						$descripcion[$indice] 	= $r[4];
						//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
						$indice++;
						
					} unset($r); unset($s);
				}
				/////Imprimir tablero
					if(count($fraccion) >= 1){
					///Header patente
						if($banderaAduana == 0){
							echo "<table border='0' align='center' width='950px'>";		
								echo "<tr height='40px'><td colspan='2'></td></tr>";
								
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='905px'>";
										for($aux = 1; $aux <= 10; $aux++){
											if($aduanaValor[$aux] == $showAduana){
												echo $aduanaShow[$aux];
											}
										}
									echo "</td>";
									echo "<td width='45px'></td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
							echo "</table>";
							
							$banderaAduana++;
						}
						
						echo "<table border='0' align='center' width='850px'>";
							echo "<tr height='20px'><td></td></tr>";
								
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='850px'>";
										echo "Patente: ".$patente[$allPatentes];
								echo "</td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td></tr>";
								
							echo "<tr height='10px'><td></td></tr>";
						echo "</table>";
						
						$cuenta 		= 0;
						
						for($a = 1; $a <= count($fraccion); $a++){
							
							if($fraccion[$a] != $fraccion[$a-1]){
								
								$cuenta++;
								
							}
							
						} unset($a);
						
						$renglones = ceil($cuenta/4);
						
						$celdas = 0;
						
						if((	   ($cuenta%4)/4) == 0.25){
							
							$celdas = 1;
							
						} else if((($cuenta%4)/4) == 0.5){
							
							$celdas = 2;
							
						} else if((($cuenta%4)/4) == 0.75){
							
							$celdas = 3;
							
						} else if( ($cuenta%4) 	  == 0){
							
							$celdas = 4;
							
						}
						//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
						echo "<!--Inicia super-->";
						echo "<table border='0' align='center' width='800px'>";
						
						$a = 1;
						$i = 1;
						
						for($e = 1; $e <= $renglones; $e++){
							//echo "A:$a, I:$i, E:$e <br>";
							///RENGLONES
							echo"<tr>";
								///CELDAS
								for($u = 1; $u <= 4; $u++){
									//echo "U:$u <br>";
									//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
										
									echo "<td width='200px'  valign='top'>";
										echo "<table width='200px' align='center' border='0'>";
											echo "<tr height='20px' id='titulo2'>";
												echo "<td width='200px' align='left' colspan='3'>";
													echo "<a href='#' title='".$descripcion[$a]."'>";
														echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
													echo "</a> ".$fraccion[$a];
												echo "</td>";
											echo "</tr>";
											
											do{
												//MUESTRA CLIENTES
												echo "<tr width='200px' id='fileItem'>";
													echo "<td width='10px' align='left'></td>";
													
													echo "<td width='180px' align='left'>";
														echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$patente[$allPatentes]."&aduana=".$showAduana."' id='iconosTexto'>";
															echo $clientes[$a];
														echo "</a>";
													echo "</td>";
													
													echo "<td width='10px' align='left'></td>";
												echo "</tr>";
												
												$a++;
													
											} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
											//echo "FIN DEL WHILE<BR>";
										echo"</table>";
									echo "</td>";
										
									$i++;
									
									if(($renglones == $e) && ($celdas == $u)){
										
										if($celdas == 1){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 2){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 3){
											echo "<td width='200px'></td>";
										}
										
										break;
									}
								}
									
							echo "</tr>";
						}
								
						echo "</table><!--Termina super-->";
					}
					
				}
				
			}
		///Todos los meses
		} else{
			
			if($showPatente != "Todas"){
				
				$indice 		= 1;
				$aduana			= NULL;
				$fraccion 		= NULL;
				$clientes 		= NULL;
				$rfc 			= NULL;
				$descripcion 	= NULL;
				$s = $INTRANET->Execute("
				SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
				FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
				WHERE YEAR(PE.xd_fechaPago) = $showYear 
				AND PE.xt_referencia = PA.xt_referencia 
				AND PE.xn_patente = $showPatente 
				AND PA.xn_fraccionVulnerable in (1, 2, 3) 
				AND PE.xt_nombre LIKE CL.xt_nombre 
				AND PE.xn_aduana LIKE '$showAduana%' 
				AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
				ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
				
				//echo "FRACCION|CLIENTE|RFC<br>";
				while($r = $s->fetchRow()){
					
					$aduana[$indice]		= $r[0];
					$fraccion[$indice] 		= $r[1];
					$clientes[$indice] 		= $r[2];
					$rfc[$indice] 			= $r[3];
					$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
					$descripcion[$indice] 	= $r[4];
					//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
					$indice++;
					
				} unset($r); unset($s);
			
			/////Imprimir tablero
			/////PATENTE 3061
				if(count($fraccion) >= 1){
				///Header patente 3061
					
					if($banderaAduana == 0){
						echo "<table border='0' align='center' width='950px'>";		
							echo "<tr height='40px'><td colspan='2'></td></tr>";
							
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='905px'>";
									for($aux = 1; $aux <= 10; $aux++){
										if($aduanaValor[$aux] == $showAduana){
											echo $aduanaShow[$aux];
										}
									}
								echo "</td>";
								echo "<td width='45px'></td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
						echo "</table>";
						
						$banderaAduana++;
					}
					
					echo "<table border='0' align='center' width='850px'>";
						echo "<tr height='20px'><td></td></tr>";
							
						echo "<tr>";
							echo "<td align='left' id='titulo2Blanco' width='850px'>";
									echo "Patente: ".$showPatente;
							echo "</td>";
						echo"</tr>";
						
						echo "<tr><td id='titleBlueLineTop'></td></tr>";
							
						echo "<tr height='10px'><td></td></tr>";
					echo "</table>";
					
					$cuenta 		= 0;
					
					for($a = 1; $a <= count($fraccion); $a++){
						
						if($fraccion[$a] != $fraccion[$a-1]){
							
							$cuenta++;
							
						}
						
					} unset($a);
					
					$renglones = ceil($cuenta/4);
					
					$celdas = 0;
					
					if((	   ($cuenta%4)/4) == 0.25){
						
						$celdas = 1;
						
					} else if((($cuenta%4)/4) == 0.5){
						
						$celdas = 2;
						
					} else if((($cuenta%4)/4) == 0.75){
						
						$celdas = 3;
						
					} else if( ($cuenta%4) 	  == 0){
						
						$celdas = 4;
						
					}
					//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
					echo "<!--Inicia super-->";
					echo "<table border='0' align='center' width='800px'>";
					
					$a = 1;
					$i = 1;
					
					for($e = 1; $e <= $renglones; $e++){
						//echo "A:$a, I:$i, E:$e <br>";
						///RENGLONES
						echo"<tr>";
							///CELDAS
							for($u = 1; $u <= 4; $u++){
								//echo "U:$u <br>";
								//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
									
								echo "<td width='200px'  valign='top'>";
									echo "<table width='200px' align='center' border='0'>";
										echo "<tr height='20px' id='titulo2'>";
											echo "<td width='200px' align='left' colspan='3'>";
												echo "<a href='#' title='".$descripcion[$a]."'>";
													echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
												echo "</a> ".$fraccion[$a];
											echo "</td>";
										echo "</tr>";
										
										do{
											//MUESTRA CLIENTES
											echo "<tr width='200px' id='fileItem'>";
												echo "<td width='10px' align='left'></td>";
												
												echo "<td width='180px' align='left'>";
													echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$showPatente."&aduana=".$showAduana."' id='iconosTexto'>";
														echo $clientes[$a];
													echo "</a>";
												echo "</td>";
												
												echo "<td width='10px' align='left'></td>";
											echo "</tr>";
											
											$a++;
												
										} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
										//echo "FIN DEL WHILE<BR>";
									echo"</table>";
								echo "</td>";
									
								$i++;
								
								if(($renglones == $e) && ($celdas == $u)){
									
									if($celdas == 1){
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										
									} else if($celdas == 2){
										echo "<td width='200px'></td>";
										echo "<td width='200px'></td>";
										
									} else if($celdas == 3){
										echo "<td width='200px'></td>";
									}
									
									break;
								}
							}
								
						echo "</tr>";
					}
							
					echo "</table><!--Termina super-->";	
													
				}
			///Todas las patentes
			} else{
				
				for($allPatentes = 1; $allPatentes <= 7; $allPatentes++){
					
					$indice 		= 1;
					$aduana			= NULL;
					$fraccion 		= NULL;
					$clientes 		= NULL;
					$rfc 			= NULL;
					$descripcion 	= NULL;
					if($patente[$allPatentes] != (""||null)){
					$s = $INTRANET->Execute("
					SELECT DISTINCT PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_nombreCorto, CL.xt_rfc, FC.xt_descripcion 
					FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
					WHERE YEAR(PE.xd_fechaPago) = $showYear 
					AND PE.xt_referencia = PA.xt_referencia 
					AND PE.xn_patente = $patente[$allPatentes] 
					AND PA.xn_fraccionVulnerable in (1, 2, 3) 
					AND PE.xt_nombre LIKE CL.xt_nombre 
					AND PE.xn_aduana LIKE '$showAduana%' 
					AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
					ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc ");
					
					//echo "FRACCION|CLIENTE|RFC<br>";
					while($r = $s->fetchRow()){
						
						$aduana[$indice]		= $r[0];
						$fraccion[$indice] 		= $r[1];
						$clientes[$indice] 		= $r[2];
						$rfc[$indice] 			= $r[3];
						$rfc[$indice] 			= str_replace('&', '%26', $rfc[$indice]);
						$descripcion[$indice] 	= $r[4];
						//echo "$fraccion[$indice], $clientes[$indice]|$rfc[$indice]|$descripcion[$indice] <br><br>";
						$indice++;
						
					} unset($r); unset($s);
				}
				/////Imprimir tablero
					if(count($fraccion) >= 1){
					///Header patente
						if($banderaAduana == 0){
							echo "<table border='0' align='center' width='950px'>";		
								echo "<tr height='40px'><td colspan='2'></td></tr>";
								
								echo "<tr>";
									echo "<td align='left' id='titulo2Blanco' width='905px'>";
										for($aux = 1; $aux <= 10; $aux++){
											if($aduanaValor[$aux] == $showAduana){
												echo $aduanaShow[$aux];
											}
										}
									echo "</td>";
									echo "<td width='45px'></td>";
								echo"</tr>";
								
								echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
							echo "</table>";
							
							$banderaAduana++;
						}
						
						echo "<table border='0' align='center' width='850px'>";
							echo "<tr height='20px'><td></td></tr>";
								
							echo "<tr>";
								echo "<td align='left' id='titulo2Blanco' width='850px'>";
										echo "Patente: ".$patente[$allPatentes];
								echo "</td>";
							echo"</tr>";
							
							echo "<tr><td id='titleBlueLineTop'></td></tr>";
								
							echo "<tr height='10px'><td></td></tr>";
						echo "</table>";
						
						$cuenta 		= 0;
						
						for($a = 1; $a <= count($fraccion); $a++){
							
							if($fraccion[$a] != $fraccion[$a-1]){
								
								$cuenta++;
								
							}
							
						} unset($a);
						
						$renglones = ceil($cuenta/4);
						
						$celdas = 0;
						
						if((	   ($cuenta%4)/4) == 0.25){
							
							$celdas = 1;
							
						} else if((($cuenta%4)/4) == 0.5){
							
							$celdas = 2;
							
						} else if((($cuenta%4)/4) == 0.75){
							
							$celdas = 3;
							
						} else if( ($cuenta%4) 	  == 0){
							
							$celdas = 4;
							
						}
						//echo "Cuenta: $cuenta, Renglones:$renglones, Celdas:$celdas <br><br>";
						echo "<!--Inicia super-->";
						echo "<table border='0' align='center' width='800px'>";
						
						$a = 1;
						$i = 1;
						
						for($e = 1; $e <= $renglones; $e++){
							//echo "A:$a, I:$i, E:$e <br>";
							///RENGLONES
							echo"<tr>";
								///CELDAS
								for($u = 1; $u <= 4; $u++){
									//echo "U:$u <br>";
									//echo "FRA:$numeroFraccion3061[$i], DESC:$descripcion[$i] <br>";
										
									echo "<td width='200px'  valign='top'>";
										echo "<table width='200px' align='center' border='0'>";
											echo "<tr height='20px' id='titulo2'>";
												echo "<td width='200px' align='left' colspan='3'>";
													echo "<a href='#' title='".$descripcion[$a]."'>";
														echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15px' height='15px'/>";
													echo "</a> ".$fraccion[$a];
												echo "</td>";
											echo "</tr>";
											
											do{
												//MUESTRA CLIENTES
												echo "<tr width='200px' id='fileItem'>";
													echo "<td width='10px' align='left'></td>";
													
													echo "<td width='180px' align='left'>";
														echo "<a href='tablero_Cliente.php?rfc=".$rfc[$a]."&y=".$showYear."&m=".$showMonth."&patente=".$patente[$allPatentes]."&aduana=".$showAduana."' id='iconosTexto'>";
															echo $clientes[$a];
														echo "</a>";
													echo "</td>";
													
													echo "<td width='10px' align='left'></td>";
												echo "</tr>";
												
												$a++;
													
											} while(($fraccion[$a] == $fraccion[$a-1]) && ($fraccion[$a] != NULL));
											//echo "FIN DEL WHILE<BR>";
										echo"</table>";
									echo "</td>";
										
									$i++;
									
									if(($renglones == $e) && ($celdas == $u)){
										
										if($celdas == 1){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 2){
											echo "<td width='200px'></td>";
											echo "<td width='200px'></td>";
											
										} else if($celdas == 3){
											echo "<td width='200px'></td>";
										}
										
										break;
									}
								}
									
							echo "</tr>";
						}
								
						echo "</table><!--Termina super-->";
					}
					
				}
				
			}
		///FIN todos los meses	
		}
		
	}
	
	unset($a); unset($celdas); unset($clientes); unset($cuenta); unset($descripcion); unset($e); unset($fraccion); unset($i);
	unset($indice); unset($o); unset($r); unset($renglones); unset($s); unset($u);

	echo "<table border=0 align='center'>";
		echo "<tr height='50px'>";
			echo "<td> </td>";
		echo "</tr>";
	echo "</table>";

 	echo "</div><!--Fin de wrapper-->";
	
?>
        </body>
    </html>
<?php
