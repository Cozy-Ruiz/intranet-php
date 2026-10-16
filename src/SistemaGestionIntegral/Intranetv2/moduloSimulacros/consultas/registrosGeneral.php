<?php

class RegistrosGenerales
{
	function statusSimulacro($codigo){
	$conexion = new ConexionIntranet();
	$sql = $conexion->GetOne("SELECT DISTINCT 
				CASE xt_statusSimulacro
                  WHEN '5' THEN 'Terminado'
                  WHEN '4' THEN 'Por evaluar'
                  WHEN '3' THEN 'En proceso'
                  WHEN '2' THEN 'Asignado'
                  WHEN '1' THEN 'Sin asignar'
                    ELSE xt_statusSimulacro
                  END FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");

	if (!empty($sql)) {
		?><b>Status: <?php echo $sql ?></b><?php
	}
	$conexion->Close();
	}

	function nombreSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_nombreSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		echo $sql;
    	}else{
    		echo "Sin titulo";
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function descripcionSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_descripcionSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (empty($sql)) {
            $sql = "Sin descripcion";
    	}
    return $sql;
    $conexion->Close();
	}//fin de funcion descripcionSimulacro

    function agenteSimulacro($codigo){
       // $conexion = new ConexionIntranet();
        //obtengo la oficna del simulacro
        $oficina = explode("-", $codigo);

        

        if($oficina[2] == "CMX"){

            $agentePatente = "3061 -Julio Antonio Escalante Bourillón / 3371 - Gabriel Roberto Escalante Bourillón /  3925 - María A. Escalante Bourillón";

        }else if($oficina[2] == "CUN"){

            $agentePatente = "3061 -Julio Antonio Escalante Bourillón / 3925 - María A. Escalante Bourillón";

        }else if($oficina[2] == "VER"){

            $agentePatente = "3061 -Julio Antonio Escalante Bourillón / 3034 - Victor M. Nuñez Cázarez Beal";

        }else if($oficina[2] == "TOL"){

            $agentePatente = "3034 - Victor M. Nuñez Cázarez Beal";

        }else if($oficina[2] == "AIFA"){

            $agentePatente = "3061 -Julio Antonio Escalante Bourillón";

        }else if($oficina[2] == "PAN"){

            $agentePatente = "3371 - Gabriel Roberto Escalante Bourillón / 3925 - María A. Escalante Bourillón";

        }else if($oficina[2] == "LAR" || $oficina[2] == "NLR"){

            $agentePatente = "3371 - Gabriel Roberto Escalante Bourillón";

        }else if($oficina[2] == "COL"){

            $agentePatente = "3371 - Gabriel Roberto Escalante Bourillón";

        }else if($oficina[2] == "QRO"){

            $agentePatente = "3371 - Gabriel Roberto Escalante Bourillón";

        }

        ?><?php echo $agentePatente ?></b><?php
        //$conexion->Close();
        }//fin de funcion descripcionSimulacro

	function codigoRiesgo($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_codigoRiesgo FROM SGI_Riesgos_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	$c=0;
    	while($d = $sql->fetchRow()){
        $codigor = $d[0];
        if (!empty($codigor)) {
    		if($c==0){ //condicion para solo mostrar una vez el encabezado?>
    		<tr><td></td><td width="20%" id='iconosTexto2' width="10%" align="left">Codigo: </td><td colspan="2" id='iconosTexto2' align="left">Riesgo: </td>
    			</tr> <?php 
    		$c=1;
    		}//fin de while ?>
    		<tr><tr style="height: 20px width: 50px"></tr>
    		<td style='width:10%;'></td>
    		<td  id='iconosTexto' style='word-wrap: break-word;'><a id='fileItem' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaRiesgov2.php?id=<?php echo $codigor ?>'><?php echo $codigor; ?></a></td>
			<td style="width:50px; word-wrap: break-word;" colspan="5"  id='fileItem'><?php $this->nombreRiesgo($codigor); ?></td>
			</tr><?php
    	}else{
            echo "No hay ningun riesgo relacionado a este simulacro.";
        }//fin de if riesgo
    }//fin de whilecodigor
    $conexion->Close();
	}//fin de funcion codigoRiesgo

	function nombreRiesgo($codigor){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_tituloRiesgo FROM SGI_Riesgos WHERE xt_codigoRiesgo = '".$codigor."'");
    echo $sql;
    $conexion->Close();
	}//fin de funcion nombreRiesgos

