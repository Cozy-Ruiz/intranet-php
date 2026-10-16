<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");


$oficina= $_POST['oficina'];
$nombre = $_POST['nombre'];
$options="";

	$s = $MASTER_GE->Execute("select xt_modulo from PERFILES.CATALOGO_MODULOS where xt_modulo not in (select xt_modulo from PERFILES.MODULOS where xt_usuario = '$nombre' and xt_oficina = '$oficina') ");
	
	echo "<option selected='selected'>Selecionar...</option>";	
	while($r = $s->fetchRow()){
		 
		 $options.= '<option value='.$r[0].'>'.$r[0].'</option>';
	}
	echo $options;


?>

