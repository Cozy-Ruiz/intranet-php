<?php
 
$nombrephp = 'FichaItemModificacionSGI.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

if($_GET['id'] != ""){
	
	$codDocumento = $_GET['id'];
	$tipoDeDocumento = $_GET['tipoDoc'];
	
	
} else if($_POST['id'] != ""){
	
	$codDocumento = $_POST['id']; 
	
}


$modifica = 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}


if($modifica == 0){
	
	
	//obtengo el titulo del documento
	$s = $INTRANETV2->Execute("SELECT xt_nombre, xt_tipoDocumento, xt_codigoManual, xt_grupo, xt_ciudad FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
	
	while($r = $s->fetchRow()){
		
		$nombre 		= $r[0];
		$tipo 			= $r[1];
		$codManual  	= $r[2];
		$codGrupo  	    = $r[3];
		$codCiudad  	= $r[4];
		
	} unset($r);
	
	
	$s = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoNorma FROM SGI_Catalogo_Normas");
	$i = 0;
		//$arrCertificaciones = array();

	while($p = $s->fetchRow()){

		$arrCertificaciones[$i] = $p[0];
		$i++;
	}unset($i);
		
		
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Ficha Modificación</title>
                 <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
					}
				?>
               	<script tye="text/javascript">
					function mostrarCertificacion(certificacion, orden){
						
						var ventana = document.getElementById(certificacion);
						ventana.style.display = 'block';

						var valorInput = document.getElementById(certificacion+"Orden");
						valorInput.value = certificacion+orden;
						
						var ventanaPadre = document.getElementById("wrapper"); // Accedemos al contenedor
						ventanaPadre.style.opacity = "0.2"; // Y lo hacemos invisible*/
					}
					function ocultarCertificacion(certificacion,estatus){
		

						var nuevoEstatus = estatus.trim();

						var ventana = document.getElementById(certificacion); // Accedemos al contenedor
						ventana.style.display = 'none'; // Y lo hacemos invisible

						var ventanaPadre = document.getElementById("wrapper"); // Accedemos al contenedor
						ventanaPadre.style.opacity = "1"; // Y lo hacemos invisible
						
						

						if(nuevoEstatus == 'guardar'){
							
							var valorInputMostrar = document.getElementById(certificacion+'Orden').value;
							var valorNormaExiste  = document.getElementById(valorInputMostrar).value;
							
						
							var neec = document.getElementsByName(certificacion+'Valor[]');
							var texto = "";
							for (i = 0; i < neec.length; i++) {
								if (neec[i].checked) {
									texto = texto + neec[i].value + ",";
								}
							}
							if(valorNormaExiste != ''){
								var textoNEEC = valorNormaExiste+','+texto.slice(0,-1);
							}else{
								var textoNEEC = texto.slice(0,-1);
							}
							
							document.getElementById(valorInputMostrar).value = textoNEEC;
							
							var limpiarCheckbox = document.getElementsByName(certificacion+'Valor[]');
							for (i = 0; i < limpiarCheckbox.length; i++) {
								if (limpiarCheckbox[i].checked) {	

									limpiarCheckbox[i].checked =  false
								}
							}
							if(textoNEEC != ''){
								var limpiar = document.getElementById(valorInputMostrar+"Limpiar").style.display = 'block';
							}else{

							}
						}else{

						}

					}
					
					function limpiarCertificacion(certificacion,orden) {
		
						document.getElementById(certificacion+orden).value = "";
						var limpiar = document.getElementById(certificacion+orden+"Limpiar").style.display = 'none';

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
					  display: none;
					}
					label span {
					  height: 15px;
					  width: 15px;
					  border: 2px solid #000000;
					  display: inline-block;
					  position: relative;
					}
					[type=checkbox]:checked + span:before {
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
					/* Ventana (background) */
					</style>
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            </head>
        <body>
    <?php
	
	echo"<div id='wrapper' align='center'>";
		echo "<form action='fichaModificacionDocumentosv3.php' method='POST'>";
	
			echo "<table border='0' align='center'>";
				echo"<tr height='15px'> </tr>";
				///MANUAL
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='700px'><b>Manual</b></td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
				echo "<select name='selectManual'>";
	
					$z = $INTRANETV2->Execute("SELECT xt_codigoManual, xt_nombre FROM SGI_Catalogo_Manuales");
				
					while($t = $z->fetchRow()){
					
						if($codManual == $t[0]){
							
							echo "<option value='$t[0]' selected >$t[0]---$t[1]</option>";
						}else{
							
							echo "<option value='$t[0]'>$t[0]---$t[1]</option>";
						}
					}
  					
				echo "</select>";
					
	
	
			echo "<table border='0' align='center'>";
				echo"<tr height='15px'> </tr>";
				///Grupo
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='700px'><b>Grupo</b></td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			echo "<select name='selectGrupo'>";
	
					$p = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Grupos");
				
					while($b = $p->fetchRow()){
					
						if($codGrupo == $b[0]){
							
							echo "<option value='$b[0]' selected >$b[0]---$b[1]</option>";
						}else{
							
							echo "<option value='$b[0]'>$b[0]---$b[1]</option>";
						}
					}
  					
				echo "</select>";
	
			echo "<table border='0' align='center'>";
				echo"<tr height='15px'> </tr>";
				///Ciudad
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='700px'><b>Ciudad</b></td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			echo "<select name='selectCiudad'>";
	
				$e = $INTRANETV2->Execute("SELECT xt_sucursal, xt_nombre FROM SGI_Catalogo_Sucursales");

				while($v = $e->fetchRow()){

					if($codCiudad == $v[0]){

						echo "<option value='$v[0]' selected >$v[0]--$v[1]</option>";
					}else{

						echo "<option value='$v[0]'>$v[0]--$v[1]</option>";
					}
				}
  					
			echo "</select>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='15px'> </tr>";
				///Certificaciones
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='700px'><b>Titulo</b></td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
		
			echo "<table border='0' align='center' name='Encabezado'>";
				///Titulo Ficha
				echo"<tr>";
					echo"<td align='center' colspan='2'>";
						echo "<input type='text' name='nombreModificado' value='$nombre' size='100'><br>";
						
						echo "<input type='hidden' value='1' name='modifica'>
						<input type='hidden' value='$codDocumento' name='codDocId'>
						<input type='hidden' value='$tipoDeDocumento' name='tipoDoc'>";
	
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10px'> </tr>";
				///Bread Crumb
				echo"<tr>"; 
					echo"<td align='center'  colspan='2'>";
						//echo "<font>$breadcrumb</font>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
	
			//obtengo codigo de certificaciones
			if($tipoDeDocumento != "C"){
			
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Certificaciones
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='700px'><b>Certificaciones</b></td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom'></td>";
					echo "</tr>";
					echo"<tr height='30px'> </tr>";
				 echo "</table>";
	
				$t = $INTRANETV2->Execute("SELECT xt_codigoNorma FROM SGI_Catalogo_Normas");
				$indiceCer = 0;

				while($r = $t->fetchRow()){
					$tipoCertificaciones[$indiceCer]= $r[0];
					$indiceCer++;

				}unset($t); unset($r);


				for($listCer = 0; $listCer < count($tipoCertificaciones); $listCer++){
					
					$nombreNorma = $tipoCertificaciones[$listCer];

					echo "<table border='0' align='center'>";
					///ISO
						echo "<tr>";
							echo "<td width='30px'> </td>";
							

							echo "<td align='right' id='iconosTexto' width='75px'>$nombreNorma:</td>";



							$s = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento' AND xt_codigoDocumentoNorma = '$tipoCertificaciones[$listCer]' ORDER BY xt_indiceDocumentoNorma ASC");

							$valoresNorma = "";
							$banderaComa = 0;
							while($r = $s->fetchRow()){
								
								if($banderaComa == 0){
									
									$valoresNorma .= trim($r[0]);
								}else{
									
									$valoresNorma .= ", ".trim($r[0]);
								}
								
								$banderaComa++;

							} unset($r);

							echo "<td width='600px'><input type='text' value='$valoresNorma' name='incisoCertifModf".$listCer."' size='50'></td>";
							echo "<input type='hidden' value='$nombreNorma' name='nomCertificacionModf".$listCer."'>";
							echo "<input type='hidden' value='".count($tipoCertificaciones)."' name='totalCertificaciones'>";
					
						echo "</tr>";
					echo "</table>";

					$indiceNorma++;

				}
			
				//REFERENCIAS
				
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='700px'><b>Referencias</b></td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom'></td>";
					echo "</tr>";
					echo"<tr height='30px'> </tr>";
				echo "</table>";

				echo "<table border='0' align='center'>";
						///ISO
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
								//$t = $INTRANETV2->Execute("SELECT xt_codigoReferencia FROM INTRANET2.SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocumento'");

							
								/*$t = $INTRANETV2->Execute("SELECT
																(SELECT MC.xt_codigoCompleto FROM INTRANET2.SGI_Manuales_Documentos MC WHERE MC.xt_codigoDocumento = DR.xt_codigoReferencia)
															FROM
																INTRANET2.SGI_Manuales_Documentos_Referencias DR
															WHERE
																DR.xt_codigoDocumento = '$codDocumento'");*/

								$t = $INTRANETV2->Execute("SELECT
															( SELECT MC.xt_codigoCompleto FROM SGI_Manuales_Documentos MC WHERE MC.xt_codigoDocumento = DR.xt_codigoReferencia ),
															( SELECT MP.xt_codigoProceso FROM SGI_Procesos MP WHERE MP.xt_codigoCorto = DR.xt_codigoReferencia ) 
														FROM
															SGI_Manuales_Documentos_Referencias DR 
														WHERE
															DR.xt_codigoDocumento = '$codDocumento'");


								$docRefValor = "";
								$banderaComa = 0;
				
								while($v = $t->fetchRow()){

									if(!empty($v[0])){
									
										if($banderaComa == 0){
										
											$docRefValor .= trim($v[0]);
										
										}else{
										
											$docRefValor .= ", ".trim($v[0]);
										}

									}else{

										if(!empty($v[1])){


											if($banderaComa == 0){
										
												$docRefValor .= trim($v[1]);
										
											}else{
										
												$docRefValor .= ", ".trim($v[1]);
											}

										}
									}
									
									$banderaComa++;
									
								}
				
								echo "<input type='text' value='$docRefValor' name='docRefModificado' size='70'>";

						echo "</td>";
					echo "</tr>";
				echo "</table>";
			}
			
			if(($tipoDeDocumento == "P") || ($tipoDeDocumento == "L") || ($tipoDeDocumento == "I") || ($tipoDeDocumento == "X")){
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='700px'><b>Elementos</b></td>";
						
					echo "</tr>";
					///Linea
					echo "<tr>";
						///COLSPAN=2
						echo "<td id='titleBlueLineBottom' ></td>";
					echo "</tr>";
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
				$i = 0;
				
				
				$s = $INTRANETV2->Execute("SELECT xn_orden, xt_titulo, xt_contenido, xt_tipoElemento, xt_tipoElemento  FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden");
				
				while($r = $s->fetchRow()){
					
					$numeroElemento[$i] = $r[0];
					$tituloElemento[$i] = utf8_encode($r[1]);
					$contenidoElemento[$i] = $r[2];
					$tipoElemento[$i] = utf8_decode($r[3]);
					$i++;
					
				} unset($r); unset($s);
			}
			
			$bandera = 0;
	
			if($numeroElemento[0] != 0){
					
				$inicializadorA = 0;
					
			}else{
					
				$inicializadorA = 1;
			}
			
			if($tipoDeDocumento == "P"){
				
				
				echo "<input type='hidden' value='".count($numeroElemento)."' name='totalElementosP'>";
				
				for($a = $inicializadorA; $a < count($numeroElemento); $a++){
					
					if($inicializadorA == 0){
						$numOrden = $a + 1;
					}else{
						$numOrden = $a;
					}
					
					
					if($tipoElemento[$a] == "A"){
						$bandera++;
					}
					
					if($bandera == 0){
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td> </td>";
								echo "<td align='left' id='iconosTexto' colspan='2'>";
										echo $numeroElemento[$a].". $tituloElemento[$a]";
								echo "</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td align='left' width='30px'> </td>";
								echo "<td width='640' id='fileItem'>";
										echo "<textarea name='contenido$numOrden' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
								echo "</td>";
							echo "</tr>";
							echo "<tr height='20px'> </tr>";
						echo "</table>";
					} else if($bandera == 1){
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td> </td>";
								echo "<td align='left' id='iconosTexto' colspan='2'>";
										echo $numeroElemento[$a].". DESARROLLO";
								echo "</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td align='left' width='30px'> </td>";
								echo "<td width='640' id='fileItem'>";
									if(substr($contenidoElemento[$a], -4) == ".pdf"){
										echo "<br><br>
										<object data='$contenidoElemento[$a]' type='application/pdf' width='639px' height='300px'><object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='950px' height='700px'>
												  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
												  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
												  </p>
											  </object><a href='/Sistemas/INTRANET_GEA/SistemaGestionIntegral/AgregaElementos/CambiarArchivoPopUpv3.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
									} else{
										echo "<textarea name='contenido$numOrden' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
									}
								echo "</td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						echo "</table>";
					} else if($bandera > 1){
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td align='left' width='30px'> </td>";
								echo "<td width='640' id='fileItem'>";
									if(substr($contenidoElemento[$a], -4) == ".pdf"){
										echo "<br><br>
										<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='950px' height='700px'>
												  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
												  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
												  </p>
											  </object><a href='/Sistemas/INTRANET_GEA/SistemaGestionIntegral/AgregaElementos/CambiarArchivoPopUpv3.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
									} else{
										echo "<textarea name='contenido$numOrden' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
									}
								echo "</td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						echo "</table>";
					}
				}
			}
			
			if($tipoDeDocumento == "L" || $tipoDeDocumento == "I" || $tipoDeDocumento == "X"){
				
				echo "<input type='hidden' value='".count($numeroElemento)."' name='totalElementosLIDE'>";
				
				for($a = $inicializadorA; $a < count($numeroElemento); $a++){
					
					if($inicializadorA == 0){
						$numOrden = $a + 1;
						
					}else{
						
						$numOrden = $a;
					}
					
					
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td width='670' id='fileItem'>";
								if(substr($contenidoElemento[$a], -4) == ".pdf"){
									echo "<br><br>
									<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='950px' height='700px'>
											  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
											  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
											  </p>
										  </object><a href='/Sistemas/INTRANET_GEA/SistemaGestionIntegral/AgregaElementos/CambiarArchivoPopUpv3.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
										  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
								} else{
									
									echo "<textarea name='contenido$numOrden' style='width: 669px; height: 50px;'>$contenidoElemento[$a]</textarea>";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr height='10px'> </tr>";
					echo "</table>";
				}
			}
			
			
			if($tipoDeDocumento == "C"){
				
				$i = 0;
				
				$s = $INTRANETV2->Execute("SELECT xn_orden, xt_tipoElemento, xt_contenido, xt_titulo, xt_outLine, xt_codigoDocumento FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden");
		
				while($r = $s->fetchRow()){
					$numeroElemento[$i] = $r[0];
					$tipoElemento[$i] = $r[1];
					$contenidoElemento[$i] = $r[2];
					$titulo[$i] = trim($r[3]);

					$outLine[$i] = $r[4];
					$subnivel = (explode('.', trim($outLine[$i])));
					$nivel[$i] = count($subnivel);

					$elementoCapID[$i] = $r[5];

					$refIso2008[$i] = "";
					$refIso2015[$i] = "";
					$refQCB[$i] = "";
					$refQCB2016[$i] = "";
					$refIso2008[$i] = "";
					$refNeec[$i] = "";
					$refSCC[$i] = "";
		
					
					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 37001:2017'");
					
					while($t = $u->fetchRow()){
						
						$refIso2008[$i] = $refIso2008[$i].trim($t[0]).", ";
						
					} unset($t); unset($u);
					
					

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 9001:2015'");
					while($t = $u->fetchRow()){
						
						$refIso2015[$i] = $refIso2015[$i].trim($t[0]).", ";
						
					} unset($t); unset($u);
					

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'QCB'");
					while($t = $u->fetchRow()){
						
						$refQCB[$i] = $refQCB[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
					
					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'QCB 2016'");
					while($t = $u->fetchRow()){
						
						$refQCB2016[$i] = $refQCB2016[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'OEA'");

					while($t = $u->fetchRow()){
						
						$refNeec[$i] = $refNeec[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'SCC'");

					while($t = $u->fetchRow()){
						
						$refSCC[$i] = $refSCC[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
				
					$u = $INTRANETV2->Execute("SELECT
							MID.xt_codigoDocumentoNorma,
							MD.xt_nombre,
							xt_indiceDocumentoNorma
						FROM
							SGI_Normas_Incisos_Documentos MID,
							SGI_Manuales_Documentos MD
						WHERE
							MID.xt_codigoDocumento = '$elementoCapID[$i]'
						AND MID.xt_indiceDocumento = '$outLine[$i]'
						AND MD.xt_codigoDocumento = MID.xt_codigoDocumentoNorma");

						while($t = $u->fetchRow()){
							$idDocRef = trim($t[0]);
							$tituloDocRef = $t[1];
							$indiceDocRef = $t[2];

							//$idDocRef = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$clave' ");
							$refDoc[$i] = $refDoc[$i]."$idDocRef, ";

						} unset($t); unset($u);
						
						
						
					if($refIso2008[$i] != ""){
						$refIso2008[$i] = substr($refIso2008[$i], 0, -2);
					}
					
					if($refIso2015[$i] != ""){
						$refIso2015[$i] = substr($refIso2015[$i], 0, -2);
					}
					if($refQCB[$i] != ""){
						$refQCB[$i] = substr($refQCB[$i], 0, -2);
					}
					if($refQCB2016[$i] != ""){
						$refQCB2016[$i] = substr($refQCB2016[$i], 0, -2);
					}
					if($refNeec[$i] != ""){
						$refNeec[$i] = substr($refNeec[$i], 0, -2);
					}
					if($refSCC[$i] != ""){
						$refSCC[$i] = substr($refSCC[$i], 0, -2);
					}
					
					if($refDoc[$i] != ""){
						$refDoc[$i] = substr($refDoc[$i], 0, -2);
					}
					
					$i++;
					
				} unset($r); unset($s);
				
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='685px'><b>Elementos</b></td>";
						echo "<td align='right' width='15px'> </td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
				
				echo "<input type='hidden' value='".count($numeroElemento)."' name='totalElementosC'>";
				
				for($a = 0; $a < count($numeroElemento); $a++){
					
					$numOrden = $a + 1;
					
					if(substr($contenidoElemento[$a], -4) == ".pdf"){
						
						echo "<br><br>
						<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='950px' height='700px'>
								  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
								  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
								  </p>
							  </object><a href='/Sistemas/INTRANET_GEA/SistemaGestionIntegral/AgregaElementos/CambiarArchivoPopUpv3.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
							  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
								
					} else{
						
						echo "<input type='hidden' value='$outLine[$a]' name='outline".$numOrden."'>";
						          
						echo "<table border='0' align='center'>";
							
							echo "<tr>";
								echo "<td width='63px'>$outLine[$a]</td>";
								//echo "<td><input type='text' name='outline".$numOrden."' value='$outLine[$a]' size='7'></td>";
								echo "<td align='left'><input type='text' name='titulo".$numOrden."' value='$titulo[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							
							/****** modificar para el uso de  37001:2017********/

								echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'ISO 2008\',\''.$numOrden.'\')">ISO 37001:2017:</a></td>';
								echo "<td align='left'><input type='text' name='ISO2008".$numOrden."' id='ISO 2008".$numOrden."' value='$refIso2008[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="ISO 2008'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'ISO 2008\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";



							/*********Modificado para obtener ISO 9001:2015*********/

							echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'ISO 2015\',\''.$numOrden.'\')">ISO 9001:2015:</a></td>';
								echo "<td align='left'><input type='text' name='ISO2015".$numOrden."' id='ISO 2015".$numOrden."' value='$refIso2015[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="ISO 2015'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'ISO 2015\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";

							echo "<tr height='10px'> </tr>";

						
						
									
						
						/*echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'QCB\',\''.$numOrden.'\')">QCB:</a></td>';
								echo "<td align='left'><input type='text' name='QCB".$numOrden."' id='QCB".$numOrden."' value='$refQCB[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="QCB'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'QCB\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						*/
						   echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'QCB 2016\',\''.$numOrden.'\')">QCB 2016:</a></td>';
								echo "<td align='left'><input type='text' name='QCB2016".$numOrden."' id='QCB 2016".$numOrden."' value='$refQCB2016[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="QCB 2016'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'QCB 2016\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						/*
							echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'NEEC\',\''.$numOrden.'\')">NEEC:</a></td>';
								echo "<td align='left'><input type='text' name='NEEC".$numOrden."' id='NEEC".$numOrden."' value='$refNeec[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="NEEC'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'NEEC\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						*/
							echo "<tr>";
								echo '<td align="right" id="fileItem"><a href="javascript:void(0);" onclick="mostrarCertificacion(\'SCC\',\''.$numOrden.'\')">SCC:</a></td>';
								echo "<td align='left'><input type='text' name='SCC".$numOrden."' id='SCC".$numOrden."' value='$refSCC[$a]' size='65'></td>";
								echo '<td align="right" style = "display:none;" id="SCC'.$numOrden.'Limpiar"><a href="javascript:void(0);" 
										onclick="limpiarCertificacion(\'SCC\',\''.$numOrden.'\')"><img src="../../Imagenes/ICN_NoOK.png" height="13" align="middle" width="13"/></a>
									 </td>';
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>Referencias:</td>";
								echo "<td align='left'><input type='text' name='refDocu".$numOrden."' value='$refDoc[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
							
							echo "<tr>";
								echo "<td width='80px'> </td>";
								echo "<td width='600' id='fileItem'><textarea name='contenido$numOrden' style='width: 600px; height: 50px;'>$contenidoElemento[$a]</textarea></td>";
							echo "</tr>";
							
						echo "</table>";	
					}
						
					echo "<table>";		
						echo "<tr height='10px'> </tr>";
					echo "</table>";
				}
			}
			
			
			if($tipo == "F"){
				
				$i = 0;
				$s = $INTRANETV2->Execute("SELECT
								 xn_orden,
								 xt_titulo,
								 xt_contenido,
								 xt_tipoElemento
								FROM
								 SGI_Manuales_Elementos
								WHERE
								 xt_codigoDocumento = '$codDocumento'
								AND (
								 xt_titulo NOT IN (
								  'Origen',
								  'Tipo',
								  'Responsable',
								  'Almacenamiento',
								  'Proteccion',
								  'Recuperacion',
								  'Retencion',
								  'Disposicion'
								 )
								 OR xt_titulo IS NULL
								)
								ORDER BY
								 xn_orden");
				
				while($r = $s->fetchRow()){
					$numeroElemento[$i] = $r[0];
					$tituloElemento[$i] 	= $r[1];
					$tipoElemento[$i] 	= $r[3];

					$contenidoElemento[$i] = $r[2];
					$i++;
				}unset($r); unset($s);
	
				
				
				if($numeroElemento != NULL){
					echo "<table border='0' align='center'>";
						echo"<tr height='30px'> </tr>";
						///Referencias
						echo "<tr id='titulo2'>";
							echo "<td align='left' width='685px'><b>Formato</b></td>";
							echo "<td align='right' width='15px'> </td>";
						echo "</tr>";
						///Linea
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						echo"<tr height='30px'> </tr>";
					echo "</table>";
				}
				
				$bandera = 0;
				
				for($a = 0; $a < count($numeroElemento); $a++){
					
					$numOrden = $a + 1;
					
					if(substr($contenidoElemento[$a], 0, 12) == "../../FILES/"){
						echo "<table>";	
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td width='670' id='fileItem'  align='justify'>";
									echo "<img src='../../Imagenes/ICN_Archivo.png'> ".substr($contenidoElemento[$a], 12, strlen($contenidoElemento[$a]));
									echo " <a href='/Sistemas/INTRANET_GEA/SistemaGestionIntegral/AgregaElementos/CambiarArchivoPopUpv3.php?codDoc=$codDocumento&nOrden=$numeroElemento[$a]' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../../Imagenes/ICN_BotonModificar.png'></a>";
								echo "</td>";
							echo "</tr>";
							echo "<tr height='20px'> </tr>";
						echo "</table>";
					} else{
						echo "<table>";	
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td width='670' id='fileItem'  align='justify'>";
									echo "<textarea name='contenido$a' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
								echo "</td>";
							echo "</tr>";
							echo "<tr height='20px'> </tr>";
						echo "</table>";	
					}
						
					echo "<table>";		
						echo "<tr height='10px'> </tr>";
					echo "</table>";
				
				}
				
					
					$banderaMuestraTitulo = 0;
					
					$s = $INTRANETV2->Execute("SELECT
							 xt_titulo,
							 xt_contenido,
							 xt_tipoElemento
							FROM
							 SGI_Manuales_Elementos
							WHERE
							 xt_codigoDocumento = '$codDocumento'
							AND 
							 xt_titulo IN (
							  'Origen',
							  'Tipo',
							  'Responsable',
							  'Almacenamiento',
							  'Proteccion',
							  'Recuperacion',
							  'Retencion',
							  'Disposicion'
							 ) ORDER BY xn_orden ASC");
					
					while($r = $s->fetchRow()){
						
						$banderaMuestraTitulo++;
		
						if($banderaMuestraTitulo == 1){
			
							echo "<table border='0' align='center'>";
								echo"<tr height='30px'> </tr>";
								///Referencias
								echo "<tr id='titulo2'>";
									echo "<td align='left' width='685px'><b>Control de Registro</b></td>";
									echo "<td align='right' width='15px'>";

									echo "</td>";
								echo "</tr>";
								///Linea
								echo "<tr>";
									echo "<td id='titleBlueLineBottom' colspan='2'></td>";
								echo "</tr>";
								echo"<tr height='30px'> </tr>";
							echo "</table>";
							
							echo "<table border='0' align='center'>";
							
								echo "<tr>";
									echo "<td width='30px'> </td>";
									echo "<td align='left' id='iconosTexto' width='120px'>$r[0]:</td>";
									echo "<td align='left' width='570px'>";
										echo"<input type='text' name='$r[0]' size='40' value='$r[1]'>";
									echo "</td>";
								echo "</tr>";

								echo "<tr height='10px'> </tr>";
							
 							echo "</table>";
							
						
						}else{
							
							echo "<table border='0' align='center'>";
							
								echo "<tr>";
									echo "<td width='30px'> </td>";
									echo "<td align='left' id='iconosTexto' width='120px'>$r[0]:</td>";
									echo "<td align='left' width='570px'>";
										echo"<input type='text' name='$r[0]' size='40' value='$r[1]'>";
									echo "</td>";
								echo "</tr>";

								echo "<tr height='10px'> </tr>";
							
 							echo "</table>";
						
						}
						
						
						
					} unset($r); unset($s);
					
			}
			
			
			///FIN DEL DOCUMENTO
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='700px'></td>";
				echo "</tr>";
				
				echo"<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10px'> </tr>";
		
				echo "<tr>";
					echo "<td align='center' id='nota_al_pie'>";
					///Titulo
						//echo "Creado: $fechaCreacion";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='40px'> </tr>";
				
			echo "</table>";
	
	echo"</div>";
	
	//Div para mostrar el listado de las certificaciones
	
	for($a = 0; $a < count($arrCertificaciones); $a++){
		echo'<div id="'.$arrCertificaciones[$a].'"  style="position: fixed; border-radius: 5px;
			border: 2px solid rgb(20, 24, 15); padding: 10px 40px; width: 200px; height: 150px; 
			 width: 500px; height: 250px; top: 50%; left: 50%; margin-top: -200px; margin-left: -300px;  font-family:Verdana, 
			Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; background-color: 
			#E5E7E9; color: #111123; display:none;">';
			echo"<br>";
		
			echo'<div style="position: absolute; top: 10px; right: 0; width: 550px; height: 235px; overflow: auto;">';
			echo"<table>";
			$y = $INTRANETV2->Execute("SELECT
										xt_codigoIndice,
										CASE xt_titulo WHEN '' THEN CONCAT(LEFT(xt_texto,40),'...') ELSE xt_titulo END
									FROM SGI_Normas_Texto
									WHERE
										xt_codigoIndice != 0
									AND xt_codigoNorma = '$arrCertificaciones[$a]'
									ORDER BY
										INET_ATON(SUBSTRING_INDEX(CONCAT(xt_codigoIndice,'.0.0.0.0'),'.',5))
									");
				while($o = $y->fetchRow()){
					$codigoNorma = $o[0];
					$tituloNorma = $o[1];

						echo"<tr>";
						 echo"<td>";
							echo"<label>";
								echo "<input type='checkbox' name='".$arrCertificaciones[$a]."Valor[]' id='".$arrCertificaciones[$a]."Valor[]' value='".$codigoNorma."'> <span></span> ".$codigoNorma."-".$tituloNorma."</option><br><br>";
							echo"</label>";
						echo"</td>";
					echo"</tr>";

				}
		 echo"</table>";
		 echo"</div>";
		 echo'<div style="position: absolute; top: 235px; right: 0; width: 560px; height: 235px; overflow: auto;">';
		 echo'<table>
				<tr>
					<td align="left" width="250px">
						<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarCertificacion(\''.$arrCertificaciones[$a].'\',\'guardar\');" name="btnAceptar" value="Guardar" />
					</td>
					<td align="right" width="300px">
						<input type="button" align="right" id="btnAceptar" class="button" style="cursor: pointer; font-size:15px; color: black;" onclick="ocultarCertificacion(\''.$arrCertificaciones[$a].'\',\'cancelar\');" name="btnAceptar" value="Cancelar" />
					</td>
					<input type="hidden" name="'.$arrCertificaciones[$a].'Orden" id="'.$arrCertificaciones[$a].'Orden">
				</tr>
			</table>';
		echo"</div>";
		echo'</div>';
	}
	echo "</form>";
	
//SI SE HIZO ALGUNA MODIFICACIÓN
	
} else if(($modifica == 1) && ($_POST['nombreModificado'] != "")){

	function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
	
	$tipoDeDocumento = $_REQUEST['tipoDoc'];
	
	$codDocModifica = $_POST['codDocId'];
	$nombreDocNuevo = $_POST['nombreModificado'];
	//$consecutivo = $_POST['consecutivo'];
	
	$grupoNuevo 	= $_REQUEST['selectGrupo'];
	$manualNuevo 	= $_REQUEST['selectManual'];
	$ciudadNuevo 	= $_REQUEST['selectCiudad'];
	
	//genero codigo de documento
	$codigoCompleto = trim($grupoNuevo."-".$manualNuevo."-".$ciudadNuevo."-".$tipoDeDocumento."-".$codDocModifica);

	
	//ACTUALIZO GRUPO, CIUDAD Y MANUAL DEL DOCUMENTO
	
	if($INTRANETV2->Execute("UPDATE SGI_Manuales_Documentos SET xt_codigoManual = '$manualNuevo', xt_grupo = '$grupoNuevo', xt_ciudad = '$ciudadNuevo'  WHERE xt_codigoDocumento = '$codDocModifica'")){
		
		//ACTUALIZO EL CODIGO COMPLETO
		
		$INTRANETV2->Execute("UPDATE SGI_Manuales_Documentos SET xt_codigoCompleto = '$codigoCompleto'  WHERE xt_codigoDocumento = '$codDocModifica'");
	}
	
	
	$nombreDocActual = "";
	
	//Modificacion en el titulo
	$nombreDocActual = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocModifica'");
	
	
	if($nombreDocNuevo != $nombreDocActual){
		
		
		$INTRANETV2->Execute("UPDATE SGI_Manuales_Documentos SET xt_nombre = '$nombreDocNuevo' WHERE xt_codigoDocumento = '$codDocModifica'");
		
	}

	
	//Modificacion en las cerificaciones
	
	$dato = "";
	
	$totalCertificaciones = $_REQUEST['totalCertificaciones'];
	
	for($cont = 0; $cont < $totalCertificaciones; $cont++){
		
		 $normaModificar = $_REQUEST['nomCertificacionModf'.$cont];
		 $incisoModificar = $_REQUEST['incisoCertifModf'.$cont];
		
		
		
		if($incisoModificar != ""){
			
			$codDocModifica = trim($codDocModifica);
			$normaModificar = ltrim(rtrim($normaModificar));
		
		
			if($s = $INTRANETV2->getOne("SELECT xt_codigoDocumento FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocModifica' AND xt_codigoDocumentoNorma = '$normaModificar' AND xt_indiceDocumento = ''")){
		
			$s = $INTRANETV2->Execute("DELETE FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocModifica' AND xt_codigoDocumentoNorma = '$normaModificar' AND xt_indiceDocumento = ''");
			}
	
		
			 $incisosNuevos = explode(',', $incisoModificar);
		
			for($i = 0; $i < count($incisosNuevos); $i++){
				$dato = trim($incisosNuevos[$i]);
				
				$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento) VALUES ('$normaModificar', '$dato', '$codDocModifica')");
			}
		
			unset($i);
		
		} unset($s);
	}
	
	//MODIFICACION DE REFERENCIAS
	if($tipoDeDocumento != "C"){
		$dato = "";

		if(!empty($_REQUEST['docRefModificado'])){

			$codDocModifica = trim($codDocModifica);
			$referenciasNuevas = trim($_REQUEST['docRefModificado']);



			if($s = $INTRANETV2->getOne("SELECT xt_codigoReferencia FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocModifica'")){

				$s = $INTRANETV2->Execute("DELETE FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocModifica'");

			}


			 $referenciasNuevas = explode(',', $referenciasNuevas);

			for($i = 0; $i < count($referenciasNuevas); $i++){
				 $referenciasNuevas[$i];

				$dato = trim($referenciasNuevas[$i]);

				

				$codManualRef = $INTRANETV2->getOne("SELECT xt_codigoDocumento FROM SGI_Manuales_Documentos WHERE xt_codigoCompleto = '$dato'");

				if(!empty($codManualRef)){


					$s = $INTRANETV2->Execute("INSERT INTO SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES ('$codDocModifica', '$codManualRef')");

				}else{

					
					$codProceso =$INTRANETV2->getOne("SELECT xt_codigoCorto FROM SGI_Procesos WHERE xt_codigoProceso = '$dato'");

					if(!empty($codProceso)){

						
						$s = $INTRANETV2->Execute("INSERT INTO SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES ('$codDocModifica', '$codProceso')");


					}
				}

				
			}

			unset($i);

		} unset($s);
		
	}
	
	
	//CONTROL DE REGISTROS
	if($tipoDeDocumento == "F"){
		
		if($_REQUEST['Origen'] != ''){
			
			$origenCR = $_REQUEST['Origen'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$origenCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Origen'");
			
		}
		
		if($_REQUEST['Tipo'] != ''){
			$tipoCR = $_REQUEST['Tipo'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$tipoCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Tipo'");
			
		}
		
		if($_REQUEST['Responsable'] != ''){
			
			$responsableCR = $_REQUEST['Responsable'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$responsableCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Responsable'");
			
		}
		
		if($_REQUEST['Almacenamiento'] != ''){
			$almacenamientoCR = $_REQUEST['Almacenamiento'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$almacenamientoCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Almacenamiento'");
			
		}
		
		if($_REQUEST['Proteccion'] != ''){
			
			$proteccionCR = $_REQUEST['Proteccion'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$proteccionCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Proteccion'");
			
		}
		
		if($_REQUEST['Recuperacion'] != ''){
			
			$recuperacionCR = $_REQUEST['Recuperacion'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$recuperacionCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Recuperacion'");
			
		}
		
		if($_REQUEST['Retencion'] != ''){
			
			$retencionCR = $_REQUEST['Retencion'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$retencionCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Retencion'");
			
		}
		
		if($_REQUEST['Disposicion'] != ''){
			
			$disposicionCR = $_REQUEST['Disposicion'];
			$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$disposicionCR' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_titulo = 'Disposicion'");
			
		}
		
		
		
	}
	
	
	//ELEMENTOS
	if($tipoDeDocumento == "P"){
		
		$totalElementosP = $_REQUEST['totalElementosP'];
		
		for($contP = 0; $contP <= $totalElementosP; $contP++){
			
			if($_REQUEST['contenido'.$contP] != ''){
				
				$contenidoP = $_REQUEST['contenido'.$contP];
				$contenidoP = str_replace("'","&#39", $contenidoP);
				//echo"UPDATE INTRANET2.SGI_Manuales_Elementos SET xt_contenido = '$contenidoP' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contP<br><br>";
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoP' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contP");
				
			}
		
		}
	}
	
	if($tipoDeDocumento == "L" || $tipoDeDocumento == "I" || $tipoDeDocumento == "DE"){
		
		
		$totalElementosLIDE = $_REQUEST['totalElementosLIDE'];
		
		for($contLIDE = 0; $contLIDE <= $totalElementosLIDE; $contLIDE++){
			
			if($_REQUEST['contenido'.$contLIDE] != ''){
				
				$contenidoLIDE = $_REQUEST['contenido'.$contLIDE];
				$contenidoLIDE = str_replace("'","&#39", $contenidoLIDE);
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoLIDE' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contLIDE");
				
			}
		
		
		}
		
	}
	
	
	if($tipoDeDocumento == "C"){
		
		$totalElementosC = $_REQUEST['totalElementosC'];
		
		for($contC = 0; $contC <= $totalElementosC; $contC++){
			
			$outline  = $_REQUEST['outline'.$contC];
			$codDocModificaSec = $codDocModifica."-".$contC;
			
			//titulo
			if($_REQUEST['titulo'.$contC] != ''){
				
				$tituloC = $_REQUEST['titulo'.$contC];
				$query = "UPDATE SGI_Manuales_Elementos SET xt_titulo = '$tituloC' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_outline = '$outline'";
				 

				 $INTRANETV2->Execute($query);
				
			}
			
			//contenido
			if($_REQUEST['contenido'.$contC] != ''){
			  


				$contenidoC = $_REQUEST['contenido'.$contC];
                  $contenidoC = str_replace("'","&#39", $contenidoC);
                  $outline  = $_REQUEST['outline'.$contC];
				 
			 
			 $query = "UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoC' WHERE xt_codigoDocumento = '$codDocModifica' AND xt_outline = '$outline'";
				
			//echo "$query <br>";
			$INTRANETV2->Execute($query);
				
			}
			

			if($_REQUEST['ISO2008'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$iso2008C = $_REQUEST['ISO2008'.$contC];
				
				$isoNuevos = explode(',', $iso2008C);
				
				echo "SALUDOS....";
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'ISO 37001:2017'"); 
				
				
				for($i = 0; $i < count($isoNuevos); $i++){
					
					$contIso = trim($isoNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('ISO 37001:2017', '$contIso', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}

			if($_REQUEST['ISO2015'.$contC] != ''){
				$outline = $_REQUEST['outline'.$contC];
				$iso2015C = $_REQUEST['ISO2015'.$contC];
				
				$isoNuevos = explode(',', $iso2015C);
				
				//elimino
				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'ISO 9001:2015'"); 
				
				
				
				for($i = 0; $i < count($isoNuevos); $i++){
					
					$contIso = trim($isoNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('ISO 9001:2015', '$contIso', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}
			
			
			/*if($_REQUEST['ISO9001:2015'.$contC] != ''){
				$outline = $_REQUEST['outline'.$contC];
				$iso2015C = $_REQUEST['ISO9001:2015'.$contC];
				
				$isoNuevos = explode(',', $iso2015C);
				
				//elimino
				$e = $INTRANETV2->Execute("DELETE 
				FROM INTRANET2.SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'ISO9001:2015'"); 
				
				
				
				for($i = 0; $i < count($isoNuevos); $i++){
					
					$contIso = trim($isoNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('ISO9001:2015', '$contIso', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}*/
			
			
			if($_REQUEST['QCB'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$nmxC = $_REQUEST['QCB'.$contC];
				
				$nmxNuevos = explode(',', $nmxC);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'QCB'"); 
				
				
				for($i = 0; $i < count($nmxNuevos); $i++){
					
					$contNmx = trim($nmxNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('QCB', '$contNmx', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
				
			}
			
			if($_REQUEST['QCB2016'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$nmxC = $_REQUEST['QCB2016'.$contC];
				
				$nmxNuevos = explode(',', $nmxC);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'QCB 2016'"); 
		
				
				for($i = 0; $i < count($nmxNuevos); $i++){
					
					$contNmx = trim($nmxNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('QCB 2016', '$contNmx', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
				
			}
			
			if($_REQUEST['NEEC'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$neecC = $_REQUEST['NEEC'.$contC];
				
				$neecNuevos = explode(',', $neecC);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'OEA'"); 
				
				
				
				for($i = 0; $i < count($neecNuevos); $i++){
					
					$contNeec = trim($neecNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('OEA', '$contNeec', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}
			
			if($_REQUEST['SCC'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$neecC = $_REQUEST['SCC'.$contC];
				
				$neecNuevos = explode(',', $neecC);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'SCC'"); 
				
				
				
				for($i = 0; $i < count($neecNuevos); $i++){
					
					$contNeec = trim($neecNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) 
					VALUES ('SCC', '$contNeec', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}
			
			//Referencias con otros documentos
			
			if($_REQUEST['refDocu'.$contC] != ''){
				
				$refDocu = $_REQUEST['refDocu'.$contC];
				$refDocNuevos = explode(',', $refDocu);
				$outline = $_REQUEST['outline'.$contC];
				
				//elimino
				$s = $INTRANETV2->Execute("DELETE FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocModifica' AND xt_outline = '$outline'");
				
							
				for($i = 0; $i < count($refDocNuevos); $i++){
					
					$contRefDoc = trim($refDocNuevos[$i]);
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('$contRefDoc', '$codDocModifica', '$outline')");
					
					
					
				}
				unset($i);
			}
			
			
		}
		
	}
	
	
 header("Location: controlCambiosv3.php?codDoc=$codDocModifica");
}
?>
</body>

</html>