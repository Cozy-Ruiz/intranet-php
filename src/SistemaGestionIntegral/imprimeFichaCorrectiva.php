<?php error_reporting(0); ?>
<?php

require_once("../ConexionDBT.php");
require('../Librerias/fpdf/fpdf.php');
include('../Librerias/fpdi/fpdi.php');
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

$correctivaID = $_GET['id'];
$claveSolicitud = $_GET['clave'];


$nombrePDF ='Correctiva_'.$claveSolicitud.'.pdf';

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

$clave 			= "";
$titulo 		= "";
$descripcion	= "";
$ruta 			= "";
$status 		= "";
$grupo 			= "";
$ciudad 		= "";
//CUERPO CORRECTIVA
$s = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo, xt_descripcion, xt_ruta, xn_status,xt_grupo,xt_ciudad FROM SGI_Acciones_Preventivas_Correctivas 
						WHERE kp_accionesID = $correctivaID AND xt_tipo = 'E' ");

while($r = $s->fetchRow()){
	$clave = $r[0];
	$titulo = $r[1];
	if ( $r[2] != ""){
		$descripcion = $r[2];
	}
	//echo "".substr($descripcion, 0, 36).".<br>";
	if(substr($descripcion, 0, 36) == "Se vincula con la Acción Correctiva"){
		//echo "".substr($descripcion, 37, 11).".<br>";
		$codigoOrigen	=  substr($descripcion, 37, 11);
		$idOrigen 		= $INTRANET->getOne("SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoOrigen' AND xt_tipo = 'E' ");
		if($idOrigen  != ""){
			$descripcion = "Se vincula con la Acción Correctiva <b>".$codigoOrigen."</b> ".substr($descripcion, 48);
		}
	}
	if($r[3] != "" ){
		$ruta = $r[3];
	}
	
	$status = $r[4];
	$grupo = $r[5];
	$ciudad = $r[6];
	
	
} unset($r); unset($s);

///SEGUIMIENTO
$seguimientoID 	= "";
$fechaReg 		= "";
$codigoS 		= "";
$asignador 		= "";
$pdrID 			= "";

$pdrNombre 		= "";
$pdrApPate 		= "";
$pdrApMate 		= "";

$show			= "";

