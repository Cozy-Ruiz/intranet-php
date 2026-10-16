<?php error_reporting(0); ?>
<?php

//echo ini_get("upload_max_filesize");

$nombrephp='AgregarDocumentoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("MailAltaSistema.php");

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
<title>Agrega elemento</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>



</head>
<body>
<?php

$modifica = "";
$modifica == 0;

if(isset($_POST['modifica']) != (NULL || '')){

	$modifica = 1;
}
//echo "$modifica<br>";

if($modifica == 0){

	$usario = $_GET['usuario'];
	$sistema = $_GET['sistema'];	
	$estatus = $_GET['estatus'];
	$tipoSolicitud = $_GET['codigo'];

		echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregarDocumentoPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Subir Archivo</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='50'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='2'></td>";
			echo "</tr>";
	
			echo"<tr height='15'></tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' colspan='2'>Archivo</td>";
			echo "</tr>";
			
			echo "<tr height='10'> </tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<input type='file' name='archivo'>";
					echo "<input type='hidden' name='usuario' value='$usario'>";
					echo "<input type='hidden' name='sistema' value='$sistema'>";
					echo "<input type='hidden' name='estatus' value='$estatus'>";
					echo "<input type='hidden' name='codigo' value='$tipoSolicitud'>";
					echo "<input type='hidden' name='modifica' value='1'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='2'></td>";
			echo "</tr>";
			
			if($estatus == 'ALTA'){
				
				echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
						
			}else if($estatus == 'BAJA'){
				
				echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonDesactivar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			}
			
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
	

}else if($modifica == 1){

	$usuario1 = $_POST['usuario'];
	$sistema1 = $_POST['sistema'];
	$estatus1 = $_POST['estatus'];
	$tipoSolicitud1 = $_POST['codigo'];
	$fecha = date('Y-m-d');
	
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);	
	
	if ($archivo != ""){
		$destino = "FilesSistemas/$archivo";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){

		$INTRANET->Execute("UPDATE PERFILES.SOLICITUD_SISTEMAS SET xd_fecha = '$fecha', xt_ruta = '$destino' WHERE xt_usuario = '$usuario1' AND xt_sistema = '$sistema1' AND xt_tipo = '$estatus1' AND xt_codigoSolicitud = '$tipoSolicitud1' ");
		
		//Si usuario se le da alta al Sistema	
		if($estatus1 == 'ALTA'){
							
		$INTRANET->Execute("INSERT INTO PERFILES.SISTEMAS (xt_usuario,xt_sistema,xt_estatus) VALUES ('$usuario1','$sistema1','ACTIVO')");
		
		//new MailAltaSistema($fecha, $usuario1, $sistema1, $estatus1, "FilesSistemas/", $archivo, $INTRANET);	
			
		echo "<script type='text/javascript'>reCargarPadre()</script>";		  
		
		//En caso que sea baja de Sistema		
		}else if ($estatus1 == 'BAJA'){

			$INTRANET->Execute("UPDATE PERFILES.SISTEMAS SET xt_estatus = 'INACTIVO' WHERE xt_usuario = '$usuario1' AND xt_sistema = '$sistema1'");
			
			//new MailAltaSistema($fecha, $usuario1, $sistema1, $estatus1, "FilesSistemas/", $archivo, $INTRANET);
			
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
		}
	}
}
?>
</body>
</html>