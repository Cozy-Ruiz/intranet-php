<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

//obtengo valores
$codProcesoRol = $_POST['valorPR'];

echo "<option value=''>Elegir......</option>";

	$ac = $INTRANET->Execute("SELECT DISTINCT (PRA.kp_codigo), A.xt_nombre FROM IntranetGEA.SGI_Procesos_Roles_Actividades PRA, IntranetGEA.SGI_Actividades A WHERE PRA.kf_codigoActividad = A.kp_codigo AND PRA.kf_codigoProcesoRol = '$codProcesoRol'");
	
 	while($filaA = $ac->fetchRow()){
		echo "<option value='".$filaA[0]."'>$filaA[1]</option>";
  	}

?>