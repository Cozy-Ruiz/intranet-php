<?php
$nombrephp = 'carga_nuevo_truck.php';
//require_once("conexionDB.php");
//require_once("compruebaUsuario.php");
//require_once 'Excel/excel_reader2.21.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Agregar Truck</title>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
   <link type="text/css" rel="stylesheet" href="cargarArchivos/uploadify.css"/>	
        <script type="text/javascript" src="cargarArchivos/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="cargarArchivos/jquery.uploadify.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $("#fileUpload").fileUpload({
                    'uploader': 'cargarArchivos/uploader.swf',
                    'cancelImg': 'cargarArchivos/cancel.png',
                    'folder': 'cargarArchivos/uploads/',
                    'buttonText': 'Archivos txt',
                    'checkScript': 'cargarArchivos/check.php',
                    'script': 'cargarArchivos/upload.php',
                    'multi': true,
                    'simUploadLimit': 2
                });	
        });
        </script>
</head>

<body>

	<h2 style="margin-left:35%;">Alta de Trailer</h2>

	<?php
	
	
	echo "date_default_timezone_set: ".date_default_timezone_get()."<br>";
	
	
	if($_POST['truckCodigo'] == ''){
		
		echo "<div style='margin-left: 4em; margin-Top: 4em;' id='altaTRailer'>";
			
			echo "<b>Paso 1 :</b> <br><br>";
			?>
            <input name="fileUpload" id="fileUpload" type="file"/> <br><br>
            <b>Paso 2 :</b> <br><br>
            Subir <a href="javascript:$('#fileUpload').fileUploadStart()"><input type='image' src='Imagenes/Boton_Verde.png' weight='15 px' height='15 px'></a><br><br><br> <!--| <a href="javascript:$('#fileUpload').fileUploadClearQueue()">Limpiar</a>-->
            <?php
			
			echo "<FORM name='form1' ACTION='XLSX_carga_nuevo_truck.php'  METHOD='POST' enctype='multipart/form-data'>";
				echo "<b>Paso 3 :</b> <br><br>";
				echo "<table border='0' width='300'>";
					echo "<tr>";
						echo "<td><b>Codigo del truck:</b></td>";
						echo "<td align='right'><INPUT TYPE='text' NAME='truckCodigo'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Porcentaje:</b></td>";
						echo "<td align='right'><INPUT TYPE='text' NAME='porcentaje'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo:</b></td>";
						echo "<td align='right'><INPUT TYPE='text' NAME='tipo'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Comentario:</b></td>";
						echo "<td align='right'><INPUT TYPE='text' NAME='comentario'></td>";
					echo "</tr>";
				echo "</table>";
				
				echo "<br><br>";	
					
				echo "<b>Paso 4 :<b> <br><br>";
				echo "<b>Selecciona archivo xls:</b> <br><br>";
				echo "<INPUT TYPE='file' NAME='archivoExcel'><br><br>";
				   
				echo "<INPUT type='submit' value='Enviar'>";
			echo "</FORM>";
		echo "</div>";	
		
	}else if($_POST['truckCodigo'] != '' && $_FILES['archivoExcel']['name'] != ''){
		
		//Paso # 1 Cargar el Truck
		$truckCodigo = trim($_POST['truckCodigo']);
		$porcentaje = trim($_POST['porcentaje']);
		$tipo = trim($_POST['tipo']);
		$comentario = trim($_POST['comentario']);
		
		echo "$truckCodigo-- $porcentaje -- $tipo -- $comentario <br>";
		
		if($truckCodigo != ''){
			//$db2->Execute("insert into RADAR_TRAILER (xt_truckCodigo) values ('$truckCodigo') ");
		}
		
		if($porcentaje != ''){
			//$db2->Execute("update RADAR_TRAILER set xn_porcentaje = $porcentaje where xt_truckCodigo = '$truckCodigo' ");
		}
		
		if($tipo != ''){
			//$db2->Execute("update RADAR_TRAILER set xt_tipo = '$tipo' where xt_truckCodigo = '$truckCodigo' ");
		}
		
		if($comentario != ''){
			//$db2->Execute("update RADAR_TRAILER set xt_comentarios = '$comentario' where xt_truckCodigo = '$truckCodigo' ");
		}

		//$s = $db2->Execute("select kp_truckId from RADAR_TRAILER where xt_truckCodigo = '$truckCodigo' ");
		//$r = $s->fetchRow();
		//$truckId = $r[0];
		//echo "$truckId <br>";
		
		
		$archivoExcel = 'tmp/'.trim($_FILES['archivoExcel']['name']);
		echo "$archivoExcel <br>";
		
		echo $_FILES['archivoExcel']['type']."<br>";
		
		
		if($_FILES['archivoExcel']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
			
			echo "Es un archivo Excel .xlsx <br>";
			
			/*
			if (move_uploaded_file($_FILES['archivoExcel']['tmp_name'],$archivoExcel)){
       			echo "El archivo ha sido cargado correctamente. <br>";
    		}else{
       			echo "Ocurrió algún error al subir el fichero. No pudo guardarse. <br>";
    		}
			*/
			
			////////////////////
			
			/** Incluir la ruta **/
			set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
			
			/** Clases necesarias */
			require_once('PHPExcel.php');
			require_once('Classes/PHPExcel/Reader/Excel2007.php');
			
			$inputFileName = 'test.xlsx';
			
			//$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$inputFileType = 'Excel2007';
			
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			
			//Solo para obtener los valores reales sin formato
			//$objReader->setReadDataOnly(true);
			
			$worksheet_names = $objReader->listWorksheetNames($inputFileName);
			echo "Numero de Sheets:".count($worksheet_names)."<br>";
			
			////////////////////
			
			//Paso # 2 Cargar datos a RADAR_TRUCK_SHIPMENT y obtengo shipments para buscar en la carga txt
			//variable $a representa el numero de pagina
			for($a = 0; $a<count($worksheet_names); $a++){
				
				$objReader->setLoadSheetsOnly($worksheet_names[$a]); 
				
				$objPHPExcel = $objReader->load($inputFileName);
				
				$excel = $objPHPExcel->getActiveSheet();	
			
			
				echo "<br>";
				
				echo "Nombre de Sheet: ".$excel->getTitle()."<br>";
				
				$highestRow = $excel->getHighestRow();
				echo "Numero de renglones: $highestRow <br>";
				
				$highestColumnString = $excel->getHighestColumn();
				echo "Ultima Columna: $highestColumnString <br>";
				
				$highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnString);
				echo "numero de columnas: $highestColumn <br>";
			
				//La variable $b representa las columnas
				for($b=0; $b < $highestColumn; $b++){	
					if($worksheet_names[$a] == trim($excel->getCellByColumnAndRow($b, 1)->getFormattedValue())){
						$status[$a] = true;
						echo "$worksheet_names[$a]--".trim($excel->getCellByColumnAndRow($b, 1)->getFormattedValue())."<br>";
						
						//variable $c representa numero de renglon
						for($c = 1; $c <= $highestRow; $c++){;
							$variable = trim($excel->getCellByColumnAndRow(0, $c)->getFormattedValue());
							if($variable == 'FACTURA'){
								$factura = trim($excel->getCellByColumnAndRow(1, $c)->getFormattedValue());
								echo "FACTURA = $factura <br>";
								//$db2->Execute("insert into RADAR_TRUCK_SHIPMENT (kp_shipmentTransitoId,kf_TruckId) values ('$factura',$truckId) ");
								echo "insert into RADAR_TRUCK_SHIPMENT (kp_shipmentTransitoId,kf_TruckId) values ('$factura',$truckId) <br>";
								
								if($status[$a] == true){
									/*		
									//Obtenemos el contenido de archivo txt
									$contenido = str_replace('|','| ',@file_get_contents("cargarArchivos/uploads/$factura.txt"));
									 
									$contenido = explode('|',$contenido);
									
									$numeroCampo = 0;
									$indice = 0;
									$registroValido = 0;
									
									for($e=0; $contenido[$e]; $e++){
										
										//CAMPOS PARA CHECAR SI EL ARCHIVO TXT ESTA COMPLETO
										if($numeroCampo == 33){
											if($lineItem[$indice] != $lineItem[$indice - 1]){
												$EXT[$indice] = trim($contenido[$e]);
												//echo "Line Item = $lineItem[$indice] --- EXT: $EXT[$indice] <br>";
											}else{
													$EXT[$indice] = 0;
													//echo "EXT: $EXT[$indice] <br>";
												}
										}
										
										
										//CAMPOS PARA SHIPMENT
										if($numeroCampo == 0){
											$shipment[$indice] = trim($contenido[$e]);
											//echo "Shipment: $shipment[$indice] <br>";
										}
										
										if($numeroCampo == 1){
											$fechaFactDell[$indice] = date("Y-m-d",strtotime(trim($contenido[$e])));
											//echo "fechaFactDel: $fechaFactDell[$indice] <br>";
										}
										
										if($numeroCampo == 11){
											$awb[$indice] = trim($contenido[$e]);
											//echo "awb: $awb[$indice] <br>";
										}
										
										if($numeroCampo == 15){
											$totalWgtLB[$indice] = trim($contenido[$e]);
											//echo "totalWgtLB: $totalWgtLB[$indice] <br>";
										}
										
										if($numeroCampo == 16){
											$totalWgtKG[$indice] = trim($contenido[$e]);
											//echo "totalWgtKG: $totalWgtKG[$indice] <br>";
										}
										
										if($numeroCampo == 17){
											$totalPkgs[$indice] = trim($contenido[$e]);
											//echo "totalPkgs: $totalPkgs[$indice] <br>";
										}
										
										if($numeroCampo == 18){
											$subtotal[$indice] = trim($contenido[$e]);
											//echo "subtotal: $subtotal[$indice] <br>";
										}
										
										if($numeroCampo == 20){
											$totalAmt[$indice] = trim($contenido[$e]);
											//echo "totalAmt: $totalAmt[$indice] <br>";
										}
										
										//CAMPOS PARA ORDENES
										
										if($numeroCampo == 23){
											$orden[$indice] = trim($contenido[$e]);
											//echo "order: $orden[$indice] <br>";
										}
										
										if($numeroCampo == 22){
											$po[$indice] = trim($contenido[$e]);
											//echo "po: $po[$indice] <br>";
											if(is_numeric($po[$indice])){
												//echo "po es numero <br>";
												$ladoms[$indice] = $po[$indice] - 144000000;
											}else{
													//echo "po es codigo <br>";
													$ladoms[$indice] = 'null';
												}
										}
										
										if($numeroCampo == 31){
											if(trim($contenido[$e]) == ''){
												$qty = 'null';
											}else{
												$qty[$indice] = trim($contenido[$e]);
												//echo "qty: $qty[$indice] <br>";
												}
										}
										
										//CAMPOS PARA LINE ITEM
										if($numeroCampo == 24){	
											$lineItem[$indice] = trim($contenido[$e]);
											//echo "lineItem: $lineItem[$indice] <br>";
										}
										
										if($numeroCampo == 25){
											$product[$indice] = trim($contenido[$e]);
											//echo "product: $product[$indice] <br>";
										}
										
										if($numeroCampo == 26){
											$productDescription[$indice] = trim($contenido[$e]);
											//echo "productDescription: $productDescription[$indice] <br>";
										}
										
										if($numeroCampo == 29){
											if(trim($contenido[$e]) == ''){
												$coo[$indice] = 'null';
											}else{
												$coo[$indice] = trim($contenido[$e]);
												//echo "coo: $coo[$indice] <br>";
												}
										}
										
										if($numeroCampo == 34){
											$hts[$indice] = trim($contenido[$e]);
											//echo "hts: $hts[$indice] <br>";
										}
										
										if($numeroCampo == 35){
											$sysHts[$indice] = trim($contenido[$e]);
											//echo "sysHts: $sysHts[$indice] <br>";
										}
										
										$numeroCampo++;
						
										if($numeroCampo == 43){
											$numeroCampo = 0;	
											$indice++;
											$registroValido++;
										}
									}
									
									//echo "Registros Validos: $registroValido <br>";
									
									if($registroValido >= 1){
										
										$status[$a] = true;
										
										//Apartado para comparacion de valores para saber si el archivo esta completo
										$sumaEXT = 0;
										for($d=1; $d<count($EXT); $d++){
											$sumaEXT += $EXT[$d]; 
										}
										if(trim($totalAmt[1]) != trim($sumaEXT)){
											//echo $totalAmt[1]." = ".$sumaEXT."<br>";
											$statusArchivo[$a] = 'Warning -> Archivo Incompleto';
										}	
										unset($sumaEXT);
										
										
										//Inserta datos a la tabla SHIPMENT
										echo "Inserta a Tabla Shipment: <br> $shipment[1]--$referencia[$c]--$awb[1]--$totalWgtLB[1]--$totalWgtKG[1]--$totalPkgs[1]--$subtotal[1]--$totalAmt[1]--$fechaFactDell[1]<br>";
										echo "-------- <br>";
										$db2->Execute("insert into RADAR_SHIPMENT (kp_Shipment, kf_Referencia, xn_AWB, xd_CargaInicial, xn_WeightLBS, xn_WeightKgs, xn_Packages, xn_Subtotal, xn_Total, xd_FechaFacturacion) values ( '$shipment[1]', '$referencia[$c]', '$awb[1]', SYSDATE(), $totalWgtLB[1], $totalWgtKG[1], $totalPkgs[1], $subtotal[1], $totalAmt[1], '$fechaFactDell[1]')");
										
										//Inserta datos en la tabla ORDENES
										echo "Inserta a Tabla Ordenes: <br>";
										for($d=1; $d<=count($orden); $d++){
											echo "$orden[$d]--$shipment[$d]--$po[$d]--$ladoms[$d]--$qty[$d] <br>";
											$db2->Execute("insert into RADAR_ORDENES (kp_Amf, kf_ShipmentId, xt_Po, xn_Ladoms, xn_qty) values ( '$orden[$d]', '$shipment[$d]', '$po[$d]', $ladoms[$d], $qty[$d])");
										}
					
										//Inserta datos en la tabla LINE_ITEM
										echo "Inserta datos a tabla LINE_ITEM; <br>";
										for($d=1; $d<=count($lineItem); $d++){
											if($lineItem[$d] != $lineItem[$d - 1]){
												echo "$shipment[$d], $lineItem[$d], $orden[$d], $product[$d], $productDescription[$d], $coo[$d], $qty[$d], $EXT[$d], $hts[$d], $sysHts[$d]<br>";
												$db2->Execute("insert into RADAR_LINE_ITEM (kp_LineItemId, xt_LineItem, kf_Amf, xt_Product, xt_ProductDescription, xt_CountryOfOrigin, xn_Qty, xn_Ext, xt_Hts, xt_SysHts) values ( '$lineItem[$d]_$orden[$d]', '$lineItem[$d]', '$orden[$d]', '$product[$d]', '$productDescription[$d]', '$coo[$d]', $qty[$d], $EXT[$d], '$hts[$d]', '$sysHts[$d]')");
											}
										}
										
										unset($shipment); unset($awb); unset($totalWgtLB); unset($totalWgtKG); unset($totalPkgs); unset($subtotal);
										unset($totalAmt); unset($fechaFactDell); unset($orden); unset($po); unset($ladoms); unset($qty); 
										unset($lineItem); unset($product); unset($productDescription); unset($coo); unset($EXT); unset($hts); unset($sysHts);
					
									}else{
											$status[$a] = 0;
										 }
									
									unset($contenido);
									unset($numeroCampo);
									unset($indice);
									*/
								}
							}
							
							//variable para transformar la hora
							$fraccionHora = 1/24;
									
							if($variable == 'FECHA DE APERTURA'){	
								$fechaAperturaShipment = date_format(date_create_from_format('m-d-y',trim($excel->getCellByColumnAndRow(1, $c)->getFormattedValue())),'d-m-Y');
								echo "Fecha apertura : $fechaAperturaShipment <br>";
								echo "update RADAR_SHIPMENT set xd_fechaApertura = '$fechaAperturaShipment' where kp_Shipment = '$factura' <br>";
								//$db2->Execute("update RADAR_SHIPMENT set xd_fechaApertura = '$fechaAperturaShipment' where kp_Shipment = '$factura' ");
								if($a == 0 && $status[$a] == 'true'){
									echo "update RADAR_TRAILER set xd_fecha_apertura = '$fechaAperturaShipment' where xt_truckCodigo = '$truckCodigo' <br>";
									//$db2->Execute("update RADAR_TRAILER set xd_fecha_apertura = '$fechaAperturaShipment' where xt_truckCodigo = '$truckCodigo'");
								}
								unset($fechaAperturaShipment);	
							}
									
							if($variable == 'HORA DE APERTURA'){
								$horaAperturaShipment = trim($excel->getCellByColumnAndRow(1, $c)->getFormattedValue());
								echo "Hora de apertura : $horaAperturaShipment <br>";
								echo "update RADAR_SHIPMENT set xt_horaApertura = '$horaAperturaShipment' where kp_Shipment = '$factura' <br>";
								//$db2->Execute("update RADAR_SHIPMENT set xt_horaApertura = '$horaAperturaShipment' where kp_Shipment = '$factura' ");
								if($a == 0 && $status[$a] == 'true'){
									echo "update RADAR_TRAILER set xt_horaApertura = '$horaAperturaShipment' where xt_truckCodigo = '$truckCodigo' <br>";
									//$db2->Execute("update RADAR_TRAILER set xt_horaApertura = '$horaAperturaShipment' where xt_truckCodigo = '$truckCodigo'");
								}
								unset($horaAperturaShipment);
							}
									
							if($variable == 'FECHA DE CIERRE'){
								$fechaCierreShipment = date_format(date_create_from_format('m-d-y',trim($excel->getCellByColumnAndRow(1, $c)->getFormattedValue())),'d-m-Y');
								echo "Fecha Cierre : $fechaCierreShipment <br>";
								echo "update RADAR_SHIPMENT set xd_fechaCierre = '$fechaCierreShipment' where kp_Shipment = '$factura' <br>";
								//$db2->Execute("update RADAR_SHIPMENT set xd_fechaCierre = '$fechaCierreShipment' where kp_Shipment = '$factura' ");
								//unset($fechaCierreShipment); no lo libero, para usarlo al final //este no se libera para usarce al final ****
							}
									
							if($variable == 'HORA DE CIERRE'){
								$horaCierreShipment = trim($excel->getCellByColumnAndRow(1, $c)->getFormattedValue());
								echo "Hora cierre : $horaCierreShipment --- $celdaFechaCierre <br>";
								echo "update RADAR_SHIPMENT set xt_horaCierre = '$horaCierreShipment' where kp_Shipment = '$factura' <br>";
								//$db2->Execute("update RADAR_SHIPMENT set xt_horaCierre = '$horaCierreShipment' where kp_Shipment = '$factura' ");
								//unset($horaCierreShipment); no lo libero, para usarlo al final //este no se libera para usarce al final ****
							}
	
						}
						
						$b = $highestColumn; //para salir del for
						
					}else{
							$status[$a] = false;
							//echo "$sheets[$a]--".trim($data->sheets[$a]['cells'][1][$b])."--$status[$a] <br>";	
						}
				}

				if($status[$a] == true){
					
					echo "<table border='1'>";
						echo "<tr>";
							echo "<td>Orden</td>";
							echo "<td>Service Tag</td>";
						echo "</tr>";
					
						$ordenIndex = 0;
						$serviceTagIndex = 0;
						
						for ($i = 2; $i <= $highestRow; $i++) {
							$variable = trim($excel->getCellByColumnAndRow(0, $i)->getFormattedValue());
							//echo "$variable <br>";
							
							if($variable == ''){
								$i = $highestRow;
							}
									
							if(is_numeric($variable)){
								$orden[$ordenIndex] = $variable;
								$ordenIndex++;
							}else if(! is_numeric($variable)){
									$serviceTag[$serviceTagIndex] = $variable;
									$serviceTagIndex++;
								}
									
							unset($variable);
									
						}
							
						for($j=0; $j<count($orden); $j++){
							echo "<tr>";
								echo "<td>$orden[$j]</td>";
								echo "<td>$serviceTag[$j]</td>";
							echo "</tr>";
							//echo "insert into RADAR_SERVICE_TAG (kp_serviceTagId, kf_amf) values ('$serviceTag[$j]','$orden[$j]') <br>";
							//$db2->Execute("insert into RADAR_SERVICE_TAG (kp_serviceTagId, xt_serviceTag, kf_amf) values ('$serviceTag[$j]_$orden[$j]', '$serviceTag[$j]', '$orden[$j]')");
						} 
							
					echo "</table>";
							
					unset($orden);
					unset($serviceTag);
							
					echo "Sheet ".($a+1)." Carga Exitosa <br><br><br>";
								 
				}
			}
	
			
			
			//cargo a radar trailer la ultima fecha y hora almacenada en $fechaCierreShipment y $horaCierreShipment
			//$db2->Execute("update RADAR_TRAILER set xd_fecha_cierre = '$fechaCierreShipment', xt_horaCierre = '$horaCierreShipment' where xt_truckCodigo = '$truckCodigo'");
			
			//$db2->Execute("update RADAR_TRAILER set xd_fecha_Salida_Planta = '$fechaCierreShipment', xt_hora_salida_planta = '$horaCierreShipment' where xt_truckCodigo = '$truckCodigo'");
			echo "fecha y hora cierre del truck : $fechaCierreShipment - $horaCierreShipment <br>";

			
			if (file_exists($archivoExcel)) {
				unlink($archivoExcel);
				echo "Archivo borrado correctamente <br>";
			}else{ echo "Borrado de archivo Incorrecto <br>";}
			
		}else{echo "No es un Archivo Excel <br>";}
			
	}
	
    ?>
	
</body>
</html>