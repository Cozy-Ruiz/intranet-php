<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
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
		echo "<form name='fichaParticipantes' method='POST' action='agregarNuevoParticipantePopUp.php?simulacro=$simulacro&ciudad=$ciudad'>";	
			echo "<input type='hidden' value='".$ciudad."' name='ciudad'>";
			echo "<input type='hidden' value='".$simulacro."' name='simulacro'>";
			echo "<input type='hidden' value='1' name='modifica'>";
			echo "<table border='0' align='center' width='500px'>";
				echo"<tr>";
					echo"<td align='center' class='titulo1' width='450px'>Ingresar nuevo participante</td>";
				echo"</tr>";
				echo"<tr height='50px'> </tr>";
			echo "</table>";
			
			echo "<div class='contenedorParticipantes'>";
				echo "<table border='0' align='center' style='width:500px'>";
					echo"<tr height='15'></tr>";
					echo "<tr>";
						echo "<td style='width:4%;'></td>";
						echo "<td>";
							echo "Nombre";
						echo "</td>";					
						echo "<td>";
							echo "<input type='text' name='nombre'>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style='width:4%;'></td>";					
						echo "<td>";
							echo "Apellido:";
						echo "</td>";					
						echo "<td>";
							echo "<input type='text' name='apellido'>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr height='20px'><td colspan='4'></td></tr>";
				echo "</table>";
			echo "</div>";	
			echo "<table border='0' align='center' width='450px'>";				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
			echo "</table>";
		echo "</form>";
	echo "</div>";
//MODIFICACIONES ****************************************************************************************************************
} else if($modifica == 1){
	$simulacro 	   = $_REQUEST['simulacro'];
	$participantes = $_REQUEST['participantes'];
	$ciudad 	   = $_REQUEST['ciudad'];
	$nombre		   = $_REQUEST['nombre'];
	$apellido	   = $_REQUEST['apellido'];
	$maximo = 0;
 	$maximo = $INTRANETV2->getOne("SELECT MAX(xn_consecutivoParticipante) FROM SGI_Participantes");
	$maximo++;
	$INTRANETV2->Execute("INSERT INTO SGI_Participantes (xn_consecutivoParticipante, xt_nombreParticipante, xt_apellidoParticipante) VALUES ('$maximo','$nombre','$apellido')");
	$INTRANETV2->Execute("INSERT INTO SGI_Participantes_Ciudades (xn_consecutivoParticipante, xt_ciudadParticipante) VALUES ('$maximo','$ciudad')");
	$INTRANETV2->Execute("INSERT INTO SGI_Simulacros_Participantes (xt_codigoSimulacro, xn_consecutivoParticipante) VALUES ('$simulacro','$maximo')");

	header("Location: modificarParticipantesPopUp.php?simulacro=".$simulacro."&ciudad=".$ciudad."");

}// FIN DEL BLOQUE DE MODIFICACIONES
?>