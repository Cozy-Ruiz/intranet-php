<?php  

class Usuarios{
	
function getUsuariosAdmin(){
	$conexion = new ConexionIntranet();
	$sql = $conexion->Query("SELECT DISTINCT kf_usuarioId FROM IntranetGEA_Usuarios_Oficina WHERE xt_codigoCiudad = 'ALL'");
	$iUsuario=0;

	while ($u = $sql->fetchRow()) {
		$usuarioAdmin[$iUsuario] = $u[0];
		$iUsuario++;
	}

	return $usuarioAdmin;
	$conexion->Close();
}
	
}
$con_usuario = new Usuarios();
?>