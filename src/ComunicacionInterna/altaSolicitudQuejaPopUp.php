<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp='altaSolicitudQuejaPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("MailIntraNet.php");

//ini_set("upload_max_filesize","300M");

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

$tipo = "";

if($_POST["tipo"] != ""){
	
	$tipo = $_POST["tipo"];
	
}else if($_GET["tipo"] != ""){
	
	$tipo = $_GET["tipo"];
	
}

$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a>";

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

if($tipo == ""){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Solicitudes y Quejas </title>
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
	echo "<div id='wrapper'>";
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Solicitudes y Quejas";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo"<tr height='40px'><td></td></tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<input type='image' onclick=\"location.href='altaSolicitudQuejaPopUp.php?tipo=solicitud';\" src='../Imagenes/ICN_BotonSolicitud.png' width='120' height='39'>";
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='40px'><td></td></tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<input type='image' onclick=\"location.href='altaSolicitudQuejaPopUp.php?tipo=queja';\" src='../Imagenes/ICN_BotonQueja.png' width='120' height='39'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='30'><td></td></tr>";
		echo "</table>";
	echo "</div>";
	
	
}

//SOLICITUD
if(($tipo == "solicitud") && (($_POST['fecha'] == "") || ($_POST['titulo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == ""))){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Solicitudes y Quejas </title>
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

	echo "<div id='wrapper'>";
	  	echo "<form name='altaSolicitudQueja' method='POST' action='altaSolicitudQuejaPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Agregar Solicitud";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>"; 
				echo "<td align='center'>";
					echo $breadcrumb;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='70px'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
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
					echo "<input type='text' class='DatP' name='fecha' size='10'>";
					echo "<input type='hidden'  name='tipo' value= 'solicitud'>";
				echo "</td>";
				
				echo "<td width='140px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='grupo'>";
							echo "<option value='' selected='selected'>Elegir...</option>";
							
							for($a = 1; $a <= count($gruposItem); $a++){
								
								echo "<option value='".$gruposItem[$a]."'>".$gruposItem[$a]."</option>";
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='grupo' value='GE'>";
						
					}
				echo "</td>";
				
				echo "<td width='160px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='ciudad'>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='ciudad' value='".$ciudadesDisponibles[1]."'>";
						
					}
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='66'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:438px; height:100px;'></textarea></td>";
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
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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

} else if(($tipo == "solicitud") && ($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['grupo'] != "") && ($_POST['ciudad'] != "")){
	
	$fechaInsert 	= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 	= $_POST['titulo'];
	$ciudad 		= $_POST['ciudad'];
	$grupoInsert	= $_POST['grupo'];
	
	$descripcionInsert = " ";
	
	if($_POST['descripcion'] != ""){
		
		$descripcionInsert = $_POST['descripcion'];
	}
	
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-B-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-B-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-B-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes(xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo) 
						  							   VALUES('B', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuarioId', '$grupoInsert') ")){
		
		$solicitudID = $INTRANET->getOne("SELECT kp_quejaSolicitudID FROM SGI_Quejas_Solicitudes WHERE xt_tipo = 'B' AND xt_ciudad = '$ciudad' 
										  AND xn_numero = '$maximo' AND xt_claveQuejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
										  
		$solicitudNumero = $INTRANET->getOne("SELECT xn_numero FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $solicitudID ");
		new MailIntraNet($usuarioId, $ciudad, $tituloInsert, $descripcionInsert, $solicitudNumero, $tipo);
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "SugerenciaQueja/".$archivo;
			
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_ruta = '$archivo' WHERE xt_claveQuejaSolicitud = '$codigo' ") ){
					
					header("Location: fichaSolicitud.php?id=$solicitudID");
					
				} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Solicitudes y Quejas </title>
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
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center'>";
							echo"<tr>"; 
								echo"<td align='center'>";
									echo $breadcrumb;
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='70'><td></td></tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
					
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Solicitudes y Quejas </title>
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
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center'>";
						echo"<tr>"; 
							echo"<td align='center'>";
								echo $breadcrumb;
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='70'><td></td></tr>";
						
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "Error en la carga";
							echo"</td>";
						echo"</tr>";
					echo "</table>";
				echo "</div>";
			}
			
		} else{
			
			header("Location: fichaSolicitud.php?id=$solicitudID");
			
		}
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Solicitudes y Quejas </title>
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
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Solicitud No Agregada";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450px'></td>";
				echo "</tr>";
		
				echo"<tr height='15px'><td ></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='center'>";
						echo "No se pudo agregar la solicitud.";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='10px'><td ></td></tr>";
				
				echo"<tr height='40px'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroSolicitudesyQuejas.php';\">";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td ></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";
	}
}

