<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha del Carmen Abam
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'AgregarArchivoAuditoriaPopUp.php';
require_once("../../ConexionDBT.php");

error_reporting(E_PARSE);
//require_once("../../compruebaUsuario.php");

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
<title>Cambiar Archivo</title>
<?php
			//if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			//}else if($estiloUsuario == 2){
            	//echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			//}
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



$auditoriaID 	= @$_GET['id'];
$tipo 		= @$_GET['tipo'];


@$modifica == 0;

if(@$_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if(@$modifica == 0){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarArchivoAuditoriaPopUp.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Archivo</font>";
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
				echo "<input type='file' name='archivo'><input type='hidden' name='id' value='$auditoriaID'>";
				echo "<input type='hidden' name='modifica' value='1'><input type='hidden' name='tipo' value='$tipo'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right' colspan='2'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

} else if(@$modifica == 1){

	$auditoriaID = @$_POST['id'];
	$tipoAuditoria = @$_POST['tipo'];
        
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	
	if ($archivo != ""){
		$destino = "AuditoriaArchivos/$archivo";
		//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], "../".$destino)){
			  chmod($destino, 0777);
			$archivoViejo = $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $auditoriaID AND xt_tipo = '$tipoAuditoria' ");
                        
                                //echo"INSERT INTO SGI_Auditorias_Archivos (kf_auditoriaID,xt_tipo,xt_ruta) VALUES ($auditoriaID,'$tipoAuditoria','$archivo')";
                               if($INTRANET->Execute("INSERT INTO SGI_Auditorias_Archivos (kf_auditoriaID,xt_tipo,xt_ruta) VALUES ($auditoriaID,'$tipoAuditoria','$archivo')" ) ) {
								   
								   echo "<script type='text/javascript'>reCargarPadre()</script>";
                                        
                                     //$claveReunion = $INTRANET->getOne("SELECT xt_claveReunion FROM IntranetGEA_Reuniones WHERE kp_reunionID = $reunionID ");
                                        //unlink($archivoViejo);/*
                  
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
<?php
