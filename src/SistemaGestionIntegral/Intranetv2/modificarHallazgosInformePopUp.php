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
<title>Hallazgos de la Auditoría</title>
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
	?>
	<div id='wrapperPopUp'>
		<form name='fichaParticipantes' method='POST' action='modificarHallazgosInformePopUp.php?clave=<?php echo $clave; ?>'>	
			<table border='0' align='center' width='500'>
				<tr>
					<td align='center' class='titulo1' width='450'>Hubo hallazgos en la auditoría?</td>
				</tr>
				<tr height='50'> </tr>
			</table>
			
			<table border='0' align='center' width='500'>
				<tr>
					<td colspan='2' id='titleBlueLineTop' width='500'></td>
				</tr>
				
				<tr height='15'></tr>		
				<tr>
					<td style='width: 20px;'></td>
					<td><input type='checkbox' name='hallazgos' value ='Si'>Sí
					</td>
				</tr>
				<tr>
					<td style='width: 20px;'></td>
					<td><input type='checkbox' name='hallazgos' value ='No'>No
					</td>
				</tr>				
				<tr height='20px'><td colspan='2'></td></tr>
				<tr>
					<td id='titleBlueLineTop' colspan='2'></td>
				</tr>
			</table>
			<table border='0' align='center' width='450'>				
				<tr height='40'>
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
	$hallazgos = $_REQUEST['hallazgos'];
	$clave = $_GET['clave'];

	if($hallazgos == 'Si'){
		$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'Si' WHERE xt_claveAuditoria = '".$clave."'");
	} else {
		$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'No' WHERE xt_claveAuditoria = '".$clave."'");
	}

	echo "
		<script type='text/javascript'>
			recargarPadre();
		</script>
	";
}// FIN DEL BLOQUE DE MODIFICACIONES
?>