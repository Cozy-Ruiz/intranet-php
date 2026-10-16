<?php error_reporting(0); ?>
<?php
$nombrephp="Registros.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Registros</title>
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
            
        </head>
        <body>
<?php

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home </a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
	
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Registros</font>";
			echo"</td>";
		echo"</tr>";
			echo"<tr height='10'> </tr>";
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
		//echo"<tr height='100'> </tr>";
	echo "</table>"; 
	
	
				
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
			
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	

	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr >";
			echo "<td align='center' width='300' >";
				echo "<a href='./Intranetv2/tableroRegistrosv2.php'><img src='../Imagenes/ICN_ListaMaestra.png'> ";
			echo "</td>";
			
			echo "<td align='center' width='300' >";
				echo "<a href='TableroVisitas2.php'><img src='../Imagenes/ICN_Visitas.png'></a> ";
			echo "</td>";
			
			echo "<td align='center' width='300' >";
				echo "<a href='#'><img src='../Imagenes/ICN_Site.png'> ";
			echo "</td>";
			/*
			echo "<td align='center' width='300' >";
				echo "<a href='#'><img src='../Imagenes/ICN_Estacionamiento.png'> ";
			echo "</td>";
			*/
		echo "</tr>";
		
		echo"<tr id='iconosTexto'>";
			echo"<td align='center' width='300' >";
				echo "Lista de Registros";
			echo"</td >";
			echo"<td align='center' width='300' >";
				echo " Visitas";
			echo"</td >";
			echo"<td align='center' width='300' >";
				echo "Site";
			echo"</td>";
			/*
			echo"<td align='center' width='300' >";
				echo "Estacionamiento";
			echo"</td>";
			*/
		echo"</tr>";
	echo "</table>";
echo"</div>";


?>
</body>
</html>