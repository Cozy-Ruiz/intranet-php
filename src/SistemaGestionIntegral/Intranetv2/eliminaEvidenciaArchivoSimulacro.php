<?php
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");	
  
if(isset($_GET['evidencia'])){
	$evidencia = $_GET['evidencia'];
	$simulacro = $_GET['simulacro'];
	$enlace    = $_GET['ruta'];
	if(isset($_GET['confirmacion'])){
	$confirmacion    = $_GET['confirmacion'];
		}
	

	echo "<script>
	if(confirm('¿Eliminar archivo?')){ 

document.location='eliminaEvidenciaArchivoSimulacro.php?evidencia=".$evidencia."&simulacro=".$simulacro."&ruta=".$enlace."&confirmacion=1';} 

else
{
	javascript:history.back();
}
 </script>";  

 if($confirmacion==1)

 	{  if($INTRANETV2->Execute("INSERT INTO SGI_Control_Eliminacion (xt_seccion,kf_actorID,xt_descripcion) VALUES ('$simulacro','$usuarioId','Eliminacion de $enlace')")) 
	 		{
	 			if($INTRANETV2->Execute("DELETE FROM SGI_Simulacros_Evidencia where xn_codigoEvidencia = '".$evidencia."' and xt_codigoSimulacro ='".$simulacro."'"  )){
	 		 		 
	 		 		if($INTRANETV2->Execute("UPDATE SGI_Evidencia SET xt_ruta = NULL WHERE xn_codigoEvidencia = '".$evidencia."' and xt_codigoSimulacro ='".$simulacro."'")){
	 		 		    	unlink($enlace); 
	 		 				header ("Location: https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/simulacroElementoActualizar.php?simulacro=$simulacro");
	 		 		}
	 			}
	 		}
	}
}
?>