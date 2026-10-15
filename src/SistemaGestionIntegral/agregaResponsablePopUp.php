<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

$itemID = $_GET['itemID'];
$rs = INTRANET2->GetArray("
	SELECT
		xt_codigoProceso
	FROM
		SGI_Procesos
	WHERE
		xt_codigoCorto = '".$itemID."'	
	");
$itemID = $rs[0];

if($_POST['modifica'] == 1 && $_POST['descripcion'] != ""){
				
	$itemID = $_POST['itemID'];
	$descripcion = $_POST['descripcion'];
	
	$grupo = "";
	$area = "";
	$tipo = "";
	$consecutivo = 0;
	
	$s = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo FROM SGI_Item WHERE kp_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$grupo = $r[0];
		$area = $r[1];
		$tipo = $r[2];
		$consecutivo = $r[3];
		
	} unset($r);
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Control_Cambios WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
	}
	
	$maximo++;
	
	$usuario = $INTRANET->getOne("SELECT kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$usuarioId' ");
	
	if($INTRANET->Execute("INSERT INTO SGI_Control_Cambios (kf_itemID, xn_numero, xd_fecha, xt_descripcion, kf_actorID) 
							VALUES ($itemID, $maximo, CURRENT_TIMESTAMP(), '$descripcion', $usuario) ")){

	
		
	}
	echo "<script>window.opener.location.reload('FichaItem.php?id=$itemID');self.close();</script>";
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

$mapa[0] 	= "Descripción";
$mapa[1] 	= "Proceso antecesor";
$mapa[2] 	= "Proceso de apoyo";
$mapa[3] 	= "Proceso sucesor";
$mapa[4] 	= "Entrada";
$mapa[5] 	= "Salida";
$mapa[6] 	= "Equipo/Insumo";
$mapa[7] 	= "Compliance";
$mapa[8] 	= "Documento";
$mapa[9] 	= "Stakeholder";
$mapa[10] 	= "Riesgo";
$mapa[11] 	= "Indicador";
$mapa[12]	= "Nota";
$mapa[13]	= "Área de Oportunidad";

$numeroMapa = 'r';

if($_POST['responsable'] == ""){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='agregaResponsablePopUp?itemID=$itemID'>";	
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
						echo "<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
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
	
	$idResponsable = $_POST['responsable'];

	if($INTRANET->Execute("
		INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_descripcion) VALUES ('$itemID', 0, 3, '$idResponsable')") ){
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='agregaResponsablePopUp.php?itemID=$itemID'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
								echo"</td>";
							echo"</tr>";
							echo"<tr>"; 
								echo"<td align='center'>";
									//echo "<font>$breadcrumb</font>";
								echo"</td>";
							echo"</tr>";
							echo"<tr height='70'> </tr>";
						echo "</table>";
						
						echo "<table border='0' align='center'>";
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
							//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
							echo "</tr>";
							echo"<tr height='10'> </tr>";
						echo "</table>";
						
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td id='titleBlueLineBottom' width='450px'></td>";
							echo "</tr>";
							
							echo "<tr height='10'> </tr>";
							
							echo"<tr height='40'>";
								echo"<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='10'> </tr>";
						echo "</table>";
						
						echo "</form>";
					echo "</div>";
				
				
			}else{
				echo "<script type='text/javascript'>recargarPadre()</script>";
			}	
		
	} else{
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó el responsable</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='recargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
	
}