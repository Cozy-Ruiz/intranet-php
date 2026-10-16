<?php

require_once("conexionMasterDB.php");
require('../Librerias/fpdf/fpdf.php');

$referencia = $_GET['referencia'];

$s= $MASTER_GE->Execute("SELECT kp_pedimento, xd_fechaPago, xn_tipoOperacion,xt_tramiteAduanero,xn_aduana FROM MASTER_PEDIMENTOS WHERE xt_referencia='$referencia'");
while($r=$s->fetchRow()){
	$pedimento=$r[0];
	$fecha=date("Y/m/d",strtotime($r[1]));
	if($r[2] == 1){
		$tipoOperacion = "IMP";
	}else if($r[2] == 2){
		$tipoOperacion = "EXP";
	}
	
	$clave=$r[3];
	$aduana=$r[4];
	
}

$nombrePDF = $pedimento.'_Cedula.pdf';

//Consulta para saber que archivos existen
$s = $MASTER_GE->Execute("select xt_tipoImagen from MASTER_IMAGENES_PEDIMENTOS where xt_referencia = '$referencia' ");
$index = 0;
while($r = $s->FetchRow()){
 $tipoImagen[$index] = $r[0];

 $index++;
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


$pdf=new FPDF();
//Primera página
$pdf->AddPage('p',"Letter");
//$pdf->SetLeftMargin(2);
//Configuramos la fuente de la linea
$pdf->SetFont('Arial','',10);
//Imprimimos la fecha de creacion
$pdf->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
$pdf->Ln(10);
//Incorporamos el logo de Livingston como primera parte de la cabecera
$pdf->Image('Imagenes/logo_livingston.jpg' , 85 ,22, 40 , 15,'JPG');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
//Colocamos el siguiente punto de la cabecera
$pdf->Cell(190,0,'Livingston Internacional',0,0,'C');
$pdf->ln(10);

//Tabla1 color
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->SetFont('Arial','B',10);
//Cabecera
$pdf->Cell(40,8,'PEDIMENTO',1,0,'C',1);
$pdf->Cell(30,8,'FECHA',1,0,'C',1);
$pdf->Cell(40,8,'REGIMEN',1,0,'C',1);
$pdf->Cell(40,8,'CLAVE',1,0,'C',1);
$pdf->Cell(40,8,'ADUANA',1,0,'C',1);

//Configuramos la primer parte de la tabla1
$pdf->Ln();
//Restauración de colores y fuentes
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10);

$fill=false;

$pdf->Cell(40,6,$pedimento,1,0,'C',$fill);
//$pdf->Cell(40,10,$pedimento,0,0,'C');
$pdf->Cell(30,6,$fecha,1,0,'C',$fill);
//$pdf->Cell(30,10,$fecha,0,0,'C');
$pdf->Cell(40,6,$tipoOperacion,1,0,'C',$fill);
//$pdf->Cell(40,10,$tipoOperacion,0,0,'C');
$pdf->Cell(40,6,$clave,1,0,'C',$fill);
//$pdf->Cell(40,10,$clave,0,0,'C');
$pdf->Cell(40,6,$aduana,1,0,'C',$fill);
//$pdf->Cell(40,10,$aduana,0,0,'C');
$pdf->ln();
//HEADER CON COLOR
$pdf->SetFillColor(54,96,146);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->SetFont('Arial','B',10);
$fill=true;
$pdf->Cell(10,8,'',1,0,'C',$fill);
$pdf->Cell(80,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'SI',1,0,'C',$fill);
$pdf->Cell(12,8,'NO',1,0,'C',$fill);
$pdf->Cell(12,8,'N/A',1,0,'C',$fill);
$pdf->Cell(64,8,utf8_decode(OBSERVACIÓN),1,0,'C',$fill);
$pdf->ln();
//Celdas
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->SetFont('Arial','',10);
$fill=false;

$pdf->Cell(10,8,'1',1,0,'C',$fill);
$pdf->Cell(80,8,'Cuenta de Gastos del Agente Aduanal',1,0,'L',$fill);

