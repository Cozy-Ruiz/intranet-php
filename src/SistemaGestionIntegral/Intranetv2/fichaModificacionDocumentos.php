<?php
/*
 *@author Guadarrama Fortoul Lizbeth
 *@version 2.0
 *@copyright Copyright (c) 2017, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'FichaItemModificacionSGI.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

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
	$s = $INTRANETV2->Execute("SELECT xt_nombre, xt_tipoDocumento FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
	
	while($r = $s->fetchRow()){
		
		$nombre 		= $r[0];
		$tipo 			= $r[1];
		
	} unset($r);
	
	
	//obtengo certificaciones 
	/*if($tipoDeDocumento != "C"){
		
		
	}
	
	//obtengo codigo de certificaciones
	$t = $INTRANETV2->Execute("SELECT xt_codigoNorma FROM SGI_Catalogo_Normas");
	$indiceCer = 0;
	while($r = $t->fechRow()){
		$tipoCertificaciones[$indiceCer]= $r[0];
		$indiceCer++;
		
	}unset($t); unset($r);
	
	
	for($listCer = 0; $listCer < count($tipoCertificaciones); $listCer++){
		
		//obtengo listado de certificaciones
		$indice = 0;
		$indiceNorma = 0;
		$tipoNorma = $tipoCertificaciones[$listCer];
		$arrayNorma.$indiceNorma = array();
	
		$s = $INTRANET->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento' AND xt_codigoDocumento_norma = '$tipoNorma' ORDER BY xt_indiceDocumentoNorma ASC");
	
		while($r = $s->fetchRow()){
			$arrayNorma.$indiceNorma [$indice] = trim($r[0]);
			$indice++;
		} unset($r);
		
		$indiceNorma++;
		
	}
	
	
	
	$indice = 1;
	$iso = NULL;
	
	$s = $INTRANET->Execute("
	SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'ISO' ORDER BY kf_codigoID ");
	
	while($r = $s->fetchRow()){
		$iso[$indice] = trim($r[0]);
		$indice++;
	} unset($r);
	
	$indice = 1;
	$nmx = NULL;
	
	$s = $INTRANET->Execute("
	SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NMX' ORDER BY kf_codigoID ");
	
	while($r = $s->fetchRow()){
		$nmx[$indice] = trim($r[0]);
		$indice++;
	} unset($r);
	
	$indice = 1;
	$neec = NULL;
	
	$s = $INTRANET->Execute("
	SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NEEC' ORDER BY kf_codigoID ");
	
	while($r = $s->fetchRow()){
		$neec[$indice] = trim($r[0]);
		$indice++;
	} unset($r); unset($indice);
	
	$indice = 1;
	$docRef = NULL;
	
	$s = $INTRANET->Execute("
	SELECT ITM.xt_codigo FROM SGI_Item ITM, SGI_Item_Referencia RFE
	WHERE ITM.kp_itemID = RFE.xt_docCodigo AND RFE.kf_itemID = $itemID ORDER BY RFE.xt_docCodigo ");
	
	while($r = $s->fetchRow()){
		$docRef[$indice] = $r[0];
		$indice++;
	} unset($r); unset($indice);
	
	if($area == 'MC'){
		$manual = "Manual de Calidad";
	} else if($area == 'CDR'){
		$manual = "Manual de Control de Documentos y Registros";
	} else if($area == 'AI'){
		$manual = "Manual de Auditorías Internas";
	} else if($area == 'CC'){
		$manual = "Manual del Comité de Calidad";
	} else if($area == 'DG'){
		$manual = "Manual de Dirección General";
	} else if($area == 'ADM'){
		$manual = "Manual de Administración";
	} else if($area == 'RH'){
		$manual = "Manual de Recursos Humanos";
	} else if($area == 'TI'){
		$manual = "Manual de Tecnologías de la Información";
	} else if($area == 'OPE'){
		$manual = "Manual de Operaciones";
	}
	
	if($tipo == "C"){
		$tipoDocumento = "Capítulo";
	} else if($tipo == "L"){
		$tipoDocumento = "Lineamiento";
	} else if($tipo == "P"){
		$tipoDocumento = "Procedimiento";
	} else if($tipo == "I"){
		$tipoDocumento = "Instructivo";
	} else if($tipo == "F"){
		$tipoDocumento = "Formato";
	} else if($tipo == "DE"){
		$tipoDocumento = "Formato";
	} else if($tipo == "K"){
		$tipoDocumento = "Proceso";
	}
	
	if(strlen($consecutivo) == 1){
		$imprimeConsecutivo = "0".$consecutivo;
	}else{
		$imprimeConsecutivo = $consecutivo;
	}*/
	
	/*$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
				<a href='manuales.php' id='breadcrumbs'> Manuales / </a> <a href='Documento.php?manual=$grupo-$area' id='breadcrumbs'> $manual </a>";
		*/
		
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
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            </head>
        <body>
    <?php
	
	echo"<div id='wrapper' align='center'>";
		echo "<form action='fichaModificacionDocumentos.php' method='POST'>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
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
					
							if($nombreNorma == "QCB"){

								$nombreNorma = "NMX";
							}

							if($nombreNorma == "OEA"){

								$nombreNorma = "NEEC";
							}

							echo "<td align='right' id='iconosTexto' width='70px'>$nombreNorma:</td>";



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
								$t = $INTRANETV2->Execute("SELECT xt_codigoReferencia FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocumento'");
				
								$docRefValor = "";
								$banderaComa = 0;
				
								while($v = $t->fetchRow()){
									
									if($banderaComa == 0){
										
										$docRefValor .= trim($v[0]);
										
									}else{
										
										$docRefValor .= ", ".trim($v[0]);
									}
									
									$banderaComa++;
									
								}
				
								echo "<input type='text' value='$docRefValor' name='docRefModificado' size='70'>";

						echo "</td>";
					echo "</tr>";
				echo "</table>";
			}
			
			if(($tipoDeDocumento == "P") || ($tipoDeDocumento == "L") || ($tipoDeDocumento == "I") || ($tipoDeDocumento == "DE")){
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
					$tituloElemento[$i] = $r[1];
					$contenidoElemento[$i] = $r[2];
					$tipoElemento[$i] = $r[3];
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
									 
										<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='950px' height='700px'>
												  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
												  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
												  </p>
											  </object><a href='CambiarArchivoPopUp.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
									} else{
										echo "<textarea name='contenido$a' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
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
											  </object><a href='CambiarArchivoPopUp.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../../Imagenes/ICN_BotonModificar.png'></a><br><br>";
									} else{
										echo "<textarea name='contenido$a' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
									}
								echo "</td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						echo "</table>";
					}
				}
			}
			
			if($tipoDeDocumento == "L" || $tipoDeDocumento == "I" || $tipoDeDocumento == "DE"){
				
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
										  </object><a href='CambiarArchivoPopUp.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
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
					$refNmx[$i] = "";
					$refNeec[$i] = "";
					$refDoc[$i] = "";
		
					
					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 2008'");
					
					while($t = $u->fetchRow()){
						
						$refIso2008[$i] = $refIso2008[$i].trim($t[0]).", ";
						
					} unset($t); unset($u);
					
					

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 2015'");
					while($t = $u->fetchRow()){
						
						$refIso2015[$i] = $refIso2015[$i].trim($t[0]).", ";
						
					} unset($t); unset($u);
					

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'QCB'");
					while($t = $u->fetchRow()){
						
						$refNmx[$i] = $refNmx[$i].trim($t[0]).", ";
					} unset($t); unset($u);

					$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'OEA'");

					while($t = $u->fetchRow()){
						
						$refNeec[$i] = $refNeec[$i].trim($t[0]).", ";
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
					if($refNmx[$i] != ""){
						$refNmx[$i] = substr($refNmx[$i], 0, -2);
					}
					if($refNeec[$i] != ""){
						$refNeec[$i] = substr($refNeec[$i], 0, -2);
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
							  </object><a href='CambiarArchivoPopUp.php?codDoc=$codDocumento&nOrden=$numOrden'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
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
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>ISO 2008:</td>";
								echo "<td align='left'><input type='text' name='refIso2008".$numOrden."' value='$refIso2008[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
								echo "<td align='right' id='fileItem'>ISO 2015:</td>";
								echo "<td align='left'><input type='text' name='refIso2015".$numOrden."' value='$refIso2015[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>NMX:</td>";
								echo "<td align='left'><input type='text' name='refNmx".$numOrden."' value='$refNmx[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>NEEC:</td>";
								echo "<td align='left'><input type='text' name='refNeec".$numOrden."' value='$refNeec[$a]' size='65'></td>";
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
									echo " <a href='CambiarArchivoPopUp.php?codDoc=$codDocumento&nOrden=$numOrden' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
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
						echo "Creado: $fechaCreacion, Salvador de la Peña";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='40px'> </tr>";
				
			echo "</table>"; 
		echo "</form>";
	echo"</div>";
	
	
//SI SE HIZO ALGUNA MODIFICACIÓN
	
} else if(($modifica == 1) && ($_POST['nombreModificado'] != "")){
	
	$tipoDeDocumento = $_REQUEST['tipoDoc'];
	
	$codDocModifica = $_POST['codDocId'];
	$nombreDocNuevo = $_POST['nombreModificado'];
	//$consecutivo = $_POST['consecutivo'];
	
	$grupoActual 	= "";
	$areaActual 	= "";
	$tipoActual 	= "";
	$nombreDocActual 	= "";
	
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
		
		if($normaModificar == "NMX"){

			$normaModificar = "QCB";
		}

		if($normaModificar == "NEEC"){

			$normaModificar = "OEA";
		}
		
		
		
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

		if($_REQUEST['docRefModificado'] != ""){

			$codDocModifica = trim($codDocModifica);
			$referenciasNuevas = trim($_REQUEST['docRefModificado']);



			if($s = $INTRANETV2->getOne("SELECT xt_codigoReferencia FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocModifica'")){

			$s = $INTRANETV2->Execute("DELETE FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocModifica'");
			}


			 $referenciasNuevas = explode(',', $referenciasNuevas);

			for($i = 0; $i < count($referenciasNuevas); $i++){

				$dato = trim($referenciasNuevas[$i]);

				$s = $INTRANETV2->Execute("INSERT INTO SGI_Manuales_Documentos_Referencias (xt_codigoDocumento, xt_codigoReferencia) VALUES ('$codDocModifica', '$dato')");
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
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoP' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contP");
				
			}
		
		}
	}
	
	if($tipoDeDocumento == "L" || $tipoDeDocumento == "I" || $tipoDeDocumento == "DE"){
		
		
		$totalElementosLIDE = $_REQUEST['totalElementosLIDE'];
		
		for($contLIDE = 0; $contLIDE <= $totalElementosLIDE; $contLIDE++){
			
			if($_REQUEST['contenido'.$contLIDE] != ''){
				
				$contenidoLIDE = $_REQUEST['contenido'.$contLIDE];
				
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoLIDE' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contLIDE");
				
			}
		
		
		}
		
	}
	
	
	if($tipoDeDocumento == "C"){
		
		$totalElementosC = $_REQUEST['totalElementosC'];
		
		for($contC = 0; $contC <= $totalElementosC; $contC++){
			
			$codDocModificaSec = $codDocModifica."-".$contC;
			
			//titulo
			if($_REQUEST['titulo'.$contC] != ''){
				
				$tituloC = $_REQUEST['titulo'.$contC];
				
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_titulo = '$tituloC' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contC");
				
			}
			
			//contenido
			if($_REQUEST['contenido'.$contC] != ''){
				
				$contenidoC = $_REQUEST['contenido'.$contC];
				
				$INTRANETV2->Execute("UPDATE SGI_Manuales_Elementos SET xt_contenido = '$contenidoC' WHERE xt_codigoDocumento = '$codDocModifica' AND xn_orden = $contC");
				
			}
			
			//referencias certificaciones
			if($_REQUEST['refIso2008'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$iso2008C = $_REQUEST['refIso2008'.$contC];
				
				$isoNuevos = explode(',', $iso2008C);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'ISO 2008'"); 
				
				
				
				for($i = 0; $i < count($isoNuevos); $i++){
					
					$contIso = trim($isoNuevos[$i]);
					
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('ISO 2008', '$contIso', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}
			
			
			if($_REQUEST['refIso2015'.$contC] != ''){
				$outline = $_REQUEST['outline'.$contC];
				$iso2015C = $_REQUEST['refIso2015'.$contC];
				
				$isoNuevos = explode(',', $iso2015C);
				
				//elimino

				$e = $INTRANETV2->Execute("DELETE 
				FROM SGI_Normas_Incisos_Documentos 
				WHERE 
				xt_codigoDocumento = '$codDocModifica' 
				AND xt_indiceDocumento = '$outline' 
				AND xt_codigoDocumentoNorma = 'ISO 2015'"); 
				
				
				
				for($i = 0; $i < count($isoNuevos); $i++){
					
					$contIso = trim($isoNuevos[$i]);
					
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('ISO 2015', '$contIso', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
			}
			
			
			if($_REQUEST['refNmx'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$nmxC = $_REQUEST['refNmx'.$contC];
				
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
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('QCB', '$contNmx', '$codDocModifica', '$outline')");
					
				}
				
				unset($i);
				
				
			}
			
			if($_REQUEST['refNeec'.$contC] != ''){
				
				$outline = $_REQUEST['outline'.$contC];
				$neecC = $_REQUEST['refNeec'.$contC];
				
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
					
					$s = $INTRANETV2->Execute("INSERT INTO SGI_Normas_Incisos_Documentos (xt_codigoDocumentoNorma, xt_indiceDocumentoNorma, xt_codigoDocumento, xt_indiceDocumento) VALUES ('OEA', '$contNeec', '$codDocModifica', '$outline')");
					
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
	
	header("Location: controlCambiosv2.php?codDoc=$codDocModifica");
	
}
?>
</body>

</html>