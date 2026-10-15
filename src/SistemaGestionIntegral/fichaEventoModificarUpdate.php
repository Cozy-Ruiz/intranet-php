<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'fichaEventoModificarUpdate.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

	$eventoID 			= $_POST['id'];
	$fechaUpdate 		= date('Y-m-d', strtotime($_POST['fecha']));
	$descripcionUpdate 	= $_POST['descripcion'];
	$impactoUpdate 		= $_POST['impacto'];
	$tituloUpdate		= $_POST['titulo'];

	$INTRANET->Execute("UPDATE SGI_Eventos SET xt_tituloEvento = '$tituloUpdate', xn_impacto = $impactoUpdate WHERE kp_eventoID = $eventoID ");
	
	if($descripcionUpdate != ""){
		
		$INTRANET->Execute("UPDATE SGI_Eventos SET xt_descripcion = '$descripcionUpdate' WHERE kp_eventoID = $eventoID");
	}
	
	//$tituloUpdate = $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $riesgoIDUpdate");
	$indice 			= 1;
	$eventosRiesgosID 	= NULL;
	
	$s = $INTRANET->Execute("SELECT kp_eventoRiesgoID FROM SGI_Eventos_Riesgos WHERE kf_eventoID = $eventoID");
		
	while($r = $s->fetchRow()){
		
		$eventosRiesgosID[$indice] = $r[0];
		
		$indice++;
		
	} unset($r); unset($s);
	
	if(count($eventosRiesgosID) >= 1){
		
		for($a = 1; $a <= count($eventosRiesgosID); $a++){
			
			$codigoRiesgo 	= $_POST["eventoRiesgoID$eventosRiesgosID[$a]"];
			
			$riesgoID		= "";
			$riesgoID		= $INTRANET->getOne("SELECT kp_riesgoId FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$codigoRiesgo' ");
			
			if($riesgoID != ""){
				
				$INTRANET->Execute("UPDATE SGI_Eventos_Riesgos SET kf_riesgoID = $riesgoID  WHERE kp_eventoRiesgoID = $eventosRiesgosID[$a] ");
			}
			
		}
	}
	
	header("Location: fichaEvento.php?id=$eventoID");
		
?>
