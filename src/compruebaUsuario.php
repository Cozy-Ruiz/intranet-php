<?php
/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 1.0
 *@copyright Copyright (c) 2015, Grupo Escalante Agencias Aduanales S.C.
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
 
//Inicio la sesión
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["autentificado"] != "SI") {
	header("Location: Home.php");
	exit();
}else{
	$sesionId = $_SESSION["sesionId"];
	$usuarioId = $_SESSION["sesionUsuario"];
	$sesionHoraAcceso = $_SESSION["sesionHoraAcceso"];
	$sesionHoraActual = date('H:i:s');
	//Para no modificar intranet (NOTA)
	$estiloUsuario = $_SESSION["sesionEstilo"];
	
	$tiempoTranscurrido = (strtotime($sesionHoraActual)-strtotime($sesionHoraAcceso));
	
	if($tiempoTranscurrido >= 18000){
		$sesionId = $_SESSION["sesionId"];
		$usuarioId = $_SESSION["sesionUsuario"];
		$sesionFechaSalida = date('Y-m-d');
		$sesionHoraSalida = date('H:i:s');
		
		$INTRANET->Execute("update IntranetGEA_SESIONES_USUARIOS set xd_fechaSalida = '$sesionFechaSalida', xt_horaSalida = '$sesionHoraSalida' where kp_sesionId = $sesionId and kf_usuario = '$usuarioId' ");
		
		header("Location: cerrarSesion.php");
	
	}else{
		
		$_SESSION["sesionHoraAcceso"] = $sesionHoraActual;
		
		$status = 'false';
		
		$s = $INTRANET->Execute("select * from IntranetGEA_USUARIOS_CATALOGO_PHP where  kf_usuarioId = '$usuarioId' ");
		while($r = $s->FetchRow()){
			$status = 'true';
			//echo $_SESSION["categoria"];
		}
		
		if($status == 'false'){
			header("Location: error.php");
		}	
	} 	
}
?>