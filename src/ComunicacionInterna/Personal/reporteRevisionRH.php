<?php error_reporting(0); ?>
<?php 

ini_set('max_execution_time', 300);
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$nombrephp = 'reporteRevisionRH.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
//require_once("compruebaUsuario.php");


	/** Error reporting */
	error_reporting(E_ALL);
	
	date_default_timezone_set('Europe/London');
	
	/** PHPExcel */
	require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Cozy")
								 ->setLastModifiedBy("Cozy")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Document")
								 ->setDescription("Test document for Office 2007 XLSX")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");	
								 
	
	if(isset($_REQUEST["aduana"])){
				 
		$empleados = $INTRANET->getArray("
			SELECT
				e.*,
				YEAR ( e.xd_fechaActualizacionDatos ) AS yearActualizacionDatos,
				(SELECT MAX(xd_fechaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = u.xt_usuario and xd_fechaEntrada < CURRENT_DATE()) AS ultimoAccesoIntranet,
				u.xt_rfc,
				YEAR (u.xd_fechaActualizacionFoto) AS yearActualizacionFoto,
				YEAR (e.xd_aceptacionCartaCompromiso) AS yearAceptacionCartaCompromiso,
				u.xd_fechaActualizacionFoto 
			FROM
				SGI_Empleados e,
				perfiles.usuarios u,
				perfiles.sistemas s
			WHERE
				e.xt_tipo = 'E' 
				AND e.xt_Estatus = 1 
				AND e.xt_ciudad IN (".$_REQUEST["aduana"].") 
				AND u.xt_usuario = e.kf_usuario
				AND s.xt_usuario = u.xt_usuario
				AND s.xt_sistema = 'INTRANET'
				AND s.xt_estatus = 'ACTIVO'
			ORDER BY
				e.xt_Nombre,
				e.xt_ApellidoPaterno,
				e.xt_apellidoMaterno
		");

	}else{

		$empleados = $INTRANET->getArray("
			SELECT
				e.*,
				YEAR ( e.xd_fechaActualizacionDatos ) AS yearActualizacionDatos,
				YEAR (e.xd_aceptacionCartaCompromiso) AS yearAceptacionCartaCompromiso,
				(SELECT MAX(xd_fechaEntrada) FROM IntranetGEA_SESIONES_USUARIOS WHERE kf_usuario = u.xt_usuario and xd_fechaEntrada < CURRENT_DATE()) AS ultimoAccesoIntranet,
				u.xt_rfc  
			FROM
				SGI_Empleados e,
				perfiles.usuarios u,
				perfiles.sistemas s
			WHERE
				e.xt_tipo = 'E' 
				AND e.xt_Estatus = 1 
				AND e.xt_ciudad NOT IN ('LAR', 'LR', 'LRD', 'NLRD') 
				AND u.xt_usuario = e.kf_usuario
				AND s.xt_usuario = u.xt_usuario
				AND s.xt_sistema = 'INTRANET'
				AND s.xt_estatus = 'ACTIVO'
			ORDER BY
				e.xt_Nombre,
				e.xt_ApellidoPaterno,
				e.xt_apellidoMaterno
		");
	}
	
	//var_dump($empleados);

	$fechaInicioVisualizadorDocumentos = '2025-01-13';

	for($j=0; $j<count($empleados); $j++){
		$documentosNuevos = $INTRANETV2->getArray("
			SELECT
				md.xt_codigoDocumento,
				md.xt_nombre,
				md.xd_fechaCreacion as xd_fecha
			FROM
				sgi_manuales_documentos md
			WHERE
				md.xd_fechaCreacion > '".$fechaInicioVisualizadorDocumentos."'
				AND md.xt_codigoDocumento NOT IN (SELECT ccd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos ccd WHERE ccd.xt_codigoDocumento	= md.xt_codigoDocumento)
				AND md.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$empleados[$j]["kf_usuario"]."' AND cvd.xt_codigoDocumento = md.xt_codigoDocumento AND cvd.xn_version = 0)
		");
			
		$documentosActualizados = $INTRANETV2->getArray("
			SELECT
				ccd.xt_codigoDocumento,
				md.xt_nombre,
				ccd.xn_version,
				ccd.xd_fechaCambio as xd_fecha
			FROM
				sgi_control_de_cambios_documentos ccd,
				sgi_manuales_documentos md
			WHERE
				ccd.xn_version > 0 
				AND ccd.xd_fechaCambio > '".$fechaInicioVisualizadorDocumentos."'
				AND md.xt_codigoDocumento = ccd.xt_codigoDocumento
				AND ccd.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$empleados[$j]["kf_usuario"]."' AND cvd.xt_codigoDocumento = ccd.xt_codigoDocumento AND cvd.xn_version = ccd.xn_version)
		");

		$empleados[$j]["documentosFaltantes"] = (count($documentosNuevos) + count($documentosActualizados));

		if( $empleados[$j]["documentosFaltantes"] > 0){
			$empleados[$j]["estatusVisualizacionDocumentos"] = "false";
		}else{
			$empleados[$j]["estatusVisualizacionDocumentos"] = "true";
		}

		$expedientesActualizados = $INTRANET->getArray("SELECT * FROM sgi_expediente_personal WHERE xt_usuario_empleado = '".$empleados[$j]["kf_usuario"]."' AND YEAR(xd_fecha) = YEAR(NOW())");
		
		if(is_numeric($indiceIdentificacion = array_search( "Identificación Personal", array_column($expedientesActualizados, 'xt_tipo_expediente') ))){
			if($expedientesActualizados[$indiceIdentificacion]["xt_estatus"] == "Aceptado"){
				$empleados[$j]["estatusIdentificacion"] = "true";
			}else if($expedientesActualizados[$indiceIdentificacion]["xt_estatus"] == "Rechazado"){
				$empleados[$j]["estatusIdentificacion"] = "refused";
			}else{
				$empleados[$j]["estatusIdentificacion"] = "pending";
			}
		}else{
			$empleados[$j]["estatusIdentificacion"] = "false";
		} 
		
		if(is_numeric($indiceComprobante = array_search( "Comprobante de domicilio", array_column($expedientesActualizados, 'xt_tipo_expediente') ))){
			if($expedientesActualizados[$indiceComprobante]["xt_estatus"] == "Aceptado"){
				$empleados[$j]["estatusComprobanteDomicilio"] = "true";
			}else if($expedientesActualizados[$indiceComprobante]["xt_estatus"] == "Rechazado"){
				$empleados[$j]["estatusComprobanteDomicilio"] = "refused";
			}else{
				$empleados[$j]["estatusComprobanteDomicilio"] = "pending";
			}
		}else{
			$empleados[$j]["estatusComprobanteDomicilio"] = "false";
		} 

		if($empleados[$j]["yearActualizacionDatos"] == date('Y')){
			if($empleados[$j]["xt_estatusDatosPersonales"] == "Rechazado"){
				$empleados[$j]["estatusDatosActualizados"] = "refused";
			}else{
				$empleados[$j]["estatusDatosActualizados"] = "true";
			}
		}else{
			$empleados[$j]["estatusDatosActualizados"] = "false";
		}

		if($empleados[$j]["yearActualizacionFoto"] == date('Y')){
			$empleados[$j]["estatusFotoActualizada"] = "true";
		}else{
			$empleados[$j]["estatusFotoActualizada"] = "false";
		}

		if($empleados[$j]["yearAceptacionCartaCompromiso"] == date('Y')){
			$empleados[$j]["estatusCartaCompromiso"] = "true";
		}else{
			$empleados[$j]["estatusCartaCompromiso"] = "false";
		}
	}

	
	
	if(count($empleados) >= 1){
		
		$sheet = 0;
		$columnas = array("A","B","C","D","E","F","G","H","I","J","K","L");
		$columna = 0;
		$renglon = 1;
		$nombreHoja = 'datos';
		
		for($a = 0; $a< count($columnas); $a++){
			$objPHPExcel->getActiveSheet()-> getStyle($columnas[$a]."".$renglon)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnas[$a])->setAutoSize(true);
		}
		
		$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit("RFC", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit("NOMBRE", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit("ADUANA", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit("DATOS ACTUALIZADOS", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit("IDENTIFICACIÓN PERSONAL", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit("COMPROBANTE DOMICILIO", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit("VISUALIZACION DOCUMENTOS", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit("DOCUMENTOS FALTANTES", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit("ULTIMO ACCESO INTRANET", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit("NUMERO EMPLEADO", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit("ACTUALIZACION FOTO", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit("CARTA COMPROMISO SGI", PHPExcel_Cell_DataType::TYPE_STRING);
	
		$renglon++;
		
		foreach($empleados as $empleado){

			$objPHPExcel->getActiveSheet()->getCell($columnas[0]."".$renglon)->setValueExplicit($empleado["xt_rfc"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[1]."".$renglon)->setValueExplicit($empleado['xt_Nombre']." ".$empleado['xt_ApellidoPaterno']." ".$empleado['xt_ApellidoMaterno'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[2]."".$renglon)->setValueExplicit($empleado["xt_ciudad"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[3]."".$renglon)->setValueExplicit($empleado["estatusDatosActualizados"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[4]."".$renglon)->setValueExplicit($empleado["estatusIdentificacion"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[5]."".$renglon)->setValueExplicit($empleado["estatusComprobanteDomicilio"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[6]."".$renglon)->setValueExplicit($empleado["estatusVisualizacionDocumentos"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[7]."".$renglon)->setValueExplicit($empleado["documentosFaltantes"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[8]."".$renglon)->setValueExplicit($empleado["ultimoAccesoIntranet"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[9]."".$renglon)->setValueExplicit($empleado["xt_NumPersonal"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[10]."".$renglon)->setValueExplicit($empleado["estatusFotoActualizada"], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getCell($columnas[11]."".$renglon)->setValueExplicit($empleado["estatusCartaCompromiso"], PHPExcel_Cell_DataType::TYPE_STRING);
			
			$renglon++;
		}
		
		if(isset($_REQUEST["aduana"])){
			if($_REQUEST["aduana"] == "'AICM', 'CDMX', 'CMX', 'DF'"){
				$aduana = "CDMX";
			}else if($_REQUEST["aduana"] == "'CUN'"){
				$aduana = "CUN";
			}else if($_REQUEST["aduana"] == "'NLR', 'NLRD'"){
				$aduana = "NLRD";
			}else if($_REQUEST["aduana"] == "'TOL'"){
				$aduana = "TOL";
			}else if($_REQUEST["aduana"] == "'VER'"){
				$aduana = "VER";
			}
		}else{
			$aduana = "TODAS";
		}

		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporteRevisionRH_'.$aduana.'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	
	}/*else{

		echo "No existe informacion con estos parametros <br>";
		
		if( isset($_REQUEST["fechaInicio"], $_REQUEST["fechaTermino"], $_POST["aduana"]) ) {

			echo "Fechas : ". $fechaInicio."-".$fechaTermino."<br>";
			echo "Aduana : ".$aduana ."<br>";

		}else if( isset($_REQUEST["year"]) ){

			echo "Year : ".$_REQUEST["year"]."<br>";
			
		}
	}
	*/
									
?>
</body>
</html>
