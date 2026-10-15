<?php

require_once("../../ConexionDBT.php");
require('../../Librerias/fpdf/fpdf.php');
include('../../Librerias/fpdi/fpdi.php');
require_once("../../ConexionIntranet2.php");


//require_once("fichaBoletin.php");

class concat_pdf extends FPDI {

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
				 $this->useTemplate($tplidx);
			}
		}
	}
}

$boletinID = $_GET['id'];

$s= $INTRANETV2-> Execute("SELECT xd_fecha, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Boletines WHERE xt_claveBoletin = '$boletinID'");

while($r = $s->fetchRow($s)){
	$fecha 			= $r[0];
	$titulo 		= $r[1];
	$descripcion 	= $r[2];
	$ruta 			= $r[3];
	

} unset($r); unset($s);



$nombrePDF ='Boletin_'.$boletinID.'.pdf';

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
$pdf->SetFont('Arial','',12);
//Imprimimos la fecha de creacion
$pdf->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
$pdf->Ln(10);
//Colocamos el siguiente punto de la cabecera
$pdf->Cell(190,0,'Boletin',0,0,'C');
$pdf->ln(20);

//se imprime la clave y fecha del boletin 
$pdf->SetFont('Arial','',10);
$pdf->Cell(70,0,''.$boletinID.'',0,0,'C');
$pdf->Cell(180,0,''.$fecha.'',0,0,'C');
$pdf->ln(15);

//despliega el titulo y la descripcion
$pdf->SetFont('Arial','',10);
$pdf->Cell(70,0,''.$titulo.'',0,0,'C');
$pdf->ln(10);


$x = $pdf->GetX(); 
$y = $pdf->GetY(); 

$pdf->MultiCell(200,6, ''.$descripcion,'C', false);

$pdf->ln(10);

$pdf->Output("cuerpoBoletin1.pdf", 'F');

$archivos = NULL;
$archivos[0] = "cuerpoBoletin1.pdf";

$indice = 1;

$consulta = $INTRANETV2->Execute("SELECT xt_ruta FROM SGI_Boletines WHERE xt_claveBoletin = '$boletinID'");
while($r=$consulta->FetchRow()){
	$tempo = "../Boletines/".trim($r[0]);
	
	if(in_array($tempo, $archivos) != true){
		$archivos[$indice] = $tempo;
		$indice++;
	}
}


$pdf =& new concat_pdf();
$pdf->setFiles($archivos);
$pdf->concat();
$pdf->Output($nombrePDF, 'D');

unlink("cuerpoBoletin1.pdf");
?>