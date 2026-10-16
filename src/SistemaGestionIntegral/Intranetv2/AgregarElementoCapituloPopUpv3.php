<?php

$nombrephp='AgregarElementoCapituloPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
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
<script type="text/javascript">
	
	function mostrarCertificacion(certificacion){

		var ventana = document.getElementById(certificacion);
		ventana.style.marginTop = "100px";
		ventana.style.marginLeft = ((document.body.clientWidth-350) / 2) +  "px";
		ventana.style.display = 'block';
		
		var ventana2 = document.getElementById(certificacion+"2");
		ventana2.style.marginTop = "320px";
		ventana2.style.marginLeft = ((document.body.clientWidth-340) / 2) +  "px";
		ventana2.style.display = 'block';
		
		var ventanaPadre = document.getElementById("wrapperPopUp"); // Accedemos al contenedor
		ventanaPadre.style.opacity = "0.2"; // Y lo hacemos invisible
		
		
	}

	function ocultarCertificacion(certificacion,estatus){
		

		var nuevoEstatus = estatus.trim();
		
		var ventana = document.getElementById(certificacion); // Accedemos al contenedor
		ventana.style.display = 'none'; // Y lo hacemos invisible
		
		var ventana2 = document.getElementById(certificacion+"2"); // Accedemos al contenedor
		ventana2.style.display = 'none'; // Y lo hacemos invisible
		
		var ventanaPadre = document.getElementById("wrapperPopUp"); // Accedemos al contenedor
		ventanaPadre.style.opacity = "1"; // Y lo hacemos invisible
		
		if(nuevoEstatus == 'guardar'){
			
			var neec = document.getElementsByName(certificacion+'Valor[]');
			var texto = "";
			for (i = 0; i < neec.length; i++) {
				if (neec[i].checked) {
					texto = texto + neec[i].value + ",";
				}
			}
			var textoNEEC = texto.slice(0,-1);
			document.getElementById(certificacion+"Texto").value = textoNEEC;
			if(textoNEEC != ''){
				var limpiar = document.getElementById(certificacion+"Limpiar").style.display = 'block';
			}else{
				
			}
		}else{
			
		}

	}
	function mostrarReferencia(){

		var ventana = document.getElementById('referencias');
		ventana.style.marginTop = "100px";
		ventana.style.marginLeft = ((document.body.clientWidth-450) / 2) +  "px";
		ventana.style.display = 'block';
		
		var ventana2 = document.getElementById("referenciasLista");
		ventana2.style.marginTop = "320px";
		ventana2.style.marginLeft = ((document.body.clientWidth-440) / 2) +  "px";
		ventana2.style.display = 'block';
		
		var ventanaPadre = document.getElementById("wrapperPopUp"); // Accedemos al contenedor
		ventanaPadre.style.opacity = "0.2"; // Y lo hacemos invisible
		
		
	}

	function ocultarReferencia(estatus){
		
		var nuevoEstatus = estatus.trim();

		var ventana = document.getElementById('referencias'); // Accedemos al contenedor
		ventana.style.display = 'none'; // Y lo hacemos invisible
		
		var ventana2 = document.getElementById("referenciasLista");// Accedemos al contenedor
		ventana2.style.display = 'none'; // Y lo hacemos invisible
		
		var ventanaPadre = document.getElementById("wrapperPopUp"); // Accedemos al contenedor
		ventanaPadre.style.opacity = "1"; // Y lo hacemos invisible
		
		if(nuevoEstatus == 'guardar'){
			var neec = document.getElementsByName('referenciaValor[]');
			var texto = "";
			for (i = 0; i < neec.length; i++) {
				if (neec[i].checked) {
					texto = texto + neec[i].value + ",";
				}
			}
			var textoNEEC = texto.slice(0,-1);
			if(textoNEEC != ''){
				document.getElementById("referenciaTexto").value = textoNEEC;
				var limpiar = document.getElementById("Limpiar").style.display = 'block';
			}else{
				document.getElementById("referenciaTexto").value = textoNEEC;
			}
		}else{
			
		}

	}
	function limpiarCertificacion(certificacion) {
		
		document.getElementById(certificacion+"Texto").value = "";
		var limpiar = document.getElementById(certificacion+"Limpiar").style.display = 'none';
		
		var desactivar = document.getElementsByName(certificacion+'Valor[]');//.checked = false;
		
		for (i = 0; i < desactivar.length; i++) {
			if (desactivar[i].checked) {	
				desactivar[i].checked =  false
			}
		}
		
	}
	
	function limpiarReferencia() {
		document.getElementById("referenciaTexto").value = "";
		var limpiar = document.getElementById("Limpiar").style.display = 'none';
		var desactivar = document.getElementsByName('referenciaValor[]');//.checked = false;
		
		for (i = 0; i < desactivar.length; i++) {
			if (desactivar[i].checked) {	
				desactivar[i].checked =  false
			}
		}
		
		
	}
	
