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
	
	$_SESSION["sesionId"] = $r[0];
	
	if($_SESSION["sesionCategoria"] == 'Administrador'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionCategoria"] == 'Inhouse'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionCategoria"] == 'Cliente'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionCategoria"] == 'Empleado'){
		header ("Location: Home.php");
	}else if($_SESSION["sesionCategoria"] == 'Proveedor'){
		header ("Location: Home.php");
	}

}else if($_POST['usuario'] == '' || $_POST['password'] == ''){
	
	header ("Location: index.php");
	
}else if($_POST['usuario'] !== '' && $_POST['password'] !== ''){

	$patrones = array(' OR ', ' AND ', ' or ', ' and ', '<', '>', '(', ')', "'", '"');
	
	$usuario = str_replace($patrones, "", htmlspecialchars(trim($_POST['usuario']), ENT_QUOTES, 'UTF-8'));
    $password = str_replace($patrones, "", htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8'));
	
	$query = "SELECT u.xt_usuario, u.xt_categoria, u.xn_estilo, u.xt_estatus, u.xt_correo, u.xt_puesto, (SELECT cp.xt_categoria FROM perfiles.catalogo_puestos cp WHERE cp.xt_puesto = u.xt_puesto LIMIT 1) as xt_puestoCategoria, ( SELECT e.kp_personalId FROM intranetgea.sgi_empleados e WHERE e.kf_usuario = u.xt_usuario) AS xt_personalId, (SELECT e.xn_foto FROM intranetgea.SGI_EMPLEADOS e WHERE e.kf_usuario = u.xt_usuario LIMIT 1 ) as xt_foto  from PERFILES.USUARIOS u where u.xt_usuario='$usuario' and u.xt_password='$password' AND u.xt_estatus ='Activo' ";
	$s = $INTRANET->execute($query);

	$status = false;
	while($r = $s->fetchRow()){

        $sesionUsuario = $r[0];
		$sesionCategoria = $r[1];
        $sesionEstilo = $r[2];
        $sesionFechaSalida = date('Y-m-d');
        $sesionHoraSalida = date('H:i:s');
        $sesionCorreo = $r[4];
        $sessionPuesto = $r[5];
        $sessionPuestoCategoria = $r[6];
        $sessionPersonalId = $r[7];
		$sesionFoto = $r[8];

		$status = true;
	}
	
	if($status == true){
		
		//session_start();
		
		$_SESSION["autentificado"] = "SI";
        $_SESSION["sesionUsuario"] = $sesionUsuario;
        $_SESSION["sesionCategoria"] = $sesionCategoria;
        $_SESSION["sesionEstilo"] = $sesionEstilo;
        $_SESSION["sesionCorreo"] = $sesionCorreo;
        $_SESSION["sesionPuesto"] = $sessionPuesto;
        $_SESSION["sesionPuestoCategoria"] = $sessionPuestoCategoria;
        $_SESSION["sessionPersonalId"] = $sessionPersonalId;
		$_SESSION["sesionFoto"] = $sesionFoto;
		$_SESSION["sesionHoraAcceso"] = date('H:i:s');
		
		$sesionFechaEntrada = date('Y-m-d');
		$sesionHoraEntrada = date('H:i:s');
		
		$INTRANET->Execute("insert into IntranetGEA_SESIONES_USUARIOS (kf_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada') ");
		
		$s = $INTRANET->Execute("select kp_sesionId from IntranetGEA_SESIONES_USUARIOS where kf_usuario = '$sesionUsuario' and xd_fechaEntrada = '$sesionFechaEntrada' and xt_horaEntrada = '$sesionHoraEntrada' ");
		$r = $s->fetchRow();
		
		$_SESSION["sesionId"] = $r[0];
		
		if($_SESSION["sesionCategoria"] == 'Administrador'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionCategoria"] == 'Inhouse'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionCategoria"] == 'Cliente'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionCategoria"] == 'Empleado'){
			header ("Location: Home.php");
		}else if($_SESSION["sesionCategoria"] == 'Proveedor'){
			header ("Location: Home.php");
		}
		
	}else{
		
		//session_start();
		//session_destroy(); 
		unset($sesionUsuario);
		header("Location: index.php");
		
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
