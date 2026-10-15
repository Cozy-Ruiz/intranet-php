<?php
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");	
  	
if(isset($_GET['simulacro'])&&isset($_GET['aviso'])){
	$simulacro = $_GET['simulacro'];
	$aviso = $_GET['aviso'];
	$enlace    = $_GET['ruta'];
	if(isset($_GET['confirmacion'])){
	$confirmacion    = $_GET['confirmacion'];
		}
	

	echo "<script>
	if(confirm('¿Eliminar archivo?')){ 

document.location='eliminaDocumentoAvisoSimulacro.php?aviso=".$aviso."&simulacro=".$simulacro."&ruta=".$enlace."&confirmacion=1';} 

else
{
	javascript:history.back();
}
 </script>";  

 if($confirmacion==1)
 	{unlink($enlace);	
 		if($INTRANETV2->Execute("INSERT INTO SGI_Control_Eliminacion (xt_seccion,kf_actorID,xt_descripcion) VALUES ('$simulacro','$usuarioId','Eliminacion de  $enlace')")) 
	 	{  
	 		if($INTRANETV2->Execute("UPDATE SGI_Simulacros_Avisos SET xt_rutaAvisoSimulacro = NULL WHERE xt_codigoSimulacro = '".$simulacro."' AND xt_codigoAviso = '".$aviso."'")){
	  			header ("Location: https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/simulacroElementoActualizar.php?simulacro=$simulacro");}
	  	}
	}
}
?>

 