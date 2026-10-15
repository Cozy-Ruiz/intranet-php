<?php

$nombrephp='manuales.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once('../../ConexionIntranet2.php');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Manuales</title>
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
			
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home /</a><a href='../homeSGI.php' id='breadcrumbs'>Sistema de Gestión Integral</a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
	
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Manuales</font>";
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
		//echo"<tr height='100'> </tr>";
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

$indice = 0;
$s = $INTRANET->Execute("SELECT xt_codigoManual, xt_nombre FROM INTRANET2.SGI_Catalogo_Manuales order by xt_codigoManual");

		while($r = $s->fetchRow()){
			$codigo[$indice] = $r[0];
			$nombre[$indice] = $r[1];
			$indice++;
		}
echo "<table border='0' align='center' name='Cuerpo' width='450px'>";
//	for($listCer = 0; $listCer < count($tipoCertificaciones); $listCer++){
	for($a=0; $a<count($codigo); $a++){
		if($codigo[$a] == 'MC'){
			echo "<tr id='titulo2Blanco'>";
				echo "<td align='left' width='100px'>";
					echo "<a href='fichaManualv3.php?codManual=".$codigo[$a]."' id='manualVinculo2'><b><u>".$codigo[$a]."</u></b></a>";
				echo "</td>";
				echo "<td align='left' width='620'>";
					echo "<a href='fichaManualv3.php?codManual=".$codigo[$a]."' id='manualVinculo2'><b><u>".$nombre[$a]."</u></b></a>";
				echo "</td>";
			echo "</tr>";
			//echo"<tr height='5'>";
				//echo"<td colspan='2' id='titleBlueLineBottom'></td>";
			//echo"</tr>";
			echo"<tr height='20'></tr>";
		}
	}
echo "</table>";

echo "<table border='0' align='center' name='Cuerpo' width='450px'>";
	for($a=0; $a<count($codigo); $a++){
		if($codigo[$a] != 'MC'){
			echo "<tr id='titulo2Blanco'>";
				echo "<td align='left' width='100px'>";
					echo "<a href='fichaManualv3.php?codManual=".$codigo[$a]."' id='manualVinculo2'>".$codigo[$a]."</a>";
				echo "</td>";
				echo "<td align='left' width='620'>";
					echo "<a href='fichaManualv3.php?codManual=".$codigo[$a]."' id='manualVinculo2'>".$nombre[$a]."</a>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='20'> </tr>";
		}
	}
	echo"<tr height='50'> </tr>";
echo "</table>";
	
echo"</div>";
?>
</body>
</html><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
</body>
</html>