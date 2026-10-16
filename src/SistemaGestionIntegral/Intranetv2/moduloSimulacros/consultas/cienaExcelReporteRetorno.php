<?php
$nombre = 'cienaExcelReporteRetorno.php';
require_once("conexionMasterDB.php");
require_once("conexionMexicoDB.php");
				
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** PHPExcel */
require_once dirname(__FILE__) . '../../Librerias/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objExcel = new PHPExcel();

// Set properties
//Set_properties
$objExcel->getProperties()->setCreator("Grupo Escalante Agencias Aduanales S.C.")
					 ->setLastModifiedBy("Grupo Escalante Agencias Aduanales S.C.")
					 ->setTitle("Office 2007 XLSX Test Document")
					 ->setSubject("Office 2007 XLSX Document")
					 ->setDescription("Test document for Office 2007 XLSX")
					 ->setKeywords("office 2007 openxml php")
					 ->setCategory("Test result file");

$fechaInicial  = date("Y-m-d",strtotime($_POST['fechaInicio']));
$fechaFinal = date("Y-m-d",strtotime($_POST['fechaFinal']));

//$fechaInicial  = "2019-01-01";
//$fechaFinal = "2019-06-30";


$objExcel->createSheet(0);
$objExcel->setActiveSheetIndex(0)->setTitle('Operaciones');
$columnas = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y");
$columna = 0;
$renglon = 1;

$objExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon.":".$columnas[23]."".$renglon)->getFont()->setBold(true);


