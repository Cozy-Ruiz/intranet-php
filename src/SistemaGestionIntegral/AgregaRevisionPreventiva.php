<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio Francisco García Robles 
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregaRevisionPreventiva.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

// save old value
$saved = getenv("LD_LIBRARY_PATH");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("LD_LIBRARY_PATH=$newld");
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
<title>Agregar Revisión Preventiva</title>
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

if(($_POST['titulo'] || $_POST['fecha'] || $_POST['descripcion']) == ('' || NULL)){
	$preventivaID = $_GET['preventivaID'];
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregaRevisionPreventiva.php'  enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Revisión</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' >Titulo</td>";
				echo "<td id='iconosTexto2' align='right' >Fecha</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<input type='text' size=50 maxlength=100 name='titulo'>";
				echo"</td>";
				echo "<td  align='right'>";
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
					echo"<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea><input type='hidden' value='$preventivaID' name='preventivaID'></td>";
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
} else if(($_POST['fecha'] && $_POST['titulo'] && $_POST['descripcion']) != ('' && NULL)){
	$IDpreventiva = $_POST['preventivaID'];
	$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert = $_POST['titulo'];
	$descripcionInsert = nl2br($_POST['descripcion']);
		
	if($INTRANET->Execute("INSERT INTO SGI_Revisiones_Preventivas(kf_preventivasID, xd_fecha, xt_titulo, xt_descripcion) VALUES ($IDpreventiva, '$fechaInsert', '$tituloInsert', '$descripcionInsert') ")){
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			$destino = "RevisionArchivo/$archivo";
			//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("
					UPDATE SGI_Revisiones_Preventivas SET xt_ruta = '$archivo' WHERE kf_preventivasID = $IDpreventiva AND xd_fecha = '$fechaInsert' AND xt_titulo = '$tituloInsert' ") ){
					
					//$claveReunion = $INTRANET->getOne("SELECT xt_claveReunion FROM IntranetGEA_Reuniones WHERE kp_reunionID = $reunionID ");
					
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
							echo "<font>Revisión No Agregado</font>";
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