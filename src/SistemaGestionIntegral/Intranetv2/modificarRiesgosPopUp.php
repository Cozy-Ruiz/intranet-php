<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
//obtengo parametros
$simulacro = $_GET['simulacro'];
if($_POST['modifica'] == 1){
	$modifica = 1;
}

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );
    return $string;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title>Agregar Alcance al Simulacro</title>
 <?php
	if($estiloUsuario == 1){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<script type="text/javascript">
	function recargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>
</head>
<body>

<?php
//INTERFACES DE CAPTURA DE DATOS

if($modifica == 0) {
	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='modificaRiesgos' method='POST' action='modificarRiesgosPopUp.php?simulacro=$simulacro'>";	
			echo "<table border='0' align='center' width='600'>";
				echo"<tr>";
					echo"<td align='center' class='titulo1' width='600'>Seleccionar riesgos</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='600'>";
				echo "<tr>";
					echo "<td id='titulo2' colspan='4'>Riesgos disponibles</td>";
				echo "</tr>";			
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='600'></td>";
				echo "</tr>";
                echo "<tr height='20px'><td colspan='4'></td></tr>";   				
				$contador = 0;
				$conjuntoRegistrosRiesgo = $INTRANETV2->Execute("
					SELECT
						xt_codigoRiesgo, xt_tituloRiesgo
					FROM
						SGI_Riesgos
					WHERE
						xt_aplicaSimulacro IN (1,'SI')
				");
				while($registroRiesgo = $conjuntoRegistrosRiesgo->fetchRow()){
					$codigoRiesgo[$contador] = $registroRiesgo[0];
					$tituloRiesgo[$contador]  = $registroRiesgo[1];
					$contador++;
				}unset($conjuntoRegistrosRiesgo);unset($registroRiesgo);unset($contador);
				$contadorRiesgosSeleccionados = 0;
				$conjuntoRegistrosRiesgosSeleccionados = $INTRANETV2->Execute("
						SELECT 
							SR.xt_codigoRiesgo, SR.xt_tituloRiesgo 
						FROM 
							SGI_Riesgos SR
						WHERE 
							SR.xt_codigoRiesgo 
						IN (SELECT SRS.xt_codigoRiesgo FROM SGI_Riesgos_Simulacros SRS WHERE SRS.xt_codigoSimulacro = '$simulacro')
					");		
				while($registroRiesgoSeleccionados = $conjuntoRegistrosRiesgosSeleccionados->fetchRow()){
					$codigoRiesgoSeleccionado[$contadorRiesgosSeleccionados] = $registroRiesgoSeleccionados[0];
					$nombreRiesgoSeleccionado[$contadorRiesgosSeleccionados] = $registroRiesgoSeleccionados[1];
					$contadorRiesgosSeleccionados++;
				}				
				for($i = 0; $i <= count($codigoRiesgo) - 1; $i++){
					echo "<tr>";
						if(!empty($codigoRiesgoSeleccionado)){					
							if(in_array($codigoRiesgo[$i], $codigoRiesgoSeleccionado)){
								echo '<td>';
									echo "<span style='margin-left:1em' >".$codigoRiesgo[$i]." | ".$tituloRiesgo[$i]."</span>";
								echo "</td>";
								echo '<td>';
									echo "<input type='checkbox' checked='true' class='LoginInicio' name='riesgos[]' value='$codigoRiesgo[$i]'/>";
								echo "</td>";	
							}else{
								echo '<td>';
									echo "<span style='margin-left:1em' >".$codigoRiesgo[$i]." | ".$tituloRiesgo[$i]."</span>";
								echo "</td>";
								echo '<td>';
									echo "<input type='checkbox' class='LoginInicio' name='riesgos[]' value='$codigoRiesgo[$i]'/>";
								echo "</td>";											
							}
						} else {
								echo '<td>';
									echo "<span style='margin-left:1em' >".$codigoRiesgo[$i]." | ".$tituloRiesgo[$i]."</span>";
								echo "</td>";								
								echo '<td>';
									echo "<input type='checkbox' class='LoginInicio' name='riesgos[]' value='$codigoRiesgo[$i]'/>";
								echo "</td>";											
						}							
					echo "</tr>";
				}
				echo "<tr height='30px'><td colspan='4'></td></tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
					echo"</td>";
				echo"</tr>";
			echo "</table>";
		echo "</form>";
	echo "</div>";
	
	
//MODIFICACIONES ****************************************************************************************************************************************
}else if($modifica == 1){
	$riesgos = $_REQUEST['riesgos'];
	$contador = 0;
	$conjuntoRegistrosRiesgo = $INTRANETV2->Execute("
		SELECT
			xt_codigoRiesgo, xt_tituloRiesgo
		FROM
			SGI_Riesgos
		WHERE
			xt_aplicaSimulacro IN (1,'SI')
	");
	while($registroRiesgo = $conjuntoRegistrosRiesgo->fetchRow()){
		$codigoRiesgo[$contador] = $registroRiesgo[0];
		$tituloRiesgo[$contador]  = $registroRiesgo[1];
		$contador++;
	}unset($conjuntoRegistrosRiesgo);unset($registroRiesgo);unset($contador);
	/*
	foreach($_POST['riesgos'] as $checkbox){
		$INTRANETV2->getOne("INSERT INTO SGI_Riesgos_Simulacros (xt_codigoSimulacro, xt_codigoRiesgo) VALUES ('$simulacro', '$checkbox') ");		
	}
	*/
	for ($i=0;$i<count($codigoRiesgo);$i++){
		if(in_array($codigoRiesgo[$i], $riesgos)){
			$INTRANETV2->getOne("INSERT INTO SGI_Riesgos_Simulacros (xt_codigoSimulacro, xt_codigoRiesgo) VALUES ('$simulacro', '$codigoRiesgo[$i]')");
		} else {
			$INTRANETV2->Execute("DELETE FROM SGI_Riesgos_Simulacros where xt_codigoRiesgo = '$codigoRiesgo[$i]' and xt_codigoSimulacro = '$simulacro' ");
		}
	}
	echo "
		<script type='text/javascript'>
			window.opener.top.location='simulacroElementoActualizar.php?simulacro=".$simulacro."';
			window.close();
		</script>
	";	
}// FIN DEL BLOQUE DE MODIFICACIONES



?>