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
    	if (!empty($sql)) {
    		echo $sql;
    	}else{
    		echo "Sin descripcion";
    	}
    $conexion->Close();
	}//fin de funcion descripcionSimulacro

	function codigoRiesgo($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->Query("SELECT DISTINCT xt_codigoRiesgo FROM SGI_Riesgos_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	$c=0;
    	while($d = $sql->fetchRow()){
        $codigor = $d[0];
        if (!empty($codigor)) {
    		if($c==0){ //condicion para solo mostrar una vez el encabezado?>
    		<tr><td></td><td colspan="2" id='iconosTexto2' width="10%" align="left">Codigo: </td><td width="10%"></td><td colspan="2" id='iconosTexto2'align="left">Riesgo: </td>
    			<td colspan="3"></td></tr> <?php 
    		$c=1;
    		}//fin de while ?>
    		<tr><tr style="height: 20px width: 50px"></tr>
    		<td style='width:10%;'></td>
    		<td colspan="3" id='iconosTexto' style='word-wrap: break-word;'><a id='fileItem' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaRiesgov2.php?id=<?php echo $codigor ?>'><?php echo $codigor; ?></a></td>
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
    $sql = $conexion->GetOne("SELECT DISTINCT u.xt_nombre FROM IntranetGEA_USUARIOS u INNER JOIN SGI_Simulacros s ON u.kp_usuario = 
    	(SELECT xt_pdrSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."') AND s.xt_codigoSimulacro = '".$codigo."'");
    echo $sql;
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaPSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaProgramada,'%d/%m/%Y %h:%m') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    if (!empty($sql)) {
    	echo $sql;
    }else{
    	echo "No programado.";
    }
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaISimulacro($codigo){
    $conexion = new ConexionIntranet();
     $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaInicio,'%d/%m/%Y %h:%m') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    if (!empty($sql)) {
    	echo $sql;
    }else{
    	echo "No iniciado.";
    }
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function fechaFSimulacro($codigo){
    $conexion = new ConexionIntranet();
     $sql = $conexion->GetOne("SELECT DATE_FORMAT(xd_fechaFinalizacion,'%d/%m/%Y %h:%m') FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
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
    		echo $sql;
    	}else{
    		echo "No hay alcance registrado.";
    	}
    $conexion->Close();
	}

	function participantes_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $a = $this->ciudadSimulacro($codigo);
    $sql = $conexion->Query("SELECT DISTINCT U.xt_nombre FROM IntranetGEA_USUARIOS U INNER JOIN SGI_Simulacros_Participantes_Int S ON S.xt_usuario = U.kp_usuario AND S.xt_codigoSimulacro = '".$codigo."'");
    $iP=0;
    while($p = $sql->fetchRow()){
        	$nombreP[$iP] = $p[0];
        	$iP++;
        }
    ?><tr><td></td><td colspan="5" id='fileItem'><?php 
    if (isset($nombreP)) {
    if (count($nombreP)>0) {
        for ($i=0; $i < count($nombreP); $i++) {
        ?><img src="../../../../../Imagenes/ICN_BotonMenos.png" alt="Borrar" width="15" height="15" align="center" class="icon" title="Borrar"><?php
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
    $sql = $conexion->GetOne("SELECT DISTINCT xt_ciudad FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    return $sql;
    $conexion->Close();
	}

	function avisos_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $conexion->Close();
	}//fin de funcion aviso Simulacro

	function desarrolloSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT MID(xt_rutaDesarrollo, 22) FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
        if (!empty($sql)) {
            ?><tr>
            <td style="width: 15%"></td><td colspan="6"><embed src="http://192.1.169.25/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/moduloSimulacros/archivos/<?php echo $sql ?>" type="application/pdf" width="700" height="800"></embed></td>
            </tr><?php
        }else{
            echo "<tr><td></td><td colspan='7' id='fileItem'>No se ha subido archivo de desarrollo.<br /><br /></td></tr><tr>";
            ?><td></td><td colspan="7"><button>Subir ahora</button></td></tr><?php
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
    		echo $sql;
    	}else{
    		echo "No se usaron recursos.";
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function resultados_Simulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_resultadosSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
    	if (!empty($sql)) {
    		echo $sql;
    	}else{
    		echo "No hay resultados registrados.";
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function evaluacionSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $sql = $conexion->GetOne("SELECT DISTINCT xt_evaluacionSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$codigo."'");
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
			<tr><tr style="height: 20px"></tr>
				<td style='width:10%;'></td><td colspan="6" style="word-wrap: break-word;">Aqui va el seguimiento en caso de ser no eficaz.</td>		
			</tr>
			<?php

    		}elseif($sql==3) {
    			?><img width="10px" src='../../img/ICN_SemaforoRojoClaro.png'><?php
    			echo " Parcialmente eficaz"; 
    		}
    	}else{
    		echo "No se ha evaluado.";
    	}
    $conexion->Close();
	}//fin de funcion nombreSimulacro

	function seguimientoSimulacro($codigo){
    $conexion = new ConexionIntranet();
    $conexion->Close();
	}//fin de funcion nombreSimulacro
}

$general = new RegistrosGenerales();


?>