<?php

$nombrephp='AgregaBoletin.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once("Mailv2.php");


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


$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			 <a href='TableroBoletinesv2.php' id='breadcrumbs'> Tablero de Boletines </a> ";
			

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
$gruposItem[2] = "OT";

//echo "Titulo: ".$_POST['titulo'].", Fecha: ".$_POST['fecha'].", Descripcion: ".$_POST['descripcion'].", Ciudad: ".$_POST['ciudad']."<br><br>";

if((isset($_POST['titulo']) == "") || ($_POST['fecha'] == "") || ($_POST['descripcion'] == "") || ($_POST['ciudad'] == "") || ($_POST['grupo'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Agregar Boletín</title>
                
                <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
					}
				?>
                
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
            </head>
            <body>
    <?php
	
	echo "<div id='wrapper'>";
		echo "<form name='agregaBoletin' method='POST' action='AgregaBoletinv2.php'  enctype='multipart/form-data'>";	
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Boletín";
					echo "</td>";
				echo "</tr>";
			
				echo "<tr>"; 
					echo "<td align='center'>";
						echo $breadcrumb;
					echo "</td>";
				echo "</tr>";
			
				echo "<tr height='70px'><td></td></tr>";
			echo "</table>";
		
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td colspan='3' id='titleBlueLineBottom'></td>";
				echo "</tr>";
	
				echo "<tr height='25px'><td colspan='3'></td></tr>";
				
				echo "<tr height='20px'>";
					echo "<td id='iconosTexto2' align='left' width='130px'>Grupo</td>";
					echo "<td id='iconosTexto2' align='left' width='170px'>Ciudad</td>";
					echo "<td id='iconosTexto2' align='left' width='170px'>Fecha</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='left'>";	
						echo "<select name='grupo'>";
							echo "<option value='' selected=''>Elegir...</option>";
							
							for($a = 1; $a <= count($gruposItem); $a++){
								
								echo "<option value='".$gruposItem[$a]."'>".$gruposItem[$a]."</option>";
								
							} unset($a);
							
						echo "</select>";
					echo "</td>";
					
					echo "<td  align='left'>";
					
					echo "<select name='ciudad'>";
						echo "<option value=''>Elegir...</option>";
						$t = $INTRANETV2->Execute("SELECT xt_sucursal, xt_nombre FROM SGI_Catalogo_Sucursales");
	
								while($p = $t->fetchRow()){
									$ciudades = $p[1];
									$cdValor  = $p[0];	
									
									echo "<option value='".$cdValor."'>".$ciudades."</option>";	
								}
						echo"</select>";
						
					
					echo "</td>";
					
					echo "<td  align='left'>";
						echo "<input type='text' class='DatP' size=15 maxlength=10 name='fecha'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left' colspan='3'>Título</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='left' colspan='3'>";
						echo "<input type='text' size='71' maxlength='100' name='titulo'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo "<td align='left' colspan='3' id='iconosTexto2'>Descripción</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo"<td align='left' colspan='3'>";
						echo "<textarea name='descripcion' style='width: 470px; height: 300px;'></textarea>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3'><input type='file' name='archivo'></td>";
				echo "</tr>";
				
				echo "<tr height='15px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='3' id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='40px'><td colspan='3'></td></tr>";
				
				echo "<tr>";
					echo "<td align='right' colspan='3'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td colspan='3'></td>";
				echo "</tr>";
						
			echo "</table>";
		
		echo "</form>";
	echo "</div>";
	
} else if(($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['descripcion'] != "") && ($_POST['ciudad'] != "") && ($_POST['grupo'] != "")){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 		= $_POST['titulo'];
	$descripcionInsert 	= nl2br($_POST['descripcion']);
	$ciudadInsert		= $_POST['ciudad'];
	$grupoInsert		= $_POST['grupo'];
	
	$maximo = 0;
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Boletines WHERE YEAR(xd_fecha) = '$anio' AND xt_grupo = '$grupoInsert' AND xt_ciudad = '$ciudadInsert' ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-H-DF-14-001
	if($ciudadInsert != ""){
		
		$codigo = $grupoInsert."-H-".$ciudadInsert."-";
		
	} else{
		
		$codigo = $grupoInsert."-H-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(       strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	}
	
		
	if($INTRANETV2->Execute("INSERT INTO SGI_Boletines(xd_fecha, xt_titulo, xt_descripcion, xn_numero, xt_claveBoletin, xt_ciudad, xt_grupo) 
											  VALUES('$fechaInsert', '$tituloInsert', '$descripcionInsert', $maximo, '$codigo', '$ciudadInsert', '$grupoInsert') ")){
												  
		
		$archivo = '';
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			$destino = "../Boletines/$archivo";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANETV2->Execute("UPDATE SGI_Boletines SET xt_ruta = '$archivo' WHERE xt_claveBoletin = '$codigo'") ){
					
					$enviarMail = new MailAgregaBoletin;
					$enviarMail->mailAgregaBoletinIntra($codigo,$tituloInsert, $descripcionInsert,$ciudadInsert, "../Boletines/", $archivo);
				//	new MailAgregaBoletin($codigo,$tituloInsert, $descripcionInsert,$ciudadInsert, "../Boletines/", $archivo);
					
					echo"<script language='javascript'>window.location='fichaBoletinv2.php?id=$codigo'</script>;";
							
				} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Agregar Boletín</title>
                                <?php
								if($estiloUsuario == 1){
									echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
								}else if($estiloUsuario == 2){
									echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
								}
								?>
                                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
                            </head>
                            <body>
                    <?php
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center' name='Encabezado'>";
						
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "<font>Error al cargar el archivo.</font>";
								echo "</td>";
							echo "</tr>";
							
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Agregar Boletín</title>
                            <?php
							if($estiloUsuario == 1){
								echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
							}else if($estiloUsuario == 2){
								echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
							}
							?>
                            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
                        </head>
                        <body>
                <?php
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "<font>Error al cargar el archivo.</font>";
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
				echo "</div>";
			}
			
		}else{
			
			if($INTRANETV2->Execute("UPDATE SGI_Boletines SET xt_ruta = '$archivo' WHERE xt_claveBoletin = '$codigo'") ){
				
				$enviarMail = new MailAgregaBoletin;
				$enviarMail->mailAgregaBoletinIntra($codigo,$tituloInsert, $descripcionInsert,$ciudadInsert, "../Boletines/", $archivo);
				
				//new MailAgregaBoletin($codigo,$tituloInsert, $descripcionInsert,$ciudadInsert, "../Boletines/", $archivo);
				
				header("Location: fichaBoletinv2.php?id=$codigo");
						
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Agregar Boletín</title>
                            <?php
							if($estiloUsuario == 1){
								echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
							}else if($estiloUsuario == 2){
								echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
							}
							?>
                            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
                        </head>
                        <body>
                <?php
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "<font>Error al cargar el archivo.</font>";
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
				echo "</div>";
			}
		}
		
		header("Location: fichaBoletinv2.php?id=$codigo");
	
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Boletín</title>
                    <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
                </head>
                <body>
        <?php
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Boletin No Agregado</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40px'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick=\"location.href='TableroBoletinesv2.php';\" src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
		echo "</div>";
	}
	
}
		
?>
    	</body>
    </html>
<?php