	function tipoSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_tipoSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		echo $sql;
    	}else{
    		echo "Debe registrar un tipo.";
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function pdrSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT u.xt_nombre FROM IntranetGEA.IntranetGEA_USUARIOS u INNER JOIN SGI_Simulacros s ON u.kp_usuario = 
    	(SELECT xt_pdrSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."') AND s.xt_codigoSimulacro = '".$codigo."'");
    echo $sql;
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaPSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaProgramada,'%d/%m/%Y %h:%i') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    if (!empty($sql)) {
    	echo $sql;
    }else{
    	echo "No programado.";
    }
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaISimulacro($codigo){
    $conexion = new ConexionIntranet();
     $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaInicio,'%d/%m/%Y %h:%i') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    if (!empty($sql)) {
    	echo $sql;
    }else{
    	echo "No iniciado.";
    }
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaFSimulacro($codigo){
    $conexion = new ConexionIntranet();
     $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaFinalizacion,'%d/%m/%Y %h:%i') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    if (!empty($sql)) {
    	echo $sql;
    }else{
    	echo "No finalizado.";
    }
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function alcanceSimulacro($codigo){
	$conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_alcanceSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		$alcance = $sql;
    	}else{
    		$alcance = "No hay alcance registrado.";
    	}
    return $alcance;
    $conexion->Close();
	}

	function participantes_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $a = $this->ciudadSimulacro($codigo);
    $sql = $conexion->Query("SELECT DISTINCT U.xt_nombre FROM IntranetGEA_USUARIOS U INNER JOIN SGI_Simulacros_Participantes_Int S ON S.xt_usuario = U.kp_usuario AND S.xt_codigoSimulacro = '".$codigo."'
        UNION
        SELECT ext_NombreCompleto FROM SGI_Simulacros_Participantes_Ext WHERE xt_codigoSimulacro = '".$codigo."'");
    $iP=0;
    while($p = $sql->fetchRow()){
        	$nombreP[$iP] = $p[0];
        	$iP++;
        }
    ?><tr><td></td><td colspan="5" id='fileItem'><?php 
    if (isset($nombreP)) {
    if (count($nombreP)>0) {
        for ($i=0; $i < count($nombreP); $i++) {
        echo '  '.$nombreP[$i]."<br />";
    	}
    }
    }else{
    		echo "No hay participantes registrados en este simulacro.";
    	}
    ?></td></tr><?php

    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function ciudadSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT LTRIM(RTRIM(xt_ciudad)) FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    return $sql;
    $conexion->Close();
	}

	function avisos_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_tipoAviso FROM SGI_Simulacros_Avisos WHERE xt_codigoSimulacro = '".$codigo."'");
    
    while ($tipos = $sql->fetchRow()) {
        $nombreT = $tipos[0];

            switch ($nombreT) {
            case 1:
                $tipo = "Aviso a poblacion";
                break;
            case 2:
                $tipo = "Aviso a protección civil";
                break;
            case 3:
                $tipo = "Aviso a Grupo Escalante";
                break;
            case 4:
                $tipo = "Aviso a Autoridades";
                break;
            }

    $sql2 = $conexion->Query("SELECT DISTINCT xt_tipoAviso, xt_nombreAviso FROM SGI_Simulacros_Avisos WHERE xt_codigoSimulacro = '".$codigo."' AND xt_tipoAviso = '".$nombreT."'");

    $c=0;
        while ($aviso = $sql2->fetchRow()) {
        $tipoA = $aviso[0];
        $nombre = $aviso[1];

                if ($c == 0) {
                    ?><tr ></tr><tr><td></td><td colspan='5' id="iconosTexto2"><?php echo $tipo ?></td></tr>

                    <tr ></tr>

                    <tr>
                        <td></td>
                        <td colspan='5' id="iconosTexto2">
                            <?php 
                            $archivo = file_get_contents("../aviso/archivosAviso/".$nombre); 
                            echo "
                                <object data=\"data:Application/pdf,'".rawurlencode($archivo)."'\" type='application/pdf' width='950px' height='700px'>
                                  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
                                  No obstante puede descargar el archivo en este <a href='../aviso/archivosAviso/Aviso Grupo Escalante.pdf'>enlance</a>
                                  </p>
                                </object>
                            ";
                            ?>
                        </td>
                    </tr>

             <?php    }else{
                    ?>
                    
                    <?php
                }
  
    }//fin de while nombres aviso
    }//find e while nombres tipo
        ?> <tr><td colspan="7">
            <table width="100%"><tr><td><embed id="pdf" src="" type="application/pdf" width="100%" height="650"></embed></td></tr></table></td></tr> <?php
    $conexion->Close();
	}//fin de funcion aviso Simulacro

	function desarrolloSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_rutaDesarrollo FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
        if (!empty($sql)) {
            ?><tr><td colspan="7">
                    <table border="0" width="100%">
                        <tr>
                            <td></td>
                            <td align="center">
                                 <?php 
                                $archivo = file_get_contents("../desarrollo/archivosDesarrollo/".$sql); 
                                echo "
                                    <object data=\"data:Application/pdf,'".rawurlencode($archivo)."'\" type='application/pdf' width='950px' height='700px'>
                                      <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
                                      No obstante puede descargar el archivo en este <a href='../aviso/archivosAviso/Aviso Grupo Escalante.pdf'>enlance</a>
                                      </p>
                                    </object>
                                ";
                                ?>
                            </td>
                        </tr>
                    </table></td>
            </tr><?php
        }else{
            echo "<tr><td></td><td colspan='7' id='fileItem'>No se ha subido archivo de desarrollo.<br /><br /></td></tr><tr>";
        }
    $conexion->Close();
	}//fin de funcion nombreSimulacro


    function asistenciaSimulacro($codigo){
        $conexion = new ConexionIntranet();
        $sql = $conexion->GetOne("SELECT DISTINCT xt_rutaAsistencia FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
            if (!empty($sql)) {
                ?><tr><td colspan="7">
                        <table border="0" width="100%">
                            <tr>
                                <td></td>
                                <td align="center">
                                     <?php 
                                    $archivo = file_get_contents("../desarrollo/archivosAsistencia/".$sql); 
                                    echo "
                                        <object data=\"data:Application/pdf,'".rawurlencode($archivo)."'\" type='application/pdf' width='950px' height='700px'>
                                          <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
                                          No obstante puede descargar el archivo en este <a href='../aviso/archivosAviso/Aviso Grupo Escalante.pdf'>enlance</a>
                                          </p>
                                        </object>
                                    ";
                                    ?>
                                </td>
                            </tr>
                        </table></td>
                </tr><?php
            }else{
                echo "<tr><td></td><td colspan='7' id='fileItem'>No se ha subido archivo de asistencia.<br /><br /></td></tr><tr>";
            }
        $conexion->Close();
        }//fin de funcion nombreSimulacro

	function evidencia_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function recursos_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_recursosSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		$recursos = $sql;
    	}else{
    		$recursos = "No se usaron recursos.";
    	}
    return $recursos;
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function resultados_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_resultadoSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		$resultado = $sql;
    	}else{
    		$resultado = "No hay resultados registrados.";
    	}
    return $resultado;
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function evaluacionSimulacro($codigo, $usuario, $usuariosAdmin){
    $conexion = new ConexionIntranet();
    $general = new RegistrosGenerales();
    $c = new Ciudades();

    $sql = $conexion->GetOne("SELECT DISTINCT xt_evaluacionSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    $pdr = $conexion->GetOne("SELECT DISTINCT xt_pdrSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    $validador = $conexion->GetOne("SELECT DISTINCT xt_resultadoSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'"); 
    $validador2 = $conexion->GetOne("SELECT DISTINCT xt_rutaDesarrollo FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'"); 
    	if (!empty($sql)) {
    		if ($sql==1) {
    		 ?><img width="10px" src='../../img/ICN_SemaforoVerdeOscuro.png'><?php
    			echo " Eficaz";

    		}elseif($sql==2) {
			?><img width="10px" src='../../img/ICN_SemaforoRojoOscuro.png'><?php
    			echo " No eficaz"; 

		    ?><tr height='50px'><td colspan='7'></td></tr>
			<tr>
				<td id='titulo2' colspan='7'><b>14. Seguimiento</b></td>	
			</tr>
			<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
			<tr><tr style="height: 20px"></tr><td></td><td colspan="5" style="word-wrap: break-word; font-size:16px;" id="iconosTexto2" >Tratamiento</td>

            <?php 
            $ciudadU = $c->imprimirCiudad($usuario);
            $ciudadS = $general->ciudadSimulacro($codigo);

            if(in_array($usuario, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
            <td align="right"><button type="submit" name="agregarSeguimiento" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button></td> <?php } ?>	
			</tr>
            <tr><td></td><td id='titleBlueLineBottom' colspan='6'></td></tr>
            <tr style="height: 15px"><td colspan='7'></td></tr>
            <?php $this->seguimientoSimulacro($codigo); 

    		}elseif($sql==3) {
    			?><img width="10px" src='../../img/ICN_SemaforoRojoClaro.png'><?php
    			echo " Parcialmente eficaz"; 
    		}
    	}else{
            if ($pdr == $usuario) {

                if($validador !="" AND $validador2 !="" ){
                
                            echo "Usted es PDR de este simulacro y puede evaluarlo." ;
                
                
                            echo "<td id='iconosTexto2' align='center'>
                            <input type='submit' style='cursor: pointer; background-color: transparent; border: 0;' id='breadcrumbs' name='evaluar' value='Evaluar' /></td>
                            
                            <tr><td></td><td><div id='evaluar'></div> </td></tr>";
                           
                }

                else
                {
                    echo "Por favor complete las etapas anteriores antes de evaluar. <br>";
                }
            
            }

            else{
                echo "No se ha evaluado.";
            }
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function seguimientoSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_claveSeguimiento, idTratamiento, xt_tipoSeguimiento, DATE_FORMAT(xd_fecha,'%d/%m/%Y') FROM SGI_Simulacros_Seguimientos WHERE xt_claveSimulacro = '".$codigo."'");
        $c=0;

        ?><tr>
                <td></td><td colspan="5">
        <table width="100%" align="center" border="0"><?php

        while($d = $sql->fetchRow()){
        $clave = $d[0];
        $id = $d[1];
        $tipo = $d[2];
        $fecha = $d[3];

        switch ($tipo) {
            case 1:
                $nombreTipo = "Solicitud";
                break;
            case 2:
                $nombreTipo = "Acción correctiva";
                break;
            case 3:
                $nombreTipo = "Acción preventiva";
                break;
            case 4:
                $nombreTipo = "Otro simulacro";
                break;
        }
            
        if (!empty($clave)) {
            if($c==0){ //condicion para solo mostrar una vez el encabezado?>

                        <tr>
                            <td id="iconosTexto2" width="50px" align="left"></td>
                            <td id="iconosTexto2" width="50px" align="left"></td>
                             <td id="iconosTexto2" width="200px" align="left">Codigo</td>
                             <td id="iconosTexto2" width="300px" align="left">Tipo</td>
                             <td id="iconosTexto2" width="200px" align="left" colspan="2">Fecha</td>
                                          
                        </tr>
            <?php 
            $c=1; 
            } ?>
    <tr>
        <td></td>
        <td>
            <?php if($tipo == 1){ ?>
            <input type="text" name="idTratamiento" value="<?php echo $id ?>" hidden>
            <a id='fileItem' href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaAltaBajaUsuario.php?codigo=<?php echo $clave ?>'><?php echo $clave ?></a></td><td>
          <a id='fileItem' href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaAltaBajaUsuario.php?codigo=<?php echo $clave ?>'><?php echo $clave ?></a>
            <?php }
            if ($tipo == 2) { ?>
            <input type="text" name="idTratamiento" value="<?php echo $id ?>" hidden>
            <input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="eliminarTratamiento" value="Eliminar" /></td><td>
            <a id='fileItem' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaCorrectivav2.php?id=<?php echo $clave ?>'><?php echo $clave ?></a>
            <?php }
            if ($tipo == 3) { ?>
            <input type="text" name="idTratamiento" value="<?php echo $id ?>" hidden>
            <input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="eliminarTratamiento" value="Eliminar" /></td><td>
            <a id='fileItem' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaPreventivav2.php?id=<?php echo $clave ?>'><?php echo $clave ?></a>
            <?php }
            if ($tipo == 4) { ?>
            <input type="text" name="idTratamiento" value="<?php echo $id ?>" hidden>
            <input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="eliminarTratamiento" value="Eliminar" /></td><td>
               <input type="text" name="clave" hidden value="<?php echo $clave ?>" />
               <input id="fileItem" align="left" style=" cursor: pointer; background-color: transparent; border: 0;" name="seguimiento" value="<?php echo $clave ?>" type="submit" /> 

            <?php } ?>
            </td>
                              <td id="fileItem" width="300px" align="left"><?php echo $nombreTipo ?></td>
                              <td id="fileItem" width="200px" align="left"><?php echo $fecha ?></td>
                                         
        </tr>
                    
<?php
	}else{
            echo "<td colspan='2'></td><td colspan='4' id='fileItem'>No hay ningun seguimiento relacionado a este simulacro.</td>";
        }
echo '</tr>';
}
echo '</table>';
}
}

$general = new RegistrosGenerales();


?>