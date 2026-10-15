<?php

//$nombrephp = 'fichaRegstroModificarUpdate.php';
require_once("../../ConexionDBT.php");
//require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

	 $registroID 		= $_POST['id'];
	 $fechaUpdate 		= date('Y-m-d', strtotime($_POST['fecha']));
	 $descripcionUpdate 	= $_POST['descripcion'];
	 $tituloUpdate		= $_POST['titulo'];
	 $registroFormatosID = $_POST['codFormato'];

	$INTRANETV2->Execute("UPDATE SGI_Documento_Registro SET xt_tituloRegistro = '$tituloUpdate' WHERE xt_codigoRegistro = '$registroID'");
	
	
		
		$INTRANETV2->Execute("UPDATE SGI_Documento_Registro SET xt_descripcion = '$descripcionUpdate' WHERE xt_codigoRegistro = '$registroID'");
	
	
	//$tituloUpdate = $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $riesgoIDUpdate");
	
				$INTRANETV2->Execute("UPDATE SGI_Documento_Registro SET xt_codigoDocumento = '$registroFormatosID'  WHERE xt_codigoRegistro = '$registroID'");
			
		
	
	
	header("Location: fichaRegistrov2.php?id=$registroID");
		
?>
