<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "eliminarRegistroAgenda"){

	$clave	 = $_POST['clave'];
	$auditor = $_POST['auditor'];
	$tipo    = $_POST['tipo'];
	
	if($INTRANETV2->Execute("DELETE FROM SGI_Auditorias_Agenda WHERE xt_claveAuditoria = '$clave' AND xt_auditor = '$auditor' AND xt_tipo = '$tipo'")){
		echo true;
	}else{
		echo "Hubo un error al eliminar los datos.";
	}

}