$s = $INTRANET->Execute("
SELECT SGU.kp_seguimientoID, SGU.xd_fechaRegistro, SGU.xt_codigoSeguimiento, EMP.xt_nombreCorto, SGU.kf_pdrID 
FROM SGI_Seguimientos SGU, SGI_Empleados EMP WHERE xt_tipoOrigen = 'E' AND kf_itemOrigenID = $correctivaID AND SGU.kf_asignadorID = EMP.kp_personalId ");

while($r = $s->fetchRow()){
	$seguimientoID 	= $r[0];
	$fechaReg 		= date('Y-m-d', strtotime($r[1]));
	$codigoS 		= $r[2];
	$asignador 		= $r[3];
	$pdrID 			= $r[4];
	
	$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId = $pdrID ");
	
	while($t = $u->fetchRow()){
		$pdrNombre = $t[0];
		$pdrApPate = $t[1];
		$pdrApMate = $t[2];
		
	} unset($u); unset($t);
	
} unset($r); unset($s);


///ETAPAS SEGUIMIENTO
if($seguimientoID != ""){
	
	$index = 1;
			
	$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta, xn_etapa, SUBSTRING_INDEX(xt_ruta, '.', -1) as RutaArchivo  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID ORDER BY xn_etapa ");
	
	while($r = $s->fetchRow()){
		
		if(($r[0] != "") || ($r[0] != NULL)){
			$fechaEtapa[$index] = date('Y-m-d', strtotime($r[0]));
			
		} else {
			$fechaEtapa[$index] = "";
			
		}
		$rutaArchivo[$index] = $r['5'];
		$tituloEtapa[$index] = $r[1];
		$contenidoEtapa[$index] = $r[2];
		$rutaEtapa[$index] = $r[3];
		$etapa[$index] = $r[4];
		
		if($tituloEtapa[$index] == "ASIGNAR"){
			$show 					= "Asignada";
			$tituloEtapa[$index] 	= "Asignada";
			
		} else if($tituloEtapa[$index] == "ANALISIS"){
			$show 					= "Análisis de la causa raíz";
			$tituloEtapa[$index] 	= "Análisis de la causa raíz";
			
		} else if($tituloEtapa[$index] == "DECISION"){
			$show 					= "Decisión";
			$tituloEtapa[$index] 	= "Decisión";
			
		} else if($tituloEtapa[$index] == "SOLICITUD"){
			$show 					= "Plan de acción";
			$tituloEtapa[$index] 	= "Plan de acción";
			
		} else if($tituloEtapa[$index] == "EVALUACION"){
			$show 					= "Terminada";
			$tituloEtapa[$index] 	= "Evaluación de la eficacia";
			
			//echo "".substr($contenidoEtapa[$index], -48, 36).".<br>";
			if(substr($contenidoEtapa[$index], -48, 36) == "Se vincula con la Acción Correctiva"){
				//echo "".substr($contenidoEtapa[$index], -11).".<br>";
				$codigoSegunda 			=  substr($contenidoEtapa[$index], -11);
				$idSegundaCorrectiva 	= $INTRANET->getOne("SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoSegunda' AND xt_tipo = 'E' ");
				if($idSegundaCorrectiva != ""){
					$contenidoEtapa[$index] = substr($contenidoEtapa[$index], 0, -11)."<a href='fichaCorrectiva.php?id=".$idSegundaCorrectiva."' id='iconosTexto' style='text-decoration:none'><b>".$codigoSegunda."</b></a>";
				}
			}
			
		}
		
		$index++;
		
	}unset($r); unset($s);
	
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
$pdf->Cell(190,0,utf8_decode(Acción).' Correctiva',0,0,'C');
$pdf->ln(25);

//se imprime la clave y fecha del boletin 
$pdf->SetFont('Arial','',10);
$pdf->Cell(5,0,'',0,0,'C');
$pdf->Cell(70,0,''.$clave.'',0,0,'C');
$pdf->Cell(175,0,'Estatus:'.utf8_decode($show).'',0,0,'C');
$pdf->ln(2);

$pdf->Cell(23,0,'',0,0,'C');
$pdf->Cell(180,0,'______________________________________________________________________________',0,0,'L');
$pdf->ln(5);

//despliega el titulo y la descripcion
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,0,'',0,0,'C');
$pdf->MultiCell(150,5,''.iconv("UTF-8","ISO-8859-1",$titulo),10,'J');
$pdf->ln(5);


if($descripcion != ""){
	
	//$x = $pdf->GetX(); 
	//$y = $pdf->GetY(); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,0,'',0,0,'C');
	$pdf->MultiCell(143,5, ''.iconv("UTF-8","ISO-8859-1",$descripcion),'J');
	$pdf->ln(10);
	
}

$indice = 1;
$archivos = NULL;
$archivos[0] = "";
$letras = "A";

if($ruta != ""){
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,0,'',0,0,'C');
	$pdf->Cell(70,0,'Ver anexo '.$letras,0,0,'L');
	$pdf->ln(10);
	
	
	$pdf2=new FPDF();
	//Primera página
	$pdf2->AddPage('p',"Letter");
	//$pdf->SetLeftMargin(2);
	//Configuramos la fuente de la linea
	$pdf2->SetFont('Arial','',12);
	//Imprimimos la fecha de creacion
	$pdf2->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
	$pdf2->Ln(10);
	//Colocamos el siguiente punto de la cabecera
	$pdf->Cell(10,0,'',0,0,'C');
	$pdf2->Cell(190,0,'Anexo '.$letras,0,0,'C');
	$pdf2->ln(20);
	$pdf2->Output("Correctiva2.pdf", 'F');
	
	$archivos[$indice] = "Correctiva2.pdf";
	$indice++;
	$archivos[$indice] = "PreventivaCorrectiva/".$ruta;
	$indice++;
	$letras++;
}
//PDR
if($pdrNombre != ""){
	
	//se imprime la clave y fecha del boletin 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,0,'',0,0,'C');
	$pdf->Cell(70,0,'Persona directamente responsable',0,0,'L');
	//$pdf->Cell(180,0,''.$show.'',0,0,'C');
	$pdf->ln(2);
	
	$pdf->Cell(23,0,'',0,0,'C');
	$pdf->Cell(180,0,'______________________________________________________________________________',0,0,'L');
	$pdf->ln(10);
	
	//despliega el titulo y la descripcion
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(28,0,'',0,0,'C');
	$pdf->Cell(70,0,''.iconv("UTF-8","ISO-8859-1",$pdrNombre).' '.iconv("UTF-8","ISO-8859-1",$pdrApPate).' '.iconv("UTF-8","ISO-8859-1",$pdrApMate).'',0,0,'L');
	$pdf->ln(15);
	
	
}

