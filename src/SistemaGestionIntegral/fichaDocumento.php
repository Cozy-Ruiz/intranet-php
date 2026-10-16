<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 3.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'FichaItem.php';
require_once("../ConexionDBT.php");
require_once("../ConexionIntranet2.php");
require_once("../compruebaUsuario.php");

$codDocumento = $_GET['id'];



?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">

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
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
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
			
//version
//fecha de ultimo actualizacion
//nombre del Documento
			
$a = $INTRANETV2->Execute("SELECT xt_nombre, xt_tipo_documento FROM SGI_MANUALES_DOCUMENTOS WHERE kp_codigo_documento = '$codDocumento'");
while($j = $a->fetchRow()){
	
	$nombreDocumento = $j[0];
	$tipoDocumento = $j[1];
	
	
}

//obtengo codigo del manual para la barra de busqueda
$codManual = explode("-", $codDocumento);
$codManual = $codManual[0]."-".$codManual[1];
$nombreManual = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_CATALOGO_MANUALES WHERE kp_codigo_manual = '$codManual'");
	
			
if($tipoDocumento != 'K'){

	$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
   <a href='manuales.php' id='breadcrumbs'> Manuales / </a> <a href='Documento.php?manual=$codManual' id='breadcrumbs'> $nombreManual </a>";
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
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
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
		include("../navegacion_banana.php");
	echo "</table>";


//Seccion de CERTIFICACIONES
if($tipoDocumento != "C"){
	//obtengo los tipos de certificacones
	$indice = 0;
	$norma 	= NULL;



	$s = $INTRANETV2->Execute("SELECT DISTINCT kf_codigo_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE kf_codigo_documento ='$codDocumento'");


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

						//Recorro arreglo de normas
						if($norma[$i] == "OEA"){
							
							echo "NEEC: ";
							
						}else if($norma[$i] == "QCB"){
							
							echo "NMX: ";
							
						}else{
							
							echo $norma[$i].": ";
						}
			
						
						
						$h = $INTRANETV2->Execute("SELECT kf_indice_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE  kf_codigo_documento_norma = '$norma[$i]' AND kf_codigo_documento = '$codDocumento'");


						while($l = $h->fetchRow()){
							$capitulo = (explode(".", $l[0]));

							echo "<a href='CapituloV2.php?norma=".$norma[$i]."&capitulo=".$capitulo[0]."#".$l[0]."' id='fichaRef' >".$l[0]."</a>;";

						}


					echo "</td>";
				echo "</tr>";
			}

			echo "</table>";
	}	

}

//REFERENCIAS
//verifico si existen referencias
$o = $INTRANETV2->Execute("SELECT kf_codigo_referencia FROM SGI_MANUALES_DOCUMENTOS_REFERENCIAS WHERE kf_codigo_documento = '$codDocumento'");
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
						$nombreDocRef = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_MANUALES_DOCUMENTOS WHERE kp_codigo_documento = '$codDoctos[$u]'");
						echo "<a href='FichaItem.php?id=".$codDoctos[$u]."' id='fichaRef' >".$codDoctos[$u]." ".$nombreDocRef."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
	}
	
}

//ELEMENTOS
			
//if($tipo == "M"){
			