</script>
<style>
	label input {
  display: none;/* <-- hide the default checkbox */
}
label span {/* <-- style the artificial checkbox */
  height: 15px;
  width: 15px;
  border: 2px solid #000000;
  display: inline-block;
  position: relative;
}
[type=checkbox]:checked + span:before {/* <-- style its checked state..with a ticked icon */
  content: '\2714';
  position: absolute;
  top: 0;
  font-size: 1.3em;
  line-height: 0.8;
  color: red;
  transition: all .2s;
  left: 0;
}
.button{
    background-color:transparent;
    border: 2px solid #d0c8c8;
    border-radius: 8px;
    color: white;
    padding: 1px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	font-weight: bold;
    margin: 4px 2px;
    cursor: pointer;
}

</style>
</head>
<body>
<?php

$s = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoNorma FROM INTRANET2.SGI_Catalogo_Normas");
$i = 0;
	$arrCertificaciones = array();

while($p = $s->fetchRow()){
	
	$arrCertificaciones[$i] = $p[0];
	$i++;
}unset($i);
		

$codDocumento = $_GET['codDoc'];   

if(@$_POST['atributo'] == ''){
echo "<form name='fichaSubir' method='POST' action='AgregarElementoCapituloPopUpv3.php' enctype='multipart/form-data'>";	
echo "<div id='wrapperPopUp'>";
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
					
					
	
					for($a = 0; $a < count($arrCertificaciones); $a++){
		

							$titulo = $arrCertificaciones[$a];

						$certificaciones[$a] =  str_replace(' ', '', $arrCertificaciones[$a]);

						echo "<tr>";
							echo '<td align="right" id="fileItem" ><a href="javascript:void(0);" onclick="mostrarCertificacion(\''.$certificaciones[$a].'\')">'.$titulo.'</a></td>';
							echo "<td align='left'>";
								echo"<input type='text' size='71'  maxlength='250' name='".$certificaciones[$a]."Texto' id='".$certificaciones[$a]."Texto'>";
							echo"</td>";
							echo '<td align="right" style = "display:none;" id="'.$certificaciones[$a].'Limpiar"><a href="javascript:void(0);" onclick="limpiarCertificacion(\''.$certificaciones[$a].'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a></td>';
							//echo"<input type='text' name='$arrCertificaciones[$a]' size='65'></td>";
							echo "<input type='hidden' value='1' name='modifica'>";
							echo "<input type='hidden' value='$codDocumento' name='codDoc'>";
						echo "</tr>";
						echo "<tr height='10px'> </tr>";
					}
	
	
	
					echo"<tr height='10'> </tr>";
					
					echo "<tr>";
						echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarReferencia()">Referencias</a></td>';
						echo "<td align='left'>";
							echo"<input type='text' size='71'  maxlength='250' name='referenciaTexto' id='referenciaTexto'>";
						echo"</td>";
						echo '<td align="right" style = "display:none;" id="Limpiar"><a href="javascript:void(0);" onclick="limpiarReferencia()"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a></td>';
					echo "</tr>";
					echo "<tr height='10px'> </tr>";

					
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
							echo "<input type='hidden' name='codDoc' value='$codDocumento'/>";
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
	
echo "</div>";

//Div para mostrar el listado de las certificaciones
for($a = 0; $a < count($arrCertificaciones); $a++){
	
	echo'<div id="'.$certificaciones[$a].'"  style="position: fixed; border-radius: 5px; border: 2px solid rgb(20, 24, 15); padding: 10px 40px; width: 200px; height: 150px; overflow: scroll; width: 500px; height: 250px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; background-color: #E5E7E9; color: #111123; display:none;">';
		echo"<br>";
		echo"<table>";
		//echo'<div style="border: #333333 3px solid; background-color: #FAFAFA; color: blue;">';
		$y = $INTRANETV2->Execute("SELECT
									xt_codigoIndice,
									CASE xt_titulo WHEN '' THEN CONCAT(LEFT(xt_texto,40),'...') ELSE xt_titulo END
								FROM INTRANET2.SGI_Normas_Texto
								WHERE
									xt_codigoIndice != 0
								AND xt_codigoNorma = '$arrCertificaciones[$a]'
								ORDER BY
									REPLACE (xt_codigoIndice, '.', '')
								");
			while($o = $y->fetchRow()){
				$codigoNorma = $o[0];
				$tituloNorma = $o[1];
				
					echo"<tr>";
					 echo"<td>";
						echo"<label>";
							echo "<input type='checkbox' name='".$certificaciones[$a]."Valor[]' id='".$certificaciones[$a]."Valor[]' value='".$codigoNorma."'> <span></span> ".$codigoNorma."-".$tituloNorma."</option><br><br>";
						echo"</label>";
					echo"</td>";
				echo"</tr>";
			  
			}
	 echo"</table>";
	echo"<br><br>";
	echo'</div>';
	//echo'</div>';
	echo'<div id="'.$certificaciones[$a].'2" style="position: fixed; border-radius: 25px;
	width: 550px; height: 20px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: normal; solid; background-color: #E5E7E9; display:none;">
		<table>
			<tr>
				<td align="left" width="250px">
					<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarCertificacion(\''.$certificaciones[$a].'\',\'guardar\');" name="btnAceptar" value="Guardar" />
				</td>
				<td align="right" width="300px">
					<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarCertificacion(\''.$certificaciones[$a].'\',\'cancelar\');" name="btnAceptar" value="Cancelar" />
				</td>
			</tr>
		</table>
	</div>';
}
	
//Div para mostrar las opciones de agregar referencia
echo'<div id="referencias"  style="position: fixed; border-radius: 5px; border: 2px solid rgb(20, 24, 15); padding: 10px 40px; width: 200px; height: 150px;  
	overflow: scroll; width: 500px; height: 250px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; background-color: #E5E7E9; color: #111123; display:none;">';
	echo"<br>";
	echo"<table>";
		$y = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoDocumento, xt_nombre FROM INTRANET2.SGI_Manuales_Documentos ORDER BY xt_codigoDocumento ASC");
			while($o = $y->fetchRow()){
				$codigoManual = $o[0];
				$tituloManual = $o[1];

					echo"<tr>";
					 echo"<td>";
						echo"<label>";
							echo "<input type='checkbox' name='referenciaValor[]' id='referenciaValor[]' value='".$codigoManual."'> <span></span> ".$codigoManual."-".$tituloManual."</option><br><br>";
						echo"</label>";
					echo"</td>";
				echo"</tr>";

			}
	 echo"</table>";
	echo"<br><br>";
echo'</div>';
	//echo'</div>';
echo'<div id="referenciasLista" style="position: fixed; border-radius: 25px; width: 550px; height: 20px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: normal; solid; background-color: #E5E7E9; display:none;">
	<table>
		<tr>
			<td align="left" width="250px">
				<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarReferencia(\'guardar\');" name="btnAceptar" value="Guardar" />
			</td>
			<td align="right" width="300px">
				<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarReferencia(\'cancelar\');" name="btnAceptar" value="Cancelar" />
			</td>
		</tr>
	</table>
</div>';
	
	
echo "</form>";



} else if(($_POST['atributo'] != ('' && NULL && "A")) && ($_POST['contenido'] != ('' && NULL))){
	
//echo "Aributo:".$_POST['atributo'].", Contenido:".$_POST['contenido']."<br>";	
	 $atributo = $_POST['atributo'];
	 $contenido = $_POST['contenido'];
	 $codDocumento = $_POST['codDoc'];
	 $titulo = $_POST['titulo'];
	 $inciso = $_POST['numeroCap'];
	 $refDocs = $_POST['referenciaTexto'];
	
	if($titulo != '' || $contenido != '' ||  $inciso != ''){
		
		$maximo = $INTRANETV2->getOne("SELECT MAX(xn_orden) FROM INTRANET2.SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento'");
	
		$maximo++;
		//$codDocumentoSecc = $codDocumento."-".$maximo;
	
		//inserto en las tablas correspondientes
		$j = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Elementos (xt_codigoDocumento, xn_orden, xt_tipoElemento, xt_titulo, xt_contenido, xt_outline) VALUES ('$codDocumento', $maximo, 'T', '$titulo', '$contenido', '$inciso')");
	
	}
	
	//obtengo datos de las certificaciones
	
	for($a = 0; $a < count($arrCertificaciones); $a++){
		
		$variableCertif = $_REQUEST[str_replace(' ', '', $arrCertificaciones[$a]."Texto")];

		$certifNuevos = trim($variableCertif);
		$certifNuevos = preg_split( '/(,|;)/', $certifNuevos);
		//$certifNuevos = explode(',', $certifNuevos);

		for($i = 0; $i<count($certifNuevos); $i++){

			$incisoCertif = trim($certifNuevos[$i]);
			
			if($incisoCertif != ''){

				$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('$arrCertificaciones[$a]', '$incisoCertif', '$codDocumento', '$inciso')");
			}

		}
	}
	
	
	//inserto Referencias
	
	if($refDocs != ("" || NULL)){
		$refNuevos = explode(',', $refDocs);

		for($a = 0; $a < count($refNuevos); $a++){
			$codRef = trim($refNuevos[$a]);
			
			
			
			$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('$codRef', '', '$codDocumento', '$inciso')");
		}
		unset($i);
	}
	
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	
} else if($_POST['atributo'] == 'A'){
	
	
	$codDocumento = $_POST['codDoc'];
	$atributo = $_POST['atributo'];
	//echo "Item:$itemID, Atributo:$atributo<br>";
	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_orden) FROM INTRANET2.SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento'");
	
	$maximo++;
	$codDocumentoSecc = $codDocumento."-".$maximo;
	
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	
	if ($archivo != ""){
		$destino = "../../FILES/$archivo";
		
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
		
			
			if($INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Elementos(xt_codigoDocumento, xn_orden, xt_tipoElemento, xt_titulo, xt_contenido) VALUES ('$codDocumento', '$maximo', 'A', '', '$destino')") ){
				
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