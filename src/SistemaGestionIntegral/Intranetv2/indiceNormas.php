<?php
 
$nombrephp = 'CapituloNorma.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

$norma = trim($_GET['norma']);

$nombreCompleto = $INTRANETV2->getOne("SELECT xt_nombreNorma FROM SGI_Catalogo_Normas WHERE xt_codigoNorma = '$norma'");



$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			   <a href='Normasv2.php' id='breadcrumbs'> Normas </a>";
			   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
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
            
	 		<?php
				echo "<title>".$nombreCompleto."</title>";
				
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
			?>
        </head>
        <body>
<?php

echo"<div id='wrapper' align='center'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo $nombreCompleto;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10'><td></td></tr>";
		
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
		
		//echo "<tr height='100'><td></td></tr>";
	echo "</table>";
	
				
		//banana de navegacion
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
	  include("../../navegacion_banana.php");
  	echo "</table>";

		echo "</td>";
	echo "</tr>";

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

	///CAPITULOS
	echo "<table border='0' align='center'>";
			
			
	
		$s = $INTRANETV2->Execute("SELECT xt_codigoIndice, xt_titulo FROM SGI_Normas_Texto WHERE xt_codigoIndice NOT LIKE '%.%' AND xt_codigoNorma = '$norma' ORDER BY CHAR(xt_codigoIndice)");
		
		while($r = $s->fetchRow()){
			
			echo "<tr>";
				echo "<td width='50' id='manualVinculo' valign='top'>".$r[0]."</td>";
				
				echo "<td width='650px' id='manualVinculo' valign='top'>";
					echo "<a id='manualVinculo' href='CapituloV2.php?norma=".$norma."&capitulo=".$r[0]."'>".$r[1]."</a>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10px'><td colspan='2'></td></tr>";
			
		} unset($r); unset($s);
	
		
		echo"<tr height='50px'><td colspan='2'></td></tr>";
	echo "</table>";
echo"</div>";
?>
		</body>
	</html>
<?php
