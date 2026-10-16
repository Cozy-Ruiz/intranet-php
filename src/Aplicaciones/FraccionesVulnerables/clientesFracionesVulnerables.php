<?php
/*
 *@author Octavio Francisco García Robles
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'clientesFracionesVulnerables.php';
//require_once("../../ConexionDBT.php");
require_once("../../ConexionMaster.php");
//require_once("../../conexionLaredo.php");
date_default_timezone_set('America/Chicago');
//require_once("compruebaUsuario.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$year = date('Y');

$indice = 1;

$s = $MASTER_GE->Execute("
SELECT DISTINCT CL.xt_nombreCorto, CL.xt_rfc 
FROM MASTER_PEDIMENTOS PE, MASTER_PARTIDAS PA, MASTER_RFC_CLIENTEID CL 
WHERE PE.xt_referencia = PA.xt_referencia 
AND PA.xn_fraccionVulnerable = 1 
AND PE.xt_nombre LIKE CL.xt_nombre 
ORDER BY CL.xt_nombreCorto 
");

while($r = $s->fetchRow()){
	$nombre[$indice] = $r[0];
	$rfc[$indice] = $r[1];
	$indice++;
	
} unset($r); unset($s);

// Error reporting 
error_reporting(E_ALL);

/** PHPExcel */
require_once('/var/www/html/radar/Librerias/PHPExcel/Classes/PHPExcel.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Grupo_Escalante")
							 ->setLastModifiedBy("Grupo_Escalante")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Test document for Office 2007 XLSX")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 

$sheet = 0;
$columnas = array("A","B");
$columna = 0;
$renglon = 1;
	
$objPHPExcel->setActiveSheetIndex($sheet);

for($a = 0; $a < count($columnas); $a++){
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
}


for($a = 1; $a <= count($nombre); $a++){
	
	$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($nombre[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($rfc[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle($columnas[1]."".$renglon)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$renglon++;	
}

// Redirect output to a client's web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Lista_Clientes_Fracciones_Vulnerables_'.$year.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

unset($a); unset($columna); unset($columnas); unset($indice); unset($nombre); unset($rfc); unset($renglon);
								
?>