<?php
/**
*  clase riesgos
*/
class Riesgos{
function seleccionarRiesgos($codigo){
$conexion = new ConexionIntranet();
$validar = $conexion->Query("SELECT DISTINCT xt_codigoRiesgo FROM SGI_Riesgos_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
$vRiesgo = array();
$iV=0;

while ($v = $validar->fetchRow()) {
	$vRiesgo[$iV] = $v[0];
	$iV++;
}
$sql = $conexion->Query("SELECT DISTINCT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos WHERE xt_aplicaSimulacro = 'SI' ORDER BY xt_codigoRiesgo ASC");
while ($r = $sql->fetchRow()) {
    $codigoR = $r[0];
    $nombreR = $r[1];
    if (!in_array($codigoR, $vRiesgo)) {
    	?><tr><td></td><td id="fileItem"><?php echo $codigoR." | ".$nombreR; ?><td id="fileItem"><input name="codigosR[]" value="<?php echo $codigoR ?>" type="checkbox" /></td></td><td></td></tr><?php
    }else{
    	?><tr><td></td><td id="fileItem"><?php echo $codigoR." | ".$nombreR; ?><td id="fileItem"><input name="codigosR[]" value="<?php echo $codigoR ?>" type="checkbox" checked="checked" /></td></td><td></td></tr><?php
    }
}
$conexion->Close();
}//fin de funcion seleccionarRiesgos
}//fin de clase riesgos
$riesgos = new Riesgos();
?>