for($a = 0; $a<count($columnas); $a++){
	
	$objExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
}
$BStyle = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("NOMBRE", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("REFERENCIA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("PEDIMENTO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("FRACCION", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("PARTIDA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("# DE PARTE", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("# DE FACTURA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit("# DE SERIE", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit("TRAMITE ADUANERO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit("TIPO OPERACION", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit("PAGO EFECTIVO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit("VALOR TOTAL MERCANCIA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[12]."".$renglon)->setValueExplicit("DTA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[13]."".$renglon)->setValueExplicit("IVA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[14]."".$renglon)->setValueExplicit("VALOR ADUANA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[15]."".$renglon)->setValueExplicit("FECHA ENTRADA", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[16]."".$renglon)->setValueExplicit("FECHA REVALIDACION", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[17]."".$renglon)->setValueExplicit("FECHA PAGO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[18]."".$renglon)->setValueExplicit("GUIA HOUSE", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[19]."".$renglon)->setValueExplicit("GUIA MASTER", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[20]."".$renglon)->setValueExplicit("TIPO DE CAMBIO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[21]."".$renglon)->setValueExplicit("DESCARGO", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[22]."".$renglon)->setValueExplicit("CANTIDAD ORIGINAL", PHPExcel_Cell_DataType::TYPE_STRING);
$objExcel->getActiveSheet()->getCell($columnas[23]."".$renglon)->setValueExplicit("PEDIMENTO DESCARGO", PHPExcel_Cell_DataType::TYPE_STRING);

$objExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon.":".$columnas[23]."".$renglon)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('E6FEED');
$objExcel->getActiveSheet()->getStyle($columnas[0]."".$renglon.":".$columnas[23]."".$renglon)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($BStyle);

$renglon++;

$indice = 0;
$nombre = array();
$referencia   = array();
$pedimento = array();
$fraccion = array();

$partida = array();

$parte = array();
$factura = array();
$serie = array();
$tramiteaduanero= array();
$tipooperacion = array();
$pagoefectivo = array();
$valortotalmercancia = array();
$dta = array();
$iva = array();
$valoraduana = array();
$fechaentrada = array();
$fecharevalidacion= array();
$fechapago = array();
$guiahouse = array();
$guiamaster = array();
$tipocambio = array();
$totalpiezas = array();
$inventario = array();
$pedimentodescargo = array();


$sql = "call sp_ReporteRetorno('$fechaInicial','$fechaFinal')";
$u = $CIENA->Execute($sql);
	
while($t = $u->FetchRow()){


	$nombre[$indice] 			= $t[0];
	$referencia[$indice]   		= $t[1];
	$pedimento[$indice] 		= $t[2];
	$fraccion[$indice] 			= $t[3];
	$parte[$indice]     		= $t[4];
	$factura[$indice] 			= $t[5];
	$serie[$indice]    			= $t[6];
	$tramiteaduanero[$indice] 	= $t[7];
	$tipooperacion[$indice] 	= $t[8];
	$pagoefectivo[$indice] 		= $t[9];
	$valortotalmercancia[$indice] = $t[10];
	$dta[$indice] 				= $t[11];
	$iva[$indice] 				= $t[12];
	$valoraduana[$indice] 		= $t[13];
	$fechaentrada[$indice] 		= $t[14];
	$fecharevalidacion[$indice] = $t[15];
	$fechapago[$indice] 		= $t[16];
	$guiahouse[$indice] 		= $t[17];
	$guiamaster[$indice] 		= $t[18];
	$tipocambio[$indice] 		= $t[19];
	
	$totalpiezas[$indice] 		= 0; // 20;
	$inventario[$indice] 		= $t[21];

	$partida[$indice] 			= $t[22];

	$pedimentodescargo[$indice] = ''; // 23;

	$indice++;


}unset($t);


for ($a=0; $a < count($referencia) ; $a++) { 
	
	$saveTimeZone = date_default_timezone_get();
	date_default_timezone_set('UTC');

	$objExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($nombre[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($referencia[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($pedimento[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit($fraccion[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit($partida[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit($parte[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($factura[$a], PHPExcel_Cell_DataType::TYPE_STRING);

	// Obtenemos información de SCIA de los números de serie
	$sql2 = "";
	$sql2 = "SELECT 
		FRA_FACTURASMERCANCIA, 
		RTRIM( REGEXP_REPLACE(
		(LISTAGG(SER_FACTURASNOSERIE,', ') WITHIN GROUP (ORDER BY SER_FACTURASNOSERIE)),
		'([^-]*)(-\1)+($|-)', 
           '\1\3'),
		 '-')
	FROM T_NOTGUIASDATOS, 
				R_FACTURASMERCANCIAPEDIMENTO, 
				R_FACTURASNOSERIE
	WHERE NTR_NOTGUIASDATOS = '$referencia[$a]'
	AND SUB_FACTURASMERCANCIA = '$partida[$a]'
	AND REF_FACTURASMERCANCIA = CVE_NOTGUIASDATOS
	AND REF_FACTURASNOSERIE   = REF_FACTURASMERCANCIA
	AND FAC_FACTURASNOSERIE   = FAC_FACTURASMERCANCIA
	AND PAR_FACTURASNOSERIE   = CON_FACTURASMERCANCIA
	GROUP BY FRA_FACTURASMERCANCIA
	
	-- UNION ALL 

	-- SELECT DISTINCT FRA_FACTURASMERCANCIA , 
	-- 		-- LISTAGG(REPLACE(OBS_TRAFICOOBSCAPTURA, 'NUMERO DE SERIE : ', ''),', ') WITHIN GROUP (ORDER BY OBS_TRAFICOOBSCAPTURA)
	-- 		LTRIM(RTRIM(REPLACE(OBS_TRAFICOOBSCAPTURA,'NUMERO DE SERIE :', '')))
	-- FROM T_NOTGUIASDATOS, 
	-- 		R_FACTURASMERCANCIAPEDIMENTO, 
	-- 		T_TRAFICOOBSCAPTURA
	-- WHERE NTR_NOTGUIASDATOS = '$referencia[$a]'	
	-- 	AND SUB_FACTURASMERCANCIA = '$partida[$a]'
	-- 	AND REF_FACTURASMERCANCIA = CVE_NOTGUIASDATOS
	-- 	AND REF_TRAFICOOBSCAPTURA = REF_FACTURASMERCANCIA
	-- 	AND PAR_TRAFICOOBSCAPTURA = SUB_FACTURASMERCANCIA
	-- 	AND TIP_TRAFICOOBSCAPTURA = 2
	-- 	AND OBS_TRAFICOOBSCAPTURA LIKE '%SERIE%'
	";

	$s = $SCIA2->Execute($sql2);
	$serie[$a] = 'SIN NUMERO';
	while($v = $s->FetchRow()){

		$serie[$a] 	= $v[1];

	}unset($v);

	// $sql2 = "";
	// $sql2 = "SELECT DISTINCT FRA_FACTURASMERCANCIA , 
	// 		OBS_TRAFICOOBSCAPTURA
	// FROM T_NOTGUIASDATOS, 
	// 		R_FACTURASMERCANCIAPEDIMENTO, 
	// 		T_TRAFICOOBSCAPTURA
	// WHERE NTR_NOTGUIASDATOS = '$referencia[$a]'	
	// 	AND SUB_FACTURASMERCANCIA = '$partida[$a]'
	// 	AND REF_FACTURASMERCANCIA = CVE_NOTGUIASDATOS
	// 	AND REF_TRAFICOOBSCAPTURA = REF_FACTURASMERCANCIA
	// 	AND PAR_TRAFICOOBSCAPTURA = SUB_FACTURASMERCANCIA
	// 	AND TIP_TRAFICOOBSCAPTURA = 2
	// 	AND OBS_TRAFICOOBSCAPTURA NOT LIKE '%SERIE%'
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%PARTE%')
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%MERCANCIA%')
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%MODELO%')
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%REQUIERE%')
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%PART%')
	// 	AND (OBS_TRAFICOOBSCAPTURA NOT LIKE '%MARCA%')
	// ";

	// $s = $SCIA2->Execute($sql2);
	// while($v = $s->FetchRow()){

	// 	$serie[$a] 	= $serie[$a].','.$v[1];

	// }unset($v);

	$objExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit($serie[$a], PHPExcel_Cell_DataType::TYPE_STRING);

	$objExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit($tramiteaduanero[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit($tipooperacion[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit($pagoefectivo[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit($valortotalmercancia[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[12]."".$renglon)->setValueExplicit($dta[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[13]."".$renglon)->setValueExplicit($iva[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[14]."".$renglon)->setValueExplicit($valoraduana[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[15]."".$renglon)->setValueExplicit($fechaentrada[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[16]."".$renglon)->setValueExplicit($fecharevalidacion[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[17]."".$renglon)->setValueExplicit($fechapago[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[18]."".$renglon)->setValueExplicit($guiahouse[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[19]."".$renglon)->setValueExplicit($guiamaster[$a], PHPExcel_Cell_DataType::TYPE_STRING);
	$objExcel->getActiveSheet()->getCell($columnas[20]."".$renglon)->setValueExplicit($tipocambio[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);

	//Obtenemos información de SCIA para el TOTAL DE PIEZAS / DESCARGO
	if ($tramiteaduanero[$a] == "BM")
	{
		$pedimento_o = substr($pedimento[$a],5,7);
		$sql2 = "";
		$sql2 = "SELECT 
				NVL(SUM(D.DESCARGAF),0) AS DESCARGO
		FROM T_NOTGUIASDATOS, PEDIMENTO.PEDIMENTOS P,PEDIMENTO.DESCARGO D
		WHERE
			D.PEDIMENTO_O = '$pedimento_o'
		AND D.FRACCION_O = '$fraccion[$a]'
		AND P.REFERENCIA = RPAD(NTR_NOTGUIASDATOS,10,' ')
		AND D.REFERENCIA = P.REFERENCIA
		";

		$s = $SCIA->Execute($sql2);
		$totalpiezas[$a] = 0;
		while($v = $s->FetchRow()){
			$totalpiezas[$a] 	= $v[0];
		}unset($v);
	}
	else {
		$totalpiezas[$a] = 0;
	}

	$objExcel->getActiveSheet()->getCell($columnas[21]."".$renglon)->setValueExplicit($totalpiezas[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objExcel->getActiveSheet()->getCell($columnas[22]."".$renglon)->setValueExplicit($inventario[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);

	if ($tramiteaduanero[$a] == "BM")
	{
		$pedimento_o = substr($pedimento[$a],5,7);
		$sql2 = "";
		$sql2 = " SELECT 
			LISTAGG(P.PEDIMENTO,', ') WITHIN GROUP (ORDER BY P.PEDIMENTO)
		FROM T_NOTGUIASDATOS, PEDIMENTO.PEDIMENTOS P,PEDIMENTO.DESCARGO D
		WHERE 
			D.PEDIMENTO_O = '$pedimento_o'
			AND  P.REFERENCIA = RPAD(NTR_NOTGUIASDATOS,10,' ')
			AND  D.REFERENCIA = P.REFERENCIA";

		$s = $SCIA->Execute($sql2);
		$pedimentodescargo[$a] = '';
		while($v = $s->FetchRow()){
			$pedimentodescargo[$a] 	= $v[0];
		}unset($v);
	}
	$objExcel->getActiveSheet()->getCell($columnas[23]."".$renglon)->setValueExplicit($pedimentodescargo[$a], PHPExcel_Cell_DataType::TYPE_STRING);

	$renglon++;

	date_default_timezone_set($saveTimeZone);

}


// Redirect output to a client's web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte_Retorno.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
$objWriter->save('php://output');

exit;

?>

