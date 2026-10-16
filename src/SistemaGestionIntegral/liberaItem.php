<?php error_reporting(0); ?>
<?php
$nombrephp='liberaItem.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");

//require_once("compruebaUsuario.php");

//$itemID  = $_GET['itemID'];
$usuario = $_GET['usuario'];
$tipo    = $_GET['tipo'];

if($tipo == 'Proceso'){
	$codigoP  = $_GET['codigo'];
}else if($tipo = 'Funcionalidad'){
	$codigoP  = $_GET['codigo'];
}

$hoy = date("Y-m-d H:i:s");

if($tipo == 'Proceso'){	

	
	
	if($INTRANETV2->Execute("INSERT INTO SGI_Libera_Inventarios (xt_codigo, xt_usuario, xd_fecha, xt_tipo) VALUES ('$codigo','$usuario','$hoy','$tipo')") ){
		
				
			header ("Location: fichaProceso.php?proceso=$codigoP");
	}
	
}else if($tipo = 'Funcionalidad'){
		
		//$codigo = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID");
	
		if($INTRANETV2->Execute("INSERT INTO SGI_Libera_Inventarios (kp_codigo, xt_usuario, xd_fecha, xt_tipo) VALUES ('$itemID','$usuario','$hoy','$tipo')") ){

			header ("Location: fichaFuncionalidadCasoUso.php?codigo=$codigoP");
		}
									
}
?>