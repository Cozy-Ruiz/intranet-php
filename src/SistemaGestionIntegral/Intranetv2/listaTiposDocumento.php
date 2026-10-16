<?php
require_once("../../ConexionDBT.php");
//require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");


$nombre = $_POST['nombre'];
$options = "";


if($nombre == "Documentos"){
	
	$s = $INTRANETV2->Execute("SELECT xt_codigoDocumento, xt_nombre FROM SGI_Manuales_Documentos");
	
	echo "<option selected='selected'>Selecionar...</option>";	
	while($r = $s->fetchRow()){
		 
		 $options.= '<option value='.$r[0].'>'.$r[0].'--'.substr($r[1], 0, 50).'...</option>';
	}
	echo $options;
	
	
}

if($nombre == "Funcionalidades"){
	
	$s = $INTRANETV2->Execute("SELECT xt_codigoFuncionalidad, xt_nombre FROM SGI_Funcionalidades");
	
	echo "<option selected='selected'>Selecionar...</option>";	
	while($r = $s->fetchRow()){
		 
		 $options.= '<option value='.$r[0].'>'.$r[0].'--'.substr($r[1], 0, 50).'...</option>';
	}
	echo $options;
	
	
}





?>

