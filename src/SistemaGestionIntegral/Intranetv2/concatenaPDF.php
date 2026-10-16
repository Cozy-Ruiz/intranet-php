<?php
use setasign\Fpdi\Fpdi;
require_once('../../Librerias/fpdf/Fpdi/fpdf.php');
require_once('../../Librerias/fpdf/Fpdi/autoload.php');

class ConcatPdf extends Fpdi
{
    public $files = array();

    public function setFiles($files) {
        $this->files = $files;
    }

    public function concat(){
        foreach($this->files AS $file) {
            try{
            $pageCount = $this->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $pageId = $this->ImportPage($pageNo);
                $s = $this->getTemplatesize($pageId);
                $this->AddPage($s['orientation'], $s);
                $this->useImportedPage($pageId);
            }
            }catch(Exception $e){
                echo 'Excepción capturada: '.$file.' ',  $e->getMessage(), "\n";
            }
        }
    }
    // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
    }
}

//echo $codigoCompleto.'.pdf';
//var_dump($archivos);

$documentoCreado = new ConcatPdf();
$documentoCreado->AliasNbPages();
$documentoCreado->setFiles($archivos);
$documentoCreado->concat();

$documentoCreado->Output('D', $codigoCompleto.'.pdf');

unlink($pdfCreado);

?>