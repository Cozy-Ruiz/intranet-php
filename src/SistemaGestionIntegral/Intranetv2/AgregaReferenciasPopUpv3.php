<?php
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
	function limpiar(valor) {
		if(valor == 'checkbox'){
			document.getElementById("referenciaTexto").value = "";
			var limpiar = document.getElementById("Limpiar").style.display = 'none';
			var desactivar = document.getElementsByName('referenciaValor[]');//.checked = false;

			for (i = 0; i < desactivar.length; i++) {
				if (desactivar[i].checked) {	
					desactivar[i].checked =  false
				}
			}
		}else{
			var limpiar = document.getElementById("Limpiar").style.display = 'block';
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
	
$codDocumento = $_GET['codDoc'];

$modifica == 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if($modifica == 0){
	
echo "<form name='fichaReferencia' method='POST' action='AgregaReferenciasPopUpv3.php' enctype='multipart/form-data'>";	
	echo "<div id='wrapperPopUp'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Referencias</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='50'> </tr>";
		echo "</table>";

		echo "<table align='center'>";
	
			echo "<tr>";
				echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarReferencia()">Referencias(Clik aqui)</a></td>';
				echo "<td align='left'>";
					echo'<input type="text" size="71"  maxlength="250" name="referenciaTexto" id="referenciaTexto" onkeyup="limpiar(\'captura\')">';
				echo"</td>";
				echo '<td align="right" style = "display:none;" id="Limpiar"><a href="javascript:void(0);" onclick="limpiar(\'checkbox\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" width="13"/></a></td>';
				//echo"<input type='text' name='$arrCertificaciones[$a]' size='65'></td>";
				echo "<input type='hidden' value='1' name='modifica'>";
				echo "<input type='hidden' value='$codDocumento' name='codDoc'>";
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
		
			echo "</tr>";
			echo "<tr height='10px'> </tr>";


		echo "</table>";

		echo "<table align='center'>";
			echo "<tr>";
			echo "<td align='center'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";

	echo "</div>";
	
	echo'<div id="referencias"  style="position: fixed; border-radius: 5px; border: 2px solid rgb(20, 24, 15); padding: 10px 40px;  width: 200px; height: 150px; overflow: scroll; width: 500px; height: 250px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; background-color: #E5E7E9; color: #111123; display:none;">';
		echo"<br>";
		echo"<table>";
		//echo'<div style="border: #333333 3px solid; background-color: #FAFAFA; color: blue;">';
			$y = $INTRANETV2->Execute("SELECT DISTINCT xt_nombre, xt_codigoCompleto FROM INTRANET2.SGI_Manuales_Documentos ORDER BY xt_codigoCompleto ASC");
				while($o = $y->fetchRow()){
					$tituloManual   = $o[0];
					$codigoCompleto = $o[1];

						echo"<tr>";
						 echo"<td>";
							echo"<label>";
								echo "<input type='checkbox' name='referenciaValor[]' id='referenciaValor[]' value='".$codigoCompleto."'> <span></span> ".$codigoCompleto."-".$tituloManual."</option><br><br>";
							echo"</label>";
						echo"</td>";
					echo"</tr>";

				}

			$z = $INTRANETV2->Execute("SELECT DISTINCT xt_nombre, xt_codigoProceso FROM INTRANET2.SGI_Procesos ORDER BY xt_codigoProceso ASC");

			while($h = $z->fetchRow()){
					$tituloProceso   = $h[0];
					$codigoCompletoProc = $h[1];

						echo"<tr>";
						 echo"<td>";
							echo"<label>";
								echo "<input type='checkbox' name='referenciaValor[]' id='referenciaValor[]' value='".$codigoCompletoProc."'> <span></span> ".$codigoCompletoProc."-".$tituloProceso."</option><br><br>";
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
	
}

if($modifica == 1){
	
	 $codDocumento = $_REQUEST['codDoc'];
	
		$variableReferencias = $_REQUEST['referenciaTexto'];
	
		$refNuevos = trim($variableReferencias);
		$refNuevos = preg_split( '/(,|;)/', $refNuevos);
	
		for($a = 0; $a < count($refNuevos); $a++){
			$codRef = trim($refNuevos[$a]);


			$codigoManualRef = $INTRANETV2->getOne("SELECT xt_codigoDocumento FROM SGI_Manuales_Documentos WHERE xt_codigoCompleto = '".$codRef."'");
			if(!empty($codigoManualRef)){

				$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES ('".$codDocumento."', '".$codigoManualRef."')");

			}else{

				$codigoProsRef = $INTRANETV2->getOne("SELECT xt_codigoCorto FROM SGI_Procesos WHERE xt_codigoProceso = '".$codRef."'");

				if(!empty($codigoProsRef)){

					$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES ('".$codDocumento."', '".$codigoProsRef."')");
				}

			}
			/*$tt = $INTRANETV2->Execute("SELECT xt_codigoDocumento FROM SGI_Manuales_Documentos WHERE xt_codigoCompleto = '$codRef'");
				while($rr = $tt->fetchRow()){
					$codigoManualRef = $rr[0];
					
					
					$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES 		('$codDocumento', '$codigoManualRef')");
					
				}unset($t); unset($r);*/
		
		}
		
	echo "<script type='text/javascript'>window.opener.location.reload(); window.close();</script>";
	
}


	
	?>
	
	</body>
</html>