<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

//obtengo valores
$codProcesoRolActF = $_POST['valorPRAF'];

echo "<option value=''>Elegir......</option>";

	$ac = $INTRANET->Execute("SELECT kp_codigo, xt_titulo FROM IntranetGEA.SGI_Procesos_Roles_Actividades_Funcionalidades_CasosdeUso WHERE kf_codigoProcesoRolActividadFuncionalidad = '$codProcesoRolActF'");
	
 	while($filaA = $ac->fetchRow()){
		echo "<option value='".$filaA[0]."'>$filaA[1]</option>";
  	}

?>