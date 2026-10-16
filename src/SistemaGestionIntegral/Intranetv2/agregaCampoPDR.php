<?php
require_once("../../ConexionIntranet2.php");

	$pdr    	  = $_POST['pdr'];
	$simulacro    = $_POST['simulacro'];
	
	if($pdr=='null'){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_pdrSimulacro = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
			echo true;
		}else{
			echo "Hubo un error al actualizar los datos";
		}		
	} else {
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xt_pdrSimulacro = '$pdr' WHERE xt_codigoSimulacro = '$simulacro'")){
			echo true;
		}else{
			echo "Hubo un error al actualizar los datos";
		}		
	}



?>