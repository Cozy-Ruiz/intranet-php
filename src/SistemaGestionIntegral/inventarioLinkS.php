<?php error_reporting(0); ?>
<?php
$nombrephp='inventarioLinkS.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tablero de Procesos</title>
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
$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos</a>";

echo"<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Listado de inventarios</font>";
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

			echo "<td align='center' width='225' >";
				echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/tableroProcesos.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a>";
			echo "</td>";
			
			echo "<td align='center' width='225' >";
				echo "<a href='tableroRoles.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a>";
			echo "</td>";
			
			echo "<td align='center' width='225' >";
				echo "<a href='tableroActividades.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a>";
			echo "</td>";
			
			echo "<td align='center' width='225' >";
				echo "<a href='tableroFuncionalidades.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr id='iconosTexto'>";
			
			echo"<td align='center' width='225' >";
				echo "Procesos";
			echo"</td >";
			
			echo"<td align='center' width='225' >";
				echo "Roles";
			echo"</td >";
			
			echo"<td align='center' width='225' >";
				echo "Actividades";
			echo"</td >";
			
			echo"<td align='center' width='225' >";
				echo "Funcionalidades";
			echo"</td >";
			
		echo"</tr>";
		
		echo"<tr height='100'> </tr>";
	echo "</table>";
echo"</div>";
?>
</body>
</html>