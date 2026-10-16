<?php error_reporting(0); ?>
<?php
$nombrephp='AgregarEtapaSeguimiento.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

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
<title>Agregar Etapa</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
			<link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">;
$(function(){
	$(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
	 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
	 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
	
	 });
});
</script>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>
</head>
<body>
<?php
$etapa = $_GET['etapa'];
$seguimiento = $_GET['seguimiento'];
$origen = $_GET['origen'];

if($origen == "A"){
	if($etapa == 2){
		$nombreEtapa = "En Proceso";
	} else if($etapa == 3){
		$nombreEtapa = "En Revisión";
	} else if($etapa == 4){
		$nombreEtapa = "Cierre";
	}
	
} else if($origen == "B"){
	if($etapa == 2){
		$nombreEtapa = "En Proceso";
	} else if($etapa == 3){
		$nombreEtapa = "En Revisión";
	} else if($etapa == 4){
		$nombreEtapa = "Cierre";
	}
	
} else if($origen == "C"){
	if($etapa == 2){
		$nombreEtapa = "Evaluación Inicial";
	} else if($etapa == 3){
		$nombreEtapa = "Investigación";
	} else if($etapa == 4){
		$nombreEtapa = "Respuesta";
	} else if($etapa == 5){
		$nombreEtapa = "Comunicación";
	} else if($etapa == 6){
		$nombreEtapa = "Cierre";
	}
	
} else if($origen == "D"){
	if(($etapa == 1) || ($etapa == 7) || ($etapa == 13)){
		$nombreEtapa = "Asignada";
	} else if(($etapa == 2) || ($etapa == 8) || ($etapa == 14)){
		$nombreEtapa = "Definición de la no conformidad potencial";
	} else if(($etapa == 3) || ($etapa == 9) || ($etapa == 15)){
		$nombreEtapa = "Evaluación";
	} else if(($etapa == 4) || ($etapa == 10) || ($etapa == 16)){
		$nombreEtapa = "Plan de acción";
	} else if(($etapa == 5) || ($etapa == 11) || ($etapa == 17)){
		$nombreEtapa = "Registro de las acciones";
	} else if(($etapa == 6) || ($etapa == 12) || ($etapa == 18)){
		$nombreEtapa = "Evaluación de la eficacia";
	}/* else if($etapa == 7){
		$nombreEtapa = "Cierre";
	}*/
	
} else if($origen == "E"){
	if(($etapa == 1) || ($etapa == 6) || ($etapa == 11)){
		$nombreEtapa = "Asignada";
	} else if(($etapa == 2) || ($etapa == 7) || ($etapa == 12)){
		$nombreEtapa = "Análisis de la causa raíz";
	} else if(($etapa == 3) || ($etapa == 8) || ($etapa == 13)){
		$nombreEtapa = "Plan de acción";
	} else if(($etapa == 4) || ($etapa == 9) || ($etapa == 14)){
		$nombreEtapa = "Registro de las acciones";
	} else if(($etapa == 5) || ($etapa == 10) || ($etapa == 15)){
		$nombreEtapa = "Evaluación de la eficacia";
	}
	
}

