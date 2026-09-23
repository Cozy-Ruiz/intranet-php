<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "agregarValoresElabora"){

	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fecha		= $_POST['fecha'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Auditorias_Planes SET xt_nombreElabora = '$auditor', xt_comentarioElabora = '$comentario', xn_status = 1, xd_fechaElabora = '$fecha' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}

}
if($_REQUEST['evento'] == "agregarValoresRevisar"){

	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fecha		= $_POST['fecha'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Auditorias_Planes SET xt_nombreRevisa = '$auditor', xt_comentarioRevisa = '$comentario', xn_status = 2, xd_fechaRevisa = '$fecha' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}

}
if($_REQUEST['evento'] == "agregarValoresAprobar"){

	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fecha		= $_POST['fecha'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Auditorias_Planes SET xt_nombreAprueba = '$auditor', xt_comentarioAprueba = '$comentario', xn_status = 3, xd_fechaAprueba = '$fecha' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}

}
if($_REQUEST['evento'] == "agregarValoresTerminar"){

	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fecha		= $_POST['fecha'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_nombreTermina = '$auditor', xt_comentarioTermina = '$comentario', xd_fechaTermina = '$fecha' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}

}
?>
