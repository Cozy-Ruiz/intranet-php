<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarContenidoFormatoPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contenido Formato</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>
</head>
<body>
<?php

$itemID = $_GET['itemID'];   

if( ($_POST['origenI'] == "") || ($_POST['tipoI'] == "") || ($_POST['responsableI'] == "") || ($_POST['almacenamientoI'] == "") || ($_POST['proteccionI'] == "") || ($_POST['recuperacionI'] == "")
        || ($_POST['retencionI'] == "") || ($_POST['disposicionI'] == "")){
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregarContenidoFormatoPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Contenido Formato</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='2'></td>";
			echo "</tr>";
	
			echo"<tr height='15'></tr>";
			
			echo "<tr id='origen'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Origen";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='origenI'>";
									echo "<option value='' selected></option>";
									echo "<option value='Interno'>Interno</option>";
									echo "<option value='Externo'>Externo</option>";
									echo "<option value='Interno/Externo'>Interno/Externo</option>";
								echo "</select><input type='hidden' value='$itemID' name='itemID'>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='tipo'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Tipo";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='tipoI'>";
									echo "<option value='' selected></option>";
									echo "<option value='Electrónico'>Electrónico</option>";
									echo "<option value='Impreso'>Impreso</option>";
									echo "<option value='Electrónico/Impreso'>Electrónico/Impreso</option>";
									echo "<option value='Papel'>Papel</option>";
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='responsable'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Responsable";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='responsableI'>";
									echo "<option value='' selected></option>";
									$s = $INTRANET->Execute("SELECT xt_opcionRegistro FROM SGI_Catalogo_Opciones_Registro WHERE xn_tipoRegistro = 1 ORDER BY xt_opcionRegistro ");
									while($r = $s->fetchRow()){
										echo "<option value='".$r[0]."'>".$r[0]."</option>";
									} unset($r); unset($s);
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='almacenamiento'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Almacenamiento";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='almacenamientoI'>";
									echo "<option value='' selected></option>";
									$s = $INTRANET->Execute("SELECT xt_opcionRegistro FROM SGI_Catalogo_Opciones_Registro WHERE xn_tipoRegistro = 2 ORDER BY xt_opcionRegistro ");
									while($r = $s->fetchRow()){
										echo "<option value='".$r[0]."'>".$r[0]."</option>";
									} unset($r); unset($s);
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='proteccion'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Protección";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='proteccionI'>";
									echo "<option value='' selected></option>";
									echo "<option value='Carpeta'>Carpeta</option>";
									echo "<option value='Electrónico'>Electrónico</option>";
									echo "<option value='Folder'>Folder</option>";
									echo "<option value='Electrónico/Expediente'>Electrónico/Expediente</option>";
									echo "<option value='N/A'>N/A</option>";
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='recuperacion'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Recuperación";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='recuperacionI'>";
									echo "<option value='' selected></option>";
									$s = $INTRANET->Execute("SELECT xt_opcionRegistro FROM SGI_Catalogo_Opciones_Registro WHERE xn_tipoRegistro = 3 ORDER BY xt_opcionRegistro ");
									while($r = $s->fetchRow()){
										echo "<option value='".$r[0]."'>".$r[0]."</option>";
									} unset($r); unset($s);
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='retencion'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Retención";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='retencionI'>";
									echo "<option value='' selected></option>";
									$s = $INTRANET->Execute("SELECT xt_opcionRegistro FROM SGI_Catalogo_Opciones_Registro WHERE xn_tipoRegistro = 4 ORDER BY xt_opcionRegistro ");
									while($r = $s->fetchRow()){
										echo "<option value='".$r[0]."'>".$r[0]."</option>";
									} unset($r); unset($s);
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='disposicion'>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Disposición";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='disposicionI'>";
									echo "<option value='' selected></option>";
									echo "<option value='Archivo Muerto'>Archivo Muerto</option>";
									echo "<option value='Destrucción'>Destrucción</option>";
									echo "<option value='Entrega a Autoridad Aduanera'>Entrega a Autoridad Aduanera</option>";
									echo "<option value='N/A'>N/A</option>";
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			
			echo"<tr height='20'> </tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
		
		echo "</form>";
	echo "</div>";

} else if( ($_POST['origenI'] != "") && ($_POST['tipoI'] != "") && ($_POST['responsableI'] != "") && ($_POST['almacenamientoI'] != "") && ($_POST['proteccionI'] != "") && ($_POST['recuperacionI'] != "")
        && ($_POST['retencionI'] != "") && ($_POST['disposicionI'] != "")){
	
	$itemID = $_POST['itemID'];
	$origen = $_POST['origenI'];
	$tipo = $_POST['tipoI'];
	$responsable = $_POST['responsableI'];
	$almacenamiento = $_POST['almacenamientoI'];
	$proteccion = $_POST['proteccionI'];
	$recuperacion = $_POST['recuperacionI'];
	$retencion = $_POST['retencionI'];
	$disposicion = $_POST['disposicionI'];
	
	if($INTRANET->Execute("INSERT INTO SGI_Registro_Contenido(kf_itemID, xt_origen, xt_tipo, xt_responsable, xt_almacenamiento, xt_proteccion, xt_recuperacion, xt_retencion, xt_disposicion)
							VALUES ($itemID, '$origen', '$tipo', '$responsable', '$almacenamiento', '$proteccion', '$recuperacion', '$retencion', '$disposicion') ")){
								
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='post' action='AgregarContenidoFormatoPopUp.php'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Contenido No Agregado</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "</form>";
		echo "</div>";
	}
}
?>
</body>
</html>