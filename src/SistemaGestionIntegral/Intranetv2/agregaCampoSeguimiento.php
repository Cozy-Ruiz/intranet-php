	<?php
require_once("../../ConexionIntranet2.php");

	$codigo   = $_POST['codigo'];
	$simulacro = $_POST['simulacro'];
	$acuerdo = $_POST['acuerdo'];
	$tipo = $_POST['tipo'];

 $query='';
 if ($simulacro!='')
 {
 	$query="INSERT INTO SGI_Simulacros_Seguimientos(xt_claveSeguimiento, xt_claveSimulacro, xt_tipoSeguimiento) VALUES ('$codigo', '$simulacro', '$tipo') ";
 }

 else if ($acuerdo!='')
 {
 	$query="INSERT INTO SGI_Acuerdos_Seguimientos(xt_claveSeguimiento, xt_claveAcuerdo, xt_tipoSeguimiento) VALUES ('$codigo', '$acuerdo', '$tipo') ";

 }
	
 
	if($INTRANETV2->Execute($query)){
		echo true;
	}else{
		echo "Hubo un error al actualizar los datos";
	}
?>