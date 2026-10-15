<?php error_reporting(0); ?>
<?php

require_once("../../ConexionDBT.php");
require('../../Librerias/fpdf/fpdf.php');
include('../../Librerias/fpdi/fpdi.php');
//require_once("MailenvioPersonal.php");

error_reporting(0);

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

$IDpersonal= $_GET['ID'];
$nombrePersonal = $_GET['nombre'];

$nombrePDF ='FichaPersonal_'.$nombrePersonal.'.pdf';

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

///CUERPO PREVENTIVA
$s= $INTRANET->execute("SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xn_Foto,kf_usuario,SUBSTRING_INDEX(xn_Foto, '.', -1) FROM IntranetGEA.SGI_Empleados WHERE kp_personalId=$IDpersonal");
	
	while($r = $s->fetchRow()){
		$NumPersonal = $r[0];
		$nombre= $r[1];
		$apellidoP = $r[2];
		$apellidoM = $r[3];
		$foto = $r[4];
		$usuario = $r[5];
		$extensionImagen = $r[6];
		
	} unset($r);unset($s);
	
$nombreUsuario = $nombre.' '.$apellidoP.' '.$apellidoM;
///Sistemas

$pdf=new FPDF();
//Primera página
$pdf->AddPage('p',"Letter");
//$pdf->SetLeftMargin(2);
//Configuramos la fuente de la linea
$pdf->SetFont('Arial','',12);
//Imprimimos la fecha de creacion
$pdf->Cell(190,0,'Fecha de '.utf8_decode(generación).': '.date("d/m/Y"),0,0,'R');
$pdf->Ln(20);
//Colocamos el siguiente punto de la cabecera
$pdf->SetFont('Arial','',15);
//$pdf->Cell(70,0,'',0,0,'C');
$pdf->Cell(200,0,'Ficha Personal',0,0,'C');
$pdf->ln(20);

$pdf->SetFont('Arial','',10);
if($extensionImagen != '' && $foto != 'FILES/sinFoto.jpg'){
	$pdf->Image($foto , 92 ,40, 35 , 25,''.$extensionImagen.'','D');
	$pdf->ln(20);
}

//imprime nombre del Personal
$pdf->SetFont('Arial','',10);
$pdf->Cell(200,10,''.utf8_decode('Nombre:'.' '.$nombre.' '.$apellidoP.' '.$apellidoM).'',0,0,'C');
$pdf->ln(30);

//imprime el texto de Acceso a Sistemas
$pdf->SetFont('Arial','',15);
//$pdf->Cell(70,0,'',0,0,'C');
$pdf->Cell(200,0,'Acesso a Sistemas',0,0,'C');
$pdf->ln(15);

	
  $s = $INTRANET->Execute("SELECT DISTINCT xt_sistema FROM PERFILES.SISTEMAS WHERe xt_usuario ='$usuario'");
  while($r = $s->fetchRow()){
	  
	  $sistema = $r[0];
	  
//if(){
	  
	 //imprime los sistemas de accesos del personal 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,0,'',0,0,'R');
	$pdf->Cell(120,0,''.$sistema.'',0,0,'L');	
	
  
	$y = $INTRANET->Execute("SELECT distinct xt_estatus FROM PERFILES.SISTEMAS WHERE xt_usuario = '$usuario' AND xt_sistema = '$sistema' ");	
	while($t = $y->fetchRow()){
		
		$estatus = $t[0];
	
	//Imprime los estatus de cada Sistema
	$pdf->SetFont('Arial','',10);	
	$pdf->Cell(120,0,''.$estatus.'',0,0,'L');
	$pdf->ln(15);	
	
	//imprime encabezado de alta y baja de los sistemas
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,'Tipo',0,0,'L');
	$pdf->Cell(30,0,'Fecha',0,0,'L');
	$pdf->Cell(30,0,'Solicitud',0,0,'L');
	$pdf->Cell(30,0,'Estatus',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(7);

	$u = $INTRANET->Execute("SELECT distinct xt_tipo, xd_fecha, xt_codigoSolicitud, xt_ruta FROM PERFILES.SOLICITUD_SISTEMAS WHERE xt_usuario = '$usuario' and xt_sistema = '$sistema' ");
		while($x = $u->fetchRow()){
			
			$tipoRegistro = $x[0];
			$fechaRegistro= $x[1];
			$codigoRegistro= $x[2];
			
	//imprime alta y baja de los sistemas de acceso
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,''.$tipoRegistro.'',0,0,'L');
	$pdf->Cell(30,0,''.$fechaRegistro.'',0,0,'L');
	$pdf->Cell(30,0,''.$codigoRegistro.'',0,0,'L');
	if($tipoRegistro == 'BAJA'){
	$pdf->Cell(30,0,'Desactivado',0,0,'L');
	}else if($tipoRegistro == 'ALTA'){
	$pdf->Cell(30,0,'Activado',0,0,'L');
	}
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
   }
   	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(7);

   	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(10);
  }

}


