<?php error_reporting(0); ?>
<?php
/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 1.0
 *@copyright Copyright (c) 2015, Grupo Escalante Agencias Aduanales S.C.
 */
 
//Inicio la sesión
session_start();

$listaFuncionalidades = null;
$listaOficinas = null;

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["autentificado"] != "SI") {
	//si no existe, envio a la página de autentificacion
	header("Location: https://escalante.com.mx/Sistemas/");
	//ademas salgo de este script
	exit();
}else{
	$sesionId = $_SESSION["sesionId"];
	$sesionUsuario = $_SESSION["sesionUsuario"];
	$sesionHoraAcceso = $_SESSION["sesionHoraAcceso"];
	$sesionHoraActual = date('H:i:s');
	$sesionEstilo = $_SESSION["sesionEstilo"];
	$tiempoTranscurrido = (strtotime($sesionHoraActual)-strtotime($sesionHoraAcceso));
	
	if($tiempoTranscurrido >= 18000){
		$sesionId = $_SESSION["sesionId"];
		$sesionUsuario = $_SESSION["sesionUsuario"];
		$sesionFechaSalida = date('Y-m-d');
		$sesionHoraSalida = date('H:i:s');
		
		header("Location: https://escalante.com.mx/Sistemas/cerrarSesion.php");
	}else{
		
		$_SESSION["horaAcceso"] = $sesionHoraActual;
		
		$status = 'false';
		
		$indiceFuncionalidad = 0;
		if($moduloScript != '' && $oficinaScript != ''){
			$s = $MASTER_GE->Execute("SELECT distinct xt_funcionalidad FROM PERFILES.FUNCIONALIDADES where xt_usuario = '$sesionUsuario' and xt_modulo = '$moduloScript' and xt_oficina = '$oficinaScript' ");
			while($r = $s->fetchRow()){
				$listaFuncionalidades[$indiceFuncionalidad] = $r[0];
				$indiceFuncionalidad++;
				$status = 'true';
			}
		}else if($moduloScript != ''){
			$s = $MASTER_GE->Execute("SELECT distinct xt_funcionalidad FROM PERFILES.FUNCIONALIDADES where xt_usuario = '$sesionUsuario' and xt_modulo = '$moduloScript' ");
			while($r = $s->fetchRow()){
				$listaFuncionalidades[$indiceFuncionalidad] = $r[0]; 
				$indiceFuncionalidad++;
				$status = 'true';
			}
		}else if($moduloScript == '' && $oficinaScript == ''){
			$status = 'true';
		}
		
		if($status == 'false'){
			header("Location: https://escalante.com.mx/Sistemas/error.php");
		}
	} 	
}
?>