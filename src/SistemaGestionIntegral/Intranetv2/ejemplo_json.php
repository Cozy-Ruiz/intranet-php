<?php

//me conecto a la BD
require_once("../../ConexionIntranet2.php");

//obtengo la informacion de la tabla de catalogo 

$s = $INTRANETV2->Execute("SELECT xt_codigoManual, xt_nombre FROM SGI_Catalog_Manuales");


$arrManuales = array();

while($b=$s->fetch_assoc()){
	//creamos el array con los datos
	$arrManuales[] = array('post'=>$b);
	
}

//formateamos a json

header('Content-type: application/json');
 echo json_encode(array('posts'=>$arrManuales));

	






?>