if($tipoDocumento == "P" || $tipoDocumento == "L" || $tipoDocumento == "I" || $tipoDocumento == "DE"){
		
	$i = 0;
	$s = $INTRANETV2->Execute("SELECT xn_orden, xt_titulo, xt_contenido, xt_tipo_elemento FROM SGI_MANUALES_ELEMENTOS WHERE kf_codigo_documento = '$codDocumento' ORDER BY xn_orden");

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
		
	if($numeroElemento == NULL){
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Contenido</b></td>";
				echo "<td align='right' width='15px'>";
					//Agregar contenido pendiente
					echo "<a href='AgregarContenidoProcedimientoPopUp.php?itemID=".$itemID."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";

	}

	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Referencias
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='685px'><b>Elementos</b></td>";

			if (($usuarioId == 'Rodrigo_Romo')||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Lizbeth_Guadarrama')||($usuarioId == 'Ricardo_Garcia')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=".$itemID."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
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
	for($a = 1; $a <= count($numeroElemento); $a++){
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
				echo "<br><br>
						<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
						  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
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
				echo "<br><br>
						<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
						  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
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
				echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
					  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
			echo "</td>";
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
				<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
					  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
					  </p>
				  </object><br><br>";
			}else{
				
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo "<a href='downloadItem.php?file=".$contenidoElemento[$a]."' ><img src='../Imagenes/ICN_Archivo.png'> </a> ".substr($contenidoElemento[$a], 9, strlen($contenidoElemento[$a]));
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

	
	$s = $INTRANETV2->Execute("SELECT xn_orden, xt_tipo_elemento, xt_contenido, xt_titulo, xt_outLine, kf_codigo_documento FROM SGI_MANUALES_ELEMENTOS WHERE kf_codigo_documento = '$codDocumento' ORDER BY xn_orden");

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
		
		//NOTA: La tabla SGI_NORMAS_INCISOS_DOCUMENTOS actua para obtener la norma, su inciso y la relacion con documento e inciso y de regreso para obtener el doumento su inciso y con que norma o documento se relaciona y su inciso (si este existe)

		//OBTENGO CERTIFICACIONES RELACIONADAS CON LOS INCISOS
		
	
		$u = $INTRANETV2->Execute("SELECT kf_indice_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE kf_codigo_documento = '$elementoCapID[$i]' AND kf_indice_documento = '$outLine[$i]' AND kf_codigo_documento_norma = 'ISO 2008'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refIso2008[$i] = $refIso[$i]."<a href='CapituloV2.php?norma=ISO 2008&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);

		$u = $INTRANETV2->Execute("SELECT kf_indice_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE kf_codigo_documento = '$elementoCapID[$i]' AND kf_indice_documento = '$outLine[$i]' AND kf_codigo_documento_norma = 'ISO 2015'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refIso2015[$i] = $refNeec[$i]."<a href='CapituloV2.php?norma=ISO 2015&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);
		
		$u = $INTRANETV2->Execute("SELECT kf_indice_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE kf_codigo_documento = '$elementoCapID[$i]' AND kf_indice_documento = '$outLine[$i]' AND kf_codigo_documento_norma = 'QCB'");
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refNmx[$i] = $refNmx[$i]."<a href='CapituloV2.php?norma=NMX&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);

		$u = $INTRANETV2->Execute("SELECT kf_indice_documento_norma FROM SGI_NORMAS_INCISOS_DOCUMENTOS WHERE kf_codigo_documento = '$elementoCapID[$i]' AND kf_indice_documento = '$outLine[$i]' AND kf_codigo_documento_norma = 'OEA'");
		
		while($t = $u->fetchRow()){
			$capitulo = explode(".", $t[0]);
			$refNeec[$i] = $refNeec[$i]."<a href='CapituloV2.php?norma=NEEC&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
		} unset($t); unset($u);
		

		//OBTENGO DOCUMENTOS RELACIONADOS CON LOS INCISOS
		
		
		$u = $INTRANETV2->Execute("SELECT
								MID.kf_codigo_documento_norma,
								MD.xt_nombre,
								kf_indice_documento_norma
							FROM
								SGI_NORMAS_INCISOS_DOCUMENTOS MID,
								SGI_MANUALES_DOCUMENTOS MD
							WHERE
								MID.kf_codigo_documento = '$elementoCapID[$i]'
							AND MID.kf_indice_documento = '$outLine[$i]'
							AND MD.kp_codigo_documento = MID.kf_codigo_documento_norma");
		
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
				echo "<a href='AgregarElementoCapituloPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=900,scrollbars=yes')\"> 
					  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
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
			echo "<br><br>			
					<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
					  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
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
					echo "<tr>";
						echo "<td> </td>";
						echo "<td align='left' id='$outLine[$a]' name='$outLine[$a]'><b><font face= 'Lucida Sans, Arial' size= '3px' color='#fff'>$outLine[$a] $titulo[$a]</font></b></td>";
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
	
	


//cierro pag
echo"</div>";
?>
	</body>
</html>
<?php


	
	
		
			
		
	
		

//}
			
			
?>
