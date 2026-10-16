<?php
require_once('../ConexionIntranet2.php');

$evento      = $_REQUEST["evento"];
$descripcion = $_REQUEST['descripcion'];

$datos = array();
$arreglo = [];
$a = $INTRANETV2->Execute("SELECT xt_codigoDocumento, xt_codigoCompleto, xt_nombre FROM SGI_Manuales_Documentos where xt_nombre Like '%".$descripcion."%'");	
while($t = $a->fetchRow()){
			
	$datos["Codigo"] = $t["xt_codigoDocumento"];  
    $datos["CodigoCompleto"]  = $t["xt_codigoCompleto"];  
    $datos["nombre"] = utf8_encode($t["xt_nombre"]); 
    $arreglo[] = $datos;
		
}

$json = new stdClass();
$json->RegistrosManuales[] = ["MANUALES" => $arreglo];
$jsonstring = json_encode($json);
echo $jsonstring;

?>