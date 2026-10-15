<?php
require_once("../ConexionDBT.php");
require_once("../ConexionIntranet2.php");
error_reporting(E_PARSE);

if(isset ($_GET['parametros'])){

	$parametros      = $_GET['parametros'];
	$parametros = base64_decode($parametros);

	$separaParametros = explode(",", $parametros);
	$procesoP         = $separaParametros[0];
	$rolP             = $separaParametros[1];
	$actividadP       = $separaParametros[2];
	$funcionalidadP   = $separaParametros[3];
	$casoUsoP         = $separaParametros[4];
	$usuario		  = $separaParametros[5];
	$nombrephp        = $separaParametros[6];
	$nombreA          = $separaParametros[7];
	$ruta 			  = $separaParametros[8];
	$codigo           = $casoUsoP;
	$codProceso       = $procesoP;

	$enlace = $ruta;

	if($nombrephp == 'fichaCasoUsov3.php'){
		
		unlink($enlace);
		
		if($INTRANETV2->Execute("DELETE FROM SGI_Casos_Uso_Archivos where xt_codigoCasoUso = '$casoUsoP' AND xt_ruta = '$enlace'")){
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
					SL.xt_codigo = '$codProceso'
				AND SL.xt_tipo = 'Proceso'
			");

			while($r = $s->fetchRow()){
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];	
			} unset($r);
			echo "DELETE FROM SGI_Casos_Uso_Archivos where xt_codigoCasoUso = '$casoUsoP' AND xt_ruta = '$enlace'";
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/controlCambiosv4.php?casoUso=".$casoUsoP."&funcionalidad=".$funcionalidadP."&actividad=".$actividadP."&rol=".$rolP."&proceso=".$codProceso." ");
			} else {
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaCasoUsov3.php?casoUso=".$casoUsoP."&funcionalidad=".$funcionalidadP."&actividad=".$actividadP."&rol=".$rolP."&proceso=".$codProceso." ");
			}			
		}else{
			echo "DELETE FROM SGI_Casos_Uso_Archivos where xt_codigoCasoUso = '$casoUsoP' AND xt_ruta = '$enlace'";
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
					SL.xt_codigo = '$codProceso'
				AND SL.xt_tipo = 'Proceso'
			");

			while($r = $s->fetchRow()){
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];	
			} unset($r);

			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/controlCambiosv4.php?casoUso=".$casoUsoP."&funcionalidad=".$funcionalidadP."&actividad=".$actividadP."&rol=".$rolP."&proceso=".$codProceso." ");
			} else {
				header ("Location: http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaCasoUsov3.php?casoUso=".$casoUsoP."&funcionalidad=".$funcionalidadP."&actividad=".$actividadP."&rol=".$rolP."&proceso=".$codProceso." ");
			}	
		}

	}
	
}

?>