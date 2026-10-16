<?php
/*
 *@author Abam Donoso Samantha
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'listaClientes.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

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
            <!-- <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png"> -->
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

	<?PHP
	
//$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
//<a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos </a>";
	$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
	<a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";
			   
			   
	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			
			echo"<tr height='80px'> </tr>";
			
			echo "<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Lista de Clientes</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='10'> </tr>";
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
		echo "</table>";
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../../navegacion_banana.php");
			echo "</table>";
			
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

	echo "<table border='0' align='center' name='Cuerpo' width='900'>";
	
		echo "<tr>";
			echo "<td colspan='4' id='titulo2Blanco'>OV 1</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td colspan='4' id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='20'><td></td></tr>";
		
		$year = date("Y");
		$year = $year - 5;
		
		//echo "$year";

		$s = $INTRANET->Query(" call MASTER_GE.sp_OperacionesVulnerablesCliente(1);");
		
		/*$s = $INTRANET->Execute(
				"SELECT distinct p.xt_rfcCausante, rfc.xt_nombreCliente, COUNT(XT_REFERENCIA) Operaciones
				FROM MASTER_GE.MASTER_PEDIMENTOS p 
					INNER JOIN MASTER_GE.MASTER_CLIENTES_FRAC_VULNERABLES rfc ON rfc.kp_rfcCliente = p.xt_rfcCausante
				where p.xn_opVulnerable = 1 
				and p.xn_patente in ('3061', '3371', '3925', '3034')
				and year(p.xd_fechaPago) >= $year
				and p.xd_fechaPago >= '2014-06-01' 
				GROUP BY p.xt_rfcCausante, rfc.xt_nombreCliente
				HAVING COUNT(XT_REFERENCIA) > 0
				ORDER BY p.xt_rfcCausante asc");*/
		
		// --(select rfc.xt_nombreCliente from MASTER_GE.MASTER_CLIENTES_FRAC_VULNERABLES rfc where rfc.kp_rfcCliente = p.xt_rfcCausante) 
		// --FROM MASTER_GE.MASTER_PEDIMENTOS p 
		// --where p.xn_opVulnerable = 1 
		// --and p.xd_fechaPago > '2014-06-01' 
		// --ORDER BY p.xt_rfcCausante asc

		while($r = $s ->fetchRow()){
			
			$rfcCliente 	= $r[0];
			$nombreCliente 	= $r[1];
			$oper 	= $r[2];

			$numarchivos 	= $INTRANET->getOne("SELECT COUNT(xt_tipoDocumento) FROM IMAGENES.IMAGENES_FRACCIONES_VULNERABLES WHERE xt_clienteRFC = '$rfcCliente'");
			//echo"$numarchivos";
			echo "<tr>";
			if($numarchivos == '8'){
					echo"<td width='20'>";
						echo"<img src='../../Imagenes/ICN_Certif.png' width='15' height='15'></img>";
					echo"</td>";
				}else{
					echo "<td align='left' id='titulo2Blanco' width='50'>";
					echo"<a id='iconosTexto2'>(".$numarchivos."-8)</a>";
				echo "</td>";
				}
				//Declaro Variable antes de enviar por urlencode
				//$nuevorfc = "$rfcCliente";
				
				echo"<td width='20'>";
					echo"<a href='clienteDocs.php?rfcCliente=". urlencode($rfcCliente) ."&usuario=". urlencode($usuarioId) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				/*
				echo"<td width='20'>";
					echo"<a href='https://71.144.19.155/INTRANET_GEA/Aplicaciones/FraccionesVulnerables/clienteDocs.php?rfcCliente=". urlencode($nuevorfc) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				*/
				echo "<td align='left' id='titulo2Blanco' width='100'>";
					echo"<a id='manualVinculo' href='tablero_Cliente.php?rfc=". urlencode($rfcCliente) ."'>".$rfcCliente."</a>";
				echo "</td>";
				
				echo "<td align='left' id='titulo2Blanco' width='760' name = 'nombreCliente'>";
					echo "$nombreCliente - ($oper)";
				echo "</td>";
											
			echo "</tr>";
		}
		
		echo "<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td colspan='4' id='titulo2Blanco'>OV 2</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td colspan='4' id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='20'><td></td></tr>";
		
		$s = $INTRANET->Execute(" call MASTER_GE.sp_OperacionesVulnerablesCliente(2);");
		/*$s = $INTRANET->Execute("SELECT distinct p.xt_rfcCausante, 
				(select rfc.xt_nombreCliente from MASTER_GE.MASTER_CLIENTES_FRAC_VULNERABLES rfc where rfc.kp_rfcCliente = p.xt_rfcCausante) 
				FROM MASTER_GE.MASTER_PEDIMENTOS p where p.xn_opVulnerable = 2 
				AND p.xt_rfcCausante NOT IN (SELECT DISTINCT p.xt_rfcCausante FROM MASTER_GE.MASTER_PEDIMENTOS p WHERE p.xn_opVulnerable in (1)) 
				and p.xd_fechaPago > '2014-06-01' 
				and p.xn_patente in ('3061', '3371', '3925', '3034') 
				ORDER BY p.xt_rfcCausante asc");*/
		
		while($r = $s ->fetchRow()){
			
			$rfcCliente 	= $r[0];
			$nombreCliente 	= $r[1];
			$numarchivos 	= $INTRANET->getOne("SELECT COUNT(xt_tipoDocumento) FROM IMAGENES.IMAGENES_FRACCIONES_VULNERABLES WHERE xt_clienteRFC = '$rfcCliente'");
			//echo"$numarchivos";
			echo "<tr>";
				echo "<td align='left' id='titulo2Blanco' width='50'></td>";
				//Declaro Variable antes de enviar por urlencode
				//$nuevorfc = "$rfcCliente";
				
				echo"<td width='20'>";
					echo"<a href='clienteDocs.php?rfcCliente=". urlencode($rfcCliente) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				/*
				echo"<td width='20'>";
					echo"<a href='https://71.144.19.155/INTRANET_GEA/Aplicaciones/FraccionesVulnerables/clienteDocs.php?rfcCliente=". urlencode($nuevorfc) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				*/
				echo "<td align='left' id='titulo2Blanco' width='100'>";
					echo"<a id='manualVinculo' href='tablero_Cliente.php?rfc=". urlencode($rfcCliente) ."'>".$rfcCliente."</a>";
				echo "</td>";
				
				echo "<td align='left' id='titulo2Blanco' width='760' name = 'nombreCliente'>";
					echo "$nombreCliente";
				echo "</td>";
			echo "</tr>";
		}
		
		echo "<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td colspan='4' id='titulo2Blanco'>OV 3</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td colspan='4' id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='20'><td></td></tr>";

		$s = $INTRANET->Execute(" call MASTER_GE.sp_OperacionesVulnerablesCliente(3);");		
		/*$s = $INTRANET->Execute("SELECT distinct p.xt_rfcCausante, 
				(select rfc.xt_nombreCliente from MASTER_GE.MASTER_CLIENTES_FRAC_VULNERABLES rfc where rfc.kp_rfcCliente = p.xt_rfcCausante) 
				FROM MASTER_GE.MASTER_PEDIMENTOS p 
				where p.xn_opVulnerable = 3 
				AND p.xt_rfcCausante NOT IN (SELECT DISTINCT p.xt_rfcCausante FROM MASTER_GE.MASTER_PEDIMENTOS p WHERE p.xn_opVulnerable in (1,2)) 
				and p.xd_fechaPago > '2014-06-01' 
				and p.xn_patente in ('3061', '3371', '3925', '3034') 
				ORDER BY p.xt_rfcCausante asc");*/
		
		while($r = $s ->fetchRow()){
			
			$rfcCliente 	= $r[0];
			$nombreCliente 	= $r[1];
			$numarchivos 	= $INTRANET->getOne("SELECT COUNT(xt_tipoDocumento) FROM IMAGENES.IMAGENES_FRACCIONES_VULNERABLES WHERE xt_clienteRFC = '$rfcCliente'");
			//echo"$numarchivos";
			echo "<tr>";
				echo "<td align='left' id='titulo2Blanco' width='50'></td>";
				//Declaro Variable antes de enviar por urlencode
				//$nuevorfc = "$rfcCliente";
				
				echo"<td width='20'>";
					echo"<a href='clienteDocs.php?rfcCliente=". urlencode($rfcCliente) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				/*
				echo"<td width='20'>";
					echo"<a href='https://71.144.19.155/INTRANET_GEA/Aplicaciones/FraccionesVulnerables/clienteDocs.php?rfcCliente=". urlencode($nuevorfc) ."'><img src='../../Imagenes/ICN_Boton_Azul.png'></img></a>";
				echo"</td>";
				*/
				echo "<td align='left' id='titulo2Blanco' width='100'>";
					echo"<a id='manualVinculo' href='tablero_Cliente.php?rfc=". urlencode($rfcCliente) ."'>".$rfcCliente."</a>";
				echo "</td>";
				
				echo "<td align='left' id='titulo2Blanco' width='760' name = 'nombreCliente'>";
					echo "$nombreCliente";
				echo "</td>";
			echo "</tr>";
		}		
		
	echo "</table>";

echo"</div>";

?>
</body>
</html>