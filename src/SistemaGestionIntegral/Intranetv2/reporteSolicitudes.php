<?php 
$nombrephp = 'reporteSolicitudes.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

// CREACIÓN DEL OBJETO PHPExcel() MEDIANTE LA LIBRERIA PHPExcel.

$objPHPExcel = new PHPExcel();

// CONFIGURACION DE PROPIEDADES DEL ARCHIVO.
$objPHPExcel->getProperties()->setCreator("Grupo_Escalante")
							 ->setLastModifiedBy("Grupo_Escalante")
							 ->setTitle("Reporte de solictudes en revision")
							 ->setSubject("Reporte")
							 ->setDescription("Reporte de solicitudes.")
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
$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("CODIGO", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("TITULO", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("FECHA", PHPExcel_Cell_DataType::TYPE_STRING);

// DESPLAZAMIENTO AL SIGUIENTE RENGLON DEL ARCHIVO EXCEL.
$renglon++;

$indice = 0;

// CONSULTA A LA BASE DE DATOS MEDIENTE EL OBJETO ADODB $MASTER_GE. OBTENEMOS LOS DATOS QUE CORRESPONDEN A LA CABECERA.
$s = $INTRANETV2->Execute("SELECT
	Q.xt_quejaSolicitud,Q.xt_titulo,QE.xd_fechaCreacion
FROM
	SGI_Quejas_Solicitudesv2 Q,
	SGI_Quejas_Solicitudes_Estatusv2 QE
WHERE
	Q.xt_quejaSolicitud = QE.xt_quejaSolicitud
AND (
	Q.xt_status = 'REVISION'
	OR QE.xt_estatus = 'ENTREGABLE PARA REVISION'
)
AND QE.xn_numero = (
	SELECT
		MAX(xn_numero)
	FROM
		SGI_Quejas_Solicitudes_Estatusv2
	WHERE
		xt_quejaSolicitud = Q.xt_quejaSolicitud
	LIMIT 1
)

ORDER BY xd_fechaCreacion");

// IMPLEMENTACIÓN DE UN BUCLE DE CONTROL PARA ITERAR LOS VALORES DE RESULT SET (CONJUNTO DE RESULTADOS) OBTENIDOS DE LA CONSULTA.
while($r = $s->fetchRow()){
	// ASIGNACIÓN DE LOS VALORES OBTENIDOS EN LA CONSULTA A SUS RESPECTIVOS ARREGLOS.   
	$codigo[$indice] 	  = $r[0];
	$titulo[$indice] 	  = $r[1]; 
	$tipo[$indice] 	  = $r[2]; 
//echo "Titulo: $titulo[$indice]<br>";

	$indice++;
}

// IMPLEMENTACIÓN DEL BUCLE FOR PARA IMPRIMIR LOS VALORES EN EL ARCHIVO EXCEL.
for ($i=0; $i<count($codigo); $i++){
$objPHPExcel->getActiveSheet()->getStyle($columnas[6]."".$renglon)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

	$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($codigo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($titulo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($tipo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	
	$renglon++;

}

// DEFINICIÓN DEL NOMBRE DEL ARCHIVO EXCEL.
$nombreDocumento = 'reporteExcelSolicitudes.xls';

// Se envia el Excel al navegador del Cliente (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombreDocumento.'"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>