<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
$nombreUsuario = $_POST['nombre'];

echo "<td width='30'> </td>";
echo "<td width='30'> </td>";
echo "<td id='iconosTexto2' align='left' >";
	$n = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM PERFILES.USUARIOS WHERE xt_usuario = '$nombreUsuario'"); 
	while($r = $n->fetchRow()){
		$nombre = $r[0];
		$correo = $r[1];
	}
	$f = $INTRANET->Execute("SELECT xt_sistema FROM PERFILES.SISTEMAS WHERE xt_usuario = '$nombreUsuario' ORDER BY xt_sistema ASC");
	echo "<input type='hidden' name='nombreUsuario' value='".$nombre."'>";
	echo "<input type='hidden' name='correoUsuario' value='".$correo."'>";
	while($r= $f->fetchRow()){
		echo"<input type='checkbox' name='sistemaActual[]' value='".$r[0]."' checked='true'>$r[0]<br>";
	}
echo "</td>";

?>