<?php


class Evidencias
{
function agregarEvidencia($conexion){
	
	$conexion->Query("INSERT INTO SGI_Simulacros_Evidencias(xt_codigoSimulacro, xt_nombre, xt_fechaSubida) VALUES('NYE-S-NLR-18-01', 'codigoS', '2018-07-09 14:25:10')");
}
}

?>