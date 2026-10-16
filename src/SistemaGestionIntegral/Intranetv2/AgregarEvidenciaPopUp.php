<?php
$nombrephp='AgregarElementoPopUp.php';
//require_once("../../compruebaUsuario.php");
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
$estiloUsuario = $_GET['estiloUsuario'];

// error_reporting(E_PARSE);

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

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );


    return $string;
}

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
	function recargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if((option == "A")||(option == "I")){
		document.getElementById("archivos").style.display="block";
		document.getElementById("contenido").style.display="none";
	} else if (option == "T") {
		document.getElementById("archivos").style.display="none";
		document.getElementById("contenido").style.display="block";
	}
}
</script>
</head>
<body>
<?php

$simulacro = $_GET['simulacro'];

if(@$_POST['tipoEvidencia'] == ''){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarEvidenciaPopUp.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Evidencia</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2'>Tipo</td>";
		echo "</tr>";
		
		echo"<tr align='left'>";
			echo "<td  align='left'>";
				echo "<select id='seleccion' name='tipoEvidencia'  onchange='show()'>";
					echo "<option value='' selected=''>Elegir...</option>";					
					echo "<option value='T'>Texto</option>";
					echo "<option value='A'>Archivo</option>";
					echo "<option value='I'>Imagen</option>";
				echo "</select>";
				echo "<input type='hidden' name='simulacro' value='$simulacro'/>";
			echo"</td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr style='display:none;' id='archivos'>";
			echo "<td>";
				echo "<table border='0'>";
					echo"<tr height='20'> ";
						echo "<td align='right'>";
							echo "<input type='file' name='archivo[]' multiple=''>";
						echo "</td>";
					echo"</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr id='contenido' style='display:none;'>";
			echo "<td>";
				echo "<table border='0'>";

					echo"<tr height='10'> </tr>";

					echo"<tr height='20'> ";
						echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
							echo"Contenido";
						echo"</td>";
					echo"</tr>";

					echo"<tr height='10'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<textarea name='contenido' style='width: 500px; height: 300px;'></textarea>";
						echo "</td>";
					echo"</tr>";
					
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

} else if($_POST['tipoEvidencia'] == "T"){
	
	$tipoEvidencia = $_POST['tipoEvidencia'];
	$contenido = $_POST['contenido'];
	$simulacro = $_POST['simulacro'];
	
	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_codigoEvidencia) FROM SGI_Simulacros_Evidencia WHERE xt_codigoSimulacro = '$simulacro'");

	$maximo++;

	if($INTRANETV2->Execute("INSERT INTO SGI_Simulacros_Evidencia (xt_codigoSimulacro, xn_codigoEvidencia) VALUES ('$simulacro', '$maximo')")){
		if($INTRANETV2->Execute("INSERT INTO SGI_Evidencia (xn_codigoEvidencia, xt_contenido, xt_tipo, xd_fecha) VALUES ('$maximo', '$contenido', '$tipoEvidencia', '".date('Y-m-d H:i:s')."')")){
				echo "<script type='text/javascript'>recargarPadre()</script>";
		} else {
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error en la carga 1</font>";
						echo"</td>";
					echo"</tr>";
					
				echo "</table>";
			echo "</div>";
		}
	} else {
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error en la carga 2</font>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
	}

	echo "<script type='text/javascript'>recargarPadre()</script>";

	
} else if($_POST['tipoEvidencia'] == 'A'){
	
	$simulacro = $_POST['simulacro'];
	$tipoEvidencia = $_POST['tipoEvidencia'];
	 
	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_codigoEvidencia) FROM SGI_Simulacros_Evidencia WHERE xt_codigoSimulacro = '$simulacro'");

	
	$total_archivos = count($_FILES['archivo']['name']);
	for($a=0;$a<$total_archivos;$a++){
		$archivo = $simulacro.$_FILES['archivo']['name'][$a];
		$archivo = limpiar_caracter_especial($archivo);
		if ($archivo != ""){
			$destino = "../SimulacroArchivos/ArchivosEvidencia/$archivo";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'][$a], $destino)){
				$maximo++;
				if($INTRANETV2->Execute("INSERT INTO SGI_Simulacros_Evidencia (xt_codigoSimulacro, xn_codigoEvidencia) VALUES ('$simulacro', '$maximo')")) {
					if($INTRANETV2->Execute("INSERT INTO SGI_Evidencia (xn_codigoEvidencia, xt_codigoSimulacro, xt_tipo, xd_fecha, xt_ruta) VALUES ('$maximo', '$simulacro', '$tipoEvidencia', '".date('Y-m-d H:i:s')."','$destino')")){

						echo "<div id='wrapperPopUp'>";
								echo "<table border='0' align='center' name='Encabezado'>";
								
										echo"<tr>";
												echo"<td align='center' id='titulo1'>";
														echo "<font>Carga Exitosa</font>";
												echo"</td>";
										echo"</tr>";
										
								echo "</table>";
						echo "</div>";
						
						/*echo "<script type='text/javascript'>
								window.onunload = refreshParent;
								function refreshParent() {
									window.opener.location.reload();
								};
								window.close();
							</script>";*/

					} else {
						echo "<div id='wrapperPopUp'>";
								echo "<table border='0' align='center' name='Encabezado'>";
								
										echo"<tr>";
												echo"<td align='center' id='titulo1'>";
														echo "<font>Error en la carga al insertar. 1</font>";
												echo"</td>";
										echo"</tr>";
										
								echo "</table>";
						echo "</div>";
					}
				} else {
						echo "<div id='wrapperPopUp'>";
								echo "<table border='0' align='center' name='Encabezado'>";
								
										echo"<tr>";
												echo"<td align='center' id='titulo1'>";
														echo "<font>Error en la carga al insertar. 2</font>";
												echo"</td>";
										echo"</tr>";
										
								echo "</table>";
						echo "</div>";
				}
			} else {
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error en la carga del archivo.</font>";
							echo"</td>";
						echo"</tr>";
						
					echo "</table>";
				echo "</div>";
			}
		}
	}
	echo "<script type='text/javascript'>recargarPadre()</script>";
} else if ($_POST['tipoEvidencia'] == 'I'){
	$simulacro = $_POST['simulacro'];
	$tipoEvidencia = $_POST['tipoEvidencia'];
	 
	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_codigoEvidencia) FROM SGI_Simulacros_Evidencia WHERE xt_codigoSimulacro = '$simulacro'");

	$total_archivos = count($_FILES['archivo']['name']);
	for($a=0;$a<$total_archivos;$a++){

		$archivo = $xn_codigoEvidencia."_".$_FILES['archivo']['name'][$a];

		$info = getimagesize($_FILES['archivo']['tmp_name'][$a]);
		//var_dump($info);

		if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
				
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error, este archivo no es una imagen.</font>";
						echo"</td>";
					echo"</tr>";
					
				echo "</table>";
			echo "</div>";
		} else {
			$archivo = $simulacro.limpiar_caracter_especial($archivo);
			if ($archivo != ""){
				$destino = "../SimulacroArchivos/ImagenesEvidencia/$archivo";
				if (move_uploaded_file($_FILES['archivo']['tmp_name'][$a], $destino)){
					$maximo++;
					if($INTRANETV2->Execute("INSERT INTO SGI_Simulacros_Evidencia (xt_codigoSimulacro, xn_codigoEvidencia) VALUES ('$simulacro', '$maximo')")) {
						if($INTRANETV2->Execute("INSERT INTO SGI_Evidencia (xn_codigoEvidencia, xt_codigoSimulacro, xt_tipo, xd_fecha, xt_ruta) VALUES ('$maximo', '$simulacro', '$tipoEvidencia', '".date('Y-m-d H:i:s')."','$destino')")){

							echo "<div id='wrapperPopUp'>";
									echo "<table border='0' align='center' name='Encabezado'>";
									
											echo"<tr>";
													echo"<td align='center' id='titulo1'>";
															echo "<font>Carga Exitosa</font>";
													echo"</td>";
											echo"</tr>";
											
									echo "</table>";
							echo "</div>";
							
							/*echo "<script type='text/javascript'>
									window.onunload = refreshParent;
									function refreshParent() {
										window.opener.location.reload();
									};
									window.close();
								</script>";*/

						} else {
							echo "<div id='wrapperPopUp'>";
									echo "<table border='0' align='center' name='Encabezado'>";
									
											echo"<tr>";
													echo"<td align='center' id='titulo1'>";
															echo "<font>Error en la carga al insertar. 1</font>";
													echo"</td>";
											echo"</tr>";
											
									echo "</table>";
							echo "</div>";
						}
					} else {
							echo "<div id='wrapperPopUp'>";
									echo "<table border='0' align='center' name='Encabezado'>";
									
											echo"<tr>";
													echo"<td align='center' id='titulo1'>";
															echo "<font>Error en la carga al insertar. 2</font>";
													echo"</td>";
											echo"</tr>";
											
									echo "</table>";
							echo "</div>";
					}
				} else {
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center' name='Encabezado'>";
						
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error en la carga del archivo.</font>";
								echo"</td>";
							echo"</tr>";
							
						echo "</table>";
					echo "</div>";
				}
			}
		}
	}
	echo "<script type='text/javascript'>recargarPadre()</script>";
}

?>
</body>
</html>