<?php
header('Content-Type: text/html; charset=UTF-8');
$nombrephp = 'actualizaDescripcion.php';
require_once("../../ConexionDBT.php"); 
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "actualizaDescripcion"){

	$descripcionN  = $_POST['descripcion'];
	$proceso       = $_POST['proceso'];
	$rol           = $_POST['rol'];
	$actividad     = $_POST['actividad'];
	$funcionalidad = $_POST['funcionalidad'];
	$casoUso = $_POST['casoUso'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Caso_Uso SET xt_descripcion = '$descripcionN' WHERE  xt_codigoCasoUso = '$casoUso'")){
		
		echo true;
	}else{
		echo "UPDATE SGI_Caso_Uso SET xt_descripcion = '$descripcionN' WHERE  xt_codigoCasoUso = '$casoUso'";
	}

}

if($_REQUEST['evento'] == "actualizarFuncionalidad"){
		
	$proceso         = $_POST['proceso'];
	$rol             = $_POST['rol'];
	$actividad	     = $_POST['actividad'];
	$funcionalidadOld     = $_POST['funcionalidadOld'];
	$funcionalidadNueva   = explode('|',$_POST['nuevaFuncionalidad']);
	$codigoFuncionalidad  = $funcionalidadNueva[0];
	$nombreFuncionalidad  = $funcionalidadNueva[1];


	if($INTRANETV2->Execute("UPDATE SGI_K_Funcionalidades SET kp_codigoFuncionalidad = '$codigoFuncionalidad', xt_nombre = '$nombreFuncionalidad' WHERE kp_codigoFuncionalidad = '$funcionalidadOld' AND kf_codigoActividad = '$actividad' AND kf_codigoRol = '$rol' AND kf_codigoProceso = '$proceso'")){

		echo true;
	}else{
		echo "Hubo un error al actualizar Funcionalidad";
	}
				
}
?>
