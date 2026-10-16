<?php
$nombrephp = 'fichaEventoModificarUpdate.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

	$eventoID 			= $_POST['evento'];
	$fechaUpdate 		= date('Y-m-d', strtotime($_POST['fecha']));
	$descripcionUpdate 	= $_POST['descripcion'];
	$impactoUpdate 		= $_POST['impacto'];
	$tituloUpdate		= $_POST['titulo'];

	$INTRANETV2->Execute("UPDATE SGI_Eventos SET xt_titulo = '$tituloUpdate', xn_impacto = $impactoUpdate WHERE xt_codigoEvento = '$eventoID' ");
	
	if($descripcionUpdate != ""){
		
		$INTRANETV2->Execute("UPDATE SGI_Eventos SET xt_descripcion = '$descripcionUpdate' WHERE xt_codigoEvento = '$eventoID'");
	}
	
	//$tituloUpdate = $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $riesgoIDUpdate");
	$indice 			= 1;
	$eventosRiesgosID 	= NULL;
	
	$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo FROM SGI_Riesgos_Eventos WHERE xt_codigoEvento = '$eventoID'");
		
	while($r = $s->fetchRow()){
		
		$eventosRiesgosID[$indice] = $r[0];
		
		$indice++;
		
	} unset($r); unset($s);
	
	if(count($eventosRiesgosID) >= 1){
		
		for($a = 1; $a <= count($eventosRiesgosID); $a++){
			
			 $codigoRiesgo 	= $_POST["eventoRiesgoID$eventosRiesgosID[$a]"];
			
			//echo"$codigoRiesgo-------------";
			
		//	$riesgoID		= "";
			//$riesgoID		= $INTRANET->getOne("SELECT kp_riesgoId FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$codigoRiesgo' ");
			
			if($codigoRiesgo != ""){
				
				//echo"UPDATE SGI_Riesgos_Eventos SET xt_codigoRiesgo = '$codigoRiesgo'  WHERE xt_codigoEvento = '$eventosRiesgosID[$a]'<br><br>";
				$INTRANETV2->Execute("UPDATE SGI_Riesgos_Eventos SET xt_codigoRiesgo = '$codigoRiesgo'  WHERE xt_codigoEvento = '$eventosRiesgosID[$a]' ");
			}
			
		}
	}
	
	header("Location: fichaEventov2.php?evento=$eventoID");
		
?>
