<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'fichaRegistroModificar.php';
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

$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros/</a><a href='tableroRegistros.php' id='breadcrumbs'> Tablero Registro</a> ";

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

$registroID = $_GET['id'];

///DATOS DEL REGISTRO
$codigoRegistro	    = "";
$titulo 			= "";
$descripcion 		= "";
$ruta 				= "";
$fechaCreacion      = "";

$s = $INTRANET->Execute("SELECT xt_codigoRegistro, xd_fechaCreacion, xt_tituloRegistro, xt_descripcion, xt_ruta 
						 FROM SGI_Registros WHERE kp_registroID = $registroID ");

while($r = $s->fetchRow()){
	
	$codigoRegistro	    = $r[0];
	$titulo 			= $r[2];
	$descripcion 		= $r[3];
	$ruta 				= $r[4];
	$fechaCreacion      = date('Y-m-d', strtotime($r[1]));
	

} unset($r); unset($s);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Registro</title>
            <?php
			if($estiloUsuario == 1){
				echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
				echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='fichaRegstroModificarUpdate.php'>";	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='12px'>";
			echo "<td align='left' id='iconosTexto2'></td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Registro";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>"; 
			echo "<td align='center'>";
				echo $breadcrumb;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
		
//CUERPO SOLICITUD
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>".$codigoRegistro."</b></td>";
			echo "<td align='right' id='titulo2' width='100px'><b>".$fechaCreacion."</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo "<tr height='30px' colspan='2'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td width='20px'></td>";
			echo "<td width='680px' id='iconosTexto'>";
				echo "<input type='text' name='titulo' size='80' value='".$titulo."'>";
			echo "</td>";
		echo "</tr>";
		
		if ($ruta != NULL){
			
			echo "<tr height='20px'><td colspan='2'></td></tr>";
			
			echo "<tr>";
				echo"<td></td>";
				echo "<td id='fileItem' align='left'>";
					echo "<img src='../Imagenes/ICN_Archivo.png'> &nbsp;".$ruta;
				echo "</td>";
				
			echo "</tr>";
			
			echo"<tr>";
				echo"<td></td>";
				echo "<td align='left'> <a href='CambiarFotoPopUp.php?ID=$registroID'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
            		<img src='../Imagenes/ICN_BotonModificar.png' height='20' width='80'></a> </td>";
			echo"</tr>";
		}
		
		echo "<tr height='10px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td><input type='hidden' name='id' value='".$registroID."'></td>";
			echo "<td align='justify' id='fileItem'>";
				echo "<textarea name='descripcion' style='width:530px; height:100px;'>".$descripcion."</textarea>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
///FORMATOS RELACIONADOS
	echo "<table border='0' align='center' width='700px'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Formatos relacionados</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='30'>";
			echo "<td width='20px'></td>";
			echo "<td width='100px'></td>";
			echo "<td width='580px'></td>";
		echo "</tr>";

		$s = $INTRANET->Execute("SELECT kp_formatoRegistroID, kf_itemID FROM SGI_Registros_Formatos WHERE kf_registroID = $registroID ");
		
		while($r = $s->fetchRow()){
			
			$registroFormatoID	= $r[0];
			$formatoID 		    = $r[1];
			$codigoItem		= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemId = $formatoID AND xt_tipo = 'F' ");
			$tituloItem	 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemId = $formatoID AND xt_tipo = 'F'");
		
			echo "<tr id='iconosTexto'>";
				echo "<td></td>";
				echo "<td align='left'>";
					echo "<input type='text' name='eventoRiesgoID".$registroFormatoID."' size='12' value='".$codigoItem."'>";
				echo "</td>";
				echo "<td align='left'>".$tituloItem."</td>";
			echo "</tr>";
			
		} unset($r); unset($s);

		echo "<tr height='30'><td colspan='3'></td></tr>";
	echo "</table>";
		

//FIN DE LA FICHA ULTIMA LINEA Y BOTON
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='30px'><td></td></tr>";
			
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='right'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'></td>";
		echo "</tr>";
		
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	echo "</form>";
echo "</div>";

?>
		</body>
	</html>
<?php
