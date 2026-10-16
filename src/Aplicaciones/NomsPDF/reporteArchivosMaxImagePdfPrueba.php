<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = "reporteArchivosMaxImagePdfPrueba.php";
require_once("conexionMasterDB.php");
require('../Librerias/fpdf/fpdf.php');
//require_once("compruebaUsuario.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$referencia = $_GET['referencia'];

class PDF extends FPDF{
	//Cabecera de Pagina
	function Header(){
		$this->SetFont('Arial','',10);
		$this->Cell(190,10,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
		$this->Ln();
		$this->Image('Imagenes/logo_livingston.PNG',100,200,+300);
		$this->Ln();
		$this->SetLineWidth(.5);
		$this->Line(10,20, 190,20);
		//Tipo de Letra
		$this->SetFont('Arial','B',13);
		//Movernos a la derecha
		$this->Cell(1);
		//Titulo
		$this->Cell(190,10,'Checklist de documentos',0,0,'C');
		//salto de linea y cambio de Frame
		$this->Ln();
		$this->SetLineWidth(.5);
		$this->Line(10,30, 190,30);
		//salto de liena 
		$this->Ln(15);
	}	
}

$s = $MASTER_GE->Execute("select kp_pedimento, xn_tipoOperacion, xt_tramiteAduanero from MASTER_PEDIMENTOS where xt_Referencia = '$referencia' ");
								
while($r = $s->FetchRow()){
	$pedimento = $r[0];

	if($r[1] == 1){
		$tipoOperacion = "IMP";
	}else if($r[1] == 2){
		$tipoOperacion = "EXP";
	}
	
	$tramiteAduanero = $r[2];
}

$s = $MASTER_GE->Execute("select xt_tipoImagen, xt_ruta from MASTER_IMAGENES_PEDIMENTOS where xt_referencia = '$referencia' ");
$index = 0;
while($r = $s->FetchRow()){
	$tipoImagen[$index] = $r[0];
	$rutaImagen[$index] = $r[1];
	$index++;
}

$nombrePDF = $pedimento.'_Cedula.pdf';

//Cracion del Objeto
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,10,'PEDIMENTO',0,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,10,'REFERENCIA',0,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,10,utf8_decode(CóDIGO),0,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,10,'TIPO',0,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','',11);
$pdf->Cell(45,10,$pedimento,0,0,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(45,10,$referencia,0,0,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(45,10,$tramiteAduanero,0,0,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(45,10,$tipoOperacion,0,0,'C');
$pdf->ln();
$pdf->ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(20,10,'',0,0,'L');
$pdf->Cell(50,10,'Lista de documentos del expediente:',0,0,'C');
for($a = 0; $a<count($tipoImagen); $a++){
	$pdf->ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(50,10,($a + 1).".- ".$tipoImagen[$a],0,0,'L');
}
/*
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,10,'Operations from:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(75,10,$operations,0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25,10,'Prepared by:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(50,10,$responsable,0,0,'L');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(12,10,'Date:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(25,10,$fechaRelacionSemanal,0,0,'L');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,10,'FIRST AUDIT:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(30,10,'Pass         Fail',0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25,10,'Audited by:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(50,10,'',0,0,'L');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(12,10,'Date:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(25,10,'',0,0,'L');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,10,'SECOND AUDIT:',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(30,10,'Pass         Fail',0,0,'L');
$pdf->ln(15);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,6,'AMOUNT MXP',1,0,'C');
$pdf->Cell(40,6,'NUMBER',1,0,'C');
$pdf->Cell(100,6,'EXPENSES DESCRIPTION',1,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Derechos de importacion / exportacion',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Flete',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Almacenaje y maniobras en almacen fiscalizado',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Desconsolidacion',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Custodia',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Montacarga',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Comisiones bancarias',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Multas',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Reexpedicion',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Etiquetado',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Otros',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Servicios complementarios',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Documentacion aduanal (fotocopias,fax)',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Entrega a domicilio',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Etiquetado',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Servicios extraordinarios',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Demoras',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Honorarios al 0.300% sobre la base',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Financiamiento',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Mensajeria',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Gastos de despacho',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Base I.V.A.',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'Recibos',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(40,6,'',1,0,'C');
$pdf->Cell(100,6,'',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,number_format($resultadoGranTotalRadar,2),1,0,'C');
$pdf->Cell(40,10,'TOTAL MXP',1,0,'C');
$pdf->Cell(100,10,'Detalle de pago',0,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'',0,0,'C');
$pdf->Cell(40,5,'',0,0,'C');
$pdf->Cell(70,5,'Gastos que generan IVA:',0,0,'R');
$pdf->Cell(30,5,number_format($resultadoSubTotalB,2),0,0,'R');
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'No. Consecutivo:',0,0,'L');
$pdf->Cell(40,5,$codigoFull,0,0,'L');
$pdf->Cell(70,5,'IVA generado:',0,0,'R');
$pdf->Cell(30,5,number_format($resultadoIvaCuentaGastos,2),0,0,'R');
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'',0,0,'L');
$pdf->Cell(40,5,'',0,0,'L');
$pdf->Cell(70,5,'Total:',0,0,'R');
$pdf->Cell(30,5,number_format($resultadoGranTotalRadar,2),0,0,'R');
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'Centro de Costos ESD:',0,0,'L');
$pdf->Cell(40,5,'1401-2124-113070-67240',0,0,'L');
*/

$pdf->Output($nombrePDF,'D');

?>