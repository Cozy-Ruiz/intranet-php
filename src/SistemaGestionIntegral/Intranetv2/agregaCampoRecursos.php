<?php
require_once("../../ConexionIntranet2.php");

$recursos  = $_POST['recursos'];
$simulacro = $_POST['simulacro'];

if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_recursosSimulacro = '$recursos' WHERE xt_codigoSimulacro = '$simulacro'")){
	echo true;
}else{
	echo "Hubo un error al actualizar Descripcion";
}
?>
