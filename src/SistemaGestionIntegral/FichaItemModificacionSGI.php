<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.1
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'FichaItemModificacionSGI.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

if($_GET['id'] != ""){
	
	$idItem = $_GET['id'];
	
} else if($_POST['id'] != ""){
	
	$idItem = $_POST['id'];
	
}


$modifica = 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if($modifica == 0){
	
	
	
	$s = $INTRANET->Execute("
	SELECT kp_itemID, xt_nombre, xd_fechaCreacion, xt_codigo, xt_ciudad, xt_grupo, xt_area, xt_tipo, xn_consecutivo FROM SGI_Item WHERE kp_itemID = $idItem ");
	
	while($r = $s->fetchRow()){
		$itemID 		= $r[0];
		$nombre 		= $r[1];
		$fechaCreacion 	= $r[2];
		$codigo 		= $r[3];
		$ciudad 		= $r[4];
		
		$grupo 			= $r[5];
		$area 			= $r[6];
		$tipo 			= $r[7];
		$consecutivo 	= $r[8];
		
	} unset($r);
	
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
	}
	
	/*$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
				<a href='manuales.php' id='breadcrumbs'> Manuales / </a> <a href='Documento.php?manual=$grupo-$area' id='breadcrumbs'> $manual </a>";
		*/
		
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Ficha Item Modificación</title>
                 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            </head>
        <body>
    <?php
	
	echo"<div id='wrapper' align='center'>";
		echo "<form action='FichaItemModificacionSGI.php?id=$idItem' method='POST'>";
		
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
						
						echo "<input type='hidden' value='1' name='modifica'><input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='$consecutivo' name='consecutivo'>";
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
			
			echo "<table border='0' align='center'>";
				///ISO
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='right' id='iconosTexto' width='70px'>ISO:</td>";
					
						$isoValor = "";
						if($iso != NULL){
							for($i = 1; $i <= count($iso); $i++){
								if($i == count($iso)){
									$isoValor = $isoValor.$iso[$i];
								} else{
									$isoValor = $isoValor.$iso[$i].", ";
								}
							}
						}
					echo "<td width='600px'><input type='text' value='$isoValor' name='isoModificado' size='50'></td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				///NMX
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='right' id='iconosTexto' width='70px'>NMX:</td>";
					
						$nmxValor = "";
						if($nmx != NULL){
							for($i = 1; $i <= count($nmx); $i++){
								if($i == count($nmx)){
									$nmxValor = $nmxValor.$nmx[$i];
								} else{
									$nmxValor = $nmxValor.$nmx[$i].", ";
								}
							}
						}
					echo "<td width='600px'><input type='text' value='$nmxValor' name='nmxModificado' size='50'></td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				///NEEC
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='right' id='iconosTexto' width='70px'>NEEC:</td>";
					
						$neecValor = "";
						if($neec != NULL){
							for($i = 1; $i <= count($neec); $i++){
								if($i == count($neec)){
									$neecValor = $neecValor.$neec[$i];
								} else{
									$neecValor = $neecValor.$neec[$i].", ";
								}
							}
						}
						echo "<td width='600px'><input type='text' value='$neecValor' name='neecModificado' size='50'></td>";
				echo "</tr>";
			echo "</table>";
			
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
							$docRefValor = "";
							if($docRef != NULL){
								for($i = 1; $i <= count($docRef); $i++){
									if($i == count($docRef)){
										$docRefValor = $docRefValor.$docRef[$i];
									} else{
										$docRefValor = $docRefValor.$docRef[$i].", ";
									}
								}
							}
							echo "<input type='text' value='$docRefValor' name='docRefModificado' size='70'>";
							
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			if(($tipo == "P") || ($tipo == "L") || ($tipo == "I") || ($tipo == "DE")){
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
				
				$i = 1;
				$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					$numeroElemento[$i] = $r[0];
					$tipoElemento[$i] = $r[1];
					$contenidoElemento[$i] = $r[2];
					$i++;
				}
			}
			
			$bandera = 0;
			
			if($tipo == "P"){
				for($a = 1; $a <= count($numeroElemento); $a++){
					if($tipoElemento[$a] == "DESARROLLOT" || $tipoElemento[$a] == "DESARROLLOA"){
						$bandera++;
					}
					
					if($bandera == 0){
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td> </td>";
								echo "<td align='left' id='iconosTexto' colspan='2'>";
										echo $numeroElemento[$a].". $tipoElemento[$a]";
								echo "</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td align='left' width='30px'> </td>";
								echo "<td width='640' id='fileItem'>";
										echo "<textarea name='contenido$a' style='width: 638px; height: 50px;'>$contenidoElemento[$a]</textarea>";
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
										echo "
											<br><br>

											<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='639px' height='300px'>
												<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.</p>
											</object>

											<a href='CambiarArchivoPopUp.php?itemID=$itemID&nElemento=$a'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											<img src='../Imagenes/ICN_BotonModificar.png'></a><br><br>";
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
											<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='639px' height='300px'>
												<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.</p>
											</object>

											<a href='CambiarArchivoPopUp.php?itemID=$itemID&nElemento=$a'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											<img src='../Imagenes/ICN_BotonModificar.png'></a><br><br>";
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
			
			if($tipo == "L" || $tipo == "I" || $tipo == "DE"){
				for($a = 1; $a <= count($numeroElemento); $a++){
					
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td width='670' id='fileItem'>";
								if(substr($contenidoElemento[$a], -4) == ".pdf"){
									echo "<br><br>
											<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='639px' height='300px'>
												<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.</p>
											</object>
											<a href='CambiarArchivoPopUp.php?itemID=$itemID&nElemento=$a'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
										  <img src='../Imagenes/ICN_BotonModificar.png'></a><br><br>";
								} else{
									echo "<textarea name='contenido$a' style='width: 669px; height: 50px;'>$contenidoElemento[$a]</textarea>";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr height='10px'> </tr>";
					echo "</table>";
				}
			}
			
			
			if($tipo == "C"){
				$i = 1;
				
				$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido, xt_titulo, xt_outLine, kp_capituloElementoID FROM SGI_CapituloElemento 
								WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		
				while($r = $s->fetchRow()){
					$numeroElemento[$i] = $r[0];
					$tipoElemento[$i] = $r[1];
					$contenidoElemento[$i] = $r[2];
					$titulo[$i] = trim($r[3]);
					
					$outLine[$i] = $r[4];
					$subnivel = (explode('.', trim($outLine[$i])));
					$nivel[$i] = count($subnivel);
					
					$elementoCapID[$i] = $r[5];
					
					$refIso[$i] = "";
					$refNmx[$i] = "";
					$refNeec[$i] = "";
					$refDoc[$i] = "";
					
					$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'ISO' ");
					while($t = $u->fetchRow()){
						$refIso[$i] = $refIso[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
					$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'NMX' ");
					while($t = $u->fetchRow()){
						$refNmx[$i] = $refNmx[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
					$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'NEEC' ");
					while($t = $u->fetchRow()){
						$refNeec[$i] = $refNeec[$i].trim($t[0]).", ";
					} unset($t); unset($u);
					
					$u = $INTRANET->Execute("SELECT SIT.xt_codigo FROM SGI_CapituloElemento_Referencia CER, SGI_Item SIT 
											 WHERE CER.kf_capituloElementoID = $elementoCapID[$i] AND CER.xt_docCodigo = SIT.kp_itemID ");
					while($t = $u->fetchRow()){
						$clave = trim($t[0]);
						$refDoc[$i] = $refDoc[$i]."$clave, ";
						
					} unset($t); unset($u);
					
					if($refIso[$i] != ""){
						$refIso[$i] = substr($refIso[$i], 0, -2);
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
				
				for($a = 1; $a <= count($numeroElemento); $a++){
					
					if(substr($contenidoElemento[$a], -4) == ".pdf"){
						echo "<br><br>
							<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf' width='639px' height='300px'>
								<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.</p>
							</object>
							<a href='CambiarArchivoCapPopUp.php?itemID=$itemID&nElemento=$a'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
							<img src='../Imagenes/ICN_BotonModificar.png'></a><br><br>";
								
					} else{
						          
						echo "<table border='0' align='center'>";
							
							echo "<tr>";
								echo "<td><input type='text' name='outline".$a."' value='$outLine[$a]' size='7'></td>";
								echo "<td align='left'><input type='text' name='titulo".$a."' value='$titulo[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>ISO:</td>";
								echo "<td align='left'><input type='text' name='refIso".$a."' value='$refIso[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>NMX:</td>";
								echo "<td align='left'><input type='text' name='refNmx".$a."' value='$refNmx[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>NEEC:</td>";
								echo "<td align='left'><input type='text' name='refNeec".$a."' value='$refNeec[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
						
							echo "<tr>";
								echo "<td align='right' id='fileItem'>Referencias:</td>";
								echo "<td align='left'><input type='text' name='refDocu".$a."' value='$refDoc[$a]' size='65'></td>";
							echo "</tr>";
							echo "<tr height='10px'> </tr>";
							
							echo "<tr>";
								echo "<td width='80px'> </td>";
								echo "<td width='600' id='fileItem'><textarea name='contenido$a' style='width: 600px; height: 50px;'>$contenidoElemento[$a]</textarea></td>";
							echo "</tr>";
							
						echo "</table>";	
					}
						
					echo "<table>";		
						echo "<tr height='10px'> </tr>";
					echo "</table>";
				}
			}
			
			
			if($tipo == "F"){
				
				$i = 1;
				$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					$numeroElemento[$i] = $r[0];
					$tipoElemento[$i] = $r[1];
					
					if(($tipoElemento[$i] == 'DESARROLLOT') || ($tipoElemento[$i] == 'DESARROLLOA')){
						$tipoElemento[$i] = "DESARROLLO";
					}
					
					$contenidoElemento[$i] = $r[2];
					$i++;
				} unset($r); unset($s);
				
				
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
				
				for($a = 1; $a <= count($numeroElemento); $a++){
					if(substr($contenidoElemento[$a], 0, 9) == "../FILES/"){
						echo "<table>";	
							echo "<tr>";
								echo "<td width='30px'> </td>";
								echo "<td width='670' id='fileItem'  align='justify'>";
									echo "<img src='../Imagenes/ICN_Archivo.png'> ".substr($contenidoElemento[$a], 9, strlen($contenidoElemento[$a]));
									echo " <a href='CambiarArchivoPopUp.php?itemID=$itemID&nElemento=$a' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
											  <img src='../Imagenes/ICN_BotonModificar.png'></a>";
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
				
				if(!$INTRANET->getOne("SELECT kp_registroID FROM SGI_Registro_Contenido WHERE kf_itemID = $itemID ")){
					
				} else{
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
					
					
					$s = $INTRANET->Execute("SELECT xt_origen, xt_tipo, xt_responsable, xt_almacenamiento, xt_proteccion, xt_recuperacion, xt_retencion, xt_disposicion 
											FROM SGI_Registro_Contenido where kf_itemID = $itemID ");
					
					while($r = $s->fetchRow()){
						$origen = $r[0];
						$tipo = $r[1];
						$responsable = $r[2];
						$almacenamiento = $r[3];
						$proteccion = $r[4];
						$recuperacion = $r[5];
						$retencion = $r[6];
						$disposicion = $r[7];
						
					} unset($r); unset($s);
					
					echo "<table border='0' align='center'>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Origen:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='origenI' size='40' value='$origen'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Tipo:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='tipoI' size='40' value='$tipo'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Responsable:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='responsableI' size='40' value='$responsable'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Almacenamiento:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='almacenamientoI' size='40' value='$almacenamiento'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Protección:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='proteccionI' size='40' value='$proteccion'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Recuperación:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='recuperacionI' size='40' value='$recuperacion'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Retención:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='retencionI' size='40' value='$retencion'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='10px'> </tr>";
						
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' id='iconosTexto' width='100px'>Disposición:</td>";
							echo "<td align='left' width='570px'>";
								echo"<input type='text' name='disposicionI' size='40' value='$disposicion'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				}
				
			}
			
			////Proceso
			if($tipo == "K"){
			///NUMERO MAPA = 0, NUMERO ELEMENTO = 1, DESCRIPCION
				$descripcion = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 0 AND xn_numeroElemento = 1 ORDER BY xn_numeroElemento ");
				
				echo "<table border='0' align='center'>";
					echo"<tr height='40px'> </tr>";
					///Descripción
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='685px'><b>Descripción</b></td>";
						echo "<td align='right' width='15px'> </td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
					//Contenido descripción
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'><textarea name='descripcion' style='width: 660px; height: 100px;'>$descripcion</textarea></td>";
					echo "</tr>";
					echo "<tr height='20px'> </tr>";
				echo "</table>";
				
			///NUMERO MAPA = 0, NUMERO ELEMENTO = 3, RESPONSABLE
				
				$idResponsable = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 0 AND xn_numeroElemento = 3 ORDER BY xn_numeroElemento ");
			
				if($idResponsable != ""){
					
					$nombreResponsable 		= $INTRANET->getOne("SELECT xt_Nombre FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					$apellidoPResponsable 	= $INTRANET->getOne("SELECT xt_ApellidoPaterno FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					$apellidoMResponsable 	= $INTRANET->getOne("SELECT xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					
					echo "<table border='0' align='center'>";
						///Responsable
						echo "<tr id='titulo2'>";
							echo "<td align='left' width='685px'><b>Responsable</b></td>";
							echo "<td align='right' width='15px'> </td>";
						echo "</tr>";
						///Linea
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						echo"<tr height='30px'> </tr>";
					echo "</table>";
					
					echo "<table border='0' align='center'>";
						//Contenido descripción
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td width='670' id='fileItem' align='left'>";
							
								echo "<select name='responsableProceso'>";
									echo "<option value='$idResponsable' selected='selected'>$nombreResponsable $apellidoPResponsable $apellidoMResponsable</option>";
									
									$s = $INTRANET->Execute("
									SELECT kp_personalId, xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados 
									WHERE xt_tipo = 'E' AND kp_personalId <> 168 ORDER BY xt_Nombre, xt_ApellidoPaterno ");
									
									while($r = $s->fetchRow()){
										if($idResponsable != $r[0]){
											echo "<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
										}
									} unset($r); unset($s);
									
								echo "</select>";
					
					
							echo "</td>";
						echo "</tr>";
						echo "<tr height='20px'> </tr>";
					echo "</table>";
				}
						
					
				unset($s); unset($r);
				
			///NUMERO MAPA = 0, NUMERO ELEMENTO = 2, DIAGRAMA DE FLUJO
				$diagrama = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 0 AND xn_numeroElemento = 2 ORDER BY xn_numeroElemento ");
				
				if($diagrama != ""){
					
					echo "<table border='0' align='center'>";
					
						echo"<tr height='30px'> </tr>";
						///Descripción
						echo "<tr id='titulo2'>";
							echo "<td align='left' width='685px'><b>Diagrama de Flujo</b></td>";
							echo "<td align='right' width='15px'> </td>";
						echo "</tr>";
						///Linea
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='2'></td>";
						echo "</tr>";
						echo"<tr height='30px'> </tr>";
					echo "</table>";
					
					echo "<table border='0' align='center'>";
						//Contenido descripción
						echo "<tr>";
							echo "<td width='700px' id='fileItem'>";
								echo "<br><br>
									  	<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($diagrama))."'\" type='application/pdf' width='639px' height='300px'>
											<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.</p>
										</object>
										<a href='CambiarDiagramaFlujoPopUp.php?itemID=$itemID'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\">
										<br><img src='../Imagenes/ICN_BotonModificar.png'></a>
										<br><br>";
							echo "</td>";
						echo "</tr>";
						echo "<tr height='20px'> </tr>";
					echo "</table>";
					
				}
				unset($s); unset($r);
				
			///NUMERO MAPA = 1, PROCESOS ANTECESORES
				
				$procesosAntecesores 	= NULL;
				$tituloPAntecesores		= NULL;
				$descripcionAncesores	= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
					
						$procesosAntecesores[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloPAntecesores[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionAncesores[$indice]	= $r[2];
						
					} else{
						
						$procesosAntecesores[$indice]	= "";
						$tituloPAntecesores[$indice]	= $r[1];
						$descripcionAncesores[$indice]	= $r[2];
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Procesos antecesores
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>1.- Procesos antecesores</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($procesosAntecesores != NULL){
						
						for($i = 1; $i <= count($procesosAntecesores); $i++){
							
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($procesosAntecesores[$i] != ""){
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='procesoAntecesor".$i."' value='".$procesosAntecesores[$i]."' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'>$tituloPAntecesores[$i]</td>";
								} else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='procesoAntecesor".$i."' value='' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloPAntecesores".$i."' value='".$tituloPAntecesores[$i]."' size='70'></td>";
								}
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionAntecesores".$i."' style='width: 699px; height: 50px;'>".$descripcionAncesores[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
			///NUMERO MAPA = 2, PROCESOS DE APOYO
				
				$procesosApoyo 	= NULL;
				$tituloPApoyo	= NULL;
				$descripcionAp	= NULL;
				$indice 		= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 2 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
						
						$procesosApoyo[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloPApoyo[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionAp[$indice]	= $r[2];
						
					} else{
						$procesosApoyo[$indice]	= "";
						$tituloPApoyo[$indice] 	= $r[1];
						$descripcionAp[$indice]	= $r[2];
						
					}
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Procesos de apoyo
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>2.- Procesos de apoyo</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($procesosApoyo != NULL){
						for($i = 1; $i <= count($procesosApoyo); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($procesosApoyo[$i] != ""){
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='procesoApoyo".$i."' value='".$procesosApoyo[$i]."' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'>$tituloPApoyo[$i]</td>";
								} else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='procesoApoyo".$i."' value='' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloPApoyo".$i."' value='".$tituloPApoyo[$i]."' size='70'></td>";
								}
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionApoyo".$i."' style='width: 699px; height: 50px;'>".$descripcionAp[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
			///NUMERO MAPA = 3, PROCESOS SUCESORES
				
				$procesosSucesores	= NULL;
				$tituloPSucesores	= NULL;
				$descripcionSuces	= NULL;
				
				$indice 			= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 3 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
						
						$procesosSucesores[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloPSucesores[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionSuces[$indice]	= $r[2];
						
					} else{
						
						$procesosSucesores[$indice]	= "";
						$tituloPSucesores[$indice] 	= $r[1];
						$descripcionSuces[$indice]	= $r[2];
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Procesos sucesores
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>3.- Procesos sucesores</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($procesosSucesores  != NULL){
						for($i = 1; $i <= count($procesosSucesores); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($procesosSucesores[$i] != ""){
									echo "<td align='left' valign='top'>";
										echo "<input type='text' name='procesoSucesor".$i."' value='".$procesosSucesores[$i]."' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'>$tituloPSucesores[$i]</td>";
								} else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='procesoSucesor".$i."' value='' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloPSucesor".$i."' value='".$tituloPSucesores[$i]."' size='70'></td>";
								}
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionSucesor".$i."' style='width: 699px; height: 50px;'>".$descripcionSuces[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
			///NUMERO MAPA = 4, ENTRADAS
				
				$entradas 				= NULL;
				$tituloEntradas			= NULL;
				$descripcionEntrada 	= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 4 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
						
						$entradas[$indice]					= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloEntradas[$indice] 			= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionEntrada[$indice] 		= $r[1];
						
					} else{
						
						$entradas[$indice]					= "";
						$tituloEntradas[$indice] 			= $r[2];
						$descripcionEntrada[$indice] 		= $r[1];
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Entradas
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>4.- Entradas</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($entradas  != NULL){
						for($i = 1; $i <= count($entradas); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($entradas[$i] != ""){
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='entra".$i."' value='".$entradas[$i]."' size='30' >";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'>".$tituloEntradas[$i]."</td>";
								} else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='entra".$i."' value='' size='30' >";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloEntradas".$i."' value='".$tituloEntradas[$i]."'  size='70'></td>";
								}
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionEntrada".$i."' style='width: 699px; height: 100px;'>".$descripcionEntrada[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
			///NUMERO MAPA = 5, SALIDAS
				
				$salidas 				= NULL;
				$tituloSalida			= NULL;
				$descripcionSalida	 	= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 5 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
						
						$salidas[$indice]					= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloSalida[$indice] 				= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionSalida[$indice] 		= $r[1];
						
					} else{
						
						$salidas[$indice]					= "";
						$tituloSalida[$indice] 				= $r[2];
						$descripcionSalida[$indice] 		= $r[1];
					}
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Salida
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>5.- Salidas</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($salidas  != NULL){
						for($i = 1; $i <= count($salidas); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($salidas[$i] != ""){
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='salida".$i."' value='".$salidas[$i]."' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'>$tituloSalida[$i]</td>";
								} else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='salida".$i."' value='' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloSalida".$i."' value='$tituloSalida[$i]' size='70'></td>";
								}
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionSalida".$i."' style='width: 699px; height: 100px;'>".$descripcionSalida[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
			///NUMERO MAPA = 6, EQUIPO/INSUMOS
				
				$descripcionEquipos	 	= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 6 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					$descripcionEquipos[$indice] 		= $r[0];
					
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Equipos e Insumos
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>6.- Equipos/Insumos</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='20px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='680px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($descripcionEquipos  != NULL){
						
						for($i = 1; $i <= count($descripcionEquipos); $i++){
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='right' valign='top'>$i.</td>";
								echo "<td align='left'> </td>";
								echo "<td align='justify'><textarea name='descripcionEquipos".$i."' style='width: 670px; height: 50px;'>".$descripcionEquipos[$i]."</textarea></td>";
								echo "<td align='left'> </td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";	
			///NUMERO MAPA = 7, COMPLIANCE
				
				$compliance				= NULL;
				$tituloCompliance		= NULL;
				$descripcionCompliance	= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 7 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					if($r[0] != ""){
						$compliance[$indice]				= trim($r[0]);
						$tituloCompliance[$indice]			= $r[2];
						$descripcionCompliance[$indice] 	= $r[1];
						
					} else{
						$compliance[$indice]				= "";
						$tituloCompliance[$indice]			= $r[2];
						$descripcionCompliance[$indice] 	= $r[1];
						
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Competencia
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>7.- Compliance</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($compliance  != NULL){
						for($i = 1; $i <= count($compliance); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($compliance[$i] != ""){
									echo "<td align='left' valign='top' colspan='3'>";
										echo "$tituloCompliance[$i] <input type='hidden' name='tituloCompliance".$i."' value='$tituloCompliance[$i]'>";
										echo "<input type='text' name='$compliance".$i."' value='$compliance[$i]'>";
									echo "</td>";
									
								}else{
									echo "<td align='left' valign='top' colspan='3'>";
										echo "<input type='text' name='tituloCompliance".$i."' value='$tituloCompliance[$i]' size='107'>";
										echo "<input type='hidden' name='$compliance".$i."' value=''>";
									echo "</td>";
									
								}
								echo "<td align='left' width='20px'> </td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='3'><textarea name='descripcionCompliance".$i."' style='width: 703px; height: 100px;'>".$descripcionCompliance[$i]."</textarea></td>";
								echo "<td align='left' width='20px'> </td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				unset($link);
			///NUMERO MAPA = 8, DOCUMENTOS
				
				$documentosProceso		= NULL;
				$descripcionDocumento	= NULL;
				$tituloDocumento		= NULL;
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 8 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "ITEM")){
						
						$documentosProceso[$indice]			= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$tituloDocumento[$indice]			= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
						$descripcionDocumento[$indice] 		= $r[1];
						
					} else{
						
						$documentosProceso[$indice]			= "";
						$tituloDocumento[$indice]			= $r[2];
						$descripcionDocumento[$indice] 		= $r[1];
						
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Competencia
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>8.- Documentos</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($documentosProceso  != NULL){
						for($i = 1; $i <= count($documentosProceso); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								if($documentosProceso[$i] != ""){
									echo "<td align='left' valign='top'>";
										echo "<input type='text' name='documentoProceso".$i."' value='".$documentosProceso[$i]."'  size='30'>";
									echo "</td>";
									echo "<td align='left'></td>";
									echo "<td align='left' colspan='2'>".$tituloDocumento[$i]."</td>";	
									
								}else{
									echo "<td align='left' valign='top'>"; 
										echo "<input type='text' name='documentoProceso".$i."' value='' size='30'>";
									echo "</td>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='2'><input type='text' name='tituloDocumentoR".$i."' value='".$tituloDocumento[$i]."' size='70'></td>";
									
								}
								echo "<td align='left' width='20px'> </td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionDocumento".$i."' style='width: 700px; height: 100px;'>".$descripcionDocumento[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				unset($link);
			///NUMERO MAPA = 9, STAKEHOLDERS
				
				$stakeholder			= NULL;
				//$descripcionStakeholder	= NULL;
				$indice 				= 1;
				///por el momento solo se esta manejando puestos fijos
				$s = $INTRANET->Execute("SELECT xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 9 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					$stakeholder[$indice]				= $r[0];
					//$tituloStakeholder[$indice]			= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE xt_codigo = '$stakeholder[$indice]' ");
					
					//$descripcionStakeholder[$indice] 	= $r[1];
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Competencia
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>9.- Stakeholders (puestos y roles)</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='220px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='480px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($stakeholder  != NULL){
						for($i = 1; $i <= count($stakeholder); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								echo "<td align='left' valign='top'>"; 
									echo "<input type='text' name='stakeholder".$i."' value='".$stakeholder[$i]."' size='30' >";
								echo "</td>";
								echo "<td align='left'> </td>";
								echo "<td align='left' colspan='2'></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							/*
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='4'><textarea name='descripcionStakeholder".$i."' style='width: 700px; height: 100px;'>".$descripcionStakeholder[$i]."</textarea></td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							*/
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
			///NUMERO MAPA = 10, RIESGOS
				
				$riesgos			= NULL;
				$descripcionRiesgos	= NULL;
				$indice 			= 1;
				
				$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 10 ORDER BY xn_numeroElemento ");
				
				while($r = $s->fetchRow()){
					
					if(($r[0] != "") && ($r[3] == "RIESGO")){
						
						$riesgos[$indice]				= $INTRANET->getOne("SELECT xt_codigoRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $r[0] ");
						$descripcionRiesgos[$indice] 	= $r[1];
						$tituloRiesgo[$indice] 			= $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $r[0] ");
						
					} else{
						
						$riesgos[$indice]				= "";
						$descripcionRiesgos[$indice] 	= $r[1];
						$tituloRiesgo[$indice] 			= $r[2];
						
					}
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Competencia
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>10.- Riesgos</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='90px'> </td>";
						echo "<td align='left' width='5px'> </td>";
						echo "<td align='left' width='595px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($riesgos  != NULL){
						
						for($i = 1; $i <= count($riesgos); $i++){
							
							if($riesgos[$i] != ""){
								echo "<tr id='iconosTexto'>";
									echo "<td align='left'> </td>";
									echo "<td align='left'>";
										echo "<input type='text' name='riesgoCod".$i."' value='".$riesgos[$i]."' size='15' >";
									echo "</td>";
									echo "<td align='left' colspan='2'>";
										echo "$tituloRiesgo[$i]";
									echo "</td>";
									echo "<td align='left' width='20px'> </td>";
								echo "</tr>";
							} else{
								echo "<tr id='iconosTexto'>";
									echo "<td align='left'> </td>";
									echo "<td align='left' colspan='3'>";
										echo "<input type='text' name='tituloRiesgo".$i."' value='".$tituloRiesgo[$i]."' size='103'>";
									echo "</td>";
									echo "<td align='left' width='20px'> </td>";
								echo "</tr>";
							}
							echo"<tr height='5px'> </tr>";
							
							
							echo "<tr id='fileItem'>";
								echo "<td align='left'> </td>";
								echo "<td align='justify' colspan='3'><textarea name='descripcionRiesgos".$i."' style='width: 678px; height: 100px;'>".$descripcionRiesgos[$i]."</textarea></td>";
								echo "<td align='left' width='20px'> </td>";
							echo "</tr>";
							
							echo"<tr height='10px'> </tr>";
							
						}
						
					}
					
					echo"<tr height='30px'> </tr>";
				echo "</table>";
				
			///NUMERO MAPA = 11, INDICADORES
				
				$indicadores			= NULL;
				$nombreIndicadores		= NULL;
				$formulaIndicadores		= NULL;
				$valorIndicadores		= NULL;
				$periodicidad			= NULL;
				
				$indice 				= 1;
				
				$s = $INTRANET->Execute("SELECT xn_numero, xt_nombre, xt_formula, xt_valor, xt_periodicidad FROM SGI_Procesos_Indicadores WHERE kf_itemID = $itemID ORDER BY xn_numero ");
				
				while($r = $s->fetchRow()){
					$indicadores[$indice]				= $r[0];
					$nombreIndicadores[$indice] 		= $r[1];
					$formulaIndicadores[$indice] 		= $r[2];
					$valorIndicadores[$indice]			= $r[3];
					$periodicidad[$indice]				= $r[4];
					
					$indice++;
					
				} unset($r);
				
				echo "<table border='0' align='center'>";
					///Competencia
					echo "<tr id='titulo2'>";
						echo "<td align='left' colspan='4'><b>11.- Indicadores</b></td>";
						echo "<td align='right'> </td>";
					echo "</tr>";
					
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto' height='30px'>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td align='left' width='90px'> </td>";
						echo "<td align='left' width='510px'> </td>";
						echo "<td align='left' width='20px'> </td>";
					echo "</tr>";
					
					if($indicadores  != NULL){
						for($i = 1; $i <= count($indicadores); $i++){
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								echo "<td align='left' colspan='4'><input type='text' name='nombreIndicadores".$i."' value='".$nombreIndicadores[$i]."' size='100'></td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								echo "<td align='left'> </td>";
								echo "<td align='left' valign='top' id='fileItem'>Fórmula:</td>";
								echo "<td align='justify' valign='top' id='fileItem'><textarea name='formula".$i."' style='width: 529px; height: 100px;'>".$formulaIndicadores[$i]."</textarea></td>";
								echo "<td align='left'> </td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								echo "<td align='left'> </td>";
								echo "<td align='left' valign='top' id='fileItem'>Valor:</td>";
								echo "<td align='justify' valign='top' id='fileItem'><input type='text' name='valorIndicador".$i."' value='".$valorIndicadores[$i]."' size='80'></td>";
								echo "<td align='left'> </td>";
							echo "</tr>";
							
							echo"<tr height='5px'> </tr>";
							
							echo "<tr id='iconosTexto'>";
								echo "<td align='left'> </td>";
								echo "<td align='left'> </td>";
								echo "<td align='left' valign='top' id='fileItem'>Periodicidad:</td>";
								echo "<td align='justify' valign='top' id='fileItem'><input type='text' name='periodicidad".$i."' value='".$periodicidad[$i]."' size='80'></td>";
								echo "<td align='left'> </td>";
							echo "</tr>";
							
							echo"<tr height='20px'> </tr>";
						}
						
					}
					
					echo"<tr height='20px'> </tr>";
				echo "</table>";
				
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
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
	
} else if(($modifica == 1) && ($_POST['nombreModificado'] != "")){
	
	$itemIDNuevo = $_POST['itemID'];
	$tituloNuevo = $_POST['nombreModificado'];
	$consecutivo = $_POST['consecutivo'];
	
	$grupoActual 	= "";
	$areaActual 	= "";
	$tipoActual 	= "";
	$tituloActual 	= "";
	
	$s = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xt_nombre FROM SGI_Item WHERE kp_itemID = $itemIDNuevo ");
	
	while($r = $s->fetchRow()){
		
		$grupoActual 	= $r[0];
		$areaActual 	= $r[1];
		$tipoActual 	= $r[2];
		$tituloActual 	= $r[3];
		
	} unset($r);
	
	
	if($tituloNuevo != $tituloActual){
		
		$INTRANET->Execute("UPDATE SGI_Item SET xt_nombre = '$tituloNuevo' WHERE kp_itemID = $itemIDNuevo ");
		
	}
	
	$dato = "";
	
	if($s = $INTRANET->getOne("SELECT kf_itemID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'ISO' ")){
		
		$s = $INTRANET->Execute("DELETE FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'ISO' ");
	}
	
	if($_POST['isoModificado'] != ("" || NULL)){
		
		$isoNuevo = explode(',', $_POST['isoModificado']);
		
		for($i = 0; $i < count($isoNuevo); $i++){
			$dato = trim($isoNuevo[$i]);
			$s = $INTRANET->Execute("INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) VALUES ($itemIDNuevo, 'ISO', '$dato')");
		}
		
		unset($i);
	}
	
	$dato = "";
	
	if($s = $INTRANET->getOne("SELECT kf_itemID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'NMX' ")){
		
		$s = $INTRANET->Execute("DELETE FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'NMX' ");
	}
	
	if($_POST['nmxModificado'] != ("" || NULL)){
		
		$nmxNuevo = explode(',', $_POST['nmxModificado']);
		
		for($i = 0; $i < count($nmxNuevo); $i++){
			$dato = trim($nmxNuevo[$i]);
			$s = $INTRANET->Execute("INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) VALUES ($itemIDNuevo, 'NMX', '$dato')");
		}
		unset($i);
	}
	
	$dato = "";
	
	
	if($s = $INTRANET->getOne("SELECT kf_itemID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'NEEC' ")){
	
		$s = $INTRANET->Execute("DELETE FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemIDNuevo AND xt_norma = 'NEEC' ");
	}
	
	if($_POST['neecModificado'] != ("" || NULL)){
		$neecNuevo = explode(',', $_POST['neecModificado']);
		
		for($i = 0; $i < count($neecNuevo); $i++){
			$dato = trim($neecNuevo[$i]);
			
			$s = $INTRANET->Execute("INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) VALUES ($itemIDNuevo, 'NEEC', '".$dato."')");
		}
		unset($i);
	}
	
	$dato = "";
	
	if($s = $INTRANET->getOne("SELECT kf_itemID FROM SGI_Item_Referencia WHERE kf_itemID = $itemIDNuevo ")){
		
		$s = $INTRANET->Execute("DELETE FROM SGI_Item_Referencia WHERE kf_itemID = $itemIDNuevo ");
	}
	
	if($_POST['docRefModificado'] != ("" || NULL)){
		
		$docRefNuevo = explode(',', $_POST['docRefModificado']);
		
		for($i = 0; $i < count($docRefNuevo); $i++){
			
			$dato = trim($docRefNuevo[$i]);
			$idDoc = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' ");
			
			$s = $INTRANET->Execute("INSERT INTO SGI_Item_Referencia(kf_itemID, xt_docCodigo) VALUES ($itemIDNuevo, '$idDoc') ");
		}
	}
	
	if(($tipoActual != "C") && ($tipoActual != "K")){
		
		$i = 1;
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo FROM SGI_Elementos WHERE kf_itemID = $itemIDNuevo ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$nElemento[$i] = $r[0];
			$tipoElemento[$i] = $r[1];
			$i++;
		}
		//elemento$numeroElemento[$a]
		for($a = 1; $a <= count($nElemento); $a++){
			$texto = "";
			if($tipoElemento[$a] != "DESARROLLOA"){
				
				$texto = $_POST["contenido$a"];
				//echo "UPDATE SGI_Elementos SET xt_contenido = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroElemento = $a<br>";
				$INTRANET->Execute("UPDATE SGI_Elementos SET xt_contenido = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroElemento = $a ");
				
			}
		}
	}
	
	if($tipoActual == "C"){
		$i = 1;
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, kp_capituloElementoID FROM SGI_CapituloElemento WHERE kf_itemID = $itemIDNuevo ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$nElemento[$i] = $r[0];
			$tipoElemento[$i] = $r[1];
			$capElementoID[$i] = $r[2];
			$i++;
		}
		//elemento$numeroElemento[$a]
		for($a = 1; $a <= count($nElemento); $a++){
			
			$texto = "";
			
			if($tipoElemento[$a] == "DESARROLLOT"){
				
				$texto = $_POST["outline$a"];
				$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_outLine = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroElemento = $a ");
				
				$texto = $_POST["titulo$a"];
				$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_titulo = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroElemento = $a ");
				
				$texto = $_POST["contenido$a"];
				$INTRANET->Execute("UPDATE SGI_CapituloElemento SET xt_contenido = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroElemento = $a ");
				
				if($u = $INTRANET->getOne("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'ISO' ")){
					$u = $INTRANET->Execute("DELETE FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'ISO' ");
				}
				
				if($_POST["refIso$a"] != ("" || NULL)){
					$refIsoNuevo = explode(',', $_POST["refIso$a"]);
					
					for($i = 0; $i < count($refIsoNuevo); $i++){
						$dato = trim($refIsoNuevo[$i]);
						$s = $INTRANET->Execute("INSERT INTO SGI_CapituloElemento_Certificaciones(kf_capituloElementoID, xt_norma, kf_codigoID) VALUES ($capElementoID[$a], 'ISO', '$dato')");
					}
					unset($i);
				}
				
				if($u = $INTRANET->getOne("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'NMX' ")){
					$u = $INTRANET->Execute("DELETE FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'NMX' ");
				}
				
				if($_POST["refNmx$a"] != ("" || NULL)){
					$refNmxNuevo = explode(',', $_POST["refNmx$a"]);
					
					for($i = 0; $i < count($refNmxNuevo); $i++){
						$dato = trim($refNmxNuevo[$i]);
						$s = $INTRANET->Execute("INSERT INTO SGI_CapituloElemento_Certificaciones(kf_capituloElementoID, xt_norma, kf_codigoID) VALUES ($capElementoID[$a], 'NMX', '$dato')");
					}
					unset($i);
				}
				
				if($u = $INTRANET->getOne("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'NEEC' ")){
					$u = $INTRANET->Execute("DELETE FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $capElementoID[$a] AND xt_norma = 'NEEC' ");
				}
				
				if($_POST["refNeec$a"] != ("" || NULL)){
					$refNeecNuevo = explode(',', $_POST["refNeec$a"]);
					
					for($i = 0; $i < count($refNeecNuevo); $i++){
						$dato = trim($refNeecNuevo[$i]);
						$s = $INTRANET->Execute("INSERT INTO SGI_CapituloElemento_Certificaciones(kf_capituloElementoID, xt_norma, kf_codigoID) VALUES ($capElementoID[$a], 'NEEC', '$dato')");
					}
					unset($i);
				}
				
				if($u = $INTRANET->getOne("SELECT xt_docCodigo FROM SGI_CapituloElemento_Referencia WHERE kf_capituloElementoID = $capElementoID[$a] ")){
					$u = $INTRANET->Execute("DELETE FROM SGI_CapituloElemento_Referencia WHERE kf_capituloElementoID = $capElementoID[$a] ");
				}
				
				if($_POST["refDocu$a"] != ("" || NULL)){
					
					$refDocNuevo = explode(',', $_POST["refDocu$a"]);
					
					for($i = 0; $i < count($refDocNuevo); $i++){
						
						$dato 		= trim($refDocNuevo[$i]);
						$idRefDoc 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' ");
						
						$s = $INTRANET->Execute("INSERT INTO SGI_CapituloElemento_Referencia(kf_capituloElementoID,xt_docCodigo) VALUES ($capElementoID[$a], $idRefDoc) ");
					}
					unset($i);
				}
			}
		}
	}
	
	if($tipoActual == "F"){
		
		$origenNuevo 			= $_POST['origenI'];
		$tipoFNuevo 			= $_POST['tipoI'];
		$responsableNuevo 		= $_POST['responsableI'];
		$almacenamientoNuevo 	= $_POST['almacenamientoI'];
		$proteccionNuevo 		= $_POST['proteccionI'];
		$recuperacionNuevo 		= $_POST['recuperacionI'];
		$retencionNuevo 		= $_POST['retencionI'];
		$disposicionNuevo 		= $_POST['disposicionI'];
		
		if($origenNuevo != (""||NULL)){
			
			$INTRANET->Execute("UPDATE SGI_Registro_Contenido SET xt_origen='$origenNuevo', xt_tipo='$tipoFNuevo', xt_responsable='$responsableNuevo', xt_almacenamiento='$almacenamientoNuevo', 
								xt_proteccion='$proteccionNuevo', xt_recuperacion='$recuperacionNuevo', xt_retencion='$retencionNuevo', xt_disposicion='$disposicionNuevo' 
								WHERE kf_itemID=$itemIDNuevo ");
		}
	}
	
	if($tipoActual == "K"){
		///DESCRIPCION DEL PROCESO
		$descripcionPActual = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 0 AND xn_numeroElemento = 1 ORDER BY xn_numeroElemento ");
		
		$descripcionPNueva = $_POST['descripcion'];
		
		$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionPNueva' WHERE WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 0 AND xn_numeroElemento = 1 ");
		
		unset($r); unset($s);
		
		///RESPONSABLE
		$responsablePNuevo = $_POST['responsableProceso'];
		
		if($responsablePNuevo != ""){
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$responsablePNuevo' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 0 AND xn_numeroElemento = 3 ");
		}
		
		///PROCESOS ANTECESORES
		$i = 1;
		//echo "SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento<br>";
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 1 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["procesoAntecesor$a"] != ""){
					
					$codigoItem		= trim($_POST["procesoAntecesor$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 1, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionAntecesores$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionAntecesores$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 1 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloPAntecesores$a"] != ""){
					
					$tituloProceso = $_POST["tituloPAntecesores$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 1, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionAntecesores$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionAntecesores$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 1 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///PROCESOS APOYO
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 2 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 2 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["procesoApoyo$a"] != ""){
					
					$codigoItem		= trim($_POST["procesoApoyo$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 2, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionApoyo$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionApoyo$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 2 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloPApoyo$a"] != ""){
					
					$tituloProceso = $_POST["tituloPApoyo$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 2, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionApoyo$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionApoyo$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 2 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///PROCESOS SUCESORES
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 3 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 3 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["procesoSucesor$a"] != ""){
					
					$codigoItem		= trim($_POST["procesoSucesor$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 3, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionSucesor$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionSucesor$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 3 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloPSucesor$a"] != ""){
					
					$tituloProceso = $_POST["tituloPSucesor$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 3, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionSucesor$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionSucesor$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 3 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///ENTRADAS
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 4 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 4 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["entra$a"] != ""){
					
					$codigoItem		= trim($_POST["entra$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 4, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionEntrada$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionEntrada$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 4 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloEntradas$a"] != ""){
					
					$tituloProceso = $_POST["tituloEntradas$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 4, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionEntrada$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionEntrada$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 4 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///SALIDAS
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 5 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 5 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["salida$a"] != ""){
					
					$codigoItem		= trim($_POST["salida$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 5, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionSalida$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionSalida$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 5 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloSalida$a"] != ""){
					
					$tituloProceso = $_POST["tituloSalida$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 5, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionSalida$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionSalida$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 5 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///EQUIPOS E INSUMOS
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 6 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] 					= $r[0];
			
			$i++;
		} unset($r);
		
		for($a = 1; $a <= count($nElementoP); $a++){
			
			$texto = $_POST["descripcionEquipos$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 6 AND xn_numeroElemento = $a ");
			
		} unset($nElementoP); unset($descripcionInsumosActual);
		
		///COMPLIANCE
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_docCodigo, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 7 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] 					= $r[0];
						
			$i++;
			
		} unset($r);
		
		for($a = 1; $a <= count($nElementoP); $a++){
			
			$texto = $_POST["compliance$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_docCodigo = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 7 AND xn_numeroElemento = $a ");
			
			$texto = $_POST["tituloCompliance$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_titulo = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 7 AND xn_numeroElemento = $a ");
			
			$texto = $_POST["descripcionCompliance$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 7 AND xn_numeroElemento = $a ");
		
		} unset($nElementoP); unset($descripcionComplianceActual); unset($docCodigoActual);
		
		///DOCUMENTOS
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 8 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 8 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["documentoProceso$a"] != ""){
					
					$codigoItem		= trim($_POST["documentoProceso$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 8, $maximoIn, '$idProcesoItem', 'ITEM') ");
						
						if($_POST["descripcionDocumento$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionDocumento$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 8 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloDocumentoR$a"] != ""){
					
					$tituloProceso = $_POST["tituloDocumentoR$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 8, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionDocumento$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionDocumento$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 8 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///STAKEHOLDERS
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_docCodigo, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 9 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] 					= $r[0];
			
			$i++;
			
		} unset($r);
		
		for($a = 1; $a <= count($nElementoP); $a++){
			
			$texto = $_POST["stakeholder$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_titulo = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 9 AND xn_numeroElemento = $a ");
			
			//$texto = $_POST["descripcionStakeholder$a"];
			
			//$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 9 AND xn_numeroElemento = $a ");
			
		} unset($nElementoP); unset($descripcionStakeholderActual); unset($docCodigoActual);
		
		///RIESGOS
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 10 ORDER BY xn_numeroElemento ");	
		
		while($r = $s->fetchRow()){
			
			$nElementoP[$i] = $r[0];
			
			$i++;
			
		} unset($r);
		
		if(count($nElementoP) >= 1){
			
			$INTRANET->Execute("DELETE FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemIDNuevo AND xn_numeroMapa = 10 ");
			
			$maximoIn = 1;
			
			for($a = 1; $a <= count($nElementoP); $a++){
				
				if($_POST["riesgoCod$a"] != ""){
					
					$codigoItem		= trim($_POST["riesgoCod$a"]);
					$idProcesoItem 	= $INTRANET->getOne("SELECT kp_riesgoId FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$codigoItem' ");
					
					if($idProcesoItem != "" && $idProcesoItem != NULL){
						
						$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   				VALUES ($itemIDNuevo, 10, $maximoIn, '$idProcesoItem', 'RIESGO') ");
						
						if($_POST["descripcionRiesgos$a"] != ""){
					
							$descripcionProceso = $_POST["descripcionRiesgos$a"];
							
							$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
												AND xn_numeroMapa = 10 AND xn_numeroElemento = $maximoIn ");
						}
						
						$maximoIn++;
					}
					
				} else if($_POST["tituloRiesgo$a"] != ""){
					
					$tituloProceso = $_POST["tituloRiesgo$a"];
					
					$INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
																	VALUES ($itemIDNuevo, 10, $maximoIn, '$tituloProceso') ");
					
					if($_POST["descripcionRiesgos$a"] != ""){
					
						$descripcionProceso = $_POST["descripcionRiesgos$a"];
						
						$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$descripcionProceso' WHERE kf_itemID = $itemIDNuevo 
											AND xn_numeroMapa = 10 AND xn_numeroElemento = $maximoIn ");
					}
					
					$maximoIn++;
				}
				
			} unset($nElementoP); unset($a);
			
		}
		
		///INDICADORES
		$s = $INTRANET->Execute("SELECT xn_numero, xt_nombre, xt_formula, xt_valor, xt_periodicidad FROM SGI_Procesos_Indicadores WHERE kf_itemID = $itemIDNuevo ORDER BY xn_numero ");	
		
		while($r = $s->fetchRow()){
			$nElementoP[$i] 		= $r[0];
						
			if($r[1] != ""){
				$indNomActual[$i]	= $r[1];
			} else{
				$indNomActual[$i]	= "";
			}
			
			if($r[2] != ""){
				$indForActual[$i]	= $r[2];
			} else{
				$indForActual[$i]	= "";
			}
			
			if($r[3] != ""){
				$indValActual[$i] 	= $r[3];
			} else{
				$$indValActual[$i] 	= "";
			}
			
			if($r[4] != ""){
				$indPerActual[$i] 	= $r[4];
			} else{
				$indPerActual[$i] 	= $r[4];
			}
			
			$i++;
			
		} unset($r); unset($s);
		
		for($a = 1; $a <= count($nElementoP); $a++){
			
			$texto = $_POST["nombreIndicadores$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_nombre = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numero = $a ");
			
			$texto = $_POST["formula$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_formula = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numero = $a ");
			
			$texto = $_POST["valorIndicador$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_valor = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numero = $a ");
			
			$texto = $_POST["periodicidad$a"];
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_periodicidad = '$texto' WHERE kf_itemID = $itemIDNuevo AND xn_numero = $a ");
			
		} unset($nElementoP); unset($indNomActual); unset($indForActual); unset($indValActual); unset($indPerActual);
	
		
	}
	
	if($tipo == 'K'){
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $idItem ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
	
	
		if($inventarioLiberado == ''){
			header ("Location: FichaItem.php?id=$idItem");
		}else{
			header("Location: ControlCambios.php?itemID=$itemIDNuevo");
		}
	}else{
		
		header("Location: ControlCambios.php?itemID=$itemIDNuevo");
		
	}
	
}
?>
</body>
</html>