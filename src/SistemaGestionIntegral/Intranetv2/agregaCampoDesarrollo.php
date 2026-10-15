<?php
require_once("../../ConexionIntranet2.php");

	$desarrollo   = $_POST['desarrollo'];
	$simulacro = $_POST['simulacro'];

	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_desarrolloSimulacro = '$desarrollo' WHERE xt_codigoSimulacro = '$simulacro'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>