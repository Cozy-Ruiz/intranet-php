<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "agregarValoresElabora"){

	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fechaPost	= $_POST['fecha'];
	$fecha = new DateTime($fechaPost);
	$hora  = new DateTime($fechaPost);
	$fecha = $fecha->format('Y-m-d');
	$hora  = $hora->format('H:i:s');
	$fecha = $fecha." ".$hora;

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
	$fechaPost	= $_POST['fecha'];
	$fecha = new DateTime($fechaPost);
	$hora  = new DateTime($fechaPost);
	$fecha = $fecha->format('Y-m-d');
	$hora  = $hora->format('H:i:s');
	$fecha = $fecha." ".$hora;
	
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
	$fechaPost	= $_POST['fecha'];
	$fecha = new DateTime($fechaPost);
	$hora  = new DateTime($fechaPost);
	$fecha = $fecha->format('Y-m-d');
	$hora  = $hora->format('H:i:s');
	$fecha = $fecha." ".$hora;
	
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
	$fechaPost	= $_POST['fecha'];
	$fecha = new DateTime($fechaPost);
	$hora  = new DateTime($fechaPost);
	$fecha = $fecha->format('Y-m-d');
	$hora  = $hora->format('H:i:s');
	$fecha = $fecha." ".$hora;
	$finalizada = $_POST['finalizada'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_nombreTermina = '$auditor', xt_comentarioTermina = '$comentario', xd_fechaTermina = '$fecha', xt_status = '$finalizada' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}

}
if($_REQUEST['evento'] == "agregarValoresRealizar"){
	$clave		= $_POST['clave'];
	$auditor    = $_POST['auditor'];
	$comentario = $_POST['comentario'];
	$fechaPost	= $_POST['fecha'];
	$fecha = new DateTime($fechaPost);
	$hora  = new DateTime($fechaPost);
	$fecha = $fecha->format('Y-m-d');
	$hora  = $hora->format('H:i:s');
	$fecha = $fecha." ".$hora;
	$realizada = $_POST['realizada'];

	if($INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_nombreRealizo = '$auditor', xt_comentarioRealizo = '$comentario', xd_fechaRealizo = '$fecha', xt_status = '$realizada' WHERE xt_claveAuditoria = '$clave'")){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos.";
	}
}
?>
