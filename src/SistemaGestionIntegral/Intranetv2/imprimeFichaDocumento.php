<?php

require_once("../../ConexionDBT.php");
require('../../Librerias/fpdf/fpdf.php');
include('../../Librerias/fpdi/fpdi.php');
//include('../Librerias/fpdi/fpdf_tpl.php');
require_once('../../Librerias/tcpdf/tcpdf.php');
require_once("../../ConexionIntranet2.php");

//require_once("fichaBoletin.php");

class PDF extends FPDI {

	var $files = array();

	function setFiles($files) {
		$this->files = $files;
	}

	function concat() {
		foreach($this->files AS $file) {
			$pagecount = $this->setSourceFile($file);
			for ($i = 1; $i <= $pagecount; $i++) {
				$tplidx = $this->ImportPage($i);
				 $s = $this->getTemplatesize($tplidx);
				 $this->AddPage('P', array($s['w'], $s['h']));
				 $this->useTemplate($tplidx , 10, 10, 200);
			}
		}
	}
}



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



//Funcion remplazar caracteres especiales
function em($word) {

    $word = str_replace("@","%40",$word);
    $word = str_replace("`","%60",$word);
    $word = str_replace("¢","%A2",$word);
    $word = str_replace("£","%A3",$word);
    $word = str_replace("¥","%A5",$word);
    $word = str_replace("|","%A6",$word);
    $word = str_replace("«","%AB",$word);
    $word = str_replace("¬","%AC",$word);
    $word = str_replace("¯","%AD",$word);
    $word = str_replace("º","%B0",$word);
    $word = str_replace("±","%B1",$word);
    $word = str_replace("ª","%B2",$word);
    $word = str_replace("µ","%B5",$word);
    $word = str_replace("»","%BB",$word);
    $word = str_replace("¼","%BC",$word);
    $word = str_replace("½","%BD",$word);
    $word = str_replace("¿","%BF",$word);
    $word = str_replace("À","%C0",$word);
    $word = str_replace("Á","%C1",$word);
    $word = str_replace("Â","%C2",$word);
    $word = str_replace("Ã","%C3",$word);
    $word = str_replace("Ä","%C4",$word);
    $word = str_replace("Å","%C5",$word);
    $word = str_replace("Æ","%C6",$word);
    $word = str_replace("Ç","%C7",$word);
    $word = str_replace("È","%C8",$word);
    $word = str_replace("É","%C9",$word);
    $word = str_replace("Ê","%CA",$word);
    $word = str_replace("Ë","%CB",$word);
    $word = str_replace("Ì","%CC",$word);
    $word = str_replace("Í","%CD",$word);
    $word = str_replace("Î","%CE",$word);
    $word = str_replace("Ï","%CF",$word);
    $word = str_replace("Ð","%D0",$word);
    $word = str_replace("Ñ","%D1",$word);
    $word = str_replace("Ò","%D2",$word);
    $word = str_replace("Ó","%D3",$word);
    $word = str_replace("Ô","%D4",$word);
    $word = str_replace("Õ","%D5",$word);
    $word = str_replace("Ö","%D6",$word);
    $word = str_replace("Ø","%D8",$word);
    $word = str_replace("Ù","%D9",$word);
    $word = str_replace("Ú","%DA",$word);
    $word = str_replace("Û","%DB",$word);
    $word = str_replace("Ü","%DC",$word);
    $word = str_replace("Ý","%DD",$word);
    $word = str_replace("Þ","%DE",$word);
    $word = str_replace("ß","%DF",$word);
    $word = str_replace("à","%E0",$word);
    $word = str_replace("á","%E1",$word);
    $word = str_replace("â","%E2",$word);
    $word = str_replace("ã","%E3",$word);
    $word = str_replace("ä","%E4",$word);
    $word = str_replace("å","%E5",$word);
    $word = str_replace("æ","%E6",$word);
    $word = str_replace("ç","%E7",$word);
    $word = str_replace("è","%E8",$word);
    $word = str_replace("é","%E9",$word);
    $word = str_replace("ê","%EA",$word);
    $word = str_replace("ë","%EB",$word);
    $word = str_replace("ì","%EC",$word);
    $word = str_replace("í","%ED",$word);
    $word = str_replace("î","%EE",$word);
    $word = str_replace("ï","%EF",$word);
    $word = str_replace("ð","%F0",$word);
    $word = str_replace("ñ","%F1",$word);
    $word = str_replace("ò","%F2",$word);
    $word = str_replace("ó","%F3",$word);
    $word = str_replace("ô","%F4",$word);
    $word = str_replace("õ","%F5",$word);
    $word = str_replace("ö","%F6",$word);
    $word = str_replace("÷","%F7",$word);
    $word = str_replace("ø","%F8",$word);
    $word = str_replace("ù","%F9",$word);
    $word = str_replace("ú","%FA",$word);
    $word = str_replace("û","%FB",$word);
    $word = str_replace("ü","%FC",$word);
    $word = str_replace("ý","%FD",$word);
    $word = str_replace("þ","%FE",$word);
    $word = str_replace("ÿ","%FF",$word);
    return $word;
}

