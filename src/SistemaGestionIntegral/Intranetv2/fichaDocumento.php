<?php


$nombrephp = 'FichaItem.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

$codDocumento = $_GET['id'];


?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">

			<style type="text/css">
				
				#roles, #tiempos{
					color: #007CBD;
				}
				table.auto{
					table-layout: auto;
				}

				.linkButton {

					float:right;
					font-family: Lucida Sans, Arial;
					font-size: 13px;
				    background: none;
				    border: none;
				    color: #007CBD;
				    text-decoration: none;
				    cursor: pointer; 
				}
			</style>            
            <script>
            	/*function guardarSignatura(codigo){		
					var signatura = document.getElementById("signatura").value;
					$('.loadSignatura').load("guardarSignatura.php",{signatura : signatura, codigo : codigo }, function(data){
						alert("Signatura");
					});
				}*/

				function showBanana(valor){
					if(valor == 1){
						document.getElementById("banana1").style.display="inline-block";
						document.getElementById("banana0").style.display="none";
						document.getElementById("mapaIntranet").style.display="inline-block";
					} else if (valor == 0){
						document.getElementById("banana1").style.display="none";
						document.getElementById("banana0").style.display="inline-block";
						document.getElementById("mapaIntranet").style.display="none";
					}
				}
			</script>
            
            <script>
				function showPREV(valor){
					if(valor == 1){
						document.getElementById("masControl5").style.display="none";
						document.getElementById("masControl6").style.display="block";
						document.getElementById("formularioUser").style.display="block";
					} else if (valor == 2){
						document.getElementById("masControl5").style.display="block";
						document.getElementById("masControl6").style.display="none";
						document.getElementById("formularioUser").style.display="none";
					}
				}
			</script>

			
           
 			<?php
			
			
				//echo "<title>".$codigo." ".$nombre."</title>";
			
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
			?>
        </head>
        <body>
<?php
			
//pongo titulo de la pestaña
?>
 <title><?php echo $codDocumento; ?></title>
<?php

//header('Content-Type: text/html; charset=UTF-8'); 

