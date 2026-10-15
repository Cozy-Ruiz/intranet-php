<?php
require_once("../../ConexionIntranet2.php");

	$resultado   = $_POST['resultado'];
	$simulacro = $_POST['simulacro'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_resultadoSimulacro = '$resultado' WHERE xt_codigoSimulacro = '$simulacro'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>