if((/*$_POST['titulo'] || */$_POST['fecha'] || $_POST['descripcion']) == ('' || NULL)){
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='AgregarEtapaSeguimiento' method='POST' action='AgregarEtapaSeguimiento.php'  enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>$nombreEtapa</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='40'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			if(($origen == "D" && $etapa == 6) || ($origen == "D" && $etapa == 12) || ($origen == "D" && $etapa == 18)){
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' colspan='2'>Evaluación</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='left' colspan='2'>";
						echo "<select name='evaluacion'>";
							echo "<option value='' selected=''></option>";
							echo "<option value='positiva'>Positiva</option>";
							echo "<option value='negativa'>Negativa</option>";
						echo "</select>";
					echo"</td>";
				echo "</tr>";
			}
			
			if(($origen == "E" && $etapa == 5) || ($origen == "E" && $etapa == 10) || ($origen == "E" && $etapa == 15)){
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' colspan='2'>Evaluación</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='left' colspan='2'>";
						echo "<select name='evaluacion'>";
							echo "<option value='' selected=''></option>";
							echo "<option value='positiva'>Positiva</option>";
							echo "<option value='negativa'>Negativa</option>";
						echo "</select>";
					echo"</td>";
				echo "</tr>";
			}
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				//echo "<td id='iconosTexto2' align='left' >Título</td>";
				echo "<td id='iconosTexto2' align='left' colspna='2'>Fecha</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				/*
				echo "<td  align='left'>";
					echo "<input type='text' size=50 maxlength=100 name='titulo'>";
				echo"</td>";
				*/
				echo "<td  align='left' colspan='2'>";
					echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='20'> ";
				echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
					echo"Descripción";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr> ";
				echo"<td valign='bottom' align='left' colspan='2'>";
					echo"<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea>
							<input type='hidden' value='$etapa' name='etapa'>
							<input type='hidden' value='$seguimiento' name='seguimiento'>
							<input type='hidden' value='$origen' name='origen'>
					</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left' colspan='2'>Seleccione un archivo:</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='2'>";
					echo "<input type='file' name='archivo'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right' colspan='2'></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
} else if(($_POST['fecha']/* && $_POST['titulo']*/ && $_POST['descripcion']) != ('' && NULL)){
	
	$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
	//$tituloInsert = $_POST['titulo'];
	$descripcionInsert = nl2br($_POST['descripcion']);
	$etapaInsert = $_POST['etapa'];
	$seguimientoInsert = $_POST['seguimiento'];
	
	$origen = $_POST['origen'];
	$evaluacion = $_POST['evaluacion'];
		
	if($INTRANET->Execute("INSERT INTO SGI_Seguimiento_Etapas (kf_seguimientoID,xn_etapa,xt_contenido,xd_fecha ) VALUES ($seguimientoInsert,$etapaInsert,'$descripcionInsert','$fechaInsert' ) ")){
		
		if($origen == "D" && $evaluacion == "positiva"){
			$preventivaID = $INTRANET->getOne("SELECT APC.kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas APC, SGI_Seguimientos SSE 
												WHERE SSE.kp_seguimientoID = $seguimientoInsert AND SSE.kf_itemOrigenID = APC.kp_accionesID AND SSE.xt_tipoOrigen = 'D' AND APC.xt_tipo = 'D' ");
												
			$INTRANET->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xn_status = 1 WHERE kp_accionesID = $preventivaID ");
		} else if($origen == "D" && $evaluacion == "negativa"){
			$etapaAsign = $etapaInsert+1;
			$INTRANET->Execute("INSERT INTO SGI_Seguimiento_Etapas (kf_seguimientoID,xn_etapa,xd_fecha) VALUES ($seguimientoInsert,$etapaAsign,'$fechaInsert') ");
		}
		
		if($origen == "E" && $evaluacion == "positiva"){
			$correctivaID = $INTRANET->getOne("SELECT APC.kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas APC, SGI_Seguimientos SSE 
												WHERE SSE.kp_seguimientoID = $seguimientoInsert AND SSE.kf_itemOrigenID = APC.kp_accionesID AND SSE.xt_tipoOrigen = 'E' AND APC.xt_tipo = 'E' ");
												
			$INTRANET->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xn_status = 1 WHERE kp_accionesID = $correctivaID ");
		} else if($origen == "E" && $evaluacion == "negativa"){
			$etapaAsign = $etapaInsert+1;
			$INTRANET->Execute("INSERT INTO SGI_Seguimiento_Etapas (kf_seguimientoID,xn_etapa,xd_fecha) VALUES ($seguimientoInsert,$etapaAsign,'$fechaInsert') ");
		}
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			$destino = "SeguimientoEtapas/$archivo";
			
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("
					UPDATE SGI_Seguimiento_Etapas SET xt_ruta = '$archivo' WHERE kf_seguimientoID= $seguimientoInsert AND xn_etapa= $etapaInsert ") ){
					
					echo "<script type='text/javascript'>reCargarPadre()</script>";
							
				} else{
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center' name='Encabezado'>";
						
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error en la carga</font>";
								echo"</td>";
							echo"</tr>";
							
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error en la carga</font>";
							echo"</td>";
						echo"</tr>";
						
					echo "</table>";
				echo "</div>";
			}
		}
		
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
		  	echo "<form name='fichaSubir' method='post' action='AgregaRevision.php'>";	
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Etapa No Agregada</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
			echo "</form>";
		echo "</div>";
	}
}
		
?>
</body>
</html>