<?php
require_once("../../ConexionIntranet2.php");
if(isset($_GET['participante'])){
	$participante = $_GET['participante'];
	$simulacro    = $_GET['simulacro'];

	if($INTRANETV2->Execute("DELETE FROM SGI_Simulacros_Participantes where xn_consecutivoParticipante = '$participante'")){
			header ("Location: simulacroElementoActualizar.php?simulacro=$simulacro");
	}
}
?>