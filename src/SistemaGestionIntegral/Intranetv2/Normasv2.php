<?php

$nombrephp = 'Normas.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Normas</title>
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

echo "<table table border='0' align='center' name='Encabezado' width='800px'>";

	echo"<tr height='80px'><td></td></tr>";
	echo "<tr>";
		echo "<td id='breadcrumbs' width='200px'>Usuario: ".$usuarioId."</td>";
	echo "</tr>";

	echo"<tr height='80px'> </tr>";
echo "</table>";
			
echo "<div align='center' width='80%'>";
	echo "<table border='0' align='center' name='Encabezado' width='100%'>";
	
		
		
		echo "<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Normas</font>";
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
	
	
				
				//banana de navegacion
				echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				  include("../../navegacion_banana.php");
			  echo "</table>";
			  
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='130px'><td></td></tr>";
	echo "</table>"; 
			
	//OBTENGO NORMAS
	$indexN = 0;
	$s = $INTRANETV2->Execute("SELECT xt_codigoNorma, xt_nombreNorma FROM SGI_Catalogo_Normas");
	while($listNorma = $s->fetchRow()){
		
		$codNorma[$indexN] = trim($listNorma[0]);
		$nomNorma[$indexN] = trim($listNorma[1]);
		$indexN++;
		
	}

	echo "<table border='0' align='center' name='Cuerpo' CELLSPACING='0' CELLSPACING='0'>";
		echo "<tr align='center'>";
			
			for($j=0; $j< count($codNorma); $j++){
				
				$codNormaMod = $codNorma[$j];
				
				//if($codNormaMod == "OEA"){
					
					//$codNormaMod = "NEEC";
					
				//}
			
				echo "<td valign='top' align='center' width='300'>";
					echo "<a href='indiceNormas.php?norma=$codNorma[$j]' style='face:Arial; color:rgb(0,118,188); font-size: 30pt'>$codNormaMod</a>";
					
				echo "</td>";
				
			}
		echo"</tr>";
			
			/*if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'sdelap')){
			echo "<tr align='center' colspan = '6'>";
				echo "<td align='center' width='300'>";
					echo "<a href='certificacion_excel.php' style='face:Arial; color:rgb(0,118,188); font-size: 30pt' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_NuevoDoc.png'> </a>";
				
					//echo "<a href='certificacion_excel.php' style='face:Arial; color:rgb(0,118,188); font-size: 30pt'><img src='../../Imagenes/ICN_NuevoDoc.png'></a>";
				echo "</td>";
			echo"</tr>";
			}else{
				
			}*/
			
		echo "</tr>";
			
		echo "<tr align='center'>";
			
			for($e=0; $e< count($codNorma); $e++){
				
				echo "<td valign='top' align='center' width='300' >";
					echo $nomNorma[$e];
				echo "</td>";
				
			}
		/*	echo "<td align='center' width='300' >";
				echo "Añadir Nuevo";
			echo "</td>";
			
		echo "</tr>";
			
		*/
	
	echo "</table>";
	
	echo "<table border='0' align='center' name='Cuerpo'>";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'sdelap')){
			echo "<tr height = 30></tr>";
			echo "<tr align='right'>";
				echo "<td  align='right' width='1200'></td>";
				echo "<td width='100'></td>";
				echo "<td width='200' align='center'>";
					echo "<a href='certificacion_excel.php' style='face:Arial; color:rgb(0,118,188); font-size: 30pt' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_NuevoDoc.png'> </a>";
				
					//echo "<a href='certificacion_excel.php' style='face:Arial; color:rgb(0,118,188); font-size: 30pt'><img src='../../Imagenes/ICN_NuevoDoc.png'></a>";
				echo "</td>";
				//echo "<td align='right' width='100'></td>";
			echo"</tr>";
			}else{
				
			}
			
		echo "</tr>";
			
		echo "<tr align='center'>";
			echo "<td></td>";
			echo "<td width='100'></td>";
			echo "<td align='center' >";
				echo "Añadir Nuevo";
			echo "</td>";
			
		echo "</tr>";

	
	echo "</table>";
	
echo"</div>";
			
echo "<table align='right' width='45%' border='0'>";
		echo "<tr>";
			echo "<td>";	
				echo "<table align='right' width='80%' border='0'>";
					echo "<tr height='50px'></tr>";
					echo "<tr>";
						echo "<td align='right'>";
							echo "<a href='downloadFormatoNorma.php?file=formatoDatosNorma.xlsx' style='font-family: Lucida Sans, Arial; font-size: 10px; color:rgb(0,118,188);'><b>Descarga Formato</b></a>";
						echo "</td>";

						echo "<td align='center'>";
							echo "<a href='downloadFormatoNorma.php?file=ejemploExcelNorma_ISO.xlsx' style='font-family: Lucida Sans, Arial; font-size: 10px; color:rgb(0,118,188);'><b>Descarga Ejemplo</b></a>";
						echo "</td>";
					echo "</tr>";

					echo "<tr height='30px'></tr>";

				echo "</table>";
			
			echo "</td>";
		echo "</tr>";
echo "</table>";
	

?>
</body>
</html>