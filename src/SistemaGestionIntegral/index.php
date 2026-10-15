<?php error_reporting(0); ?>
<?php
define('FPDF_FONTPATH', dirname(__FILE__) . '/fpdf17/font/');
require('../Librerias/fpdf/fpdf.php');
require ('InvoicePDF.class.php');
$pdf = new InvoicePDF();
$pdf->Output();
