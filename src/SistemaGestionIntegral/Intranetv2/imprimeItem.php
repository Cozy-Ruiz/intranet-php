<?php

require_once("../ConexionDBT.php");
require('../Librerias/fpdf/fpdf.php');
include('../Librerias/fpdi/fpdi.php');
//include('../Librerias/fpdi/fpdf_tpl.php');
require_once('../Librerias/tcpdf/tcpdf.php');

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

$idItem = $_GET['id'];

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

///CURPO DEL ITEM
$s = $INTRANET->Execute("SELECT kp_itemID, xt_nombre, xd_fechaCreacion, xt_codigo, xt_ciudad, xt_grupo, xt_area, xt_tipo, xn_consecutivo 
						 FROM SGI_Item WHERE kp_itemID = $idItem ");

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

///REFERENCIAS ISO
$indice = 1;
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
	
} unset($r); unset($i);

	
$fechaActualizacion 	= $INTRANET->getOne("SELECT MAX(xd_fecha) FROM SGI_Control_Cambios WHERE kf_itemID = $idItem");

$numeroVersion 	= $INTRANET->getOne("SELECT MAX(xn_numero) FROM SGI_Control_Cambios WHERE kf_itemID = $idItem");

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
$pdf->Cell(190,0,''.iconv("UTF-8","ISO-8859-1",$nombre).' '.iconv("UTF-8","ISO-8859-1",$codigo),0,0,'C');
$pdf->Ln(7);


$pdf->Cell(180,0,'Copia no controlada',0,0,'C');
$pdf->ln(20);

//CERTIFICACIONES
$pdf->Cell(100,0,'Certificaciones',0,0,'L');
$pdf->Ln(10);
if(count($iso) >= 1){
 
	$isos = "ISO: ";
	
	for($i = 1; $i <= count($iso); $i++){
	
		$isos = $isos.$iso[$i]."; ";
	
	} unset($i);
	
	$isos = substr($isos, 0, -2);
	
	$pdf->Cell(100,0,''.$isos,0,0,'L');
	$pdf->Ln(10);

}
if(count($nmx) >= 1){
 
 	$nmxs = "NMX: ";
 
	for($i = 1; $i <= count($nmx); $i++){
	
		$nmxs = $nmxs.$nmx[$i]."; ";
	
	} unset($i);
	
	$nmxs = substr($nmxs, 0, -2);
	
	$pdf->Cell(100,0,''.$nmxs,0,0,'L');
	$pdf->Ln(10);

}
if(count($neec) >= 1){
 
	$neecs = "NEEC: ";
	
	for($i = 1; $i <= count($neec); $i++){
	
		$neecs = $neecs.$neec[$i]."; ";
	
	} unset($i);
	
	$neecs = substr($neecs, 0, -2);
	
	$pdf->Cell(100,0,''.$neecs,0,0,'L');
	$pdf->Ln(10);

}

$pdf->ln(20);

//REFERENCIAS
$pdf->Cell(100,0,'Referencias',0,0,'L');
$pdf->ln(10);

if(count($docRef) >= 1){
 
	$neecs = "";
	
	for($i = 1; $i <= count($docRef); $i++){
	
		//$docs = $docs.$docRef[$i];
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(150,0,''.iconv("UTF-8","ISO-8859-1",$docRef[$i]),0,0,'L');
		$pdf->ln(5);
	
	} unset($i);
	
}
$pdf->ln(20);
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
	
	if($tipoElemento[$a] == "DESARROLLO"){
		
		$bandera++;
		
	}
	
	if($bandera == 0){
		
		///IMPRIMIR TITULO
			$pdf->Cell(100,0,''.to_roman($numeroElemento[$a]).'. '.$tipoElemento[$a],0,0,'L');
			$pdf->ln(10);
			//echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
			
		///IMPRIMIR CONTENIDO
			//$x = $pdf->GetX(); 
			//$y = $pdf->GetY(); 
			$pdf->MultiCell(180,6,''.iconv("UTF-8","ISO-8859-1",$contenidoElemento[$a]),'J');
			$pdf->ln(10);
			//echo "$contenidoElemento[$a]";
			
		
	} else if($bandera == 1){
		
		///IMPRIMIR TITULO
			$pdf->Cell(100,0,''.to_roman($numeroElemento[$a]).'. '.$tipoElemento[$a],0,0,'L');
			$pdf->ln(10);
			//echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
				
		
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
			$pdf->MultiCell(180,6,''.$contenidoElemento[$a],'J');
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
	/*
	function TablaBasica($header){
		//Cabecera
		foreach($header as $col)
		$this->Cell(40,7,$col,1);
		$this->Ln();
	   
		  $this->Cell(40,5,"Version",1);
		  $this->Cell(40,5,"Descripcion",1);
		  $this->Cell(40,5,"Fecha",1);
		  $this->Cell(40,5,"Iniciales",1);
		  $this->Ln();
		  $this->Cell(40,5,''.$version[$o].'',1);
		  $this->Cell(40,5,''.iconv("UTF-8","ISO-8859-1",$cambioDesc[$o]).'',1);
		  $this->Cell(40,5,''.$fechaVersion[$o].'',1);
		  $this->Cell(40,5,''.$iniciales[$o].'',1);
	}
	*/
	//$x = $pdf->GetX(); 
	//$y = $pdf->GetY(); */
	//$pdf->SetFont('Arial','',7);
	//$pdf->Cell(0,0,'',0,0,'C');
	
	
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
$nombrePDF = 'Procedimiento_'.$codigo.'.pdf';
$pdf->Output("Procedimiento0.pdf", 'F');
$archivos[0] = "Procedimiento0.pdf";

$pdf =& new PDF();
$pdf->setFiles($archivos);
$pdf->concat();
$pdf->Output($nombrePDF, 'D');

unlink("Procedimiento0.pdf");


?>