//imprime el texto de Resguardo
$pdf->SetFont('Arial','',15);
//$pdf->Cell(70,0,'',0,0,'C');
$pdf->Cell(200,0,'Resguardo',0,0,'C');
$pdf->ln(15);


$articulos = $INTRANET->getArray("SELECT xt_articulo, xt_descripcion,xd_fechaAsignacion, xd_fechaRecepcion, xd_fechaEntrega, xd_fechaAceptacion FROM intranet2.sgi_resguardo_articulos WHERE xt_usuario = '$usuario' ");	

foreach($articulos as $articulo){

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(30,0,'',0,0,'R');
  $pdf->Cell(120,0,utf8_decode($articulo['xt_articulo']).' - '.utf8_decode($articulo['xt_descripcion']),0,0,'L');	

  //$pdf->SetFont('Arial','',10);	
  //$pdf->Cell(120,0,''.$articulo['xt_descripcion'].'',0,0,'L');
  $pdf->ln(15);	

  //imprime fechas
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,'Solicitud',0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Recepción),0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Devolución),0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Aceptación),0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(7);

  $pdf->SetFont('Arial','',6);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,$articulo['xd_fechaAsignacion'],0,0,'L');
	$pdf->Cell(30,0,$articulo['xd_fechaRecepcion'],0,0,'L');
	$pdf->Cell(30,0,$articulo['xd_fechaEntrega'],0,0,'L');
	$pdf->Cell(30,0,$articulo['xd_fechaAceptacion'],0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
  
  $pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(15);
}


$articulos = $INTRANET->getArray("SELECT xt_numeroLlave, xt_lugarUso, xd_fecha FROM intranet2.sgi_control_llaves WHERE xt_usuario = '$usuario' ");	

foreach($articulos as $articulo){

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(30,0,'',0,0,'R');
  $pdf->Cell(120,0,utf8_decode($articulo['xt_numeroLlave']).' - '.utf8_decode($articulo['xt_lugarUso']),0,0,'L');	

  //$pdf->SetFont('Arial','',10);	
  //$pdf->Cell(120,0,''.$articulo['xt_descripcion'].'',0,0,'L');
  $pdf->ln(15);	

  //imprime fechas
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,'Solicitud',0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Recepción),0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Devolución),0,0,'L');
	$pdf->Cell(30,0,utf8_decode(Aceptación),0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(7);

  $pdf->SetFont('Arial','',6);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(30,0,$articulo['xd_fecha'],0,0,'L');
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(30,0,'',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(4);
  
  $pdf->SetFont('Arial','',8);
	$pdf->Cell(45,0,'',0,0,'R');	
	$pdf->Cell(90,0,'__________________________________________________________________',0,0,'L');
	$pdf->Cell(45,0,'',0,0,'R');
	$pdf->ln(15);
}

/*$pdf =& new concat_pdf();
$pdf->setFiles($sistema);
$pdf->concat();*/

$pdf->Output($nombrePDF, 'D');
unlink($nombrePDF);
	
/*
$pdf->Output("EMPLEADOCUMENTO/".$nombrePDF,"F");

//Envia el archivo a correo 
if($nombrePDF != ''){

new MailenvioPersonal("EMPLEADOCUMENTO/".$nombrePDF, $nombreUsuario);

//Si envia a Correo que elimine el archivo
if('MailenvioPersonal' == true){
	
	unlink("EMPLEADOCUMENTO/".$nombrePDF);
}

echo"<script language='javascript'>window.location='fichaPersonal.php?ID=$IDpersonal'</script>;";

}else{
	
	echo"No se Pudo Enviar el Archivo";
	
}
*/
?>