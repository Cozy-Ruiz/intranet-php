<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
$options="";

 $oficinas = $MASTER_GE->Execute("SELECT xt_oficina FROM PERFILES.CATALOGO_OFICINAS  WHERE xt_oficina NOT IN(SELECT xt_oficina FROM PERFILES.OFICINAS where xt_usuario = '$usuario')");
	echo "<option selected='selected'>Selecionar...</option>";
	while($r = $oficinas->fetchRow()){
		
		echo '<option value='.$r[0].'>'.$r[0].'</option>';
	}	 

?>
