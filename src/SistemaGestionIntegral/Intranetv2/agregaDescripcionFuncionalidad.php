<?php
require_once("../../ConexionIntranet2.php");
if($_REQUEST['evento'] == "actualizaDescripcion"){

	$descripcionN  = $_POST['descripcion'];
	$proceso       = $_POST['proceso'];
	$rol           = $_POST['rol'];
	$actividad     = $_POST['actividad'];
	$funcionalidad = $_POST['funcionalidad'];
	
	if($INTRANETV2->Execute("UPDATE SGI_Funcionalidades SET xt_descripcion = '$descripcionN' WHERE xt_codigoFuncionalidad = '$funcionalidad' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){
		
		echo true;
	}else{
		echo "Hubo un error al actualizar Descripcion";
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
if($_REQUEST['evento'] == "agregaCasoUso"){
		
	$proceso        = $_POST['proceso'];
	$rol            = $_POST['rol'];
	$actividad	    = $_POST['actividad'];
	$funcionalidad  = $_POST['funcionalidad'];
	$casoUso        = $_POST['casoUso'];
	$codigoCasoUso  = 4;
	$nombreCasoUso  = $casoUso;

	
	if($INTRANETV2->Execute("INSERT INTO SGI_Caso_Uso (xt_codigoCasoUso,xt_codigoFuncionalidad, xt_codigoActividad, xt_codigoRol, xt_codigoProceso, xt_nombre) VALUES ('$codigoCasoUso','$funcionalidad', '$actividad', '$rol', '$proceso', '$nombreCasoUso')")){

		echo true;
	}else{
		echo "INSERT INTO SGI_Caso_Uso (xt_codigoCasoUso,xt_codigoFuncionalidad, xt_codigoActividad, xt_codigoRol, xt_codigoProceso, xt_nombre) VALUES ('$codigoCasoUso','$funcionalidad', '$actividad', '$rol', '$proceso', '$nombreCasoUso')";
		echo "Hubo un error al agregar Caso de Uso";
	}
				
}
?>