//OBTENGO PARAMETROS
$codDocumento = $_GET['codDoc'];
$tipoDoc = $_GET['tipoDoc'];
///CURPO DEL ITEM
$nombre = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");

if($tipoDoc != "C"){
	
	//Certificcaciones
	$arrNormas = array();
	$arrIncisoNorma = array();
	$indexNorma = 0;
	$indexincisoN = 0;
	
	$s= $INTRANETV2->Execute("SELECT DISTINCT xt_codigoDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
	while($listNorma = $s -> fetchRow()){

		  $arrNormas[$indexNorma] = $listNorma[0];
		
		//ontengo los indices de la norma correspondiente
		$j= $INTRANETV2 ->Execute("SELECT xt_indiceDocumentoNorma FROM SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento' AND xt_codigoDocumentoNorma = '$arrNormas[$indexNorma]'");
	
	
		$listaIncisosN = "";
		$banderaComa = 0;
		
		while($listInciso = $j->fetchRow()){
			
			if($banderaComa == 0){
				
				$listaIncisosN .= trim($listInciso[0]);
			}else{
				
				$listaIncisosN .= "; ".trim($listInciso[0]);
			}
			
			$banderaComa++;
		
		}
		
		  $arrIncisoNorma[$indexincisoN] = $listaIncisosN;

		$indexNorma++;
		$indexincisoN++;
	}
	
	//Referencias
	
	$l = $INTRANETV2->Execute("SELECT MDR.xt_codigoReferencia, CMD.xt_nombre FROM SGI_Manuales_Documentos CMD, SGI_Manuales_Documentos_Referencias MDR WHERE MDR.xt_codigoReferencia = CMD.xt_codigoDocumento AND  MDR.xt_codigoDocumento = '$codDocumento'");
	
	while($listRef = $l->fetchRow()){
		
		$listaReferencias .= $listRef[0]."; ";
		
	}

	
}

///ELEMENTOS
$i = 1;
$s = $INTRANETV2->Execute("SELECT xn_orden, xt_tipoElemento, xt_titulo, xt_contenido, xt_outline FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden ");

while($r = $s->fetchRow()){
	
	$numeroElemento[$i] = $r[0];
	$tipoElemento[$i] 	= $r[1];
	$tituloElemento[$i] = $r[2];
	
	
	$contenidoElemento[$i] = $r[3];
	$outline [$i] = $r[4];
	
	$i++;
	
} unset($r); unset($i); 


//Datos de ultima actualizacion
$numeroVersion 	= $INTRANETV2->getOne("SELECT MAX(xn_version) FROM SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
if($numeroVersion != ''){
$fechaActualizacion = $INTRANETV2->getOne("SELECT xd_fechaCambio FROM SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento  = '$codDocumento' AND xn_version= $numeroVersion");

}else{
	$numeroVersion = 0;
	$fechaActualizacion = $INTRANETV2->getOne("SELECT xd_fechaCreacion FROM SGI_Manuales_Documentos WHERE xt_codigoDocumento  = '$codDocumento'");

}


//VERSIONES
$z = 1;
$banderaVersion = 0;

$s = $INTRANETV2->Execute("SELECT xd_fechaCambio, xn_version, xt_descripcion, xt_inicialesUsuario FROM SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento ='$codDocumento'");

while($r = $s->fetchRow()){
	
	$fechaVersion[$z] 	= date('Y-m-d', strtotime($r[0]));
	$version[$z] 		= $r[1];
	$cambioDesc[$z] 	= $r[2];
	$iniciales[$z] 		= $r[3];
	
	$z++;
	$banderaVersion++;
	
} unset($r); unset($z);





///REFERENCIAS ISO
/*$indice = 1;
$iso 	= NULL;

$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'ISO' ORDER BY kf_codigoID ");

while($r = $s->fetchRow()){
	
	$iso[$indice] = trim($r[0]);
	$indice++;
	
} unset($r);

///REFERENCIAS NMX
$indice = 1;
$nmx 	= NULL;

$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NMX' ORDER BY kf_codigoID ");

while($r = $s->fetchRow()){
	
	$nmx[$indice] = trim($r[0]);
	$indice++;
	
} unset($r);

///REFERENCIAS NEEC
$indice = 1;
$neec 	= NULL;

$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NEEC' ORDER BY kf_codigoID ");

while($r = $s->fetchRow()){
	
	$neec[$indice] = trim($r[0]);
	$indice++;
	
} unset($r);

///REFERENCIAS OTROS DOCUMENTOS
$indice = 1;
$docRef = NULL;

$s = $INTRANET->Execute("SELECT ITM.xt_nombre, ITM.kp_itemID, ITM.xt_codigo 
						 FROM SGI_Item ITM, SGI_Item_Referencia RFE WHERE ITM.kp_itemID = RFE.xt_docCodigo AND RFE.kf_itemID = $itemID 
						 ORDER BY ITM.xt_codigo ");

while($r = $s->fetchRow()){
	
	$itmRef[$indice] = $r[1];
	
	$docRef[$indice] = $r[2]." ".$r[0];
		
	$indice++;
	
} unset($r); unset($indice);

///VERSIONES
$i = 1;
$banderaVersion = 0;

$s = $INTRANET->Execute("SELECT CC.xd_fecha, xn_numero, CC.xt_descripcion, EMP.xt_iniciales FROM SGI_Control_Cambios CC, SGI_Empleados EMP
						WHERE CC.kf_itemID = $itemID AND EMP.kp_personalId = CC.kf_actorID ORDER BY xd_fecha DESC ");

while($r = $s->fetchRow()){
	
	$fechaVersion[$i] 	= date('Y-m-d', strtotime($r[0]));
	$version[$i] 		= $r[1];
	$cambioDesc[$i] 	= $r[2];
	$iniciales[$i] 		= $r[3];
	
	$i++;
	$banderaVersion++;
	
} unset($r); unset($i);

if($banderaVersion == 0){
	$versionImprime = 0;
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaCreacion));
} else{
	$versionImprime = $version[1];
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaVersion[1]));
}

///ELEMENTOS
$i = 1;
$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");

while($r = $s->fetchRow()){
	
	$numeroElemento[$i] = $r[0];
	$tipoElemento[$i] 	= $r[1];
	
	if(($tipoElemento[$i] == 'DESARROLLOT') || ($tipoElemento[$i] == 'DESARROLLOA')){
		$tipoElemento[$i] = "DESARROLLO";
	}
	
	$contenidoElemento[$i] = $r[2];
	
	$i++;
	
} unset($r); unset($i); */



$fechaTexto = 'Fecha de última actualización';

$pdf=new FPDF();
//Primera página
$pdf->AddPage('p',"Letter");
//$pdf->SetLeftMargin(2);
//Configuramos la fuente de la linea
$pdf->SetFont('Arial','',10);
//Imprimimos la fecha de creacion
$pdf->Cell(20,0,''.utf8_decode(Versión).': '.$numeroVersion,0,0,'R');
$pdf->Ln(5);
$pdf->Cell(72,0,''.utf8_decode($fechaTexto).': '.date(substr($fechaActualizacion,0,10)),0,0,'C');


//$pdf->Cell(10,0,''.utf8_decode(Fecha).': '.$fechaVersion("d/m/Y"),0,0,'R');
$pdf->Ln(15);

//Colocamos el siguiente punto de la cabecera nombre del procedimiento
$pdf->Cell(190,0,''.iconv("UTF-8","ISO-8859-1",$nombre).' '.iconv("UTF-8","ISO-8859-1",$codDocumento),0,0,'C');
$pdf->Ln(7);


$pdf->Cell(180,0,'Copia no controlada',0,0,'C');
$pdf->ln(20);

//CERTIFICACIONES
$pdf->Cell(100,0,'Certificaciones',0,0,'L');
$pdf->Ln(10);

if(count($arrNormas) >= 1){
	
	for($p = 0; $p < count($arrNormas); $p++){
		
		 $incisoCertif = $arrNormas[$p];
		
		if($incisoCertif == "QCB"){

			$incisoCertif = "NMX";
		}else if($incisoCertif == "OEA"){

			$incisoCertif = "NEEC";
		}
 
		 $incisoCertif .= ": "; 

		for($i = 0; $i < count($arrIncisoNorma[$p]); $i++){

			 $incisoCertif = $incisoCertif.$arrIncisoNorma[$p]."; ";

		} unset($i);

		$incisoCertif = substr($incisoCertif, 0, -2);

		$pdf->Cell(100,0,''.$incisoCertif,0,0,'L');
		$pdf->Ln(10);
	}
}


$pdf->ln(10);

//REFERENCIAS
$pdf->Cell(100,0,'Referencias',0,0,'L');
$pdf->ln(10);

if($listaReferencias != ''){
 
	//$docs = $docs.$docRef[$i];
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(150,0,''.iconv("UTF-8","ISO-8859-1", $listaReferencias),0,0,'L');
	$pdf->ln(5);
	
}
$pdf->ln(10);


//ELEMENTOS
$indice = 1;
$archivos = NULL;
$archivos[0] = "";
$letras = "A";

$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'Elementos',0,0,'L');
$pdf->ln(10);

$bandera = 0;
for($a = 1; $a <= count($numeroElemento); $a++){
	
	if($tituloElemento[$a] == "DESARROLLO"){
		
		$bandera++;
		
	}
	
	if($bandera == 0){
		
		///IMPRIMIR TITULO
			if($tipoDoc != "C"){
			$pdf->Cell(100,0,''.to_roman($numeroElemento[$a]).'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
			$pdf->ln(10);
			//echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
			}else{
				$pdf->Cell(100,0,''.$outline[$a].'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
				$pdf->ln(10);
				
			}
		///IMPRIMIR CONTENIDO
			//$x = $pdf->GetX(); 
			//$y = $pdf->GetY(); 
		if($tipoElemento[$a] != "A"){
			$pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
			$pdf->ln(10);
			//echo "$contenidoElemento[$a]";
		}
		
	} else if($bandera == 1){
		
		///IMPRIMIR TITULO
		if($tipoDoc != "C"){
			$pdf->Cell(100,0,''.to_roman($numeroElemento[$a]).'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
			$pdf->ln(10);
		}else{
			if($tipoElemento[$a] != "A"){
			$pdf->Cell(100,0,''.$outline[$a].'. '.$tituloElemento[$a],0,0,'L');
			$pdf->ln(10);
			}
			
		}
			//echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
				
		
		if(substr($contenidoElemento[$a], -4) == ".pdf" ){
			
			///METODO PARA AGREGAR UN PDF AL ARREGLO DE IMPRESION
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(70,0,'Ver anexo '.$letras,0,0,'C');
			$pdf->ln(10);
			
			$pdf4=new FPDF();
			//Primera página
			$pdf4->AddPage('p',"Letter");
			//$pdf->SetLeftMargin(2);
			//Configuramos la fuente de la linea
			$pdf4->SetFont('Arial','',12);
			//Imprimimos la fecha de creacion
			$pdf4->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
			$pdf4->Ln(10);
			//Colocamos el siguiente punto de la cabecera
			$pdf4->Cell(190,0,'Anexo '.$letras,0,0,'C');
			$pdf4->ln(20);
			$pdf4->Output("procedimiento$a.pdf", 'F');
			$archivos[$indice] = "procedimiento$a.pdf";
			$indice++;
			$archivos[$indice] = $contenidoElemento[$a];
			$indice++;
			$letras++;
			
		} else{
			
			///IMPRIMIR CONTENIDO
			//$x = $pdf->GetX(); 
			//$y = $pdf->GetY(); 
			$pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
			//$pdf->MultiCell(180,6,''.iconv("UTF-8","ISO-8859-1",$contenidoElemento[$a]),'J');
			$pdf->ln(10);
			//echo "$contenidoElemento[$a]";
			
		}
		
	} else if($bandera > 1){
		
		if(substr($contenidoElemento[$a], -4) == ".pdf"){
			
			///METODO PARA AGREGAR UN PDF AL ARREGLO DE IMPRESION
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(70,0,'Ver anexo '.$letras,0,0,'C');
			$pdf->ln(10);
			
			$pdf4=new FPDF();
			//Primera página
			$pdf4->AddPage('p',"Letter");
			//$pdf->SetLeftMargin(2);
			//Configuramos la fuente de la linea
			$pdf4->SetFont('Arial','',12);
			//Imprimimos la fecha de creacion
			$pdf4->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
			$pdf4->Ln(10);
			//Colocamos el siguiente punto de la cabecera
			$pdf4->Cell(190,0,'Anexo '.$letras,0,0,'C');
			$pdf4->ln(20);
			$pdf4->Output("procedimiento$a.pdf", 'F');
			$archivos[$indice] = "procedimiento$a.pdf";
			$indice++;
			$archivos[$indice] = $contenidoElemento[$a];
			$indice++;
			$letras++;
			
		} else{
			
			///IMPRIMIR CONTENIDO
			//$x = $pdf->GetX(); 
			//$y = $pdf->GetY(); 
			$pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
			$pdf->ln(10);
			//echo "$contenidoElemento[$a]";	
			
		}
		
	}
}


//CAMBIOS
$pdf->Cell(100,0,'Control de Cambios',0,0,'L');
$pdf->ln(10);

$pdf->SetX(160);
	$pdf->Cell(10,5,utf8_decode('Versión'),0,0,'C');
	$pdf->SetX(130);
	$pdf->Cell(20,5,utf8_decode('Iniciales'),0,0,'C');
	$pdf->SetX(100);
	$pdf->Cell(30,5,utf8_decode('Fecha'),0,0,'C');
	$pdf->SetX(20);
	$pdf->MultiCell(80,5,utf8_decode('Descripción'),0); 
	$pdf->ln(8);
for($o= 1;$o<= count($version);$o++){
	
	
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(160);
	$pdf->Cell(10,5,utf8_decode($version[$o]),0,0,'C');
	$pdf->SetX(130);
	$pdf->Cell(20,5,utf8_decode($iniciales[$o]),0,0,'C');
	$pdf->SetX(100);
	$pdf->Cell(30,5,date($fechaVersion[$o]),0,0,'C');
	$pdf->SetX(20);
	$pdf->MultiCell(80,5,utf8_decode($cambioDesc[$o]),0); 
//	$pdf->SetMargins(5,25,5);  
	//$pdf->SetX(20);
	
	//$pdf->Cell(10,5,utf8_decode($version[$o]),1,'C');
	$pdf->Ln(10);

}


//SALIDA
$nombrePDF = 'Documento'.$codDocumento.'.pdf';
$pdf->Output("Documento0.pdf", 'F');
$archivos[0] = "Documento0.pdf";

$pdf =& new PDF();
$pdf->setFiles($archivos);
$pdf->concat();
$pdf->Output($nombrePDF, 'D');

unlink("Documento0.pdf");


?>