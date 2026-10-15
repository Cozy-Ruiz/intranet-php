<?php 
$nombrephp = 'reporteSolicitudes.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

if ($_REQUEST['date1'] != '' && $_REQUEST['date2'] != '') {
	$date1=$_REQUEST['date1'];
	$date2=$_REQUEST['date2'];
	$datend = str_replace('-', '/', $date2);
	$tomorrow = date('Y-m-d',strtotime($datend . "+1 days"));		
}else if ($_REQUEST['date1'] == '' && $_REQUEST['date2'] == '') {
	$date1=date("Y-m-d");
	$date2=date("Y-m-d");
	$datend = str_replace('-', '/', $date2);
	$tomorrow = date('Y-m-d',strtotime($datend . "+1 days")); 
}


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
$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("TIPO", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("TIPO SOLICITUD", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("GRUPO", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("CIUDAD", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("FECHA", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit("DESCRIPCION", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit("USUARIO", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit("STATUS", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit("SOLICITANTE", PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit("PDR", PHPExcel_Cell_DataType::TYPE_STRING);


// DESPLAZAMIENTO AL SIGUIENTE RENGLON DEL ARCHIVO EXCEL.
$renglon++;

$indice = 0;

// CONSULTA A LA BASE DE DATOS MEDIENTE EL OBJETO ADODB $MASTER_GE. OBTENEMOS LOS DATOS QUE CORRESPONDEN A LA CABECERA.
$s = $INTRANETV2->Execute("SELECT
					MP.xt_referencia,
					MP.xt_nombre,
					MP.xn_pesoKgs PESO,
					MP.xn_aduana,
					(
						SELECT
							MFCP.xt_factura
						FROM
							MASTER_FACTURAS_COVE_PARTIDAS MFCP
						WHERE
							MP.xt_referencia = MFCP.xt_referencia
						LIMIT 1
					) FACTURAS,
					CONCAT(
						DATE_FORMAT(MP.xd_fechaPago, '%y'),
						' ',
						LEFT (MP.xn_aduana, 2),
						' ',
						MP.xn_patente,
						' ',
						SUBSTRING_INDEX(MP.kp_pedimento, '-', - 1)
					) AS Pedimento,
					MG.xt_guiaMaster,
					MG.kp_guiaHouse,
				(CASE 
				  WHEN SUBSTRING(MPS.xn_fraccionArancelaria,1,2) = '61' THEN '1TEXTIL'
				  WHEN SUBSTRING(MPS.xn_fraccionArancelaria,1,2) = '62' THEN '1TEXTIL'
				  WHEN SUBSTRING(MPS.xn_fraccionArancelaria,1,2) = '33' THEN '2HOGAR/C'
				  WHEN SUBSTRING(MPS.xn_fraccionArancelaria,1,2) = '34' THEN '2HOGAR/C'
				  ELSE '3MERCANCIA'
				END) AS Cap,
				CS.XT_OBSERVACIONES,
				FROM
				MASTER_PEDIMENTOS MP
					LEFT OUTER JOIN MASTER_GUIAS MG ON MG.xt_referencia = MP.xt_referencia
					LEFT OUTER JOIN MASTER_PARTIDAS MPS ON MPS.xt_referencia = MP.xt_referencia
					LEFT OUTER JOIN GRUPO_INDITEX.CONFIRMACION_SALIDAS CS ON CS.xt_referencia = MP.xt_referencia
					WHERE
						MP.xd_fechaEntrada BETWEEN '".$date1."'
					AND '".$date2."'
					AND MP.xn_aduana = '470'
					AND MP.xt_referencia LIKE '%-%'
					AND MP.xt_rfcCausante IN (
						'ZME920824KM3',
						'ZHM040609ES5',
						'RME140210IY5',
						'FGM150917IPA',
						'BME0004112J6',
						'UME091026UT6',
						'P&B0108104K7',
						'IMV1402104L4',
						'OME0107208X5',
						'ZMC960801538',
						'MDM041221RJ3',
						'SME111206QU5',
						'TME030710K69',
						'NCG131029SK3'
					)
				AND MP.xt_referencia LIKE '19-401149'
				ORDER BY
					SUBSTRING(Cap,1,2) LIMIT 5");

// IMPLEMENTACIÓN DE UN BUCLE DE CONTROL PARA ITERAR LOS VALORES DE RESULT SET (CONJUNTO DE RESULTADOS) OBTENIDOS DE LA CONSULTA.
while($r = $s->fetchRow()){
	// ASIGNACIÓN DE LOS VALORES OBTENIDOS EN LA CONSULTA A SUS RESPECTIVOS ARREGLOS.   
	$codigo[$indice] 	  = $r[0];
	$titulo[$indice] 	  = $r[1]; 
	$tipo[$indice] 	  = $r[2]; 
	$tipoSolicitud[$indice] 	  = $r[3]; 
	$grupo[$indice] 	  = $r[4]; 
	$ciudad[$indice] 	  = $r[5]; 
	$fecha[$indice] 	  = $r[6]; 
	$descripcion[$indice] 	  = $r[7]; 
	$usuario[$indice] 	  = $r[8]; 
	$status[$indice]= $r[9]; 
	$solicitante[$indice] 	      = $r[10]; 
	$pdr[$indice] 	  = $r[11]; 
//echo "Titulo: $titulo[$indice]<br>";

	$indice++;
}

// IMPLEMENTACIÓN DEL BUCLE FOR PARA IMPRIMIR LOS VALORES EN EL ARCHIVO EXCEL.
for ($i=0; $i<count($codigo); $i++){
$objPHPExcel->getActiveSheet()->getStyle($columnas[6]."".$renglon)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

	$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($codigo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($titulo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($tipo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit($tipoSolicitud[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit($grupo[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit($ciudad[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($fecha[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit($descripcion[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit($usuario[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit($status[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit($solicitante[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit($pdr[$i], PHPExcel_Cell_DataType::TYPE_STRING);
	
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