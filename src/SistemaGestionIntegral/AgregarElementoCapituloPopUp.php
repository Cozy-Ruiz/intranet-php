<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarElementoCapituloPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
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

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if(option == "DESARROLLOA"){
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

$itemID = $_GET['itemID'];   

if( $_POST['atributo'] == ''){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoCapituloPopUp.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Elemento</font>";
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
			echo "<td  align='left' colspan='2'>";
				echo "<select id='seleccion' name='atributo'  onchange='show()'>";
					echo "<option value='' selected=''></option>";					
					echo "<option value='DESARROLLOT'>Texto</option>";
					echo "<option value='DESARROLLOA'>Archivo</option>";
				echo "</select><input type='hidden' name='itemID' value='$itemID'/>";
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
					echo "<tr id='iconosTexto2'>";
						echo "<td id='iconosTexto2' align='left'>Outline</td>";
						echo "<td align='left' >Titulo</td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr>";
						echo "<td>";
							echo "<input type='text' name='numeroCap' size='11'>";
						echo "</td>";
						echo"<td valign='bottom' align='left'>";
							echo"<input type='text' name='titulo' size='65'>";
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' colspan='2'>Certificaciones</td>";
					echo "</tr>";
					
					echo "<tr align='left' height='20' >";
						echo "<td id='fileItem' align='right' width='50px'>ISO</td>";
						echo "<td align='right'><input type='text' size='62' maxlength='250' name='iso'></td>";
					echo "</tr>";
										
					echo"<tr height='10'> </tr>";
					
					echo "<tr align='left' height='20' >";
						echo "<td id='fileItem' align='right'>NMX</td>";
						echo "<td align='right'><input type='text' size='62' maxlength='250' name='nmx'></td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr align='left' height='20' >";
						echo "<td id='fileItem' align='right'>NEEC</td>";
						echo "<td align='right'><input type='text' size='62' maxlength='250' name='neec'></td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' colspan='2'>Referencias</td>";
					echo "</tr>";
					
					echo "<tr align='left' height='20' >";
						echo "<td align='left' colspan='2'><input type='text' size='65' maxlength='250' name='docs'></td>";
					echo "</tr>";
					
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

} else if(($_POST['atributo'] != ('' && NULL && "DESARROLLOA")) && ($_POST['contenido'] != ('' && NULL))){
//echo "Aributo:".$_POST['atributo'].", Contenido:".$_POST['contenido']."<br>";	
	$atributo = $_POST['atributo'];
	$contenido = $_POST['contenido'];
	$itemID = $_POST['itemID'];
	$titulo = $_POST['titulo'];
	//$iso = $_POST['iso'];
	//$nmx = $_POST['nmx'];
	//$neec = $_POST['neec'];
	//$refDocs = $_POST['docs'];
	$numeroCap = $_POST['numeroCap'];
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_CapituloElemento WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if($INTRANET->Execute("
	INSERT INTO SGI_CapituloElemento(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido, xt_outLine) VALUES ('$itemID', $maximo, '$atributo', '$contenido', '$numeroCap')
	")){
		$capituloElementoID = $INTRANET->getOne("SELECT kp_capituloElementoID FROM SGI_CapituloElemento WHERE kf_itemID = '$itemID' AND xn_numeroElemento = $maximo ");
		
		if($titulo != ""){
			$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_titulo = '$titulo' WHERE kp_capituloElementoID = $capituloElementoID ");
		}
		
		if($_POST['iso'] != ("" || NULL)){
			$iso = explode(',', $_POST['iso']);
			
			for($i = 0; $i < count($iso); $i++){
				$dato = trim($iso[$i]);
				$s = $INTRANET->Execute("
				INSERT INTO SGI_CapituloElemento_Certificaciones (kf_capituloElementoID, xt_norma, kf_codigoID) 
				VALUES ($capituloElementoID, 'ISO', '$dato')");
			}
			unset($i);
		}/*
		if($iso != ""){
			$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_referenciaISO = '$iso' WHERE kp_capituloElementoID = $capituloElementoID ");
		}*/
		if($_POST['nmx'] != ("" || NULL)){
			$nmx = explode(',', $_POST['nmx']);
			
			for($i = 0; $i < count($nmx); $i++){
				$dato = trim($nmx[$i]);
				$s = $INTRANET->Execute("
				INSERT INTO SGI_CapituloElemento_Certificaciones (kf_capituloElementoID, xt_norma, kf_codigoID) 
				VALUES ($capituloElementoID, 'NMX', '$dato')");
			}
			unset($i);
		}/*
		if($nmx != ""){
			$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_referenciaNMX = '$nmx' WHERE kp_capituloElementoID = $capituloElementoID ");
		}*/
		if($_POST['neec'] != ("" || NULL)){
			$neec = explode(',', $_POST['neec']);
			
			for($i = 0; $i < count($neec); $i++){
				$dato = trim($neec[$i]);
				$s = $INTRANET->Execute("
				INSERT INTO SGI_CapituloElemento_Certificaciones (kf_capituloElementoID, xt_norma, kf_codigoID) 
				VALUES ($capituloElementoID, 'NEEC', '$dato')");
			}
			unset($i);
		}/*
		if($neec != ""){
			$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_referenciaNEEC = '$neec' WHERE kp_capituloElementoID = $capituloElementoID ");
		}*/
		if($_POST['docs'] != ("" || NULL)){
			$refDocs = explode(',', $_POST['docs']);
			
			for($i = 0; $i < count($refDocs); $i++){
				$dato = trim($refDocs[$i]);
				$idDoc	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' ");
				$s = $INTRANET->Execute("
				INSERT INTO SGI_CapituloElemento_Referencia (kf_capituloElementoID, xt_docCodigo) 
				VALUES ($capituloElementoID, $idDoc)");
			}
			unset($i);
		}/*
		if($refDocs != ""){
			$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_referenciaDoc = '$refDocs' WHERE kp_capituloElementoID = $capituloElementoID ");
		}*/
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='post' action='AgregarElementoCapituloPopUp.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Item No Agregado</font>";
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
	
} else if($_POST['atributo'] == 'DESARROLLOA'){
	$itemID = $_POST['itemID'];
	$atributo = $_POST['atributo'];
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_CapituloElemento WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	//echo "itm:$itemID, atr:$atributo, max:$maximo<br>";
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	if ($archivo != ""){
		$destino = "../FILES/$archivo";
		//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino<br>";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
			//echo "INSERT INTO SGI_CapituloElemento(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ('$itemID', $maximo, '$atributo', '$destino')<br>";
			if($INTRANET->Execute("
				INSERT INTO SGI_CapituloElemento(kf_itemID, xn_numeroElemento, xt_tipo, xt_contenido) VALUES ($itemID, $maximo, '$atributo', '$destino')
				")){
					
				echo "<script type='text/javascript'>reCargarPadre()</script>";
						
			} else{
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error</font>";
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
}
?>
</body>
</html>