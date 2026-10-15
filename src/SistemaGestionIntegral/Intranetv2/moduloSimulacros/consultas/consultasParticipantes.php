<?php

class Participantes{
function seleccionarParticipantes($ciudad, $codigo){
$conexion = new ConexionIntranet();
 if ($ciudad=='CMX') {
    	$ciudad='DF';
    }

$sqlp = $conexion->Query("
SELECT DISTINCT CONCAT(SE.xt_Nombre,' ', SE.xt_ApellidoPaterno,' ', SE.xt_ApellidoMaterno), kf_usuario as 'usuario' FROM SGI_Empleados SE 
LEFT OUTER JOIN IntranetGEA_USUARIOS  IU ON SE.kf_usuario = IU.kp_usuario WHERE IU.kp_usuario IS NOT NULL AND CONCAT(SE.xt_Nombre,' ', SE.xt_ApellidoPaterno,' ', SE.xt_ApellidoMaterno) IS NOT NULL AND IU.xt_ciudad = '$ciudad' ORDER BY usuario" );

$validar = $conexion->Query("SELECT DISTINCT xt_usuario FROM SGI_Simulacros_Participantes_Int WHERE xt_codigoSimulacro = '$codigo'");
$vParticipante = array();
$iP=0;

while ($p = $validar->fetchRow()) {
    $vParticipante[$iP] = $p[0];
    $iP++;
}
$b = $conexion->Query("SELECT PERFILES.SISTEMAS.xt_usuario FROM PERFILES.SISTEMAS WHERE PERFILES.SISTEMAS.xt_estatus = 'INACTIVO' AND PERFILES.SISTEMAS.xt_sistema = 'INTRANET'");
$ib=0;
while ($bajas = $b->fetchRow()) {
    $usuarios_baja[$ib] = $bajas[0];
    $ib++;
}
while ($p = $sqlp->fetchRow()) {
    $nombreP = $p[0];
    $usuarioP = $p[1];

    if (in_array($usuarioP, $vParticipante)) {
    ?>
        <tr><td></td><td id="fileItem"><input name="pSeleccionados[]" value="<?php echo $usuarioP ?>" type="checkbox" checked="checked" /><td id="fileItem"><?php echo $nombreP ?></td></td><td></td></tr><?php
    }elseif(!in_array($usuarioP, $vParticipante) && !in_array($usuarioP, $usuarios_baja)){
    ?>
        <tr><td></td><td id="fileItem"><input name="pSeleccionados[]" value="<?php echo $usuarioP ?>" type="checkbox" /><td id="fileItem"><?php echo $nombreP ?></td></td><td></td></tr><?php }
    
}
$conexion->Close();
}//fin de funcion seleccionarParticipantes

function agregarPExterno($codigo, $nombre, $apellidos){
$conexion = new ConexionIntranet();
$sql = $conexion->Query("INSERT INTO SGI_Simulacros_Participantes_Ext(xt_codigoSimulacro, ext_NombreCompleto) 
                        VALUES ('".$codigo."', '".$nombre.' '.$apellidos."')");
$conexion->Close();
}//fin de funcion agregarPExterno

function seleccionarPdr($ciudad){
$conexion = new ConexionIntranet();
 if ($ciudad=='CMX') {
    	$ciudad='DF';
    }
/*$sqlp = $conexion->Query("SELECT DISTINCT xt_nombre, kP_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = '$ciudad'
UNION
SELECT CONCAT(SE.xt_Nombre,' ', SE.xt_ApellidoPaterno,' ', SE.xt_ApellidoMaterno), kf_usuario FROM SGI_Empleados SE 
LEFT OUTER JOIN IntranetGEA_USUARIOS  IU ON SE.kf_usuario = IU.kp_usuario WHERE IU.kp_usuario IS NULL");*/

//consulta nueva
/*$sqlp = $conexion->Query("SELECT DISTINCT CONCAT(SE.xt_Nombre,' ', SE.xt_ApellidoPaterno,' ', SE.xt_ApellidoMaterno), SE.kf_usuario FROM SGI_Empleados SE
JOIN SGI_EmpleadosActividad IA ON IA.kf_personalId = SE.kp_personalId
UNION
SELECT DISTINCT xt_nombre, kP_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = '".$ciudad."'");*/
$sqlp = $conexion->Query("SELECT DISTINCT
    CONCAT( SE.xt_Nombre, ' ', SE.xt_ApellidoPaterno, ' ', SE.xt_ApellidoMaterno )  NOMBRE,
    SE.kf_usuario USUARIO
FROM
    IntranetGEA.SGI_Empleados SE 
    JOIN SGI_EmpleadosActividad IA ON IA.kf_personalId = SE.kp_personalId 
UNION
SELECT DISTINCT
    xt_nombre NOMBRE,
    kP_usuario USUARIO 
FROM
    IntranetGEA.IntranetGEA_USUARIOS
WHERE  xt_ciudad = '".$ciudad."'
ORDER BY NOMBRE ASC");
    ?>
        		<select name="sPdr">
        		<?php while ($usuarioP = $sqlp->fetchRow()) {
        			$pdr = $usuarioP[0];
        			$usuarioP = $usuarioP[1];
        			?><option value="<?php echo $usuarioP ?>" > <?php echo $pdr ?></option><?php
        		}//fin de while tipos ?>
        		</select>
        		<?php
$conexion->Close();
}//fin de funcion seleccionarPdr

}//fin de clase riesgos
$cparticipantes = new Participantes();
?>


