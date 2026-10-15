<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='Auditorias.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Auditorías</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
</head>

<body>
<?php
$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos</a>";

echo"<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Auditorías</font>";
			echo"</td>";
		echo"</tr>";
			echo"<tr height='10'> </tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='100'> </tr>";
	echo "</table>"; 

	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr >";
			echo "<td align='center' width='225' >";
				echo "<a href='tableroAuditorias.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a>";
			echo "</td>";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap')){
				echo "<td align='center' width='225' >";
					echo "<a href='altaAuditoriaPopUp.php'><img src='../Imagenes/ICN_NuevoDoc.png'></a>";
				echo "</td>";
			}else{ }
		echo "</tr>";
		
		echo"<tr id='iconosTexto'>";
			echo"<td align='center' width='225' >";
				echo "Tablero";
			echo"</td >";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap')){
				echo"<td align='center' width='225' >";
					echo "Añadir";
				echo"</td>";
			}else { }
		echo"</tr>";
	echo "</table>";
echo"</div>";
?>
</body>
</html>