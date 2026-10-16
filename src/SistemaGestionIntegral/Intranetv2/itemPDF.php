<?php
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once('../../Librerias/fpdf/Fpdi/fpdf.php');

class PDF extends FPDF{
 
   /* // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
    }*/
}

abstract class NumerosRomanos  
{  
 
    private static  $_romanos = array(0=>array(0 => '',  
      1 => 'I',  
      2 => 'II',  
      3 => 'III',  
      4 => 'IV',  
      5 => 'V',  
      6 => 'VI',  
      7 => 'VII',  
      8 => 'VIII',  
      9 => 'IX'),  
    1    =>   array(0 => '',  
      1 => 'X',  
      2 => 'XX',  
      3 => 'XXX',  
      4 => 'XL',  
      5 => 'L',  
      6 => 'LX',  
      7 => 'LXX',  
      8 => 'LXXX',  
      9 => 'XC'),  
    2   =>    array(0 => '',  
      1 => 'C',  
      2 => 'CC',  
      3 => 'CCC',  
      4 => 'CD',  
      5 => 'D',  
      6 => 'DC',  
      7 => 'DCC',  
      8 => 'DCCC',  
      9 => 'CM'),  
    3 =>     array(0 => '',  
      1 => 'M',  
      2 => 'MM',  
      3 => 'MMM'));  

    private static $_divisores =    array(1, 10, 100, 1000);  

    private static $_decimal =      array('.'   => 0,  
                                          'I'   => 1,  
                                          'V'   => 5,  
                                          'X'   => 10,  
                                          'L'   => 50,  
                                          'C'   => 100,  
                                          'D'   => 500,  
                                          'M'   => 1000);  

    public static function decimalRomano($numero)  
    {  
        $retorno = '';  
        $max = (int)log10($numero);  
        for ($div = $max; $div > -1; $div--) {  
            $aux     =  (int)($numero/self::$_divisores[$div]);  
                $retorno.= self::$_romanos[$div][$aux];  
                $numero -=self::$_divisores[$div]*$aux;  
        }  
        return $retorno;  
    }  

