<?php
/*
ini_set('max_execution_time', 300);
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
*/

$nombrephp = 'reporteAduanasExcel.php';
require_once("../../ConexionDBT.php");
//require_once("compruebaUsuario.php");


	/** Error reporting */
	//error_reporting(E_ALL);
	
	date_default_timezone_set('Europe/London');
	
	require_once '../../../Librerias/PHPExcel/Classes/PHPExcel.php';
	/** PHPExcel */
	//require_once dirname(__FILE__) . '/../../Librerias/PHPExcel/Classes/PHPExcel.php';
	
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("GRUPO ESCALANTE")
							 ->setLastModifiedBy("GRUPO ESCALANTE")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Test document for Office 2007 XLSX")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

			$sheet = 0;
			$columnas = array("A","B","C","D","E","F","G","H");
			$columna = 0;
			$renglon = 1;
			
			$objPHPExcel->setActiveSheetIndex($sheet)->setTitle("Reporte");
			for($a = 0; $a < count($columnas); $a++){
				$objPHPExcel->getActiveSheet()->getStyle($columnas[$a]."".$renglon)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
				
			}
			
			$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("ADUANA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("PATENTE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("FRACCIÓN ARANCELARIA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("CLIENTE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("RFC", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("REFERENCIA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("FECHA DE PAGO", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit("PEDIMENTO", PHPExcel_Cell_DataType::TYPE_STRING);
			
			$renglon++;

$patente[1] = 3061;
$patente[2] = 3371;
$patente[3] = 3034;
$patente[4] = 3925;
$patente[5] = 3633;
$patente[6] = 3009;
$patente[7] = 3621;
$patente[8] = "Todas";

$aduanaValor[1] 	= 7;
$aduanaValor[2] 	= 16;
$aduanaValor[3] 	= 20;
$aduanaValor[4] 	= 24;
$aduanaValor[5] 	= 40;
$aduanaValor[6] 	= 43;
$aduanaValor[7] 	= 47;
$aduanaValor[8] 	= 53;
$aduanaValor[9] 	= 65;
$aduanaValor[10] 	= 80;
$aduanaValor[11]	= 44444;

$aduanaShow[1] 		= "Cd. Juarez, Chih.";
$aduanaShow[2] 		= "Manzanillo, Col.";
$aduanaShow[3] 		= "Pantaco, México D.F.";
$aduanaShow[4] 		= "Nuevo Laredo, Tamps";
$aduanaShow[5] 		= "Tijuana, B.C.";
$aduanaShow[6] 		= "Veracruz, Ver.";
$aduanaShow[7] 		= "AICM, México D.F.";
$aduanaShow[8] 		= "Cancún, Q.Roo";
$aduanaShow[9] 		= "Toluca, Méx.";
$aduanaShow[10] 	= "Colombia, N.L.";
$aduanaShow[11]		= "Todas";

$mesNombre[1] 	= "Enero";
$mesNombre[2] 	= "Febrero";
$mesNombre[3] 	= "Marzo";
$mesNombre[4] 	= "Abril";
$mesNombre[5] 	= "Mayo";
$mesNombre[6] 	= "Junio";
$mesNombre[7] 	= "Julio";
$mesNombre[8] 	= "Agosto";
$mesNombre[9] 	= "Septiembre";
$mesNombre[10] 	= "Octubre";
$mesNombre[11] 	= "Noviembre";
$mesNombre[12] 	= "Diciembre";
$mesNombre[13]  = "Todos";


///Obtiene el año si fue pasado como parametro
if($_GET['y'] != ""){
	$showYear = $_GET['y'];
	//echo "GETshowYear: ".$showYear."<br>";
///Si no el año se asigna como el año en curso	
}
///Obtiene el mes si fue pasado como parametro
if($_GET['m'] != ""){
	$showMonth = $_GET['m'];
///Si no el mes se asigna como el mes en curso	
} 

///Obtiene la patente si fue pasado como parametro
if($_GET['patente'] != ""){
	$showPatente = $_GET['patente'];
///Si no el mes se asigna como el mes en curso	
}

////
if($_GET['aduana'] != ""){
	$showAduana = $_GET['aduana'];
///Si no el mes se asigna como el mes en curso	
} 
								 
			$indice		= 1;
			$aduana		= NULL;
			$patente	= NULL;
			$fraccion	= NULL;
			$cliente	= NULL;
			$rfc		= NULL;
			$referencia	= NULL;
			$fechaPago	= NULL;
			$pedimento	= NULL;
			
			////TODAS LAS ADUANAS
			if($showAduana == 44444){
				///MES ESPECIFICO
				if($showMonth != 13){
					///PATENTE ESPECIFICA
					if($showPatente != "Todas"){
				
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND MONTH(PE.xd_fechaPago) = $showMonth 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $showPatente 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
						
					///TODAS LAS PATENTES
					} else{
						
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND MONTH(PE.xd_fechaPago) = $showMonth 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
						
					}
				///TODOS LOS MESES
				} else{
					///PATENTE ESPECIFICA
					if($showPatente != "Todas"){
				
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $showPatente 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
						
					///TODAS LAS PATENTES
					} else{
						
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
						
					}
						
				}
			///ADUANA ESPECIFICA
			} else{
				///MES ESPECIFICO
				if($showMonth != 13){
					///PATENTE ESPECIFICA
					if($showPatente != "Todas"){
				
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND MONTH(PE.xd_fechaPago) = $showMonth 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $showPatente 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$showAduana%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
					///TODAS LAS PATENTES
					} else{
						
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND MONTH(PE.xd_fechaPago) = $showMonth 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$showAduana%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
						
					}
				///TODOS LOS MESES
				} else{
					///PATENTE ESPECIFICA
					if($showPatente != "Todas"){
				
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PE.xn_patente = $showPatente 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$showAduana%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");
					///TODAS LAS PATENTES
					} else{
						
						$s = $INTRANET->Execute("
						SELECT DISTINCT PE.xn_aduana,PE.xn_patente,PA.xn_fraccionArancelaria, CL.xt_nombreCorto,CL.xt_rfc,PE.xt_referencia,PE.xd_fechaPago,PE.kp_pedimento 
						FROM MASTER_GE.MASTER_PEDIMENTOS PE, MASTER_GE.MASTER_PARTIDAS PA, MASTER_GE.MASTER_RFC_CLIENTEID CL, MASTER_GE.MASTER_FRACCIONES_VULNERABLES FC 
						WHERE YEAR(PE.xd_fechaPago) = $showYear 
						AND PE.xt_referencia = PA.xt_referencia 
						AND PA.xn_fraccionVulnerable = 1 
						AND PE.xt_nombre LIKE CL.xt_nombre 
						AND PE.xn_aduana LIKE '$showAduana%' 
						AND FC.kp_CodigoFraccion = PA.xn_fraccionArancelaria 
						ORDER BY PE.xn_aduana, PA.xn_fraccionArancelaria, CL.xt_rfc,PE.xd_fechaPago  ");						
					}
						
				}
				
			}
			
			while($r = $s->fetchRow()){
				
				if(strlen($r[0]) == 2){
					
					$aduana[$indice] = substr($r[0], 0, 1);
				  
				} else if(strlen($r[0]) == 3){
					
					$aduana[$indice] = substr($r[0], 0, 2);
				}
				
				for($j = 1; $j <= 10; $j++){
					if($aduanaValor[$j] == $aduana[$indice]){
						$aduana[$indice] = $aduanaShow[$j];
					}
				}
				
				$patente[$indice] 		= $r[1];
				$fraccion[$indice] 		= $r[2];
				$cliente[$indice] 		= $r[3];
				$rfc[$indice]			= $r[4];
				$referencia[$indice] 	= $r[5];
				$fechaPago[$indice] 	= $r[6];
				$pedimento[$indice]		= $r[7];
				
				$indice++;
				
			} unset($r); unset($s); unset($a);			
	
			
			
			for($i=1; $i<= count($referencia); $i++){
				
	$saveTimeZone = date_default_timezone_get();
	date_default_timezone_set('UTC');
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($aduana[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($patente[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($fraccion[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit($cliente[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit($rfc[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit($referencia[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($fechaPago[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit($pedimento[$i], PHPExcel_Cell_DataType::TYPE_STRING);
			//echo "<br>".$aduana[$a].", ".$patente[$a].", ".$fraccion[$a].", ".$cliente[$a].", ".$rfc[$a].", ".$referencia[$a].", ".$fechaPago[$a].", ".$pedimento[$a];
				
				$renglon++;
				
	date_default_timezone_set($saveTimeZone);
			}
			
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');			
			header('Content-Disposition: attachment;filename="reporteAduanasFraccion.xls"');			
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			
									
								
?>
</body>
</html>
