<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='CambiarArchivoSolicitud.php';
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

$modifica == 0;

if(($_POST['modifica'] != NULL) || ($_POST['modifica'] != "")){
	$modifica = 1;
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



if($modifica == 0){
	
	$solicitudID = $_GET['solicitudID'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Cambiar Archivo</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
		</head>
		<body>
<?php
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='CambiarArchivoSolicitud.php' enctype='multipart/form-data'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Cambiar Archivo</font>";
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
						echo "<input type='hidden' name='solicitudID' value='$solicitudID'>";
						echo "<input type='hidden' name='modifica' value='1'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
			
			echo "</form>";
		echo "</div>";
?>
</body>
</html>
<?php

} else if($modifica == 1){

	$solicitudID = $_POST['solicitudID'];
	
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	
	if ($archivo != ""){
		
		$destino = $archivo;
		//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], ("SugerenciaQueja/".$destino))){
			
			$archivoViejo = $INTRANET->getOne("SELECT xt_ruta FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $solicitudID ");
			
			if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_ruta = '$destino' WHERE kp_quejaSolicitudID = $solicitudID ") ){
				
				if($archivoViejo != $destino){
					unlink($archivoViejo);
				}
				
				echo "<script type='text/javascript'>window.close();</script>";
						
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Cambiar Archivo</title>
                            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                        </head>
                        <body>
                <?php
				
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error en la carga</font>";
							echo"</td>";
						echo"</tr>";
						
					echo "</table>";
				echo "</div>";
				
				?>
                </body>
                </html>
                <?php
			}
			
		} else{
			?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Cambiar Archivo</title>
                        <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    </head>
                    <body>
            <?php
            
            echo "<div id='wrapperPopUp'>";
                echo "<table border='0' align='center' name='Encabezado'>";
                
                    echo"<tr>";
                        echo"<td align='center' id='titulo1'>";
                            echo "<font>Error en la carga</font>";
                        echo"</td>";
                    echo"</tr>";
                    
                echo "</table>";
            echo "</div>";
            
            ?>
            </body>
            </html>
            <?php
		}
	}
}

?>