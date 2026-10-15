<?php
$nombreDocumentoP =""; 
$nombrephp = 'FichaItem.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

$ficheros = scandir('../../FILES/');
//var_dump($ficheros);

$documentos = $INTRANETV2->getArray("SELECT xt_contenido, xt_codigoDocumento FROM sgi_manuales_elementos WHERE xt_tipoElemento='A' ORDER BY xt_codigoDocumento");
foreach($documentos as $registro){
	$nombreArchivo = explode('/', $registro['xt_contenido'])[count(explode('/', $registro['xt_contenido'])) - 1];
	if(in_array($nombreArchivo, $ficheros) == true){
		$estatus = 1;
	}else{
		$estatus = 0;
		echo $registro['xt_codigoDocumento']." - ".$estatus." - ".$nombreArchivo."<br>";
	}
	
}


?>

