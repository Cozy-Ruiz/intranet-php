<?php
require_once("../../ConexionIntranet2.php");

if($_REQUEST['evento'] == "actualizaDescripcion"){
	if(isset($_REQUEST['descripcion'], $_REQUEST['proceso'], $_REQUEST['actividad'], $_REQUEST['rol'])){
		
		$descripcionN = $_POST['descripcion'];
		$proceso = $_POST['proceso'];
		$rol = $_POST['rol'];
		$actividad = $_POST['actividad'];
		
	
		$INTRANETV2->Execute("UPDATE SGI_Actividades
							SET xt_descripcion = '$descripcionN'
							WHERE
								xt_codigoProceso = '$proceso'
							AND xt_codigoRol = '$rol'
							AND xt_codigoActividad = '$actividad'");
		
	}
}
if($_REQUEST['evento'] == "agregaFuncionalidad"){
		
		$funcionalidad          = explode('|',$_POST['funcionalidad']);
		$codFuncionalidad       = $funcionalidad[0];
		$nombreFuncionalidad    = $funcionalidad[1];
		$proceso                = $_POST['proceso'];
		$actividad              = $_POST['actividad'];
		$rol                    = $_POST['rol'];
		
		$INTRANETV2->Execute("INSERT INTO SGI_Funcionalidades (xt_codigoFuncionalidad, xt_codigoActividad, xt_codigoRol, xt_codigoProceso, xt_nombre) VALUES ('$codFuncionalidad', '$actividad', '$rol', '$proceso', '$nombreFuncionalidad')");
				
}
if($_REQUEST['evento'] == "actualizarActividad"){
		
		$proceso         = $_POST['proceso'];
		$rol             = $_POST['rol'];
		$actividad       = explode("|",$_POST['nuevaActividad']);
		$codActividadAgrega = $actividad[0];
		$nomActividadAgrega = $actividad[1];
		$actividadOld	    = $_POST['actividadOld'];
		
		if($INTRANETV2->Execute("UPDATE SGI_Actividades SET xt_codigoActividad = '$codActividadAgrega', xt_nombre = '$nomActividadAgrega' WHERE xt_codigoActividad = '$actividadOld' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){
			
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
	
		if($INTRANETV2->Execute("UPDATE SGI_Actividades SET xt_momento = '$momento' WHERE xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar el momento";
		}
				
}
if($_REQUEST['evento'] == "actualizarRol"){
		
		$proceso         = $_POST['proceso'];
		$rol             = explode("|",$_POST['rolNuevo']);
		$rolCodigo       = trim($rol[0]);
		$nombreRol       = trim($rol[1]);
		$rolOld	         = $_POST['rolOld'];
		$actividad       = $_POST['actividad'];
		
		
		//$INTRANETV2->Execute("UPDATE SGI_Roles SET xt_codigoRol = '$rolCodigo', xt_codigoProceso = '$proceso', xt_nombreRol = '$nombreRol' WHERE xt_codigoRol = '$rolOld' AND xt_codigoProceso = '$proceso'";
		if($INTRANETV2->Execute("UPDATE SGI_Actividades SET xt_codigoRol = '$rolCodigo' WHERE xt_codigoProceso = '$proceso' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rolOld'")){	
			echo true;
		}else{
			echo "Hubo un error al actualizar el rol";
		}
				
}
?>
