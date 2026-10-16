<?php
require_once("../../ConexionIntranet2.php");

	$alcance   = $_POST['alcance'];
	$simulacro = $_POST['simulacro'];

	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_alcanceSimulacro = '$alcance' WHERE xt_codigoSimulacro = '$simulacro'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>