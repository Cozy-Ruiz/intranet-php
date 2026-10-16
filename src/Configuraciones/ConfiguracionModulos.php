<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");


$oficina= $_POST['oficina'];
$nombre = $_POST['nombre'];
$modulo = $_POST['modulo'];
$options="";
if($modulo != ''){


	$s = $MASTER_GE->Execute("SELECT xt_funcionalidad FROM PERFILES.CATALOGO_FUNCIONALIDADES  WHERE xt_funcionalidad NOT IN 
(SELECT xt_funcionalidad FROM PERFILES.FUNCIONALIDADES WHERE xt_usuario = '$nombre' AND xt_modulo = '$modulo' AND xt_oficina = '$oficina')
 ");
	
	echo "<option selected='selected'>Selecionar...</option>";
	while($r = $s->fetchRow()){
		
		echo '<option value='.$r[0].'>'.$r[0].'</option>';
	}	 

}else{

echo "<option selected='selected'>Selecionar...</option>";

}


?>

