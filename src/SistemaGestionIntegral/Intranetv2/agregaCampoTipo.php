<?php
require_once("../../ConexionIntranet2.php");

	$tipo    	  = $_POST['tipo'];
	$simulacro    = $_POST['simulacro'];
	$codigo   = $_POST['codigo'];
	$accion   = $_POST['accion'];
    


 if ($codigo!="")
	{
		$query="INSERT INTO SGI_Simulacros_Seguimientos(xt_claveSeguimiento, xt_claveSimulacro, xt_tipoSeguimiento) VALUES ('$codigo', '$simulacro', '$tipo'); ";
	}

	else{ 
		$query="UPDATE SGI_Simulacros SET xt_tipoSimulacro = '$tipo' WHERE xt_codigoSimulacro = '$simulacro'";
	}


		if( $accion='agregarAuditor')
	{
		$usuario   = $_POST['usuario'];
		$nombre   = $_POST['nombre'];
		$ciudad   = $_POST['ciudad'];
		$query="INSERT INTO SGI_Catalogo_Auditores     (xt_usuario, xt_nombreAuditor, xt_ciudad) VALUES ('$usuario','$nombre','$ciudad');";
	}

	 

	if($INTRANETV2->Execute($query)){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>