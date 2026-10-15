<?php
/*
 *@author Octavio Francisco García Robles
 *@version 3.1
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
//$nombrephp = "tablero_Patentes.php";
//require_once("../../ConexionDBT.php");
require_once("../../ConexionMaster.php");
//require_once("../../conexionLaredo.php");
date_default_timezone_set('America/Chicago');
//require_once("compruebaUsuario.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--Inicia html-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<!--ESTILOS & SCRIPTS-->
    <link type="text/css" rel="stylesheet" href="../../css/styleHomePage.css"/>
	<link rel="stylesheet" href="../../css/jquery-ui.css"/>
	<script src="../../css/jquery-1.9.1.js" charset="utf-8"></script>
	<script src="../../css/jquery-ui.js" charset="utf-8"></script>
	
	<script>
		$(function() {
		$( document ).tooltip();
		});
	</script>
    
    <!--Inicia de head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tablero Patentes</title>
    </head>
    <!--Fin de head-->
	<!--Inicia body-->
	<body>
<?php

$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a><a href='../aplicaciones.php' id='breadcrumbs'>Módulos /</a><a href='../operaciones.php' id='breadcrumbs'>Operaciones</a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";//Encabezado
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Tablero de Patentes</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='70'> </tr>";
	echo "</table>";
							
	echo "
		<table align='center'>
			<tr>
				<td align='right' width='900px' id='breadcrumbs'>
					<font>Lista Clientes</font> 
					<a href='clientesFracionesVulnerables.php'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a><td>
			</tr>
			
			<tr height='20'> </tr>
		</table>";
	
	$currentYear = date('Y');
	$currentMonth = date('m');
	
	///Obtiene el año si fue pasado como parametro
	if($_POST['year'] != ""){
		$showYear = $_POST['year'];
	
	} else if($_GET['year'] != ""){
		$showYear = $_GET['year'];
	///Si no el año se asigna como el año en curso	
	} else if(($_POST['year'] == "") && ($_GET['year'] == "")){
		$showYear = $currentYear;
		
	}
	
	///Obtiene el mes si fue pasado como parametro
	if($_POST['month'] != ""){
		$showMonth = $_POST['month'];
	
	} else if($_GET['month'] != ""){
		$showMonth = $_GET['month'];
	///Si no el mes se asigna como el mes en curso	
	} else if(($_POST['month'] == "") && ($_GET['month'] == "")){
		$showMonth = $currentMonth;
		
	}
	
	////
	if($_POST['aduana'] != ""){
		$showAduana = $_POST['aduana'];
	
	} else if($_GET['aduana'] != ""){
		$showAduana = $_GET['aduana'];
	///Si no el mes se asigna como el mes en curso	
	} else if(($_POST['aduana'] == "") && ($_GET['aduana'] == "")){
		$showAduana = 470;
		
	}
	///Formulario para seleccionar Año y Mes a consultar
	echo "
		<form action='tablero_Patentes.php'  method='POST'>
			<table align='center'>
				<tr id='fileItem'>
					<td align='center'>
						Seleccione año:
					</td>
					<td align='center'>
						Seleccione mes:
					</td>
					<td align='center'>
						Seleccione aduana:
					</td>
				</tr>
				<tr>
					<td align='center' style='min-width: 160px; max-width: 160px;'>
						<select name='year'>
							<option value='".$showYear."' selected=''>$showYear</option>";
							///Muestra solo 4 años, del actual y los tres anteriores consecutivos
							for($o = $currentYear; $o >= ($currentYear-3); $o--){
								if($showYear != $o){
									echo "<option value='$o'>$o</option>";
								}
							} unset($o);
							
					echo "</select>
					</td>
					
					<td align='center' style='min-width: 160px; max-width: 160px;'>
						<select name='month'>";
						
						///Muestra el mes que ha sido seleccionado
					if($showMonth == 1){
						echo "
							<option value='".$showMonth."' selected=''>Enero</option>";
					} else if($showMonth == 2){
						echo "
							<option value='".$showMonth."' selected=''>Febrero</option>";
					} else if($showMonth == 3){
						echo "
							<option value='".$showMonth."' selected=''>Marzo</option>";
					} else if($showMonth == 4){
						echo "
							<option value='".$showMonth."' selected=''>Abril</option>";
					} else if($showMonth == 5){
						echo "
							<option value='".$showMonth."' selected=''>Mayo</option>";
					} else if($showMonth == 6){
						echo "
							<option value='".$showMonth."' selected=''>Junio</option>";
					} else if($showMonth == 7){
						echo "
							<option value='".$showMonth."' selected=''>Julio</option>";
					} else if($showMonth == 8){
						echo "
							<option value='".$showMonth."' selected=''>Agosto</option>";
					} else if($showMonth == 9){
						echo "
							<option value='".$showMonth."' selected=''>Septiembre</option>";
					} else if($showMonth == 10){
						echo "
							<option value='".$showMonth."' selected=''>Octubre</option>";
					} else if($showMonth == 11){
						echo "
							<option value='".$showMonth."' selected=''>Noviembre</option>";
					} else if($showMonth == 12){
						echo "
							<option value='".$showMonth."' selected=''>Diciembre</option>";
					}
							
							///Muestra las opciones de los meses
						echo "
							<option value='1'>Enero</option>
							<option value='2'>Febrero</option>
							<option value='3'>Marzo</option>
							<option value='4'>Abril</option>
							<option value='5'>Mayo</option>
							<option value='6'>Junio</option>
							<option value='7'>Julio</option>
							<option value='8'>Agosto</option>
							<option value='9'>Septiembre</option>
							<option value='10'>Octubre</option>
							<option value='11'>Noviembre</option>
							<option value='12'>Diciembre</option>
							";
						
					echo "</select>
					</td>";
					
					echo "
					<td>
						<select name='aduana'>";
						///Muestra la aduana seleccionada
					if($showAduana == 470){
						echo "
							<option value='".$showAduana."' selected=''>Aeropuerto Internacional de la Ciudad de México</option>";
					} else if($showAduana == 800){
						echo "
							<option value='".$showAduana."' selected=''>Colombia, Nuevo León</option>";
					} else if($showAduana == 160){
						echo "
							<option value='".$showAduana."' selected=''>Pantaco, Ciudad de México</option>";
					} else if($showAduana == 240){
						echo "
							<option value='".$showAduana."' selected=''>Nuevo Laredo, Tamaulipas</option>";
					} else if($showAduana == 530){
						echo "
							<option value='".$showAduana."' selected=''>Cancún, Quintana Roo</option>";
					} else if($showAduana == 533){
						echo "
							<option value='".$showAduana."' selected=''>Puerto Morelos, Quintana Roo</option>";
					} else if($showAduana == 650){
						echo "
							<option value='".$showAduana."' selected=''>Toluca, México</option>";
					} else if($showAduana == 430){
						echo "
							<option value='".$showAduana."' selected=''>Veracruz, Veracruz</option>";
					} 
							
							///Muestra las opciones de los meses
						echo "
							<option value='470'>Aeropuerto Internacional de la Ciudad de México</option>
							<option value='160'>Pantaco, Ciudad de México</option>
							<option value='240'>Nuevo Laredo, Tamaulipas</option>
							<option value='430'>Veracruz, Veracruz</option>
							<option value='530'>Cancún, Quintana Roo</option>
							<option value='533'>Puerto Morelos, Quintana Roo</option>
							<option value='650'>Toluca, México</option>
							<option value='800'>Colombia, Nuevo León</option>
							";
						
					echo "		
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='3' align='center'>
						<br><br><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
					</td>
				</tr>
			</table>
		</form>
		";
	
	$cliente = NULL;
	$fraccion = NULL;
	$rfc = NULL;
	$descripcion = NULL;
	$patente = NULL;
	
	$indice = 1;
	
	$s = $MASTER_GE->Execute("
		SELECT DISTINCT CL.xt_nombreCorto, PA.xn_fraccionArancelaria, CL.xt_rfc, FC.xt_descripcion, PE.xn_patente 
		FROM MASTER_PEDIMENTOS PE, MASTER_PARTIDAS PA, MASTER_RFC_CLIENTEID CL, MASTER_FRACCIONES_VULNERABLES FC 
		WHERE YEAR(PE.xd_fechaPago) = $showYear 
		AND MONTH(PE.xd_fechaPago) = $showMonth 
		AND PE.xt_referencia = PA.xt_referencia 
		AND PE.xn_patente IN (3061, 3371, 3034, 3925, 3633, 3009) 
		AND PA.xn_fraccionVulnerable = 1 
		AND PE.xt_nombre LIKE CL.xt_nombre 
		AND PE.xn_aduana = $showAduana 
		AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
		ORDER BY PE.xn_patente, PA.xn_fraccionArancelaria, CL.xt_rfc ");	
	
	while($r = $s->fetchRow()){
		$cliente[$indice] = $r[0];
		$fraccion[$indice] = $r[1];
		$rfc[$indice] = $r[2];
		$descripcion[$indice] = $r[3];
		$patente[$indice] = $r[4];
		
		$indice++;
		
	} unset($r); unset($s);
	
	///I VARIABLE DE INDICE DEL ARREGLO				
	$i = 1;
	do{
		///RENGLONES
		echo "<tr>";
			///CELDAS
			//U VARIABLE PARA CONTROLAR EL NUMERO DE CELDAS POR RENGLON
			$u = 1;
			do{
				echo"<td width='200px'  valign='top'>";
					echo "<table>";
						echo "<tr style='width: 200px; height: 20px;'>";
							echo "<td colspan='3' align='left' style='font-weight:bold; width: 200px; color: #007cbd;' id='fileItem'>";
								echo "<a href='#' title='".$descripcion[$i]."'><img src='../../Imagenes/ICN_Boletines.png' border=0 width='12' height='12'/></a> ".$fraccion[$i];
							echo "</td>";
						echo "</tr>";
						
						do{
							//MUESTRA CLIENTES
							echo "<tr style='width: 200px;' id='fileItem'>";
								echo "<td style='width: 10px;' align='left'> </td>";
								
								echo "<td style='width: 170px;' align='left'>";
									echo "<a href='tablero_Cliente.php?c=$rfc[$i]&y=$showYear&m=$showMonth'>";
										echo "<img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/>";
									echo "</a> ".$cliente[$i];
								echo "</td>";
								
								echo "<td style='width: 20px;' align='left'> </td>";
							echo "</tr>";
							
							$i++;
								
						} while(($fraccion[$i] == $fraccion[$i-1]) && ($i <= $indice));
						//echo "FIN DEL WHILE<BR>";
					echo"</table>";
				echo "</td>";
				
				$i++;
				
			} while(($u <= 4) && ($i <= $indice));
			
			if($u == 1){
				echo "<td width='200px'> </td>";
				echo "<td width='200px'> </td>";
				echo "<td width='200px'> </td>";
			} else if($u == 2){
				echo "<td width='200px'> </td>";
				echo "<td width='200px'> </td>";
			} else if($u == 3){
				echo "<td width='200px'> </td>";
			}
			
		echo "</tr>";
		
	} while($i <= $indice);


echo "<br><br><br><br>
</div>
<!--Fin de wrapper-->";
	
?>
	</body>
</html>