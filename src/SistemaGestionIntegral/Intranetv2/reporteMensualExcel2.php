<?php
/*
ini_set('max_execution_time', 300);
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
*/

$nombrephp = 'reporteMensualExcel2.php';
require_once("conexionMasterDB.php");
//require_once("compruebaUsuario.php");

	/** Error reporting */
	error_reporting(E_ALL);
	
	date_default_timezone_set('Europe/London');
	
	/** PHPExcel */
	require_once ('../Librerias/PHPExcel/Classes/PHPExcel.php');
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Sam")
								 ->setLastModifiedBy("Sam")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Document")
								 ->setDescription("Test document for Office 2007 XLSX")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");	
								 
					
	if($_POST["fechaInicial"] != '' && $_POST["fechaFinal"] != ''){
		
		$fechaInicial 		= date("Y-m-d",strtotime($_POST["fechaInicial"]));
		$fechaFinal 		= date("Y-m-d",strtotime($_POST["fechaFinal"]));
		//$cliente 			= trim($_GET['cliente']);
		$aduana 			= $_POST['aduana'];
		
		$existeInformacion 	= false;

		$index 				= 0;
		
		if($aduana == 470){
			
			$s = $MASTER_GE -> Execute("
			SELECT MP.xd_fechaPago, MP.xt_proyecto, MP.xn_tipoOperacion, MP.xn_aduana, MP.kp_pedimento, 
			SUM(MPA.xn_valorFacturaUSD), MP.xn_valorAduana, MP.xn_valorComercial, 
			MP.xn_tipoCambio, (MP.xn_importePagoPrimasSeguros + MP.xn_importePagoFletes + MP.xn_importePagoEmbalajes + MP.xn_importePagoOtrosIncrementables), 
			MP.xt_referencia 
			FROM MASTER_PEDIMENTOS MP, MASTER_PARTIDAS MPA 
			WHERE MP.xt_referencia = MPA.xt_referencia 
			AND MP.xd_fechaPago BETWEEN '$fechaInicial' AND '$fechaFinal' 
			AND MP.xn_aduana = 470 
			AND MP.xt_rfcCausante = 'DUC0912109A2' 
			GROUP BY MPA.xt_referencia 
			ORDER BY MP.xd_fechaPago ");
			
		}else if($aduana == 430){
			
			$s = $MASTER_GE -> Execute("
			SELECT MP.xd_fechaPago, MP.xt_proyecto, MP.xn_tipoOperacion, MP.xn_aduana, MP.kp_pedimento, 
			SUM(MPA.xn_valorFacturaUSD), MP.xn_valorAduana, MP.xn_valorComercial, 
			MP.xn_tipoCambio, (MP.xn_importePagoPrimasSeguros + MP.xn_importePagoFletes + MP.xn_importePagoEmbalajes + MP.xn_importePagoOtrosIncrementables), 
			MP.xt_referencia 
			FROM MASTER_PEDIMENTOS MP, MASTER_PARTIDAS MPA 
			WHERE MP.xt_referencia = MPA.xt_referencia 
			AND MP.xd_fechaPago BETWEEN '$fechaInicial' AND '$fechaFinal' 
			AND MP.xn_aduana = 650 
			AND MP.xt_rfcCausante = 'DUC0912109A2' 
			GROUP BY MPA.xt_referencia 
			ORDER BY MP.xd_fechaPago ");
			
		}else if($aduana == 800){
			
			$s = $MASTER_GE -> Execute("
			SELECT 	MP.xd_fechaPago, MP.xt_proyecto, MP.xn_tipoOperacion, MP.xn_aduana, MP.kp_pedimento, 
			SUM(MPA.xn_valorFacturaUSD), MP.xn_valorAduana, MP.xn_valorComercial, 
			MP.xn_tipoCambio, (MP.xn_importePagoPrimasSeguros + MP.xn_importePagoFletes + MP.xn_importePagoEmbalajes + MP.xn_importePagoOtrosIncrementables), 
			MP.xt_referencia 
			FROM MASTER_PEDIMENTOS MP, MASTER_PARTIDAS MPA 
			WHERE MP.xt_referencia = MPA.xt_referencia  
			AND MP.xd_fechaPago BETWEEN '$fechaInicial' AND '$fechaFinal' 
			AND MP.xn_aduana IN (800,240) 
			AND MP.xt_rfcCausante = 'DUC0912109A2' 
			GROUP BY MPA.xt_referencia 
			ORDER BY MP.xd_fechaPago ");
			
		}
		
		while ($r = $s->FetchRow()){
			
			$existeInformacion = true;
			
			$ref 	= $r[10];
			
			/*$advR 	= $MASTER_GE->getOne("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$ref' and xn_claveGravamen = 6 ");
			
			$dtaR 	= $MASTER_GE->getOne("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion = 1 ");
			
			$ivaR 	= $MASTER_GE->getOne("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$ref' and xn_claveGravamen = 3 ");
			
			$prevR 	= $MASTER_GE->getOne("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion = 15 ");
			
			$contra = $MASTER_GE->getOne("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion = 21 ");*/

		select sum(xn_importeGravamen),'advR'from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$ref' and xn_claveGravamen = 6
				union 
		select sum(xn_importeContribucion),'dtaR' from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion =1
				union 
		select sum(xn_importeGravamen),'ivaR' from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$ref' and xn_claveGravamen = 3
				union 
		select sum(xn_importeContribucion),'prevR' from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion = 15 
				UNION
		select sum(xn_importeContribucion),'contra' from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$ref' and xn_claveContrubucion = 21 


			$totalT	= $advR+$dtaR+$ivaR+$prevR+$contra;
			 echo $totalT.;
			
			$bandera = 0;
			
			$t = $MASTER_GE -> Execute("
			select xt_cuentaDeGastos, xn_subTotalA, xn_subTotalB, xn_totalImpuestosTrasladados,xn_granTotal from MASTER_CUENTADEGASTOS where xt_referencia = '$ref' 
			AND xt_emisorNombre <> 'On Time Forwarding, Inc.'");
			
			while($u= $t -> fetchRow()){
				
				$bandera = 1;
				
				if($u[0] != ""){
					
					$fechaPago[$index]			= "";
					$pedido[$index]				= "";
					$tipoMovimiento[$index]		= "";
					$aduSecc[$index]			= "";
					$pedimento[$index]			= "";
					$vgalorFactUsd[$index]		= "";
					$valorNormal[$index]		= "";
					$valorComercial[$index]		= "";
					$tipoCambio[$index]			= "";
					$totalGastos[$index]		= "";
					$referencia[$index]			= "";
					
					$ADV[$index] 				= 0;
					$DTA[$index] 				= 0;
					$IVA[$index] 				= 0;
					$PREV[$index] 				= 0;
					$CONTRAPRESTACION[$index]	= 0;
					$totalImpuestos[$index] 	= 0;
					
					$almacenaje[$index]			= 0;
					$desconsolidacion[$index]	= 0;
					$fletes[$index]				= 0;
					$maniobras[$index]			= 0;
					$montaCarga[$index]			= 0;
					$otros[$index]				= 0;
					$documentacion[$index]		= 0;
					$honorarios[$index]			= 0;
					$entrega[$index]			= 0;
					$servicios[$index]			= 0;
					$financiamiento[$index]		= 0;
					$mensajeria[$index]			= 0;
					$otros2[$index]				= 0;
					$retencion[$index] 			= 0;
					$coveVucem[$index]			= 0;
					$validacion[$index]			= 0;
					$etiquetado[$index]			= 0;
					
					$invoiceId[$index]			= 0;
					$subTotalA[$index] 			= 0;
					$subTotalB[$index] 			= 0;
					$ivaCuentaGastos[$index] 	= 0;
					$granTotal[$index]			= 0;
					
					
					if($r[0] != ""){
						$fechaPago[$index] 		= date('d/m/Y',strtotime($r[0]));
					} else{
						$fechaPago[$index]		= "";
					}
					
					$pedido[$index] 			= $r[1];
					
					if($r[2] == 1){
						$tipoMovimiento[$index] = 'IMP';
						
					}else if($r[2] == 2){
						$tipoMovimiento[$index] = 'EXP';
					}
					
					$aduSecc[$index] 			= $r[3];
					
					$pedimento[$index] 			= $r[4];
					
					$vgalorFactUsd[$index] 		= $r[5];
					
					$valorNormal[$index] 		= $r[6];
					
					$valorComercial[$index] 	= $r[7];
					
					$tipoCambio[$index] 		= $r[8];
					
					$totalGastos[$index] 		= $r[9];
					
					$referencia[$index] 		= $r[10];
					
					
					$ADV[$index] 				= $advR;
					
					$DTA[$index] 				= $dtaR;
					
					$IVA[$index] 				= $ivaR;
					
					$PREV[$index] 				= $prevR;
					
					$CONTRAPRESTACION[$index]	= $contra;
					
					$totalImpuestos[$index] 	= $totalT;
					/*
					
					
					echo "INDEX: $index|";
					echo "FPAGO: $fechaPago[$index]|";
					echo "PEDIDO: $pedido[$index]|";
					echo "TIPOMOV: $tipoMovimiento[$index]|";
					echo "ADUSEC: $aduSecc[$index]|";
					echo "PEDIMENTO: $pedimento[$index]|";
					echo "VALORFACUS: $vgalorFactUsd[$index]|";
					echo "VALORNORM: $valorNormal[$index] |";
					echo "VALORCOME: $valorComercial[$index]|";
					echo "TIPOCAMB: $tipoCambio[$index]|";
					echo "TOTALGAST: $totalGastos[$index]|";
					echo "REFERENCIA: $referencia[$index]|";
					echo "ADV: $ADV[$index]|";
					echo "DTA: $DTA[$index]|";
					echo "IVA: $IVA[$index]|";
					echo "PREV: $PREV[$index]|";			
					echo "TOTAIMPUES: $totalImpuestos[$index]|<br>";*/
					
					$invoiceId[$index] 	= $u[0];
					//echo "INVOICE:$invoiceId[$index]|";
					
					$v  = $MASTER_GE->EXecute("SELECT xn_importe, xt_descripcion, xn_valorUnitario FROM MASTER_CONCEPTOS_CUENTADEGASTOS WHERE xt_cuentaDegastos = '$u[0]' ");
												
					while($w = $v->fetchRow()){
						
						if(strstr($w[1], "DESCONSOLIDACION") != ""){
							$desconsolidacion[$index] 	= $w[0];
							
						} else if(strstr($w[1], "MANIOBRAS") != ""){
							$maniobras[$index] 			= $w[0];
							
						}else if(strstr($w[1], "ALMACENAJE") != ""){
							$almacenaje[$index] 		= $w[0];
							
						}else if(strstr($w[1], "FLETES") != ""){
							$fletes[$index] 			= $w[0];
							
						}else if(strstr($w[1], "MONTACARGA") != ""){
							$montaCarga[$index] 		= $w[0];
							
						}else if(strstr($w[1], "OTROS") != ""){
							$otros[$index] 				= $w[0];
							
						}else if(strstr($w[1], "DOCUMENTACION") != ""){
							$documentacion[$index] 		= $w[0];
							
						}else if(strstr($w[1], "HONORARIOS") != ""){
							$honorarios[$index] 		= $w[0];
							
						}else if(strstr($w[1], "ENTREGA") != ""){
							$entrega[$index] 			= $w[0];
							
						}else if(strstr($w[1], "SERVICIOS COMPLEMENTARIOS") != ""){
							$servicios[$index]			= $w[0];
							
						}else if(strstr($w[1], "SERV.COMPLEMENTARIOS") != ""){
							$servicios[$index]			= $w[0];
							
						}else if(strstr($w[1], "FINANCIAMIENTO") != ""){
							$financiamiento[$index]		= $w[0];
							
						}else if(strstr($w[1], "MENSAJERIA") != ""){
							$mensajeria[$index]			= $w[0];
							
						}else if(strstr($w[1], "OTROS2") != ""){
							$otros2[$index]				= $w[0];
							
						}else if(strstr($w[1], "COVE/VUCEM") != ""){
							$coveVucem[$index]			= $w[0];
							
						}else if(strstr($w[1], "VALIDACION") != ""){
							$validacion[$index]			= $w[0];
							
						}else if(strstr($w[1], "ETIQUETADO") != ""){
							$etiquetado[$index]			= $w[0];
							
						}
						
						if($w[2] != ""){
							$retencion[$index]			= $w[2];
						}
						
					}unset($w);
					
				/*	echo "DESCONSOLIDACION: $desconsolidacion[$index]|";
					echo "MANIOBRAS: $maniobras[$index]|";
					echo "ALMACENAJE: $almacenaje[$index]|";
					echo "FLETES: $desconsolidacion[$index]|";
					echo "MONTACARGA: $montaCarga[$index]|";
					echo "OTROS: $otros[$index]|";
					echo "DOCUMENTACION: $documentacion[$index]|";
					echo "HONORARIOS: $honorarios[$index]|";
					echo "ENTREGA: $entrega[$index]|";
					echo "SERVICIOS COMPLEMENTARIOS: $servicios[$index]|";
					echo "FINANCIAMIENTO: $financiamiento[$index]|";
					echo "MENSAJERIA: $mensajeria[$index]|";
					echo "OTROS2: $otros2[$index]|";
					echo "RETENCION: $retencion[$index]|<br><br>";*/
					
					if($u[1] != ""){
						$subTotalA[$index] 		= $u[1];
						//echo "SUBTOTALA: $subTotalA[$index]|";
					}
					
					if($u[2] != ""){
						$subTotalB[$index] 		= $u[2];
						//echo "SUBTOTALB: $subTotalB[$index]|";
					}
					
					if($u[3] != ""){
						$ivaCuentaGastos[$index] = $u[3];
						//echo "IVACTAGSTO: $ivaCuentaGastos[$index]<BR>.";
					}
					
					if($u[4] != ""){
						$granTotal[$index] = $u[4];
						//echo "IVACTAGSTO: $ivaCuentaGastos[$index]<BR>.";
					}
				}
				
				$index++;
				
			}unset($t);
			
			if($bandera == 0){
				$index++;
			}
			
		}
		
		if($existeInformacion == true){
			
			$sheet = 0;
			$columnas = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
							"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ");
			$columna = 0;
			$renglon = 1;
			
			if($aduana == 470){
				$nombreHoja = 'MonthlyReport';
			}else if($aduana == 430){
				$nombreHoja = 'MonthlyReport';
			}else if($aduana == 800 || 240){
				$nombreHoja = 'MonthlyReport';
			}
			for($a = 0; $a<count($columnas); $a++){
				$objPHPExcel->getActiveSheet()-> getStyle($columnas[$a]."".$renglon)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("REFERENCE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("PAYMENT DATE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("TYPE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("CUSTOMS SECTION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("ENTRY SUMARY", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("INVOICE AMOUNT USD", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("EXCHANGE RATE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit("COMMERCIAL VALUE MXP", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit("TOTAL ADDITIONAL CONCEPTS MXP", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit("CUSTOMS VALUE MXP", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit("IGI", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit("DTA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[12]."".$renglon)->setValueExplicit("VAT", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[13]."".$renglon)->setValueExplicit("PREVALIDATION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[14]."".$renglon)->setValueExplicit("CONTRAPRESTACION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[15]."".$renglon)->setValueExplicit("TOTAL TAXES", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[16]."".$renglon)->setValueExplicit("ALMACENAJE BASE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[17]."".$renglon)->setValueExplicit("ALMACENAJE IVA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[18]."".$renglon)->setValueExplicit("DESCONSOLIDACION BASE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[19]."".$renglon)->setValueExplicit("DESCONSOLIDACION IVA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[20]."".$renglon)->setValueExplicit("FLETES BASE", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[21]."".$renglon)->setValueExplicit("FLETES IVA", PHPExcel_Cell_DataType::TYPE_STRING);
			//$objPHPExcel->getActiveSheet()->getCell($columnas[22]."".$renglon)->setValueExplicit("FLETES RET", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[22]."".$renglon)->setValueExplicit("HANDLING", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[23]."".$renglon)->setValueExplicit("HANDLING VAT", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[24]."".$renglon)->setValueExplicit("FORKLIFT", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[25]."".$renglon)->setValueExplicit("FORKLIFT VAT", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[26]."".$renglon)->setValueExplicit("OTHERS", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[27]."".$renglon)->setValueExplicit("SUBTOTAL A", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[28]."".$renglon)->setValueExplicit("DOCUMENTATION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[29]."".$renglon)->setValueExplicit("COVE/VUCEM", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[30]."".$renglon)->setValueExplicit("VALIDATION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[31]."".$renglon)->setValueExplicit("DELIVERY RECOLECTION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[32]."".$renglon)->setValueExplicit("GE FEES", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[33]."".$renglon)->setValueExplicit("ADDITIONAL SERVICES", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[34]."".$renglon)->setValueExplicit("FINANCING", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[35]."".$renglon)->setValueExplicit("MENSAJERIA", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[36]."".$renglon)->setValueExplicit("LABELING", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[37]."".$renglon)->setValueExplicit("OTHERS", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[38]."".$renglon)->setValueExplicit("SUBTOTAL B", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[39]."".$renglon)->setValueExplicit("GE INVOICE VAT", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[40]."".$renglon)->setValueExplicit("RETENTION", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[41]."".$renglon)->setValueExplicit("GE INVOICE TOTAL", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[42]."".$renglon)->setValueExplicit("GE INVOICE NUMBER", PHPExcel_Cell_DataType::TYPE_STRING);	
			
			$renglon++;

			
			for($a=0; $a<count($referencia); $a++){
				
				/*echo $a."---$otros[$a]|$subTotalB[$a]|$documentacion[$a]|$entrega[$a]|$honorarios[$a]|$servicios[$a]|$financiamiento[$a]|$mensajeria[$a]|$otros2[$a]|$ivaCuentaGastos[$a]|$retencion[$a]|$invoiceId[$a]|$referencia[$a]<br>";
				*/
				//////
				/*$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($referencia[$a], PHPExcel_Cell_DataType::TYPE_STRING);
					//echo $referencia;
				$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($fechaPago[$a], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($tipoMovimiento[$a], PHPExcel_Cell_DataType::TYPE_STRING);
			/*	$objPHPExcel->getActiveSheet()->setCellValue($columnas[3]."".$renglon,$aduSecc[$a]);
				$objPHPExcel->getActiveSheet()->setCellValue($columnas[4]."".$renglon,$pedimento[$a]);
				$objPHPExcel->getActiveSheet()->setCellValue($columnas[5]."".$renglon,$vgalorFactUsd[$a]);
				$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($tipoCambio[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit($valorComercial[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit($totalGastos[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit($valorNormal[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit($ADV[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit($DTA[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[12]."".$renglon)->setValueExplicit($IVA[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[13]."".$renglon)->setValueExplicit($PREV[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[14]."".$renglon)->setValueExplicit($CONTRAPRESTACION[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[15]."".$renglon)->setValueExplicit($totalImpuestos[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				if($almacenaje[$a] != ""){
					$temp = $almacenaje[$a]/1.16;
				} else {
					$temp = 0;
				}
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[16]."".$renglon)->setValueExplicit($temp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[17]."".$renglon)->setValueExplicit(($almacenaje[$a]-$temp), PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				if($desconsolidacion[$a] != ""){
					$temp = $desconsolidacion[$a]/1.16;
				} else{
					$temp = 0;
				}
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[18]."".$renglon)->setValueExplicit($temp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[19]."".$renglon)->setValueExplicit(($desconsolidacion[$a]-$temp), PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				if($fletes[$a] != ""){
					$temp = $fletes[$a]/1.16;
				} else {
					$temp = 0;
				}
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[20]."".$renglon)->setValueExplicit($temp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[21]."".$renglon)->setValueExplicit(($fletes[$a]-$temp), PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				$objPHPExcel->getActiveSheet()->getStyle($columnas[5]."".$renglon.":".$columnas[21]."".$renglon)->getNumberFormat()->setFormatCode('"$"#,##0.00');
				
				
				//$objPHPExcel->getActiveSheet()->setCellValue($columnas[22]."".$renglon,'');
				
				
				if($maniobras[$a] != ""){
					$temp = $maniobras[$a]/1.16;
				} else {
					$temp = 0;
				}
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[22]."".$renglon)->setValueExplicit($temp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[23]."".$renglon)->setValueExplicit(($maniobras[$a]-$temp), PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				if($montaCarga[$a] != ""){
					$temp = $montaCarga[$a]/1.16;
				} else{
					$temp = 0;
				}
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[24]."".$renglon)->setValueExplicit($temp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[25]."".$renglon)->setValueExplicit(($montaCarga[$a]-$temp), PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[26]."".$renglon)->setValueExplicit($otros[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[27]."".$renglon)->setValueExplicit($subTotalA[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[28]."".$renglon)->setValueExplicit($documentacion[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[29]."".$renglon)->setValueExplicit($coveVucem[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[30]."".$renglon)->setValueExplicit($validacion[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[31]."".$renglon)->setValueExplicit($entrega[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[32]."".$renglon)->setValueExplicit($honorarios[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[33]."".$renglon)->setValueExplicit($servicios[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[34]."".$renglon)->setValueExplicit($financiamiento[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[35]."".$renglon)->setValueExplicit($mensajeria[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[36]."".$renglon)->setValueExplicit($etiquetado[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[37]."".$renglon)->setValueExplicit($otros2[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[38]."".$renglon)->setValueExplicit($subTotalB[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[39]."".$renglon)->setValueExplicit($ivaCuentaGastos[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[40]."".$renglon)->setValueExplicit($retencion[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getCell($columnas[41]."".$renglon)->setValueExplicit($granTotal[$a], PHPExcel_Cell_DataType::TYPE_NUMERIC);
				
				$objPHPExcel->getActiveSheet()->getStyle($columnas[22]."".$renglon.":".$columnas[41]."".$renglon)->getNumberFormat()->setFormatCode('"$"#,##0.00');
				
				
				$objPHPExcel->getActiveSheet()->getCell($columnas[42]."".$renglon)->setValueExplicit($invoiceId[$a], PHPExcel_Cell_DataType::TYPE_STRING);*/
				
				$renglon++;
				
			}
			
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			if($aduana == 470){
				header('Content-Disposition: attachment;filename="MonthlyReport_'.$fechaInicial.'-'.$fechaFinal.'.xls"');
			}else if($aduana == 430){
				header('Content-Disposition: attachment;filename="MonthlyReport_'.$fechaInicial.'-'.$fechaFinal.'.xls"');
			}else if($aduana == 800 || 240){
				header('Content-Disposition: attachment;filename="MonthlyReport_'.$fechaInicial.'-'.$fechaFinal.'.xls"');
			}
			
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			
		}else{
			echo "No existe informacion con estos parametros <br>";
			echo "Fecha Inicial : ". $fechaInicial."<br>";
			echo "Fecha Final : ".$fechaFinal."<br>";
			echo "Cliente : ".$cliente."<br>";
			echo "Aduana : ".$aduana ."<br>";
		}
		
		
		
	}
								
								
?>
</body>
</html>
<?php