//QUEJA
if(($tipo == "queja") && (($_POST['fecha'] == "") || ($_POST['titulo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == ""))){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Solicitudes y Quejas </title>
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

	echo "<div id='wrapper'>";
		echo "<form name='altaSolicitudQueja' method='POST' action='altaSolicitudQuejaPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Queja";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70px'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='3'></td>";
			echo "</tr>";
	
			echo"<tr height='15px'><td colspan='3'></td></tr>";
			
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
					echo "<input type='text' class='DatP' name='fecha' size='10'>";
					echo "<input type='hidden'  name='tipo' value= 'queja'>";
				echo "</td>";
				
				echo "<td width='140px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='grupo'>";
							echo "<option value='' selected='selected'>Elegir...</option>";
							
							for($a = 1; $a <= count($gruposItem); $a++){
								
								echo "<option value='".$gruposItem[$a]."'>".$gruposItem[$a]."</option>";
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='grupo' value='GE'>";
						
					}
				echo "</td>";
				
				echo "<td width='160px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='ciudad'>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='ciudad' value='".$ciudadesDisponibles[1]."'>";
						
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='60'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:400px; height:100px;'></textarea></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
			echo "</tr>";
				
			echo "<tr>";
				echo "<td colspan='3'><input type='file' name='archivo'></td>";
			echo "</tr>";
				
			echo"<tr height='15px'><td colspan='3'></td></tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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

} else if(($tipo == "queja") && ($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['grupo'] != "") && ($_POST['ciudad'] != "")){
	
	$fechaInsert 	= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 	= $_POST['titulo'];
	$ciudad 		= $_POST['ciudad'];
	$grupoInsert	= $_POST['grupo'];
	
	$descripcionInsert = " ";
	
	if($_POST['descripcion'] != ""){
		
		$descripcionInsert = $_POST['descripcion'];
		
	}
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'Q' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-Q-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-Q-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-Q-";
		
	}
	
	$anio = date('y',strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes(xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo) 
						  VALUES('C', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuarioId', '$grupoInsert') ")){
		
		$quejaID = $INTRANET->getOne("SELECT kp_quejaSolicitudID FROM SGI_Quejas_Solicitudes WHERE xt_tipo = 'C' AND xt_ciudad = '$ciudad' 
									  AND xn_numero = '$maximo' AND xt_claveQuejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "SugerenciaQueja/".$archivo;
			
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_ruta = '$archivo' WHERE xt_claveQuejaSolicitud = '$codigo' ") ){
					
					header("Location: fichaQueja.php?id=$quejaID");
							
				} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Solicitudes y Quejas </title>
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
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center'>";
							echo"<tr>"; 
								echo"<td align='center'>";
									echo $breadcrumb;
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='70px'><td></td></tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Solicitudes y Quejas </title>
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
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center'>";
						echo"<tr>"; 
							echo"<td align='center'>";
								echo $breadcrumb;
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='70px'><td></td></tr>";
						
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "Error en la carga";
							echo"</td>";
						echo"</tr>";
					echo "</table>";
				echo "</div>";
			}
			
		} else{
			
			header("Location: fichaQueja.php?id=$quejaID");
		}
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Solicitudes y Quejas </title>
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
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Queja No Agregada";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
					
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450px'></td>";
				echo "</tr>";
		
				echo"<tr height='15px'><td></td></tr>";
				
				echo "<tr height='20px'>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo"<tr>";
					echo "<td  align='center'>";
						echo "No se pudo agregar la queja.";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='10px'><td></td></tr>";
				
				echo"<tr height='40px'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroSolicitudesyQuejas.php';\">";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";
	}
}

?>
    	</body>
    </html>
<?php
