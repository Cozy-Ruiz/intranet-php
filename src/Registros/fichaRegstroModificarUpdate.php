<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'fichaRegstroModificarUpdate.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

	$registroID 		= $_POST['id'];
	$fechaUpdate 		= date('Y-m-d', strtotime($_POST['fecha']));
	$descripcionUpdate 	= $_POST['descripcion'];
	$tituloUpdate		= $_POST['titulo'];

	$INTRANET->Execute("UPDATE SGI_Registros SET xt_tituloRegistro = '$tituloUpdate' WHERE kp_registroID = $registroID ");
	
	if($descripcionUpdate != ""){
		
		$INTRANET->Execute("UPDATE SGI_Registros SET xt_descripcion = '$descripcionUpdate' WHERE kp_registroID = $registroID");
	}
	
	//$tituloUpdate = $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $riesgoIDUpdate");
	$indice 			= 1;
	$registroFormatosID = NULL;
	
	$s = $INTRANET->Execute("SELECT kp_formatoRegistroID FROM SGI_Registros_Formatos WHERE kf_registroID = $registroID");
		
	while($r = $s->fetchRow()){
		
		$registroFormatosID[$indice] = $r[0];
		
		$indice++;
		
	} unset($r); unset($s);
	
	if(count($registroFormatosID) >= 1){
		
		for($a = 1; $a <= count($registroFormatosID); $a++){
			
			$codigoItem 	= $_POST["eventoRiesgoID$registroFormatosID[$a]"];
			
			$formatoID		= "";
			$formatoID		= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoItem' ");
			
			if($codigoItem != ""){
				
				$INTRANET->Execute("UPDATE SGI_Registros_Formatos SET kf_itemID = $formatoID  WHERE kp_formatoRegistroID = $registroFormatosID[$a] ");
			}
			
		}
	}
	
	header("Location: fichaRegistro.php?id=$registroID");
		
?>
