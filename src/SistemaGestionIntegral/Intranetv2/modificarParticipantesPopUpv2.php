<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
//error_reporting(E_PARSE);
//obtengo parametros
$simulacro = $_GET['simulacro'];
if(empty($_GET['ciudad'])){
	$ciudad = $_POST['ciudad'];
} else {
	$ciudad = $_GET['ciudad'];
}
if($_POST['modifica'] == 1){
	$modifica = 1;
}
//FUNCIONES
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
<style>
	.contenedorParticipantes { 
		border:2px solid #ccc;
		width:550px;
		height: 500px;
		margin: auto;
		overflow-y: scroll;
	}
</style>
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
		echo "<form name='fichaParticipantes' method='POST' action='modificarParticipantesPopUpv2.php?simulacro=$simulacro&ciudad=$ciudad'>";	
			echo "<input type='hidden' value='".$ciudad."' name='ciudad'>";
			echo "<table border='0' align='center' width='500'>";
				echo"<tr>";
					echo"<td align='center' class='titulo1' width='450'>Seleccionar participantes</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";
			
			echo "<div class='contenedorParticipantes'>";
				echo "<table border='0' align='center' width='500'>";
					echo "<tr>";
						echo "<td id='titleBlueLineTop' width='550'></td>";
					echo "</tr>";
					$index = 0;
					//LISTA DE PARTCIPANTES
					$INTRANET->Execute("set names 'utf8'");
					$conjuntoRegistroParticipantes = $INTRANET->Execute("
						SELECT DISTINCT
							SE.kf_usuario, IUO.xt_codigoCiudad, SE.xt_Nombre, SE.xt_ApellidoPaterno
						FROM
							SGI_Empleados SE
						INNER JOIN 
							IntranetGEA_Usuarios_Oficina IUO
						ON 
							SE.kf_usuario = IUO.kf_usuarioId
						WHERE
							xt_codigoCiudad = '".$ciudad."'
						");
					while($registroParticipante = $conjuntoRegistroParticipantes->fetchRow()){
						$codigoParticipante[$index]   = $registroParticipante[0];
						$nombreParticipante[$index]   = $registroParticipante[2];
						$apellidoParticipante[$index] = $registroParticipante[3];
						$index++;
					}
					$indice = 0;
					//LISTA DE PARTCIPANTES EXISTENTES
					$INTRANETV2->Execute("set names 'utf8'");
					$conjuntoRegistroParticipantesSimulacro = $INTRANETV2->Execute("
						SELECT DISTINCT
							xt_codigoParticipante
						FROM
							SGI_Simulacros_Participantes
						WHERE
							xt_codigoSimulacro = '".$simulacro."'
						");
					while($registroParticipanteSimulacro = $conjuntoRegistroParticipantesSimulacro->fetchRow()){
						$codigoParticipanteSimulacro[$indice]   = $registroParticipanteSimulacro[0];
						$indice++;	
					}
					echo"<tr height='15'></tr>";				
						for ($i=0;$i<count($codigoParticipante);$i++){
							echo '<tr>';
								if(!empty($codigoParticipanteSimulacro)){					
									if(in_array($codigoParticipante[$i], $codigoParticipanteSimulacro)){
										echo '<td>';
											echo "$nombreParticipante[$i] $apellidoParticipante[$i]";
										echo "</td>";
										echo '<td>';
											echo "<input type='checkbox' checked='true' class='LoginInicio' name='participantes[]' value='$codigoParticipante[$i]'/>";
										echo "</td>";	
									}else{
										echo '<td>';
											echo "$nombreParticipante[$i] $apellidoParticipante[$i]";
										echo "</td>";
										echo '<td>';
											echo "<input type='checkbox' class='LoginInicio' name='participantes[]' value='$codigoParticipante[$i]'/>";
										echo "</td>";											
									}
								} else {
										echo '<td>';
											echo "$nombreParticipante[$i] $apellidoParticipante[$i]";
										echo "</td>";								
										echo '<td>';
											echo "<input type='checkbox' class='LoginInicio' name='participantes[]' value='$codigoParticipante[$i]'/>";
										echo "</td>";											
								}					
							echo "</tr>";
						}			
					echo "<tr height='20px'><td colspan='4'></td></tr>";
					echo "<tr>";
						echo "<td id='titleBlueLineTop'></td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";	
			echo "<table border='0' align='center' width='450'>";				
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
	$participantes = $_REQUEST['participantes'];
	$ciudad 	   = $_REQUEST['ciudad'];
	$index = 0;
	//LISTA DE PARTCIPANTES
	$INTRANET->Execute("set names 'utf8'");
	$conjuntoRegistroParticipantes = $INTRANET->Execute("
		SELECT DISTINCT
			SE.kf_usuario, IUO.xt_codigoCiudad, SE.xt_Nombre, SE.xt_ApellidoPaterno
		FROM
			SGI_Empleados SE
		INNER JOIN 
			IntranetGEA_Usuarios_Oficina IUO
		ON 
			SE.kf_usuario = IUO.kf_usuarioId
		WHERE
			xt_codigoCiudad = '".$ciudad."'
		");
	while($registroParticipante = $conjuntoRegistroParticipantes->fetchRow()){
		$codigoParticipante[$index]   = $registroParticipante[0];
		$nombreParticipante[$index]   = $registroParticipante[2];
		$apellidoParticipante[$index] = $registroParticipante[3];
		$index++;
	}
	echo "
		SELECT DISTINCT
			SE.kf_usuario, IUO.xt_codigoCiudad, SE.xt_Nombre, SE.xt_ApellidoPaterno
		FROM
			SGI_Empleados SE
		INNER JOIN 
			IntranetGEA_Usuarios_Oficina IUO
		ON 
			SE.kf_usuario = IUO.kf_usuarioId
		WHERE
			xt_codigoCiudad = '".$ciudad."'
			<br>";
	print_r($codigoParticipante);
	echo "<br>";
	print_r($participantes);
	echo "<br>";
	for ($i=0;$i<count($codigoParticipante);$i++){
		if(in_array($codigoParticipante[$i], $participantes)){
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->getOne("INSERT INTO SGI_Simulacros_Participantes (xt_codigoSimulacro, xt_codigoParticipante) VALUES ('$simulacro', '$codigoParticipante[$i]')");
			echo "
				INSERT INTO SGI_Simulacros_Participantes (xt_codigoSimulacro, xt_codigoParticipante) VALUES ('$simulacro', '$codigoParticipante[$i]')
			";
			echo "<br>";
		} else {
			$INTRANETV2->Execute("set names 'utf8'");
			$INTRANETV2->Execute("DELETE FROM SGI_Simulacros_Participantes where xt_codigoParticipante = '$codigoParticipante[$i]'");
			echo "
				DELETE FROM SGI_Simulacros_Participantes where xt_codigoParticipante = '$codigoParticipante[$i]'
			";
			echo "<br>";
		}
	}	
	/*echo "
		<script type='text/javascript'>
			window.opener.top.location='simulacroElementoActualizar.php?simulacro=".$simulacro."';
			window.close();
		</script>
	";*/
}// FIN DEL BLOQUE DE MODIFICACIONES
?>