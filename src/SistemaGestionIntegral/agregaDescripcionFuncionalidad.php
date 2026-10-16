<?php error_reporting(0); ?>
<?php
require_once("../ConexionDBT.php");
if($_REQUEST['evento'] == "actualizaDescripcion"){

	$descripcionN  = $_POST['descripcion'];
	$proceso       = $_POST['proceso'];
	$rol           = $_POST['rol'];
	$actividad     = $_POST['actividad'];
	$funcionalidad = $_POST['funcionalidad'];
	
	if($INTRANET->Execute("UPDATE SGI_K_Funcionalidades SET xt_descripcion = '$descripcionN' WHERE kp_codigoFuncionalidad = '$funcionalidad' AND kf_codigoActividad = '$actividad' AND kf_codigoRol = '$rol' AND kf_codigoProceso = '$proceso'")){
		
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


	if($INTRANET->Execute("UPDATE SGI_K_Funcionalidades SET kp_codigoFuncionalidad = '$codigoFuncionalidad', xt_nombre = '$nombreFuncionalidad' WHERE kp_codigoFuncionalidad = '$funcionalidadOld' AND kf_codigoActividad = '$actividad' AND kf_codigoRol = '$rol' AND kf_codigoProceso = '$proceso'")){

		echo true;
	}else{
		echo "Hubo un error al actualizar Funcionalidad";
	}
				
}

if($_REQUEST['evento'] == "agregaCasoUso"){
		
	$proceso         = $_POST['proceso'];
	$rol             = $_POST['rol'];
	$actividad	     = $_POST['actividad'];
	$funcionalidad     = $_POST['funcionalidad'];
	$casoUso         = explode('|',$_POST['casoUso']);
	$codigoCasoUso  = $casoUso[0];
	$nombreCasoUso  = $casoUso[1];

	
	if($INTRANET->Execute("INSERT INTO SGI_K_Caso_Uso (kp_codigoCasoUso,kf_codigoFuncionalidad, kf_codigoActividad, kf_codigoRol, kf_codigoProceso, xt_nombre) VALUES ('$codigoCasoUso','$funcionalidad', '$actividad', '$rol', '$proceso', '$nombreCasoUso')")){

		echo true;
	}else{
		echo "Hubo un error al agregar Caso de Uso";
	}
				
}
?>
