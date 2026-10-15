<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "actualizarCamposGenerales"){

	$nombre  	  = $_POST['nombre'];
	$descripcion  = $_POST['descripcion'];
	$simulacro    = $_POST['simulacro'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_nombreSimulacro = '$nombre' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_descripcionSimulacro = '$descripcion' WHERE xt_codigoSimulacro = '$simulacro'")){
			echo true;
		}else{
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
?>