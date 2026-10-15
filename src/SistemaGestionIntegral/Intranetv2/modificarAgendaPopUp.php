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
	<title>Agregar Registro</title>
	 <?php
		if($estiloUsuario == 1){
	    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
		}else if($estiloUsuario == 2){
	    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
		}
	?>
	<link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript">;
		$(function(){
			$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd',
			 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
			 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
			 });					
		});
	</script>
	<script type="text/javascript">
		function recargarPadre(){
			opener.location.reload();
			window.close();
		}
		function validarRegistroAgenda(){
	    	var inputAuditor = document.forms["formulario"]["auditor"].value;
	    	var inputManual = document.forms["formulario"]["manual"].value;
	    	var inputPuesto = document.forms["formulario"]["puesto"].value;
	    	var inputFecha = document.forms["formulario"]["fecha"].value;
	    	var inputHora = document.forms["formulario"]["hora"].value;
		    if ((inputAuditor !=  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )) {
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el manual y puesto a auditar con su respectiva fecha y hora.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y puesto a auditar con su respectiva fecha y hora.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y manual a auditar con su respectiva fecha y hora.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha != "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor, manual y puesto a auditar con su respectiva hora.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor, manual y puesto a auditar con su respectiva hora.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar con su respectiva fecha y hora.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la fecha y la hora.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora == "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la hora.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha == "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar la fecha.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor y manual a auditar.");
		        return false;
		    } else if ((inputAuditor ==  "" ) && (inputManual != "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el auditor.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual == "" ) && (inputPuesto != "" ) && (inputFecha != "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el proceso a auditar.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha == "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar con su respectiva fecha.");
		        return false;
		    } else if ((inputAuditor !=  "" ) && (inputManual != "" ) && (inputPuesto == "" ) && (inputFecha != "" ) && (inputHora != "" )){
		        alert("No puede agregar el registro de la agenda ya que todos campos de éste deben estar completos. Favor de ingresar el puesto a auditar.");
		        return false;
		    }
		}	
	</script>
</head>
<body>

<?php
//INTERFACES DE CAPTURA DE DATOS

if($modifica == 0) {
	?>
	<div id='wrapperPopUp'>
		<form name='formulario' id='formulario' method='POST' action='modificarObjetivosPopUp.php?clave=$clave'>	
			<table border='0' align='center' width='850'>
				<tr>
					<td align='center' class='titulo1' width='450'>Agregar registro a la agenda</td>
				</tr>
				<tr height='50'> </tr>
				<tr colspan='2'>
					<td id='titleBlueLineTop' width='850'></td>
				</tr>				
			</table>
			
			<table border='0' align='center' width='800'>						
				<tr height='30px' colspan='2'> </tr>
				<tr width="800px">
					<td align='left' width='30px'> </td>
					<td><i style="color:#636262;">La junta de apertura se realizará a las nueve de la mañana del primer día de la auditoría y la junta de cierre se realizará según instrucciones del auditor líder.</i></td>
				</tr>
				<tr height='20px'><td></td></tr>
			</table>
			<table class="datos" width="800px" cellspacing="0" cellpadding="0" border="1" align="center">
				<tr>
					<td>Auditor
					</td>
					<td>Proceso a auditar
					</td>
					<td>Fecha
					</td>
					<td>Hora
					</td>					
				</tr>
				<tr>
					<td>
						<select name='auditor'>
							<option value=''>Elije...</option>
							<?php
							$conjuntoRegistroAuditores = $INTRANETV2->Execute("
									SELECT
										xt_claveAuditor, xt_nombreAuditor 
									FROM 
										SGI_Catalogo_Auditores
									WHERE
										xt_ciudad IN ('CMX','DF')
									ORDER BY
										xn_posicion
								");
							while($registroAuditor = $conjuntoRegistroAuditores->fetchRow()){
								$claveAuditor = $registroAuditor[0];
								$nombre = $registroAuditor[1];
								echo "<option value='$nombre'>$claveAuditor | $nombre</option>";
							}
							?>
						</select>
	 				</td>
					<td>
		 				<select name='manual'>
							<option value=''>Elije...</option>
							<?php
							$conjuntoRegistrosManaual = $INTRANETV2->Execute("
									SELECT 
										xt_codigoManual, xt_nombre
									FROM 
										SGI_Catalogo_Manuales
								");
							while($registroManual = $conjuntoRegistrosManaual->fetchRow()){
								$claveManual = utf8_decode($registroManual[0]);
								$nombre = $registroManual[1];
								echo "<option value='$nombre'>$claveManual | $nombre</option>";
							}
							?>
						</select>
					</td>
					<td align='center'>
						<input type='text' placeholder='Elije...'name='fecha' id='datepicker' size='11'/>
					</td>
					<td align='center'>
						<input type='time' name='hora' id='time'>
					</td>						
				</tr>
			</table>
			<table border='0' align='center' width='850px'>				
				<tr height='20px'><td></td></tr>
				<tr>
					<td valign='bottom' align='right'>
						<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
						<!-- <input type='hidden' value='1' name='modifica'> -->
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
	
//MODIFICACIONES ******************************************************************************************************************
}else if($modifica == 1){
	$avisos = $_REQUEST['avisos'];
	/*foreach($_POST['avisos'] as $checkbox){
		$INTRANETV2->Execute("set names 'utf8'");
		$INTRANETV2->getOne("INSERT INTO SGI_Simulacros_Avisos (xt_codigoSimulacro, xt_codigoAviso) VALUES ('$simulacro', '$checkbox') ");			
	}*/
	$index = 0;
	//LISTA DE PARTCIPANTES EXISTENTES
	$conjuntoRegistroAvisos = $INTRANETV2->Execute("
		SELECT
			xt_codigoAviso, xt_nombreAviso
		FROM
			SGI_Catalogo_Aviso
		");
	while($registroAviso = $conjuntoRegistroAvisos->fetchRow()){
		$codigoAviso[$index] = $registroAviso[0];
		$nombreAviso[$index]  = $registroAviso[1];
		$index++;
	}
	for ($i=0;$i<count($codigoAviso);$i++){
		if(in_array($codigoAviso[$i], $avisos)){
			$INTRANETV2->getOne("INSERT INTO SGI_Simulacros_Avisos (xt_codigoSimulacro, xt_codigoAviso) VALUES ('$simulacro', '$codigoAviso[$i]')");
		} else {
			$INTRANETV2->Execute("DELETE FROM SGI_Simulacros_Avisos where xt_codigoAviso = '$codigoAviso[$i]'");
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