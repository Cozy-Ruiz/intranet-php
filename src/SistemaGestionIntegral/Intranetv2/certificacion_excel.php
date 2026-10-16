<?php
$nombrephp='AgregarElementoCapituloPopUp.php';

require_once('../../ConexionDBT.php');
require_once('../../compruebaUsuario.php');
require_once('../../ConexionIntranet2.php');
require_once ('../../Librerias/PHPExcel/Classes/PHPExcel.php');

//require_once('file:///C|/Users/amartinez/Documents/PHPExcel/Classes/PHPExcel.php');

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
//obtengo parametros para insertar Normas


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
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<?php


$inserta = 0;

if($_REQUEST['inserta'] == 1){
	$inserta = 1;
	
}


//FORMULARIO

if($inserta == 0){
	
echo "<div id='wrapperPopUp' align='center'>";
  echo "<form name='fichaSubir' method='POST' action='certificacion_excel.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agrega norma</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='50'> </tr>";
		echo "</table>";
	
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "Nombre Corto";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<input type='text' name='nomCorto' size='65'>";
			echo "</td>";
		echo "</tr>";
		echo "<tr height='10px'></tr>";
	
		echo "<tr>";
				echo "<td>";
					echo "Nombre Completo";
				echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='nomCompleto' size='65'>";
			echo "</td>";
		echo "</tr>";
	
	echo "</table>";
	
		//titulo
	echo "<table border='0'>";
		echo "<tr height='10px'></tr>";
		echo"<tr height='20'> ";
			echo "<td align='right'>";
				echo "<input type='file' name='archivo'>";
			echo "</td>";
		echo"</tr>";
	
	echo"<tr height='40'>";
		echo "<tr height='10px'></tr>";
			echo"<td valign='bottom' align='right' colspan='2'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		echo "<input type='hidden' name='inserta' value='1'/>";
	echo "</table>";
		
	echo "</form>";
echo "</div>";
	
	
}




if($inserta == 1){

 	$nombreCorto = $_REQUEST['nomCorto'];
 	$nombreCompleto = $_REQUEST['nomCompleto'];

	$archivo = $_FILES['archivo']['name'];
	$nombreArchivo = "certificacion_excel.xlsx";

	$destino = "Excel_Normas/$nombreArchivo";

	$banderaArchivo = 0;

	if($archivo != ''){
		unlink($destino);
		//cargo archivo en la carpeta correspondiente
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
			$banderaArchivo = 1;

		}

	}

	//INSERTO EN EL CATALOGO DE NORMAS
	if($nombreCorto != ''){
		
		$INTRANETV2->Execute("INSERT INTO SGI_Catalogo_Normas (xt_codigoNorma, xt_nombreNorma) VALUES ('$nombreCorto', '$nombreCompleto')");
		
	}


	$rutaPatente = $destino;

	if(file_exists($rutaPatente)){
		

		$respuesta->estado = true;
		$inputFileType = PHPExcel_IOFactory::identify($rutaPatente);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$worksheet_names = $objReader->listWorksheetNames($rutaPatente);

		 for($a=0; $a<count($worksheet_names); $a++){

			 if(trim($worksheet_names[$a]) == "Hoja1"){

				$objReader->setLoadSheetsOnly($worksheet_names[$a]);

				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($rutaPatente);

				$excel = $objPHPExcel->getActiveSheet();

				//echo "Nombre Sheet: ".$excel->getTitle()."<br>";
				 $highestRow = $excel->getHighestRow();

				$highestColumnString = $excel->getHighestColumn();
				//echo "Ultima Columna: $highestColumnString <br>";

				$highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnString);
				//echo "Numero de columnas: $highestColumn <br>";

				$nuevoExcel = new PHPExcel();

				$indice = 1;


				 for($h=2; $h<=$highestRow; $h++){

				   $codigoIndice     = trim($excel->getCellByColumnAndRow(0,$h)->getFormattedValue());
				   $titulo     = trim($excel->getCellByColumnAndRow(1,$h)->getFormattedValue());
				  // $fecha           = $excel->getCellByColumnAndRow(4,$h)->getFormattedValue();
				   $codDocRelacionado          = trim($excel->getCellByColumnAndRow(2,$h)->getFormattedValue());
				   $texto          = nl2br($excel->getCellByColumnAndRow(3,$h)->getFormattedValue());
				   $notasExplcativas          = nl2br($excel->getCellByColumnAndRow(4,$h)->getFormattedValue());
					
					//echo $codigoIndice."<br>";

					 //INSERTO EN TABLA DE CONTENIDO DE NORMAS
					 //echo "INSERT INTO SGI_Normas_Texto (xt_codigoIndice, xt_titulo, xt_texto, xt_notasExplicativas, xt_codigoNorma) VALUES ('$codigoIndice', '$titulo', '$texto', '$notasExplcativas', '$nombreCorto') <br>";
					$s= $INTRANETV2->Execute("INSERT INTO SGI_Normas_Texto (xt_codigoIndice, xt_titulo, xt_texto, xt_notasExplicativas, xt_codigoNorma) VALUES ('$codigoIndice', '$titulo', '$texto', '$notasExplcativas', '$nombreCorto')");

					 if($codDocRelacionado != ''){

						 //INSERTO LOS ELEMENTOS RELACIONADOS
						$refNuevos = trim($codDocRelacionado);
						$refNuevos = explode(',', $refNuevos);

						for($a = 0; $a < count($refNuevos); $a++){
							$codRef = trim($refNuevos[$a]);
						 //echo "INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento) VALUES ('$nombreCorto', '$codigoIndice', '$codRef') <br>";
						$j= $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento) VALUES ('$nombreCorto', '$codigoIndice', '$codRef')");

						}
					 }

					 unset($s); unset($j); unset($codRef); unset($refNuevos);

				 }					 
			 }
		 }

	}
	echo "<script type='text/javascript'>reCargarPadre()</script>";
}


?>
       
