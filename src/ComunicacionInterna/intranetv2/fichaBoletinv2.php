<?php

$nombrephp='fichaBoletin.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Boletín</title>
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

$claveBoletin = $_REQUEST['id'];

$fecha 			= "";
$titulo 		= "";
$descripcion 	= "";
$ruta 			= "";



$s= $INTRANETV2-> Execute("SELECT xd_fecha, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Boletines WHERE xt_claveBoletin = '$claveBoletin'");

while($r = $s->fetchRow($s)){
	$fecha 			= $r[0];
	$titulo 		= $r[1];
	$descripcion 	= $r[2];
	$ruta 			= $r[3];
	

} unset($r); unset($s);

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			 <a href='TableroBoletinesv2.php' id='breadcrumbs'> Tablero de Boletines </a>";

echo "<div id='wrapper'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Boletín</font>";
			echo"</td>";
		echo"</tr>";
		
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
		
		echo"<tr height='70'><td> </td></tr>";
	echo "</table>";
	
	
		echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			include("../../navegacion_banana.php");
		echo "</table>";
	echo "</td>";
	echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		
	//CUERPO FICHA
	echo "<table border='0' align='center' width='700px'>";
		echo"<tr>";
			echo "<td id='iconosTexto2' align='left' width='350px'><b>".$claveBoletin."</b></td>";
			echo "<td id='iconosTexto2' align='right' width='350px'><b>".$fecha."</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
		echo "</tr>";
		
		echo"<tr height='30'><td colspan='2'> </td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td> </td>";
			
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
			
			echo "<td id='iconosTexto' align='right'>";
			
				if($ruta != ""){
					echo"<a href='downloadBoletin.php?file=".$ruta."'><img src='../../Imagenes/ICN_Archivo.png'></a>";
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='4'> </td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'> </td>";
			echo "<td width='20px'> </td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td width='50px'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	//Despliegue de pdf
	if($ruta != ""){
		if(substr($ruta, -4) == ".pdf"){
			echo "<br><br>";
			echo "<div id='wrapperBoletin'>";
				echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../Boletines/".$ruta))."'\" type='application/pdf' width='950px' height='700px' align='left'>";
					echo "<p>";
						echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
						echo "No obstante puede descargar el archivo en este <a href='".$ruta."'>enlance</a>";
					echo "</p>";
				echo "</object>";
			echo "</div>";
			echo "<br><br>";
		} 
	}
	
	echo "<table border='0' align='center' width='700px'>";
	
		echo "<tr height='20px'><td> </td></tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700px'></td>";
		echo "</tr>";
		
		echo "<tr>";
			//echo "<td align='center' id='breadcrumbs' width='700px'><i><a href='imprimeFichaBoletin.php?id=$claveBoletin' id='breadcrumbs'> Imprimir </a></i></td>";
		echo "</tr>";
		
		echo "<tr height='50px'><td> </td></tr>";
		
	echo "</table>";

?>
    	</body>
    </html>
<?php
