<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title></title>

</head>
<body>
<?php




	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaActividad' method='post' action='pagPHP.php'>";

			echo "<table border='0'  width='40%' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td height='25px' bgcolor='#FFF' align='center'><font color='#070707'>Aceptado</font></td>";
				echo"</tr>";
				echo "<tr height='10px'></tr>";
				echo "<tr>";	
					echo"<td height='25px' bgcolor='#FFF' align='center'><font color='#070707'>Rechazado</font></td>";
				echo "</tr>";	
				
				echo"<tr height='25px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
				echo "<td>Comentarios</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
	
				echo "<tr id='iconosTexto2'>";
					echo "<td>";
						echo "<textarea type='text'  rows='3'  cols='45' name='descripcion'></textarea>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				//seccion de subir archivo
				echo"<tr height='20'></tr>";
				echo "<tr>";
				echo "<td>Archivo</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
								
				echo "<tr id='subeArchivo'>";
					
					echo "<td>";
						echo "<div id='divFile'>
								<form enctype='multipart/form-data'>
									<fieldset style='width:40%'>
										<input type='file' name='archivo[]' id='archivo' multiple></input>
									</fieldset>
								</form> </div>";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
?>


