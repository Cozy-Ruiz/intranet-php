<?php error_reporting(0); ?>
<?php
$nombrephp = 'AgregarReunion.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Agregar Reunión</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?> 
<?php
if($_POST['id'] != ""){
	$id = $_POST['id'];
} else if($_GET['id'] != ""){
	$id = $_GET['id'];
}

//echo "ID:$id<br>";

if($_POST["N2_1"] != NULL){
	$item = $_POST["N2_1"];
	//echo "UPDATE SGI_Registros SET xt_contenido = '$item' WHERE kf_itemID = $id AND xt_campo = '$item' <br>";
	$INTRANET->Execute("UPDATE SGI_Registros SET xt_contenido = '$item' WHERE kf_itemID = $id AND xt_campo = 'N2_1' ");
}

if($_POST["N2_2"] != NULL){
	$item = $_POST["N2_2"];
	//echo "UPDATE SGI_Registros SET xt_contenido = '$item' WHERE kf_itemID = $id AND xt_campo = '$item' <br>";
	$INTRANET->Execute("UPDATE SGI_Registros SET xt_contenido = '$item' WHERE kf_itemID = $id AND xt_campo = 'N2_2' ");
}

?>

</head>

<body> 
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'>Sistema de Gestión Integral/ </a>";


echo"<div id='wrapperFicha' align='center'>";
	echo "<form name='Encabezado' method='POST' action='AgregarReunion.php'>";	
		echo "<table border='0' align='center' name='Encabezado'>";		
			echo"<tr height='80px'> </tr>";
		///Titulo 
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
					echo "Agrega Reunión";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
			echo"</tr>";		
			echo"<tr height='50'> </tr>";		
		echo "</table>";	
	//LINEA
		echo"<table border='0' align='center' width='800'>";
				
				echo"<tr height='50px'></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";		
		echo"</table>";
	
	//Temas a tratar 2
		echo"<table border='0' align='center' width='700'>";
				
				echo"<tr height='50px'></tr>";

				echo "<tr>";
					echo "<td id='titulo2' colspan='2'><b> 2. Temas a tratar</b></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='20'></tr>";
				
				$valor = $INTRANET->getOne("SELECT xt_contenido FROM SGI_Registros WHERE kf_itemID = $id AND xt_campo = 'N2_1' ");
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Resultado de las auditorías <input type='hidden' name='id' value='$id'></td> </tr>";
				
				echo"<tr> 
						<td width='20'> </td> 
						<td> 
							<textarea  name='N2_1' style='width: 600px; height:50px;'>$valor</textarea><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>
						</td>
					</tr>";
				
				echo"<tr height='20'></tr>";
				
				
				$valor = $INTRANET->getOne("SELECT xt_contenido FROM SGI_Registros WHERE kf_itemID = $id AND xt_campo = 'N2_2' ");
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Retroalimentación del cliente: Quejas </td> </tr>";
				echo"<tr>
						<td width='20'> </td> 
						<td>
							<textarea name='N2_2' style='width: 600px; height:50px;'>$valor</textarea><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>
						</td>
					</tr>";
								
				echo"<tr height='20'></tr>";
				
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Retroalimentación del cliente: Cuestionario de satisfacción del cliente </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.3.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				
				
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Estado de acciones preventivas y correctivas</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.4.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Seguimiento de revisiones gerenciales anteriores: Compromisos anteriores</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.5.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				
				
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Cambios que podrían afectar al SGI</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.6.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Recomendaciones para la mejora</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.7.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Necesidades de recursos</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.8.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				
				
				
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Política de calidad </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.9.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Objetivos de calidad </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.10.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				
				
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Revisión de Indicadores de Desempeño </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.11.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Planeación Estratégica</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.12.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Seguridad</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.13.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Otros</td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.14.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Ronda de Sugerencias </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.15.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Exámenes de entrenamiento en ISO 9001 </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <textarea name='2.16.' style='width: 600px; height:100px;' > </textarea> </td> </tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Revisión y reaprobación de documentos que integran el SGI </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <input type='text' name='2.17.' size='100' > </td> </tr>";
				
				echo"<tr height='20'></tr>";		

		echo"</table>";
		
	//3 Resultados de la revision
		echo"<table border='0' align='center' width='700'>";
				
				echo"<tr height='50px'></tr>";

				echo "<tr>";
					echo "<td id='titulo2' colspan='2'><b> 3. Resultados de la revisión</b></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='20'></tr>";
				
				echo "<tr> <td width='20'> </td> <td id='iconosTexto'> Resultados </td> </tr>";
				echo"<tr> <td width='20'> </td> <td> <textarea name='3.1.' style='width: 600px; height:100px;' > </textarea> </td> </tr>";

		echo"</table>";
	
	echo "</form>";
echo "</div>";
?>

</body>
</html>