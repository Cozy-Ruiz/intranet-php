<?php
error_reporting(0);

session_start();

/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 1.0
 *@copyright Copyright (c) 2015, Grupo Escalante Agencias Aduanales S.C.
 */

require_once("ConexionDBT.php");
if(isset($_SESSION["autentificado"]) && $_SESSION["autentificado"]== "SI"){
	
	$sesionUsuario = $_SESSION["sesionUsuario"];
	$sesionFechaEntrada = date('Y-m-d');
	$sesionHoraEntrada = date('H:i:s');
	
	$INTRANET->Execute("insert into IntranetGEA_SESIONES_USUARIOS (kf_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada') ") or die ("Error al registrar el inicio de session <br>'$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada'  ");
	
	$s = $INTRANET->Execute("select kp_sesionId from IntranetGEA_SESIONES_USUARIOS where kf_usuario = '$sesionUsuario' and xd_fechaEntrada = '$sesionFechaEntrada' and xt_horaEntrada = '$sesionHoraEntrada' ") or die ("Error al seleccionar la session <br>");
	$r = $s->fetchRow();
	
	$_SESSION["sesionIntranetId"] = $r[0];
	$_SESSION["sesionIntranetUsuario"] = $_SESSION["sesionUsuario"];
	$_SESSION["sesionIntranetCategoria"] = $_SESSION["sesionCategoria"];
	$_SESSION["sesionIntranetHoraAcceso"] = date('H:i:s'); 
	$_SESSION["sesionIntranetEstilo"] = $_SESSION["sesionEstilo"];
	
	//echo "Categoria".$_SESSION["categoria"];
	if($_SESSION["sesionIntranetCategoria"] == 'Administrador'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionIntranetCategoria"] == 'Inhouse'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionIntranetCategoria"] == 'Cliente'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionIntranetCategoria"] == 'Empleado'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionIntranetCategoria"] == 'Proveedor'){
		header ("Location: Home.php");
	}

}else if($_POST['usuario'] == '' || $_POST['contraseña'] == ''){
	
	header ("Location: https://escalante.com.mx/Sistemas");
	
}else if(($_POST['usuario'] && $_POST['contraseña']) != ''){
	
	$usuario = trim($_POST['usuario']);
	$password = trim($_POST['contraseña']);
	
	$s = $INTRANET->execute("select xt_usuario, xt_categoria, xn_estilo, (SELECT xn_foto FROM SGI_EMPLEADOS WHERE kf_usuario = xt_usuario LIMIT 1 ) as xt_foto from PERFILES.USUARIOS where xt_usuario='$usuario' and xt_password='$password' ");
	
	$status = false;
	while($r = $s->fetchRow()){
		$sesionId = $_SESSION["sesionIntranetId"];
		$sesionUsuario = $_SESSION["sesionIntranetUsuario"];
		$sesionEstilo = $r[2];
		$sesionFoto = $r[3];
		$sesionFechaSalida = date('Y-m-d');
		$sesionHoraSalida = date('H:i:s');	
		$INTRANET->Execute("update IntranetGEA_SESIONES_USUARIOS set xd_fechaSalida = '$sesionFechaSalida', xt_horaSalida = '$sesionHoraSalida' where kp_sesionId = $sesionId and kf_usuarioId = $sesionUsuario ");
		session_destroy();
		
		$status = true;
		$sesionUsuario = $r[0];
		$sesionCategoria = $r[1];
		$sesionEstilo = $r[2];
	}
	
	if($status == true){
		
		session_start();
		
		$_SESSION["autentificado"]= "SI";
		$_SESSION["sesionIntranetUsuario"] = $sesionUsuario;
		$_SESSION["sesionIntranetCategoria"] = $sesionCategoria;
		$_SESSION["sesionIntranetHoraAcceso"] = date('H:i:s'); 
		$_SESSION["sesionIntranetEstilo"] = $sesionEstilo;
		$_SESSION["sesionIntranetFoto"] = $sesionFoto;
		
		$sesionFechaEntrada = date('Y-m-d');
		$sesionHoraEntrada = date('H:i:s');
		
		$INTRANET->Execute("insert into IntranetGEA_SESIONES_USUARIOS (kf_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada') ");
		
		$s = $INTRANET->Execute("select kp_sesionId from IntranetGEA_SESIONES_USUARIOS where kf_usuario = '$sesionUsuario' and xd_fechaEntrada = '$sesionFechaEntrada' and xt_horaEntrada = '$sesionHoraEntrada' ");
		$r = $s->fetchRow();
		
		$_SESSION["sesionIntranetId"] = $r[0];
		
		if($_SESSION["sesionIntranetCategoria"] == 'Administrador'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionIntranetCategoria"] == 'Inhouse'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionIntranetCategoria"] == 'Cliente'){
			header ("Location: Home.php");
		}
		
	}else{
		
		session_destroy(); 
		unset($sesionUsuario);
		header("Location: https://escalante.com.mx/Sistemas/");
		
	}	
}



function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);
 
		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );
 
		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );
 
		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );
 
		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );
 
		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}
?> 
