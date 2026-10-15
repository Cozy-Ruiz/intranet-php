<?php error_reporting(0); ?>
<?php

require_once("../ConexionDBT.php");

	if(isset($_POST['descripcion'])){
		
		$descripcionN = $_POST['descripcion'];
		$codigoCU = $_POST['codigoCU'];
		
       // echo "UPDATE SGI_Procesos_Roles_Actividades SET xt_descripcion = '$descripcionN' WHERE kp_codigo = '$codigoAct'";

		$INTRANET->Execute("UPDATE SGI_Procesos_Roles_Actividades_Funcionalidades_CasosdeUso SET xt_descripcion = '$descripcionN' WHERE kp_codigo = '$codigoCU'");
		
	}

?>


<script>
//alert("PDR Asignado");
window.location.reload();
</script>