    public static function romanoDecimal($romano)  
    {  
        $decimal    = 0;  
        $letras     = strlen($romano);  
        $romano    .= '.';  
        for ($r = 0; $r < $letras; $r++) {  
            $valorI     = self::$_decimal[$romano[$r]];  
            $valorII    = self::$_decimal[$romano[$r+1]];  
            $decimal += ($valorI < $valorII)? - $valorI : $valorI;  
        }  
        return $decimal;  
    }  
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
$nombre = $INTRANETV2->getOne("SELECT xt_nombre FROM INTRANET2.SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
$codigoCompleto = $INTRANETV2->getOne("SELECT xt_codigoCompleto FROM INTRANET2.SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
//echo "SELECT SUBSTRING_INDEX( xt_contenido, '/',- 1 ) AS Archivo  FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' AND xt_tipoElemento = 'A'";
$PdfExistente = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX( xt_contenido, '/',- 1 ) AS Archivo  FROM SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' AND xt_tipoElemento = 'A' ");

$arrNormas = array();
$arrIncisoNorma = array();
if($tipoDoc != "C"){
    
    //Certificcaciones
    //$arrNormas = array();
    //$arrIncisoNorma = array();
    $indexNorma = 0;
    $indexincisoN = 0;
    
    $s= $INTRANETV2->Execute("SELECT DISTINCT xt_codigoDocumentoNorma FROM INTRANET2.SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
    while($listNorma = $s -> fetchRow()){

          $arrNormas[$indexNorma] = $listNorma[0];
        
        //ontengo los indices de la norma correspondiente
        $j= $INTRANETV2 ->Execute("SELECT xt_indiceDocumentoNorma FROM INTRANET2.SGI_Normas_Incisos_Documentos WHERE xt_codigoDocumento = '$codDocumento' AND xt_codigoDocumentoNorma = '$arrNormas[$indexNorma]'");
    
    
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
    

    
}

//Referencias
$listaReferencias = array();
$indexRef = 0;
$listaCodDoc = "";

$array = $INTRANETV2->GetArray("SELECT
    xt_codigoReferencia
    FROM
    SGI_Manuales_Documentos_Referencias 
    WHERE
    xt_codigoDocumento = '$codDocumento'
");

foreach ($array as $key => $value) {
    $listaCodDoc .= $value["xt_codigoReferencia"].",";
}

$listaCodDoc = substr($listaCodDoc, 0, -1);

$l = $INTRANETV2->Execute("
SELECT
SMD.xt_codigoCompleto,
SMD.xt_nombre
FROM
INTRANET2.SGI_Manuales_Documentos_Referencias SMDR
        LEFT OUTER JOIN INTRANET2.SGI_Manuales_Documentos SMD ON SMDR.xt_codigoReferencia = SMD.xt_codigoDocumento
WHERE
SMDR.xt_codigoDocumento = '$codDocumento'

UNION

SELECT
SMD.xt_codigoCompleto,
SMD.xt_nombre
FROM
SGI_Manuales_Documentos_Referencias SMDR,
SGI_Manuales_Documentos SMD
WHERE
SMDR.xt_codigoReferencia = '$codDocumento'
AND SMDR.xt_codigoDocumento = SMD.xt_codigoDocumento
AND SMDR.xt_codigoDocumento not in ('".$listaCodDoc."')");

while($listRef = $l->fetchRow()){
    
    $listaReferencias[$indexRef] = $listRef[0]."   ".$listRef[1];
    $indexRef++;
}

///ELEMENTOS
$i = 1;

$s = $INTRANETV2->Execute("SELECT xn_orden, xt_tipoElemento, xt_titulo, xt_contenido, xt_outline FROM INTRANET2.SGI_Manuales_Elementos WHERE xt_codigoDocumento = '$codDocumento' ORDER BY xn_orden ");

while($r = $s->fetchRow()){
    
    $numeroElemento[$i] = $r[0];
    $tipoElemento[$i]   = $r[1];
    $tituloElemento[$i] = $r[2];
    
    
    $contenidoElemento[$i] = $r[3];
    $outline [$i] = $r[4];
    
    $i++;
    
} unset($r); unset($i); 


//Datos de ultima actualizacion
$numeroVersion  = $INTRANETV2->getOne("SELECT MAX(xn_version) FROM INTRANET2.SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento = '$codDocumento'");
if($numeroVersion != ''){
$fechaActualizacion = $INTRANETV2->getOne("SELECT xd_fechaCambio FROM INTRANET2.SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento  = '$codDocumento' AND xn_version= $numeroVersion");

}else{
    $numeroVersion = 0;
    $fechaActualizacion = $INTRANETV2->getOne("SELECT xd_fechaCreacion FROM INTRANET2.SGI_Manuales_Documentos WHERE xt_codigoDocumento  = '$codDocumento'");

}


//Referencias
$indexVersion = 0;
$ll = $INTRANETV2->Execute("SELECT xd_fechaCambio, xn_version, xt_descripcion, xt_inicialesUsuario FROM INTRANET2.SGI_Control_De_Cambios_Documentos WHERE xt_codigoDocumento ='$codDocumento'");
$version = array();
while($rr = $ll->fetchRow()){
    
    $fechaVersion[$indexVersion]   = date('Y-m-d', strtotime($rr[0]));
    $version[$indexVersion]        = $rr[1];
    $cambioDesc[$indexVersion]     = $rr[2];
    $iniciales[$indexVersion]      = $rr[3];
    $indexVersion++;

}unset($rr); unset($indexVersion);


$fechaTexto = 'Fecha de última actualización';

$pdf = new PDF();
if($PdfExistente == ''){
   // $pdf->AliasNbPages();
}

//
//Primera página
$pdf->AddPage('p',"Letter");
//Configuramos la fuente de la linea
$pdf->SetFont('Arial','',10);
//Imprimimos la fecha de creacion
$pdf->Cell(20,0,''.utf8_decode('Versión').': '.$numeroVersion,0,0,'R');
$pdf->Ln(5);
$pdf->Cell(72,0,''.utf8_decode($fechaTexto).': '.date(substr($fechaActualizacion,0,10)),0,0,'C');
$pdf->Ln(15);

$pdf->SetFont('Arial','',12);
//Colocamos el siguiente punto de la cabecera nombre del procedimiento
$pdf->Cell(190,0,''.iconv("UTF-8","ISO-8859-1",$nombre),0,0,'C');
$pdf->Ln(7);

$pdf->Cell(190,0,''.iconv("UTF-8","ISO-8859-1",$codigoCompleto),0,0,'C');
$pdf->Ln(7);

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,0,'Copia no controlada',0,0,'C');
$pdf->ln(20);

//CERTIFICACIONES
$pdf->Cell(100,0,'Certificaciones',0,0,'L');
$pdf->Ln(10);

//echo count($arrNormas);

if(count($arrNormas) > 0){
    
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

for($a = 0; $a<count($listaReferencias); $a++){
    //echo $listaReferencias."<br><br>";
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(150,0,''.iconv("UTF-8","ISO-8859-1", $listaReferencias[$a]),0,0,'L');
    $pdf->ln(5);
    
}

$pdf->ln(10);


//ELEMENTOS
$indice = 1;
$archivos = array();
$letras = "A";

$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'Elementos',0,0,'L');
$pdf->ln(10);

$pdf->SetFont('Arial','',10);
//$bandera = 0;
//echo count($numeroElemento)."<br>;
for($a = 1; $a <= count($numeroElemento); $a++){
    //echo $tipoDoc."<br>";
    
    /*
    if($tituloElemento[$a] == "DESARROLLO"){
        
        $bandera++;
        
    }
    */
    
    
    //if($bandera == 0){
       
        ///IMPRIMIR TITULO
        if($tipoDoc != "C"){
            //echo ''.NumerosRomanos::decimalRomano($numeroElemento[$a]).'. '.utf8_decode($tituloElemento[$a])."<br>";
            $pdf->Cell(100,0,''.NumerosRomanos::decimalRomano($numeroElemento[$a]).'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
            $pdf->ln(10);
        }else{
            //echo $outline[$a].'. '.utf8_decode($tituloElemento[$a]."<br>";
            $pdf->Cell(100,0,''.$outline[$a].'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
            $pdf->ln(10);
        }

        if($tipoElemento[$a] != "A"){
            //echo ''.utf8_decode($contenidoElemento[$a]."<br>";
            $pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
            $pdf->ln(10);
        }
       
    //} else if($bandera == 1){
       
        ///IMPRIMIR TITULO
        /*
        if($tipoDoc != "C"){
            $pdf->Cell(100,0,''.NumerosRomanos::decimalRomano($numeroElemento[$a]).'. '.utf8_decode($tituloElemento[$a]),0,0,'L');
            $pdf->ln(10);
        }else{
            if($tipoElemento[$a] != "A"){
                $pdf->Cell(100,0,''.$outline[$a].'. '.$tituloElemento[$a],0,0,'L');
                $pdf->ln(10);
            }   
        }*/
                
        
        if(substr($contenidoElemento[$a], -4) == ".pdf" ){
            
            array_push($archivos, $contenidoElemento[$a]);
            
        } else {
            
            $pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
            $pdf->ln(10);
            
        }
    /*    
    } else if($bandera > 1){

        
        if(substr($contenidoElemento[$a], -4) == ".pdf"){
            
            echo "entro";
            echo "nombre archivo"."procedimiento$a.pdf";
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
            $pdf4->Cell(190,0,'Fecha de '.utf8_decode('generación').': '.date("d/m/Y"),0,0,'R');
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
            
            $pdf->MultiCell(180,6,''.utf8_decode($contenidoElemento[$a]),'J');
            $pdf->ln(10);
            
        }
        
    }*/
}

if(count($version) > 0){
//echo "entro a version";
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


    for($vv = 0; $vv<count($version); $vv++){  

        $pdf->SetFont('Arial','',9);
        $pdf->SetX(160);
        $pdf->Cell(10,5,utf8_decode($version[$vv]),0,0,'C');
        $pdf->SetX(130);
        $pdf->Cell(20,5,utf8_decode($iniciales[$vv]),0,0,'C');
        $pdf->SetX(100);
        $pdf->Cell(30,5,date($fechaVersion[$vv]),0,0,'C');
        $pdf->SetX(20);
        $pdf->MultiCell(80,5,utf8_decode($cambioDesc[$vv]),0); 
        $pdf->Ln(10);
    }
}

$pdfCreado = $codDocumento.'.pdf';
$extensionPDF = substr($PdfExistente, -4);

//if($PdfExistente != '' && $extensionPDF == '.pdf'){
    $archivo = $pdf->Output($pdfCreado, 'F');

    if (file_exists($pdfCreado)) {

        array_unshift($archivos, $pdfCreado);

        //var_dump($archivos);

        include('concatenaPDF.php');

    } else {
        echo "No se pudo crear el archivo";
    }
/*
}else{
    $archivo = $pdf->Output($codigoCompleto.'.pdf', 'D');
}
*/
?>