<?php
require_once("../../ConexionIntranet2.php");
if(isset($_GET['evidencia'])){
	$evidencia = $_GET['evidencia'];
	$simulacro = $_GET['simulacro'];
	if($INTRANETV2->Execute("DELETE FROM SGI_Simulacros_Evidencia where xn_codigoEvidencia = '".$evidencia."'")){
		echo "DELETE FROM SGI_Simulacros_Evidencia where xn_codigoEvidencia = '".$evidencia."'";
	    if($INTRANETV2->Execute("UPDATE SGI_Evidencia SET xt_contenido = NULL WHERE xn_codigoEvidencia = '".$evidencia."'")){
	    	echo "UPDATE SGI_Evidencia SET xt_ruta = NULL WHERE xn_codigoEvidencia = '".$evidencia."'";
			header ("Location: https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/simulacroElementoActualizar.php?simulacro=$simulacro");
		}
	}	
}
?>