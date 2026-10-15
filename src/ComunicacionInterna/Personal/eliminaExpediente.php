<?php
require_once("../../ConexionDBT.php");

if(isset($_REQUEST["evento"])){
	
	if($_REQUEST["evento"] == "eliminaDocumento"){
		//echo "DELETE FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '".$_GET[usuario]."' AND xt_ruta_archivo = '".$_GET[ruta]."' ";
		$INTRANET->Execute("DELETE FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '".$_REQUEST['usuario']."' AND xt_ruta_archivo = '".$_REQUEST['ruta']."' ");
		unlink($_REQUEST['ruta']);
	}

	if($_REQUEST["evento"] == "aceptaDocumento"){
		$INTRANET->Execute("UPDATE SGI_EXPEDIENTE_PERSONAL SET xt_estatus = 'Aceptado' WHERE xt_usuario_empleado = '".$_REQUEST['usuario']."' AND xt_tipo_expediente = '".$_REQUEST['tipoArchivo']."' ");
	}

	if($_REQUEST["evento"] == "rechazaDocumento"){
		$INTRANET->Execute("UPDATE SGI_EXPEDIENTE_PERSONAL SET xt_estatus = 'Rechazado' WHERE xt_usuario_empleado = '".$_REQUEST['usuario']."' AND xt_tipo_expediente = '".$_REQUEST['tipoArchivo']."' ");
	}

	if($_REQUEST["evento"] == "rechazaFoto"){
		$INTRANET->Execute("UPDATE perfiles.usuarios SET xd_fechaActualizacionFoto = NULL WHERE xt_usuario = '".$_REQUEST['usuario']."' ");
		//$INTRANET->Execute("UPDATE perfiles.usuarios SET xt_foto = '', xd_fechaActualizacionFoto = 'Null' WHERE xt_usuario = '".$usuario."' ");
    	// $INTRANET->Execute("UPDATE intranetgea.sgi_empleados SET xn_Foto = 'FILES/".$fileName."' WHERE kf_usuario = '".$usuario."' ");
	}

}
?>