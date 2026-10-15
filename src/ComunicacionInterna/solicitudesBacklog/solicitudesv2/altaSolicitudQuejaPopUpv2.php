<?php error_reporting(0); ?>
<?php
$nombrephp='altaSolicitudQuejaPopUp.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");
require_once("../../../Consultas/ConsutasGlobales.php");

//require_once("MailIntraNet.php");

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


$breadcrumb="<a href='../../../Home.php' id='breadcrumbs'> Home / </a><a href='../../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes</a>";

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
/*
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
*/

$gruposItem[1] = "GE";
//$gruposItem[2] = "OT";

$indice = 1;
$ciudadesDisponibles = NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Solicitudes y Quejas </title>
                <?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>";
				}
				?>
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

	
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='70'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../../navegacion_banana.php");
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		//CUERPO FICHA ALTA
		$fecha = date("Y-m-d");
	echo "<form name='altaSolicitudQueja' method='POST' action='guardaSolicitudAdministrativa.php' enctype='multipart/form-data'>";
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='3'></td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Fecha</td>";
				
				echo "<td id='iconosTexto2'>";
				
					if($categoriaUsr == "Administrador"){
						echo "Grupo";
					}
				
				echo "</td>";
				
				echo "<td id='iconosTexto2'>";
				
					if($categoriaUsr == "Administrador"){
						echo "Ciudad";
					}
				
				echo "</td>";
				
			echo "</tr>";
			
			echo "<tr>";
				echo "<td width='150px'>";
					echo "<input type='text' name='fecha' size='10'  value='$fecha' readonly>";
					
					echo "<input type='hidden'  name='tipo' value= 'solicitud'>";
					echo "<input type='hidden'  name='usuario' value= '$usuarioId'>";
				echo "</td>";
				
				echo "<td width='140px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<input type='text' name='grupo' style='width:25%;height:23px;' value='GE' readonly>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='grupo' value='GE'>";
						
					}
				echo "</td>";
				
				echo "<td width='160px'>";
				
				opcionesCiudadesAlta();
				
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='66' required></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:438px; height:100px;' required></textarea></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
			echo "</tr>";				
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<input type='file' name='archivo'>";
				echo "</td>";
			echo "</tr>";	
			echo"<tr height='15px'><td colspan='3'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='3'></td></tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";

?>
    	</body>
    </html>
<?php
