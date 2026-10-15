<?php
$nombrephp = 'FichaItem.php';
//require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
//require_once("../../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Certificaciones</title>
 <?php
	//if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	//}else if($estiloUsuario == 2){
		//echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	//}
?>
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
	function limpiar(certificacion) {
		document.getElementById(certificacion+"Texto").value = "";
		var limpiar = document.getElementById(certificacion+"Limpiar").style.display = 'none';
		
		var desactivar = document.getElementsByName(certificacion+'Valor[]');//.checked = false;
		
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
	
$s = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoNorma FROM SGI_Normas_Texto");
$i = 0;
	$arrCertificaciones = array();

while($p = $s->fetchRow()){
	
	$arrCertificaciones[$i] = $p[0];
	$i++;
}unset($i);
	
	

$codDocumento = $_GET['codDoc'];


$modifica == 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if($modifica == 0){

echo "<form name='fichaSubir' method='POST' action='AgregarCertificacionesPopUp.php' enctype='multipart/form-data'>";	
	echo "<div id='wrapperPopUp'>";  
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Certificaciones</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='50'> </tr>";
		echo "</table>";

		echo "<table align='center'>";
		
		for($a = 0; $a < count($arrCertificaciones); $a++){
		
			//if($arrCertificaciones[$a] == "OEA"){

				//$titulo = "NEEC";
			//}else if($arrCertificaciones[$a] == "QCB"){

				//$titulo = "NMX";
			//}else{

				$titulo = $arrCertificaciones[$a];
			//}

			$certificaciones[$a] =  str_replace(' ', '', $arrCertificaciones[$a]);

			echo "<tr>";
				echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\''.$certificaciones[$a].'\')">'.$titulo.'</a></td>';
				echo "<td align='left'>";
					echo"<input type='text' size='71'  maxlength='250' name='".$certificaciones[$a]."Texto' id='".$certificaciones[$a]."Texto'>";
				echo"</td>";
				echo '<td align="right" style = "display:none;" id="'.$certificaciones[$a].'Limpiar"><a href="javascript:void(0);" onclick="limpiar(\''.$certificaciones[$a].'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" width="13"/></a></td>';
				//echo"<input type='text' name='$arrCertificaciones[$a]' size='65'></td>";
				echo "<input type='hidden' value='1' name='modifica'>";
				echo "<input type='hidden' value='$codDocumento' name='codDoc'>";
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
		}

		echo "</table>";

		echo "<table align='center'>";
			echo "<tr>";
			echo "<td align='center'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
	
	echo "</div>";
	
	for($a = 0; $a < count($arrCertificaciones); $a++){
	
		echo'<div id="'.$certificaciones[$a].'"  style="position: fixed; border-radius: 5px; border: 2px solid rgb(20, 24, 15); padding: 10px 40px; width:200px; height: 150px; overflow: scroll; width: 500px; height: 250px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; background-color: #E5E7E9; color: #111123; display:none;">';
			echo"<br>";
			echo"<table>";
			//echo'<div style="border: #333333 3px solid; background-color: #FAFAFA; color: blue;">';
			$y = $INTRANETV2->Execute("SELECT
										xt_codigoIndice,
										CASE xt_titulo WHEN '' THEN CONCAT(LEFT(xt_texto,40),'...') ELSE xt_titulo END
									FROM SGI_Normas_Texto
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
			//echo'<input align="right" id="btnAceptar" onclick="ocultarCertificacion(\''.$certificaciones[$a].'\');" name="btnAceptar" size="20" type="button" value="Guardar" />';
		echo'</div>';
		//echo'</div>';
		echo'<div id="'.$certificaciones[$a].'2" style="position: fixed; border-radius: 25px; width: 550px; height: 20px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: normal; solid; background-color: #E5E7E9; display:none;">
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
	
echo "</form>";
	
	
}

if($modifica == 1){
	
	$codDocumento = $_REQUEST['codDoc'];
	
	for($a = 0; $a < count($arrCertificaciones); $a++){
		
		$variableCertif = $_REQUEST[str_replace(' ', '', $arrCertificaciones[$a]."Texto")];
		
		$certifNuevos = trim($variableCertif);
		$certifNuevos = preg_split( '/(,|;)/', $certifNuevos);
	
		for($i = 0; $i<count($certifNuevos); $i++){
			
			$incisoCertif = trim($certifNuevos[$i]);
			
			if($incisoCertif != ''){
			
				$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento) VALUES ('$arrCertificaciones[$a]', '$incisoCertif', '$codDocumento')");
			}

		}
	}
	
	echo "<script type='text/javascript'>window.opener.location.reload(); window.close();</script>";
	
	
	
}


	
	?>
	
	</body>
</html>