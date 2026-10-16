<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
header('Content-Type: text/html; charset=UTF-8'); 
//Obtengo los parametros
 $proceso = $_POST['valorP'];
echo "<option value=''>Elegir......</option>";
  $ro = $INTRANET->Execute("SELECT PR.kp_codigoProcesoRol, R.xt_nombre FROM IntranetGEA.SGI_Procesos_Roles PR, IntranetGEA.SGI_Roles R WHERE PR.kf_codigoRol = R.kp_codigo AND PR.kf_codigoProceso = '$proceso'");
  while($filaR = $ro->fetchRow()){
	  echo "<option value='".$filaR[0]."'>$filaR[1]</option>";
  }

?>