//SEGUIMIENTO
if($seguimientoID != ""){
	//se imprime la clave y fecha del boletin 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,0,'',0,0,'C');
	$pdf->Cell(70,0,'Seguimiento ('.$codigoS.')',0,0,'L');
	//$pdf->Cell(180,0,''.$show.'',0,0,'C');
	$pdf->ln(2);
	
	$pdf->Cell(23,0,'',0,0,'C');
	$pdf->Cell(180,0,'______________________________________________________________________________',0,0,'L');
	$pdf->ln(10);
	
	
	if(count($etapa) >= 1){
			
		for($a = 1; $a <= count($etapa); $a++){
			
		///ETAPA ASIGNADA
			if($etapa[$a] == 1){
				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(28,0,'',0,0,'C');
				$pdf->Cell(70,0,$fechaEtapa[$a].' '.iconv("UTF-8","ISO-8859-1",$tituloEtapa[$a]),0,0,'L');
				$pdf->ln(15);
				
				
			}
		///ETAPA ANALISIS DE CAUSA RAIZ
			if($etapa[$a] == 2){
				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(28,0,'',0,0,'C');
				$pdf->Cell(70,0,$fechaEtapa[$a].' '.iconv("UTF-8","ISO-8859-1",$tituloEtapa[$a]),0,0,'L');
				$pdf->ln(15);
				

					if($rutaEtapa[$a] != "" && $rutaArchivo[$a] == 'pdf'){
			
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(28,0,'',0,0,'C');
					$pdf->Cell(70,0,'Ver anexo '.$letras,0,0,'L');
					$pdf->ln(15);

				
					$pdf3=new FPDF();
					//Primera página
					$pdf3->AddPage('p',"Letter");
					//$pdf->SetLink($link);
					//$pdf->SetLeftMargin(2);
					//Configuramos la fuente de la linea
					$pdf3->SetFont('Arial','',12);
					//Imprimimos la fecha de creacion
					$pdf3->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
					$pdf3->Ln(10);
					//Colocamos el siguiente punto de la cabecera
					$pdf3->Cell(190,0,'Anexo '.$letras,0,0,'C');
					$pdf3->ln(20);
					$pdf3->Output("Correctiva3.pdf", 'F');
					$archivos[$indice] = "Correctiva3.pdf";
					$indice++;
					$archivos[$indice] = "SeguimientoEtapas/".$rutaEtapa[$a];
					$indice++;
					$letras++;
				}
			}
		///ETAPA DECISION
			if($etapa[$a] == 3){
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(28,0,'',0,0,'C');
				$pdf->Cell(70,0,$fechaEtapa[$a].' '.iconv("UTF-8","ISO-8859-1",$tituloEtapa[$a]).': '.iconv("UTF-8","ISO-8859-1",$contenidoEtapa[$a]),0,0,'L');
				$pdf->ln(15);
					
			}
		///PLAN DE ACCION
			if($etapa[$a] == 4){
				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(28,0,'',0,0,'C');
				$pdf->Cell(70,0,$fechaEtapa[$a].' '.iconv("UTF-8","ISO-8859-1",$tituloEtapa[$a]),0,0,'L');
				$pdf->ln(10);
				
				
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(35,0,'',0,0,'C');
				$pdf->Cell(65,0,'Actividad',0,0,'L');
				$pdf->Cell(30,0,'Solicitud',0,0,'L');
				$pdf->Cell(30,0,'Responsable',0,0,'L');
				$pdf->Cell(30,0,'Status',0,0,'L');
				$pdf->ln(2);
				
				$pdf->Cell(35,0,'',0,0,'C');
				$pdf->Cell(900,0,'_____________________________________________________________________________________________________',0,0,'L');
				$pdf->ln(7);
	
									
				$y = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID FROM SGI_Seguimiento_Etapas SSE, SGI_Quejas_Solicitudes SQS 
									WHERE SSE.kf_seguimientoID = $seguimientoID AND SSE.xt_titulo = 'SOLICITUD' AND SQS.kp_quejaSolicitudID = SSE.xt_contenido 
									ORDER BY SQS.xt_claveQuejaSolicitud ");
			
			while($x = $y->fetchRow()){
				///OBTENER DATOS SEGUIMIENTO SOLICITUD
		
				
				$s = $INTRANET->Execute("SELECT SQS.xt_titulo, SQS.xt_claveQuejaSolicitud FROM SGI_Quejas_Solicitudes SQS WHERE kp_quejaSolicitudID = $x[0] ");
				
				while($r = $s->fetchRow()){
					
					$tituloSol 	= $r[0];
					$claveSol	= $r[1];
					
					
					$u = $INTRANET->Execute("SELECT kp_seguimientoID, kf_pdrID from SGI_Seguimientos SGU WHERE SGU.kf_itemOrigenID = $x[0] AND SGU.xt_tipoOrigen = 'B' ");
					
					while($t = $u->fetchRow()){
						
						$segSolId = $t[0];
						$pdrSolId = $t[1];
						
					} unset($t); unset($u);
					
					if($segSolId != ""){
						
						$u = $INTRANET->Execute("SELECT SQSE.xt_estatus FROM SGI_Quejas_Solicitudes_Estatus SQSE WHERE SQSE.kf_seguimientoID = $segSolId ORDER BY SQSE.xn_numero ");
						
						while($t = $u->fetchRow()){
							
							$estatSol = $t[0];
							
							if($estatSol == "ABIERTA"){
								$estatSol = "Asignada";
								
							} else if($estatSol == "REVISION"){
								$estatSol = "Para Revisión";
								
							} else if($estatSol == "RECHAZADA"){
								$estatSol = "Rechazada";
								
							} else if($estatSol == "TERMINADA"){
								$estatSol = "Terminada";
								
							}
							
						} unset($t);
						
						$u = $INTRANET->Execute("SELECT SEM.xt_Nombre, SEM.xt_ApellidoPaterno FROM SGI_Empleados SEM WHERE SEM.kp_personalId = $pdrSolId ");
						
						while($t = $u->fetchRow()){
							
							$pdrSNombre = $t[0];
							$pdrSApPate = $t[1];

							
							//$pdf->SetFont('Arial','',8);
							$pdf->SetX(155);
							$pdf->Cell(40,5,utf8_decode($estatSol),0,0,'C');
							$pdf->SetX(130);
							$pdf->Cell(40,5,utf8_decode($pdrSNombre." ".$pdrSApPate),0,0,'C');
							$pdf->SetX(105); 
							$pdf->Cell(40,5,utf8_decode($claveSol),0,0,'L');
							$pdf->SetX(45);
							$pdf->MultiCell(50,5,utf8_decode($tituloSol),0);  
							$pdf->Ln(3);	
							
						} 
						
					}

				} unset($r); unset($s);
				
			}	
				$pdf->Cell(35,0,'',0,0,'C');
				$pdf->Cell(900,0,'_____________________________________________________________________________________________________',0,0,'L');
				$pdf->ln(10);
				
			}
			
				
		///EVALUACION
			if($tituloEtapa[$a] == "Evaluación de la eficacia"){
				
				$cal = "";
				$cal = $INTRANET->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $correctivaID AND xt_tipo = 'E'");
				if($cal == 0){
					$cal = "No eficaz";
				} else if($cal == 1){
					$cal = "Eficaz";
				}
				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(28,0,'',0,0,'C');
				$pdf->Cell(70,0,$fechaEtapa[$a].' '.utf8_decode(Evaluación).' de la eficacia:'.$cal,0,0,'L');
				$pdf->ln(8);
				
				
				$x = $pdf->GetX(); 
				$y = $pdf->GetY(); 
				
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(35,0,'',0,0,'C');
				$pdf->MultiCell(140,6, iconv("UTF-8","ISO-8859-1",$contenidoEtapa[count($etapa)]),'J');
				$pdf->ln(15);
				
				
				if($rutaEtapa[$a] != ""){
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(15,0,'',0,0,'C');
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
					$pdf4->Output("Correctiva4.pdf", 'F');
					$archivos[$indice] = "Correctiva4.pdf";
					$indice++;
					$archivos[$indice] = "SeguimientoEtapas/".$rutaEtapa[$a];
					$indice++;
					$letras++;
				}
			}
		}
	}
}



$pdf->Output("Correctiva0.pdf", 'F');
//$pdf->Output();
$archivos[0] = "Correctiva0.pdf";


$pdf =& new PDF();
$pdf->setFiles($archivos);
$pdf->concat();
$pdf->Output($nombrePDF, 'D');

unlink("Correctiva0.pdf");
?>