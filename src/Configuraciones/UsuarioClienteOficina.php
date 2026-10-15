<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$nombre = $_POST['nombre'];
$options="";

	$s = $MASTER_GE->Execute("select xt_oficina from PERFILES.CATALOGO_OFICINAS where xt_oficina in (select xt_oficina from PERFILES.OFICINAS where xt_usuario = '$nombre') ");
	
	echo "<option selected='selected'>Selecionar...</option>";	
	while($r = $s->fetchRow()){
		 
		 $options.= '<option value='.$r[0].'>'.$r[0].'</option>';
	}
	echo $options;


?>

