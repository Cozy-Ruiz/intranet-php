<?php
require_once("../../ConexionIntranet2.php");

	$evaluacion   		   = $_POST['evaluacion'];
	$descripcionEvaluacion = $_POST['descripcionEvaluacion'];
	$simulacro 			   = $_POST['simulacro'];

	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_evaluacionSimulacro = '$evaluacion', xt_descripcionEvaluacionSimulacro = '$descripcionEvaluacion' WHERE xt_codigoSimulacro = '$simulacro'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>