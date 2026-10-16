<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarContenidoProcedimientoPopUp.php';
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
<title>Contenido Procedimiento</title>
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

if( ($_POST['objetivoI'] == "") || ($_POST['alcanceI'] == "") || ($_POST['definicionesI'] == "") || ($_POST['responsablesI'] == "") || ($_POST['lineamientosI'] == "")){
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregarContenidoProcedimientoPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Contenido Procedimiento</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='2'></td>";
			echo "</tr>";
	
			echo"<tr height='15'></tr>";
			
			echo "<tr>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Objetivo";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<textarea name='objetivoI' style='width: 450px; height: 50px;'></textarea>";
								echo "<input type='hidden' name='itemID' value='$itemID'>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<t>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Alcance";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<textarea name='alcanceI' style='width: 450px; height: 50px;'></textarea>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Definiciones";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<textarea name='definicionesI' style='width: 450px; height: 50px;'></textarea>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Responsables";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<textarea name='responsablesI' style='width: 450px; height: 50px;'></textarea>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td width='50px'> </td>";
				echo "<td width='400px'>";
					echo "<table border='0'>";
						echo"<tr> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Lineamientos";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<textarea name='lineamientosI' style='width: 450px; height: 50px;'></textarea>";
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

} else if( ($_POST['objetivoI'] != "") && ($_POST['alcanceI'] != "") && ($_POST['definicionesI'] != "") && ($_POST['responsablesI'] != "") && ($_POST['lineamientosI'] != "")){
	
	$itemID = $_POST['itemID'];
	$objetivo = $_POST['objetivoI'];
	$alcance = $_POST['alcanceI'];
	$definiciones = $_POST['definicionesI'];
	$responsables = $_POST['responsablesI'];
	$lineamientos = $_POST['lineamientosI'];
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Elementos WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$inserciones = 0;
	
	if($INTRANET->Execute("INSERT INTO SGI_Elementos(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, 'OBJETIVO', '$objetivo') ")){
		$maximo++;
	} else{
		$inserciones++;
	}
	if($INTRANET->Execute("INSERT INTO SGI_Elementos(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, 'ALCANCE', '$alcance') ")){
		$maximo++;
	} else{
		$inserciones++;
	}
	if($INTRANET->Execute("INSERT INTO SGI_Elementos(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, 'DEFINICIONES', '$definiciones') ")){
		$maximo++;
	} else{
		$inserciones++;
	}
	if($INTRANET->Execute("INSERT INTO SGI_Elementos(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, 'RESPONSABLES', '$responsables') ")){
		$maximo++;
	} else{
		$inserciones++;
	}
	if($INTRANET->Execute("INSERT INTO SGI_Elementos(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, 'LINEAMIENTOS', '$lineamientos') ")){
		$maximo++;
	} else{
		$inserciones++;
	}
	
	
								
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	
}
?>
</body>
</html>