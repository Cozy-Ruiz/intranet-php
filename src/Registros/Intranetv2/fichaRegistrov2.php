<?php

$nombrephp='fichaRegistro.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

 error_reporting(E_PARSE);
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

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='../Registros.php' id='breadcrumbs'> Registros/</a><a href='tableroRegistrosv2.php' id='breadcrumbs'> Tablero Registro</a> ";
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

$probabValue[0] = "Nula";
$probabValue[1] = "Muy Baja";
$probabValue[2] = "Baja";
$probabValue[3] = "Media";
$probabValue[4] = "Alta";
$probabValue[5] = "Muy Alta";

///DATOS DEL EVENTO
$codigoRegistro	    = "";
$titulo 			= "";
$descripcion 		= "";
$ruta 				= "";
$fechaCreacion      = "";

$s = $INTRANET->Execute("SELECT xt_codigoRegistro, xd_fechaCreacion, xt_tituloRegistro, xt_descripcion, xt_ruta FROM INTRANET2.SGI_Documento_Registro WHERE xt_codigoRegistro = '$registroID' ");

while($r = $s->fetchRow()){
	
	$codigoRegistro	    = $r[0];
	$titulo 			= $r[2];
	$descripcion 		= nl2br($r[3]);
	$ruta 				= $r[4];
	$fechaCreacion      = date('Y-m-d', strtotime($r[1]));
	
	
} unset($r); unset($s);

////INSERCION DE UN CODIGO RIESGO
if($_POST['codigoPREV'] != ""){
	
	$codigoInsert 	= $_POST['codigoPREV'];
	$idFormato 		= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoInsert' AND xt_tipo = 'F'");
	$fechaInsert 	= date("Y-m-d");

	$INTRANET->Execute("INSERT INTO SGI_Registros_Formatos (kf_registroID, kf_itemID, xd_fecha) 
												 VALUES ($registroID, $idFormato, '$fechaInsert') ");
	
	$registroFormato = mysql_insert_id();
	
	header("Location: fichaRegistro.php?id=$registroID");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Registro</title>
            <?php
			if($estiloUsuario == 1){
				echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
				echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
            
            <script>
                function showPREV(valor){
                    if(valor == 1){
                        document.getElementById("prevencionINS").style.display="block";
                        document.getElementById("masControl5").style.display="none";
                        document.getElementById("masControl6").style.display="block";
                    } else if (valor == 2){
                        document.getElementById("prevencionINS").style.display="none";
                        document.getElementById("masControl5").style.display="block";
                        document.getElementById("masControl6").style.display="none";
                    }
                }
            </script> 
            
            <script>
				function showBanana(valor){
					if(valor == 1){
						document.getElementById("banana1").style.display="inline-block";
						document.getElementById("banana0").style.display="none";
						document.getElementById("mapaIntranet").style.display="inline-block";
					} else if (valor == 0){
						document.getElementById("banana1").style.display="none";
						document.getElementById("banana0").style.display="inline-block";
						document.getElementById("mapaIntranet").style.display="none";
					}
				}
			</script>
        </head>
        <body>
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='12px'>";
			echo "<td align='left' id='iconosTexto2'></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Registro";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>"; 
			echo "<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";

				//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		
//CUERPO SOLICITUD
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b> </b></td>";
			echo "<td align='right' id='titulo2' width='100px'><b>".$fechaCreacion."</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
			echo "<td id='iconosTexto' align='right'>";
			
				if($ruta != NULL){
					
					echo "<a href='downloadRegistrov2.php?file=".$ruta."'><img src='../../Imagenes/ICN_Archivo.png'></a>";
					
				}
				
			echo "</td>";
		echo "</tr>"; 
		
		echo "<tr height='10px'><td colspan='4'></td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'></td>";
			echo "<td width='20px'></td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td width='50px'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='4'></td></tr>";
	echo "</table>";
	
///RIESGOS RELACIONADOS
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2' width='680px'><b>Formatos relacionados</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='30px'>";
			echo "<td width='20px'></td>";
			echo "<td width='130px'></td>";
			echo "<td width='550px'></td>";
		echo "</tr>";
			
			
		$s = $INTRANET->Execute("SELECT R.xt_codigoDocumento, (SELECT M.xt_codigoCompleto FROM INTRANET2.SGI_Manuales_Documentos M WHERE M.xt_codigoDocumento = R.xt_codigoDocumento) FROM INTRANET2.SGI_Documento_Registro R WHERE R.xt_codigoRegistro = '$registroID'");
		
		while($r = $s->fetchRow()){
			
			$formatoID		= $r[0];
			$codigoManual   = $r[1];
			$tituloItem	 	= $INTRANET->getOne("SELECT xt_nombre FROM INTRANET2.SGI_Manuales_Documentos WHERE xt_codigoDocumento = '$formatoID' AND xt_tipoDocumento = 'F'");
			
			
			echo "<tr id='iconosTexto'>";
				echo "<td ></td>";
				echo "<td align='left' width='150px'><a id='iconosTexto' href='../../SistemaGestionIntegral/Intranetv2/fichaDocumentov3.php?id=".$formatoID."'>".$codigoManual."</a></td>";
				echo "<td align='left'>".$tituloItem."</td>";
			
			
			echo "</tr>";
		
		} unset($r); unset($s);
	
		echo "<tr height='30'><td colspan='3'></td></tr>";
	echo "</table>";
	
//DESPLIEGUE DEL CODIGO PARA AGREGAR EL FORMATO
	/*echo "<form method='post' action='fichaRegistro.php?id=".$registroID."'>";	
	echo "<table border='0' align='center' width='450px' id='prevencionINS' style='display:none;'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'><input type='hidden' name='id' value='".$registroID."'></td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td></td></tr>";
		
		echo "<tr align='left' height='20px'>";
			echo "<td id='iconosTexto2' align='left' width='450px'>Código</td>";
		echo "</tr>";
		
		echo "<tr align='left'>";
			echo "<td  align='left'>";
				echo "<input type='text' size='20' maxlength='100' name='codigoPREV'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td></td></tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		echo "<tr height='40px'>";
			echo "<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'>";
			echo "<td align='right'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
		*/
//FIN DE LA FICHA ULTIMA LINEA Y BOTON
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='30px'><td></td></tr>";
			
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='right'>";
				echo "<a href='fichaRegistroModificarv2.php?id=".$registroID."'>";
					echo "<input type='image' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>";
				echo "</a>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
echo "</div>";

?>
		</body>
	</html>
<?php
