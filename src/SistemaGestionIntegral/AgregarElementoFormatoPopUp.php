<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarElementoFormatoPopUp.php';
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
<title>Agregar Elementos Formato</title>
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
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "ORIGEN"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="block";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "TIPO"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="block";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "RESPONSABLE"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="block";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "ALMACENAMIENTO"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="block";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "PROTECCION"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="block";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "RECUPERACION"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="block";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "RETENCION"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="block";
		document.getElementById("disposicion").style.display="none";
	} else if(option == "DISPOSICION"){
		document.getElementById("archivos").style.display="none";
		document.getElementById("origen").style.display="none";
		document.getElementById("tipo").style.display="none";
		document.getElementById("responsable").style.display="none";
		document.getElementById("almacenamiento").style.display="none";
		document.getElementById("proteccion").style.display="none";
		document.getElementById("recuperacion").style.display="none";
		document.getElementById("retencion").style.display="none";
		document.getElementById("disposicion").style.display="block";
	}
}
</script>
</head>
<body>
<?php

$itemID = $_GET['itemID'];   

if($_POST['atributo'] == ""){
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregarElementoFormatoPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Elementos Formato</font>";
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
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'ORIGEN' "))){
							echo "<option value='ORIGEN'>Origen</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'TIPO' "))){
							echo "<option value='TIPO'>Tipo</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'RESPONSABLE' "))){
							echo "<option value='RESPONSABLE'>Responsable</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'ALMACENAMIENTO' "))){
							echo "<option value='ALMACENAMIENTO'>Lugar de Almacenamiento</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'PROTECCION' "))){
							echo "<option value='PROTECCION'>Protección</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'RECUPERACION' "))){
							echo "<option value='RECUPERACION'>Recuperación</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'RETENCION' "))){
							echo "<option value='RETENCION'>Retención</option>";
						}
						if(!($INTRANET->getOne("SELECT xt_campo FROM SGI_Registros WHERE kf_itemID = $itemID AND xt_campo = 'DISPOSICION' "))){
							echo "<option value='DISPOSICION'>Disposición</option>";
						}
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
			/*
			echo "<tr id='proceso' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Proceso";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='procesoI'>";
									echo "<option value='' selected></option>";
									$s = $INTRANET->Execute("SELECT xt_opcionRegistro FROM SGI_Catalogo_Opciones_Registro WHERE xn_tipoRegistro = 5 ORDER BY xt_opcionRegistro ");
									while($r = $s->fetchRow()){
										echo "<option value='".$r[0]."'>".$r[0]."</option>";
									} unset($r); unset($s);
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			*/
			echo "<tr id='origen' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Origen";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
						echo"<tr> ";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo "<select name='origenI'>";
									echo "<option value='' selected></option>";
									echo "<option value='Interno'>Interno</option>";
									echo "<option value='Externo'>Externo</option>";
									echo "<option value='Interno/Externo'>Interno/Externo</option>";
								echo "</select>";
							echo "</td>";
						echo"</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr id='tipo' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Tipo";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='responsable' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Responsable";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='almacenamiento' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Almacenamiento";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='proteccion' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Protección";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='recuperacion' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Recuperación";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='retencion' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Retención";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			echo "<tr id='disposicion' style='display:none;'>";
				echo "<td>";
					echo "<table border='0'>";/*
						echo"<tr height='20'> ";
							echo"<td valign='bottom' align='left' id='iconosTexto2' colspan='2'>";
								echo"Disposición";
							echo"</td>";
						echo"</tr>";
						*/
						echo"<tr height='10'> </tr>";
						
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
			
			
			echo"<tr height='10'> </tr>";
			
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

} else if(($_POST['atributo'] != "" ) && ($_POST['atributo'] != "DESARROLLOA")){
	
	$atributo = $_POST['atributo'];
	$itemID = $_POST['itemID'];
	
	/*if($atributo == "PROCESO"){
		$contenido = $_POST['procesoI'];
	} else*/ if($atributo== "ORIGEN"){
		$contenido = $_POST['origenI'];
	} else if($atributo == "TIPO"){
		$contenido = $_POST['tipoI'];
	} else if($atributo == "RESPONSABLE"){
		$contenido = $_POST['responsableI'];
	} else if($atributo == "ALMACENAMIENTO"){
		$contenido = $_POST['almacenamientoI'];
	} else if($atributo == "PROTECCION"){
		$contenido = $_POST['proteccionI'];
	} else if($atributo == "RECUPERACION"){
		$contenido = $_POST['recuperacionI'];
	} else if($atributo == "RETENCION"){
		$contenido = $_POST['retencionI'];
	} else if($atributo == "DISPOSICION"){
		$contenido = $_POST['disposicionI'];
	}
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Registros WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if($INTRANET->Execute("
	INSERT INTO SGI_Registros(kf_itemID, xn_numero, xt_campo, xt_contenido) VALUES ($itemID, $maximo, '$atributo', '$contenido') ")){
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='post' action='AgregarElementoFormatoPopUp.php'>";	
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
	//echo "Item:$itemID, Atributo:$atributo<br>";
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Registros WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//echo "maximo:$maximo<br>";
	
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	
	if ($archivo != ""){
		$destino = "../FILES/$archivo";
		echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
			
			if($INTRANET->Execute("
				INSERT INTO SGI_Registros(kf_itemID, xn_numero, xt_campo, xt_contenido) VALUES ($itemID, $maximo, '$atributo', '$destino')") ){
				
				//$claveReunion = $INTRANET->getOne("SELECT xt_claveReunion FROM IntranetGEA_Reuniones WHERE kp_reunionID = $reunionID ");
				
				echo "<script type='text/javascript'>reCargarPadre()</script>";
						
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
}
?>
</body>
</html>