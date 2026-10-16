<?php

error_reporting(0);
//echo ini_get("upload_max_filesize");
//ini_set("upload_max_filesize","300M");
$nombrephp='AgregarElementoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
// save old value
$saved = getenv("LD_LIBRARY_PATH");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("LD_LIBRARY_PATH=$newld");
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
<title>Agregar Elementos</title>
 <?php
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
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

$codDocumento = $_GET['codDoc'];   

if($_POST['codDoc'] == ''){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='agregaControlRegistrosF.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Control del registro</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		
		echo "<tr id='contenido'>";
			echo "<td>";
				echo "<table border='0'>";
	
					echo"<tr height='20'> ";
						echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
							echo"Origen";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='origen' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	

					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Tipo";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='tipo' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Responsable";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='responsable' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Almacenamiento";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='almacenamiento' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Proteccion";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='proteccion' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Recuperacion";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='recuperacion' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Retencion";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='retencion' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					echo"<tr>";
					echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
						echo"Disposicion";
					echo"</td>";
					echo"</tr>";
					
					echo"<tr height='5'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='disposicion' size='65'></input>";
							echo "<input type='hidden' name='codDoc' value='$codDocumento'/>";
						echo "</td>";
					echo"</tr>";	
	
					echo"<tr height='10'> </tr>";
	
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right' colspan='2'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

} else if(($_POST['codDoc'] != ('' && NULL))){
	
	$codDocumento = $_POST['codDoc'];
	 $origen = $_POST['origen'];
	 $tipo = $_POST['tipo'];
	 $responsable = $_POST['responsable'];
	 $almacenamiento = $_POST['almacenamiento'];
	 $proteccion = $_POST['proteccion'];
	 $recuperacion = $_POST['recuperacion'];
	 $retencion = $_POST['retencion'];
	 $disposicion = $_POST['disposicion'];
	
	$arrTipos = array('Origen', 'Tipo', 'Responsable', 'Almacenamiento', 'Proteccion', 'Recuperacion', 'Retencion', 'Disposicion');
	$arrConte = array($origen, $tipo, $responsable, $almacenamiento, $proteccion, $recuperacion, $retencion, $disposicion);
	
	for($d = 0; $d < count($arrTipos); $d++){
		
		$maximo = $INTRANETV2->getOne("SELECT MAX(xn_orden) FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento'");
	
		$maximo++;
		$codDocumentoSecc = $codDocumento."-".$maximo;

		$INTRANETV2->Execute("INSERT INTO SGI_Manuales_Elementos(xt_codigoSeccion, xt_codigoDocumento, xn_orden, xt_tipoElemento, xt_titulo, xt_contenido) VALUES ('$codDocumentoSecc', '$codDocumento', '$maximo', 'T', '$arrTipos[$d]', '$arrConte[$d]')");
		
	} unset($codDocumentoSecc);
	
	
	echo "<script type='text/javascript'>reCargarPadre()</script>";
}
?>
</body>
</html>