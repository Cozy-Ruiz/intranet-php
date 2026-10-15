<?php

$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

$codigoCorto = $_GET['codigoProceso'];

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
             "â€“", "–"),
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
<title>Agregar Elemento Proceso</title>
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

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if(option == "Archivo"){
		document.getElementById("archivos").style.display="block";
		document.getElementById("contenido").style.display="none";
	} else{
		document.getElementById("archivos").style.display="none";
		document.getElementById("contenido").style.display="block";
	}
}
</script>
</head>
<body>
<?php
if($_POST['responsable'] == ""){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='agregaResponsablePopUp.php?codigoProceso=$codigoCorto'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar Responsable</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='center'>Seleccione persona responsable:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='center'>";
				echo "<select name='responsable'>";
					echo "<option value='' selected='selected'></option>";
					
					$s = $INTRANET->Execute("
					SELECT kp_personalId, xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados 
					WHERE xt_tipo = 'E' AND kp_personalId <> 168 ORDER BY xt_Nombre, xt_ApellidoPaterno ");
					
					while($r = $s->fetchRow()){
						echo "<option value='".$r[1]." ".$r[2]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
					} unset($r); unset($s);
				echo "</select>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

/// AGREGAR Responsable
} else if($_POST['responsable'] != ""){
	$responsable = limpiar_caracter_especial($_POST['responsable']);

	if($INTRANETV2->Execute("
		UPDATE
			SGI_Procesos
		SET
			xt_responsable = '".$responsable."'
		WHERE
			xt_codigoCorto = '".$codigoCorto."'
		")){
		
		$s = $INTRANETV2->Execute("
			SELECT
				(
					SELECT
						CONCAT(
							U.xt_Nombre,
							' ',
							U.xt_ApellidoPaterno,
							' ',
							U.xt_ApellidoMaterno
						)
					FROM
						IntranetGEA.SGI_Empleados U
					WHERE
						U.kf_usuario = SL.xt_usuario
				),
				SL.xd_fecha
			FROM
				INTRANET2.SGI_Libera_Inventarios SL
			WHERE
				SL.xt_codigo = '".$codigoCorto."'
			AND 
				SL.xt_tipo = 'Proceso'
			");
		
		while($r = $s->fetchRow()){
			
			$usuarioLibera = $r[0];
			$fechaLibera   = $r[1];
			
		} unset($r);
		if ($usuarioLibera != NULL && $usuarioLibera != ''){
			echo "
				<script type='text/javascript'>
					window.opener.top.location='controlCambiosv4.php?proceso=".$codigoCorto."';
					window.close();
				</script>
			";
		} else {
			echo "
				<script type='text/javascript'>
					window.opener.top.location='fichaProcesov2.php?proceso=".$codigoCorto."';
					window.close();
				</script>	
			";
		}
	} else {
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó el responsable</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='recargarPadre()' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
}