$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "FACTURA"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'2',1,0,'C',$fill);
$pdf->Cell(80,8,'Pedimento/copia del  importador/ exportador',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "FACTURA"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'3',1,0,'C',$fill);
$pdf->Cell(80,8,'Comprobantes fiscales',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "COMPROBANTES SUBTOTAL A"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'4',1,0,'C',$fill);
$pdf->Cell(80,8,'Instrucciones de '.utf8_decode(importación).'/ '.utf8_decode(exportación).'',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "CARTAS ACLARATORIAS" || $tipoImagen[$a] == "TRADUCCIÓN FACTURAS"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'5',1,0,'C',$fill);
$pdf->Cell(80,8,'Factura Comercial',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "FACTURA PROVEEDOR"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$cadena="Conocimiento de Embarque (BL)/ Guía Aérea o terrestre";
$pdf->Cell(10,12,'6',1,0,'C',$fill);
$y = $pdf->GetY();
$pdf->MultiCell(80,6,urldecode(em($cadena)),1,'L',$fill); 
$pdf->SetXY(100,$y);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "GUIA"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,12,'X',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,12,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'7',1,0,'C',$fill);
$pdf->Cell(80,8,'Carta Protesta  - Factura 3.1.5 RCGMCE',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'8',1,0,'C',$fill);
$pdf->Cell(80,8,'Lista de empaque',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$cadena="Documento  que determine la procedencia y el origen de las mercancías";
$pdf->Cell(10,12,'9',1,0,'C',$fill);
$y = $pdf->GetY();
$pdf->MultiCell(80,6,urldecode(em($cadena)),1,'L',$fill); 
$pdf->SetXY(100,$y);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "CERTIFICADOS DE ORIGEN"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,12,'X',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	$pdf->Cell(12,12,'',1,0,'C',$fill);
	
}
$pdf->Cell(64,12,'',1,0,'C',$fill);
$pdf->ln();

$cadena = "Documentos que comprueben el cumplimiento de Regulaciones y Restricciones No Arancelarias.(Carta excención de NOM, carta aclaratoria, etc)";
$pdf->Cell(10,24,'10',1,0,'C',$fill);
$y = $pdf->GetY();
$pdf->MultiCell(80,6,urldecode(em($cadena)),1,'L',$fill); 
$pdf->SetXY(100,$y);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "PERMISOS"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,24,'X',1,0,'C',$fill);
	$pdf->Cell(12,24,'',1,0,'C',$fill);
	$pdf->Cell(12,24,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,24,'',1,0,'C',$fill);
	$pdf->Cell(12,24,'',1,0,'C',$fill);
	$pdf->Cell(12,24,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,24,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'11',1,0,'C',$fill);
$pdf->Cell(80,8,'Permiso Previo',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'12',1,0,'C',$fill);
$pdf->Cell(80,8,'Certificado de peso/ volumen',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$cadena ="Pedimento de Rectificación";
$pdf->Cell(10,8,'13',1,0,'C',$fill);
$pdf->Cell(80,8,urldecode(em($cadena)),1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "PEDIMENTO RECTIFICADO"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'14',1,0,'C',$fill);
$pdf->Cell(80,8,'Pedimento(s) de refencia o descargo',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'15',1,0,'C',$fill);
$pdf->Cell(80,8,'Desgloce de incrementables',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'16',1,0,'C',$fill);
$pdf->Cell(80,8,'COVES',1,0,'L',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(12,8,'',1,0,'C',$fill);
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$cadena="Manifestación de valor";
$pdf->Cell(10,8,'17',1,0,'C',$fill);
$pdf->Cell(80,8,urldecode(em($cadena)),1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "MANIFESTACION DE VALOR"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$cadena="Hoja de cálculo";
$pdf->Cell(10,8,'18',1,0,'C',$fill);
$pdf->Cell(80,8,urldecode(em($cadena)),1,0,'L',$fill);

$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "HOJA DE CALCULO"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}
$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'19',1,0,'C',$fill);
$pdf->Cell(80,8,'Comprobante de entrega en almacen',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "ACUSES DE RECIBO"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();

$pdf->Cell(10,8,'20',1,0,'C',$fill);
$pdf->Cell(80,8,'Otros Anexos',1,0,'L',$fill);
$bandera = 0;

for($a=0;$a<count($tipoImagen);$a++){
	if($tipoImagen[$a] == "OTROS ANEXOS"){
		$bandera = 1;
		break;
	}
}
if($bandera == 1){
	$pdf->Cell(12,8,'X',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
} else{
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	$pdf->Cell(12,8,'',1,0,'C',$fill);
	
}

$pdf->Cell(64,8,'',1,0,'C',$fill);
$pdf->ln();
$pdf->Output($nombrePDF,'D');



?>