<?php error_reporting(0); ?>
<?php
require_once("../ConexionDBT.php");

if($_REQUEST['evento'] == "actualizaDescripcion"){
	if(isset($_REQUEST['descripcion'], $_REQUEST['proceso'], $_REQUEST['actividad'], $_REQUEST['rol'])){
		
		$descripcionN = $_POST['descripcion'];
		$proceso = $_POST['proceso'];
		$rol = $_POST['rol'];
		$actividad = $_POST['actividad'];
		
	
		$INTRANET->Execute("UPDATE SGI_K_Actividades
							SET xt_descripcion = '$descripcionN'
							WHERE
								kf_codigoProceso = '$proceso'
							AND kf_codigoRol = '$rol'
							AND kp_codigoActividad = '$actividad'");
		
	}
}
if($_REQUEST['evento'] == "agregaFuncionalidad"){
		
		$funcionalidad          = explode('|',$_POST['funcionalidad']);
		$codFuncionalidad       = $funcionalidad[0];
		$nombreFuncionalidad    = $funcionalidad[1];
		$proceso                = $_POST['proceso'];
		$actividad              = $_POST['actividad'];
		$rol                    = $_POST['rol'];
		
		$INTRANET->Execute("INSERT INTO SGI_K_Funcionalidades (kp_codigoFuncionalidad, kf_codigoActividad, kf_codigoRol, kf_codigoProceso, xt_nombre) VALUES ('$codFuncionalidad', '$actividad', '$rol', '$proceso', '$nombreFuncionalidad')");
				
}
if($_REQUEST['evento'] == "actualizarActividad"){
		
		$proceso         = $_POST['proceso'];
		$rol             = $_POST['rol'];
		$actividad       = explode("|",$_POST['nuevaActividad']);
		$codActividadAgrega = $actividad[0];
		$nomActividadAgrega = $actividad[1];
		$actividadOld	    = $_POST['actividadOld'];
		
		if($INTRANET->Execute("UPDATE SGI_K_Actividades SET kp_codigoActividad = '$codActividadAgrega', xt_nombre = '$nomActividadAgrega' WHERE kp_codigoActividad = '$actividadOld' AND kf_codigoRol = '$rol' AND kf_codigoProceso = '$proceso'")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar Actividad";
		}
				
}
if($_REQUEST['evento'] == "actualizarMomento"){
		
		$proceso         = $_POST['proceso'];
		$rol             = $_POST['rol'];
		$actividad 	     = $_POST['actividad'];
		$momento 	     = $_POST['momento'];
	
		if($INTRANET->Execute("UPDATE SGI_K_Actividades SET xt_momento = '$momento' WHERE kp_codigoActividad = '$actividad' AND kf_codigoRol = '$rol' AND kf_codigoProceso = '$proceso'")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar el momento";
		}
				
}
if($_REQUEST['evento'] == "actualizarRol"){
		
		$proceso         = $_POST['proceso'];
		$rol             = explode("|",$_POST['rolNuevo']);
		$rolCodigo       = $rol[0];
		$nombreRol       = $rol[1];
		$rolOld	         = $_POST['rolOld'];
		
		
		if($INTRANET->Execute("UPDATE SGI_K_Roles SET kp_codigoRol = '$rolCodigo', xt_nombreRol = '$nombreRol' WHERE kp_codigoRol = '$rolOld' AND kf_codigoProceso = '$proceso'")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar el rol";
		}
				
}
?>
