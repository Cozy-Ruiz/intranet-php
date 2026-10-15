<?php

class Simulacros{
function opcionesAnios(){
    $conexion = new ConexionIntranet();
    $anio= $conexion->Query("SELECT DISTINCT YEAR(xd_fechaProgramada) FROM SGI_Simulacros"); 
            while($a = $anio->fetchRow()){
                    $an = $a[0];
                    if(!empty($an)){
                        echo "<option value=".$an." > ".$an."</option>";
                    }//fin de if guardar datos anios
                }//fin de while anio
        $conexion->Close();
}//fin de funcion opionesAnios

function opcionesCategorias(){
    $conexion = new ConexionIntranet();
    $categoria= $conexion->Query("SELECT DISTINCT s.xt_tipoSimulacro, cs.xt_nombre FROM SGI_Simulacros s
                                INNER JOIN SGI_Catalogo_Simulacros cs 
                                ON s.xt_tipoSimulacro = cs.xt_tipo"); 

            while($cat = $categoria->fetchRow()){
                    $tipoCat = $cat[0];
                    $nombreCat = $cat[1];
                    if(!empty($nombreCat)){
                        echo "<option value=".$tipoCat." > ".$nombreCat."</option>";
                    }//fin de if categorias
                }//fin de while categorias
        $conexion->Close();
}//fin funcion categorias

function tablaSimulacro($sql, $usuario){

    $conexion = new ConexionIntranet();
    $con_usuario = new Usuarios();
    $con_ciudades = new Ciudades();
    $usuariosAdmin = $con_usuario->getUsuariosAdmin();

    $sqlTipo = $conexion->Query("SELECT DISTINCT xt_tipoSimulacro FROM SGI_Simulacros ORDER BY xt_tipoSimulacro DESC");
    $ciudad = $con_ciudades->imprimirCiudad($usuario);
    $iTipo=0;
    $tt = '';

    ?>
    <table border='0' align='left' width="100%"><tr style="height: 30px"></tr>
        <table border='0' align='left' width="100%"><?php

    while($t = $sqlTipo->fetchRow()){

    $nombreTipo[$iTipo] = $t[0];
    $sqlCiudad = $conexion->Query("SELECT DISTINCT s.xt_ciudad, cs.xt_nombre FROM SGI_Catalogo_Sucursales cs 
                INNER JOIN SGI_Simulacros s ON cs.xt_sucursal = s.xt_ciudad ORDER BY cs.xt_nombre ASC");
    $iCiudad=0;
    
    while($city = $sqlCiudad->fetchRow()){

                $codigoC[$iCiudad] = $city[0];
                $nombreC[$iCiudad] = $city[1];

                if (empty($sql)) {

                    if (in_array($usuario, $usuariosAdmin)) {
                        $tipo_filtro = $codigoC[$iCiudad];
                    }else{
                        $tipo_filtro = $ciudad;
                    }

                    $sqlSimulacro = $conexion->Query("SELECT xt_codigoSimulacro, xt_ciudad, xt_tipoSimulacro, DATE_FORMAT(xd_fechaProgramada,'%d/%m/%Y'), 
                      xt_nombreSimulacro, xt_pdrSimulacro, 
                      CASE xt_statusSimulacro
                      WHEN '5' THEN 'Terminado'
                      WHEN '4' THEN 'Por evaluar'
                      WHEN '3' THEN 'En proceso'
                      WHEN '2' THEN 'Asignado'
                      WHEN '1' THEN 'Sin asignar'
                        ELSE xt_statusSimulacro
                      END, xt_evaluacionSimulacro FROM SGI_Simulacros s
                      WHERE xt_ciudad = '".$tipo_filtro."' 
                      AND DATE_FORMAT(xd_fechaProgramada,'%Y') = '".date('Y')."'
                     AND xt_tipoSimulacro = '".$nombreTipo[$iTipo]."' 
                     ORDER BY xd_fechaProgramada DESC"); 

                }else{
                    if (in_array($usuario, $usuariosAdmin)) {

                        $tipo_filtro = $codigoC[$iCiudad];

                    }else{
                        $tipo_filtro = $ciudad;
                    }
                  $sqlSimulacro = $conexion->Query("SELECT 
                  xt_codigoSimulacro, xt_ciudad, xt_tipoSimulacro,
                   DATE_FORMAT(xd_fechaProgramada,'%d/%m/%Y'), 
                  xt_nombreSimulacro, xt_pdrSimulacro, 
                  CASE xt_statusSimulacro
                  WHEN '5' THEN 'Terminado'
                  WHEN '4' THEN 'Por evaluar'
                  WHEN '3' THEN 'En proceso'
                  WHEN '2' THEN 'Asignado'
                  WHEN '1' THEN 'Sin asignar'
                    ELSE xt_statusSimulacro
                  END, xt_evaluacionSimulacro FROM SGI_Simulacros s
                  WHERE 1=1 ".$sql." AND xt_ciudad = '".$tipo_filtro."' 
                  AND xt_tipoSimulacro = '".$nombreTipo[$iTipo]."' 
                  ORDER BY xd_fechaProgramada DESC"); 
                }//fin de condicion para consulta

    $iSimulacro=0;
    $mostrarCiudad = "nada";
    while($s = $sqlSimulacro->fetchRow()){

        $codigoS[$iSimulacro] = $s[0];
        $ciudadS[$iSimulacro] = $s[1];
        $tipoS[$iSimulacro] = $s[2];
        $fechapS[$iSimulacro] = $s[3];
        $nombreS[$iSimulacro] = $s[4];
        $pdrS[$iSimulacro] = $s[5];
        $statusS[$iSimulacro] = $s[6];
        $evaluacionS[$iSimulacro] = $s[7];

        $sqlNombrePdr = $conexion->Query("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '".$pdrS[$iSimulacro]."'");
        while($p = $sqlNombrePdr->fetchRow()){
            $nombrePdr[$iSimulacro] = $p[0]; 
        }//guardar datos del pdr

        if ($ciudadS[$iSimulacro] == $codigoC[$iCiudad]) {
                    if ($ciudadS[$iSimulacro] !== $mostrarCiudad) {
                        $mostrarCiudad = $ciudadS[$iSimulacro];
                        
        if ($tipoS[$iSimulacro] !== $tt) {
                        ?> 
                        <tr style="height: 20px"></tr>
                        <tr><td width="10%"></td><td colspan='7' id='titulo2Blanco' align="left"><?php echo $tipoS[$iSimulacro] ?></td><td width="10%"></td></tr>
                        <?php 
                        $tt = $tipoS[$iSimulacro];
                        }//fin de if titulo tipo ?> 
                        
                        <tr style="height: 10px"></tr><tr><td></td><td colspan='6' id='titulo2'><?php echo $nombreC[$iCiudad] ?></td><td width="10%"></td></tr>
                        <tr></tr><tr>
                                <td></td><td colspan='7' id='titleBlueLineTop'></td>
                            </tr><tr></tr> 
                        <tr height='0'><td colspan='7'></td></tr>
                              <tr id='titulo2'>
                                <td></td>
                                <td align='center' style='width:50px'></td>
                                <td align='center' style='width:200px'>Código</td>
                                <td align='center' style='width:150px'>Fecha</td>
                                <td align='left' style='width:600px'>Título</td>
                                <td align='center' style='width:300px'>PDR</td>
                                <td align='center' style='width:100px'>Status</td>
                                <td align='center' style='width:200px'>Evaluación</td>
                                <tr></tr>
                            </tr>
                            <tr><td></td><td colspan='7' id='titleBlueLineTop'></td>
                            </tr><tr></tr><?php
                    }//fin if asignar mostrarr ciudad

                                if($evaluacionS[$iSimulacro] == 1){
                                    $boton = "'./img/ICN_SemaforoVerdeOscuro.png'";
                                }
                                elseif($evaluacionS[$iSimulacro] == 2){
                                    $boton= "'./img/ICN_SemaforoRojoOscuro.png'";
                                }
                                elseif($evaluacionS[$iSimulacro] == 3){
                                    $boton = "'./img/ICN_SemaforoRojoClaro.png'";
                                }else{
                                    $boton = "";
                                }

                                $s = $codigoS[$iSimulacro];
                        ?>
                        <tr align="left" id='fileItem'>
                            <td width="10%">
                            <td align='left' style='width:50px'></td>
                            <td align='center' style='width:200px'>
                                <form action="vistas/simulacro/verSimulacro.php" method="POST" target="_blank">
                                   <input align="center" id="fileItem" style="cursor: pointer; background-color: transparent; border: 0;" name="simulacro" value="<?php echo $codigoS[$iSimulacro] ?>" type="submit" /> 
                                </form>
                            </td>
                            <td valign="top" align='center' style='width:150px'><?php echo $fechapS[$iSimulacro] ?></td>
                            <td valign="top" align='left'   style='width:600px'><?php echo $nombreS[$iSimulacro] ?></td>
                            <td valign="top" align='center' style='width:300px'><?php echo $pdrS[$iSimulacro] ?></td>
                            <td valign="top" align='center' style='width:100px'><?php echo $statusS[$iSimulacro] ?></td>
                            <td valign="top" align='center' style='width:10px'><img width="10px" src=<?php echo $boton ?>></td>
                            <td width="10%">
                        </tr>
                        <?php
                    }//fin if de mostrar ciudad
        $iSimulacro++;
    }//fin de while guardar registros de simulacros
    $iCiudad++;
    }//fin de while guaradr datos de ciudad        
    $iTipo++;
    }//fin de while tipo
    ?>
    <tr style="height: 20px"></tr>
    <tr><td></td><td colspan="7" width="80%" id='titleBlueLineTop'></td><td></td></tr>
    <tr style="height: 30px"></tr>
    </table>
        </table>
    <?php
}//fin de funcion tablaS 

function getTipos(){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_tipo FROM SGI_Catalogo_Simulacros");
    return $sql;
    $conexion->Close();
}//fin de funcion getTipos

function getStatus($simulacro){
    $conexion = new ConexionIntranet();
    $status = $conexion->GetOne("SELECT DISTINCT xt_statusSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '$simulacro' LIMIT 1");

    return $status;
    $conexion->Close();
}//fin de funcion status

function getGrupos(){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_codigo, xt_nombre FROM SGI_Grupos");
    return $sql;
    $conexion->Close();
}//fin de funcion grupos

function guardarRiesgo_Simulacro($riesgo, $simulacro, $eliminar){
    $conexion = new ConexionIntranet();
    if ($eliminar == 1) {
    $conexion->Query("DELETE FROM SGI_Riesgos_Simulacros WHERE xt_codigoSimulacro = '".$simulacro."'");
    }//eliminar existentes
    $conexion->Query("INSERT INTO SGI_Riesgos_Simulacros(xt_codigoRiesgo, xt_codigoSimulacro) VALUES('$riesgo', '$simulacro')");
    $conexion->Close();
}//fin de funcion guardar riesgossimulacro

function guardarParticipante_Simulacro($simulacro, $participante, $eliminar){
    $conexion = new ConexionIntranet();
    if ($eliminar == 1) {
    $conexion->Query("DELETE FROM SGI_Simulacros_Participantes_Int WHERE xt_codigoSimulacro = '".$simulacro."'");
    }//eliminar existentes
    $conexion->Query("INSERT INTO SGI_Simulacros_Participantes_Int(xt_codigoSimulacro, xt_usuario) VALUES('".$simulacro."', '".$participante."')");
    $conexion->Close();
}//fin de guardar participante_Simulacro

function actualizarGeneral($titulo, $descripcion, $codigo){
    $conexion = new ConexionIntranet();
    $conexion->Query("UPDATE SGI_Simulacros SET xt_nombreSimulacro = '".$titulo."', xt_descripcionSimulacro = '".$descripcion."' WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}//fin de funcion actualizar titulo y descripcion

function actualizarTipo($tipo, $codigo){
    $conexion = new ConexionIntranet();
    $conexion->Query("UPDATE SGI_Simulacros SET xt_tipoSimulacro = '".$tipo."' WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}//fin de funcion actualizar tipo

function guardarPdr($simulacro, $pdr){
    $conexion = new ConexionIntranet();

    $status = $this->getStatus($simulacro);
    $sqlEstatus = '';
    
    if ($status == 1) {
       $sqlEstatus = ', xt_statusSimulacro = 2';
    }

    //echo "UPDATE SGI_Simulacros SET xt_pdrSimulacro = '".$pdr."' $sqlEstatus WHERE xt_codigoSimulacro = '".$simulacro."'";
    $conexion->Query("UPDATE SGI_Simulacros SET xt_pdrSimulacro = '".$pdr."' $sqlEstatus WHERE xt_codigoSimulacro = '".$simulacro."'");
    $conexion->Close();
}//fin de funcion guardar riesgossimulacro

function actualizarAlcance($codigo, $alcance){
    $conexion = new ConexionIntranet();
    $conexion->Query("UPDATE SGI_Simulacros SET xt_alcanceSimulacro = '".$alcance."' WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}//fin de funcion actualizar alcance

function actualizarRecursos($codigo, $recursos){
    $conexion = new ConexionIntranet();
    $conexion->Query("UPDATE SGI_Simulacros SET xt_recursosSimulacro = '".$recursos."' WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}//fin de funcion actualizar recursos

function actualizarResultados($codigo, $resultados){
    $conexion = new ConexionIntranet();
    $conexion->Query("UPDATE SGI_Simulacros SET xt_resultadoSimulacro = '".$resultados."' WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}//fin de funcion actualizar recursos

function agregarSimulacro($vGrupo, $vTipo, $vFecha_prog, $vCiudad, $vNombre, $vDescripcion){
    $conexion = new ConexionIntranet(); 
    $año_actual = date('y');
    $codigoComparar = $vGrupo.'-S-'.$vCiudad.'-'.$año_actual.'-';
    $sql = $conexion->GetOne("SELECT DISTINCT xt_codigoSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro LIKE '".$codigoComparar."%' 
                                ORDER BY xt_codigoSimulacro DESC LIMIT 1");

    if($vCiudad == "AIFA"){
        $consecutivo = substr($sql, 14, 20)+1;
    }else{
        $consecutivo = substr($sql, 13, 20)+1;
    }
    
    if ($consecutivo<10) {
    $codigoNew = $codigoComparar.'00'.$consecutivo;
    }elseif ($consecutivo>=10 && $consecutivo<100) {
    $codigoNew = $codigoComparar.'0'.$consecutivo;
    }else{
        $codigoNew = $codigoComparar.$consecutivo;
    }//fin de if de comparacion si es menor o mayor a 100

    $ejecuta = $conexion->Query("INSERT INTO SGI_Simulacros(xt_codigoSimulacro, xt_tipoSimulacro, xd_fechaProgramada, xt_ciudad, xt_nombreSimulacro, xt_descripcionSimulacro, xt_statusSimulacro) VALUES('".$codigoNew."', '".$vTipo."', '".$vFecha_prog."', '".$vCiudad."', '".$vNombre."', '".$vDescripcion."', 1)");
    $conexion->Close();
    
}//insertar datos de nuevo imulacro

function actualizarFecha_Inicio($codigo, $fecha_inicio){
    $conexion = new ConexionIntranet();

    $status = $this->getStatus($codigo);
    $sqlEstatus = '';

    if ($status == 2) {
        $sqlEstatus = ', xt_statusSimulacro = 3';
    }

    $conexion->Query("UPDATE SGI_Simulacros SET xd_fechaInicio = '".$fecha_inicio."' $sqlEstatus WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}

function actualizarFecha_Final($codigo, $fecha_final){
    $conexion = new ConexionIntranet();

    $status = $this->getStatus($codigo);
    $sqlEstatus = '';

    if ($status == 2) {
        $sqlEstatus = ', xt_statusSimulacro = 3';
    }

    $conexion->Query("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = '".$fecha_final."' $sqlEstatus WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}
function agregarSeguimiento($cod, $clave_s, $tipo_s){
    $conexion = new ConexionIntranet();
    $conexion->Query("INSERT INTO SGI_Simulacros_Seguimientos(xt_claveSeguimiento, xt_claveSimulacro, xt_tipoSeguimiento) VALUES ('$clave_s', '$cod', '$tipo_s')");
    $conexion->Close();
}

function actualizarEvaluacion($codigo, $evaluado){
    $conexion = new ConexionIntranet();

    $conexion->Query("UPDATE SGI_Simulacros SET xt_evaluacionSimulacro = '".$evaluado."', xt_statusSimulacro = 5 WHERE xt_codigoSimulacro = '".$codigo."'");
    $conexion->Close();
}



}//fin de clase Simulacros
$simulacro = new Simulacros();
?>