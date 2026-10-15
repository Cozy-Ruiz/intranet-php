<?php error_reporting(0); ?>
<?php
require('../../Librerias/fpdf/fpdf.php');
date_default_timezone_set('America/Mexico_City');

class PDF extends FPDF{

	function Footer(){ 
			
	}
}

function acuseQueja($codigo,$nombre,$fechaRecepcion,$nombreRecibe){
	$pdf=new PDF('P','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();

			$pdf->SetFont('Arial','',15);
			$pdf->Cell(40,20);
			$pdf->Image('../../Imagenes/GEA.png' , 55 ,22, 50 , 30,'PNG');
			$pdf->Image('../../Imagenes/NE.png' , 105 ,22, 50 , 30,'PNG');
			$pdf->ln(45);
			$pdf->SetFont('Arial','',16);
			$pdf->Cell(190,10,"ACUSE DE RECIBO DE QUEJA",0,1,"C");
			$pdf->ln();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(140,3);
			$pdf->Cell(30,3,"GE-CC-001",0,1,"R");
			$pdf->Cell(140,3);
			$pdf->Cell(30,3,utf8_decode("Versión 2"),0,1,"R");
			$pdf->ln(10);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,7);
			$pdf->Cell(150,7,utf8_decode("Queja número: $codigo."),0,1,"L");
			$pdf->Cell(20,7);
			$pdf->Cell(150,7,utf8_decode("Estimado (a): $nombre."),0,1,"L");
			$pdf->Cell(20,7);
			$pdf->Cell(150,7,utf8_decode("Su queja ha sido recibida el día $fechaRecepcion."),0,1,"L");
			$pdf->ln(3);
			$pdf->Cell(20,7);
			$pdf->MultiCell(150,4,utf8_decode("En un plazo no mayor a 48 horas, recibirá uno o varios correos por parte de nuestro departamento de calidad para darle respuesta."),0,"J");
			$pdf->ln(3);
			$pdf->Cell(20,7);
			$pdf->Cell(68,4,utf8_decode("Para efectos de seguimiento, favor de enviar correo a:"),0,1,"J");
			$pdf->SetTextColor(0,162,232);
			$pdf->ln(-4);
			$pdf->Cell(88,7);
			$pdf->Cell(35,4," calidad@escalante.com.mx, ",0,1,"L");
			$pdf->ln(-4);
			$pdf->Cell(123,7);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(47,4,utf8_decode("  incluyendo número de queja en el"),0,1,"L");
			$pdf->ln(0);
			$pdf->Cell(20,4);
			$pdf->Cell(170,4,utf8_decode("campo del asunto."),0,1,"L");
			$pdf->ln(3);
			$pdf->Cell(20,7);
			$pdf->MultiCell(150,4,utf8_decode("Finalmente, Usted está en su derecho de notificar sobre quejas a nuestro Organismo Certificador en el cumplimiento con la norma mexicana NMX-R-026-SCFI-2009, en la siguiente página:"),0,"J");
			$pdf->ln(3);
			$pdf->Cell(20,7);
			$pdf->Write(5,'www.anace.org.mx','www.anace.org.mx');
			$pdf->ln(7);
			$pdf->Cell(20,7);
			$pdf->MultiCell(150,4,utf8_decode("El trámite de atención de su queja será conforme a la norma mexicana NMX-R-026-SCFI-2009, en su inciso 5.2.2.12, el cual establece los siguientes pasos:"),0,"J");
			$pdf->ln(3);
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("a) Recepción."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("b) Acuse de recibo."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("d) Tratamiento."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("e) Evaluación inicial."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("f) Respuesta."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("g) Comunicación de la decisión."),0,1,"J");
			$pdf->Cell(20,4);
			$pdf->Cell(150,4,utf8_decode("h) Cierre de la queja."),0,1,"J");
			$pdf->ln();
			$pdf->Cell(20,7);
			$pdf->Cell(150,7,utf8_decode("Atentamente."),0,1,"J");
			$pdf->Cell(20,7);
			$pdf->SetFont('','U');
			$pdf->Cell(150,7,utf8_decode($nombreRecibe),0,1,"J");
			$pdf->Output("Acuse_de_Queja_".$codigo.".pdf","D");
}
?>