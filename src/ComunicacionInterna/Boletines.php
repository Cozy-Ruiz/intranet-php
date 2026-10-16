<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp="Boletines.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Boletines</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
</head>
<body>

<?PHP
$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a><a href='comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna</a>";

echo"<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Boletines</font>";
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
				echo "<a href='TableroBoletines.php'><img src='../Imagenes/ICN_ListaMaestra.png'></a> ";
			echo "</td>";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap')
				||($usuarioId == 'Pedro_Moyotl')){
				echo "<td align='center' width='225' >";
					echo "<a href='AgregaBoletin.php'><img src='../Imagenes/ICN_NuevoDoc.png'> ";
				echo "</td>";
			}else{
				
			}
		echo "</tr>";
		
		echo"<tr id='iconosTexto'>";
			echo"<td align='center' width='225' >";
				echo " Tablero de Boletines";
			echo"</td >";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap')
				||($usuarioId == 'Pedro_Moyotl')){
				echo"<td align='center' width='225' >";
					echo "Añadir";
				echo"</td>";
			}else{
				
			}
		echo"</tr>";
	echo "</table>";
echo"</div>";


?>
</body>
</html>