function to_roman($num) { 

	// Function to convert an arabic number ($num) to a roman numeral.  $num must be between 0 and 9,999 
	
	if ($num < 0 || $num > 9999) { return -1; } // out of range 
	
	$r_ones = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX"); 
	$r_tens = array(1=> "X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX", 8=>"LXXX", 9=>"XC"); 
	$r_hund = array(1=> "C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC", 8=>"DCCC", 9=>"CM"); 
	$r_thou = array(1=> "M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM", 7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM"); 
	
	$ones = $num % 10; 
	$tens = ($num - $ones) % 100; 
	$hundreds = ($num - $tens - $ones) % 1000; 
	$thou = ($num - $hundreds - $tens - $ones) % 10000; 
	
	$tens = $tens / 10; 
	$hundreds = $hundreds / 100; 
	$thou = $thou / 1000; 
	
	if ($thou) { $rnum .= $r_thou[$thou]; } 
	if ($hundreds) { $rnum .= $r_hund[$hundreds]; } 
	if ($tens) { $rnum .= $r_tens[$tens]; } 
	if ($ones) { $rnum .= $r_ones[$ones]; } 
	
	return $rnum; 

}

//TITULO
			
//obtengo registro de cambios para el documento
$versionImprime = $INTRANETV2->getOne("SELECT max(xn_version) FROM SGI_Control_De_Cambios_Documentos where xt_codigoDocumento = '$codDocumento'");
if($versionImprime > 0){
	
	$fechaVersionImprime = $INTRANETV2->getOne("SELECT xd_fechaCambio FROM SGI_Control_De_Cambios_Documentos where xn_version = $versionImprime AND xt_codigoDocumento = '$codDocumento'");
	
}else{
	
	$versionImprime = 0;
	$fechaVersionImprime = $INTRANETV2->getOne("SELECT xd_fechaCreacion FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
}

			
//version
//fecha de ultimo actualizacion
//nombre del Documento
			
$a = $INTRANETV2->Execute("SELECT xt_nombre, xt_tipoDocumento FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
while($j = $a->fetchRow()){
	
	$nombreDocumento = $j[0];
	$tipoDocumento = $j[1];
	
	
}

//obtengo codigo del manual para la barra de busqueda
$codManual = explode("-", $codDocumento);

	$area = $codManual[1];

$codManual = $codManual[0]."-".$codManual[1];
$nombreManual = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Catalogo_Manuales WHERE xt_codigoManual = '$codManual'");
	
			
if($tipoDocumento != 'K'){

	$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
   <a href='manualesv2.php' id='breadcrumbs'> Manuales / </a> <a href='fichaManual.php?codManual=$codManual' id='breadcrumbs'> $nombreManual </a>";
} else{

	$breadcrumb = "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
	<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a> 
	<a href='Procesos.php' id='breadcrumbs'> Inventario de procesos / </a> <a href='tableroProcesos.php' id='breadcrumbs'> Tablero Inventario de Procesos </a>";
}

echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		
		echo "<tr>";
			echo "<td align='left' id='iconosTexto2'>Versión: ".$versionImprime."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ".$fechaVersionImprime."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		
		if($tipoDocumento != "K"){
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>".$codDocumento."</td>";
				//echo"<td align='center' id='titulo3' width='350px'>".$nombre."</td>";
						//echo $codigo." <br>".$nombre;
				echo"</td>";
			echo"</tr>";
			echo"<tr>";
				echo"<td align='center' id='titulo3' width='700px'>".$nombreDocumento."</td>";
				echo"</td>";
			echo"</tr>";
		} else{
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
						echo $codDocumento;
				echo"</td>";
			echo"</tr>";
		}
		
		echo"<tr height='10px'> </tr>";
		///Bread Crumb
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";		
	echo "</table>";
	
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";


//Seccion de CERTIFICACIONES
//if($tipoDocumento != "C"){
	//obtengo los tipos de certificacones
	$indice = 0;
	$norma 	= NULL;



	$s = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento ='$codDocumento' AND xt_indiceDocumento = ''");


	while($r = $s->fetchRow()){

		$norma[$indice] = ($r[0]);
		$indice++;

	} unset($r);



	if(($norma != (NULL|| ""))){

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

		for($i = 0; $i < count($norma); $i++){
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";

						$inciso = $INTRANETV2->getOne("SELECT GROUP_CONCAT( xt_indiceDocumentoNorma SEPARATOR ', ') FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumentoNorma = '$norma[$i]' AND xt_codigoDocumento = '$codDocumento'");

						echo $inciso;
						
						if($inciso != ''){
							//Recorro arreglo de normas
							if($norma[$i] == "OEA"){

								echo "NEEC: ";

							}else if($norma[$i] == "QCB"){

								echo "NMX: ";

							}else{

								echo $norma[$i].": ";
							}	
			
						
						
							$h = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE  xt_codigoDocumentoNorma = '$norma[$i]' AND xt_codigoDocumento = '$codDocumento'");


							while($l = $h->fetchRow()){
								$capitulo = (explode(".", $l[0]));



								echo "<a href='CapituloV2.php?norma=".$norma[$i]."&capitulo=".$capitulo[0]."#".$l[0]."' id='fichaRef' >".$l[0]."</a>;";

							}
						}

					echo "</td>";
				echo "</tr>";
			}

			echo "</table>";
	}else{
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Certificaciones</b></td>";
				echo "<td align='right' width='15px'>";
					//Agregar contenido pendiente
					echo "<a href='AgregarCertificacionesPopUp.php?codDoc=".$codDocumento."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
		
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
		
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	}

//}

//REFERENCIAS
if($tipoDocumento == "L" || $tipoDocumento == "P" || $tipoDocumento == "F" || $tipoDocumento == "I"){
	//verifico si existen referencias
	$o = $INTRANETV2->Execute("SELECT xt_codigoReferencia FROM SGI_Manuales_Documentos_Referencias WHERE xt_codigoDocumento = '$codDocumento'");
	$indexTD = 0;

	while($p = $o->fetchRow()){

		$codDoctos[$indexTD] = $p[0];
		$indexTD++;

	}unset($o); unset($indexTD);

	if(count($codDoctos) > 0){
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

		for($u = 0; $u<count($codDoctos); $u++){

			echo "<table border='0' align='center'>";
				///ISO
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
							$nombreDocRef = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDoctos[$u]'");
							echo "<a href='fichaDocumento.php?id=".$codDoctos[$u]."' id='fichaRef' >".$codDoctos[$u]." ".$nombreDocRef."</a>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";

		}

	}else{
		
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Referencias</b></td>";
				echo "<td align='right' width='15px'>";
					//Agregar contenido pendiente
					echo "<a href='AgregaReferenciasPopUp.php?codDoc=".$codDocumento."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
		
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
		
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	}

}

//ELEMENTOS
			
//if($tipo == "M"){
			
if($tipoDocumento == "P" || $tipoDocumento == "L" || $tipoDocumento == "I" || $tipoDocumento == "DE"){
		
	$i = 0;
	$s = $INTRANETV2->Execute("SELECT xn_orden, xt_titulo, xt_contenido, xt_tipoElemento FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden");

	while($r = $s->fetchRow()){
		$numeroElemento[$i] = $r[0];
		$tituloElemento[$i] 	= $r[1];
		$tipoElemento[$i] 	= $r[3];
		
		$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
		$i++;
	}
}
			

$bandera = 0;
			
//TIPO P
if($tipoDocumento == "P"){
		
	/*if($numeroElemento == NULL){
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Contenido</b></td>";
				echo "<td align='right' width='15px'>";
					//Agregar contenido pendiente
					echo "<a href='AgregarContenidoProcedimientoPopUp.php?itemID=".$itemID."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";

	}*/

	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Elementos</b></td>";

			if (($usuarioId == 'Rodrigo_Romo')||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Lizbeth_Guadarrama')||($usuarioId == 'Ricardo_Garcia')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregarElementoPopUpv2.php?codDoc=".$codDocumento."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			}else{
				echo "<td align='right' width='15px'>";	
				echo "</td>";	
			}

		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	$bandera = 0;
	for($a = 0; $a < count($numeroElemento); $a++){
		if($tituloElemento[$a] == "DESARROLLO"){
			$bandera++;
		}

		if($bandera == 0){
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left' id='iconosTexto' colspan='2'>";
							echo to_roman($numeroElemento[$a]).". $tituloElemento[$a]";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' width='30px'> </td>";
					echo "<td width='640' id='fileItem' align='justify'>$contenidoElemento[$a]</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
			echo "</table>";
		} else if($bandera == 1){
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' colspan='2' width='670px'>";
							echo to_roman($numeroElemento[$a]).". $tituloElemento[$a]";
					echo "</td>";
				echo "</tr>";
			echo "</table>";	

			if(substr($contenidoElemento[$a], -4) == ".pdf"){
				echo "<br><br><object data='$contenidoElemento[$a]' type='application/pdf' width='950px' height='700px'>
						  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
						  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
						  </p>
					  </object><br><br>";
			} else{
				echo "<table aling='center'>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='640' id='fileItem'  align='justify'>";
							echo $contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
				echo "</table>";	
			}

			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		} else if($bandera > 1){
			if(substr($contenidoElemento[$a], -4) == ".pdf"){
				echo "<br><br><object data='$contenidoElemento[$a]' type='application/pdf' width='950px' height='700px'>
						  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
						  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
						  </p>
					  </object><br><br>";
			} else{
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='640' id='fileItem'  align='justify'>";
							echo $contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
				echo "</table>";	
			}

			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		}
	}
}

//PARA TIPO L, I Y DE

if($tipoDocumento == "L" || $tipoDocumento == "I" || $tipoDocumento == "DE"){
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Elementos</b></td>";
			echo "<td align='right' width='15px'>";
				echo "<a href='AgregarElementoPopUpv2.php?codDoc=$codDocumento' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
					  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
			echo "</td>";
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	for($a = 0; $a < count($numeroElemento); $a++){

		if(substr($contenidoElemento[$a], -4) == ".pdf"){
			echo "<br><br><object data='$contenidoElemento[$a]' type='application/pdf' width='950px' height='700px'>
					  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
					  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
					  </p>
				  </object><br><br>";
			}else{
				
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo $contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10'> </tr>";
				echo "</table>";
			
				
			}

			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
	}
}
			
//TIPO C
			
if($tipoDocumento == "C"){
	$i = 0;

	
	$s = $INTRANETV2->Execute("SELECT xn_orden, xt_tipoElemento, xt_contenido, xt_titulo, xt_outLine, xt_codigoDocumento FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden");

	while($r = $s->fetchRow()){
		$numeroElemento[$i] = $r[0];
		$tipoElemento[$i] = $r[1];
		$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
		$titulo[$i] = trim($r[3]);

		$outLine[$i] = $r[4];
		$subnivel = (explode('.', trim($outLine[$i])));
		$nivel[$i] = count($subnivel);

		$elementoCapID[$i] = $r[5];

		$refIso[$i] = "";
		$refNmx[$i] = "";
		$refNeec[$i] = "";
		$refDoc[$i] = "";
		
		//NOTA: La tabla SGI_Normas_Incisos_Documentos actua para obtener la norma, su inciso y la relacion con documento e inciso y de regreso para obtener el doumento su inciso y con que norma o documento se relaciona y su inciso (si este existe)

		//OBTENGO CERTIFICACIONES RELACIONADAS CON LOS INCISOS
		
	
		$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 2008'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refIso2008[$i] = $refIso[$i]."<a href='CapituloV2.php?norma=ISO 2008&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);

		$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'ISO 2015'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refIso2015[$i] = $refNeec[$i]."<a href='CapituloV2.php?norma=ISO 2015&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);
		
		$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'QCB'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refNmx[$i] = $refNmx[$i]."<a href='CapituloV2.php?norma=NMX&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);

		$u = $INTRANETV2->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$elementoCapID[$i]' AND xt_indiceDocumento = '$outLine[$i]' AND xt_codigoDocumentoNorma = 'OEA'");
		
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refNeec[$i] = $refNeec[$i]."<a href='CapituloV2.php?norma=NEEC&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);
		

		//OBTENGO DOCUMENTOS RELACIONADOS CON LOS INCISOS
		
		
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
			$refDoc[$i] = $refDoc[$i]."<a href='fichaDocumento.php?id=".$idDocRef."' id='breadcrumbs'>".$idDocRef." ".$indiceDocRef." ".$tituloDocRef."</a><br>";

		} unset($t); unset($u);  

		$i++;
	}

	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Elementos</b></td>";
			echo "<td align='right' width='15px'>";
				//Agregar elemento
				echo "<a href='AgregarElementoCapituloPopUpv2.php?codDoc=$codDocumento' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=900,scrollbars=yes')\"> 
					  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
			echo "</td>";
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	for($a = 0; $a < count($numeroElemento); $a++){

		if(substr($contenidoElemento[$a], -4) == ".pdf"){
			echo "<br><br><object data='$contenidoElemento[$a]' type='application/pdf' width='950px' height='700px'>
					  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
					  No obstante puede descargar el archivo en este <a href='$contenidoElemento[$a]'>enlance</a>
					  </p>
				  </object><br><br>";
		} else{

			if($nivel[$a] == 1){
				$ancho = 680;
			} else if($nivel[$a] == 2){
				$ancho = 660;
			} else if($nivel[$a] == 3){
				$ancho = 640;
			} else if($nivel[$a] == 4){
				$ancho = 620;
			} else if($nivel[$a] == 5){
				$ancho = 600;
			} else if($nivel[$a] == 6){
				$ancho = 580;
			} else if($nivel[$a] == 7){
				$ancho = 560;
			} else if($nivel[$a] == 8){
				$ancho = 540;
			} else if($nivel[$a] == 9){
				$ancho = 520;
			}

			echo "<table border='0' align='center'>";
				if($titulo[$a] != ""){
					echo "<tr id='fichaRef'>";
						echo "<td> </td>";
						echo "<td align='left' id='$outLine[$a]' name='$outLine[$a]'><b>$outLine[$a] $titulo[$a]</b></td>";
					echo "</tr>";
				}

				if($refIso2008[$a] != "" || $refNmx[$a] != "" || $refNeec[$a] != "" || $refIso2015[$a] != ""){
					echo "<tr>";
						echo "<td> </td>";
						echo "<td align='left' id='breadcrumbs'>";

						$indicador = 0;

						if($refIso2008[$a] != ""){
							echo "ISO 2008: ";

							echo substr($refIso2008[$a], 0, -2);
							$indicador++;
						}
					
						if($refIso2015[$a] != ""){

								if($indicador >= 1){
									echo " / ISO 2015: ".substr($refIso2015[$a], 0, -2);
								} else{
									echo "ISO 2015:: ".substr($refIso2015[$a], 0, -2);
								}
								$indicador++;
							}

						if($refNmx[$a] != ""){

							if($indicador >= 1){
								echo " / NMX: ".substr($refNmx[$a], 0, -2);
							} else{
								echo "NMX: ".substr($refNmx[$a], 0, -2);
							}
							$indicador++;
						}

						if($refNeec[$a] != ""){
							if($indicador >= 1){
								echo " / NEEC: ".substr($refNeec[$a], 0, -2);
							} else{
								echo "NEEC: ".substr($refNeec[$a], 0, -2);
							}
						}
						echo "</td>";
					echo "</tr>";

					echo "<tr height='5px'> </tr>";
				}

				if($refDoc[$a] != ""){
					echo "<tr>";
						echo "<td> </td>";
						echo "<td align='left' id='breadcrumbs'>$refDoc[$a]</td>";
					echo "</tr>";
				}

				echo "<tr height='10px'> </tr>";
				//////AJUSTE DEL ANCHO DE LA TABLA (SANGRIA)
				echo "<tr>";
					echo "<td width='".(700-$ancho)."'> </td>";
					echo "<td width='$ancho' id='fileItem' align='justify'>$contenidoElemento[$a]</td>";
				echo "</tr>";

				echo "<tr height='20px'> </tr>";

			echo "</table>";

		}

		echo "<table>";		
			echo "<tr height='10px'> </tr>";
		echo "</table>";
	}
}
			
			
//TIPO F			


if(($tipoDocumento == "F") && ($area != 'CRM')){
	
	
	
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
		
		$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
		$i++;
	}unset($r); unset($s);
	

	$bandera = 0;

	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Formato</b></td>";
			echo "<td align='right' width='15px'>";
				echo "<a href='AgregarElementoPopUpv2.php?codDoc=".$codDocumento."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
					  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
			echo "</td>";
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	for($a = 0; $a <= count($numeroElemento); $a++){

		if(substr($contenidoElemento[$a], 0, 12) == "../../FILES/"){
			echo "<table>";	
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td width='670' id='fileItem'  align='justify'>";
						echo "<a href='downloadItem.php?file=".$contenidoElemento[$a]."' ><img src='../../Imagenes/ICN_Archivo.png'> </a> ".substr($contenidoElemento[$a], 12, strlen($contenidoElemento[$a]));
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'> </tr>";
			echo "</table>";
		} else{
			echo "<table>";	
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td width='670' id='fileItem'  align='justify'>";
						echo $contenidoElemento[$a];
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'> </tr>";
			echo "</table>";	
		}

		echo "<table>";		
			echo "<tr height='10px'> </tr>";
		echo "</table>";

	}
	
	//CONTROL DE REGISTROS
	
	$banderaMuestraTitulo = 0;
	$p = $INTRANETV2->Execute("SELECT
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
	
	while($t = $p->fetchRow()){
		
		$banderaMuestraTitulo++;
		
		if($banderaMuestraTitulo == 1){
			
			
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
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
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo $t[0].": ".$t[1]."</td>";
				echo "</tr>";
				
			echo "</table>";
			
		}else if($banderaMuestraTitulo > 1){

			echo "<table border='0' align='center'>";

				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo $t[0].": ".$t[1]."</td>";
				echo "</tr>";
				
			echo "</table>";
			
			
			
		}
		
		
	}
	
	if($banderaMuestraTitulo == 0){
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Control del registro</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='agregaControlRegistrosF.php?codDoc=$codDocumento' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	}

	
	// FORMATOS REGISTRADOS
	//echo"SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ";
	
	//$formatoRegistro = $INTRANET->GetOne("SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ");
	
	$f = $INTRANETV2->Execute("SELECT DISTINCT xt_codigoDocumento FROM SGI_Documento_Registro ORDER BY xt_codigoDocumento");
	
	$contadorReg = 0;
	while($p = $f->fetchRow()){

		$formatoCategoria[$contadorReg] = $p[0];
		$contadorReg++;

	} unset($p); unset($f); unset($contadorReg);
	
	
	
	for($allTypes=0; $allTypes<count($formatoCategoria); $allTypes++){		
	//for($allTypes = 1; $allTypes <= 16; $allTypes++){
   				
			if(($codDocumento) == ($formatoCategoria[$allTypes])){				
			
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='685px'><b>Registros</b></td>";
						
						echo "<td align='right' width='15px'>";
							echo "<a href='../../Registros/altaRegistroItemv2.php?codDoc=$codDocumento' target='popup' onclick=\"window.open(this.href,this.target,'width=900,height=800,scrollbars=yes')\"> 
								  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
						echo "</td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					
					echo"<tr height='30px'> </tr>";
					
					echo"<tr>";
						$s = $INTRANETV2->Execute("SELECT xt_tituloRegistro, xt_codigoRegistro, xt_ruta FROM SGI_Documento_Registro WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xd_fecha ASC");
					
							while($r = $s->fetchRow()){
							
							$tituloRegistro = $r[0];
							$resgitroID		= $r[1];
							$archivo		= $r[2];
							
							echo "<td id='iconosTexto'><a id='iconosTexto' href='../../Registros/Intranetv2/fichaRegistrov2.php?id=".$resgitroID."'>".$tituloRegistro."</td>";
								if($archivo != ""){
									echo"<td> <a href='../../Registros/downloadRegistrov2.php?file=".$archivo."'><img src='../../Imagenes/ICN_Archivo.png'></a></td>";
								}
						
							
							
					echo"</tr>";
											}
					echo"<tr height='20px'> </tr>";
				echo "</table>";
			
			}//fin de if registros
	}//fin de formatos registrados 
}


//Seccion para formato CRM con relacion a la solicitud del entregable
		
if($tipoDocumento == "F" && $area == 'CRM'){
	


	$i = 1;
	//$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
	$s = $INTRANETV2->Execute("SELECT xt_codigoReporte, xt_nombreArchivo, xt_quejaSolicitud, xt_ruta FROM IntranetGEA.SGI_Backlog_Informacion_Reportes WHERE xt_codigoReporte = '$codDocumento'");

	while($r = $s->fetchRow()){
		$tipoElemento[$i] = $r[0];
		$solicitud[$i]    = $r[2];
		$ruta[$i]         = $r[3];

		$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[1]));
		$i++;
	}
	

	$bandera = 0;

	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Formato</b></td>";
			echo "<td align='right' width='15px'>";
			
			echo "</td>";
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	for($a = 1; $a <= count($contenidoElemento); $a++){

		if($contenidoElemento[$a] != ''){
			echo "<table>";	
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td width='670' id='fileItem'  align='justify'>";
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctosReporte.php?nombreA=$contenidoElemento[$a]&ruta=$ruta[$a]'><img src='../../Imagenes/ICN_Archivo.png'> </a> ".$contenidoElemento[$a];
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'> </tr>";
			echo "</table>";
		} /*else{
			echo "<table>";	
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td width='670' id='fileItem'  align='justify'>";
						echo $contenidoElemento[$a];
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'> </tr>";
			echo "</table>";	
		//}*/
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Solicitud relacionada</b></td>";
				echo "<td align='right' width='15px'>";
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";

		$s = $INTRANET->Execute("SELECT
									xt_quejaSolicitud
								FROM
									SGI_Backlog_Informacion_Reportes
								WHERE
									xt_codigoReporte = '$codDocumento' ");

		while($r = $s->fetchRow()){
			$codigoSolicitud     = $r[0];

		} unset($r); unset($s);

		echo "<table>";		
			echo "<tr height='10px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$codigoSolicitud'>$codigoSolicitud</a></td>";
			echo "</tr>";
		echo "</table>";

		echo "<table>";		
			echo "<tr height='10px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Parámetros</b></td>";
				echo "<td align='right' width='15px'>";
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";

		$s = $INTRANETV2->Execute("SELECT
									xt_quejaSolicitud,
									xt_codigoReporte,
									xt_cliente,
									xt_solicitanteOriginal,
									xt_responsableEnvio,
									xt_responsableReenvio,
									xt_descripcion,
									xt_periodicidad,
									xt_parametros,
									xt_listaDistribucion,
									xt_modoEnvio,
									xt_sistema
								FROM
									IntranetGEA.SGI_Backlog_Informacion_Reportes
								WHERE
									xt_codigoReporte = '$codigo' ");

		while($r = $s->fetchRow()){
			$codigoSolicitud     = $r[0];
			$codigoReporte       = $r[1];
			$cliente             = $r[2];
			$solicitanteOriginal = $r[3];
			$responsableEnvio    = $r[4];
			$responsableReenvio  = $r[5];
			$descripcion         = $r[6];
			$periodicidadS       = $r[7];
			$parametros          = $r[8];
			$listaDistribucion   = $r[9];
			$modoEnvio           = $r[10];
			$sistema             = $r[11];


		} unset($r); unset($s);

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Cliente:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$cliente</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Solicitante original:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$solicitanteOriginal</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Responsable de envío:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$responsableEnvio</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Descripción:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$descripcion</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Periodicidad:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$periodicidadS</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Parámetros de consulta:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$parametros</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Lista de distribución:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$listaDistribucion</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Modo de envío:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$modoEnvio</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
					echo "<b>Fuente de información:</td>";
				echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
					echo "$sistema</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
		echo "</table>";
			/*
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Solicitante original:  </b> $solicitanteOriginal</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Responsable de envío:  </b>$responsableEnvio</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Responsable de reenvío:  </b>$responsableReenvio</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Descripción:  </b>$descripcion</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Periodicidad:  </b>$periodicidadS</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Parámetros de consulta:  </b>$parametros</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Lista de distribución:  </b>$listaDistribucion</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Modo de envío:  </b>$modoEnvio</td>";
			echo "</tr>";
			echo "<tr height='5px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "<b>Fuente de información:  </b>$sistema</td>";
			echo "</tr>";*/
		echo "</table>";

		echo "<table>";		
			echo "<tr height='10px'> </tr>";
		echo "</table>";

	}
	//CONTROL DE REGISTROS

	//CONTROL DE REGISTROS
	
	$banderaMuestraTitulo = 0;
	$p = $INTRANETV2->Execute("SELECT
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
	
	while($t = $p->fetchRow()){
		
		$banderaMuestraTitulo++;
		
		if($banderaMuestraTitulo == 1){
			
			
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
					echo "<td align='right' width='15px'>";
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
		}else if($banderaMuestraTitulo > 1){

			echo "<table border='0' align='center'>";

				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo $t[0].": ".$t[1]."</td>";
				echo "</tr>";
				
			echo "</table>";
			
			
			
		}
		
		
	}
	
	if($banderaMuestraTitulo == 0){
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Control del registro</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregarContenidoFormatoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	}

}
	
			
			

	
//CONTROL DE CAMBIOS

//obtengo registro de cambios para el documento
$k = $INTRANETV2->Execute("SELECT xn_version, xt_descripcion, xt_inicialesUsuario FROM SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_version DESC");

$versionCC = array();
$cambioDesc = array();
$fechaVersion = array();
$iniciales = array();

$indexCC = 0;
			
while($n = $k->fetchRow()){
	
 $versionCC[$indexCC] = $n[0];
 $cambioDesc[$indexCC] = $n[1];
 
 $iniciales[$indexCC] = $n[2];
	
 $indexCC++;
}
	
			
if($cambioDesc != (NULL)){
	
		
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='700px'><b>Control de Cambios</b></td>";
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";

	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='iconosTexto2'>Versión</td>";
			echo "<td align='left' id='iconosTexto2'>Descripción</td>";
			echo "<td align='center' id='iconosTexto2'>Fecha</td>";
			echo "<td align='center' id='iconosTexto2'>Iniciales</td>";
		echo "</tr>";

		echo "<tr height='10px'> </tr>";

		for($a = 0; $a < count($versionCC); $a++){
			
			
			$fechaVersion = $INTRANETV2->getone("SELECT xd_fechaCambio FROM SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento = '$codDocumento' AND xn_version = $versionCC[$a]");
			$fechaVersion = date('Y-m-d', strtotime($fechaVersion));
			echo "<tr>";
				echo "<td width='100px' align='center' id='fileItem'>$versionCC[$a]</td>";
				echo "<td align='left' width='420px' id='fileItem'>$cambioDesc[$a]</td>";
				echo "<td align='center' width='80px' id='fileItem'>$fechaVersion</td>";
				echo "<td align='center' width='100' id='fileItem'>$iniciales[$a]</td>";
			echo "</tr>";
			echo "<tr height='10px'> </tr>";

		}

	echo "</table>";
}

//Pie de pag
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td width='550px'> </td><td width='150px'> </td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs' width='700px'>";
				echo "<i><a href='imprimeFichaDocumento.php?codDoc=".$codDocumento."&tipoDoc=".$tipoDocumento."' id='breadcrumbs'>Imprimir</a></i>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		/*if($tipo == 'K'){
			
			$firmaAutorizada = $INTRANET->getOne("SELECT SGE.kp_personalId FROM SGI_Empleados SGE WHERE SGE.kf_usuario = '$usuarioId' ");
			
			if ($firmaAutorizada == $idResponsable){
				echo "<td align='right'>";
					echo "<a href='firmarProceso.php?id=".$idItem."&elemento=Documento' target='popup' onclick=\"window.open(this.href,this.target,'width=510,height=400,scrollbars=yes')\">
						  <img src='../Imagenes/ICN_Firmar.png' width='90' height='29'></a>";
				echo "</td>";
				
			}else{
				echo "<td align='right'> </td>";
			}
		}else{
			echo "<td align='right'> </td>";
		}*/
		
		if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
			echo "<td align='right'>";
				echo "<a href='fichaModificacionDocumentos.php?id=".$codDocumento."&tipoDoc=".$tipoDocumento."' >
					  <img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
			
		} else{
			echo "<td align='right'> </td>";
		}
		echo "</tr>";
		
		
		echo"<tr height='10px'> </tr>";
		
		echo "<tr>";
			echo "<td align='center' id='nota_al_pie' colspan='2'>";
			//Fecha y usuario de creacion del documento
			
				$fechaCreacion = $INTRANETV2->getOne("SELECT xd_fecha_creacion FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
				echo "Creado: $fechaCreacion, Salvador de la Peña";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='40px'> </tr>";
		
	echo "</table>";			


//cierro pag
echo"</div>";
?>
	</body>
</html>

