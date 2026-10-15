<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.1
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'Capitulo.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

 error_reporting(E_PARSE);


$norma 		= $_GET['norma'];
$nombreNorma = $norma;

if($norma == "QCB"){
	$nombreNorma = "NMX";
	
}
$capitulo 	= $_GET['capitulo'];

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'>Home /</a><a href='../homeSGI.php' id='breadcrumbs'>Sistema de Gestión Integral /</a> 
			   <a href='Normasv2.php' id='breadcrumbs'> Normas /</a><a href='indiceNormas.php?norma=$norma' id='breadcrumbs'> Capitulos </a>";
			
$indice 	= 1;
$niveles 	= 1;
$bandera 	= 1;



$s = $INTRANETV2->Execute("SELECT
						xt_codigoIndice,
						xt_titulo,
						xt_texto,
						xt_notasExplicativas
					FROM
						SGI_Normas_Texto
					WHERE
						xt_codigoNorma = '$norma'
					AND(
						xt_codigoIndice LIKE '$capitulo'
					OR xt_codigoIndice LIKE '$capitulo.%'
					)
					ORDER BY INET_ATON(SUBSTRING_INDEX(CONCAT(xt_codigoIndice,'.0.0.0'),'.',4))");

while($r = $s->fetchRow()){
	
	$codigo[$indice] 		= $r[0];
	$titulo[$indice] 		= $r[1];
	$texto[$indice] 		= $r[2];
	$notasExpli[$indice]	= $r[3];
	
	$subnivel 		= explode('.', $codigo[$indice]);
	$nivel[$indice] = count($subnivel);
	
	if($nivel[$indice] > $niveles){
		
		$niveles =  $nivel[$indice];
		$bandera = $indice;
		
	}
	
	$documento[$indice] = "";
	
	
	$t = $INTRANETV2->Execute("SELECT
					NID.xt_codigoDocumento,
					MD.xt_nombre,
					NID.xt_indiceDocumento,
					MD.xt_codigoCompleto
				FROM
					SGI_Normas_Incisos_Documentos NID,
					SGI_Manuales_Documentos MD
				WHERE
					NID.xt_codigoDocumentoNorma = '$norma'
				AND NID.xt_indiceDocumentoNorma = '$codigo[$indice]'
				AND NID.xt_codigoDocumento = MD.xt_codigoDocumento
				ORDER BY
					NID.xt_codigoDocumento");
					
	
	
	while($u = $t->fetchRow()){
		
		$tmp = "<a href='fichaDocumentov3.php?id=".$u[0]."' id='breadcrumbs'>";
		$tmp = $tmp.$u[3].", ".$u[2]." ".$u[1];
		$tmp = $tmp."</a>";
		
		
		
		if(substr_count($documento[$indice], $tmp) == 0){
			 $documento[$indice] = $documento[$indice].$tmp."<br>";
		}
		
	} unset($u); unset($t);
	
	
	/*$t = $INTRANET->Execute("
	SELECT ITM.xt_nombre, ITM.kp_itemID, xt_codigo 
	FROM SGI_CapituloElemento CEL, SGI_CapituloElemento_Certificaciones CEC, SGI_Item ITM 
	WHERE CEC.xt_norma = '$norma' AND CEC.kf_codigoID = '$codigo[$indice]' AND CEC.kf_capituloElementoID = CEL.kp_capituloElementoID 
	AND CEL.kf_itemID = ITM.kp_itemID ORDER BY ITM.xt_grupo, ITM.xt_area, ITM.xt_tipo, ITM.xn_consecutivo, ITM.xt_ciudad ");
	
	while($u = $t->fetchRow()){
		
		$tmp = "<a href='FichaItem.php?id=".$u[1]."' id='breadcrumbs'>";
		$tmp = $tmp.$u[2]." ".$u[0];
		$tmp = $tmp."</a>";
		
		if(substr_count($documento[$indice], $tmp) == 0){
			$documento[$indice] = $documento[$indice].$tmp."<br>";
		}
		
	} unset($u); unset($t);*/
	
	$indice++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <?php
				echo "<title>Capítulo $capitulo $norma</title>";
			
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

echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		///Titulo Ficha
		echo "<tr>";
			echo "<td align='center' id='titulo1' >".$nombreNorma."</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		///Bread Crumb
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
		
			
			//banana de navegacion de intranet
			 
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
			
	

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>";
//echo"</tr>"; 
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr height='10px'><td></td></tr>";
		///Capitulo
		echo "<tr>";
			echo "<td align='center' id='titulo1' width='700px'>";
				echo $codigo[1].". ".$titulo[1];
			echo "</td>";
		echo "</tr>";
		////DocsRefCapitulo
		if($documento[1] != ""){
			echo "<tr>";
				echo "<td align='center' >".$documento[1]."</td>";
			echo "</tr>";
			
			echo "<tr height='60px'><td></td></tr>";
			
		} else{
			
			echo "<tr height='80px'><td></td></tr>";
		}
		
		echo "<tr>";
			echo "<td align='justify' id='iconosTexto'>";
				echo $texto[1];
			echo "</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'>";
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	if($indice >= 2){
		//echo "<tr><td colspan='$niveles'>niveles:$niveles, </td></tr>";
		for($a = 2; $a <= count($codigo); $a++){
			
			if($nivel[$a] == 2){
				$ancho = 680;
			} else if($nivel[$a] == 3){
				$ancho = 660;
			} else if($nivel[$a] == 4){
				$ancho = 640;
			} else if($nivel[$a] == 5){
				$ancho = 620;
			} else if($nivel[$a] == 6){
				$ancho = 600;
			} else if($nivel[$a] == 7){
				$ancho = 580;
			} else if($nivel[$a] == 8){
				$ancho = 560;
			} else if($nivel[$a] == 9){
				$ancho = 540;
			} else if($nivel[$a] == 10){
				$ancho = 520;
			}
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td></td>";
					echo "<td align='left'>";
						echo "<a name='".$codigo[$a]."' id='iconosTexto'>";
							echo "<b>".$codigo[$a]." ".$titulo[$a]."</b>";
						echo "</a>";
					echo "</td>";
				echo "</tr>";
				
				if($documento[$a] != ""){
					echo "<tr>";
						echo "<td></td>";
						echo "<td align='left' >".$documento[$a]."</td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='2'></td></tr>";
					
				}
				
				echo "<tr>";
					echo "<td width='".(700-$ancho)."'></td>";
					echo "<td width='".$ancho."' id='fileItem' align='justify'>".$texto[$a]."</td>";
				echo "</tr>";
			echo "</table>";
			
			
			if($notasExpli[$a] != ""){
				
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'><td colspan='3'></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td id='fileItem' align='justify' colspan='2'>";
							echo "<b><i>Notas Explicativas</i></b>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='3'></td></tr>";
					
					echo "<tr>";
						echo "<td width='".(700-$ancho)."px'></td>";
						echo "<td width='20px'></td>";
						echo "<td width='".($ancho-30)."px' id='fileItem' align='justify'>";
							echo "<i id='texto10Blanco'>".nl2br($notasExpli[$a])."</i>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			
			}
			
			echo "<table>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
				
		}
	}
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'><td></td></tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='700px'></td>";
		echo "</tr>";
		
		echo"<tr height='40px'><td></td></tr>";
	echo "</table>";
	
echo"</div>";
?>
		</body>
	</html>
<?php
