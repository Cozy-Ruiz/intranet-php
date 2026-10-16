<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "actualizaDescripcion"){

	$descripcionN  = $_POST['descripcion'];
	$proceso       = $_POST['proceso'];
	$rol           = $_POST['rol'];
	$actividad     = $_POST['actividad'];
	$funcionalidad = $_POST['funcionalidad'];
	$casoUso = $_POST['casoUso'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Caso_Uso SET xt_descripcion = '$descripcionN' WHERE  xt_codigoCasoUso = '$casoUso' AND xt_codigoFuncionalidad = '$funcionalidad' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){
		
		echo true;
	}else{
		echo "Hubo un error al actualizar Descripcion";
	}

}

if($_REQUEST['evento'] == "actualizarCasoUso"){
		
	$proceso        = $_POST['proceso'];
	$rol            = $_POST['rol'];
	$actividad	    = $_POST['actividad'];
	$casoUsoOld     = $_POST['casoUsoOld'];
	$casoUsoNuevo   = explode('|',$_POST['nuevoCasoUso']);
	$codigoCasoUso  = $casoUsoNueva[0];
	$nombreCasoUso  = $casoUsoNueva[1];


	if($INTRANETV2->Execute("UPDATE SGI_Caso_Uso SET xt_codigoCasoUso = '$codigoCasoUso', xt_nombre = '$nombreCasoUso' WHERE xt_codigoCasoUso = '$casoUsoOld' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){

		echo true;
	}else{
		echo "Hubo un error al actualizar el Caso de Uso";
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


	if($INTRANETV2->Execute("UPDATE SGI_Funcionalidades SET xt_codigoFuncionalidad = '$codigoFuncionalidad', xt_nombre = '$nombreFuncionalidad' WHERE xt_codigoFuncionalidad = '$funcionalidadOld' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){

		echo true;
	}else{
		echo "Hubo un error al actualizar Funcionalidad";
	}
				
}
?>
