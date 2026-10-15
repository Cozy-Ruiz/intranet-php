<?php


//echo ini_get("upload_max_filesize");
//ini_set("upload_max_filesize","300M");
$nombrephp='AgregarElementoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

error_reporting(E_PARSE);
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
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if(option == "A"){
		document.getElementById("archivos").style.display="block";
		document.getElementById("contenido").style.display="none";
	} else{
		document.getElementById("archivos").style.display="none";
		document.getElementById("contenido").style.display="block";
	}
}
</script>
</head>
<body>
<?php

$codDocumento = $_GET['codDoc'];   

if(@$_POST['atributo'] == ''){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoPopUpv3.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Elemento</font>";
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
				echo "<select id='seleccion' name='atributo'  onchange='show()'>";
					echo "<option value='' selected=''></option>";					
					echo "<option value='T'>Texto</option>";
					echo "<option value='A'>Archivo</option>";
				echo "</select><input type='hidden' name='codDoc' value='$codDocumento'/>";
			echo"</td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr style='display:none;' id='archivos'>";
			echo "<td>";
				echo "<table border='0'>";
					echo"<tr height='20'> ";
						echo "<td align='right'>";
							echo "<input type='file' name='archivo'>";
						echo "</td>";
					echo"</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr id='contenido' style='display:none;'>";
			echo "<td>";
				echo "<table border='0'>";
	
					echo"<tr height='20'> ";
						echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
							echo"Titulo";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo"<tr> ";
						echo"<td valign='bottom' align='left' colspan='2'>";
							echo"<input type='text' name='titulo' size='65'></input>";
						echo "</td>";
					echo"</tr>";	
	
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

} else if(($_POST['atributo'] != ('' && NULL && "A")) && ($_POST['contenido'] != ('' && NULL))){
	$atributo = $_POST['atributo'];
	$contenido = $_POST['contenido'];
	$codDocumento = $_POST['codDoc'];
	$titulo = $_POST['titulo'];
	

	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_orden) FROM INTRANET2.SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento'");
	
	$maximo++;
	
	
	if($INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Elementos(xt_codigoDocumento, xn_orden, xt_tipoElemento, xt_titulo, xt_contenido) VALUES ('$codDocumento', '$maximo', 'T', '$titulo', '$contenido')")){
		
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='post' action='AgregarElementoPopUpv3.php'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Elemento No Agregado</font>";
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
	
} else if($_POST['atributo'] == 'A'){
	
	
	 $codDocumento = $_POST['codDoc'];
	 $atributo = $_POST['atributo'];
	//echo "Item:$itemID, Atributo:$atributo<br>";
	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_orden) FROM INTRANET2.SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento'");
	
	$maximo++;
	//$codDocumentoSecc = $codDocumento."-".$maximo;
	
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	
	if ($archivo != ""){
		$destino = "../../FILES/$archivo";
		
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
		
		
			if($INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Elementos(xt_codigoDocumento, xn_orden, xt_tipoElemento, xt_titulo, xt_contenido) VALUES ( '$codDocumento', '$maximo', 'A', '', '$destino')") ){
				
				//$claveReunion = $INTRANET->getOne("SELECT xt_claveReunion FROM IntranetGEA_Reuniones WHERE kp_reunionID = $reunionID ");
				
				//echo "<script type='text/javascript'>reCargarPadre()</script>";
						
			} else{
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error en la carga</font>";
							echo"</td>";
						echo"</tr>";
						
					echo "</table>";
				echo "</div>";
			}
			
		} else{
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
				
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error en la carga</font>";
						echo"</td>";
					echo"</tr>";
					
				echo "</table>";
			echo "</div>";
		}
	}
	
	echo "<script type='text/javascript'>reCargarPadre()</script>";
}
?>
</body>
</html>