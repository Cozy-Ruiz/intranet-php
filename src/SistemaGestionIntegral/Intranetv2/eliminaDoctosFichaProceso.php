<?php
require_once("../ConexionIntranet2.php");

if(isset ($_GET['codigo']) && isset ($_GET['ruta'])){
		
	$tipoArchivo      = $_GET['nombreA']; 
	$ruta             = $_GET['ruta'];
	$nombrephp        = $_GET['nombrephp'];
	$codigo           = $_GET['codigo'];
	
	
	//echo $nomA= str_replace(' ','_',$archivoElimina); 
	$enlace = $ruta;
	//echo $enlace = "C:/xampp/htdocs/radar/1899/liz/".$archivoElimina;
//error_reporting(E_ALL ^ E_NOTICE);
 if($nombrephp == 'fichaProceso.php'){
		
			unlink($enlace);
			
			if($INTRANETV2->Execute("DELETE FROM SGI_Documentacion where xt_codigoProceso = '$codigo' AND xt_ruta = '$enlace'")){
			
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2".$nombrephp."?proceso=".$codigo." ");
			}else{
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2".$nombrephp."?proceso=".$codigo." ");
			}
		//}
	}
	
//echo 'Archivo borrado correctamente';

}

?>