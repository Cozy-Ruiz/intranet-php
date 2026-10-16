<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
$oficina= $_POST['oficina'];
$options="";

 $clientes = $MASTER_GE->Execute("SELECT kp_clienteId, xt_rfc, xt_nombre FROM MASTER_GE.MASTER_RFC_CLIENTEID  WHERE kp_clienteId NOT IN(SELECT xn_clienteId FROM PERFILES.CLIENTES where xt_usuario = '$usuario' and xt_oficina IN('$oficina')) ORDER BY xt_nombre");
	echo "<option selected='selected'>Selecionar...</option>";
	while($r = $clientes->fetchRow()){
		
		echo '<option value='.$r[0].'-'.$r[1].'-'.$r[2].'>'.$r[2].'-'.$r[1].'-'.$r[0].'</option>';
	}	 

?>
