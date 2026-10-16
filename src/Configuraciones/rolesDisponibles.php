<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
//$usuario = "Alberto_Martinez-AICM";
$usuario = trim($usuario);
$datos = explode("-", $usuario);
strtoupper($datos[0]."-".$datos[1]);


$options="";

//echo"SELECT CR.xt_rol FROM PERFILES.CATALOGO_ROLES CR WHERE CR.xt_rol not in (SELECT R.xt_rol FROM PERFILES.ROLES R WHERE R.xt_usuario ='$datos[0]' AND R.xt_oficina ='$datos[1]')";
$s = $MASTER_GE->Execute("SELECT CR.xt_rol FROM PERFILES.CATALOGO_ROLES CR WHERE CR.xt_rol not in (SELECT R.xt_rol FROM PERFILES.ROLES R WHERE R.xt_usuario ='$datos[0]' AND R.xt_oficina ='$datos[1]') ");

	echo "<option selected='selected'>Selecionar...</option>";	
		while($r = $s->fetchRow()){
			 
			 $options.= '<option value="'.$r[0].'">'.$r[0].'</option>';
		}
		echo $options;


?>

