<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
//$usuario = "cozy-Ejecutivo de cuenta-NLRD";
$usuario = trim($usuario);
$usuario1 = explode("-", $usuario);
strtoupper($usuario1[0]."-".$usuario1[1]."-".$usuario1[2]);


$options="";

//echo"SELECT C.xt_modulo FROM PERFILES.CATALOGO_MODULOS C WHERE C.xt_modulo not in (SELECT M.xt_modulo FROM PERFILES.MODULOS M WHERE M.xt_usuario ='$usuario1[0]' AND M.xt_oficina = '$usuario1[2]') ";
$s = $MASTER_GE->Execute("SELECT C.xt_modulo FROM PERFILES.CATALOGO_MODULOS C WHERE C.xt_modulo not in (SELECT M.xt_modulo FROM PERFILES.MODULOS M WHERE M.xt_usuario ='$usuario1[0]' AND M.xt_oficina = '$usuario1[2]') ");

	echo "<option selected='selected'>Selecionar...</option>";	
		while($r = $s->fetchRow()){
			  
			 $options.= '<option value='.$r[0].'>'.$r[0].'</option>';
		}
		echo $options;


?>

