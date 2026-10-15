<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

//obtengo valores
$codProcesoRolAct = $_POST['valorPRA'];

echo "<option value=''>Elegir......</option>";

	$ac = $INTRANET->Execute("SELECT PRAF.kp_codigo, F.xt_nombre FROM IntranetGEA.SGI_Procesos_Roles_Actividades_Funcionalidades PRAF, IntranetGEA.SGI_Funcionalidades F WHERE PRAF.kf_codigoFuncionalidad = F.kp_codigo AND PRAF.kf_codigoProcesoRolActividad = '$codProcesoRolAct'");
	
 	while($filaA = $ac->fetchRow()){
		echo "<option value='".$filaA[0]."'>$filaA[1]</option>";
  	}

?>