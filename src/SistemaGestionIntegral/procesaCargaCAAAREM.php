<?php error_reporting(0); ?>
<?php
$nombrephp = 'procesaCargaCAAAREM.php';
require_once('conexionMasterDB.php');
require_once('conexionMexicoDB.php');

/** Error reporting */
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Europe/London');
/**PHPExcel**/
require_once("PHPExcel/Classes/PHPExcel.php");
//require_once('PHPExcel/Classes/PHPExcel.php');

// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );


    return $string;
}

$upload_folder ='Lee_archivo/FILES';
$nombre_archivo = $_FILES['archivo']['name'];
$tipo = $_FILES['archivo']['type'];
$tamanio = $_FILES['archivo']['size'];
$archivotmp = $_FILES['archivo']['tmp_name'];
$respuesta = new stdClass();

$nombre_archivo = limpiar_caracter_especial($nombre_archivo);

$archivador = $upload_folder . '/' . $nombre_archivo;
	
if(move_uploaded_file($archivotmp, $archivador) ){
	
	$respuesta->estado = true;
	
} else {
	$respuesta->estado = false;
	$respuesta->mensaje = "El archivo no se pudo subir al servidor, intentalo mas tarde";
}

//if($respuesta->estado){
	
	
	$rutaPatente = "$archivador";
	//$rutaPatente = 'Lee_archivo/FILES/CopiadeSolicitud_GEBDF1601219.xlsx';
		
	  if(file_exists($rutaPatente)){
		  
		  $respuesta->estado = true;
		  $inputFileType = PHPExcel_IOFactory::identify($rutaPatente);
		  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		  $worksheet_names = $objReader->listWorksheetNames($rutaPatente);
	  
		   for($a=0; $a<count($worksheet_names); $a++){
	
			   if(trim($worksheet_names[$a]) == "Sheet0"){
				   
				  $objReader->setLoadSheetsOnly($worksheet_names[$a]);
				  
				  $objReader->setReadDataOnly(true);
				  $objPHPExcel = $objReader->load($rutaPatente);
				
				  $excel = $objPHPExcel->getActiveSheet();
				  
				  //echo "Nombre Sheet: ".$excel->getTitle()."<br>";
				  $highestRow = $excel->getHighestRow();
				  
				  $highestColumnString = $excel->getHighestColumn();
				  //echo "Ultima Columna: $highestColumnString <br>";
		
				  $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnString);
				  //echo "Numero de columnas: $highestColumn <br>";
		
				  $nuevoExcel = new PHPExcel();
				  
				  $indice = 0;
				  $conteo = 0;
				  
				   for($h=0; $h<=$highestRow; $h++){
					   
					   $pedimento       = $excel->getCellByColumnAndRow(0,$h)->getFormattedValue();
					   $tipoOperacion   = $excel->getCellByColumnAndRow(4,$h)->getFormattedValue();
					   $claveAduanero   = $excel->getCellByColumnAndRow(7,$h)->getFormattedValue();
					   $rfc             = $excel->getCellByColumnAndRow(8,$h)->getFormattedValue();
					   $fechaCruce      = $excel->getCellByColumnAndRow(15,$h)->getFormattedValue();
					   $estado          = $excel->getCellByColumnAndRow(20,$h)->getFormattedValue();
					   $subEstado       = $excel->getCellByColumnAndRow(21,$h)->getFormattedValue();					   
					   
					  
	
					   $nuevaFecha = date("Y-d-m H:i:s",strtotime($fechaCruce));
					   		
						  
						   if(is_numeric($pedimento) !='' && $rfc != '' && $nuevaFecha != '' && $subEstado != 'RECTIFICADO'){
						
								$separaFecha = explode(' ', $nuevaFecha);
								$hora        =   $separaFecha[1];
								
								if($tipoOperacion == 'IMP'){
									$tipo = '1';
								}else if($tipoOperacion == 'EXP'){
									$tipo = '2';
								}
								
								if($estado == 'DESADUANADO/CUMPLIDO'){
									
									$nuevoEstado = 1;
									
								}else if($estado == 'PRIMER RECONOCIMIENTO'){
									
									$nuevoEstado = 2;
									
								}							
									
								$referencia = $MASTER_GE->getOne("SELECT distinct xt_referencia FROM MASTER_PEDIMENTOS WHERE SUBSTRING_INDEX(kp_pedimento,'-',-1) = '".$pedimento."' AND xt_rfcCausante = '".$rfc."' AND xt_tramiteAduanero = '".$claveAduanero."' AND xn_tipoOperacion = '".$tipo."'");
				
							
								
								$Pedimento[$indice] = $pedimento;
								$Tipo[$indice]      = $tipo;
								$ClaveAduanero[$indice] = $claveAduanero;
								$RFC[$indice]       = $rfc;
								$CRUCE[$indice]     = $nuevaFecha;
								$HORA[$indice]      = $hora;
								$ESTADO[$indice]    = $nuevoEstado;
								$Referencia[$indice] = $referencia;
			
								
								$indice++;
						   }
							
				   }
		   
				    $pedimentos = array(); //declaro array vacio que tendra todas los pedimentos sin repetir 
						
					for($i=0;$i<count($Pedimento);$i++){  
					
					//if($Referencia[$i] == '16-408420'){
					
						if (in_array($Pedimento[$i], $pedimentos)) {//si pedimento ya esta en el array, muestra el resultado 
						
							$pedimentos[]  = $Pedimento[$i];
							
							$separa = substr($HORA[$i],0,5);
	
							$sql = "update MASTER_PEDIMENTOS set xd_fechaCruce = '".$CRUCE[$i]."' WHERE SUBSTRING_INDEX(kp_pedimento,'-',-1) = '".$Pedimento[$i]."' AND xt_rfcCausante = '".$CRUCE[$i]."' AND xt_tramiteAduanero = '".$ClaveAduanero[$i]."' ";
				
							if(!$MASTER_GE->query($sql)){			
									$respuesta->estado = false;
									$respuesta->mensaje = "El pedimento $pedimento no se actualizo, verifica la información \n"; 				
							}
							
							$SCIA->Execute("UPDATE SCIA.T_TRAFICOCRUCE SET  HC2_TRAFICOCRUCE = '$separa', SEM_TRAFICOCRUCE = $ESTADO[$i] WHERE  NTR_TRAFICOCRUCE = '".$Referencia[$i]."' ");
						
						}else{// Muestra pedimentos con ID unico
							
							$pedimentos[] = $Pedimento[$i];
							
							$separa = substr($HORA[$i],0,5);
								
							$existeReferencia = $SCIA->getOne("SELECT NTR_TRAFICOCRUCE  FROM SCIA.T_TRAFICOCRUCE WHERE  NTR_TRAFICOCRUCE = '".$Referencia[$i]."'");
								
							$sql = "update MASTER_PEDIMENTOS set xd_fechaCruce = '".$CRUCE[$i]."' WHERE SUBSTRING_INDEX(kp_pedimento,'-',-1) = '".$Pedimento[$i]."' AND xt_rfcCausante = '".$CRUCE[$i]."' AND xt_tramiteAduanero = '".$ClaveAduanero[$i]."' ";
				
							if(!$MASTER_GE->query($sql)){			
									$respuesta->estado = false;
									$respuesta->mensaje = "El pedimento $pedimento no se actualizo, verifica la información \n"; 				
							}
							
							if($Referencia[$i] != '' && $existeReferencia == ''){
								
							$SCIA->Execute("INSERT INTO SCIA.T_TRAFICOCRUCE (CVE_TRAFICOCRUCE,PPD_TRAFICOCRUCE, FCR_TRAFICOCRUCE, HC1_TRAFICOCRUCE, SE1_TRAFICOCRUCE, NTR_TRAFICOCRUCE) VALUES (400000,'$Pedimento[$i]',TO_DATE('".$CRUCE[$i]."','YYYY-MM-DD HH24:MI:SS'), '$separa', $ESTADO[$i], '$Referencia[$i]') ");
						
							}else {
								
								$SCIA->Execute("UPDATE SCIA.T_TRAFICOCRUCE SET FCR_TRAFICOCRUCE = TO_DATE('".$CRUCE[$i]."','YYYY-MM-DD HH24:MI:SS') , HC1_TRAFICOCRUCE = '$separa', SE1_TRAFICOCRUCE = $ESTADO[$i] WHERE  NTR_TRAFICOCRUCE = '".$Referencia[$i]."' ");
									
								
									
							}
			
						}
					}
					//}
						
					if($respuesta->estado == true){
				 
						$respuesta->mensaje = "Se actualizaron correctamente los registros\n";
	
					  }
					  
			   }else{
						$respuesta->estado = false;
						$respuesta->mensaje = "No se pudo leer el archivo\n";
			   }
		   }
	  }
/*}else{
$respuesta->estado = false;
$respuesta->mensaje = "No se cargo ningun archivo";
}*/
	
unlink($rutaPatente);

echo json_encode($respuesta);

?>
       
