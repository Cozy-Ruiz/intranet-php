<?php
/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'tablero_Cliente.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionImagenes.php");
require_once("../../compruebaUsuario.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if($_GET['rfc'] != ""){
	$cliente = $_GET['rfc'];	
}

$cliente = trim($cliente);
$nombre	= null;

$s = $INTRANET->Execute("SELECT xt_nombre FROM MASTER_GE.MASTER_RFC_CLIENTEID WHERE xt_rfc = '$cliente' ");
while($r = $s->fetchRow()){
	$nombre = $r[0];	
}

$currentYear = date('Y');

if($_GET['y'] != ""){
	
	 $showYear = $_GET['y'];
	
}else{
	
	if($_POST['year'] != ""){
	 $showYear = $_POST['year'];
	} else{
	 $showYear = $currentYear;	
	}
	
}
	


if($_POST['mes'] != ""){
	$showMonth = $_POST['mes'];
}else{
	$showMonth = "Todos";
}

///Obtiene la patente si fue pasado como parametro
if($_POST['patente'] != ""){
	$showPatente = $_POST['patente'];
}else{
	$showPatente = "Todas";
}

////
if($_POST['aduana'] != ""){
	$showAduana = $_POST['aduana'];
}else{
	$showAduana = "Todas";
}

$patente[0] = 3061;
$patente[1] = 3371;
$patente[2] = 3034;
$patente[3] = 3925;
//$patente[4] = 3633;
//$patente[5] = 3009;
//$patente[6] = 3621;

$aduanaValor[0] 	= 7;
$aduanaValor[1] 	= 16;
$aduanaValor[2] 	= 20;
$aduanaValor[3] 	= 24;
$aduanaValor[4] 	= 40;
$aduanaValor[5] 	= 43;
$aduanaValor[6] 	= 47;
$aduanaValor[7] 	= 53;
$aduanaValor[8] 	= 65;
$aduanaValor[9] 	= 80;

$aduanaShow[0] 		= "Cd. Juarez, Chih.";
$aduanaShow[1] 		= "Manzanillo, Col.";
$aduanaShow[2] 		= "Pantaco, México D.F.";
$aduanaShow[3] 		= "Nuevo Laredo, Tamps";
$aduanaShow[4] 		= "Tijuana, B.C.";
$aduanaShow[5] 		= "Veracruz, Ver.";
$aduanaShow[6] 		= "AICM, México D.F.";
$aduanaShow[7] 		= "Cancún, Q.Roo";
$aduanaShow[8] 		= "Toluca, Méx.";
$aduanaShow[9] 	= "Colombia, N.L.";

