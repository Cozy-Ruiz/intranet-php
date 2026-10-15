<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
//obtengo parametros
$clave = $_GET['clave'];
if($_POST['modifica'] == 1){
	$modifica = 1;
}

$fechas = $INTRANETV2->getArray("SELECT xd_fecha, xd_fechaInicio, xd_fechaFinalizacion FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$clave."'");

if (!empty($fechas[0][0])){
	if(date('Y-m-d', strtotime($fechas[0][0]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraProgramada = $fechas[0][0];
		$fechaProgramada = date('Y-m-d', strtotime($fechaHoraProgramada));
	}
}

if (!empty($fechas[0][1])){
	if(date('Y-m-d', strtotime($fechas[0][1]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraInicio = $fechas[0][1];
		$fechaInicio = date('Y-m-d', strtotime($fechaHoraInicio));
	}
}

if (!empty($fechas[0][2])){
	if(date('Y-m-d', strtotime($fechas[0][2]))>date('Y-m-d', strtotime("2000-01-01"))){
		$fechaHoraFinalizacion = $fechas[0][2];
		$fechaFinalizacion = date('Y-m-d', strtotime($fechaHoraFinalizacion));
	}
}

if (!empty($fechas[0][0])){
	if(date('Y-m-d', strtotime($fechas[0][0]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraProgramada = $fechas[0][0];
		$horaProgramada = date('H:i', strtotime($fechaHoraProgramada));
	}
}

if (!empty($fechas[0][1])){
	if(date('Y-m-d', strtotime($fechas[0][1]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraInicio = $fechas[0][1];
		$horaInicio = date('H:i', strtotime($fechaHoraInicio));
	}
}

if (!empty($fechas[0][2])){
	if(date('Y-m-d', strtotime($fechas[0][2]))>date('Y-m-d', strtotime("2000-01-01"))){
		$fechaHoraFinalizacion = $fechas[0][2];
		$horaFinalizacion = date('H:i', strtotime($fechaHoraFinalizacion));
	}
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
	<title>Modificar Fechas de la Auditoría</title>
	 <?php
		if($estiloUsuario == 1){
	    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
		}else if($estiloUsuario == 2){
	    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
		}
	?>
	<link type="text/css" href="../../Librerias/JQuery/css/jquery.timepicker.min.css" rel="stylesheet"/>
	<link type="text/css" href="../../Librerias/JQuery/css/bootstrap-datepicker.css" rel="stylesheet"/>
	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery.timepicker.min.js"></script>
	<script type="text/javascript" src="../../Librerias/JQuery/js/bootstrap-datepicker.js"></script>	

	<script type="text/javascript">
		$(function() {
			$('#horaProgramada').timepicker({ 'timeFormat': 'H:i' });
			$('#horaInicio').timepicker({ 'timeFormat': 'H:i' });
			$('#horaFinalizacion').timepicker({ 'timeFormat': 'H:i' });
		});		
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
	?>
	<div id='wrapperPopUp'>
		<form name='fichaConclusion' method='POST' action='modificarFechasPopUp.php?clave=<?php echo $clave; ?>'>	
			<table border='0' align='center' width='500'>
				<tr>
					<td align='center' class='titulo1' width='450'>Modificar las Fechas</td>
				</tr>
				<tr height='50'> </tr>
			</table>
			
			<table border='0' align='center' width='500'>
				<tr>
					<td id='titleBlueLineTop' colspan = '4' width='550'></td>
				</tr>
				
				<tr height='30'></tr>			
				<tr>
					<td style='width: 20px;'></td>
					<td style='width: 200px;'>Fecha y Hora Programada</td>
					<td><input type='date' name='fechaProgramada' size='7' value='<?php echo $fechaProgramada; ?>'></td>
					<td><input type='text' name='horaProgramada' id='horaProgramada' size='7' value='<?php echo $horaProgramada; ?>'></td>
				</tr>

				<tr height='15'></tr>
				<tr>
					<td style='width: 20px;'></td>
					<td style='width: 200px;'>Fecha y Hora Inicio</td>
					<td><input type='date' name='fechaInicio' size='7' value='<?php echo $fechaInicio; ?>'></td>
					<td><input type='text' name='horaInicio' id='horaInicio' size='7' value='<?php echo $horaInicio; ?>'></td>
				</tr>

				<tr height='15'></tr>			
				<tr>
					<td style='width: 20px;'></td>
					<td style='width: 200px;'>Fecha y Hora Finalización</td>
					<td><input type='date' name='fechaFinalizacion' size='7' value='<?php echo $fechaFinalizacion; ?>'></td>
					<td><input type='text' name='horaFinalizacion' id='horaFinalizacion' size='7' value='<?php echo $horaFinalizacion; ?>'></td>
				</tr>				

				<tr height='30px'><td colspan='4'></td></tr>
				<tr>
					<td id='titleBlueLineTop' colspan = '4'></td>
				</tr>
			</table>
			<table border='0' align='center' width='450'>	
				<tr height='40px'><td colspan='4'></td></tr>			
				<tr height='20'>
					<td valign='bottom' align='right'>
						<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
						<input type='hidden' value='1' name='modifica'>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
	
//MODIFICACIONES ******************************************************************************************************************
}else if($modifica == 1){
	$fechaProgramada = date('Y-m-d', strtotime($_REQUEST['fechaProgramada']));
	$fechaInicio = date('Y-m-d', strtotime($_REQUEST['fechaInicio']));
	$fechaFinalizacion = date('Y-m-d', strtotime($_REQUEST['fechaFinalizacion']));
	$horaProgramada = $_REQUEST['horaProgramada'];
	$horaInicio = $_REQUEST['horaInicio'];
	$horaFinalizacion = $_REQUEST['horaFinalizacion'];
	$clave = $_REQUEST['clave'];

	print_r($_POST);

	$fechaHoraProgramada = $fechaProgramada." ".$horaProgramada;
	$fechaHoraInicio = $fechaInicio." ".$horaInicio;
	$fechaHoraFinalizacion = $fechaFinalizacion." ".$horaFinalizacion;
	
	$INTRANETV2->getOne("UPDATE SGI_Auditorias SET xd_fecha = '$fechaHoraProgramada', xd_fechaInicio = '$fechaHoraInicio', xd_fechaFinalizacion = '$fechaHoraFinalizacion' WHERE xt_claveAuditoria = '$clave'");
	
	echo "
		<script type='text/javascript'>
			recargarPadre();
		</script>
	";
}// FIN DEL BLOQUE DE MODIFICACIONES
?>