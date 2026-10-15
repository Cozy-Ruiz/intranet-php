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
 if($nombrephp == 'fichaProcesov2.php'){
			unlink($enlace);
			
			if($INTRANETV2->Execute("DELETE FROM SGI_Documentacion where xt_codigoProceso = '$codigo' AND xt_ruta = '$enlace'")){
				
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '$codigo'
					AND SL.xt_tipo = 'Proceso'
				");

				while($r = $s->fetchRow()){
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];	
				} unset($r);

				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/controlCambiosv4.php?proceso=$codigo");
				} else {
					header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProcesov2.php?proceso=$codigo");
				}
			}else{
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '$codigo'
					AND SL.xt_tipo = 'Proceso'
				");

				while($r = $s->fetchRow()){
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];	
				} unset($r);

				if ($usuarioLibera != NULL && $usuarioLibera != ''){

					header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/controlCambiosv4.php?proceso=$codigo");
				} else {

					header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProcesov2.php?proceso=$codigo");
				
				}
			}
		//}
	}
	
//echo 'Archivo borrado correctamente';

}

?>