$mesNombre[0] 	= "Enero";
$mesNombre[1] 	= "Febrero";
$mesNombre[2] 	= "Marzo";
$mesNombre[3] 	= "Abril";
$mesNombre[4] 	= "Mayo";
$mesNombre[5] 	= "Junio";
$mesNombre[6] 	= "Julio";
$mesNombre[7] 	= "Agosto";
$mesNombre[8] 	= "Septiembre";
$mesNombre[9] 	= "Octubre";
$mesNombre[10] 	= "Noviembre";
$mesNombre[11] 	= "Diciembre";

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../aplicaciones.php' id='breadcrumbs'> Módulos / </a>
			   <a href='../operaciones.php' id='breadcrumbs'> Operaciones / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Clientes</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            <script src="../../css/jquery-1.9.1.js" charset="utf-8"></script>
            <script src="../../css/jquery-ui.js" charset="utf-8"></script>
            <script>
                $(function() {
                	$( document ).tooltip();
                });
            </script>
            
        </head>
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
			echo "<td align='center' id='titulo1'>Tablero Cliente</td>";
		echo "</tr>";
		
		echo "<tr>"; 
			echo "<td align='center'>".$breadcrumb."</td>";
		echo "</tr>";
		
		echo "<tr height='70'><td></td></tr>";
	echo "</table>";

	//MUESTRA CLIENTE
	if($cliente != ""){
		echo "<table align='center' id='titulo30Blanco'>";
			echo "<tr>";
				echo "<td><b>$nombre<b></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
		///Formulario para seleccionar Año y Mes a consultar
		echo "<form action='tablero_Cliente.php?rfc=$cliente'  method='POST'>";
			echo "<table align='center'>";
				echo "<tr id='fileItem'>";
					echo "<td align='center'>Seleccione año:</td>";
					echo "<td align='center'>Seleccione mes:</td>";
					echo "<td align='center'>Seleccione patente:</td>";
					echo "<td align='center'>Seleccione aduana:</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center' style='min-width: 110px; max-width: 110px;'>";
						echo "<input type='hidden' name='cliente' value='".$cliente."'>";
		
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
						echo "<select name='mes'>";
							echo "<option value='Todos' selected='selected'>Todos</option>";	
							///Muestra los meses consecutivamente
							for($o=0; $o<count($mesNombre); $o++){
								echo "<option value='".($o + 1)."'>".$mesNombre[$o]."</option>";	
							} unset($o);
						echo "</select>";
					echo "</td>";
					
					echo "<td align='center' style='min-width: 120px; max-width: 120px;'>";
						echo "<select name='patente'>";
							echo "<option value='Todas' selected='selected'>Todas</option>";
							///Muestra los meses consecutivamente
							for($o=0; $o<count($patente); $o++){
								echo "<option value='".$patente[$o]."'>".$patente[$o]."</option>";
							} unset($o);
						echo "</select>";
					echo "</td>";
						
					echo "<td align='center' style='min-width: 180px; max-width: 180px;'>";
						echo "<select name='aduana'>";
							echo "<option value='Todas' selected='selected'>Todas</option>";
							///Muestra la aduana seleccionada
							for($o=0; $o<count($aduanaValor); $o++){
								echo "<option value='".$aduanaValor[$o]."'>".$aduanaShow[$o]."</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='4' align='center'>";
						echo "<br><br><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='4'></td></tr>";
			echo "</table>";
		echo "</form>";
		
		$ftp_server = "71.144.19.155";
		$ftp_user 	= "Imagenes";
		$ftp_pass 	= "Img2012Server";
	
		//echo "CLIENTE: ".$cliente.", AÑO: ".$showYear.", MES: ".$showMonth.", ADUANA: ".$showAduana.", PATENTE: ".$showPatente."<br>";
		
		if($showPatente == "Todas"){
			if($showMonth == 'Todos'){
				$s = $INTRANET->Execute("SELECT DISTINCT p.xn_patente 
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and p.xn_patente in ('3061', '3371', '3925', '3034')
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}else if($showMonth != 'Todos'){
				$s = $INTRANET->Execute("SELECT DISTINCT p.xn_patente 
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear 
								and MONTH(p.xd_fechaPago) = $showMonth 
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and p.xn_patente in ('3061', '3371', '3925', '3034')
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}
		}else if($showPatente != "Todas"){
			if($showMonth == 'Todos'){
				$s = $INTRANET->Execute("SELECT DISTINCT p.xn_patente 
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $showPatente
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and p.xn_patente in ('3061', '3371', '3925', '3034')
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}else if($showMonth != 'Todos'){
				$s = $INTRANET->Execute("SELECT DISTINCT p.xn_patente 
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear
								and MONTH(p.xd_fechaPago) = $showMonth  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $showPatente
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}
		}
		while($r = $s->fetchRow()){
			$patente = $r[0];
			echo "<table border='0' align='center' width='900px'>";
				echo "<tr height='30px'><td colspan='2'></td></tr>";
				
				echo "<tr align='left' id='titulo2Blanco'>";
					echo "<td width='855px'>Patente: ".$patente."</td>";
					echo "<td width='45px'></td>";
				echo "</tr>";
				
				echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
				
				echo "<tr height='10px'><td></td></tr>";
			echo "</table>";
			
			if($showAduana == 'Todas'){
				$u = $INTRANET->Execute("SELECT DISTINCT p.xn_aduana 
									FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
									WHERE YEAR(p.xd_fechaPago) = $showYear  
									AND p.xt_rfcCausante = '$cliente'
									and p.xn_patente = $patente
									and p.xn_opVulnerable in (1, 2, 3)
									and pa.xt_referencia = p.xt_referencia
									and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}else if($showAduana != 'Todas'){
				$u = $INTRANET->Execute("SELECT DISTINCT p.xn_aduana 
									FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
									WHERE YEAR(p.xd_fechaPago) = $showYear  
									AND p.xt_rfcCausante = '$cliente'
									and p.xn_patente = $patente
									and p.xn_opVulnerable in (1, 2, 3)
									and p.xn_aduana like '".$showAduana."%'
									and pa.xt_referencia = p.xt_referencia
									and pa.xn_fraccionVulnerable in (1, 2, 3) ");
			}				
			while($t = $u->fetchRow()){
				$aduana = $t[0];
				$clave = array_search(substr($aduana,0,-1),$aduanaValor);
				echo "<table border='0' align='center' width='800px'>";
					echo "<tr align='left' id='titulo2Blanco'>";
						echo "<td>".$aduanaShow[$clave]."</td>";
					echo "</tr>";
					
					echo "<tr><td id='titleBlueLineTop'></td></tr>";
					
					echo "<tr height='10px'><td></td></tr>";
				echo "</table>";
				$w = $INTRANET->Execute("SELECT DISTINCT pa.xn_fraccionArancelaria 
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $patente
								and p.xn_aduana = $aduana
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");				
				while($v = $w->fetchRow()){	
					$fraccionArancelaria = $v[0];
					$y = $INTRANET->Execute("SELECT xt_descripcion  
								FROM MASTER_GE.MASTER_FRACCIONES_VULNERABLES 
								WHERE kp_CodigoFraccion = '$fraccionArancelaria' ");
					while($z = $y->fetchRow()){
						$descripcion = $z[0];
					}
					echo "<table border='0' align='center' width='700px'>";
						echo "<tr align='left' id='titulo2'>";	
							echo "<td width='700px'>";
								echo $fraccionArancelaria;
								echo "<a href='' title='".$descripcion."'>";
									echo "<img src='../../Imagenes/ICN_Boletines.png' border=0 width='15' height='15'/>";
								echo "</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					if($showMonth == 'Todos'){
						$y = $INTRANET->Execute("SELECT count(DISTINCT p.xt_referencia)
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $patente
								and p.xn_aduana = $aduana
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionArancelaria = $fraccionArancelaria
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
					}else if($showMonth != 'Todos'){
						$y = $INTRANET->Execute("SELECT count(DISTINCT p.xt_referencia)
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear
								and MONTH(p.xd_fechaPago) = $showMonth  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $patente
								and p.xn_aduana = $aduana
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionArancelaria = $fraccionArancelaria
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
					}
									
					while($x = $y->fetchRow()){
						$contador = $x[0];	
						echo "<table border='0' align='center' width='600px'>";
							echo "<tr id='iconosTexto2'>";
								echo "<th  width='50px' align='center' >(".$contador.")</th>";
								echo "<th  width='100px' align='center'>Referencia</th>";
								echo "<th  width='150px' align='center'>Pedimento</th>";
								echo "<th  width='100px' align='center'>Fecha</th>";
								echo "<th  width='100px' align='center'>Acuse</th>";
								echo "<th  width='100px' align='center'>Archivo</th>";
								echo "<th  width='100px' align='center'>OV</th>";
							echo "</tr>";
							
							echo "<tr><td colspan='7' id='titleBlueLineBottom'></td></tr>";
							echo "<tr height='10px'><td colspan='6'></td></tr>";
						echo "</table>";
					}
					
					if($showMonth == 'Todos'){
						$y = $INTRANET->Execute("SELECT DISTINCT p.xt_referencia, p.kp_pedimento, p.xd_fechaPago, xn_opVulnerable
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $patente
								and p.xn_aduana = $aduana
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionArancelaria = $fraccionArancelaria
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
					}else if($showMonth != 'Todos'){
						$y = $INTRANET->Execute("SELECT DISTINCT p.xt_referencia, p.kp_pedimento, p.xd_fechaPago, xn_opVulnerable
								FROM MASTER_GE.MASTER_PEDIMENTOS p, MASTER_GE.MASTER_PARTIDAS pa
								WHERE YEAR(p.xd_fechaPago) = $showYear  
								and MONTH(p.xd_fechaPago) = $showMonth
								AND p.xt_rfcCausante = '$cliente'
								and p.xn_patente = $patente
								and p.xn_aduana = $aduana
								and p.xn_opVulnerable in (1, 2, 3)
								and pa.xt_referencia = p.xt_referencia
								and pa.xn_fraccionArancelaria = $fraccionArancelaria
								and pa.xn_fraccionVulnerable in (1, 2, 3) ");
					}
					
					$index = 1;	
					echo "<table border='0' align='center' width='600px'>";			
					while($x = $y->fetchRow()){
						$referencia = $x[0];
						$pedimento = $x[1];
						$fechaPago = $x[2];
						$OV = $x[3];
						
						///Comprueba existencia Archivo M y obtiene la ruta si existe
						$z= $IMAGENES->Execute("SELECT xt_ruta FROM IMAGENES_PEDIMENTOS WHERE xt_referencia = '$referencia' AND xt_tipoDocumento = 'VALIDA' ");
						while($i = $z->fetchRow()){
							$archivo = $i[0];
							//$ruta[$indice] = $t[0];
							$acuse = "<img src='../../Imagenes/ICN_Boton_Azul.png' height='7' width='7'/>";
						} unset($t);
						
						echo "<tr id='fileItem'>";
							echo "<td width='50px' align='center'>".$index."</td>";
							//<a href='fichaIndividualPedimentos.php?referencia=$referencia[$e]&c=$cliente&y=$showYear&m=$showMonth'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a>
							echo "<td width='100px' align='center'>".$referencia."</td>";
							echo "<td width='150px' align='center'>".$pedimento."</td>";
							echo "<td width='100px' align='center'>".$fechaPago."</td>";
							echo "<td width='100px' align='center'>".$acuse."</td>";
							echo "<td width='100px' align='center'>";
								if($archivo != ""){
									echo "<a href='extraccionImagenPedimento.php?ruta=".$archivo."'>";
										echo "<img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'>";
									echo "</a>";
								}
							echo "</td>";
							echo "<td width='100px' align='center'>".$OV."</td>";
						echo '</tr>';
						
						$index++;
					}
					echo "</table>";
				}
			}
			
			echo "<table border='0' align='center' width='900px'>";
				echo "<tr height='30px'><td colspan='2'></td></tr>";
				echo "<tr align='left' id='titulo2Blanco'>";
					echo "<td width='855px'></td>";
					echo "<td width='45px'></td>";
				echo "</tr>";
				echo "<tr><td id='titleBlueLineTop'></td><td></td></tr>";
				echo "<tr height='10px'><td></td></tr>";
			echo "</table>";
			
		}	
	}
		
	echo "<table border=0 align='center'>";
		echo "<tr height='50px'><td></td></tr>";
	echo "</table>";
//termina wrapper
echo "</div><!--Fin de wrapper-->";
?>
	</body><!--Termina body-->
</html><!--Termina html-->

<?
