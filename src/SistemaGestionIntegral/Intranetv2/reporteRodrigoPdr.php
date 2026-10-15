<?php 
$nombrephp = 'reporteRodrigoPdr.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

// CREACIÓN DEL OBJETO PHPExcel() MEDIANTE LA LIBRERIA PHPExcel.

$objPHPExcel = new PHPExcel();

// CONFIGURACION DE PROPIEDADES DEL ARCHIVO.
$objPHPExcel->getProperties()->setCreator("Grupo_Escalante")
							 ->setLastModifiedBy("Grupo_Escalante")
							 ->setTitle("Reporte de visitas 2015-2016")
							 ->setSubject("Reporte")
							 ->setDescription("Reporte de visitas.")
							 ->setKeywords("reporte excel php")
							 ->setCategory("Reportes");

// INICIALIZACIÓN LAS VARIABLES.
$sheet = 0;
$columnas = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP");
$columna = 0;
$renglon = 1;


$objPHPExcel->setActiveSheetIndex($sheet);							 

// DEFINICIÓN DEL TAMAÑO DE LAS COLUMNAS A AUTOMÁTICO.
for($a = 0; $a < count($columnas); $a++){
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
}

// ESTABLECIMIENTO DE LA CABECERA CON FORMATO NEGRITA.
$objPHPExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon.":".$columnas[11]."".$renglon)->getFont()->setBold(true);

// DEFINICIÓN DE LOS VALORES DE LA CABECERA.
$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("Codigo", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("Titulo", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("Tipo Solicitud", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("Ciudad", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("Fecha", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("Estatus", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("PDR", PHPExcel_Cell_DataType::TYPE_STRING);

// DESPLAZAMIENTO AL SIGUIENTE RENGLON DEL ARCHIVO EXCEL.
$renglon++;

$indice = 0;

// CONSULTA A LA BASE DE DATOS MEDIENTE EL OBJETO ADODB $MASTER_GE. OBTENEMOS LOS DATOS QUE CORRESPONDEN A LA CABECERA.
$s = $INTRANETV2->GetArray("SELECT xt_quejaSolicitud c1, xt_titulo c2, xt_tipoSolicitud c3, xt_ciudad c4, xd_fecha c5, xt_status c6, xt_pdr c7 FROM SGI_Quejas_Solicitudesv2 WHERE xt_status = 'SIN ASIGNAR' AND xt_pdr = 'Rodrigo_Romo'");

// IMPLEMENTACIÓN DE UN BUCLE DE CONTROL PARA ITERAR LOS VALORES DE RESULT SET (CONJUNTO DE RESULTADOS) OBTENIDOS DE LA CONSULTA.
/*while($r = $s->fetchRow()){
	// ASIGNACIÓN DE LOS VALORES OBTENIDOS EN LA CONSULTA A SUS RESPECTIVOS ARREGLOS.   
	$codigo[$indice] 	  = $r[0];
	$titulo[$indice] 	  = $r[1]; 
	$tipo[$indice] 	  = $r[2]; 
//echo "Titulo: $titulo[$indice]<br>";

	$indice++;
}*/

// IMPLEMENTACIÓN DEL BUCLE FOR PARA IMPRIMIR LOS VALORES EN EL ARCHIVO EXCEL.
foreach ($s as $key => $value) {
	$objPHPExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
	$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($value["c1"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($value["c2"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($value["c3"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit($value["c4"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit($value["c5"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit($value["c6"], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($value["c7"], PHPExcel_Cell_DataType::TYPE_STRING);
	
	$renglon++;
}

// DEFINICIÓN DEL NOMBRE DEL ARCHIVO EXCEL.
$nombreDocumento = 'reporteRodrigoPdr.xls';
// Se envia el Excel al navegador del Cliente (Excel5)
header("Content-type: application/vnd-ms-excel; charset=UTF-8"); 
header('Content-Disposition: attachment;filename="'.$nombreDocumento.'"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>